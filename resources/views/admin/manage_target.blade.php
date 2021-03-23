@extends('admin_layout')
@section('admin_content')
@php
                    $total=0;
                    @endphp
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Các sản phẩm tồn kho
            </div>
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
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng còn</th>
                        <th>Số lượng bán</th>
                     
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach($product as $key => $pro)
                    
                    <?php
                        $subtotal =$pro['product_price']* $pro['product_sold'];
                        $total = $total + $subtotal;
                    ?>

                    @if($pro->product_sold==0)
                    @php
                    $i++;
                    @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$pro->product_id}}</td>
                        <td>{{$pro->product_name}}</td>
                        <td>{{$pro->product_quantity}}</td>
                        <td>{{$pro->product_sold}}</td>
                        
                    </tr>
                    @endif
                @endforeach
                        
                        
                    </tbody>
                </table>
                
                
                
            </div>
          
        </div>
    </div>


@endsection
