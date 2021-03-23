
@extends('layout')
@section('content')


               
            
<div class="row">
        <div class="col-lg-12">
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
                                $customer_id=Session::get('customer_id');
                                $customer_name=Session::get('customer_name');
                                $customer_password=Session::get('customer_password')
                                     
                        ?>
            <section class="panel">
            <h3 class="text-primary">Đổi mật khẩu</h3>
            <form role="form" action="{{URL::to('/save-update-password/'.$customer_id)}}"  method="POST" > 
            {{csrf_field()}}
                
                    
                <div class="form-group">
                    <label for="user_signin">Mật khẩu mới</label>
                    <input name="password" type="password" class="form-control" id="new_pass" >
                    @if($errors->has('password'))
                        <div class="alert alert-danger">{{$errors->first('password')}}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="user_signin">Nhập lại mật khẩu mới</label>
                    <input name="re_password" type="password" class="form-control" id="re_new_pass" >
                    @if($errors->has('re_password'))
                        <div class="alert alert-danger">{{$errors->first('re_password')}}</div>
                    @endif
                </div>
                <div class="alert alert-danger hidden"></div>
                <button type="submit" class="btn btn-info" id="submit_change_pass">
                    <span class="glyphicon glyphicon-ok"></span> Đổi mật khẩu
                </button>
                
                <br><br> 
               
             
                
            </form>  
            </section>
          
        </div>
       
    </div>
   

@endsection

