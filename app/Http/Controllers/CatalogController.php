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
        ->select(DB::raw('"" as no'),'id','catalogName','image_path','catalogDescription',DB::raw('"" as action'))
        ->get();

        $catalog = Catalog::all();

        $shelf = Shelf::all();

        return view('catalog',compact('me','list','shelf','catalog'));
    }

    public function getData()
    {
    	$me = (new CommonController)->thisuser();

        $list = DB::table('catalogs')
        ->select(DB::raw('"" as no'),'id','catalogName','image_path','catalogDescription',DB::raw('"" as action'))
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('image', function($list){
            if($list->image_path)
            {
                return '<img src="'.asset('storage/public/catalog/'.$list->image_path).'" width="50" height="50">';
            }
            else
            {
                return "-";
            }
        })
        ->addColumn('action', function($list){
            return '<button class="btn btn-primary" onclick="openModal(this)" data-type="Edit" data-id="'.$list->id.'">Edit</button> <button class="btn btn-danger" onclick="openModal(this)" data-type="Delete" data-id="'.$list->id.'">Delete</button>';
        })
        ->rawColumns(['action','image'])
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
            $item = Catalog::find($request->id);
            $item->update($request->except('id','_token'));
        }
        else
        {
            $item = Catalog::create($request->except('id','_token'));
        }
        
        if($request->hasFile('photo'))
        {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('photo')->storeAs('public/catalog',$fileNameToStore);
            $item->image_path = $fileNameToStore;
            $item->save(); 
        }
    }
}
