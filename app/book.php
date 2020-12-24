<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    protected $fillable = ['bookName','ISBN','description','price','quantity','shelfId','catalogId'];

}
