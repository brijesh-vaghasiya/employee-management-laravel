<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'education',
        'experience',
        'previous_company',
        'position',
        'skills',
        'ctc',
        'expected_ctc',
        'cv_path',
        'interview_date',
        'interviewer',
        'department',
        'status',
        'notes',
        'bg_approval',
        'edu_approval',
        'salary_approval'
    ];

    protected $casts = [
        'interview_date' => 'date',
        'bg_approval' => 'boolean',
        'edu_approval' => 'boolean',
        'salary_approval' => 'boolean',
        'ctc' => 'decimal:2',
        'expected_ctc' => 'decimal:2',
    ];

    public function results()
    {
        return $this->hasMany(InterviewResult::class);
    }
}
