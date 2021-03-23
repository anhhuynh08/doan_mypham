@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách danh mục
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
                        <th>Mã danh mục</th>
                        <th>Tên danh mục</th>
                        <th>Hiển thị</th>

                        <th style="width:100px;">Tuỳ chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_category_product as $key => $cate_pro)
                    <tr>
                        <td>{{$cate_pro->category_id}}</td>
                        <td>{{$cate_pro->category_name}}</td>
                        <td><span class="text-ellipsis">
                                <?php
                                if($cate_pro->category_status==1){
                                    ?>
                                    <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                                    <?php
                                }else{
                                    ?>
                                    <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                                    <?php

                                }
                                ?>
                            </span></td>
                        <td>
                            <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                            <a onclick="return confirm('Bạn chắc chắn muốn xoá danh mục này?')" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">
                            <i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
        {!!$all_category_product->links()!!}
    </div>
    

@endsection
