<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;

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