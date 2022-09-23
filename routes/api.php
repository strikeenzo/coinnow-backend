<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeneralApiController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiSellerAuthController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\SellerApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\SellerCartApiController;
use App\Http\Controllers\Api\ChatsApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/users', function (Request $request) {
    return $request->user();
});

Route::get('/something', [GeneralApiController::class, 'something']);
Route::get('/something2', [GeneralApiController::class, 'something2']);
// Route::get('/getTrades', [GeneralApiController::class, 'getTrades']);
// Route::middleware(['checkKey'])->group(function () {

Route::middleware(['checkKey'])->group(function () {
    Route::get('testAPI', function () {
        return response()->json(['status' => 1, 'message' => 'Test Done!']);
    });

    Route::controller(GeneralApiController::class)->group(function () {
        Route::get('/getGuide/{type}', 'getGuide');
        Route::get('/getHomePage', 'getHomePage');
        Route::get('/getNewProducts', 'getNewProducts');
        Route::get('/getNewProductsV1', 'getNewProductsV1');
        Route::get('/getTrendingProducts', 'getTrendingProducts');
        Route::get('/getTrendingProductsV1', 'getTrendingProductsV1');
        Route::get('/getDODProducts', 'getDODProducts');
        Route::get('/getBannerImages', 'getBannerImages');
        Route::get('/getCategories', 'getCategories');
        Route::get('/getManufacturers', 'getManufacturers');
        Route::get('/searchProducts', 'searchProducts');
        Route::get('searchOtherSellersProducts', 'searchOtherSellersProducts');
        Route::get('getMarketplaceProducts', 'getMarketplaceProducts');
        Route::get('/productDetail/{id?}', 'productDetails');
        Route::post('/incrementProductView/{id?}', 'incrementProductView');
        Route::get('/getProductByCategory/{id?}', 'getProductByCategory');
        Route::get(
            '/getProductByManufacturer/{id?}',
            'getProductByManufacturer'
        );
        Route::get('/getPages/{id?}', 'getPages');
        // Route::put('/productRandomPrice', 'productRandomPrice');
        Route::get('/news', 'getNews');
        Route::get('/productPrice/{id}', 'productPrices');
        Route::post('/postComment', 'postComment');
        Route::get('/getComments', 'getComments');
        Route::get('/getCoinPrices', 'getCoinPrices');
    });

    Route::group(['prefix' => 'seller'], function () {
        Route::controller(ApiSellerAuthController::class)->group(function () {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::get('/logout', 'logout');
        });

        Route::middleware(['sellerAuth'])->group(function () {
            Route::controller(SellerApiController::class)->group(function () {
                Route::get('getSeller', 'getSellerDetails');
                Route::get('getSellers', 'getSellers');
                Route::post('sendCoins', 'sendCoins');
                Route::get('balanceHistory', 'balanceHistory');
                Route::get('searchProducts', 'searchProducts');
                Route::get('getTrades', 'getTrades');
                Route::post('trade', 'trade');
                Route::post('updateProfile', 'updateProfile');
                Route::post('changePassword', 'changePassword');
                Route::post('updateProduct/{id?}', 'updateProduct');
                Route::post('listProductSale/{id?}', 'listProductSale');
                Route::get('/getHistory', 'getHistory');
                Route::get('/getExpenses', 'getExpenses');
                Route::get('/getEarnings', 'getEarnings');
                Route::post('/payByStripe', 'payByStripe');
                Route::post('/buyCoin', 'buyCoin');
            });

            //cart functionality
            Route::controller(SellerCartApiController::class)->group(
                function () {
                    Route::post('/addToCart', 'addToCart');
                    Route::get('/getCart', 'getCart');
                    Route::post('/updateCart', 'updateCart');
                    Route::post('/deleteCart', 'deleteCart');
                    Route::post('/applyCoupon', 'applyCoupon');
                    Route::post('/selectShipping/{id?}', 'selectShipping');
                    Route::post('/placeOrder', 'placeOrder');
                    Route::post('/buyProduct', 'buyProduct');
                    Route::post('/buyProductV1', 'buyProductV1');
                    Route::post('/fightProduct', 'fightProduct');
                    Route::get('/getOrdersList', 'getOrdersList');
                }
            );

            //chat between sellers
            Route::group(['prefix' => 'chat'], function () {
                Route::controller(ChatsApiController::class)->group(
                    function () {
                        Route::post('/sendMessage', 'sendMessage');
                        Route::get('/users', 'getUsers');
                        Route::get(
                            '/getMessagesByChannel',
                            'getMessagesByChannel'
                        );
                        Route::get(
                            '/getMessagesByReceiver',
                            'getMessagesByReceiver'
                        );
                        Route::get('/getReceivedMessagesCounts', 'getReceivedMessagesCounts');
                    }
                );
            });
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::controller(ApiAuthController::class)->group(function () {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
            Route::post('/socialLogin', 'socialLogin');
            Route::post('/socialRegister', 'socialRegister');
            Route::get('/logout', 'logout');
        });

        Route::middleware(['customerAuth'])->group(function () {
            Route::controller(CustomerApiController::class)->group(function () {
                Route::get('getCustomer', 'getCustomerDetails');
                Route::post('updateProfile', 'updateProfile');
                Route::post('addUpdateWishlist', 'addUpdateWishlist');
                Route::get('getWishlist', 'getWishlist');
                Route::post('changePassword', 'changePassword');
                Route::post('changeProfilePicture', 'changeProfilePicture');
                Route::post('/addAddress', 'addAddress');
                Route::post('/editAddress/{id?}', 'editAddress');
                Route::post('/deleteAddress/{id?}', 'deleteAddress');
                Route::post('/addReview', 'addReview');
                Route::get('/getAdress', 'getAdress');
            });

            //cart functionality
            Route::controller(CartApiController::class)->group(function () {
                Route::post('/addToCart', 'addToCart');
                Route::get('/getCart', 'getCart');
                Route::post('/updateCart', 'updateCart');
                Route::post('/deleteCart', 'deleteCart');
                Route::post('/applyCoupon', 'applyCoupon');
                Route::get('/getCheckoutData', 'getCheckoutData');
                Route::post('/selectShipping/{id?}', 'selectShipping');
                Route::post('/placeOrder', 'placeOrder');
                Route::get('/getOrdersList', 'getOrdersList');
            });
        });
    });
});
