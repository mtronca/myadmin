<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \View::composer('layouts/website', function($view){
            $data = array();
            $data['basic_info'] = \App\BasicInfo::find(1);
            $view->with('data', $data);
        });
        \View::composer('layouts/app', function($view){
            $data = array();
            $data['modulos'] = \App\Gerador::get();
            $view->with('data', $data);
        });


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
