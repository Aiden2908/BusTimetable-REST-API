<?php

use Illuminate\Database\Seeder;

class BusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //:: crate dummy data 30 times:://
        factory(App\Bus::class, 30)->create();
    }
}
