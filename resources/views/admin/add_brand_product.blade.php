
@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thương hiệu sản phẩm
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
                    
                        <form role="form" id="formDemo"  action="{{URL::to('/save-brand-product')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input name="brand_product_name" id="exampleInputEmail1" type="text"  class="form-control" placeholder="tên thương hiệu " required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả</label>
                                <textarea id="exampleInputPassword1" rows="5" class="form-control" name="brand_product_desc" placeholder="Mô tả thương hiệu"required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="brand_product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                            <button type="submit" name="save_category_product" class="btn btn-info ">Thêm thương hiệu</button>
                        </form>
                        
                    </div>

                </div>
            </section>
            <!-- <button type="button" name="add_brand" class="add_brand ">Thêm thương hiệu</button> -->
        </div>
    </div>

@endsection
