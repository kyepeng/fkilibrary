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
use App\User;
use App\Booklog;

class BookLogController extends Controller
{
    public function index()
    {	
        $me = (new CommonController)->thisuser();

        $list = DB::table('book_logs')
        ->select(DB::raw('"" as no'),'id','bookId','userId','start_date','end_date','fine','paid',DB::raw('"" as action'))
        ->get();

        $users = User::where('type','Student')->get();

        $books = Book::all();

        return view('booklogs',compact('me','list','users','books'));
    }

    public function getData()
 	{
    	$me = (new CommonController)->thisuser();

        $list = DB::table('book_logs')
        ->select(DB::raw('"" as no'),'id','bookId','userId','start_date','end_date','fine','paid',DB::raw('"" as action'))
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('book', function($list){
            $book = Book::find($list->bookId);
            return $book->bookName;
        })
        ->addColumn('student', function($list){
            $user = User::find($list->userId);
            return $user->name;
        })
        ->addColumn('action', function($list){
            return '<button class="btn btn-primary" onclick="openModal(this)" data-type="Update" data-id="'.$list->id.'">Update</button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function update(Request $request)
    {
        $me = (new CommonController)->thisuser();

        //Validator
        $rules = [
            'bookId' => 'required',
            'userId' => 'required|checkPenalty'
        ];

        $penalty = BookLog::where('userId',$request->userId)->where('paid',0)->sum('fine');

        $message = [
            'bookId.required' => 'Book field is required',
            'userId.required' => 'Student field is required',
            'userId.check_penalty' => "The student has unpaid fine RM ".$penalty
        ];


        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 404);
        }

        $request->merge(['start_date' => date('Y-m-d') , 'end_date' => date('Y-m-d',strtotime('today + 7 days'))]);

        BookLog::create($request->except('id','_token'));
    }
}