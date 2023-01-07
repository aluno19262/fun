<?php

namespace App\Providers;

use App\Helpers\Eupago;
use App\Helpers\HelperMethods;
use App\Helpers\Moloni;
use App\Helpers\Setting;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Core\Adapters\Theme;

class AppServiceProvider extends ServiceProvider
{
    protected $rules = [
        \App\Rules\PtNif::class,
        \App\Rules\PtCc::class
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }*/

        $this->app->bind('setting',function(){
            return new Setting();
        });
        $this->app->bind('helperMethods',function(){
            return new HelperMethods();
        });
        $this->app->bind('eupago',function(){
            return new Eupago();
        });
        $this->app->bind('moloni',function(){
            return new Moloni();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //this is used by metronic to define the demo used
        $theme = theme();

        // Share theme adapter class
        View::share('theme', $theme);

        // Set demo globally
        //$theme->setDemo(request()->input('demo', 'demo1'));
         $theme->setDemo('demo1');

        $theme->initConfig();

        bootstrap()->run();

        if (isRTL()) {
            // RTL html attributes
            Theme::addHtmlAttribute('html', 'dir', 'rtl');
            Theme::addHtmlAttribute('html', 'direction', 'rtl');
            Theme::addHtmlAttribute('html', 'style', 'direction:rtl;');
        }

        //override the infyom model generator to add extra informations
        $loader = AliasLoader::getInstance();
        $loader->alias('InfyOm\Generator\Generators\ModelGenerator','App\Overrides\infyomlabs\ModelGenerator');
    }

    private function registerValidationRules()
    {
        foreach($this->rules as $class ) {
            $alias = (new $class)->__toString();
            if ($alias) {
                Validator::extend($alias, $class .'@passes');
            }
        }
    }
}
