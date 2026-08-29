<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'request_option_id',
        'description',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function requestOption()
    {
        return $this->belongsTo(RequestOption::class);
    }
}
