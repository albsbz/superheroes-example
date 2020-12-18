<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superpower extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'nickname',
    //     'real_name',
    //     'catch_phrase'
    // ];
    public function superheroes()
    {
        return $this->belongsToMany(Superpower::class);
    }
}
