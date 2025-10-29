<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employeeProfile', function (){
    return view('employeeProfile');
});

Route::get('/employeeCreation', function (){
    return  view('employeeCreation');
});