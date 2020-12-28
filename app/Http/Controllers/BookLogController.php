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
    public function index(Request $request)
    {	
        $me = (new CommonController)->thisuser();

        $id = $request->id ?: 0;

        $list = DB::table('book_logs')
        ->select(DB::raw('"" as no'),'id','bookId','userId','start_date','end_date','fine','paid','status')
        ->get();

        $users = User::where('type','Student')->get();

        $books = Book::all();

        return view('booklogs',compact('me','list','users','books','id'));
    }

    public function getData(Request $request)
 	{
    	$me = (new CommonController)->thisuser();

    	$cond = "1";

    	if($request->id)
    	{
    		$cond .= " AND book_logs.bookId =".$request->id;
    	}

    	if($request->status)
    	{
    		if($request->status == "Borrow")
    		{
    			$cond .= " AND status = 'Borrow' AND DATEDIFF(end_date,CURDATE()) >= 0";
    		}
    		else if($request->status == "Expired")
    		{
    			$cond .= " AND status = 'Borrow' AND DATEDIFF(end_date,CURDATE()) < 0";
    		}
    		else
    		{
    			$cond .= " AND status = 'Returned'";
    		}
    	}

        $list = DB::table('book_logs')
        // ->join(DB::raw('(SELECT Max(id) as maxid, bookId FROM book_logs GROUP BY bookId) as max'),'max.bookId','books.id')
        // ->join('book_logs','book_logs.id','=','max.maxid')
        ->select(DB::raw('"" as no'),'book_logs.id','book_logs.bookId','userId','start_date','end_date','fine','paid','status')
        ->whereRaw($cond)
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('book', function($list){
            $book = Book::find($list->bookId);
            return $book->bookName;
        })
        ->addColumn('student', function($list){
            $user = User::find($list->userId);
            return $user->matric;
        })
        ->addColumn('badge', function($list){
        	$class = "badge badge-success";
        	if($list->status == "Borrow" && (date('Y-m-d') < $list->end_date) )
        	{
        		$class = "badge badge-warning";
        	}
        	else if($list->status == "Borrow")
        	{
        		$class = "badge badge-danger";
        	}

            return "<span class='".$class."'>".$list->status."</span>";
        })
        ->rawColumns(['badge'])
        ->make(true);
    }

    public function returnBookForm()
    {
    	$books = Book::all();

    	$users = User::where('type','Student')->get();

    	return view('returnbookform',compact('books','users'));
    }

    public function getLogInfo(request $request)
    {
    	$list = Book::join(DB::raw('(SELECT Max(id) as maxid, bookId FROM book_logs GROUP BY bookId) as max'),'max.bookId','books.id')
        ->join('book_logs','book_logs.id','=','max.maxid')
        ->select('book_logs.id','book_logs.bookId','userId','start_date','end_date')
        ->where('book_logs.bookId',$request->bookId)
        ->where('book_logs.userId',$request->userId)
        ->where('status','Borrow')
        ->first();

        $fine = BookLog::where('userId',$request->userId)->where('paid',0)->sum('fine');

        return response()->json(compact('fine','list'));
    }

    public function payFine($id)
    {
    	$logs = BookLog::where('userId',$id)->get();

    	foreach($logs as $log)
    	{
    		Booklog::find($log->id)->update(['paid' => $log->fine]);
    	}
    }

    public function update(Request $request)
    {
        $me = (new CommonController)->thisuser();

        if($request->type == "Pay")
        {
        	$this->payFine($request->userId);
        	return 1;
        }

        if($request->type == "Renew")
        {
        	$status = "Borrow";
        }
        else
        {
        	$status = "Returned";
        }

        $request->merge(['status' => $status]);

        //Validator
        $rules = [
            'bookId' => 'required',
            'userId' => 'required|checkPenalty'
        ];

        // $penalty = BookLog::where('userId',$request->userId)->where('paid',0)->sum('fine');

        $message = [
            'bookId.required' => 'Book field is required',
            'userId.required' => 'Student field is required',
            'userId.check_penalty' => "The student has unpaid fine"
        ];


        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 404);
        }

        $request->merge(['start_date' => date('Y-m-d') , 'end_date' => date('Y-m-d',strtotime('today + 7 days'))]);

        BookLog::create($request->except('id','_token'));
    }

    public function bookForm($id)
    {
    	$me = (new CommonController)->thisuser();
    	$book = Book::find($id);

    	return view('bookForm',compact('me','id','book'));
    }

    public function submitBookForm(Request $request)
    {
    	$me = (new CommonController)->thisuser();

    	$created = BookLog::create($request->except('_token'));

    	$detail = BookLog::where('book_logs.id',$created->id)->join('books','books.id','=','book_logs.bookId')->join('users','users.id','=','book_logs.userId')->first();

    	Mail::send('emails.bookissue', compact('detail'), function($message) use ($detail)
        { 
                $message->to($detail->email)->subject("You’ve issued a book on ".date('Y-m-d'));
        });

        return view('layouts.success');
    }
}