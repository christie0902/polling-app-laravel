<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PollController::class, 'displayAll'])->name('home');
Route::get('/edit/{id?}', [PollController::class, 'edit'])->name('poll.edit');
Route::post('/polls/store', [PollController::class, 'save'])->name('polls.store');
Route::put('/polls/update/{id}', [PollController::class, 'save'])->name('polls.update');
Route::get('/mypoll', [PollController::class, 'myPolls'])->name('mypolls');
Route::post('/polls/{poll_id}/respond', [PollController::class, 'respond'])->name('polls.respond')->middleware('auth');