<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use App\Http\Requests\RequestPassword;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\City;
use App\Province;
use App\Wards;
use App\Feeship;
use App\Customer;

use App\Shipping;
use App\Order;
use App\OrderDetails;
use Hash;

class CheckoutController extends Controller
{
    public function  AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            Redirect::to('dashboard');
        }else{
            return  Redirect::to('admin')->send();
        }
    }
    public function  AuthLogin1(){
        $customer_id = Session::get('customer_id');
        if($customer_id){
            Redirect::to('/checkout');
        }else{
            return  Redirect::to('login-checkout')->send();
        }
    }
    public function confirm_order(Request $request){
        $data = $request->all();

        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);

 
        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();
        

        if(Session::get('cart')==true){
           foreach(Session::get('cart') as $key => $cart){
               $order_details = new OrderDetails;
               $order_details->order_code = $checkout_code;
               $order_details->product_id = $cart['product_id'];
               $order_details->product_name = $cart['product_name'];
               $order_details->product_price = $cart['product_price'];
               $order_details->product_sales_quantity = $cart['product_qty'];
               $order_details->product_coupon =  $data['order_coupon'];
               $order_details->product_feeship = $data['order_fee'];
               $order_details->save();
           }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
   }
    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id=DB::table('tbl_order')
            ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
            ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
            ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
            ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->where('tbl_order.order_id',$orderId)->first();
        
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id );
       
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                     foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{ 
                    Session::put('fee',25000);
                    Session::save();
                }
            }
           
        }
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
    	if($data['action']){
    		$output = '';
    		if($data['action']=="city"){
    			$select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
    				$output.='<option>---Chọn quận huyện---</option>';
    			foreach($select_province as $key => $province){
    				$output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
    			}

    		}else{

    			$select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
    			$output.='<option>---Chọn xã phường---</option>';
    			foreach($select_wards as $key => $ward){
    				$output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
    			}
    		}
    		echo $output;
    	}
    }
    public function login_checkout(){
        $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function add_customer(Request $request){
        $data= array();
        $data['customer_name']=$request->customer_name;
        $data['customer_phone']=$request->customer_phone;
        $data['customer_email']=$request->customer_email;
        
        $result=DB::table('tbl_customer')->where ('customer_email',$request->customer_email)->first();
        $sdt=DB::table('tbl_customer')->where ('customer_phone',$request->customer_phone)->first();
        if($result){
            return Redirect::to('/login-checkout')->with('error','Email bạn vừa nhập đã được đăng ký');
        }
        if($sdt){
            
            return Redirect::to('/login-checkout')->with('error','Số điện thoại bạn vừa nhập đã được đăng ký');
        }
        if($request->customer_name == null || $request->customer_name == ""){
            
            return Redirect::to('/login-checkout')->with('error','vui lòng nhập đầy đủ thông tin khi đăng ký');
        }
        if($request->customer_phone == null || $request->customer_phone == ""){
            return Redirect::to('/login-checkout')->with('error','vui lòng nhập đầy đủ thông tin khi đăng ký');
        }
        if($request->customer_email == null || $request->customer_email == ""){
            return Redirect::to('/login-checkout')->with('error','vui lòng nhập đầy đủ thông tin khi đăng ký');
        }
        if($request->customer_email == 'customer_email' || $request->customer_email == ""){
            return Redirect::to('/login-checkout')->with('error','vui lòng nhập đầy đủ thông tin khi đăng ký');
        }
       
        if($request->customer_password==null|| $request->customer_password == "" ){
            return Redirect::to('/login-checkout')->with('error','mật khẩu phải từ 6 ký tự');
        }
       
        $data['customer_password']=md5($request->customer_password);
        $customer_id =DB::table('tbl_customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('checkout')->with('message','Đăng ký thành công');
    }
 
    public function update_password( $customer_id){
        $this->AuthLogin1();
        $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $all_user=DB::table('tbl_customer')->where('customer_id',$customer_id)->orderby('customer_id','desc')->get();
        
      
        return view('pages.show_info_cus')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function save_update_password(REQUEST $request,$customer_id){
        $this->AuthLogin1();
        $this->validate($request,
        [
            'password' => 'required|min:6',
            're_password'=> 'required|same:password',
        ],
        [
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min'=>'Mật khẩu phải từ 6 ký tự',
            're_password.required'=>'Không được bỏ trống',
            're_password.same'=>'Mật khẩu phải giống nhau', 
            //'re_password.min'=> 'Mật khẩu phải từ 6 ký tự fd',
        ]
        );
        $data=array();
        $data['customer_password']= md5($request->password);
        DB::table('tbl_customer')->where('customer_id',$customer_id)->update($data);
        
        return Redirect::to('/update-password/.$customer_id')->with('message','Đổi mật khẩu thành công');


        

    }
    public function update_customer(Request $request ,$customer_id){
        $data=array();
        $data['customer_name']= $request->customer_name;
        $data['customer_phone']= $request->customer_phone;
        $data['customer_email']= $request->customer_email;
        $data['customer_password']= $request->customer_password;
        DB::table('tbl_customer')->where('customer_id',$customer_id)->update($data);
        Session::put('message','Cập nhật thành công');
        return Redirect::to('pages.show_info_cus');
        
    }
    public function checkout(Request $request){
        
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
        $city = City::orderby('matp','ASC')->get();
    	return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('city',$city);
   
    }
    public  function save_checkout_customer(Request $request){
        $data= array();
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_phone']=$request->shipping_phone;
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_address']=$request->shipping_address;
       
        if($data['shipping_name']==null){
            
            return Redirect::to('/checkout')->with('error','vui lòng nhập đầy đủ thông tin trước khi gửi');
            
        }if($data['shipping_phone']==null){
            return Redirect::to('/checkout')->with('error','vui lòng nhập đầy đủ thông tin trước khi gửi');
            
        }
        if($data['shipping_email']==null){
            return Redirect::to('/checkout')->with('error','vui lòng nhập đầy đủ thông tin trước khi gửi');
            
        }
        if($data['shipping_address']==null){
            return Redirect::to('/checkout')->with('error','vui lòng nhập đầy đủ thông tin trước khi gửi');
        }
        $shipping_id =DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        
        return Redirect::to('/payment');
    }
    public function payment(){
        $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function logout_checkout(){
         $this->AuthLogin1();
        Session::forget('customer_id',null);
        Session::put('customer_name',null);
        Session::put('customer_phone',null);
        Session::forget('customer');
        
        
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        $email= $request->email_account;
        $phone= $request->email_account;
        $password= md5($request->password_account);
        $result=DB::table('tbl_customer')->where ('customer_email',$email)->where('customer_password',$password)->first();
        $a=DB::table('tbl_customer')->where ('customer_phone',$email)->where('customer_password',$password)->first();
        if($result){
            
            Session::put('customer_id',$result->customer_id);
            Session::put('customer_name',$result->customer_name);
            return Redirect::to('/checkout')->with('message','Đăng nhập thành công');
        } elseif($a){
            
            Session::put('customer_id',$a->customer_id);
            Session::put('customer_name',$a->customer_name);
            return Redirect::to('/checkout')->with('message','Đăng nhập thành công');
        }elseif($result!=true){
            return Redirect::to('/login-checkout')->with('error','Tên đăng nhập hoặc mật khẩu sai!!');
        }
       elseif($a!=true){
            return Redirect::to('/login-checkout')->with('error','Tên đăng nhập hoặc mật khẩu sai!!');
        }
        
        
     
    }
    public function order_place(Request $request){
        $data= array();
        $data['payment_method']=$request->payment_option;
        $data['payment_status']='Đang xử lý';
        $payment_id=DB::table('tbl_payment')->insertGetId($data);
      
        //order
        $order_data= array();
        $order_data['customer_id']=Session::get('customer_id');
        $order_data['shipping_id']=Session::get('shipping_id');
        $order_data['payment_id']=$payment_id;
        $order_data['order_total']= Cart::total();
        $order_data['order_status']= 'Đang xử lý';
        $order_id=DB::table('tbl_order')->insertGetId($order_data);
        
        // order_details
        $content= Cart::content();
        foreach ($content as $v_content){
            $order_d_data= array();
            $order_d_data['order_id']=$order_id;
            $order_d_data['product_id']=$v_content->id;
            $order_d_data['product_name']=$v_content->name;
            $order_d_data['product_price']= $v_content->price;
            $order_d_data['product_sales_quantity']= $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
            
        }
        if($data['payment_method']==1){
            echo 'thanh toán thẻ';
        }else if($data['payment_method']==2){
            Cart::destroy();
            $cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);
        }
       // return Redirect::to('/payment');
    }
    public function manage_order(){
        $this->AuthLogin();
        $all_order=DB::table('tbl_order')
            ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
            ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
}
