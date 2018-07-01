<?php

return [
	'bonus_maxout' => 30000, //Binary bonus cannot over $30000

	'price_per_ticket' => 0.0002,

	//agency commission
	'agency_level_1' => 0.05,
	'agency_level_2' => 0.04,
	'agency_level_3' => 0.03,
	'agency_level_4' => 0.02,
	'agency_level_5' => 0.01,
	
	//agency commission for each binary level
	'binary_level_1' => 0.06,
	'binary_level_2' => 0.07,
	'binary_level_3' => 0.08,
	'binary_level_4' => 0.09,
	'binary_level_5' => 0.1,

	//ticket commission
	'ticket_dr_cus' => 0.05,
	'ticket_level_1' => 0.05,
	'ticket_level_2' => 0.02,
	'ticket_level_3' => 0.01,
	'ticket_level_4' => 0.01,
	'ticket_level_5' => 0.01,
	
	//award commision
	'award_dr_cus' => 0.025,
	'award_agency' => 0.005,

	'condition' => array(
    	1 => '35',
    	2 => '70',
    	3 => '140',
    	4 => '280',
    	5 => '560',
    ),

    'wallet_type' => array(
        1 => 'adminlte_lang::wallet.fast_start_type',
        2 => 'adminlte_lang::wallet.interest',
        3 => 'adminlte_lang::wallet.binary',
        4 => 'adminlte_lang::wallet.loyalty',
        6 => 'adminlte_lang::wallet.reinvest_clp_type', //holding wallet to clp wallet
        8 => 'adminlte_lang::wallet.clp_btc_type',
        9 => 'adminlte_lang::wallet.withdraw_btc_type',
        10 => 'adminlte_lang::wallet.withdraw_clp_type',
        12 => 'adminlte_lang::wallet.transfer_clp_type', //REMOVE
        13 => 'adminlte_lang::wallet.deposit_btc_type',
        14 => 'adminlte_lang::wallet.deposit_clp_type',
        15 => 'adminlte_lang::wallet.buy_pack',
        16 => 'adminlte_lang::wallet.tl_withdraw_pack',
        //17 => 'adminlte_lang::wallet.binary_interest',
        18 => 'adminlte_lang::wallet.binary_interest',
        //19 => 'adminlte_lang::wallet.binary_interest',
        19 => 'adminlte_lang::wallet.global_bonus',
    ),

];
