<?php

namespace App\Modules\Calculator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calculator extends Model
{
    use HasFactory;

    protected $fillable = ['num1', 'num2', 'operation', 'result'];
}
