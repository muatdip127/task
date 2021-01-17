<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/invoices','Controller@get_invoices');
Route::get('/',function(){return view('admin');});
Route::post('/addinvoice','Controller@new_invoice');
Route::get('/payer/{invocelink}','Controller@payer');
Route::get('/getinvoice/{invocelink}','Controller@get_invoice');
Route::post('/pay','Controller@pay');

