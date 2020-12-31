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
use App\Reserve;

class BookLogController extends Controller
{
    public function index(Request $request)
    {	
        $me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();

        $id = $request->id ?: 0;

        $list = DB::table('book_logs')
        ->select(DB::raw('"" as no'),DB::raw('"" as ISBN'),'id','bookId','userId','start_date','end_date','fine','paid','status')
        ->get();

        $users = User::where('type','Student')->get();

        $books = Book::all();

        return view('booklogs',compact('me','list','users','books','id','allcatalog'));
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
        ->join(DB::raw('(SELECT Max(id) as maxid, bookId FROM book_logs GROUP BY bookId) as max'),'max.maxid','book_logs.id')
        // ->join('book_logs','book_logs.id','=','max.maxid')
        ->select('book_logs.id','book_logs.bookId','userId','start_date','end_date','fine','paid','status')
        ->whereRaw($cond)
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->addColumn('book', function($list){
            $book = Book::find($list->bookId);
            return "$book->bookName";
        })
        ->addColumn('ISBN',function($list){
            $book = Book::find($list->bookId);
            return "$book->ISBN";
        })
        ->addColumn('student', function($list){
            $user = User::find($list->userId);
            return $user->matric;
        })
        ->addColumn('badge', function($list){
        	$class = "badge badge-success";
        	if($list->status == "Borrow" && (date('Y-m-d') <= $list->end_date) )
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
        $me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();

    	$books = Book::all();

    	$users = User::where('type','Student')->get();

    	return view('returnbookform',compact('me','books','users','allcatalog'));
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

        $created = BookLog::create($request->except('id','_token'));

        $this->sendEmail($created,$request->type);

    }

    public function bookForm($id,$type)
    {
    	$me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();

    	$book = Book::find($id);

        if($me->type == "Admin")
        {
    	   return view('bookForm',compact('me','id','book','type','allcatalog'));
        }
        else
        {
            return redirect('home');
        }
    }

    public function submitBookForm(Request $request)
    {
    	$me = (new CommonController)->thisuser();

        if($request->status == "Borrow")
        {
            if($request->id)
            {
                Reserve::find($request->id)->update(['checked'=>1]);
            }

    	   $created = BookLog::create($request->except('_token','id'));
    	   $this->sendEmail($created,'Issue');
           return view('layouts.success');
        }
        else
        {
            Reserve::create($request->only('bookId','userId'));
            return redirect('reservelist');
        }

    }

    public function sendEmail($created,$type)
    {   

        $text = "issued";
        $blade = "emails.bookissue";
        if($type == "Return")
        {
            $text = "returned";
            $blade = "emails.update";
        }
        else if($type == "Renew")
        {
            $text = "renew";
            $blade = "emails.update"; 
        }
        $title = "You’ve ".$text." a book on ".date('Y-m-d');

        $detail = BookLog::where('book_logs.id',$created->id)->join('books','books.id','=','book_logs.bookId')->join('users','users.id','=','book_logs.userId')->first();

        $fine = BookLog::where('userId',$detail->userId)
        ->where('bookId',$detail->bookId)
        ->where('Id','<>',$created->id)
        ->where('status','Borrow')
        ->orderBy('id','DESC')
        ->first();

        Mail::send($blade, compact('detail','type','fine'), function($message) use ($detail,$title)
        { 
                $message->to($detail->email)->subject($title);
        });
    }
}