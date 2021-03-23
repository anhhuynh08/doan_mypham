@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách mã giảm giá
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
                        <th>Tên mã</th>
                        <th>Mã giảm</th>
                        <th>Số lượng</th>
                        <th>Điều kiện</th>
                        <th>Số giảm</th>
                        

                        <th style="width:100px;">Tuỳ chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupon as $key => $cou)
                        <tr>
                            
                            <td>{{$cou->coupon_name}}</td>
                            <td>{{$cou->coupon_code}}</td>
                            <td>{{$cou->coupon_time}}</td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if($cou->coupon_condition==1){
                                    ?>
                                    Giảm theo %
                                    <?php
                                    }else{
                                        
                                    ?>
                                        Giảm theo tiền
                                    
                                    <?php

                                    }
                                    ?>
                            </span></td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if($cou->coupon_condition==1){
                                    ?>
                                    Giảm {{$cou->coupon_number}} %
                                    <?php
                                    }else{
                                        
                                    ?>
                                        Giảm {{$cou->coupon_number}} ₫
                                    
                                    <?php

                                    }
                                    ?>
                            </span></td>
                            <td>
                                

                                <a onclick="return confirm('Bạn chắc chắn muốn xoá mã này?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active" ui-toggle-class="">
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
