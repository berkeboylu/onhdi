<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/info', function () {return view('info');});
    Route::get('/info/{id}', ['App\Http\Controllers\MainController', 'InfoNode'])->name('info.node.id');
    Route::get('/view/{id}', ['App\Http\Controllers\MainController', 'ViewNode'])->name('view.node.id');
    
    Route::get('/', function () {return view('main');});
    Route::get('/list', function () {return view('try');});
    Route::get('/graph', function () {return view('graph');})->name('view.graph');
    Route::get('/settings', function () {return view('sections.settings');})->name('view.settings');
    Route::get('/profile', function () {return view('auth.profile');})->name('auth.profile');
    Route::get('/nodes', function () {return view('nodes');});
    Route::get('/nodes/add', function () {return view('nodes.add');})->name('nodes.add');
    
    Route::get('/nodes/view/detail/{id}', ['App\Http\Controllers\MainController', 'getNodeView'])->name('nodes.view.detail');
});

Auth::routes();