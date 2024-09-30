<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

