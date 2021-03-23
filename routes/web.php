<?php

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
//Fontend

Route::get('/', 'HomeController@index' );
Route::get('/trang-chu', 'HomeController@index');
Route::post('/tim-kiem', 'HomeController@search');
//danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}', 'CategoryProduct@show_category_home');
//thuong hieu san pham trang chu
Route::get('/thuong-hieu-san-pham/{brand_id}', 'BrandProduct@show_brand_home');
Route::get('/chi-tiet-san-pham/{product_id}', 'ProductController@detail_product');
//uu dai va su kien
Route::get('/uu-dai-su-kien', 'BrandProduct@show_even');
//Backend
Route::get('/admin', 'AdminController@index' );
Route::get('/dashboard', 'AdminController@show_dashboard' );
Route::get('/logout', 'AdminController@logout' );
Route::post('/admin-dashboard', 'AdminController@dashboard' );

Route::get('/add-admin', 'AdminController@add_admin' );
Route::post('/save-add-admin', 'AdminController@save_add_admin' );
//category product
Route::get('/add-category-product', 'CategoryProduct@add_category_product');
Route::get('/all-category-product', 'CategoryProduct@all_category_product');
Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@delete_category_product');
Route::post('/save-category-product', 'CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@update_category_product');

Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');


//brand product
Route::get('/add-brand-product', 'BrandProduct@add_brand_product');
Route::get('/all-brand-product', 'BrandProduct@all_brand_product');
Route::get('/edit-brand-product/{brand_product_id}', 'BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}', 'BrandProduct@delete_brand_product');
Route::post('/save-brand-product', 'BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'BrandProduct@update_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}', 'BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}', 'BrandProduct@active_brand_product');

//product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/all-product', 'ProductController@all_product');
Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'ProductController@delete_product');
Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');

Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');
//cart
Route::post('/update-cart-quantity', 'CartController@update_cart_quantity');
Route::post('/save-cart', 'CartController@save_cart');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/delete-cart/{rowId}', 'CartController@delete_cart');
Route::post('/add-cart-ajax','CartController@add_cart_ajax');
Route::get('/gio-hang','CartController@gio_hang'); 
Route::post('/update-cart','CartController@update_cart');
Route::get('/del-product/{session_id}', 'CartController@del_product');
Route::post('/update-qty','OrderController@update_qty');
Route::post('/update-order-qty','OrderController@update_order_qty');
//checkout 
Route::post('/calculate-fee', 'CheckoutController@calculate_fee');
Route::post('/select-delivery-home', 'CheckoutController@select_delivery_home');
Route::get('/login-checkout', 'CheckoutController@login_checkout');
Route::get('/logout-checkout', 'CheckoutController@logout_checkout');
Route::post('/add-customer', 'CheckoutController@add_customer');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::get('/checkout', 'CheckoutController@checkout');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');
Route::get('/payment', 'CheckoutController@payment');
Route::post('/order-place', 'CheckoutController@order_place');
Route::post('/confirm-order','CheckoutController@confirm_order');

//quan ly don hang show_ordered_details
Route::get('/manage-order', 'OrderController@manage_order');
Route::get('/view-order/{order_code}', 'OrderController@view_order');
Route::get('/print-order/{checkout_code}','OrderController@print_order');
Route::get('/show-ordered/{customer_id}', 'OrderedController@show_ordered');
Route::get('/show-ordered-details/{order_code}', 'OrderedController@show_ordered_details');
Route::get('/uu-tien', 'OrderController@uu_tien');
//coupon
Route::post('/check-coupon', 'CartController@check_coupon');
Route::get('/insert-coupon', 'CouponController@insert_coupon');
Route::post('/insert-coupon-code', 'CouponController@insert_coupon_code');
Route::get('/list-coupon', 'CouponController@list_coupon');
Route::get('/delete-coupon/{coupon_id}', 'CouponController@delete_coupon');
Route::get('/unset-coupon', 'CouponController@unset_coupon');
//Delivery 
Route::get('/delivery','DeliveryController@delivery');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');
//updateorder update-qty-order
Route::post('/update-order-qty','OrderController@update_order_qty');
Route::post('/update-qty-order','OrderController@update_qty_order');
//quanlyKH
Route::get('/customer-info','AdminController@customer_info');
Route::get('/customer-ordered/{customer_id}', 'AdminController@customer_ordered');
//quanlydoanhthu target-month info-cus
Route::get('/manage-targetup','OrderController@manage_targetup');
Route::get('/manage-target','OrderController@manage_target');
Route::get('/target-month','OrderController@target_month');
Route::post('/tinh-target', 'OrderController@tinh_target');
//customer

Route::get('/update-password/{customer_id}','CheckoutController@update_password');
Route::post('/save-update-password/{customer_id}','CheckoutController@save_update_password');
//admin-pass

Route::get('/update-pass-admin/{admin_id}','AdminController@update_pass_admin');
Route::post('/save-update-pass-admin/{admin_id}','AdminController@save_update_pass_admin');