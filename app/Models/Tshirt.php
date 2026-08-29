<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    use HasFactory;

    protected $fillable = [
        'design_name',
        'stock',
        'size',
    ];

    public function assignments()
    {
        return $this->hasMany(TshirtAssign::class);
    }
}
