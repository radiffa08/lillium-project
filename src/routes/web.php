<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserCommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/codex', function() {
   return view('static.codex'); 
});

Route::get('/home', [HomeController::class, 'show']);

Route::get('/store', [StoreController::class, 'show']);

Route::get('/login', [LoginController::class, 'show']);
Route::post('/login/post', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/listing',                  [ListingController::class, 'show']);
Route::get('/listing/productedit',      [ListingController::class, 'productedit'])->name('listing.productedit');
Route::post('/listing/update',          [ListingController::class, 'update'])->name('listing.update');
Route::post('/listing/new',             [ListingController::class, 'new'])->name('listing.new');
Route::post('/listing/delete',          [ListingController::class, 'delete'])->name('listing.delete');
Route::post('/listing/image/delete',    [ListingController::class, 'delete_image'])->name('listing.image.delete');

Route::get('/product', [ProductPageController::class, 'show'])->name('productpage');

Route::get('/product/buy', [BuyerController::class, 'buy_product'])->name('product.buy');
Route::post('/product/comment', [UserCommentController::class, 'comment'])->name('product.comment');