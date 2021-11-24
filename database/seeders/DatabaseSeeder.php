<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        \App\Models\User::factory(10)->create();
       // $this->call([
            //UsersTableSeeder::class, 
       //  StoreTableSeeder::class
        //]);
        //$this->call(StoreTableSeeder::class);
    }
}
