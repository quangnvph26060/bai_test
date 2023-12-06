<?php

use App\Http\Controllers\Api\ApiSanPhamController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return 'Nguyễn Trọng Nam';
// });
// Route::resource('posts', PostController::class)->only(['index','show','update','store','delete']); 
// only chỉ thực hiện những phương thức đấy
// Route::resource('posts', PostController::class)->except(['edit','create']); // except ngược lại không thực hiện phương thức đấy


Route::post('login',[AuthController::class,'login'])->name('login');
Route::post('register',[AuthController::class,'register']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    //Route::get('posts',[PostController::class,'index']);
//    Route::resource('posts', PostController::class);
});
Route::resource('posts', PostController::class);
Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/list',[ApiSanPhamController::class,'index']);
        Route::post('/add', [ApiSanPhamController::class,'store']);
        Route::get('/edit/{id}',[ApiSanPhamController::class,'show']);
        Route::put('/update/{id}', [ApiSanPhamController::class,'update']);
        Route::delete('/delete/{id}', [ApiSanPhamController::class,'destroy']);
    });
});

// Route::get('posts',[PostController::class,'index']);