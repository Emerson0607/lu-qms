<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = ['w_id','department', 'name', 'number', 'status'];
}
