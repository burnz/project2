<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Validator;
use App\ExchangeRate;
use View;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('isTypeCategory', function($attribute, $value, $parameters, $validator) {
            if( $value == 1 || $value == 2 || $value == 3 || $value ==4 ){
                return true;
            }
                return false;
        });

        view()->composer('*', function ($view){
            if(Auth::user())
            {
                $amountBTC=Auth::user()->userCoin->btcCoinAmount;
                $amountCLP=Auth::user()->userCoin->clpCoinAmount;
                $amountReinvest=Auth::user()->userCoin->reinvestAmount;

                $btcUSDRate = ExchangeRate::getBTCUSDRate();

                $view->with('walletAmount',['amountBTC'=>$amountBTC,'amountCLP'=>$amountCLP,'amountReinvest'=>$amountReinvest);
                $view->with('btcUSDRate', $btcUSDRate);
            }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
