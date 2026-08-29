<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function questions()
    {
        return $this->hasMany(InterviewQuestion::class, 'interview_category_id');
    }
}
