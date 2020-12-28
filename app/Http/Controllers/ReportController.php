<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookLog;
use App\Book;
use App\User;
use DB;

class ReportController extends Controller
{
	public function index(Request $request)
	{
     	$me = (new CommonController)->thisuser();

     	//default show today
     	$cond = "CAST(created_at as date) = CURDATE()";
     	$cond = "CAST(updated_at as date) = CURDATE()";

     	if($request->year)
     	{
     		$cond = "YEAR(created_at) =".$request->year;
     		$cond2 = "YEAR(updated_at) =".$request->year;
     	}

     	if($request->month)
     	{
     		$cond = "MONTH(created_at) =".$request->month;
     		$cond2 = "MONTH(updated_at) =".$request->month;
     	}

     	if($request->day)
     	{
     		$cond = "CAST(created_at as date) =".$request->day;
     		$cond2 = "CAST(updated_at as date) =".$request->day;
     	}

        $issue = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->where('status','Borrow')
        ->whereRaw($cond)
        ->first();

        $return = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->where('status','Returned')
        ->whereRaw($cond)
        ->first();

        $nonreturn = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->whereRaw('end_date < CURDATE()')
        ->where('status','Borrow')
        ->whereRaw($cond)
        ->first();

        $fine = BookLog::whereRaw($cond)->sum('paid') ?: -1;
        
        $booktitle = ['Issued','Returned','Non-Return'];
        $bookdata = [];
        $bookdata[0] = $issue->count;
        $bookdata[1] = $return->count;
        $bookdata[2] = $nonreturn->count;

        return view('report',compact('me','booktitle','bookdata','fine'));
	}
}
