<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\BookLog;

class sendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiring = Booklog::where(DB::Raw('DATEDIFF(end_date,CURDATE())'),'<',3)
         ->select('users.email','books.bookName','book_logs.end_date','users.name')
         ->leftjoin('books','books.id','=','book_logs.bookId')
         ->leftjoin('users','users.id','=','book_logs.userId')
         ->get();

         foreach($expiring as $exp)
         {
            Mail::send('emails.expiring', compact('exp'), function($message) use ($exp)
            { 
                    $message->to($exp->email)->subject("FKILibrary Expiring Notice");
            });
         }
    }
}
