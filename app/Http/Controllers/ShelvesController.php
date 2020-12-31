<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\Shelf;
use App\Catalog;

class ShelvesController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $list = DB::table('shelves')
        ->select(DB::raw('"" as no'),'id','displayName',DB::raw('"" as action'))
        ->get();

        $allcatalog = Catalog::all();

        $shelf = Shelf::all();

        return view('shelves',compact('me','list','shelf','allcatalog'));
    }

    public function getData()
    {
    	$me = (new CommonController)->thisuser();

        $list = DB::table('shelves')
        ->select(DB::raw('"" as no'),'id','shelf','row','displayName',DB::raw('"" as action'))
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('action', function($list){
            return '<button class="btn btn-primary" onclick="openModal(this)" data-type="Edit" data-id="'.$list->id.'">Edit</button> <button class="btn btn-danger" onclick="openModal(this)" data-type="Delete" data-id="'.$list->id.'">Delete</button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function update(Request $request)
    {
        $me = (new CommonController)->thisuser();
      
        if($request->id && !$request->row)
        {
            Shelf::find($request->id)->delete();
            return 1;
        }

        $request->merge(['displayName' => 'S'.$request->shelf.'-R'.$request->row ]);
        //Validator
        $rules = [
            // 'row' => 'required',
            'shelf' => 'required|max:1|regex:/^[1-5]+$/',
            'row' => 'required|max:1|regex:/^[1-8]+$/', 
            'displayName' => 'unique:shelves,displayName'          
        ];

        $message = [
            // 'row.required' => 'Row field is required',
            'shelf.required' => 'Shelf field is required',
            'row.required' => 'Row field is required', 
            'shelf.regex'=>'Shelf field should between 1 to 5' ,
            'row.regex'=>'Row field should between 1 to 8' ,
            'displayName.unique'=>"The place has already been taken"
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        
        if($validator->fails())
        {
            return response()->json($validator->errors(), 404);
        }
        
        if($request->id)
        {
            
            Shelf::find($request->id)->update($request->except('id','_token'));
    
        }
        else
        {
            
            $test=Shelf::create($request->except('id','_token'));
            
        }
        
    }
}
