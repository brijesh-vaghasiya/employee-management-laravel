<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_category_id',
        'question',
    ];

    public function category()
    {
        return $this->belongsTo(InterviewCategory::class, 'interview_category_id');
    }
}
