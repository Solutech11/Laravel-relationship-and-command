<?php

use App\Models\UserModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $getCache=Cache::get('allUser');

    if($getCache){
        return $getCache;
    }
    
    $user= UserModel::all();

    Cache::add('alluser', $user);//adding cache

    return Cache::get('allUser');
});
