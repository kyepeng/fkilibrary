<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookLog;
use App\Book;
use App\User;
use DB;

class ReportController extends Controller
{
	public function index($start = null,$end = null)
	{
     	$me = (new CommonController)->thisuser();

     	if(!$start)
     	{
     		$start = date('Y-m-d',strtotime('today'));
     	}

     	if(!$end)
     	{
     		$end = date('Y-m-d',strtotime('today'));
     	}

     	$student = $me->type == "Student" ? " AND book_logs.userId =".$me->id : "";
     	//default show today
     	$cond = "CAST(created_at as date) BETWEEN '".$start."' AND '".$end."' ".$student;
     	$cond2 = "CAST(updated_at as date) BETWEEN '".$start."' AND '".$end."' ".$student;

        $issue = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->where('status','Borrow')
        ->whereRaw($cond)
        ->first()->count;

        $return = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->where('status','Returned')
        ->whereRaw($cond)
        ->first()->count;

        $nonreturn = BookLog::select(DB::raw('count(*) as count'))
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId,userId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','book_logs.id')
        ->whereRaw('end_date < CURDATE()')
        ->where('status','Borrow')
        ->whereRaw($cond2)
        ->first()->count;

        $fine = BookLog::whereRaw($cond)->sum('paid') ?: -1;
        $booktitle = ['Issued','Returned','Non-Return'];
        $bookdata = [];
        $bookdata[0] = $issue;
        $bookdata[1] = $return;
        $bookdata[2] = $nonreturn;

        if(!$issue && !$return && !$nonreturn)
        {
        	$bookdata = [100];
        }

        return view('report',compact('me','booktitle','bookdata','fine','start','end'));
	}
}
