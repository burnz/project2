<?php

return [
	'clp_bonus_pay' => 0.6,
	'reinvest_bonus_pay' => 0.4,
	'bonus_maxout' => 30000, //Binary bonus cannot over $35000

	//Interest range
	'min_interest' => 0.66,
	'max_interest' => 0.8,

	//Bonus when member have new F1
	'bonus_range_1_pay' => 0.07,
	'bonus_range_2_pay' => 0.08,
	'bonus_range_3_pay' => 0.09,
	'bonus_range_4_pay' => 0.1,
	
	//Binary level
	'bi_sale_cond_lv_1' => 1000,
	'bi_sale_cond_lv_2' => 10000,
	'bi_sale_cond_lv_3' => 100000,
	'bi_sale_cond_lv_4' => 200000,
	
	//Bonus for each binary level
	'bi_lv_1_bonus' => 0.04,
	'bi_lv_2_bonus' => 0.06,
	'bi_lv_3_bonus' => 0.08,
	'bi_lv_4_bonus' => 0.1,

	//Binary interest level
	'bi_inter_cond_lv_1' => 500,
	'bi_inter_cond_lv_2' => 3000,
	'bi_inter_cond_lv_3' => 30000,
	'bi_inter_cond_lv_4' => 50000,

	//Bonus for each binary interest level
	'bi_lv_1_inter_bonus' => 0.14,
	'bi_lv_2_inter_bonus' => 0.16,
	'bi_lv_3_inter_bonus' => 0.18,
	'bi_lv_4_inter_bonus' => 0.2,


	'binary_matching_bonus' => 0.05,

	//Leadership bonus
	'sapphire_leadership_bonus' => 0.02,
	'emerald_leadership_bonus' => 0.015,
	'diamond_leadership_bonus' => 0.01,
	'bluediamond_leadership_bonus' => 0.0075,
	'blackdiamond_leadership_bonus' => 0.005,
	
	//Leadership level
	'loyalty_upgrate_silver' => 20000,
	'loyalty_upgrate_gold' => 50000,
	'loyalty_upgrate_pear' => 100000,
	'loyalty_upgrate_emerald' => 200000,
	'loyalty_upgrate_diamond' => 500000,
	
    'wallet_type' => array(
        1 => 'adminlte_lang::wallet.fast_start_type',
        2 => 'adminlte_lang::wallet.interest',
        3 => 'adminlte_lang::wallet.binary',
        4 => 'adminlte_lang::wallet.loyalty',
        5 => 'adminlte_lang::wallet.usd_clp_type',
        6 => 'adminlte_lang::wallet.reinvest_clp_type', //holding wallet to clp wallet
        7 => 'adminlte_lang::wallet.btc_clp_type',
        8 => 'adminlte_lang::wallet.clp_btc_type',
        9 => 'adminlte_lang::wallet.withdraw_btc_type',
        10 => 'adminlte_lang::wallet.withdraw_clp_type',
        11 => 'adminlte_lang::wallet.transfer_btc_type',
        12 => 'adminlte_lang::wallet.transfer_clp_type', //REMOVE
        13 => 'adminlte_lang::wallet.deposit_btc_type',
        14 => 'adminlte_lang::wallet.deposit_clp_type',
        15 => 'adminlte_lang::wallet.buy_pack',
        16 => 'adminlte_lang::wallet.tl_withdraw_pack',
    ),

    'listLoyalty' => array(1 => "Broker", 2 => "Supervisor", 3 => "Manager", 4 => "Executive", 5 => "President"),
    ];
