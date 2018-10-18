<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\AuthPermissionCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\UpdateBtcCoin;
use App\Notifications\AvailableAmountController as AvailableAmount;
use App\Cronjob\UpdateExchangeRate;
use App\Cronjob\TransferCarPresale;
use App\Cronjob\Bonus;
use App\Cronjob\AutoAddBinary;
use App\Cronjob\UpdateStatusBTCWithdraw;
use App\Cronjob\UpdateStatusCLPWithdraw;
use App\Cronjob\UpdateCLPCoin;
use App\Cronjob\ReturnCarForLandUser;
use App\RandCronjobInterest;
use App\RandCronjobBinary;
use App\RandCronjobBinaryInterest;
use Carbon\Carbon;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AuthPermissionCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Auto add to binary at 23:30 every sunday
        // try {
        //     $schedule->call(function () {
        //         AutoAddBinary::addBinary();
        //     })->weekly()->saturdays()->at('07:00'); //->weekly()->sundays()->at('23:30');
        // } catch (\Exception $ex) {
        //     Log::info($ex);
        // }

        // // Binary bonus run on monday each week
        // try {
        //     $schedule->call(function () {
        //         Bonus::bonusBinaryWeekCron();
        //     })->weekly()->sundays()->at('00:15');
        // } catch (\Exception $ex) {
        //     Log::info($ex);
        // }
	

        // // Binary bonus infinity interest
	
        // try {
        //     $schedule->call(function () {
        //         Bonus::bonusRevenueCron();
        //     })->weekly()->sundays()->at('00:30');
        // } catch (\Exception $ex) {
        //     Log::info($ex);
        // }
	

        // // Binary bonus leadership monthly
        // try {
        //     $schedule->call(function () {
        //         Bonus::bonusAwardCron();
        //     })->weekly()->sundays()->at('00:45');
        // } catch (\Exception $ex) {
        //     Log::info($ex);
        // }

        /**
         * @author Huynq 
         * run every 30s update notification
         */
        // try {
        //     $schedule->call(function () {
        //         //UpdateBtcCoin::UpdateBtcCoinAmount();
        //     })->everyMinute();
        // } catch (\Exception $ex) {
        //     Log::info($ex);
        // }

        // Cronjob update exchange BTC, CLP rate
        try {
            $schedule->call(function (){
                UpdateExchangeRate::updateExchangRate();
            })->everyMinute();
        } catch (\Exception $ex) {
            
        }

        // Cron job update status withdraw BTC
        // try {
        //     $schedule->call(function () {
        //         //UpdateStatusBTCWithdraw::updateStatusWithdraw();
        //     })->everyFiveMinutes();
        // } catch (\Exception $ex) {
        //     Log::info($ex);
        // }

        // Cron job update status withdraw CLP
        try {
            $schedule->call(function () {
                UpdateStatusCLPWithdraw::updateStatusWithdraw();
            })->everyFiveMinutes();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

	   // Cron job update get CLP
        try {
            $schedule->call(function (){
                UpdateCLPCoin::UpdateClpCoinAmount();
            })->everyMinute();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
