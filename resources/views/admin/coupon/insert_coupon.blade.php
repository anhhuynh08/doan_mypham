@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mã giảm giá
            </header>
            <div class="panel-body">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger">
            {{session()->get('error')}}
            </div>
            @endif
                <div class="position-center">
                    <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên mã giảm giá</label>
                            <input name="coupon_name" type="text" class="form-control" placeholder="Tên mã giảm giá">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mã giảm giá</label>
                            <input id="exampleInputPassword1" rows="5" class="form-control" name="coupon_code" placeholder="Mã giảm giá">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng mã</label>
                            <input id="exampleInputPassword1" rows="5" class="form-control" name="coupon_time" placeholder="Số lượng mã">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tính năng</label>
                                <select name="coupon_condition" class="form-control input-sm m-bot15">
                                <option value="0">----chọn----</option>
                                    <option value="1">Giảm theo %</option>
                                    <option value="2">Giảm theo tiền</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nhập số % hoặc tiền giảm</label>
                            <input id="exampleInputPassword1" rows="5" class="form-control" name="coupon_number" placeholder="Số lượng mã">
                        </div>
                       
                        <button type="submit" name="save_category_product" class="btn btn-info">Thêm mã</button>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>


    @endsection
