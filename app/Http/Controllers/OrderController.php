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
class OrderController extends Controller
{
	public function  AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            Redirect::to('dashboard');
        }else{
          return  Redirect::to('admin')->send();
        }
    }
	
	// public function show_ordered($order_code){
	// 	$cate_product = DB::table ('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
	// 	$brand_product = DB::table ('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
	// 	$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
	// 	$order = Order::where('order_code',$order_code)->get();
	// 	foreach($order as $key => $ord){
	// 		$customer_id = $ord->customer_id;
	// 		$shipping_id = $ord->shipping_id;
	// 		$order_status = $ord->order_status;
	// 	}
	// 	$customer = Customer::where('customer_id',$customer_id)->first();
	// 	$shipping = Shipping::where('shipping_id',$shipping_id)->first();

	// 	$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

	// 	foreach($order_details_product as $key => $order_d){

	// 		$product_coupon = $order_d->product_coupon;
	// 	}
		
    // 	return view('pages.checkout.show_ordered')->with('category',$cate_product)->with('brand',$brand_product)->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));;

       
        
	// }
	public function update_qty_order(Request $request){
		$this->AuthLogin();
		$data = $request->all();
		$order_details= OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$order_details->product_sales_quantity= $data['order_qty'];
		$order_details->save();	
	}
	public function update_order_qty(Request $request){
		$this->AuthLogin();
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status= $data['order_status'];
		$order->save();
		if($order->order_status==2){
			foreach($data['order_product_id'] as $key => $product_id){
				$product = Product::find($product_id);
				$product_quantity =  $product->product_quantity;
				$product_sold = $product->product_sold;
				foreach($data['quantity'] as $key2 =>$qty){
					if($key==$key2){
						$pro_remain = $product_quantity - $qty;
						$product->product_quantity = $pro_remain;
						$product->product_sold = $product_sold + $qty;
						$product->save();
					}
				}
			}
		}elseif($order->order_status!=2 && $order->order_status!=3 ){
			foreach($data['order_product_id'] as $key => $product_id){
			$product = Product::find($product_id);
			$product_quantity =  $product->product_quantity;
			$product_sold = $product->product_sold;
			foreach($data['quantity'] as $key2 =>$qty){
				if($key==$key2){
					$pro_remain = $product_quantity + $qty;
					$product->product_quantity = $pro_remain;
					$product->product_sold = $product_sold - $qty;
					$product->save();
				}
			}
		}
	}
	}
	public function print_order($checkout_code){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		return $pdf->stream();
	}
	public function print_order_convert($checkout_code){
		$order_details = OrderDetails::where('order_code',$checkout_code)->get();
		$order = Order::where('order_code',$checkout_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();
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
		$output='';
		$output.='<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border:1px solid #000;
		}
		.table-styling tbody tr td{
			border:1px solid #000;
		}
		</style>
		<p>Thông tin đơn hàng</p>
		<table class="table-styling">
		<thead>
			<tr>
			<th>Tên khách hàng</th>
			<th>Số điện thoại</th>
			<th>Email</th>
			</tr>
		</thead>
		<tbody>';
		$output.='
			<tr>
			<td>'.$customer->customer_name.'</td>
			<td>'.$customer->customer_phone.'</td>
			<td>'.$customer->customer_email.'</td>
			</tr>';
			$output.='
			</tbody>
		</table>
		<p>Thông tin vận chuyển</p>
		<table class="table-styling">
		<thead>
			<tr>
				
				<th>Tên người nhận</th>
				<th>Số điện thoại</th>
				<th>Địa chỉ</th>
				<th>Email</th>
				<th>Ghi chú</th>
			</tr>
		</thead>
		<tbody>';
		$output.='
			<tr>
				
				<td>'.$shipping->shipping_name.'</td>
				<td>'.$shipping->shipping_phone.'</td>
				<td>'.$shipping->shipping_address.'</td>
				<td>'.$shipping->shipping_email.'</td>
				<td>'.$shipping->shipping_notes.'</td>
				
				
			</tr>';
			$output.='
			</tbody>
		</table>
		<p>Thông tin đơn hàng</p>
		<table class="table-styling">
		<thead>
			<tr>
			<th>Tên sản phẩm</th>
			<th>Đơn giá</th>
			<th>Số lượng</th>
			<th>Mã giảm giá</th>
		
			<th>Thành tiền</th>
			</tr>
		</thead>
		<tbody>';
		$total=0;
			foreach($order_details_product as $key=>$product){
				$subtotal =$product->product_price*$product->product_sales_quantity;
				$total+=$subtotal;
			$output.='
				<tr>
					<td>'.$product->product_name.'</td>
					<td>'.number_format($product->product_price,0,',','.').'đ'.'</td>
					<td>'.$product->product_sales_quantity.'</td>
					<td>'.$product->product_coupon.'</td>
					
					<td>'.number_format($subtotal,0,',','.').'đ'.'</td>

				</tr>';
			}
				$output.='<tr>
					<td colspan="2">
						
						<p>Phí ship:'.number_format($product->product_feeship,0,',','.').'đ'.'</p>
						<p>Thanh toán:'.number_format($total + $product->product_feeship,0,',','.').'đ'.'</p>
					</td>
				</tr>';

			
			
			$output.='

			</tbody>
		</table>
		<p></p>
		<table>
			<thead>
				<tr>
					<th width="200px">Người lập phiếu </th>
					<th width="800px">Người nhận</th>
				</tr>
			</thead>
		<tbody>';
		$output.='
		</tbody>
		</table>';
		
		return $output;
	}
	public function view_order($order_code){
		$this->AuthLogin();
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
		
		return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));

	}
    public function manage_order(){
		$this->AuthLogin();
    	$order = Order::orderby('created_at','DESC')->get();
    	return view('admin.manage_order')->with(compact('order'));
	}
	
	public function manage_target(){
		$this->AuthLogin();
		//$product = Product::orderby('product_id','product_name','product_quantity','product_sold')->get();
		$product = Product::orderby('product_quantity','DESC')->get();
		//$order = Order::orderby('created_at','DESC')->get();
		return view('admin.manage_target')->with(compact('product'));
	}
	public function manage_targetup(){
		$this->AuthLogin();
		//$product = Product::orderby('product_id','product_name','product_quantity','product_sold')->get();
		$product = Product::orderby('product_quantity','ASC')->get();
		$order = Order::orderby('order_code','DESC')->get();
		//$order = Order::orderby('created_at','DESC')->get();
		return view('admin.manage_targetup')->with(compact('product'))->with(compact('order','order_details'));
	}
	
	public function target_month(){
		$this->AuthLogin();
		$product = Product::orderby('product_sold','DESC')->get();
		$order = Order::orderby('order_code','DESC')->get();
		$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
		return view('admin.show_target_month')->with(compact('order','order_details'));
	}
	public function tinh_target(Request $request){
		$this->AuthLogin();
		$data=array();
		$nam=$request->year_submit;
		$thang=$request->month_submit;
		//if($thang==DB::select('SELECT MONTH(created_at) FROM tbl_order') && $nam==DB::select('SELECT YEAR(created_at) FROM tbl_order')){
		$month=DB::select('SELECT MONTH(created_at) FROM tbl_order');
		if($thang==0 ||$nam==0){
			Session::put('message','Vui lòng chọn thời gian');
			$product = Product::orderby('product_sold','DESC')->get();
			$order = Order::orderby('order_code','DESC')->get();
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==1 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=1 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==2 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=2 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==3 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=3 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==4 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=4 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==5 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=5 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==6 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=6 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==7 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=7 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==8 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=8 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==9 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=9 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==10 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=10 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==11 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=11 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==12 && $nam==2020){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=12 AND YEAR(created_at)=2020 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==1 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=1 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==2 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=2 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==3 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=3 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==4 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=4 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==5 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=5 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==6 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=6 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==7 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=7 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==8 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=8 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==9 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=9 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==10 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=10 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==11 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=11 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
		if($thang==12 && $nam==2019){
			$product = Product::orderby('product_sold','DESC')->get();
			$order =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=12 AND YEAR(created_at)=2019 ');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			return view('admin.show_target_month')->with(compact('order','order_details'));
		}
			
	}
		public function uu_tien(){
			$this->AuthLogin();
			//$time =DB::select('SELECT * FROM tbl_order WHERE MONTH(created_at)=8 AND DAY(created_at)=11 AND (order_status)==1');
			$thang=8;
			$ngay=11;
			//$month=DB::select('SELECT');
			$order_details = OrderDetails::with('product')->orderby('order_code','DESC')->get();
			$order = Order::orderby('created_at','DESC')->WHERE('order_status',1)->get();

			return view('admin.uu_tien')->with(compact('order','order_details'));
		}
}
