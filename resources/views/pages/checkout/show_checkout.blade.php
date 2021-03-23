

@extends('layout')
@section('content')
@php
                    $total=0;
                    @endphp
                    @if(Session::get('cart')==true)
    <section id="cart_items">
        <div class="#">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li class="active">Tiến hành đặt hàng</li>
                </ol>
                @if(session()->has('message'))
                <div class="alert alert-success">
                {!!session()->get('message')!!}
                </div>
                @elseif(session()->has('error'))
                <div class="alert alert-danger">
                {!!session()->get('error')!!}
                </div>
                @endif
            </div>
            
            <div class="shopper-informations">
            <div class='row'>
                <div class='col-sm-12'>
                <div class="table-responsive cart_info">
                <form action ="{{url('/update-cart')}}" method="POST">
                                    {{ csrf_field() }}
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình sản phẩm</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td>Tuỳ chọn</td>
                    </tr>
                    </thead>
                    
                    <tbody>
                   
                 
                   
                    @foreach(Session::get('cart') as  $key =>$cart)
                    <?php
                        $subtotal =$cart['product_price']* $cart['product_qty'];
                        $total =$total + $subtotal;
                    ?>
                    <tr>
                        <td class="cart_product">
                            <a href=""> <img src="{{asset('public/upload/image/'.$cart['product_image'])}}" width="50" alt="{{$cart['product_name']}}" /></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href=""></a></h4>
                            <p>{{$cart['product_name']}} </p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($cart['product_price'],0,',','.')}}.₫</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                               

                                <input class="cart_quantity_" type="number" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  min="1">
                                <input type="hidden" value="" name="rowId_cart" class="form-control">
                                
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                            {{number_format($subtotal,0,',','.')}}₫

                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    
                    @endforeach
                   
                   
                    <tr>
                    <td> <input type="submit" value="Cập nhật giỏ hàng" name="update" class="btn btn-success btn-sm"></td>
                    </tr>
                    
                    </tbody>
                   
                     </form>
                </table>
                <form method="POST" action="{{url('/check-coupon')}}">
                            @csrf
                            <div class="form-row"><br>
  
                                <div class="input-group mb-3">
                                <input type="text" class="form-control mb-2" aria-label="Recipient's username" aria-describedby="basic-addon2" name="coupon" placeholder="Nhập mã giảm giá" required  />
                                </div>
                                <div class="col-3">
                                <button type="submit" class="btn btn-success check_coupon"  name="check_coupon">Đồng ý</button>
                                
                                @if(Session::get('coupon'))
                                <a href="{{url('/unset-coupon')}}" class="btn btn-danger delete_code_coupon"  >Xoá mã khuyến mãi</a>
                                @endif
                                </div>
                            
                            </div>
                                                        
                            </form>
            </div>   
            
            <div class="col-xl-6">
            <form>
                                    @csrf 
                                <div class="content">
                                <h4>Vui lòng chọn địa chỉ của bạn để ước tính phí vận chuyển</h4>
                                    <div class="col-4">
                                        <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn thành phố</label>
                                        <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                        
                                                <option value="">--Chọn tỉnh thành phố--</option>
                                                @foreach($city as $key => $ci)
                                                <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                            @endforeach
                                                
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn quận huyện</label>
                                        <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                                <option value="">--Chọn quận huyện--</option>
                                            
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn xã phường</label>
                                        <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                                <option value="">--Chọn xã phường--</option>   
                                        </select>
                                        </div>
                                    </div>
                                </div>
                               
                                
                                  
                               
                               
                                <input type="button" value="Tính phí vận chuyển" name="calculate_order" class="btn btn-success  calculate_delivery">


                            </form>
            </div>
                            
   <div class="container1">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="total_area">
                    <ul>
                        <li>Tạm tính <span>{{number_format($total,0,',','.')}}₫</span></li>
                        @if(Session::get('fee'))
                        <li>Phí vận chuyển <span>{{number_format(Session::get('fee'),0,',','.')}}₫</span></li>
                        @else
                        <li>Phí vận chuyển <span style="color:red">Hãy chọn khu vực vận chuyển nếu không phí sẽ được cộng vào sau khi đặt hàng là 40.000đ</span></li>
                        @endif
                        @if(Session::get('coupon'))
                        <li> Giảm giá:
                        
                            @foreach(Session::get('coupon') as $key =>$cou)
                            @if($cou['coupon_condition']==1)
                            <span>Mã giảm:{{$cou['coupon_number']}}%</span>
                            <span>
                                @php 
                                $total_coupon=($total*$cou['coupon_number'])/100;
                                echo '<p><li>Tiền giảm:<span>'.number_format($total_coupon,0,',','.').'₫</span></li></p>';
                                @endphp
                            </span>
                            </li>
                           <li>Thành tiền <span>{{number_format($total-$total_coupon + Session::get('fee'),0,',','.')}}₫</span></li>
                           @elseif($cou['coupon_condition']==2 && number_format($total,0,',','.')>=100)
                        <span>{{number_format($cou['coupon_number'],0,',','.')}}₫</span>
                            <span>
                                @php 
                                $total_coupon=$total-$cou['coupon_number'];
                                @endphp
                            </span>
                            
                           <li>Thành tiền <span>{{number_format($total_coupon + Session::get('fee'),0,',','.')}}₫</span></li>
                          @else
                          <span style="color:red">Mã giảm áp dụng cho hoá đơn từ 100.000₫</span>
                          <li>Thành tiền <span>{{number_format($total+ Session::get('fee'),0,',','.')}}₫</span></li>
                           @endif
                           
                            @endforeach
                        @else
                        <li>Thành tiền <span>{{number_format($total+ Session::get('fee'),0,',','.')}}₫</span></li>

                        
                        @endif
                        
                        
                        
                        
                        </li>
                        
                        
                        
                    </ul>
                    
                       
                        
                </div>
            </div>
        </div>
    </div>                            
            
			<div class="col-xl-12 ">
            <h4>Thông tin người nhận</h4><br>
							
							<div class="form-one">
								<form method="POST" >
									@csrf
									<input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên người nhận" required />
                                    <input type="email" id="email"  name="shipping_email" class="shipping_email" placeholder="Email" required />
									<input type="text" name="shipping_phone" id="mobile" class="shipping_phone" placeholder="Số điện thoại" required />
                                    <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ: số nhà, tên đường, phường, quận, thành phố.." required />
									<textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="4"required ></textarea>
		
									@if(Session::get('fee'))
										<input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
									@else 
										<input type="hidden" name="order_fee" class="order_fee" value="40000">
									@endif

									@if(Session::get('coupon'))
										@foreach(Session::get('coupon') as $key => $cou)
											<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
										@endforeach
									@else 
										<input type="hidden" name="order_coupon" class="order_coupon" value="no">
									@endif
									
									
									
									<div class="">
										 <div class="form-group">
		                                    <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
		                                      <select name="shipping_method"  class="form-control input-sm m-bot15 shipping_method">
                                                    <option value="3">---Chọn---</option>
		                                            <option value="0">Qua chuyển khoản</option>
		                                            <option value="1">Tiền mặt</option>   
		                                    </select>
		                                </div>
									</div>
									 <td>
                                        <button type="button" value="Đặt hàng" name="send_order" class="btn btn-success  send_order">Đặt hàng</button>
                        
                                    </td>
								</form>
								
							</div>
			
            </div>
			
           
            
           
        
           
            
    
           
    </section>
    @else
                    <p>Giỏ hàng trống</p>
                    @endif
@endsection
