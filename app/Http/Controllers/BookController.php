<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\Shelf;
use App\Catalog;

class BookController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $list = DB::table('books')
        ->select(DB::raw('"" as no'),'id','bookName','ISBN','description','price','quantity','image_path',DB::raw('"" as catalog'),DB::raw('"" as shelf'),DB::raw('"" as action'))
        ->get();

        $catalog = Catalog::all();

        $shelf = Shelf::all();

        return view('books',compact('me','list','shelf','catalog'));
    }

    public function getData()
    {
    	$me = (new CommonController)->thisuser();

        $list = DB::table('books')
        ->select(DB::raw('"" as no'),'id','bookName','ISBN','description','price','quantity','image_path','shelfId','catalogId',DB::raw('"" as action'))
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('shelf', function($list){
            $shelf = Shelf::find($list->shelfId);
            return $shelf ? $shelf->displayName : '-';
        })
        ->addColumn('catalog', function($list){
            $catalog = Catalog::find($list->catalogId);
            return $catalog ? $catalog->catalogName : '-';
        })
        ->addColumn('image', function($list){
            return '<img src="'.asset('storage/public/book/'.$list->image_path).'" width="50" height="50">';
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

        if($request->id && !$request->ISBN)
        {
            Book::find($request->id)->delete();
            return 1;
        }

        //Validator
        $rules = [
            'bookName' => 'required|max:255',
            'ISBN' => 'required|min:7|max:7|regex:/^[a-zA-Z][0-9]+$/|unique:books,ISBN,'.$request->id,
            'price' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'catalogId' => 'required',
            'shelfId' => 'required'
        ];

        $message = [
            'bookName.required' => 'Name field is required',
            'ISBN.required' => 'ISBN field is required',
            'ISBN.regex' => 'ISBN field must be a combination of 1 alphabet and 6 numbers ex: J100001',
            'ISBN.min' => "ISBN must be 7 characters",
            'ISBN.max' => "ISBN must be 7 characters",
            'ISBN.unique' => 'ISBN has been taken',
            'catalogId.required' => 'Catalog field is required',
            'shelfId.required' => 'Shelf field is required',
        ];


        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 404);
        }


        if($request->id)
        {
            $item = Book::find($request->id);
            $item->update($request->except('id','_token'));
        }
        else
        {
            $item = Book::create($request->except('id','_token'));
        }

        if($request->hasFile('photo'))
        {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('photo')->storeAs('public/book',$fileNameToStore);
            $item->image_path = $fileNameToStore ;
            $item->save(); 
        }
    }
}
