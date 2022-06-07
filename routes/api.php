<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Public Routes 


// Protected Routes 
Route::group(['middleware' => ['auth:sanctum']], function () {


    // CUstomer
    Route::post('/upload/customers/{id}',[CustomerController::class, 'uploadCustomers']);
    Route::get('customers/{id}',[CustomerController::class, 'customers']);
    Route::post('sms/send/{id}',[CustomerController::class, 'sendSMS']);
  
});

