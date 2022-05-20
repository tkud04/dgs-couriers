<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;

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

Route::get('/', [MainController::class,'getIndex']);


//Authentication
Route::get('login', [LoginController::class,'getLogin']);
Route::get('signup', [LoginController::class,'getSignup']);
Route::post('login', [LoginController::class,'postLogin']);
Route::post('signup', [LoginController::class,'postSignup']);
Route::get('bye', [LoginController::class,'getLogout']);

//Dashboard
Route::get('dashboard', [MainController::class,'getDashboard']);
Route::get('profile', [MainController::class,'getProfile']);
Route::post('profile', [MainController::class,'postProfile']);

//Classes and Subjects
Route::get('classes', [MainController::class,'getClasses']);
Route::get('class', [MainController::class,'getSingleClass']);
Route::get('subjects', [MainController::class,'getSubjects']);
Route::get('subject', [MainController::class,'getSubject']);
Route::get('topics', [MainController::class,'getTopics']);
Route::get('topic', [MainController::class,'getTopic']);

//Teachers
Route::get('new-class', [MainController::class,'getNewClass']);
Route::post('new-class', [MainController::class,'postNewClass']);
Route::get('edit-class', [MainController::class,'getEditClass']);
Route::post('edit-class', [MainController::class,'postEditClass']);
Route::get('remove-class', [MainController::class,'getRemoveClass']);
Route::get('new-subject', [MainController::class,'getNewSubject']);
Route::post('new-subject', [MainController::class,'postNewSubject']);
Route::get('edit-subject', [MainController::class,'getEditSubject']);
Route::post('edit-subject', [MainController::class,'postEditSubject']);
Route::get('remove-subject', [MainController::class,'getRemoveSubject']);
Route::get('new-topic', [MainController::class,'getNewTopic']);
Route::post('new-topic', [MainController::class,'postNewTopic']);
Route::get('edit-topic', [MainController::class,'getEditTopic']);
Route::post('edit-topic', [MainController::class,'postEditTopic']);
Route::get('remove-topic', [MainController::class,'getRemoveTopic']);
Route::get('add-student', [MainController::class,'getAddStudent']);
Route::post('add-student', [MainController::class,'postAddStudent']);
Route::get('remove-student', [MainController::class,'getRemoveStudent']);

//Students
Route::get('my-subjects', [MainController::class,'getMySubjects']);