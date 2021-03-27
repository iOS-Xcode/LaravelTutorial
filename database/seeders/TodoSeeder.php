<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
 //       \App\Todo::factory(30)->create();
               factory(\App\Todo::class, 30)->create();

    }
}
