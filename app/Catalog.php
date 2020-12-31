<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class catalog extends Model
{
    protected $fillable = ['catalogName','catalogDescription','image_path'];
}
