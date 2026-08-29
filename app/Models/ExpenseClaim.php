<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseClaim extends Model
{
    protected $guarded = [];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
