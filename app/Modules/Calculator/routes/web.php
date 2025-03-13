<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CalculatorController@index')->name('calculator.index');
Route::post('calculator', 'CalculatorController@calculator')->name('calculator.calculator');
