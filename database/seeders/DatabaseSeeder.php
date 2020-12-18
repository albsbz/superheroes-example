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
            UsersTableSeeder::class,
            SuperpowerSeeder::class,
            SuperheroSeeder::class,

        ]);
    }
}
