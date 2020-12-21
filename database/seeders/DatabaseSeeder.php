<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SuperheroSeeder;
use Database\Seeders\SuperpowerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SuperpowerSeeder::class,
            SuperheroSeeder::class,

        ]);
    }
}
