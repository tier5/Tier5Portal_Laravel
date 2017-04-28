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

Route::get('/showevents',['uses'=>'AdminController@showalleventsview','as'=>'showalleventsView']);


Route::get('/addevents',['uses'=>'AdminController@addeventview','as'=>'addeventView']);

Route::post('/addevent',['uses'=>'AdminController@addevent','as'=>'addEvent']);

Route::post('/deleteevent',['uses'=>'AdminController@deleteevent','as'=>'deleteEvent']);

Route::post('/insertemployeedetails',['uses'=>'AdminController@insertemployeedetails','as'=>'insertemployeeDetails']);

Route::get('/addnotices',['uses'=>'AdminController@addnoticeview','as'=>'addnoticeView']);

Route::post('/addnotice',['uses'=>'AdminController@addnotice','as'=>'addNotice']);

Route::get('/shownotices',['uses'=>'AdminController@shownotices','as'=>'shownoticesView']);

Route::post('/changestatusnotice',['uses'=>'AdminController@changestatusnotice','as'=>'changestatusNotice']);

Route::post('/deletenotice',['uses'=>'AdminController@deletenotice','as'=>'deleteNotice']);

Route::post('/fetchnoticedetails',['uses'=>'AdminController@fetchnoticedetails','as'=>'fetchnoticeDetails']);

Route::post('/editnotice',['uses'=>'AdminController@editnotice','as'=>'editNotice']);

Route::get('/managebadges',['uses'=>'AdminController@managebadges','as'=>'managebadgesView']);

Route::post('/addbadges',['uses'=>'AdminController@addbadges','as'=>'addBadges']);

Route::post('/changestatusbadge',['uses'=>'AdminController@changestatusbadge','as'=>'changestatusBadge']);

Route::post('/deletebadge',['uses'=>'AdminController@deletebadge','as'=>'deleteBadge']);

Route::get('/managebreak',['uses'=>'AdminController@managebreak','as'=>'manageBreak']);

Route::post('/fetchbadgedetails',['uses'=>'AdminController@fetchbadgedetails','as'=>'fetchbadgeDetails']);

Route::post('/editbadge',['uses'=>'AdminController@editbadge','as'=>'editBadge']);

Route::get('/employeeofthemonth',['uses'=>'AdminController@employeeofthemonth','as'=>'employeeofthemonthView']);

Route::post('/addemployeeofthemonth',['uses'=>'AdminController@addemployeeofthemonth','as'=>'addemployeeoftheMonth']);

Route::get('/manageclockinclockout',['uses'=>'AdminController@manageclockinclockoutview','as'=>'manageclockinclockoutView']);

Route::post('/changestatusbreaks',['uses'=>'AdminController@changestatusbreaks','as'=>'changestatusBreaks']);

Route::post('/fetchbreakdetails',['uses'=>'AdminController@fetchbreakdetails','as'=>'fetchbreakDetails']);

Route::post('/editbreaks',['uses'=>'AdminController@editbreaks','as'=>'editBreaks']);

Route::post('/addshift',['uses'=>'AdminController@addshift','as'=>'addShift']);

Route::get('/addholidays',['uses'=>'AdminController@addholidayview','as'=>'addholidayView']);

Route::post('/addholiday',['uses'=>'AdminController@addholiday','as'=>'addHoliday']);

Route::get('/showallholidays',['uses'=>'AdminController@showallholidayview','as'=>'showallholidayView']);

Route::post('/showallholidays',['uses'=>'AdminController@showallholidays','as'=>'showallHolidays']);

Route::post('/deleteholiday',['uses'=>'AdminController@deleteholiday','as'=>'deleteHoliday']);

Route::post('/fetchholidaydetails',['uses'=>'AdminController@fetchholidaydetails','as'=>'fetchholidayDetails']);

Route::post('/editholiday',['uses'=>'AdminController@editholiday','as'=>'editHoliday']);

Route::get('/specialholiday',['uses'=>'AdminController@specialholidayview','as'=>'specialholidayView']);

Route::post('/addspecialholiday',['uses'=>'AdminController@addspecialholiday','as'=>'addspecialHoliday']);

Route::post('/deletespholiday',['uses'=>'AdminController@deletespholiday','as'=>'deletespHoliday']);

Route::post('/newusersetattendence',['uses'=>'AdminController@newusersetattendence','as'=>'newusersetAttendence']);

Route::get('/expenditureonattendence',['uses'=>'AdminController@expenditureonattendenceview','as'=>'expenditureonattendenceView']);

Route::post('/attendenceexpenditure',['uses'=>'AdminController@attendenceexpenditure','as'=>'attendenceExpenditure']);

Route::get('/pointshistory',['uses'=>'AdminController@pointshistoryview','as'=>'pointshistoryView']);


Route::post('/allpoints',['uses'=>'AdminController@allpoints','as'=>'allPoints']);

Route::post('/getpointinfo',['uses'=>'AdminController@getpointinfo','as'=>'getpointInfo']);

Route::get('/adddeductpoints',['uses'=>'AdminController@adddeductpointsview','as'=>'adddeductpointsView']);

Route::post('/adddeductpoints',['uses'=>'AdminController@adddeductpoints','as'=>'adddeductPoints']);




Route::get('/logout',['uses'=>'AdminController@logout','as'=>'adminLogout']);

});