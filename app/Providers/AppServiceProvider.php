<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Validator;
use App\ExchangeRate;
use View;
use Auth;
use DB;
use Carbon\Carbon;

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

        //Get CLP news
        $clpNews = DB::table('news')
            ->where('category_id', 3)
            ->where('created_at', '>', Carbon::now()->subDay(3))
            ->select('id')
            ->get();

        $aCLPNews = [];
        foreach($clpNews as $news) {
            $aCLPNews[] = $news->id;
        }

        //$aCLPNews = json_encode($aCLPNews);

        View::share('carNews', $aCLPNews);

        view()->composer('*', function ($view){
            if(Auth::user())
            {
                $amountBTC=Auth::user()->userCoin->btcCoinAmount;
                $amountCLP=Auth::user()->userCoin->clpCoinAmount;
                $amountHoldingCAR=Auth::user()->userCoin->usdAmount;
                $amountReinvest=Auth::user()->userCoin->reinvestAmount;

                $btcUSDRate = ExchangeRate::getBTCUSDRate();

                $view->with('walletAmount',['amountBTC'=>$amountBTC,'amountCLP'=>$amountCLP,'amountReinvest'=>$amountReinvest, 'amountHoldingCAR'=>$amountHoldingCAR,]);
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
