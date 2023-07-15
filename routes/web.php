<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\StripeController;
use App\Models\User;
use App\Models\Receipt;
use App\Models\Order;

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

Route::match(['get', 'post'], '/search', [FlightSearchController::class, 'processSearchForm'])->name('search');

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

Route::middleware(['auth','role:user'])->group(function(){

    Route::get('/user/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');

    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

    Route::get('/user/profile', [UserController::class, 'Userprofile'])->name('user.profile');

    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');

    Route::get('/user/view/car', [UserController::class, 'UserViewCar'])->name('user.view.car');

    Route::get('/user/edit/car{id}', [UserController::class, 'UserEditCar'])->name('user.edit.car');

    Route::post('/user/store/{id}/order', [UserController::class, 'UserStoreOrder'])->name('user.store.order');

    Route::get('/user/receipt', [UserController::class, 'UserReceipt'])->name('user.receipt');

    Route::delete('/user/order/{order_id}', [UserController::class, 'destroy'])->name('user.order.destroy');


});


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
Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');

Route::get('/user/paid', [UserController::class, 'UserPaid'])->name('user.paid');
Route::get('/user/receipt', [StripeController::class, 'UserReceipt'])->name('user.user_receipt');
Route::post('/user/paid', [StripeController::class, 'UserPaid'])->name('user.user_paid');

}); //prevent back  middleware



