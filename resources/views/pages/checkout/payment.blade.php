@extends('layout')
@section('content')
    <section id="cart_items">
    <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                    <li class="active">Chi tiết giỏ hàng</li>
                </ol>
            </div>
           
        <div class="container">
            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2><br>
                <div class='row'>
                    <div class='col-sm-9'>
                        <div class="table-responsive cart_info">
                            <?php
                            $content= Cart::content();
                            ?>
                            <table class="table table-condensed">
                                <thead>
                                <tr class="cart_menu">
                                    <td class="image">Hình sản phẩm</td>
                                    <td class="description">Mô tả</td>
                                    <td class="price">Giá</td>
                                    <td class="quantity">Số lượng</td>
                                    <td class="total">Tổng tiền</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($content as $v_content)
                            <tr>
                                <td class="cart_product">
                                    <a href=""> <img src="{{URL::to('public/upload/image/'.$v_content->options->image)}}" width="50" alt="" /></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{$v_content->name}}</a></h4>
                                    <p>Mã sản phẩm : {{$v_content->id}}</p>
                                </td>
                                <td class="cart_price">
                                    <p>{{number_format($v_content->price).' '.'VNĐ'}}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <form action ="{{URL::to('/update-cart-quantity')}}" method="POST">
                                            {{ csrf_field() }}

                                        <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
                                        <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
                                        <input type="submit" value="cập nhật" name="update" class="btn btn-default btn-sm">
                                        </form>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        <?php
                                        $subtotal= $v_content->price * $v_content->qty;
                                        echo number_format( $subtotal).' '.'VNĐ';
                                        ?>

                                    </p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="{{URL::to('/delete-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>

                                @endforeach
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
            
        
    </section>
                <h4>Hình thức thanh toán</h4><br><br>
                <form action="{{URL::to('/order-place')}}" method="POST">
                {{csrf_field()}}
                <div class="payment-options">
                        <span>
                            <label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ</label>
                        </span>
                    <span>
                            <label><input name="payment_option" value="2" type="checkbox"> Thanh toán bằng tiền mặt</label>
                        </span><br>
                        <input type="submit"  value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
                </div>
               
           
@endsection
