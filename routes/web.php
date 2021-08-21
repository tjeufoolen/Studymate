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

# Global
Auth::routes();
Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('login.github');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');
Route::get('/', 'HomeController@index')->name("home");
Route::get('qrcode/{student}', 'HomeController@qrcode')->name("qrcode");

# Students
Route::resource('students', 'StudentController');
Route::get('students/tests/{student}', 'StudentTestController@index')->name('students.tests.index');
Route::post('students/tests/{student}/{lecture}', 'StudentTestController@update')->name('students.tests.update');
Route::post('students/tests/{student}/{lecture}/grade', 'StudentTestController@grade')->name('students.tests.grade');

# Modules
Route::resource('modules', 'ModuleController');
Route::get('modules/enroll/{module}', 'ModuleController@enrollIndex')->name('enroll.index');
Route::put('modules/enroll/{student}/{lecture}', 'ModuleController@enroll')->name('enroll.update');
Route::put('modules/disenroll/{student}/{lecture}', 'ModuleController@disenroll')->name('disenroll.update');

# Teachers
Route::resource('teachers', 'TeacherController');

# Deadlines
Route::get('deadlines', 'DeadlineController@deadlines')->name('deadlines.deadlines');
Route::get('nodeadlines', 'DeadlineController@nodeadlines')->name('deadlines.nodeadlines');
Route::get('deadlines/{module}/create', 'DeadlineController@create')->name('deadlines.create');
Route::post('deadlines/{module}', 'DeadlineController@store')->name('deadlines.store');
