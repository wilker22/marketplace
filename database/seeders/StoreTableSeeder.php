<?php

namespace Database\Seeders;

use App\Models\Store;
use Carbon\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = \App\Store::all();

        foreach($stores as $store)
        {
        	$store->products()->save(Factory(\App\Product::class)->make());
        }
}
