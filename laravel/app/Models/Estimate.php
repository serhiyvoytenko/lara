<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable= [
      'number',
      'sum',
      'object',
      'contract',
      'balance',
    ];

    public function file(){
        return $this->morphOne(File::class, 'modelled');
    }
}
