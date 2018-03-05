<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserData;
use App\UserCoin;
use App\Role;
use App\News;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Google2FA;
use DB;

class InfoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function clp(Request $request)
    {
        $listNews = News::where('category_id', 3)->orderBy('created_at', 'desc')->get();
        $title = "CAR News";
        $type = 'car';
        return view('adminlte::news.index', compact('listNews', 'title', 'type'));
    }
}
