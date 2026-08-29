<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TshirtAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'tshirt_id',
        'employee_id',
        'assigned_date',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function tshirt()
    {
        return $this->belongsTo(Tshirt::class);
    }
}
