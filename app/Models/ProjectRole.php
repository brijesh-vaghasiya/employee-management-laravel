<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'role_name',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
