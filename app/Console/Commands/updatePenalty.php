<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BookLog;

class updatePenalty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatePenalty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Penalty';

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
        //check overdue
        $expired = Booklog::select(DB::raw('DATEDIFF(CURDATE(),end_date) as expired_day'),'id','fine')
        ->where('end_date','<',date('Y-m-d'))
        ->get();

        foreach($expired as $exp)
        {
            Booklog::find($exp->id)
            ->update([
                'fine' => 0.2 * $exp->expired_day
            ]);
        }
    }
}
