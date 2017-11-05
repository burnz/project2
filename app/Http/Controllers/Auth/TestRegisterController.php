<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
//use App\BitGo\BitGoSDK;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use Illuminate\Auth\Events\Registered;
use App\Notifications\UserRegistered;
use App\UserData;
use App\UserCoin;
use App\CLPWallet;
use URL;
use Session;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class TestRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    const COINBASE = 'coinbase';

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFormNoActive(Request $request)
    {
        $referrerId = $referrerName = null;
        if(isset($request['referrer']) && trim($request['referrer']) != ''){
            $request['referrer'] = trim($request['referrer']);
            if(is_numeric($request['referrer']) && $request['referrer'] > 0) {
                $user = User::find($request['referrer']);
            }elseif(is_string($request['referrer'])){
                $user = User::where('name', '=', $request['referrer'])->first();
            }
            if($user){
                $referrerId = $user->id;
                $referrerName = $user->name;
            }
        }
        return view('adminlte::auth.test_register', ['referrerId' =>$referrerId, 'referrerName' => $referrerName]);
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/notiactive';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        return Validator::make($data, [
            'firstname'     => 'required|max:255',
            'lastname'     => 'required|max:255',
            'name'     => 'required|without_spaces|max:255|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            //'password' => 'required|min:8|confirmed|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
            'phone'    => 'required',
            'terms'    => 'required',
            'country'    => 'required|not_in:0',
            'g-recaptcha-response'=> config('app.enable_captcha') ? 'required|captcha' : '',
        ]);
    }
    

    public function registerNoActive(Request $request)
    {
        //$this->validator($request->all())->validate();

        event(new Registered($user = $this->createNoActive($request->all())));

        if($user == false) flash()->success('Dont have sponsor id.');
        else flash()->success('User has been created.');

        return redirect()->route('test.showRegister');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createNoActive(array $data)
    {
        //Tao acc vi
        try {
            //get userid from uid
            $userReferer = User::where('uid', $data['refererId'])->get()->first();

            if(!isset($userReferer->id)) return false;

            //luu vao thong tin ca nhan vao bang User
            $fields = [
                'firstname'     => $data['name'],
                'lastname'     => 'Do',
                'name'     => $data['name'],
                'email'    => $data['name'] . '@gmail.com',
                'phone'    => '0978788999',
                'country'    => '704',
                'refererId'    => isset($userReferer->id) ? $userReferer->id : null,
                'password' => bcrypt('1'),
                //'accountCoinBase' => 'test',
                'active' => 1,
                'activeCode' => 'test',
                'uid' => User::getUid(),
                'google2fa_secret' => Google2FA::generateSecretKey(16)
            ];
            if (config('auth.providers.users.field','email') === 'username' && isset($data['username'])) {
                $fields['username'] = $data['username'];
            }
            $user = User::create($fields);

            //SAVE to User_datas
            $fields['userId'] = $user->id;
            
            $fields['clpCoinAmount'] = '100000';
            
            $userData = UserData::create($fields);

            
            $userCoin = UserCoin::create($fields);

            //Update calculate total member
            User::updateUserGenealogy($user->id);

            //gui mail
            //ma hoa send link active qua mail
            // if($user) {
            //     $encrypt    = [hash("sha256", md5(md5($data['email']))),$data['email']];
            //     $linkActive =  URL::to('/active')."/".base64_encode(json_encode($encrypt));
            //     $user->notify(new UserRegistered($user, $linkActive));  
            // }
            return $user;
        } catch (Exception $e) {
            var_dump($e->getmessage());
        }
    }
}
