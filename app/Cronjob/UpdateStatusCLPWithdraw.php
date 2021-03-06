<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\Withdraw;
use App\Wallet;
use DateTime;
use App\CLPWalletAPI;

/**
 * Description of UpdateStatusBTCTransaction
 *
 * @author giangdt
 */
class UpdateStatusCLPWithdraw
{
    
    public static function updateStatusWithdraw()
    {
        //List withdraw not completed
        $listWithdrawNotUpdated = Withdraw::where("status", 0)->whereNotNull('amountCLP')->get();
        $clpApi = new CLPWalletAPI();

        foreach($listWithdrawNotUpdated as $withdraw) {

            $datetime1 = new DateTime(date("Y-m-d H:i:s"));
            //get release date của package cuối cùng <-> max id
            $enoughtTime = strtotime($withdraw->created_at . "+ 5 minutes");
            $datetime2 = new DateTime(date('Y-m-d H:i:s', $enoughtTime));

            $interval = $datetime2->diff($datetime1);
            //compare
            if( $interval->format('%i') >= 0 ) {
                //Get transaction info
                $tranStatus = $clpApi->getTransactionInfo($withdraw->transaction_hash);
                if($tranStatus == 'completed') {
                    $withdraw->status = 1;
                    $withdraw->save();
                    //Updat status in table wallets from "Pending" => "Completed"
                    Wallet::find($withdraw->wallet_id)->update(['note' => "Completed"]);
                }
            }
            
        }
    }
}
