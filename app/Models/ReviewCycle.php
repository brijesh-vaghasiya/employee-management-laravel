<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewCycle extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function appraisals()
    {
        return $this->hasMany(Appraisal::class);
    }
}
