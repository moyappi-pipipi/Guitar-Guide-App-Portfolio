<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\GuitarController;
use App\Http\Controllers\Api\GuitarItemController;
use App\Http\Controllers\Api\OpenApiController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/openapi.yaml', [OpenApiController::class, 'yaml']);
Route::get('/openapi.json', [OpenApiController::class, 'json']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);

Route::get('/guitars', [GuitarController::class, 'index']);
Route::get('/guitars/{id}', [GuitarController::class, 'show']);

Route::get('/guitar-items', [GuitarItemController::class, 'index']);
Route::get('/guitar-items/{id}', [GuitarItemController::class, 'show']);

Route::get('/search', SearchController::class);
