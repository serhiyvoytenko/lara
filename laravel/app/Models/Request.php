<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'from',
        'object',
        'contract',
        'date',
    ];

    public function file(){
        return $this->morphOne(File::class, 'modelled');
    }
}
