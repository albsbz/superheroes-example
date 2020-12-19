<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperpowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Superpower = DB::table('superpowers');

        $Superpower->insert([
            'name' => 'Fly'
        ]);
        $Superpower->insert([
            'name' => 'Fireball'
        ]);
        $Superpower->insert([
            'name' => 'See through walls'
        ]);
        $Superpower->insert([
            'name' => 'Mega strength'
        ]);
        $Superpower->insert([
            'name' => 'Cool suit'
        ]);
        $Superpower->insert([
            'name' => 'Swim like fish'
        ]);
    }
}
