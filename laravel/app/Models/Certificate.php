<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'expired',
        'name',
    ];

    public function file(){
        return $this->morphOne(File::class, 'modelled');
    }
}
