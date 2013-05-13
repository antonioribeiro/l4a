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
	return Redirect::to('http://www.cys.com.br');
});

Route::get('/billet/{customer}/{invoice}/{hash}',array('as'=>'billet', 'uses'=>'BankingController@showBillet'));

Route::get('/billet/{customer}/{invoice}/{hash}/send',array('as'=>'sendBillet', 'uses'=>'BillingController@sendBillet'));

Route::get('/billing',array('as'=>'billingGET', 'uses'=>'BillingController@index'));
Route::post('/billing',array('as'=>'billingPOST', 'uses'=>'BillingController@index'));
Route::get('/billing/filter/{date}',array('as'=>'billingFilter', 'uses'=>'BillingController@filter'));

Route::post('/billing/send',array('as'=>'sendBills', 'uses'=>'BillingController@sendBills'));

Route::get('/billing/buildFile',array('as'=>'buildFile', 'uses'=>'BillingController@buildFile'));

