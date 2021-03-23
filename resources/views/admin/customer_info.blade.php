@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách khách hàng
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
            <div class="table-responsive" id="example">
               
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Mã khách hàng</th>    
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        
                        <th style="width:100px;">Tuỳ chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_user as $key => $customer)
                    
                    <tr>
                        <td>{{$customer->customer_id}}</td>
                        <td>{{$customer->customer_name}}</td>
                        <td>{{$customer->customer_phone}}</td>
                        <td>{{$customer->customer_email}}</td>
                        <td><a href="{{URL::to('/customer-ordered/'.$customer->customer_id)}}"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a></td>
                       
                        
                    </tr>
                @endforeach
                    
                    </tbody>
                </table>
            </div>
            
            
           
        </div>
    </div>


@endsection
