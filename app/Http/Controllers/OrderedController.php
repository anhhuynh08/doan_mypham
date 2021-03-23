<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DB;
use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\Customer;
use App\Coupon;
use PDF;
use App\Product;
use Session;
session_start();
class OrderedController extends Controller
{
	public function  AuthLogin1(){
        $customer_id = Session::get('customer_id');
        if($customer_id){
            Redirect::to('/checkout');
        }else{
            return  Redirect::to('login-checkout')->send();
        }
	}
	
	public function show_ordered($customer_id){
		$this->AuthLogin1();
		
        $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
		$brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $info_order = DB::table('tbl_order')->where('customer_id',$customer_id)->orderby('customer_id','desc')->get();
        $order_details=DB::table('tbl_order_details')->where('');
    	return view('pages.checkout.show_ordered')->with('category',$cate_product)->with('brand',$brand_product)->with('order',$info_order);

       
        
	}
	public function info_cus($customer_id){
		$this->AuthLogin1();
        $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
		$brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
       
        
    	return view('pages.show_info_cus')->with('category',$cate_product)->with('brand',$brand_product);

       
        
    }
    public function show_ordered_details($order_code){
		$this->AuthLogin1();
		 
        $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
		$brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
		$order = Order::where('order_code',$order_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;
		}
		if($product_coupon != 'no'){
			$coupon = Coupon::where('coupon_code',$product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;
		}
		
		return view('pages.checkout.show_ordered_details')->with('category',$cate_product)->with('brand',$brand_product)->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));

    }
}