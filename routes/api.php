<?php

use App\Http\Controllers\api\doctor\auth\DoctorAuthController;
use App\Http\Controllers\api\doctor\DoctorController;
use App\Http\Controllers\api\project\ProjectController;

use App\Http\Controllers\api\standards\StandardController;
use App\Http\Controllers\api\student\auth\StudentAuthController;
use App\Http\Controllers\api\student\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::get('/test/test', function () {
    return response()->json(['jkj'=>'fgfggf']);
})->middleware('auth:sanctum');

Route::prefix('student')->group(function(){
    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::post('/login', [StudentAuthController::class, 'login']);
});

Route::prefix('student')->group(function(){
    Route::get('/students', [StudentController::class, 'index']);

    Route::post('/createTeam', [StudentController::class, 'createTeam']);
    Route::get('/requests', [StudentController::class, 'getStudentRequest']);
    Route::post('/create/doctor/request', [StudentController::class, 'createDoctorRequest']);
    Route::get('/project', [StudentController::class, 'getProjectOfStudent']);
    Route::get('/project/students', [StudentController::class, 'getStudentsOfProject']);
    Route::post('/accept/request/{request_id}', [StudentController::class, 'acceptStudentRequest']);

});
Route::prefix('doctor')->group(function(){
    Route::post('/register', [DoctorAuthController::class, 'register']);
    Route::post('/login', [DoctorAuthController::class, 'login']);
});

Route::prefix('doctor')->group(function(){
    Route::resource('/projects',DoctorController::class);
    Route::get('/doctors',[DoctorController::class, 'index']);
    Route::post('/accept/request/{request_id}',[DoctorController::class, 'acceptRequest']);
    Route::post('/assign',[DoctorController::class, 'assignDoctor']);
    Route::post('/update/{doctor}',[DoctorController::class,'changeActivity']);
    Route::delete('/delete',[DoctorController::class,'destroy']);
    Route::get('/requests', [DoctorController::class, 'getDoctorRequest']);
    Route::post('/grades', [DoctorController::class, 'insertGrades']);
    Route::get('/grades', [DoctorController::class, 'getGrades']);




});


Route::prefix('project')->group(function(){

    Route::resource('/projects',ProjectController::class);
    Route::post('/update/{project}',[ProjectController::class,'update']);
    Route::delete('/delete/{project}',[ProjectController::class,'destroy']);
});

Route::prefix('admin')->group(function(){
    Route::post('/notes',[StandardController::class,'insertNotes']);
    Route::get('/notes',[StandardController::class,'getNotes']);
    Route::get('/standards',[StandardController::class,'index']);
    Route::post('/standards/create',[StandardController::class,'store']);
    Route::post('/update/{standard}',[StandardController::class,'update']);
    Route::delete('standards/delete/{standard}',[StandardController::class,'destroy']);
});

