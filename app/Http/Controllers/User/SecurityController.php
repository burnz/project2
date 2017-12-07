<?php
    namespace App\Http\Controllers\User;
    
    use App\Http\Requests;
    use App\UserData;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Response;
    use App\User;
    use Auth;
    use Session;
    use Hash;
    use Google2FA;
    use App\Http\Controllers\Controller;
    use Validator;
    class SecurityController extends Controller
    {
        /**
         * Show security profile user
         */
        public function psecurity()
        {
            $sponsor = User::where('id', Auth::user()->refererId)->first();
            $google2faUrl = Google2FA::getQRCodeGoogleUrl(
               config('app.name'),
               Auth::user()->email,
               Auth::user()->google2fa_secret
            );
            return view('adminlte::profile.security',compact('sponsor', 'google2faUrl'));
        }
    } 
?>