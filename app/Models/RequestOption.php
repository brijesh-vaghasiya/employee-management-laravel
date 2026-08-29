<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function employeeRequests()
    {
        return $this->hasMany(EmployeeRequest::class);
    }
}
