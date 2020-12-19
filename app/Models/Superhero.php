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
        'catch_phrase',
        'origin_description'
    ];
    public function superpowers()
    {
        return $this->belongsToMany(Superpower::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class);
    }
    public function scopeWithSuperpower($query, $superpower)
    {
        return $query->whereHas('superpowers', function ($q) use ($superpower) {
            return $q->where('id', $superpower);
        });
    }
    // public function scopePopular($query)
    // {
    //     return $query->where('votes', '>', 100);
    // }
}
