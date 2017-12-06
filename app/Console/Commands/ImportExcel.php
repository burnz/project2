<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Excel;
use App\Package;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\UserData;
use App\UserCoin;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;

class ImportExcel extends Command
{
    const COINBASE = 'coinbase';

    const USER = 'User';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import multi excel with type';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->choice('What is your type excel import (typing number)?',
            [self::USER, 'Another']);

        if ($type == self::USER) {
            $this->info('Begin import excel and update again db plz wait until end ...');

            try {
                $this->import_user_excel();
            } catch (\Exception $exception) {
                Log::info($exception->getMessage());
                Log::info($exception->getTraceAsString());
                $this->error('Error' . $exception->getMessage());
                $this->error('Error' . $exception->getTraceAsString());
                exit();
            };

            if ($this->confirm('Do you wish to continue import excel another?')) {
                self::handle();
            } else {
                $this->line('End');
            }
        } else {
            $this->info('Coming soon !, Bye see you again !');
        }

    }

    private function import_user_excel()
    {
        $start = microtime(true);
        $latestUser = ($temp = DB::table('users')->select('id')->orderBy('id', 'DESC')->first()) == null ? 0 : $temp->id;
        $exData = Excel::load(storage_path('excel/users.xls'))->get();
        $data = $exData->toArray();

        //Có hơn 1 sheet
        if(isset($data[0][0])){
            User::insert($data[0]);
        } else {
            //xy neu chi co 1 sheet duy nhat trong 1 excel
            User::insert($data);
        }

        //update lai
        $users = DB::table('users')->select('id', 'referer_name', 'name', 'value_package')
            ->where('id', '>', $latestUser)
            ->whereNotNull('uid')
            ->whereNull('refererId')
            ->whereNotNull('value_package')
            ->whereNotNull('referer_name')
            ->get();
        
        //cần update lại created_at , updated_at , status, refererId, active
        $dataUserData = [];
        $dataUserCoin = [];
        $this->info('Caculate UserData');
        foreach ($users as $user){
            $userInfo = User::where('name', $user->referer_name)->first();
            $refererId = isset($userInfo->id) ? $userInfo->id : null;

            $dataUpdate['created_at'] = \Carbon\Carbon::now();
            $dataUpdate['updated_at'] = \Carbon\Carbon::now();
            $dataUpdate['status'] = 1;
            $dataUpdate['refererId'] = $refererId;
            $dataUpdate['active'] = 1;
            User::where('id', $user->id)
                ->update($dataUpdate);

            //Update user tree permission
            User::updateUserGenealogy($user->id);

            //Get package id
            $packageId = 0;
            if(200 <= $user->value_package && $user->value_package < 1010) $packageId = 1;
            if(1010 <= $user->value_package && $user->value_package < 10010) $packageId = 2;
            if(10010 <= $user->value_package && $user->value_package < 50010) $packageId = 3;
            if(50010 <= $user->value_package) $packageId = 4;
            
            //Get address
            if($user->name) {
                //$accountWallet = $this->GenerateAddress(self::COINBASE, $user->name);
            }

            //UserData
            $dataUserData[] = [
                'userId' => $user->id,
                'refererId' => $dataUpdate['refererId'],
                'packageId' => $packageId,
                'packageDate'=> \Carbon\Carbon::now(),
                'status' => 1
            ];

            //UserCoin
            $dataUserCoin[] = [
                'userId' => $user->id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];
        }
        
        $this->info('Update user_data table');
        UserData::insert($dataUserData);

        //Import data for UserCoin
        $this->info('Update user_coins table');
        UserCoin::insert($dataUserCoin);

        $time_elapsed_secs = microtime(true) - $start;
        echo 'time estimated : ';
        var_dump ($time_elapsed_secs);
        $this->info('Success Complete !');
    }

    /*
    * @author GiangDT
    * 
    * Generate new address
    *
    */
    private function GenerateAddress( $type, $name = null ) {
        $data = [];
       
        try {
            // tạo acc ví cho tk
            $configuration = Configuration::apiKey( config('app.coinbase_key'), config('app.coinbase_secret'));
            $client = Client::create($configuration);

            //Account detail
            $account = $client->getAccount(config('app.coinbase_account'));

            // Generate new address and get this adress
            $address = new Address([
                'name' => $name
            ]);

            //Generate new address
            $client->createAccountAddress($account, $address);

            //Get all address
            $listAddresses = $client->getAccountAddresses($account);

            $address = '';
            $id = '';
            foreach($listAddresses as $add) {
                if($add->getName() == $name) {
                    $address = $add->getAddress();
                    $id = $add->getId();
                    break;
                }
            }

            $data = [ "accountId" => $id,
                "walletAddress" => $address ];

        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $data;
    }
}