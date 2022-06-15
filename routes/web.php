<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\RegisteredUserController;
use App\Models\BukuTamu;

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
    return view('tamu');
});
Route::get('create-data', [BukuTamuController::class, 'create_tamu']);


Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', function(){
        return view('dashboard');
    });
    Route::resource('roles', RoleController::class);
    Route::resource('users', RegisteredUserController::class);
    Route::resource('buku-tamu', BukuTamuController::class);
    Route::get('/excel', function(){return BukuTamu::excel();});
});

require __DIR__.'/auth.php';
