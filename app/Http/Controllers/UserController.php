<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Catalog;

class UserController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();

        $list = DB::table('users')
        ->select(DB::raw('"" as no'),'id','name','email','matric','gender','year','course','phone',DB::raw('"" as action'))
        ->get();

        return view('users',compact('me','list','allcatalog'));
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
        	return '<button class="btn btn-danger" onclick="openModal(this)" data-type="Delete" data-id="'.$list->id.'">Delete</button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function update(Request $request)
    {
        $me = (new CommonController)->thisuser();
        if($request->id)
        {
            User::find($request->id)->delete();
            return 1;
        }


    }
}

