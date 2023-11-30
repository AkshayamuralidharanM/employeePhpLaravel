<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('employees',[EmployeeController::class,'index']);
Route::get('fetch-students',[EmployeeController::class,'fetchstudent']);

Route::post('employees',[EmployeeController::class,'store']);

Route::get('edit-employee/{id}',[EmployeeController::class,'edit']);

Route::put('update-employee/{id}',[EmployeeController::class,'update']);

Route::delete('delete-employee/{id}',[EmployeeController::class,'destroy']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();