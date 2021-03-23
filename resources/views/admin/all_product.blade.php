@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách sản phẩm
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
                        
                        <th>Tên sản phẩm</th>
                        <th>Số lượng còn</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Hình ảnh</th>
                        <th>Nội dung</th>

                        <th>Hiển thị</th>

                        <th style="width:100px;">Tuỳ chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_product as $key =>$pro)
                        <tr>
                            
                            <td>{{$pro->product_name}}</td>
                            <td>{{$pro->product_quantity}}</td>
                            <td>{{$pro->product_price}}</td>
                            <td>{{$pro->product_desc}}</td>
                            <td>{{$pro->category_name}}</td>
                            <td>{{$pro->brand_name}}</td>
                            <td><img src="public/upload/image/{{$pro->product_image}}"height="100" width="100"> </td>
                            <td>{{$pro->product_content}}</td>

                            <td><span class="text-ellipsis">
                                <?php
                                    if($pro->product_status==0){
                                    ?>
                                    <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                                    <?php
                                    }else{
                                    ?>
                                    <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                                    <?php

                                    }
                                    ?>
                            </span></td>
                            <td>
                                <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <a onclick="return confirm('Bạn chắc chắn muốn xoá sản phẩm này?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            
            {!!$all_product->links()!!}
        </div>
    </div>

    
@endsection
