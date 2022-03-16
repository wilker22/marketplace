<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //$categories = Category::all('name', 'slug');
        
        //view()->share('categories', $categories);
        
        //view()->composer('*', function($view) use($categories){
         //   $view->with('categories', $categories);
        //});

        view()->composer('layouts.front', 'App\Http\Views\CategoryViewComposer@compose');
    }
}
