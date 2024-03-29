<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookLog;
use App\Book;
use App\User;
use DB;
use Datatables;
use App\Catalog;

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
        ->whereRaw('end_date > CURDATE()')
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
        ->whereRaw($cond)
        ->first()->count;

        $fine = BookLog::whereRaw($cond2)->sum('paid') > 0 ? BookLog::whereRaw($cond2)->sum('paid') : -1;
        $booktitle = ['Issued','Returned','Non-Return'];
        $bookdata = [];
        $bookdata[0] = $issue;
        $bookdata[1] = $return;
        $bookdata[2] = $nonreturn;

        if(!$issue && !$return && !$nonreturn)
        {
        	$bookdata = [100];
        }

        $allcatalog = Catalog::all();

        return view('report',compact('me','booktitle','bookdata','fine','start','end','allcatalog'));
	}

	public function finereport($start = null, $end = null)
	{
		$me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();
     	if(!$start)
     	{
     		$start = date('Y-m-d',strtotime('today'));
     	}

     	if(!$end)
     	{
     		$end = date('Y-m-d',strtotime('today'));
     	}

     	$list = DB::table('book_logs')
     	->select('id','userId','bookId','start_date','end_date','fine','paid','created_at')
     	->get();

		return view('finereport',compact('me','start','end','list','allcatalog'));
	}

	public function getFineData(Request $request)
	{
		$me = (new CommonController)->thisuser();
     	$student = $me->type == "Student" ? " AND book_logs.userId =".$me->id : "";
     	//default show today
     	$cond = "paid > 0 AND CAST(book_logs.updated_at as date) BETWEEN '".$request->startdate."' AND '".$request->enddate."' ".$student;

        $list = DB::table('book_logs')
        ->leftjoin('books','books.id','=','book_logs.bookId')
        ->leftjoin('users','users.id','=','book_logs.userId')
        ->select('book_logs.id','userId','bookId','start_date','end_date','fine','paid','books.ISBN','books.bookName',DB::raw('IFNULL(matric,"User Deleted") as matric'))
        ->whereRaw($cond)
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
        ->make(true);
	}

	public function logreport($start = null, $end = null)
	{
		$me = (new CommonController)->thisuser();
        $allcatalog = Catalog::all();
     	if(!$start)
     	{
     		$start = date('Y-m-d',strtotime('today'));
     	}

     	if(!$end)
     	{
     		$end = date('Y-m-d',strtotime('today'));
     	}

     	$list = DB::table('book_logs')
     	->select('id','userId','bookId','start_date','end_date','fine','status','created_at')
     	->get();

		return view('logreport',compact('me','start','end','list','allcatalog'));
	}

	public function getLogData(Request $request)
	{
		$me = (new CommonController)->thisuser();
     	$student = $me->type == "Student" ? " AND book_logs.userId =".$me->id : "";
     	//default show today
     	$cond = "CAST(book_logs.created_at as date) BETWEEN '".$request->startdate."' AND '".$request->enddate."' ".$student;

        $list = DB::table('book_logs')
        ->join(DB::raw('(SELECT Max(id) as maxid,bookId FROM book_logs GROUP BY bookId,userId) as max'),'max.maxid','=','book_logs.id')
        ->leftjoin('books','books.id','=','book_logs.bookId')
        ->leftjoin('users','users.id','=','book_logs.userId')
        ->select('book_logs.id','book_logs.userId','book_logs.bookId','start_date','end_date','fine','status','books.ISBN','books.bookName',DB::raw('IFNULL(matric,"User Deleted") as matric'))
        ->whereRaw($cond)
        ->get();

        return Datatables::of($list)
        ->addIndexColumn()
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
}
