<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResources extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "description"=> $this->description,
            "amount"=> $this->amount,
            "expense_date"=> $this->expense_date,
            "user_id" => $this->user_id,
            "user_id" => [
                "id"=> $this->user->id,
                "name"=> $this->user->name,
                "email"=> $this->user->email
            ]
        ];
    }
}
