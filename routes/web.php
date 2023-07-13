<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\FlightSearchController;
use App\Models\User;

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
Route::group(['middleware' => 'prevent-back-history'],function(){

Route::match(['get', 'post'], '/search', [FlightSearchController::class, 'processSearchForm'])->name('processSearchForm');

Route::get('/results', [FlightController::class, 'showResults'])->name('results');
Route::get('/apisearch',[FlightController::class. 'apiSearch'])->name('apiSearch');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//admin Group Middleware
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'Adminprofile'])->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

    Route::get('/admin/view/user', [AdminController::class, 'AdminViewUser'])->name('admin.view.user');

    Route::get('/admin/edit/user{id}', [AdminController::class, 'AdminEditUser'])->name('admin.edit.user');

    Route::post('/admin/user/{id}/store', [AdminController::class, 'AdminUserStore'])->name('admin.user.store');

    Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admin/view/flight', [AdminController::class, 'AdminViewFlight'])->name('admin.view.flight');

    

   
    

});//End group admin middleware



Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
}); //prevent back  middleware



