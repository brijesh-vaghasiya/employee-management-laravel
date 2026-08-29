<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'vehicle_number',
        'card_number',
        'assigned_date',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
