<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers;

$router->get('/', function () use ($router) {
	return array(
		'status' => 200,
		'message' => 'success',
		'using' => $router->app->version()
	);
});


$router->group(['prefix' => 'boards'], function() use($router) {
	$router->get('/', "BoardController@list");
	$router->get('/{id}', "BoardController@details");
	$router->post('/', "BoardController@new");
	$router->put('/{id}', "BoardController@undone");
	$router->delete('/{id}', "BoardController@done");
});

$router->group(['prefix' => 'cards'], function() use($router) {
	$router->get('/', "CardController@list");
	$router->get('/{id}', "CardController@details");
	$router->post('/', "CardController@new");
	$router->put('/{id}/move', "CardController@move");
	$router->put('/{id}', "CardController@undone");
	$router->delete('/{id}', "CardController@done");
});
// $router->post('/cards/new', "CardController@new");
// $router->post('/cards/{id}/done', "CardController@done");