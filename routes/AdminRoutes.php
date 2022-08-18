<?php
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\Admin\ProfileController;

Route::get('/', [HomeController::class,'index'])->name('dashboard');
Route::get('/dashboard', [HomeController::class,'index'])->name('dashboard');
Route::get('/unauthorize', function() {
  return view('admin.unauth');
});


//'check_permission'
Route::middleware(['check_permission'])->group(function () {

  // Route::controller(ProfileController::class)->group(function () {
  //   Route::get('profile', ['as' => 'profile.edit', 'uses' => 'edit']);
  //   Route::put('profile', ['as' => 'profile.update', 'uses' => 'update']);
  //   Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'password']);
  // });

    include('CategoryRoutes.php');
    include('BannerRoutes.php');
    include('CountryRoutes.php');
    include('TaxRateRoutes.php');
    include('StockStatusRoutes.php');
    include('LengthClassRoutes.php');
    include('WeightClassRoutes.php');
    include('CustomerRoutes.php');
    include('SellerRoutes.php');
    include('ReviewRoutes.php');
    include('ManufacturerRoutes.php');
    include('OrderStatusRoutes.php');
    include('ProductRoutes.php');
    include('ProductOptionRoutes.php');
    include('OrderRoutes.php');
    include('CouponRoutes.php');
    include('RoleRoutes.php');
    include('PermissionRoutes.php');
    include('UserRoutes.php');
    include('ProductAttributeGroupRoutes.php');
    include('ProductAttributeRoutes.php');
    include('PagesRoutes.php');
    include('DODRoutes.php');
    include('ShippingRoutes.php');
    include('TradeRoutes.php');

  	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
  });
