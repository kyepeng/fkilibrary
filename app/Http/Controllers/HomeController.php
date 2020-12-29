<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookLog;
use App\Book;
use App\User;
use App\Catalog;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $me = (new CommonController)->thisuser();

        $popular = BookLog::select(DB::raw('count(*) as count'),'books.bookName')
        ->join('books','books.id','=','book_logs.bookId')
        ->where('status','Borrow')
        ->GroupBy('bookId')
        ->limit(10)
        ->orderBy(DB::raw('count(*)'),"DESC")
        ->get();

        $populartitle = [];
        $populardata = [];
        foreach($popular as $pop)
        {
           array_push($populartitle, $pop->bookName);
           array_push($populardata, $pop->count);
        }

        $active = BookLog::select(DB::raw('count(*) as count'),'users.year')
        ->join('users','users.id','=','book_logs.userId')
        ->where('status','Borrow')
        ->GroupBy('users.year')
        ->get();

        $activetitle = ['Year 1','Year 2','Year 3','Year 4'];
        $activedata = [0,0,0,0];
        foreach($active as $act)
        {
           $activedata[$act->year-1] = $act->count;
        }

        $students = User::where('type','Student')
        ->select('year',DB::raw('count(*) as count'))
        ->GroupBy('year')
        ->get();

        $studenttitle = ["Year 1","Year 2","Year 3","Year 4"];
        $studentdata = [0,0,0,0];
        foreach($students as $student)
        {
            $studentdata[$student->year-1] = $student->count;
        }

        $issue = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->where('start_date',date('Y-m-d'))
        ->where('status','Borrow')
        ->first();

        $return = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->where(DB::raw('CAST(created_at as date)'),date('Y-m-d'))
        ->where('status','Returned')
        ->first();

        $nonreturn = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->whereRaw('end_date < CURDATE()')
        ->where('status','Borrow')
        ->first();

        $fine = BookLog::whereRaw('CAST(updated_at as date) = CURDATE()')
        ->sum('paid') ?: -1;
        
        $booktitle = ['Issued','Returned','Non-Return'];
        $bookdata = [];
        $bookdata[0] = $issue->count;
        $bookdata[1] = $return->count;
        $bookdata[2] = $nonreturn->count;

        $allcatalog = Catalog::all();

        return view('home',compact('me','populartitle','populardata','activetitle','activedata','studenttitle','studentdata','booktitle','bookdata','fine','allcatalog'));
    }

    public function main()
    {
        $me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();

        $catalog = Catalog::all()->chunk(4);
        $book = Book::all()->chunk(4);

        return view('main',compact('me','catalog','book','allcatalog'));
    }

    public function about()
    {
        $me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();   
        return view('about',compact('me','allcatalog'));
    }
}
