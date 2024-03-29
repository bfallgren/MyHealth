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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('myHealth', 'HealthController');
Route::resource('patient', 'PatientController');
Route::resource('doctor', 'DoctorController');
Route::resource('surgery', 'SurgeryController');
Route::resource('meds', 'MedController');
Route::resource('fam', 'FamhistController');
Route::resource('imaging', 'ImageController');
Route::resource('lab', 'LabController');
Route::resource('labtmpl', 'LabtemplateController');
Route::resource('vaccine', 'VaccineController');

/* THE FOLLOWING ARE USED FOR ALIAS IN APPS.BLADE.PHP */
Route::get('fetchWellness', 'HealthController@fetchData'); /* wellness search Route */
Route::get('myHealth', array('as' => 'wellness', 'uses' => 'HealthController@index'));
Route::get('doctor', array('as' => 'mydoc', 'uses' => 'DoctorController@index'));
Route::get('patient', array('as' => 'member', 'uses' => 'PatientController@index'));
Route::get('surgery', array('as' => 'mysurgery', 'uses' => 'SurgeryController@index'));
Route::get('lab',array('as' => 'mylab', 'uses' =>'LabController@index'));
Route::get('labtmpl',array('as' => 'template', 'uses' =>'LabtemplateController@index'));
Route::get('labdel',array('as' => 'labdelall', 'uses' =>'LabtemplateController@deleteall'));
Route::get('labadd',array('as' => 'labaddall', 'uses' =>'LabtemplateController@storeall'));
Route::get('labtmpldate',array('as' => 'labtmplmoddate', 'uses' =>'LabtemplateController@moddate'));
Route::get('vaccine',array('as' => 'myshots', 'uses' =>'VaccineController@index'));
Route::get('meds', array('as' => 'mymeds', 'uses' => 'MedController@index'));
Route::get('fam', array('as' => 'myfam', 'uses' => 'FamhistController@index'));
Route::get('imaging', array('as' => 'myimaging', 'uses' => 'ImageController@index'));

/* THE FOLLOWING IS USED TO POPULATE DOCTOR SPECIALTY */
Route::get('surgery/getSpecs/{id}', 'SurgeryController@getSpecs');
Route::get('myHealth/getSpecs/{id}', 'HealthController@getSpecs');
Route::get('imaging/getSpecs/{id}', 'ImageController@getSpecs');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
