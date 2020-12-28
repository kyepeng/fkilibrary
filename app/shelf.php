<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shelf extends Model
{
    protected $fillable = ['shelf','row','column','displayName'];
}
