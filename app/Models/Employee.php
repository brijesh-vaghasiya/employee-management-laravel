<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'designation',
        'department',
        'salary',
        'joining_date',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employeeDocuments()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
}
