<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Coupon;
use Illuminate\Support\Facades\Redirect;
session_start();
class CouponController extends Controller
{
    public function  AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            Redirect::to('dashboard');
        }else{
            return  Redirect::to('admin')->send();
        }
    }
    public function unset_coupon(){
        $this->AuthLogin();
       $coupon= Session::get('coupon');
       if($coupon==true){
           Session::forget('coupon');
           return redirect()->back()->with('message','Xoá mã khuyến mãi thành công');
       }
    }
    public function insert_coupon(){
        $this->AuthLogin();
        return view ('admin.coupon.insert_coupon');
    }
    public function delete_coupon($coupon_id){
        $this->AuthLogin();
        $coupon= Coupon::find($coupon_id);
       // $coupon->delete();
        Session::put('message','Xoá mã giảm giá thành công');
        return Redirect::to ('list_coupon');
    }
    public function list_coupon(){
        $this->AuthLogin();
        $coupon = Coupon::orderby('coupon_id','DESC')->get();
        return view ('admin.coupon.list_coupon')->with(compact('coupon'));
    }
    public function insert_coupon_code(Request $request){
        $this->AuthLogin();
       $data= $request->all();
       $coupon= new Coupon;
       $coupon->coupon_name=$data['coupon_name'];
       $coupon->coupon_number=$data['coupon_number'];
       $coupon->coupon_code=$data['coupon_code'];
       $coupon->coupon_time=$data['coupon_time'];
       $coupon->coupon_condition=$data['coupon_condition']; 
       if($coupon->coupon_name==null||$coupon->coupon_name==""||$coupon->coupon_number==null||
       $coupon->coupon_number==""||$coupon->coupon_code==null||$coupon->coupon_code==""||
       $coupon->coupon_time==null||$coupon->coupon_time==""||$coupon->coupon_condition==null||
       $coupon->coupon_condition==""){
        return Redirect::to('insert-coupon')->with('error','vui lòng nhập đầy đủ thông tin để thêm giảm giá');
       }elseif($coupon->coupon_time<=0){
        return Redirect::to('insert-coupon')->with('error','Số lượng mã phải lớn hơn 0');
       }elseif($coupon->coupon_number<=0){
        return Redirect::to('insert-coupon')->with('error','giá trị giảm phải lớn hơn 0');
       }
       else{
        $coupon->save();
        Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('insert-coupon');
       }
      
    }
}
