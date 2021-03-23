<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>

@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách thương hiệu
            </div>
            <div class="table-responsive" id="example">
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
                        <th>Mã thương hiệu</th>    
                        <th>Tên thương hiệu</th>
                        <th>Hiển thị</th>

                        <th style="width:100px;">Tuỳ chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($all_brand_product as $key => $brand_pro)
                    
                        <tr>
                        <td>{{$brand_pro->brand_id}}</td>
                            <td>{{$brand_pro->brand_name}}</td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if($brand_pro->brand_status==1){
                                    ?>
                                    <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                                    <?php
                                    }else{
                                    ?>

                                    <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}"><i class="fa fa-square-o" aria-hidden="true"></i></i></a>
                                    <?php

                                    }
                                    ?>
                            </span></td>
                            <td>
                                <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <a onclick="return confirm('Bạn chắc chắn muốn xoá danh mục này?')" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            
            {!!$all_brand_product->links()!!}
            <!-- <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer> -->
        </div>
    </div>


@endsection
