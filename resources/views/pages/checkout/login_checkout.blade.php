<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script>
    function validateform() {
        var email_account = document.myform.email_account.value;
        var password_account = document.myform.password_account.value;
 
        if (email_account == null || email_account == "") {
        
           alert("Tên đăng nhập không được để trống");
            return false;
        } else if (password_account.length < 6) {
            alert("Mật khẩu không được dưới 6 ký tự");
            return false;
        }
    }
</script>
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

@extends('layout')
@section('content')
    <section id="form">
        <div class="container">
       
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
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form">
                        <h2>Đăng nhập</h2>
                        <form name="myform" action="{{URL::to('/login-customer')}}" method="POST" onsubmit="return validateform()">
                        {{ csrf_field() }}
                            <input name="email_account" type="text" placeholder="Email hoặc SĐT" required />
                            
                            <input name="password_account" type="password" placeholder="Mật khẩu" required/>
                           
                            <button type="submit" value="register" class="btn btn-default">Đăng nhập</button>
                        </form>
                    </div>
                </div>
                
                <div class="col-sm-4">
                    <div class="signup-form">
                        <h2>Đăng ký</h2>
                        <form  id="formDemo"  action="{{URL::to('/add-customer')}}" method="POST">
                            {{ csrf_field() }}
                            
                            <input type="text" name="customer_name" placeholder="Họ & Tên(*)" required/>
                             
                            <input type="email" name="customer_email" placeholder="Địa chỉ Email(*)"required/>
                            <input id="mobile" type="text"name="customer_phone" placeholder="Số điện thoại(*)"required/>
                          
                            <input type="password" id="pass" name="customer_password" placeholder="Mật khẩu(*)"required/>
                     
                            <button type="submit" class="btn btn-default checkuser">Đăng ký</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
                
            </div>
           
        </div>

<body>

</body>
    </section>


@endsection
