<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'number',
        'number_project',
        'sum',
        'contract',
        'object',
    ];
}
