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
 
     /**
     * @OA\Get(
     *     path="/api/expenses",
     *     summary="Get list of expenses",
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="expense_date", type="date", example="Y-m-d"),
     *                 @OA\Property(property="amount", type="number", format="float", example=150.00),
     *                 @OA\Property(property="description", type="string", example="Coffee Break")
     *             )
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function index(): ResourceCollection
    {
        $expense = $this->repository->paginate();
        return ExpenseResources::collection($expense);
    }

    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     summary="Create a new expense",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description", "amount", "user_id", "expense_date"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="expense_date", type="date", example="Y-m-d"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="description", type="string", example="Coffee Break")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Expense created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="expense_date", type="date", example="Y-m-d"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="description", type="string", example="Coffee Break")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */

    public function store(ExpenseRequest $request): JsonResource
    {
        $expense = $this->repository->create($request->all());
        return new ExpenseResources($expense);
    }

       /**
     * @OA\Get(
     *     path="/api/expenses/{id}",
     *     summary="Get a specific expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="expense_date", type="date", example="Y-m-d"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="description", type="string", example="Coffee Break")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Expense not found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    
    public function show(string $id): JsonResource
    {
        $expense = $this->repository->findOrFail($id);
        return new ExpenseResources($expense);
    }

  /**
     * @OA\Patch(
     *     path="/api/expenses/{id}",
     *     summary="Update an existing expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="expense_date", type="date", example="Y-m-d"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="description", type="string", example="Coffee Break")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Expense updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="expense_date", type="date", example="Y-m-d"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="description", type="string", example="Coffee Break")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Expense not found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */

    public function update(ExpenseRequest $request, Expense $expense): JsonResource
    {
        $expense->update($request->validated());
        return new ExpenseResources($expense);
    }

    /**
     * @OA\Delete(
     *     path="/api/expenses/{id}",
     *     summary="Delete an existing expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Expense deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Expense not found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
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
