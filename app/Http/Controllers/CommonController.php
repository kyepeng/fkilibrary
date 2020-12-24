<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use DB;

class CommonController extends Controller
{
    public function thisuser()
    {
        $auth = Auth::user();
        $me = User::find($auth->id)->first();
        
        return $me;
    }
}
