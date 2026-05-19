<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;

Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index']);
Route::post('/track', [VisitController::class, 'store']);
Route::get('/stats/hourly', [VisitController::class, 'hourly']);
Route::get('/stats/cities', [VisitController::class, 'cities']);
