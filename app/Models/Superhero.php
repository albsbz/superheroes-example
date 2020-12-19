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
    public function scopeWithSuperpowers($query, $superpowers)
    {
        if (isset($superpowers)) {
            return $query->where(function ($q) use ($superpowers) {
                function check($q, $superpowers, $i)
                {
                    if ($i < count($superpowers)) {
                        $superpower = $superpowers[$i];
                        $q = $q->whereHas(
                            'superpowers',
                            function ($q) use ($superpower) {
                                return $q->where('id', $superpower);
                            }
                        );
                        $q = check($q, $superpowers, ++$i);
                    }
                    return $q;
                }
                return check($q, $superpowers, 0);
            });
        }
        return $query;
    }
}
