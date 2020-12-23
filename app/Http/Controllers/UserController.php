<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $list = DB::table('users')
        ->select(DB::raw("'' as no"),DB::raw("'' as checkbox"),'id','name','email','status')
        ->get();

        return view('users',compact('me','list'));
    }

    public function getUsers()
    {
        $list = DB::table('users')
        ->select(DB::raw(" '' as no"),'id','name','email')
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('checkbox', function($list){
            return '<input type="checkbox" class="check" value="'.$list->id.'">';
        })
        ->rawColumns(['checkbox'])
        ->make(true);
    }
}
