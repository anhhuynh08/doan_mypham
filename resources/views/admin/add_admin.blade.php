<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>

<script>
    function checkpass() {
    var flag = false;
    var pass = $('#pass').val().trim(); // ID của trường pass
    
    if (pass.length < 6) {
        flag = false;
    }
    else{
        flag=   true;
    }
    return flag;
}
</script>
<script>
    $(document).ready(function() {
    $('#formDemo').submit(function(e) { // ID của Form
    if (!checkpass()) {
        alert("mật khẩu phải lớn hơn 6 ký tự");
        $('#pass').parents('div.form-group').addClass('has-error'); // ID của trường Số điện thoại
        $('#pass').focus(); // ID của trường Số điện thoại
        e.preventDefault();
    }
    
});
   
$('#pass').keypress(function() { // ID của trường Số điện thoại
    $(this).parents('div.form-group').removeClass('has-error');
});
});
</script>
<script>
    function checkPhoneNumber() {
    var flag = false;
    var phone = $('#mobile').val().trim(); // ID của trường Số điện thoại
    phone = phone.replace('(+84)', '0');
    phone = phone.replace('+84', '0');
    phone = phone.replace('0084', '0');
    phone = phone.replace(/ /g, '');
    if (phone != '') {
        var firstNumber = phone.substring(0, 2);
        if ((firstNumber == '09' || firstNumber == '08') && phone.length == 10) {
            if (phone.match(/^\d{10}/)) {
                flag = true;
            }
        } else if (firstNumber == '01' && phone.length == 11) {
            if (phone.match(/^\d{11}/)) {
                flag = true;
            }
        }
    }
    return flag;
}
</script>
<script>
    $(document).ready(function() {
    $('#formDemo').submit(function(e) { // ID của Form
    if (!checkPhoneNumber()) {
        alert("Số điện thoại không tồn tại");
        $('#mobile').parents('div.form-group').addClass('has-error'); // ID của trường Số điện thoại
        $('#mobile').focus(); // ID của trường Số điện thoại
        e.preventDefault();
    }
});
   
$('#mobile').keypress(function() { // ID của trường Số điện thoại
    $(this).parents('div.form-group').removeClass('has-error');
});
});
</script>
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
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">Thêm người quản lý</div>
            <div class="panel-body">
                <form id="formDemo" role="form" action="{{URL::to('/save-add-admin')}}" method="post">
                    {{csrf_field()}}
                    <fieldset>
                        <div class="form-group">
                            <lable>Họ Tên</lable>
                            <input class="form-control"  name="admin_name" type="text" autofocus="" required />
                        </div>
                       
                        <div class="form-group">
                            <lable>Email</lable>
                            <input class="form-control"  name="admin_email" type="text" autofocus="" required />
                        </div>
                        <div class="form-group">
                            <lable>Số điện thoại</lable>
                            <input id="mobile" class="form-control " name="admin_phone" type="text" autofocus="" required />
                        </div>
                        <div class="form-group">
                            <lable>Mật khẩu</lable>
                            <input id="pass" class="form-control" name="admin_password" type="password" value="" required />
                        </div>
                       
                        <input class="btn btn-primary add_admin" type="submit" value="Thêm" name="add_admin">
                    </fieldset>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div>
                

@endsection