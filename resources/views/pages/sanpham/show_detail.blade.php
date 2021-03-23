@extends('layout')
@section('content')
    @foreach($product_detail as $key =>$value)
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{URL::to('/public/upload/image/'.$value->product_image)}}" alt="" />
        </div>

    </div>
    
    <div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{$value->product_name}}</h2>
                                <p>Mã sản phẩm : {{$value->product_id}}</p>
								<img src="images/product-details/rating.png" alt="" />
								<form action="{{URL::to('/save-cart')}}" method="POST">
									@csrf
									<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                                          
								<span>
									<span>{{number_format($value->product_price,0,',','.').'₫'}}</span>
								

                                <p id="mota_product"><b>{{$value->product_desc}}</b></p></br>
                                <p ><b>Mô tả : </b>{{$value->product_content}}</p></br>
                                <p><b>Thương hiệu : </b>{{$value->brand_name}}</p></br>
								<p><b>Danh mục:</b> {{$value->category_name}}</p>
                                <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                                
                                @if($value->product_quantity!=0)
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}"  value="1" />
                                    <input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />
                                
								</span></br></br>
                                
                                <input type="button" value="CHỌN MUA" class="btn btn-sussces btn-sm add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart"/>
                                @else
                                <p style="color:red">Tạm hết hàng</p>
                                @endif
								</form>
							</div><!--/product-information-->
						</div>
</div><!--/product-details-->
@endforeach

<div class="recommended_items">
			<h2 class="title text-center">Sản phẩm liên quan</h2>
				<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
								<div class="item active">
							@foreach($relate as $key => $product)
							<a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 ">
                            <div class="product-image-wrapper">
                           
                                <div class="single-products">
                                        <div class="productinfo text-center">
                                            <form>
                                                @csrf
                                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_quantity}}"class="cart_product_quantity_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                                            <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                                            <img src="{{URL::to('public/upload/image/'.$product->product_image)}}"
                alt="" />
                                                <h2>{{number_format($product->product_price,0,',','.').' '.'₫'}}</h2>
                                                <p>{{$product->product_name}}</p>

                                             
                                             </a>
                                             @if($product->product_quantity!=0)
                                            <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                                            @else
                                            <p style="color:red">Tạm hết hàng</p>
                                            @endif
                                            </form>

                                        </div>
                                      
                                </div>
                           
                             
                            </div>
                    
                        </div>
            
            </a>
							@endforeach		
								</div>
									
						</div>
						{!!$relate->links()!!}			
				</div>
					
</div>
@endsection
