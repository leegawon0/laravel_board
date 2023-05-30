<?php

/************************************************
 * 프로젝트명   : laravel_board
 * 디렉토리     : Controllers
 * 파일명       : BoardsController.php
 * 이력         : v001 0530 GW.Lee new
 ************************************************/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

// Boards
Route::resource('/boards', BoardsController::class);

// GET|HEAD        / ......................................................................................................... 
// POST            _ignition/execute-solution .. ignition.executeSolution › Spatie\LaravelIgnition › ExecuteSolutionController  
// GET|HEAD        _ignition/health-check .............. ignition.healthCheck › Spatie\LaravelIgnition › HealthCheckController  
// POST            _ignition/update-config ........... ignition.updateConfig › Spatie\LaravelIgnition › UpdateConfigController  
// GET|HEAD        api/user ..................................................................................................  
// GET|HEAD        boards .............................................................. boards.index › BoardsController@index  
// POST            boards .............................................................. boards.store › BoardsController@store  
// GET|HEAD        boards/create ..................................................... boards.create › BoardsController@create  
// GET|HEAD        boards/{board} ........................................................ boards.show › BoardsController@show  
// PUT|PATCH       boards/{board} .................................................... boards.update › BoardsController@update  
// DELETE          boards/{board} .................................................. boards.destroy › BoardsController@destroy  
// GET|HEAD        boards/{board}/edit ................................................... boards.edit › BoardsController@edit  
// GET|HEAD        sanctum/csrf-cookie ........................................... Laravel\Sanctum › CsrfCookieController@show 

// Users
Route::get('/users/login', [UserController::class, 'login'])->name('users.login');
Route::post('/users/loginpost', [UserController::class, 'loginpost'])->name('users.login.post');
Route::get('/users/registration', [UserController::class, 'registration'])->name('users.registration');
Route::post('/users/registrationpost', [UserController::class, 'registrationpost'])->name('users.registration.post');