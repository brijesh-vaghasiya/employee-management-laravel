<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'format_type',
        'file_path',
    ];

    public function employeeDocuments()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
}
