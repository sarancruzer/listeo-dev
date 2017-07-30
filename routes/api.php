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
			

Route::group(["middleware"=>"jwt.auth"], function(){

			
				

			Route::post('getSupplierList', 'SupplierController@getSupplierList');		
			Route::post('supplierAdd', 'SupplierController@supplierAdd');		
			Route::post('getSupplierById/{id}', 'SupplierController@getSupplierById');
			Route::post('supplierUpdate', 'SupplierController@supplierUpdate');		
			Route::post('supplierDelete', 'SupplierController@supplierDelete');

			Route::post('getProductList', 'ProductController@getProductList');		
			Route::post('productAdd', 'ProductController@productAdd');		
			Route::post('getProductById/{id}', 'ProductController@getProductById');
			Route::post('productUpdate', 'ProductController@productUpdate');		
			Route::post('productDelete', 'ProductController@productDelete');		
			Route::post('getAllSuppliers', 'ProductController@getAllSuppliers');		
			

			
			Route::post('getProductinwardList', 'ProductController@getProductinwardList');	
			Route::post('productinwardAdd', 'ProductController@productinwardAdd');		
			Route::post('getProductinwardById/{id}', 'ProductController@getProductinwardById');
			Route::post('productinwardUpdate', 'ProductController@productinwardUpdate');		
			Route::post('productinwardDelete', 'ProductController@productinwardDelete');	
			Route::post('getAllProducts', 'ProductController@getAllProducts');	
			Route::post('getProductCost', 'ProductController@getProductCost');	
			

			Route::post('productInward', 'ProductController@productInward');	
			Route::post('profile', 'AuthenticateController@profile');	
			Route::post('getProductinwardDetailById', 'ProductController@getProductinwardDetailById');	
			Route::post('getStockList', 'ProductController@getStockList');	
			
			

			
			
			
			
			

		
});

});