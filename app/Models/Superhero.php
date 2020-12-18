<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    use HasFactory;
    protected $fillable = [
        'nickname',
        'real_name',
        'catch_phrase'
    ];
    public function superpowers()
    {
        return $this->belongsToMany(Superpower::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class);
    }
}
