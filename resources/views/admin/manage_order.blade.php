@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách đơn hàng
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
                        <th>Mã đơn hàng</th>
                        <th>Thời gian đặt</th>
                        <th>Tình trạng</th>
                        <th style="width:100px;">Tuỳ chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach($order as $key => $ord)
                    @php
                    $i++;
                    @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$ord->order_code}}</td>
                        <td>{{$ord->created_at}}</td>
                     
                        <td>@if($ord->order_status==1)
                            Đang xử lý
                            @else
                            Đã xử lý
                            @endif
                        </td>
                        <td>
                            <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                            <a onclick="return confirm('Bạn chắc chắn muốn xoá đơn hàng này không ?')" href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active" ui-toggle-class="">
                            <i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>


@endsection
