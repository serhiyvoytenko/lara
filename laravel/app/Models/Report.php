<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'date',
        'object',
        'contract',
    ];

    public function file(){
        return $this->morphOne(File::class, 'modelled');
    }
}
