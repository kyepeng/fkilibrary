<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Book;
use App\Shelf;
use App\Catalog;

class BookController extends Controller
{
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $list = DB::table('books')
        ->select(DB::raw('"" as no'),'id','shelfId','catalogId','bookName','ISBN','description','price','quantity',DB::raw('"" as catalog'),DB::raw('"" as shelf'),DB::raw('"" as action'))
        ->get();

        $catalog = Catalog::all();

        $shelf = Shelf::all();

        return view('books',compact('me','list','shelf','catalog'));
    }

    public function getBooks()
    {
    	$me = (new CommonController)->thisuser();

        $list = DB::table('books')
        ->select(DB::raw('"" as no'),'id','bookName','ISBN','description','price','quantity','shelfId','catalogId',DB::raw('"" as action'))
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('shelf', function($list){
            $shelf = Shelf::find($list->shelfId);
            return $shelf->displayName;
        })
        ->addColumn('catalog', function($list){
            $catalog = Catalog::find($list->catalogId);
            return $catalog->catalogName;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function updateBooks(Request $request)
    {
        $me = (new CommonController)->thisuser();

        if($request->id && !$request->ISBN)
        {
            Book::find($id)->delete();
        }

        //Validator
        $rules = [
            'bookName' => 'required|max:255',
            'ISBN' => 'required|min:7|max:7|regex:/^[a-zA-Z][0-9]+$/|unique:books,ISBN,'.$request->id,
            'price' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            // 'catalogId' => 'required',
            // 'shelfId' => 'required'
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
            Book::find($request->id)->update($request->except('id','_token'));
        }
        else
        {
            Book::create($request->except('id','_token'));
        }
    }
}
