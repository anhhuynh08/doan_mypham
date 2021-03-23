@extends('admin_layout')
@section('admin_content')
<div class="row">
@if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger">
            {{session()->get('error')}}
            </div>
            @endif
            <?php
                                $admin_id=Session::get('admin_id');
                                $admin_name=Session::get('admin_name');
                                $admin_password=Session::get('admin_password')
                                     
                        ?>
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">Đổi mật khẩu</div>
            <div class="panel-body">
                 <form role="form" action="{{URL::to('/save-update-pass-admin/'.$admin_id)}}"  method="POST" > 
                    {{csrf_field()}}
                    <fieldset>
                    <!-- <div class="form-group">
                            <lable>Mật khẩu cũ</lable>
                            <input id="old_pass" class="form-control" name="old_password" type="password" value="" required />
                            @if($errors->has('old_password'))
                                
                                <div class="alert alert-danger">{{$errors->first('old_password')}}</div>
                            @endif
                            @if($admin_password=='old_password')
                                <p>mật khẩu k khớp</p>
                            @endif

                        </div> -->
                        <div class="form-group">
                            <lable>Mật khẩu mới</lable>
                            <input id="pass" class="form-control" name="password" type="password" value="" required />
                            @if($errors->has('password'))
                                <div class="alert alert-danger">{{$errors->first('password')}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <lable>Nhập lại mật khẩu mới</lable>
                            <input id="pass" class="form-control" name="re_password" type="password" value="" required />
                            @if($errors->has('re_password'))
                                <div class="alert alert-danger">{{$errors->first('re_password')}}</div>
                            @endif
                        </div>  
                       
                        <input class="btn btn-primary add_admin" type="submit" value="Đổi mật khẩu" >
                    </fieldset>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div>



@endsection
