<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookLog extends Model
{
    protected $fillable = ['bookId','userId','start_date','end_date','fine','paid']; 
}
