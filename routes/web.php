<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-route', function () {
    $name='aziz diab';
    \Illuminate\Support\Facades\Mail::to('abdulazizdiab8@gmail.com')->send(new \App\Mail\MyTestEmail($name));
});
