<?php

use App\Models\Subcategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('products-data', [ProductController::class,'data'])->name('products.data');
    Route::get('/get-subcategories/{id}', function ($id) {
        return Subcategory::where('category_id', $id)->get();
    });
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments-data', [AppointmentController::class, 'data'])->name('appointments.data');
});

require __DIR__.'/auth.php';
