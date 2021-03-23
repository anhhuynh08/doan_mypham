@extends('layout')
@section('content')

<div class="features_items">
    <h2 class="title text-center">Sản phẩm mới</h2>
    @foreach($all_product as $key =>$product)
       
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6  ">
        <div class="product-image-wrapper">
        
            <div class="single-products">
                <div class="productinfo text-center">
                <form>
                @csrf
                <input type="hidden" value="{{$product->product_id}}"
                class="cart_product_id_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_name}}"
                class="cart_product_name_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_image}}"
                class="cart_product_image_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_price}}"
                class="cart_product_price_{{$product->product_id}}">
                <input type="hidden" value="{{$product->product_quantity}}"
                class="cart_product_quantity_{{$product->product_id}}">
                <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                <img src="{{URL::to('public/upload/image/'.$product->product_image)}}"
                alt="" />
                <h2>{{number_format($product->product_price).' '.'₫'}}</h2>
                <p>{{$product->product_name}}</p>

                </a>
                @if($product->product_quantity!=0) 
                <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
                @else
                <p style="color:red">Tạm hết hàng</p>
                @endif                        
                
 </form></div>

            </div>
        </div>
    </div>
       
@endforeach
</div><!--features_items-->

@endsection
