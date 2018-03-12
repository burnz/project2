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
use App\Cronjob;
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
        try {
            $schedule->call(function () {
                AutoAddBinary::addBinary();
            })->weekly()->sundays()->at('23:30'); //->weekly()->sundays()->at('23:30');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
        
        //Profit run everyday
        try {
            $schedule->call(function () {
                Bonus::bonusDayCron();
            })->hourly()->when(function () {
                $data = Cronjob::first();

                if($data->hour_run == Carbon::now()->hour && $data->next_date == Carbon::now()->toDateString()) {
                    $nextHour = rand(1,12);
                    $data->update(['hour_run' => $nextHour, 'next_date' => Carbon::tomorrow()->toDateString()]);
                    return true;
                } else {
                    return false;   
                }
            });
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        // Binary bonus run on monday each week
        try {
            $schedule->call(function () {
                Bonus::bonusBinaryWeekCron();
            })->weekly()->mondays()->hourly()->when(function () {
                $data = RandCronjobBinary::first();

                if($data->hour_run == Carbon::now()->hour && $data->next_week == Carbon::now()->weekOfYear) {
                    $nextHour = rand(1,12);
                    $data->update(['hour_run' => $nextHour, 'next_week' => Carbon::now()->addDays(7)->weekOfYear]);
                    return true;
                } else {
                    return false;   
                }
            }); //->weekly()->mondays()->at('00:30');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
	

        // Binary bonus infinity interest
	
        try {
            $schedule->call(function () {
                Bonus::bonusMatchingWeekCron();
            })->weekly()->mondays()->hourly()->when(function () {
                $data = RandCronjobBinaryInterest::first();

                if($data->hour_run == Carbon::now()->hour && $data->next_week == Carbon::now()->weekOfYear) {
                    $nextHour = rand(1,12);
                    $data->update(['hour_run' => $nextHour, 'next_week' => Carbon::now()->addDays(7)->weekOfYear]);
                    return true;
                } else {
                    return false;   
                }
            }); //->weekly()->mondays()->at('01:00');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
	

        // Binary bonus leadership monthly
        try {
            $schedule->call(function () {
                Bonus::bonusLeadershipMonthCron();
            })->monthlyOn(1, '2:00');
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        /**
         * @author Huynq 
         * run every 30s update notification
         */
        try {
            $schedule->call(function () {
                UpdateBtcCoin::UpdateBtcCoinAmount();
            })->everyMinute();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        // Cronjob update exchange BTC, CLP rate
        try {
            $schedule->call(function (){
                UpdateExchangeRate::updateExchangRate();
            })->everyMinute();
        } catch (\Exception $ex) {
            
        }

        // Cron job update status withdraw BTC
        try {
            $schedule->call(function () {
                UpdateStatusBTCWithdraw::updateStatusWithdraw();
            })->everyFiveMinutes();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

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
