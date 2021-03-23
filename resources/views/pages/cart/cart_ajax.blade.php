@extends('layout')
@section('content')
    <section id="cart_items">
         @php
                    $total=0;
         @endphp
        @if(Session::get('cart')==true)
        <div class="container1">
            <h4>Chi tiết giỏ hàng</h4>
            @if(session()->has('message'))
            <div class="alert alert-success">
                {!!session()->get('message')!!}
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger">
            {!!session()->get('error')!!}
            </div>
            @endif
           <div class='row'>
                <div class='col-sm-12'>
                
                <div class="table-responsive cart_info">
                <form action="{{url('/update-cart')}}" method="POST">
					@csrf
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
                    @if(Session::get('cart')==true)
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
								
								
									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >
								
									
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
                    @else
                    <p>Giỏ hàng trống</p>
                    @endif
                     </form>
                </table>
                <form method="POST" action="{{url('/check-coupon')}}">
                            @csrf
                            <div class="form-row"><br>
  
                                <div class="input-group mb-3">
                                <input type="text" class="form-control mb-2" aria-label="Recipient's username" aria-describedby="basic-addon2" name="coupon" placeholder="Nhập mã giảm giá" required />
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
           
                </div>
           </div>
           
        </div> 
        
    </section>
   
    <section id="do_action">
        <div class="container1">
        
            <div class="row">
                <div class="col-sm-12">
                    <div class="total_area">
                        <ul>
                            <li>Tạm tính <span>{{number_format($total,0,',','.')}}₫</span></li>
                            <!-- <li>Phí vận chuyển <span></span></li> -->
                            
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
                               <li>Thành tiền <span>{{number_format($total-$total_coupon,0,',','.')}}₫</span></li>
                               @elseif($cou['coupon_condition']==2 && number_format($total,0,',','.')>=100)
                            <span>{{number_format($cou['coupon_number'],0,',','.')}}₫</span>
                                <span>
                                    @php 
                                    $total_coupon=$total-$cou['coupon_number'];
                                    @endphp
                                </span>
                                
                               <li>Thành tiền <span>{{number_format($total_coupon,0,',','.')}}₫</span></li>
                              
                               @else
                                <span style="color:red">Mã giảm áp dụng cho hoá đơn từ 100.000₫</span>
                                <li>Thành tiền <span>{{number_format($total,0,',','.')}}₫</span></li>
                               @endif
                               
                                @endforeach
                            @else
                            <li>Thành tiền <span>{{number_format($total,0,',','.')}}₫</span></li>

                            
                            @endif
                            
                            
                            
                            
                            </li>
                            
                            
                            
                        </ul>
                        
                            <td>
                            @if(Session::get('customer_id'))
                             <a class="btn btn-success check_out" href="{{URL::to('/checkout')}}">Tiến hành đặt hàng</a><br>
                            @else
                            <a class="btn btn-success check_out" href="{{URL::to('/login-checkout')}}">Tiến hành đặt hàng</a><br>
                            @endif
                            
                            </td>
                            
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
                    <tr>
                    <?php
                    Session::forget('cart');
                        Session::forget('coupon');
                        echo 'Không có sản phẩm nào trong giỏ hàng của bạn';
                    ?>
                    <a href="{{URL::to('/trang-chu')}}" class="btn btn-info">Tiếp tục mua sắm</a>
                    </tr>
                    @endif<!--/#do_action-->

@endsection
