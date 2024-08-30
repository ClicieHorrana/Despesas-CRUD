<?php

namespace Tests\Unit;

use App\Http\Controllers\ExpenseController;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResources;
use App\Models\Expense;
use App\Models\User;
use App\Notifications\ExpenseCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;

class ExpenseControllerTest extends TestCase
{
    use WithFaker;

    protected $expenseController;
    protected $expenseMock;
    protected $userMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->expenseMock = Mockery::mock(Expense::class)->makePartial();
        $this->userMock = Mockery::mock(User::class)->makePartial();
        $this->userMock->role = 'admin';

        $this->expenseController = new ExpenseController($this->expenseMock);
    }

    public function testIndex()
    {
        $this->expenseMock
            ->shouldReceive('paginate')
            ->once()
            ->andReturn(collect([new Expense()]));

        $response = $this->expenseController->index();

        $this->assertInstanceOf(ResourceCollection::class, $response);
    }
    
    public function testUpdate()
    {
        // Cria um usuário admin e autentica
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        // Cria uma despesa existente
        $expense = Expense::factory()->create([
            'description' => 'Old Description',
            'amount' => 50,
            'user_id' => $user->id,
            'expense_date' => now(),
        ]);

        // Dados atualizados
        $data = [
            'description' => 'Updated Description',
            'amount' => 150,
            'expense_date' => now()->format('Y-m-d'),
        ];

        // Simula o request de atualização
        $request = new ExpenseRequest($data);

        // Simula o método update no controller
        $response = $this->expenseController->update($request, $expense);

        // Assertivas para verificar a resposta
        $this->assertEquals(200, $response->status());

        $updatedExpense = $expense->fresh();
        $this->assertEquals('Updated Description', $updatedExpense->description);
        $this->assertEquals(150, $updatedExpense->amount);
    }
    public function testStore()
    {
        $request = ExpenseRequest::create('/expenses', 'POST', [
            'description' => 'New Expense',
            'amount' => 100,
            'expense_date' => now()->format('Y-m-d'),
            'user_id' => 2
        ]);

        $this->expenseMock
            ->shouldReceive('create')
            ->once()
            ->with($request->all())
            ->andReturn(new Expense($request->all()));

        $response = $this->expenseController->store($request);

        $this->assertInstanceOf(ExpenseResources::class, $response);
    }

    public function testShow()
    {
        $expense = new Expense(['id' => 1]);

        $this->expenseMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($expense);

        $response = $this->expenseController->show(1);

        $this->assertInstanceOf(ExpenseResources::class, $response);
    }

    public function testExpenseCreationSendsNotification()
    { 
        Notification::fake();

        // Cria um usuário e com permissão admin
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        // Cria uma nova despesa e dispara a notificação
        $expense = Expense::factory()->create([
            'description' => 'Test Expense',
            'amount' => 100,
            'user_id' => $user->id,
            'expense_date' => now(),
        ]);

        Notification::assertSentTo(
            [$user], 
            ExpenseCreatedNotification::class, 
            function ($notification, $channels) use ($expense) {
                return $notification;
            }
        );
    }
    
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
