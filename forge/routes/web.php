<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employeeProfile', function (){
    return view('employeeProfile');
});