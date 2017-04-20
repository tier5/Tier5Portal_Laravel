<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',['uses'=>'UserController@index','as'=>'login_page']);

Route::post('/login',['uses'=>'UserController@login','as'=>'authenticate']);



Route::group(['prefix'=>'admin'],function(){

Route::get('/home',['uses'=>'AdminController@index','as'=>'adminDashboard']);

Route::get('/addemployee',['uses'=>'AdminController@addemployeeindex','as'=>'addEmployee']);

Route::get('/adduser',['uses'=>'AdminController@adduserindex','as'=>'addUser']);

Route::post('/insertemployeedetails',['uses'=>'AdminController@insertemployeedetails','as'=>'insertemployeeDetails']);

Route::get('/logout',['uses'=>'AdminController@logout','as'=>'adminLogout']);

});