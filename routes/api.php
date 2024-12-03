<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [\App\Http\Controllers\Api\AuthenticationController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Api\AuthenticationController::class, 'destroy'])->middleware('auth:api');
    Route::post('register', [\App\Http\Controllers\Api\AuthenticationController::class, 'saveNewUser']);
    Route::post('updateprofile', [\App\Http\Controllers\Api\ProfileController::class, 'updateProfile'])->middleware('auth:api');
    Route::get('getproductlist', [\App\Http\Controllers\Api\ProductController::class, 'getAllProductList'])->middleware('auth:api');
    Route::get('getallcat', [\App\Http\Controllers\Api\ProductController::class, 'getAllCat'])->middleware('auth:api');
    Route::get('getproductcat', [\App\Http\Controllers\Api\ProductController::class, 'getProductCat'])->middleware('auth:api');
    Route::middleware('auth:api')->group(function () {
        Route::post('/messages/send', [\App\Http\Controllers\Api\MessageController::class, 'sendMessage']);
        Route::get('/messages/{user_id}', [\App\Http\Controllers\Api\MessageController::class, 'getMessages']);
        Route::delete('/delete/{id}', [\App\Http\Controllers\Api\MessageController::class, 'deleteMessage']);
        Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
        Route::get('/users/search', [\App\Http\Controllers\Api\UserController::class, 'search']);
    });
    // Route::middleware('auth:api')->group(function (){
    //     Route::apiResource('chat', ChatController::class)->only(['index','store','show']);
    //     Route::apiResource('chat_message', ChatMessageController::class)->only(['index','store']);
    //     Route::apiResource('user', UserController::class)->only(['index']);
    
    // });
  });

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ChatController;
// use App\Http\Controllers\ChatMessageController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\Api\AuthenticationController;
// use App\Http\Controllers\Api\ProfileController;
// use App\Http\Controllers\Api\ProductController;

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

// Route để lấy thông tin người dùng
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// // Nhóm các route API v1
// Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
//     Route::post('login', [AuthenticationController::class, 'login']);
//     Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');
//     Route::post('register', [AuthenticationController::class, 'saveNewUser']);
//     Route::post('updateprofile', [ProfileController::class, 'updateProfile'])->middleware('auth:api');

//     // Các route cho sản phẩm
//     Route::get('getproductlist', [ProductController::class, 'getAllProductList'])->middleware('auth:api');
//     Route::get('getallcat', [ProductController::class, 'getAllCat'])->middleware('auth:api');
//     Route::get('getproductcat', [ProductController::class, 'getProductCat'])->middleware('auth:api');

//     // Nhóm các route cho tin nhắn
//     // Route::middleware('auth:api')->group(function () {
//     //     Route::post('/messages/send', [ChatMessageController::class, 'sendMessage']);
//     //     Route::get('/messages/{user_id}', [ChatMessageController::class, 'getMessages']);
//     //     Route::delete('/messages/{id}', [ChatMessageController::class, 'deleteMessage']);
//     // });

//     // Nhóm các route cho chat
//     Route::middleware('auth:sanctum')->group(function (){
//         Route::apiResource('chat', ChatController::class)->only(['index', 'store', 'show']);
//         Route::apiResource('chat_message', ChatMessageController::class)->only(['index', 'store']);
//         Route::apiResource('user', UserController::class)->only(['index']);
//     });
// });
