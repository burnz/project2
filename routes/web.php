<?php
Route::get('/design', function () {
    return view('design');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/term-condition.html', function () {
    return view('adminlte::layouts.term_register');
});

Route::get('/package-term-condition.html', function () {
    return view('adminlte::layouts.term_buy_pack');
});

Auth::routes();
Route::get('authenticator', 'Auth\LoginController@auth2fa');
Route::post('authenticator', 'Auth\LoginController@auth2fa');
Route::get('users/search',"User\UserController@search");
Route::group( ['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('users/root', 'User\UserController@root')->name('users.root');
    Route::resource('users', 'Backend\User\UserController');
    Route::resource('roles', 'Backend\User\RoleController');
    Route::resource('posts', 'Backend\User\PostController');
    Route::group(['middleware' => ['permission:view_admins']], function () {
        Route::get('admin/home', 'Backend\HomeController@index')->name('backend.home');
    });

    Route::group(['middleware' => ['permission:add_users']], function () {
        Route::post('users/approve_ok/{id}', 'Backend\User\UserController@approve_ok')->name('approve.ok');
        Route::post('users/approve_cancel/{id}', 'Backend\User\UserController@approve_cancel')->name('approve.cancel');
        Route::post('users/lock', 'Backend\User\UserController@lock')->name('users.lock');
    });

    Route::group(['middleware' => ['permission:edit_users']], function () {
        Route::post('users/reset2fa', 'Backend\User\UserController@reset2fa')->name('users.reset2fa');
        Route::post('users/resend-active-email', 'Backend\User\UserController@resendActiveEmail')->name('users.resendActiveEmail');
    });

    Route::group(['middleware' => ['permission:view_users']], function () {
        Route::get('users/photo_approve', 'Backend\User\UserController@photo_approve')->name('users.photo_approve');
    });

    Route::group(['middleware' => ['permission:view_users']], function () {
        Route::post('withdraw/approve', 'Backend\User\WithdrawController@withdrawApprove')->name('withdraw.approve');
    });

    Route::group(['middleware' => ['permission:view_users']], function () {
        Route::get('withdraw/', 'Backend\User\WithdrawController@index')->name('withdraw.list');
    });

    Route::group(['middleware' => ['permission:view_users']], function () {
        Route::get('wallet/history/', 'Backend\User\WalletController@index')->name('wallet.list');
    });

    Route::group(['middleware' => ['permission:view_reports']], function () {
        Route::get('/report', 'Backend\Report\ReportController@getDataReport')->name('report');
        Route::get('/report/commission', 'Backend\Report\ReportController@getDataCommissionReport');
        Route::get('/report/commission-usd', 'Backend\Report\ReportController@getDataCommissionReportUSD');
        Route::get('/report/rank', 'Backend\Report\ReportController@getRankList');
    });

    Route::get('members/genealogy', 'User\MemberController@genealogy');
    Route::get('members/binary', 'User\MemberController@binary');
    Route::get('members/referrals', 'User\MemberController@refferals');
    Route::get('members/referrals/{id}/detail', 'User\MemberController@refferalsDetail');
    Route::post('members/pushIntoTree', 'User\MemberController@pushIntoTree');
    Route::resource('members', 'User\MemberController');

    
    //Route::get('wallets/switchusdclp', 'Wallet\UsdWalletController@switchUSDCLP');
    Route::get('wallets/car/itransfer','Wallet\ClpWalletController@viewClpTransfer');
    Route::get('wallets/getrateusdbtc', 'Wallet\UsdWalletController@getDataWallet');
    Route::post('wallets/btcwithdraw', 'Wallet\WithDrawController@btcWithDraw');

    //Re-invest WALLET
    //Route::get('wallets/reinvest', 'Wallet\UsdWalletController@reinvestWallet')->name('wallet.reinvest');
    //Route::post('wallets/reinvest', 'Wallet\UsdWalletController@reinvestWallet');

    //BTC WALLET
    Route::get('wallets/btc', 'Wallet\BtcWalletController@showBTCWallet')->name('wallet.btc');
    Route::get('wallets/getbtccoin',"Wallet\BtcWalletController@getBtcCoin");
    Route::post('wallets/btcbuyclp',"Wallet\BtcWalletController@buyCLP");

    Route::get('wallets/btctranfer',"Wallet\BtcWalletController@btctranfer");

    Route::get('wallets/car/transfer',"Wallet\ClpWalletController@clptranfer");
    Route::get('wallets/car/convert',"Wallet\ClpWalletController@sellCAR");

    //Route::get('wallets/deposit', 'Wallet\BtcWalletController@deposit');
    //Route::get('wallets/switchbtcclp', 'Wallet\BtcWalletController@switchBTCCLP');
    Route::get('wallets/btc/ideposit','Wallet\BtcWalletController@showBtcDeposit');
    Route::get('wallets/btc/iwithdraw','Wallet\BtcWalletController@showBtcWithdraw');
    
    //CLP WALLET
    Route::get('wallets/car', 'Wallet\ClpWalletController@clpWallet')->name('wallet.clp');
    Route::post('wallets/car', 'Wallet\ClpWalletController@clpWallet')->name('wallet.clp');
    //Route::get('wallets/usd', 'Wallet\UsdWalletController@usdWallet')->name('wallet.usd');
    //Route::post('wallets/buy-car', 'Wallet\UsdWalletController@buyCar')->name('wallet.buy-car');
    Route::get('wallets/car/getaddresswallet', 'Wallet\ClpWalletController@getClpWallet');
    Route::post('wallets/car/withdraw', 'Wallet\WithDrawController@clpWithDraw');
    Route::post('wallets/sellclp', 'Wallet\ClpWalletController@sellCLP');
    Route::get('wallets/car/iwithdraw','Wallet\ClpWalletController@viewClpWithdraw');
    Route::get('wallets/car/ideposit','Wallet\ClpWalletController@viewClpDeposit');
    //Get total value
    Route::get('wallets/totalvalue','WalletController@getMaxTypeWallet');
        

    Route::get('wallets/transferholding', 'WalletController@transferFromHolding')->name('holding.transfer');


    Route::get('mybonus/tickets', 'MyBonusController@tickets');
    Route::get('mybonus/infinity', 'MyBonusController@binary');
    Route::get('mybonus/winning', 'MyBonusController@awards');
    Route::get('mybonus/fast-start', 'MyBonusController@faststart');
    Route::get('week/tickets/level/{level}/w/{week}', 'MyBonusController@detailTicket');
    Route::get('week/awards/level/{level}/w/{week}', 'MyBonusController@detailAward');
    Route::get('week/agency/level/{level}/w/{week}', 'MyBonusController@detailAgency');
    Route::resource('mybonus', 'MyBonusController');

    Route::get('packages/ibuy','PackageController@showBuyPackage');
    Route::get('packages/buy','PackageController@buyPackage')->name('package.buy');

    //Route::get('packages/invest', 'PackageController@invest');
    Route::post('packages/invest', [ 'as' => 'packages.invest', 'uses' => 'PackageController@invest']);
    Route::post('packages/withdraw', [ 'as' => 'packages.withdraw', 'uses' => 'PackageController@withDraw']);
    Route::resource('packages', 'PackageController');

    //Profile router
    Route::any('profile/upload','User\ProfileController@upload');
    Route::get('profile','User\ProfileController@index');
    Route::get('profile/security','User\SecurityController@psecurity');
    Route::post('profile/changepassword','User\ProfileController@changePassword');
    Route::get('profile/switchauthen','User\ProfileController@switchTwoFactorAuthen');

    Route::resource('profile', 'User\ProfileController');

    //Auction
    // Route::get('order','Order\OrderController@index')->name('order.manage');
    // Route::post('order', 'Order\OrderController@index');
    // Route::get('gethistorydataorderuser', 'Order\OrderController@getHistoryDataOrder');
    // Route::get('gethistorydatatrademarket', 'Order\OrderController@getHistoryDataTradeMarket');

    Route::get('todayorder','Backend\Order\ToDayOrderController@show');
    Route::get('historyorder','Backend\Order\HistoryOrderController@show');
    Route::get('gettodaydataorder','Backend\Order\ToDayOrderController@getToDayDataOrder');
    Route::get('gethistorydataorder','Backend\Order\HistoryOrderController@getHistoryDataOrder');
    Route::resource('ordermin', 'Backend\Order\OrderMinController');

    //News
    Route::get('/news','User\InfoController@clp');
    Route::get('news/detail/{id}','News\DisplayNewsController@displayDetailNews');
    Route::resource('admin/news','Backend\News\NewsController');
    //get ty gia
    Route::get('exchange',function(App\ExchangeRate $rate){
        return $rate->getExchRate();
    });


});

Route::post('api/update-ticket','JackpotController@updateTicket');
Route::post('api/update-award','JackpotController@updateAward');
Route::post('api/create-user','JackpotController@createUser');

Route::get('getnotification','GetNotificationController@getNotification');
Route::post('getnotification','GetNotificationController@getNotification');
Route::post('clpnotification','GetNotificationController@clpNotification');


/***------- TEST -------***/
//Route::get('ethereumtest', 'EthereumTestController@index');
//Route::get('test-register', 'Auth\TestRegisterController@showRegistrationFormNoActive')->name('test.showRegister');
//Route::post('registernoactiveaction', 'Auth\TestRegisterController@registerNoActive')->name('test.registerAction');
//Route::get('update-ticket', 'TestController@showUpdateTicket')->name('test.showTicket');
//Route::post('save-ticket', 'TestController@updateTicket')->name('test.saveTicket');
//Route::get('update-award', 'TestController@showUpdateAward')->name('test.showAward');
//Route::post('save-award', 'TestController@updateAward')->name('test.saveAward');
//Route::get('convert-package', 'TestController@convertPackage');


//Route::get('run-agency-bonus',"TestController@testInterest");
//Route::get('run-infinity','TestController@testInfinityBonus');
//Route::get('run-ticket-bonus', 'TestController@testInfinityInterest');
//Route::get('run-award-bonus','TestController@testGlobalBonus');
//Route::get('test-auto-binary',"TestController@testAutoAddBinary");
Route::get('test',"TestController@test");


/***------- END TEST -------***/
Route::get('ref/{nameref}',"Auth\RegisterController@registerWithRef")->name('user.ref');
Route::get('active/{infoActive}',"Auth\ActiveController@activeAccount");
//Route::get('reactive',"Auth\ActiveController@reactiveAccount");
//Route::post('reactive',"Auth\ActiveController@reactiveAccount");
Route::get('notification/useractive',"NotificationController@userActive");
Route::get('notification/useractived',"NotificationController@userActived");
Route::get('notiactive',"NotificationController@userNotiActive");
Route::any('confirmWithdraw',"Wallet\WithDrawController@confirmWithdraw");


