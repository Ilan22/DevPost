<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('commonData')->group(function () {
    Route::redirect('/', '/post');

    Route::fallback(function () {
        return redirect('/post');
    });

    // POST
    Route::middleware('auth')->prefix('/post')->name('post.')->controller(PostController::class)->group(function () {
        Route::get('/', 'list')->name('list');
        Route::get('/title', 'listByTitle')->name('listByTitle');
        Route::get('/category/{id}', 'listByCategory')->where(['id' => '[0-9]+'])->name('listByCategory');
        Route::get('/tag/{id}', 'listByTag')->where(['id' => '[0-9]+'])->name('listByTag');

        Route::get('/create', 'createShow')->name('createShow');
        Route::post('/create', 'create')->name('create');

        Route::get('/{id}', 'view')->where(['id' => '[0-9]+'])->name('view');
        Route::get('/{id}/edit', 'editShow')->where(['id' => '[0-9]+'])->name('editShow');
        Route::patch('/{id}/edit', 'edit')->where(['id' => '[0-9]+'])->name('edit');
        Route::post('/{id}', 'action')->where(['id' => '[0-9]+'])->name('action');
        Route::delete('/{id}', 'delete')->where(['id' => '[0-9]+'])->name('delete');
    });

    // COMMENT
    Route::middleware('auth')->prefix('/comment')->name('comment.')->controller(CommentController::class)->group(function () {
        Route::post('/{id}/comment', 'addComment')->where(['id' => '[0-9]+'])->name('addComment');
        Route::delete('/{id}/comment/{comment_id}', 'deleteComment')->where(['id' => '[0-9]+', 'comment_id' => '[0-9]+'])->name('deleteComment');
    });

    // AUTH
    Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/register', 'showRegister')->name('showRegister');
        Route::post('/register', 'register')->name('register');
        Route::get('/login', 'showLogin')->name('showLogin');
        Route::post('/login', 'login')->name('login');

        Route::middleware('auth')->group(function () {
            Route::post('/logout', 'logout')->name('logout');
            Route::get('/profile', 'profile')->name('profile');
            Route::patch('/saveInfos', 'saveInfos')->name('saveInfos');
            Route::put('/savePassword', 'savePassword')->name('savePassword');
        });
    });

    Route::middleware('auth.isAdmin')->group(function () {
        // ADMIN
        Route::prefix('/admin')->name('admin.')->controller(AdminController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/user', 'manageUser')->name('manageUser');
        });

        // TAG
        Route::prefix('/tag')->name('tag.')->controller(TagController::class)->group(function () {
            Route::post('/', 'create')->name('create');
            Route::delete('/', 'delete')->name('delete');
        });

        // CATEGORY
        Route::prefix('/category')->name('category.')->controller(CategoryController::class)->group(function () {
            Route::post('/', 'create')->name('create');
            Route::delete('/', 'delete')->name('delete');
        });
    });
});
