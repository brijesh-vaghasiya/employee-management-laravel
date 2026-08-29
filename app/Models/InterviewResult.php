<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'interview_question_id',
        'score',
        'remarks',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function question()
    {
        return $this->belongsTo(InterviewQuestion::class, 'interview_question_id');
    }
}
