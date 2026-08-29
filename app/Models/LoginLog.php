<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'role',
        'project',
        'result',
        'ip_address',
        'login_date',
    ];

    protected $casts = [
        'login_date' => 'datetime',
    ];
}
