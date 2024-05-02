<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\VisiController;
use App\Http\Controllers\MisiController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\GlobalTrendController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\OrientationValueController;
use App\Http\Controllers\ClientPartnerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\BeritaController;

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
        Route::get('get-about', [AboutController::class,'getAbout']);
        Route::post('create-about', [AboutController::class,'createAbout']);
        Route::post('update-about/{id}', [AboutController::class,'updateAbout']);
        Route::delete('delete-about/{id}', [AboutController::class,'deleteAbout']);

        Route::get('get-visi', [VisiController::class,'getVisi']);
        Route::post('create-visi', [VisiController::class,'createVisi']);
        Route::post('update-visi', [VisiController::class,'updateVisi']);
        Route::post('delete-visi', [VisiController::class,'deleteVisi']);

        Route::get('get-misi', [MisiController::class,'getMisi']);
        Route::post('create-misi', [MisiController::class,'createMisi']);
        Route::post('update-misi/{id}', [MisiController::class,'updateMisi']);
        Route::delete('delete-misi/{id}', [MisiController::class,'deleteMisi']);

        Route::get('get-opportunity', [OpportunityController::class,'listOpportunity']);
        Route::post('create-opportunity', [OpportunityController::class,'createOpportunity']);
        Route::post('update-opportunity/{id}', [OpportunityController::class,'updateOpportunity']);
        Route::delete('delete-opportunity/{id}', [OpportunityController::class,'deleteOpportunity']);
       
        Route::get('get-benefit', [BenefitController::class,'getBenefits']);
        Route::post('create-benefit', [BenefitController::class,'createBenefit']);
        Route::post('update-benefit/{id}', [BenefitController::class,'updateBenefit']);
        Route::delete('delete-benefit/{id}', [BenefitController::class,'deleteBenefit']);


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

        Route::get('list-register', [RegisterController::class,'listRegister']);
        Route::post('update-register/{id}', [RegisterController::class,'updateRegister']);
        Route::delete('delete-register/{id}', [RegisterController::class,'deleteRegister']);


        Route::get('list-service', [ServiceController::class,'listService']);
        Route::post('create-service', [ServiceController::class,'createService']);
        Route::post('update-service/{id}', [ServiceController::class,'updateService']);
        Route::delete('delete-service/{id}', [ServiceController::class,'deleteService']);

        Route::get('list-anggota', [AnggotaController::class,'listAnggota']);
        Route::post('create-anggota', [AnggotaController::class,'createAnggota']);
        Route::post('update-anggota/{id}', [AnggotaController::class,'updateAnggota']);
        Route::delete('delete-anggota/{id}', [AnggotaController::class,'deleteAnggota']);

        Route::get('list-pengurus', [PengurusController::class,'listPengurus']);
        Route::post('create-pengurus', [PengurusController::class,'createPengurus']);
        Route::post('update-pengurus/{id}', [PengurusController::class,'updatePengurus']);
        Route::delete('delete-pengurus/{id}', [PengurusController::class,'deletePengurus']);

        Route::get('get-berita', [BeritaController::class,'listBerita']);
        Route::post('create-berita', [BeritaController::class,'createBerita']);
        Route::post('update-berita/{id}', [BeritaController::class,'updateBerita']);
        Route::delete('delete-berita/{id}', [BeritaController::class,'deleteBerita']);
      });
      
    });
  });
  
  Route::post('insert-register', [RegisterController::class,'insertRegister']);
Route::get('list-profile', [GlobalTrendController::class,'dataProfile']);