<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/settings/change', ['App\Http\Controllers\SettingsController', 'makeChanges'])->name('api.settings.change');
Route::get('/settings/get', ['App\Http\Controllers\SettingsController', 'getSettingsJson'])->name('api.settings.get');
Route::post('/main/get/items', ['App\Http\Controllers\MainController', 'getAllItems'])->name('api.main.get.items');


Route::post('/category/add', ['App\Http\Controllers\MainController', 'addCategory'])->name('api.category.add');
Route::post('/nodes/add', ['App\Http\Controllers\MainController', 'addNode'])->name('api.nodes.add');
Route::post('/nodes/get', ['App\Http\Controllers\MainController', 'getNode'])->name('api.nodes.get');
Route::post('/nodes/disable', ['App\Http\Controllers\MainController', 'disableNode'])->name('api.nodes.disable');
Route::post('/tree/get', ['App\Http\Controllers\MainController', 'getTree'])->name('api.tree.get');

Route::post('/edges/add', ['App\Http\Controllers\MainController', 'addEdge'])->name('api.edges.add');
Route::get('/edges/get/{node_id}', ['App\Http\Controllers\MainController', 'getEdge'])->name('api.edges.get');


Route::get('/main/dashboard', ['App\Http\Controllers\MainController', 'dashboard'])->name('api.main.dashboard');
