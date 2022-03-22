<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Carbon\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
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
        $stores = Store::all();

        foreach($stores as $store)
        {
        	$store->products()->save(factory(Product::class)->make());
        }
    }
}
