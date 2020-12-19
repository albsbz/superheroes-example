<?php

namespace Database\Seeders;

use App\Models\Superhero;
use App\Models\Superpower;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperheroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superpowers = Superpower::all();

        Superhero::factory(50)->hasImages(2)->create()->each(function ($superhero) use ($superpowers) {
            $superhero->superpowers()->attach($superpowers->random(rand(1, 3))->pluck('id')->toArray());
            // Image::factory(1)->eac
        });
    }
}
