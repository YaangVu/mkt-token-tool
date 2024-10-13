<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $client = \App\Models\Client::find(6);
//    dd($client->password, password_verify('1234567', $client->password));
    dd(\Illuminate\Support\Facades\Hash::check(1, $client->password));
    dd(\Illuminate\Support\Facades\Crypt::decrypt($client->password));
    return view('welcome');
});
