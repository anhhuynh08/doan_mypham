@extends('admin_layout')
@section('admin_content')
<h2>Chào mừng bạn đến với trang quản lý</h2>
<div class="market-updates">
			<div class="col-md-3 market-update-gd">
				<div class="market-update-block clr-block-2">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-eye"> </i>
					</div>
					 <div class="col-md-8 market-update-left">
					 <h4>Số lượt truy cập </h4>
					<h3>0</h3>
					<p></p>
				  </div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<a href="{{URL::to('/customer-info')}}">
			<div class="col-md-3 market-update-gd">
				<div class="market-update-block clr-block-1">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-users" ></i>
					</div>
					@php
                    $i = 0;
                    @endphp
                    @foreach($all_customer as $key => $cus)
                    @php
                    $i++;
					@endphp
					@endforeach
					<div class="col-md-8 market-update-left">
					<h4>Lượng KH</h4>
						<h3>{{$i}}</h3>
						<p></p>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			</a>
			<a href="{{URL::to('/target-month')}}">
			<div class="col-md-3 market-update-gd">
				<div class="market-update-block clr-block-3">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-usd"></i>
					</div>
					@php 
					$i = 0;
					$total = 0;
					@endphp
					@foreach($order_details as $key => $details)

					@php 
					$i++;
					$subtotal = $details->product_price*$details->product_sales_quantity;
					$total+=$subtotal;
					@endphp
					
					@endforeach
					<div class="col-md-8 market-update-left">
						<h4>Doanh thu</h4>
						<h3>{{$total}}₫</h3>
						
						<p></p>
					</div>
					
				  <div class="clearfix"> </div>
				</div>
			</div>
			</a>
			<a href="{{URL::to('/manage-order')}}">
			<div class="col-md-3 market-update-gd">
				<div class="market-update-block clr-block-4">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    @php
                    $i = 0;
                    @endphp
                    @foreach($all_order as $key => $ord)
                    @php
                    $i++;
					@endphp
					@endforeach
					
					<div class="col-md-8 market-update-left">
						<h4>Số đơn hàng </h4>
						<h3>{{$i}}</h3>
						<p></p>
					</div>
					
				  <div class="clearfix"> </div>
				</div>
			</div>
			</a>
		   <div class="clearfix"> </div>
		</div>
	
                    
				
@endsection

