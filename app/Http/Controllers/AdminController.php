<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
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
use App\Product;

class AdminController extends Controller
{
    public function  AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            Redirect::to('dashboard');
        }else{
          return  Redirect::to('admin')->send();
        }
    }
    public function index()
    {
        return view('pages.admin_login');
    }
    public function customer_info(Request $request){
        $this->AuthLogin();
        $all_user=DB::table('tbl_customer')->Paginate(5);
        $all_customer = view('admin.customer_info')->with('all_user',$all_user);
        return view('admin_layout')->with('admin.customer_info',$all_customer);
        
       
    }
    public function customer_ordered($customer_id){
		$this->AuthLogin();
        $info_order = DB::table('tbl_order')->where('customer_id',$customer_id)->orderby('customer_id','desc')->get();
        $order_details=DB::table('tbl_order_details')->where('');
        
    	return view('admin.customer_ordered')->with('order',$info_order);

       
        
    }
    public function show_dashboard(Request $request){
        $this->AuthLogin();
        $order_details=DB::table('tbl_order_details')
        ->select('tbl_order_details.*','tbl_order_details.order_details_id')
        ->orderby('tbl_order_details.order_details_id','desc')->get();
        $all_customer=DB::table('tbl_customer')
            
            ->select('tbl_customer.*','tbl_customer.customer_id')
            ->orderby('tbl_customer.customer_id','desc')->get();
        $all_order=DB::table('tbl_order')
            ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
            ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        
        $manager_order = view('admin.dashboard')->with('all_order',$all_order)->with('all_customer',$all_customer)->with('order_details',$order_details);
        return view('admin_layout')->with('admin.dashboard',$manager_order)->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));;
        // return view('admin.dashboard');
    }

    public function dashboard(Request $request)
    {
        
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbt_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if ($result) {
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to ('/dashboard');
        }else{
            Session::put('message','Email hoặc mật khẩu sai. Vui lòng thử lại');
            return Redirect::to ('/admin');
        }
    }
    public function logout(Request $request)
    {
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        Session::forget('admin');
        return Redirect::to ('/admin');


    }
    public function add_admin(Request $request){
        $this->AuthLogin();
        
        return view('admin.add_admin');
    }
    public function save_add_admin(Request $request){
        $this->AuthLogin();
        $data= array();
        $data['admin_name']=$request->admin_name;
        $data['admin_phone']=$request->admin_phone;
        $data['admin_email']=$request->admin_email;
        $data['admin_password']=md5($request->admin_password);
        $result=DB::table('tbt_admin')->where ('admin_email',$request->admin_email)->first();
        $sdt=DB::table('tbt_admin')->where ('admin_phone',$request->admin_phone)->first();
        if($result){
            return Redirect::to('/add-admin')->with('error','Email bạn vừa nhập đã được đăng ký');
        }
        if($sdt){
            
            return Redirect::to('/add-admin')->with('error','Số điện thoại bạn vừa nhập đã được đăng ký');
        }
       
        DB::table('tbt_admin')->insert($data);
     
        return Redirect::to ('/add-admin')->with('message','Thêm thành công người dùng' );
    }
    public function update_pass_admin( $admin_id){
        $this->AuthLogin();
        
        $all_admin=DB::table('tbt_admin')->where('admin_id',$admin_id)->orderby('admin_id','desc')->get();
        
      
        return view('admin.update_pass_admin');
    }
    public function save_update_pass_admin(REQUEST $request,$admin_id){
        $this->AuthLogin();
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
        $data['admin_password']= md5($request->password);
        DB::table('tbt_admin')->where('admin_id',$admin_id)->update($data);
        
        return Redirect::to('/update-pass-admin/.$admin_id')->with('message','Đổi mật khẩu thành công');


        

    }
   
    
}



