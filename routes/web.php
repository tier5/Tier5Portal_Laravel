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

Route::get('/activeuserinfo',['uses'=>'AdminController@activeuserinfo','as'=>'activeuserInfo']);

Route::get('/allemployeedetails',['uses'=>'AdminController@allemployeeinfo','as'=>'allemployeeInfo']);

Route::post('/createuser',['uses'=>'AdminController@createuser','as'=>'createUser']);

Route::post('/vieweditactiveemployeedetails',['uses'=>'AdminController@vieweditactiveemployeedetails','as'=>'vieweditactiveemployeeDetails']);

Route::post('/editactiveemployeedetails',['uses'=>'AdminController@editactiveemployeedetails','as'=>'editactiveemployeeDetails']);

Route::post('/changeemployeepassword',['uses'=>'AdminController@changeemployeePassword','as'=>'changeemployeePassword']);

Route::post('/changeemployeeavailability',['uses'=>'AdminController@changeemployeeavailability','as'=>'changeemployeeAvailability']);

Route::get('/editemployeedetails/{id}',['uses'=>'AdminController@editemployeedetails','as'=>'editemployeeDetails']);

Route::post('/changeemployeedetails',['uses'=>'AdminController@changeemployeedetails','as'=>'changeemployeeDetails']);

Route::get('/showallevents',['uses'=>'AdminController@showalleventsview','as'=>'showalleventsView']);


Route::get('/addevents',['uses'=>'AdminController@addeventview','as'=>'addeventView']);

Route::post('/addevent',['uses'=>'AdminController@addevent','as'=>'addEvent']);

Route::post('/deleteevent',['uses'=>'AdminController@deleteevent','as'=>'deleteEvent']);

Route::post('/insertemployeedetails',['uses'=>'AdminController@insertemployeedetails','as'=>'insertemployeeDetails']);

Route::get('/logout',['uses'=>'AdminController@logout','as'=>'adminLogout']);

});