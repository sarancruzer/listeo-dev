<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::group(["middleware"=>"cors"], function(){

			Route::post('authenticate', 'AuthenticateController@authenticate');

	// ----------------------------------
			Route::post('getAmenities', 'MasterController@getAmenities');
			Route::post('getCategory', 'MasterController@getCategory');
			Route::post('getCity', 'MasterController@getCity');
			Route::post('getState', 'MasterController@getState');
			Route::post('getTime', 'MasterController@getTime');
			Route::post('getWeekdays', 'MasterController@getWeekdays');

			Route::post('submitMasterAmenities', 'MasterController@submitMasterAmenities');	
			Route::post('submitMasterCategory', 'MasterController@submitMasterCategory');	
			Route::post('submitMasterCity', 'MasterController@submitMasterCity');	
			Route::post('submitMasterState', 'MasterController@submitMasterState');	
			Route::post('submitMasterTime', 'MasterController@submitMasterTime');	
			Route::post('submitMasterWeekdays', 'MasterController@submitMasterWeekdays');	

			Route::post('getMasterDetails', 'MasterController@getMasterDetails');	

			Route::post('getListing', 'ListingController@index');		
			Route::post('addListing', 'ListingController@create');		
			Route::post('editListing', 'ListingController@edit');		
			Route::post('updateListing', 'ListingController@update');		
			Route::post('viewListing', 'ListingController@show');		
			Route::post('deleteListing', 'ListingController@delete');		

			

Route::group(["middleware"=>"jwt.auth"], function(){


			

		
});

});