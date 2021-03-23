
@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin đặt hàng
            </div>
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger">
            {{session()->get('error')}}
            </div>
            @endif
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
            <a href="{{URL::to('/view-order/'.$infoorder->order_code)}}" class="active" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Xem</a>
            </td>
          </tr>
          @if($infoorder->order_code==null||$infoorder->order_code=="")
                <p>trong</p>
          
         @endif
          @endforeach
        </tbody>
      </table>
 
        
        </div>
    </div>


@endsection
