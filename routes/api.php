<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/testing',function(){
    return response()->json([
        'status' => 'berhasil',
        'messege' => 'anda berhasil login'
    ],200);
});