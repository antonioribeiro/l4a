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
	return View::make('views.home');
});

Route::get('/billet/{customer}/{invoice}/{hash}',array('as'=>'billet', 'uses'=>'BankingController@showBillet'));

Route::get('/billing',array('as'=>'billing', 'uses'=>'BillingController@index'));

