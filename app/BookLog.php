<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class book_log extends Model
{
    protected $fillable = ['bookId','userId','start_date','end_date','fine','paid']; 
}
