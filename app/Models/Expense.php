<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Adapter\Phpunit\MockeryTestCaseSetUp;

class Expense extends Model
{
    use HasFactory, SoftDeletes, MockeryTestCaseSetUp;

    protected $fillable = 
    [
        'user_id',
        'amount',
        'expense_date',
        'description',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }
}
