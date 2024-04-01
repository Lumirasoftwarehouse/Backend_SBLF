<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GlobalTrendController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\OrientationValueController;
use App\Http\Controllers\ClientPartnerController;

Route::group([
    'prefix' => 'auth'
  ], function () {
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::group([
      'middleware' => 'auth:api'
    ], function(){
      Route::post('logout', [AuthController::class,'logout']);
      Route::post('refresh', [AuthController::class, 'refresh']);
      Route::get('me', [AuthController::class,'me']);
      
      Route::group([
        'middleware' => 'auth:api'
      ], function () {
        Route::get('list-trend', [GlobalTrendController::class,'listGlobalTrend']);
        Route::post('create-trend', [GlobalTrendController::class,'createGlobalTrend']);
        Route::post('update-trend/{id}', [GlobalTrendController::class,'updateGlobalTrend']);
        Route::delete('delete-trend/{id}', [GlobalTrendController::class,'deleteGlobalTrend']);
        
        Route::get('get-quote', [QuoteController::class,'getQuote']);
        Route::post('create-quote', [QuoteController::class,'makeQuote']);

        Route::get('list-orientation', [OrientationValueController::class,'listOrientationValue']);
        Route::post('create-orientation', [OrientationValueController::class,'createOrientationValue']);
        Route::post('update-orientation/{id}', [OrientationValueController::class,'updateOrientationValue']);
        Route::delete('delete-orientation/{id}', [OrientationValueController::class,'deleteOrientationValue']);

        Route::get('list-client', [ClientPartnerController::class,'listClientPartner']);
        Route::post('create-client', [ClientPartnerController::class,'createClientPartner']);
        Route::post('update-client/{id}', [ClientPartnerController::class,'updateClientPartner']);
        Route::delete('delete-client/{id}', [ClientPartnerController::class,'deleteClientPartner']);
      });
      
    });
  });
  
Route::get('list-profile', [GlobalTrendController::class,'dataProfile']);