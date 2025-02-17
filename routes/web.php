<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrannerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/get-started', function () {
    return view('getStarted');
});


// users auth 

Route::get('/users/register', [UserController::class, 'register'])->middleware('logedout');
Route::post('/users/register', [UserController::class, 'registerPost'])->middleware('logedout');

Route::get('/users/login', [UserController::class, 'login'])->middleware('logedout');
Route::post('/users/login', [UserController::class, 'loginPost'])->middleware('logedout');


Route::delete('/users/logout', [UserController::class, 'logout'])->middleware('user');

Route::get('/users/dashboard', [UserController::class, 'dashboard'])->middleware('user');
// users workout


Route::get('/users/workouts', [UserController::class, 'workouts'])->middleware('user');
Route::get('/users/get-workouts', [UserController::class, 'getWorkouts'])->middleware('user');
Route::post('/users/save-workout', [UserController::class, 'saveWorkout'])->middleware('user');


// user plan 
Route::get('/users/create-plan', [UserController::class, 'createPlanView'])->middleware('user');
Route::post('/users/create-plan', [UserController::class, 'createPlan'])->middleware('user');
Route::post('/users/create-workout-plan', [UserController::class, 'createWorkoutPlan'])->middleware('user');
Route::get('/users/create-workout-plan', [UserController::class, 'createWorkoutPlanView'])->middleware('user');
Route::get('/users/show-workout-plan', [UserController::class, 'showWorkoutPlan'])->middleware('user');
Route::get('/users/get-workout-plan', [UserController::class, 'getWorkoutPlan'])->middleware('user');


Route::get('/users/dicover-plans', [UserController::class, 'dicoverPlansView'])->middleware('user');
Route::get('/users/get-dicover-plans', [UserController::class, 'getDicoverPlans'])->middleware('user');

Route::post('/users/save-plan', [UserController::class, 'savePlan'])->middleware('user');
Route::post('/users/update-plan', [UserController::class, 'updatePlan'])->middleware('user');


Route::delete('/users/delete-plan', [UserController::class, 'deletePlan'])->middleware('user');


//progress
Route::get('/users/my-progress', [UserController::class, 'myProgressView'])->middleware('user');
Route::get('/users/get-my-progress', [UserController::class, 'getMyProgress'])->middleware('user');
Route::post('/users/update-progress', [UserController::class, 'updateProgress'])->middleware('user');


// chat 
Route::post('/user/create-chat', [UserController::class, 'createChat'])->middleware('user');
Route::post('/user/add-message', [UserController::class, 'createChat'])->middleware('user');
// Route::post('/user/create-chat', [UserController::class,'createChat'])->middleware('user');






// admin related
//admin auth

Route::get('/admin/login', [AdminController::class, 'login'])->middleware('logedout');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->middleware('logedout');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('admin');
Route::delete('/admin/logout', [AdminController::class, 'logout'])->middleware('admin');



// tranner related 

//tranner auth 
Route::get('/trainer/login', [TrannerController::class, 'login'])->middleware('logedout');
Route::post('/trainer/login', [TrannerController::class, 'loginPost'])->middleware('logedout');
Route::delete('/trainer/logout', [TrannerController::class, 'logout'])->middleware('trainer');

Route::get('/trainer/dashboard', [TrannerController::class, 'dashboard'])->middleware('trainer');

// tranner workout 

Route::get('/trainer/create-workout', [TrannerController::class, 'createWorkoutView'])->middleware('trainer');
Route::post('/trainer/create-workout', [TrannerController::class, 'createWorkout'])->middleware('trainer')->name('file.upload');
Route::get('/trainer/workouts', [TrannerController::class, 'workouts'])->middleware('trainer');
Route::get('/trainer/get-workouts', [TrannerController::class, 'getWorkouts'])->middleware('trainer');


//tranner  plan 
Route::get('/trainer/create-plan', [TrannerController::class, 'createPlanView'])->middleware('trainer');
Route::post('/trainer/create-plan', [TrannerController::class, 'createPlan'])->middleware('trainer');
Route::get('/trainer/dicover-plans', [TrannerController::class, 'dicoverPlansView'])->middleware('trainer');
Route::get('/trainer/get-dicover-plans', [TrannerController::class, 'dicoverPlans'])->middleware('trainer');




Route::post('/trainer/create-workout-plan', [TrannerController::class, 'createWorkoutPlan'])->middleware('trainer');
Route::get('/trainer/create-workout-plan', [TrannerController::class, 'createWorkoutPlanView'])->middleware('trainer');
Route::get('/trainer/show-workout-plan', [TrannerController::class, 'showWorkoutPlan'])->middleware('trainer');
Route::get('/trainer/get-workout-plan', [TrannerController::class, 'getWorkoutPlan'])->middleware('trainer');





// apis 










