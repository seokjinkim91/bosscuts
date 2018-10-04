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


/* 
|--------------------------------------------------------------------------
| Main Page Controller 
|--------------------------------------------------------------------------
*/

Route::get('/', 'MainController@index')->name('index');

Route::get('/booking', 'MainController@booking')->name('booking'); 
Route::get('/bookingDate/{date}', 'MainController@bookingDate');

Route::get('bookingServices/{empid}','MainController@bookingServices');
Route::post('bookingSubmit/{userid}/{datetimeid}/{service}/{email}/{contact}/{name}','MainController@bookingSubmit');

Route::get('/career', 'MainController@career')->name('career'); 
Route::post('/career','MainController@careersubmit');




/* 
|--------------------------------------------------------------------------
| Admin Page Controller 
|--------------------------------------------------------------------------
*/

Auth::routes(); // Laravel Login variables 
Route::get('/admin', 'AdminController@index')->name('admin');
Route::post('/admin', 'AdminController@index');


//Save, Enable, Disable users_datetimes 
Route::post('/admin/schedule/save', 'AdminController@saveSchedule');
Route::post('/admin/schedule/enable', 'AdminController@enableSchedule');
Route::post('/admin/schedule/disable', 'AdminController@disableSchedule');



Route::get('/admin/bookings', 'AdminController@getBooking');
//Route::get('/admin/bookings/{tab}','AdminController@getBookings')->name('getBookings');
Route::get('/admin/bookingDate/{date}', 'MainController@bookingDate');
Route::get('/admin/bookingServices/{empid}','MainController@bookingServices');

Route::get('/admin/bookings/{bookingid}/{status}', 'AdminController@updateBookings')->name('updateBookings');
Route::post('/admin/bookings/insertBooking','AdminController@insertBooking');
Route::get('/admin/bookings/{bookingid}', 'AdminController@deleteBookings')->name('deleteBookings');

Route::get('/admin/profile', 'AdminController@profile'); 
Route::post('/admin/profile','AdminController@addProfile');

Route::get('/admin/services', 'AdminController@services'); 
Route::get('/admin/applicants', 'AdminController@applicants');
Route::get('/admin/users', 'AdminController@users')->name('users');
Route::get('/admin/users/{userid}', 'AdminController@userstatus')->name('userstatus');
Route::post('/admin/users','AdminController@updateUsers');
Route::post('/admin/users/add','AdminController@addUsers');

Route::post('/admin/services','AdminController@editService');
Route::delete('/admin/services','AdminController@deleteService');
Route::delete('/admin/applicants','AdminController@deleteApplicants');
Route::get('/admin/applicants/{filename}','AdminController@downloadApplicant');


/* 
|--------------------------------------------------------------------------
| Database Seed Controller 
|--------------------------------------------------------------------------
*/

Route::get('/db/insertall', 'DBSeedController@insertAll');
Route::get('/db/insertusers', 'DBSeedController@insertUsers');
Route::get('/db/insertapplicants', 'DBSeedController@insertApplicants');
Route::get('/db/insertservices', 'DBSeedController@insertServices');
Route::get('/db/insertdatetimes', 'DBSeedController@insertDatetimes');
Route::get('/db/insertbookings', 'DBSeedController@insertBookings');
Route::get('/db/insertusersdatetimes', 'DBSeedController@insertUsersDatetimes');
Route::get('/db/insertusersservices', 'DBSeedController@insertUsersServices');

Route::get('/db/truncateall', 'DBSeedController@truncateAll');
Route::get('/db/truncateusers', 'DBSeedController@truncateUsers');
Route::get('/db/truncateapplicants', 'DBSeedController@truncateApplicants');
Route::get('/db/truncateservices', 'DBSeedController@truncateServices');
Route::get('/db/truncatedatetimes', 'DBSeedController@truncateDatetimes');
Route::get('/db/truncatebookings', 'DBSeedController@truncateBookings');
Route::get('/db/truncateusersdatetimes', 'DBSeedController@truncateUsersDatetimes');
Route::get('/db/truncateusersservices', 'DBSeedController@truncateUsersServices');


/*
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
*/
