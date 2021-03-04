<?php

use Illuminate\Support\Facades\Route;
use App\Models\PlayingCard;

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

Route::get('/', function () {
    return view('welcome', ['cards' => PlayingCard::get()]);
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:sanctum', 'verified']], function() {

	Route::get('/', function () {
	    return view('dashboard');
	})->name('dashboard');

	Route::get('/play', function() {
		return view('play', ['cards' => PlayingCard::inRandomOrder()->get()]);
	})->name('play');

});
