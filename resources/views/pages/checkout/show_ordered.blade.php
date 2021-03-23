@extends('layout')
@section('content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin đặt hàng
            </div>
            <div class="table-responsive">
            <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Mã đơn hàng</th>
            <th>Thời gian đặt</th>
            <th>Tình trạng đơn hàng</th>
            
            <th>Tuỳ chọn</th>
          </tr>
        </thead>
        <tbody>
        @foreach($order as $key =>$infoorder)
          <tr>
          <td>{{$infoorder->order_code}}</td>
            <td>{{$infoorder->created_at}}</td>
            <td>@if($infoorder->order_status==1)
                            Đang xử lý
                            @elseif($infoorder->order_status==2)
                            Đã giao
                            @else
                            Đã huỷ
                            @endif
            </td>
            <td>
                <a href="{{URL::to('/show-ordered-details/'.$infoorder->order_code)}}" class="btn btn-success" >Xem lại</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
 
        
        </div>
    </div>
       


@endsection
