<?php

namespace Tests\Unit;

use App\Http\Controllers\ExpenseController;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResources;
use App\Models\Expense;
use App\Policies\ExpensePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Mockery;
use PHPUnit\Framework\TestCase;

class ExpenseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $expenseController;
    protected $expenseMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->expenseMock = new Mockery(Expense::class);
        $this->expenseController = new ExpenseController($this->expenseMock);
    }

    public function Should_testIndex()
    {
        $this->expenseMock
            ->shouldReceive('paginate')
            ->once()
            ->andReturn(collect([new Expense()]));

        $response = $this->expenseController->index();

        $this->assertInstanceOf(ResourceCollection::class, $response);
    }

    public function Should_testStore()
    {
        $request = ExpenseRequest::create('/expenses', 'POST', [
            'description' => 'New Expense',
            'amount' => 100,
        ]);

        $this->expenseMock
            ->shouldReceive('create')
            ->once()
            ->with($request->all())
            ->andReturn(new Expense($request->all()));

        $response = $this->expenseController->store($request);

        $this->assertInstanceOf(ExpenseResources::class, $response);
    }

    public function Should_testShow()
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

    public function Should_testUpdate()
    {
        $expense = new Expense(['id' => 1]);

        $request = ExpenseRequest::create('/expenses/1', 'PATCH', [
            'description' => 'Atualizando Expense',
            'amount' => 150.89,
            ''
        ]);

        $this->expenseMock
            ->shouldReceive('update')
            ->once()
            ->with($request->validated())
            ->andReturn(true);

        $response = $this->expenseController->update($request, $expense);

        $this->assertInstanceOf(ExpenseResources::class, $response);
    }

    public function Should_testDestroy()
    {
        $expense = Mockery::mock(Expense::class)->makePartial();

        $policyMock = Mockery::mock(ExpensePolicy::class);
        $policyMock->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $this->app->instance(ExpensePolicy::class, $policyMock);

        $expense->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $response = $this->expenseController->destroy($expense);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
