<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home.index');
});

Route::get('/directions', function() {
	return View::make('home.directions');
});

Route::post('/directions', function() {
	$origin = Input::get('origin');
	$destination = Input::get('destination');

	$url = "http://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $destination . "&sensor=false";

	$json = json_decode(file_get_contents(str_replace(" ", "%20", $url)), true);
	$result = var_export($json, true);
	//return Redirect::to('/')->withInput()->with('directions', $result);
	return View::make('home.directions', ['directions' => $result]);
});

Route::get('/search', 'DirectionsAPIController@search');

//Route::resource('country', 'CountryController');

Route::get('/country', ['as' => 'country.index', 'uses' => 'CountryController@index']);
Route::post('/country/store', ['as' => 'country.store', 'uses' => 'CountryController@store']);
Route::post('/country/clear', ['as' => 'country.clear', 'uses' => 'CountryController@clear']);
Route::get('/country/all', ['as' => 'country.all', 'uses' => 'CountryController@all']);
Route::delete('/country/{country}', ['as' => 'country.destroy', 'uses' => 'CountryController@destroy']);