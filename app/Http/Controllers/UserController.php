<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Mail;

class UserController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $list = DB::table('users')
        ->select(DB::raw('"" as no'),'id','name','email','matric','gender','year','course','phone',DB::raw('"" as action'))
        ->get();

        return view('users',compact('me','list'));
    }

    public function getUsers()
    {
    	$me = (new CommonController)->thisuser();

        $list = DB::table('users')
        ->select('id','name','email','matric','gender','year','course','phone')
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('action', function($list){
        	return '<button class="btn btn-danger" data-id="'.$list->id.'">Delete</button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
