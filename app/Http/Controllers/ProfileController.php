<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\Shelf;
use App\Catalog;
use App\User;
use App\Course;
use Redirect;

class ProfileController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $allcatalog = Catalog::all();

        $list = DB::table('users')
        ->select('id','name','type','matric','course','year','gender')
        ->get();
        
        $catalog = Catalog::all();

        $shelf = Shelf::all();

        $course=Course::all();

        return view('profile',compact('me','list','shelf','catalog','course','allcatalog'));
    }

    public function update(Request $request)
    {
        $me = (new CommonController)->thisuser();
        
        //Validator
        $rules = [
            'course' => 'required',
            'phone' => 'required|regex:/^(01)[0-46-9]*[0-9]{7,8}$/|max:11|min:10',
        ];

        $message = [
            'course.required' => "Course field is required",
            'phone. required' => "Phone field is required",
            'phone.regex'=> "Invalid phone number ex:0123456789",
            'phone.max'=>"The phone number may not be greater than 11 characters."
        ];


        $validator = Validator::make($request->all(),$rules,$message);
        
        if($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
               
        }
        else
        {
            User::find($request->id)->update($request->except('id','_token'));
            return redirect()->back()->with('success', 'Data Updated');
        }
        
        
    }
}
