<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Tax.php
class Tax extends Model
{
    protected $fillable = ['name', 'description', 'rate', 'threshold'];
}

