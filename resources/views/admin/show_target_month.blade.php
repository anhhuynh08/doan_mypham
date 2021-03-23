<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
        $(document).ready(function() {
            $('#year').change(function(){
                var nam=$(this).val();
                
            });
        });
</script>
<script>
        $(document).ready(function() {
            $('#month').change(function(){
                var thang=$(this).val();
               
            });
        });
</script>

       
@extends('admin_layout')
@section('admin_content')

<div class="panel-heading">
    
     
    <form action="{{URL::to('/tinh-target')}}" method="POST">
                    {{csrf_field()}}
                    Các sản phẩm đã bán trong
                    <select name="year_submit" id="year" size="1" required>
                        <option value="0">--Năm--</option>
                        
                        <option value="2019">Năm 2019</option>
                        <option value="2020">Năm 2020</option>
                    </select>
                    
                    <select name="month_submit" id="month" size="1" required>
                        <option value="0">--Tháng--</option>
                        <option value="1">Tháng 1</option>
                        <option value="2">Tháng 2</option>
                        <option value="3">Tháng 3</option>
                        <option value="4">Tháng 4</option>
                        <option value="5">Tháng 5</option>
                        <option value="6">Tháng 6</option>
                        <option value="7">Tháng 7</option>
                        <option value="8">Tháng 8</option>
                        <option value="9">Tháng 9</option>
                        <option value="10">Tháng 10</option>
                        <option value="11">Tháng 11</option>
                        <option value="12">Tháng 12</option>
                    </select>
                            
                
                    <input type="submit" style="color:#000" name="tinh-targer" class="btn btn-success btn-sm"  value="Xem"/>     
    </form>   
 </div>
 <div class="">
  @php
                    
                    $total=0;
                    
                    
                    @endphp
  <div class="table-agile-info">
        <div class="panel panel-default">
            
            <div class="table-responsive">
                <?php
                $message=Session::get('message');
                if($message){
                    echo '<span class="text-alert_err" >',$message,'</span>';
                    Session::put('message',null);
                }
                ?></br>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        
                        <th>Thời gian</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($order as $key => $ord)
                    @php
                       
                    @endphp
                    @php
                        
                        
                    @endphp
                  
                       
                        
                       @foreach($order_details as $key => $de)
                       @if( $ord->order_code==$de->order_code&& $ord->order_status==2)
                        @php
                            $subtotal =$de['product_price']* $de['product_sales_quantity'];
                            $total = $total + $subtotal;
                        @endphp
                        
                        <tr>
                        
                            <td>{{$ord->created_at}}</td>
                            <td>{{$ord->order_code}}</td>
                            <td>{{$de->product_name}}</td> 
                             <td>{{$de->product_sales_quantity}}</td> 
                            <td>{{number_format($subtotal,0,',','.')}}₫</td>    
                        </tr>
                        @endif
                         @endforeach 
                   
                @endforeach
                        
                        
                    </tbody>
                </table>
                
                <table class="table">
                <thead>
                    <tr>
                        <td>Doanh thu</td>
                        <td>{{number_format($total,0,',','.')}}₫</td>
                    </tr>
                    </thead>
                </table>
                
            </div>
          
        </div>
  </div>
  
  </div>
 

@endsection
