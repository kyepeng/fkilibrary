<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\Shelf;
use App\Catalog;

class CatalogController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $list = DB::table('catalogs')
        ->select(DB::raw('"" as no'),'id','catalogName','catalogDescription',DB::raw('"" as action'))
        ->get();

        $catalog = Catalog::all();

        $shelf = Shelf::all();

        return view('catalog',compact('me','list','shelf','catalog'));
    }

    public function getData()
    {
    	$me = (new CommonController)->thisuser();

        $list = DB::table('catalogs')
        ->select(DB::raw('"" as no'),'id','catalogName','catalogDescription',DB::raw('"" as action'))
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
        if($request->id && !$request->catalogName)
        {
            Catalog::find($request->id)->delete();
            return 1;
        }

        //Validator
        $rules = [
            'catalogName' => 'required|max:255',
            //'catalogpicture' => 'required',
            
            
        ];

        $message = [
            'catalogName.required' => 'Name field is required',
           
            //'catalogpicture.required' => 'Picture field is required',
            
        ];


        $validator = Validator::make($request->all(),$rules,$message);
      
        if($validator->fails())
        {
            return response()->json($validator->errors(), 404);
        }
       
        if($request->id)
        {
            Catalog::find($request->id)->update($request->except('id','_token'));
        }
        else
        {
            Catalog::create($request->except('id','_token'));
        }
        
    }
}
