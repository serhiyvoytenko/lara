<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'object',
        'status',
        ];

    public function file(){
        return $this->morphOne(File::class, 'modelled');
    }
}
