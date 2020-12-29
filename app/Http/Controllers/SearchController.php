<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use Illuminate\Support\Facades\Validator;
use App\Book;
use App\Shelf;
use App\Catalog;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $me = (new CommonController)->thisuser();
        $book = $request->book ? : 0;
        $usersearch = $request->usersearch ?: "";
        $catalog = $request->catalog ?: "";

        $list = DB::table('books')
        ->select(DB::raw('"" as no'),'id','bookName','ISBN','description','quantity',DB::raw('"" as catalog'),DB::raw('"" as shelf'),DB::raw('"" as action'))
        ->get();

        return view('searchresult',compact('list','usersearch','book','catalog','me'));
    }

    public function getData(Request $request)
    {
    	$cond = "1";

    	if($request->book)
    	{
    		$cond .= " AND id =".$request->book;
    	}

    	if($request->usersearch)
    	{
    		$cond .= " AND books.ISBN LIKE '%".$request->usersearch."%' OR books.bookName LIKE '%".$request->usersearch."%'";
    	}

    	if($request->catalog)
    	{
    		$cond .= " AND catalogId =".$request->catalog;
    	}
  
        $list = DB::table('books')
        ->select(DB::raw('"" as no'),'id','bookName','ISBN','description','price','quantity','shelfId','catalogId',DB::raw('"" as action'))
        ->whereRaw($cond)
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
        ->addColumn('available',function($list){
        	$unreturn = Book::join(DB::raw('(SELECT Max(id) as maxid, bookId FROM book_logs GROUP BY bookId) as max'),'max.bookId','books.id')
	        ->join('book_logs','book_logs.id','=','max.maxid')
	        ->select(DB::raw('COUNT(*) as borrowed'))
	        ->where('status','Borrow')
	        ->where('book_logs.bookId',$list->id)
	        ->first();
	        $available = $list->quantity > $unreturn->borrowed ? "Yes" : "No";
	        $class = $list->quantity > $unreturn->borrowed ? "success" : "danger";
	        return "<span class='badge badge-".$class."'>".$available."</span>";
        })
        ->addColumn('action', function($list){

        	$unreturn = Book::join(DB::raw('(SELECT Max(id) as maxid, bookId FROM book_logs GROUP BY bookId) as max'),'max.bookId','books.id')
	        ->join('book_logs','book_logs.id','=','max.maxid')
	        ->select(DB::raw('COUNT(*) as borrowed'))
	        ->where('status','Borrow')
	        ->where('book_logs.bookId',$list->id)
	        ->first();

	        $type = $list->quantity > $unreturn->borrowed ? "Borrow" : "Reserve";
            $url = $list->quantity > $unreturn->borrowed ? url('bookForm').'/'.$list->id : url('reserveForm').'/'.$list->id;

            return '<a href="'.url('bookForm').'/'.$list->id.'" class="btn btn-primary">'.$type.'</a>';
        })
        ->rawColumns(['action','available'])
        ->make(true);
    }
}
