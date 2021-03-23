<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
@extends('admin_layout')
@section('admin_content')

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>
            <div class="table-responsive">
            <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td>{{$customer->customer_email}}</td>
          </tr>
        </tbody>
      </table>
            </div>
        </div>
    </div>
    </br></br>
    <div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin vận chuyển
    </div>
    
    
    <div class="table-responsive">
                     
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
          
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        
          <tr>
           
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
             <td>{{$shipping->shipping_phone}}</td>
             <td>{{$shipping->shipping_email}}</td>
             <td>{{$shipping->shipping_notes}}</td>
             <td>@if($shipping->shipping_method==0) Chuyển khoản @else Tiền mặt @endif</td>
            
          
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
    </br></br>
    <div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
      Chi tiết đơn hàng
    </div>
   
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th >STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng còn</th>
            <th>Mã giảm giá</th>
            <th>Phí ship hàng</th>
            <th>Số lượng</th>
            <th>Giá sản phẩm</th>
            <th>Tổng tiền</th>
            
            <th style="width:30px;"></th>
          </tr> 
        </thead>
        <tbody>
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
          <tr class="">
           
            <td><i>{{$i}}</i></td>
            <td>{{$details->product_name}}</td>
            <td class="color_qty_{{$details->product_id}}">{{$details->product->product_quantity}}</td>
            <td>@if($details->product_coupon!='no')
                  {{$details->product_coupon}}  
                @else 
                  Không mã
                @endif
            </td>
            <td>{{number_format($details->product_feeship ,0,',','.')}}₫</td>
            <td>
                <input style="max-width: 50px" class ="order_qty_{{$details->product_id}}" type="number" min="1"{{$order_status==2 ?'disabled' :''}} value="{{$details->product_sales_quantity}}" name="product_sales_quantity">
                <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantity}}">   
                <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">   
                <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">      
                @if($order_status!=2)       
                <button data-product_id="{{$details->product_id}}" class="btn btn-success update_quantity" name="update_quantity" >Thay đổi</button>
                @endif
            </td>
            <td>{{number_format($details->product_price ,0,',','.')}}₫</td>
            <td>{{number_format($subtotal ,0,',','.')}}₫</td>
          </tr>
        @endforeach
          
        </tbody>
      </table>   
      <tr>
            <td colspan="2">  
            @php 
                $total_coupon = 0;
              @endphp
              @if($coupon_condition==1)
               <li class="list-group-item list-group-item-success"> <span>
                  @php
                  $total_after_coupon = ($total*$coupon_number)/100;
                  echo 'Tổng giảm :'.number_format($total_after_coupon,0,',','.').'₫'.'</br>';
                  $total_coupon = $total - $total_after_coupon + $details->product_feeship;
                  @endphp
                  </span></li>
              @else 
              <li class="list-group-item list-group-item-success"><span>
                  @php
                  
                  echo 'Tổng giảm :'.number_format($coupon_number,0,',','.').'₫'.'</br>';
                  $total_coupon = $total - $coupon_number + $details->product_feeship;

                  @endphp
                  </span></li>
              @endif

             <li class="list-group-item list-group-item-success">Phí ship :<span> {{number_format($details->product_feeship,0,',','.')}}₫</span></li> 
             <li class="list-group-item list-group-item-success">Thành tiền: <span>{{number_format($total_coupon,0,',','.')}}₫</span></li>
            </td>
          </tr>  
          <tr>
              <td colspan="6">
              @foreach($order as $key => $or)
                @if($or->order_status==1)
                <form>
                @csrf 
                    <select class="form-control order_details">
                            <option value="" >---Tình trạng đơn hàng---</option>
                            <option id="{{$or->order_id}}"selected value="1">Đang xử lý</option>
                            <option id="{{$or->order_id}}" value="2">Đã giao</option>
                            <option id="{{$or->order_id}}" value="3">Đã huỷ đơn</option>
                    </select>
                </form>
                @elseif($or->order_status==2)
                <form>
                @csrf 
                    <select class="form-control order_details">
                            <option value="" >---Tình trạng đơn hàng---</option>
                            <option id="{{$or->order_id}}" value="1">Đang xử lý</option>
                            <option id="{{$or->order_id}}" selected value="2">Đã giao</option>
                            <option id="{{$or->order_id}}" value="3">Đã huỷ đơn</option>
                    </select>
                </form>
                @else
                <form>
                @csrf 
                    <select class="form-control order_details">
                            <option value=""  >---Tình trạng đơn hàng---</option>
                            <option id="{{$or->order_id}}" value="1">Đang xử lý</option>
                            <option id="{{$or->order_id}}"  value="2">Đã giao</option>
                            <option id="{{$or->order_id}}" selected value="3">Đã huỷ đơn</option>
                    </select>
                </form>
                @endif
                @endforeach
              </td>
          </tr>      
      <a target="_blank" href="{{url('/print-order/'.$details->order_code)}}">In đơn hàng</a>
      
    </div>
   
  </div>
</div>

@endsection
