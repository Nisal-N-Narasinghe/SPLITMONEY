<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'destination',
        'days',
        'travelers',
        'budget_mode',
        'total_budget',
        'category_budgets',
        'daily_plan',
        'summary',
        'tips',
    ];

    protected $casts = [
        'category_budgets' => 'array',
        'daily_plan' => 'array',
        'tips' => 'array',
        'total_budget' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
