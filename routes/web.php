<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Homepage\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/category/{slug}', [\App\Http\Controllers\Homepage\CategoryController::class, 'index'])->name('category');

Route::get('/cart', [\App\Http\Controllers\Homepage\CartController::class, 'index'])->name('cart');
Route::get('/cart-detail', [\App\Http\Controllers\Homepage\CartController::class, 'cartDetail'])->name('cart.detail');
Route::get('/cart-delete/{rowId}', [\App\Http\Controllers\Homepage\CartController::class, 'cartDelete'])->name('cart.delete');
Route::get('/cart/form', [\App\Http\Controllers\Homepage\CartController::class, 'form'])->name('cart.form');
Route::get('/cart/form/get-city', [\App\Http\Controllers\Homepage\CartController::class, 'getCity'])->name('cart.form.getCity');

Route::post('/cart/form/transaction', [\App\Http\Controllers\Homepage\CartController::class, 'transaction'])->name('cart.form.transaction');
Route::get('/cart/myorder', [\App\Http\Controllers\Homepage\CartController::class, 'myorder'])->name('cart.myorder');
Route::post('/cart/myorder/upload', [\App\Http\Controllers\Homepage\CartController::class, 'upload'])->name('cart.myorder.upload');
Route::get('/cart/myorder/detail/{code}', [\App\Http\Controllers\Homepage\CartController::class, 'detailOrder'])->name('cart.myorder.detail');
Route::delete('/cart/myorder/delete', [\App\Http\Controllers\Homepage\CartController::class, 'delete'])->name('cart.myorder.delete');

Route::post('/login-suppliermember', [\App\Http\Controllers\Homepage\UserController::class, 'login'])->name('login.supplier-member');
Route::get('/logout-suppliermember', [\App\Http\Controllers\Homepage\UserController::class, 'logout'])->name('logout.supplier-member');
Route::get('/register-suppliermember', [\App\Http\Controllers\Homepage\UserController::class, 'register'])->name('register.supplier-member');
Route::post('/register-suppliermember', [\App\Http\Controllers\Homepage\UserController::class, 'registerCreate'])->name('register.supplier-member.create');
Route::get('/verifikasi/{token}', [\App\Http\Controllers\Homepage\UserController::class, 'verifikasi'])->name('verifikasi');
Route::get('/member', [\App\Http\Controllers\Homepage\UserController::class, 'member'])->name('member');
Route::get('/myaccount', [\App\Http\Controllers\Homepage\UserController::class, 'myaccount'])->name('myaccount');
Route::post('/myaccount/update/{id}', [\App\Http\Controllers\Homepage\UserController::class, 'myAccountUpdate'])->name('myaccount.update');

Route::get('/product', [\App\Http\Controllers\Homepage\ProductController::class, 'index'])->name('product');
Route::get('/detail/{slug}', [\App\Http\Controllers\Homepage\ProductController::class, 'detail'])->name('product.detail');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'administrator', 'middleware' => ['role:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/media', [DashboardController::class, 'media'])->name('admin.media');

    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('/', [SettingController::class, 'update'])->name('admin.setting.update');
    });

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/getData', [CategoryController::class, 'getData'])->name('admin.category.getData');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::post('/update', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/delete', [CategoryController::class, 'delete'])->name('admin.category.delete');

        Route::get('/sub-category/{subCategory}', [CategoryController::class, 'subCategory'])->name('admin.category.subCategory');
        Route::post('/update-sub-category', [CategoryController::class, 'updateSubCategory'])->name('admin.category.updateSubCategory');
        Route::delete('/delete-sub-category', [CategoryController::class, 'deleteSubCategory'])->name('admin.category.deleteSubCategory');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product');
        Route::get('/getData', [ProductController::class, 'getData'])->name('admin.product.getData');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::post('/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
    });

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('admin.transaction');
        Route::get('/getData', [TransactionController::class, 'getData'])->name('admin.transaction.getData');
        Route::delete('/delete', [TransactionController::class, 'delete'])->name('admin.transaction.delete');
        Route::get('/pdf', [TransactionController::class, 'pdf'])->name('admin.transaction.pdf');
        Route::get('/print', [TransactionController::class, 'print'])->name('admin.transaction.print');
        Route::post('/status', [TransactionController::class, 'status'])->name('admin.transaction.status');
        Route::get('/export', [TransactionController::class, 'export'])->name('admin.transaction.export');
    });

    Route::prefix('report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('admin.report');
        Route::get('/export', [ReportController::class, 'export'])->name('admin.report.export');
        Route::post('/income', [ReportController::class, 'income'])->name('admin.report.income');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::get('/getData', [UserController::class, 'getData'])->name('admin.user.getData');
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::post('/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/delete', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::get('/export', [UserController::class, 'export'])->name('admin.user.export');
        Route::get('/delete', [UserController::class, 'deleteAll'])->name('admin.user.deleteAll');
    });

    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'index'])->name('admin.province');
        Route::get('/getData', [ProvinceController::class, 'getData'])->name('admin.province.getData');
    });

    Route::prefix('city')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('admin.city');
        Route::get('/getData', [CityController::class, 'getData'])->name('admin.city.getData');
    });

    Route::prefix('cost')->group(function () {
        Route::get('/', [CostController::class, 'index'])->name('admin.cost');
        Route::post('/', [CostController::class, 'check'])->name('admin.cost.check');
    });

    // Profile
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    });
});