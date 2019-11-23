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

Route::resource('MyHealth', 'HealthController');
Route::resource('Patient', 'PatientController');
Route::resource('Doctor', 'DoctorController');
Route::resource('Surgery', 'SurgeryController');
Route::resource('Labs', 'LabController');

/* THE FOLLOWING ARE USED FOR ALIAS IN APPS.BLADE.PHP */
Route::get('MyHealth', array('as' => 'wellness', 'uses' => 'HealthController@index'));
Route::get('Doctor', array('as' => 'mydoc', 'uses' => 'DoctorController@index'));
Route::get('Patient', array('as' => 'member', 'uses' => 'PatientController@index'));
Route::get('Surgery', array('as' => 'mysurgery', 'uses' => 'SurgeryController@index'));
Route::get('Labs', array('as' => 'mylabs', 'uses' => 'LabController@index'));
/* THE FOLLOWING IS USED TO POPULATE DOCTOR SPECIALTY */
Route::get('Surgery/getSpecs/{id}', 'SurgeryController@getSpecs');
Route::get('MyHealth/getSpecs/{id}', 'HealthController@getSpecs');
