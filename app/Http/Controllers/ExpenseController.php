<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResources;
use App\Models\Expense;
use App\Policies\ExpensePolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseController extends Controller
{
    public function __construct(protected Expense $repository)
    {}    
    
    public function index(): ResourceCollection
    {
        $expense = $this->repository->paginate();
        return ExpenseResources::collection($expense);
    }

    public function store(ExpenseRequest $request): JsonResource
    {
        $expense = $this->repository->create($request->all());
        return new ExpenseResources($expense);
    }

    public function show(string $id): JsonResource
    {
        $expense = $this->repository->findOrFail($id);
        return new ExpenseResources($expense);
    }

    public function update(ExpenseRequest $request, Expense $expense): JsonResource
    {
        $expense->update($request->validated());
        return new ExpenseResources($expense);
    }

    public function destroy(Expense $expense): JsonResponse
    {
        if(!app(ExpensePolicy::class)->delete($this->user()))
        {
            return response()->json(["message"=> "Você não tem permissão para deletar."],0);
        }

        $expense->delete();
        
        return response()->json('Deletado com sucesso', 204);
    }
}
