<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\User;
use App\BookLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $penalty = 0;
        Validator::extend('checkPenalty', function ($attribute, $value, $parameters, $validator) {
            $result = true;

            //check penalty
            $penalty = BookLog::where('userId',$value)->where('paid',0)->sum('fine');

            if($penalty > 0)
            {
                $result = false;
            }

            return $result;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
