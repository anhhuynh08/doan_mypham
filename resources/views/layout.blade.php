<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Trang chủ | Mỹ phẩm</title>

    <link href="{{asset('public/fontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/prettyPhoto.css')}}"rel="stylesheet">
    <link href="{{asset('public/fontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/sweetalert.css')}}" rel="stylesheet">

    <link href="{{asset('public/fontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/responsive.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <style>


.dropdown {
   position: relative;
  display: inline-block;

}

.dropdown-content {
  display: none;
  position: absolute;
background:#B2B2B2;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
#taikhoan{
    padding-top:10px;
}
.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}


</style>

</head><!--/head-->

<body>
    
<header id="header"><!--header-->
    <div class="header-top"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <div class="shop-menu pull-left">
                <ul class="nav navbar-nav">
                <li class="hotline" >
                        <span>Hotline:1800787878</span>
                        </li>
                </ul>
                </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                        <?php
                                $customer_id=Session::get('customer_id');
                                $customer_name=Session::get('customer_name');
                                if($customer_id!=NULL){       
                        ?>
                        
                        <div class="dropdown pt-3" id='taikhoan'>
                        
                        <li class="dropbtn" ><a href="{{URL::to('/checkout')}}"><i class="fa fa-user-circle"></i>
                        <span>{{$customer_name}}</span>
                        </a></li>
                        
                        <div class="dropdown-content">
                            <li><a href="{{URL::to('/show-ordered/'.$customer_id)}}"><i class="fa fa-cog"></i> Quản lý đơn hàng</a></li>
                            <li><a href="{{URL::to('/update-password/'.$customer_id)}}"><i class="fa fa-cog"></i> Đổi mật khẩu</a></li>
                            
                        </div>
                        </div>
                        
                        
                        <?php
                                }
                        ?>
                        <?php
                                $customer_id=Session::get('customer_id');
                                $shipping_id= Session::get('shipping_id');
                                if($customer_id!=NULL && $shipping_id==NULL){       
                        ?>
                      
                        
                             <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                            
                            <?php
                                }else if($customer_id!=NULL && $shipping_id!=NULL){
                                    ?>
                                    <li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                    
                                    <?php
                                }else{
                                    ?>
                                    <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                    <?php
                                }

                            ?>
                            
                            <li><a href="{{URL::to('/gio-hang')}}"><i class="fa fa-shopping-cart"></i>Giỏ hàng</a></li>
                            <?php
                                $customer_id=Session::get('customer_id');
                                if($customer_id!=NULL){

                                
                            ?>
                             <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
                            
                            <?php
                                }else{
                                    ?>
                                    <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                    <?php
                                }

                            ?>
                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="content-menu">
            <div class="row navmenu">
                <div class="col-sm-8">
                    <div class="mainmenu ">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{URL:: to('/trang-chu')}}" class="">Trang chủ</a></li>
                            <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                <div class="panel-group category-products" id="accordian">
                        @foreach($category as $key =>$cate)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a  href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">
                                        <span class="badge pull-right"></span>
                                        {{$cate->category_name}}
                                    </a>
                                </h4>
                            </div>
                        </div>
                        @endforeach

                    </div>
                           
                                </ul>
                            </li>
                           
                            <li><a href="{{URL::to('/uu-dai-su-kien')}}">Ưu đãi và sự kiện</a></li>

                        </ul>
                    </div>
                </div>
                <form action="{{URL::to('/tim-kiem')}}" method="POST">
                    {{csrf_field()}}
                <div class="col-sm-3 input-search">
                    <div class="search_box ">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input class="input-tim" type="text" name="keywords_submit" placeholder="Tìm kiếm sản phẩm" required />
                    </div>
                    
                </div>
                            
                
                <div class="col-sm-1 btn-search">
                    <div class="btn-timkiem">
                        <input type="submit" style="color:#000" name="search_items" class="btn btn-success btn-sm" placeholder="<i class='icon-search'></i>" value="Tìm kiếm"/>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->

<section id="slider">
    <div class="container-fluid">
        <div class="row1">
            <div class="co">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="image-slide">
                                <img class="img-responsive" src="{{asset('public/fontend/images/slide2.jpg')}}" >
                            </div>
                        </div>
                        <div class="item">
                            <div class="image-slide">
                                <img class="girl img-responsive" src="{{asset('public/fontend/images/slide3.PNG')}}">
                            </div>
                        </div>

                        <div class="item">
                            <div class="image-slide">
                                <img class="girl img-responsive" src="{{asset('public/fontend/images/slide1.PNG')}}" >
                            </div>
                        </div>

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Danh mục sản phẩm</h2>
                    <div class="panel-group brand-products" id="accordian">
                        @foreach($category as $key =>$cate)
                        
                                    <a class="list-group-item list-group-item1 "  href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">
                                    {{$cate->category_name}}
                                    </a><br>
                              
                           
                            @endforeach

                    </div><!--/category-products--><br>

                    
                    <h2>Thương hiệu</h2>
                    <div class="panel-group brand-products" >
                    @foreach($brand as $key =>$brand)
                        
                                <a class="list-group-item list-group-item1 "  href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> <span class="pull-right"></span>{{$brand->brand_name}}</a>
                                    </a><br>
                                    
                               
                            @endforeach

                    </div><!--/category-products-->              

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                    @yield('content')
            </div>
        </div>
    </div>
</section>


<footer id="footer">
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 column">
                    <div class="widget">
                        <div class="about_widget">
                        <h4 class="footer-title">Liên hệ với chúng tôi</h4>
                            <span>140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, TP.HCM</span><br>
                            <span>0964283264</span><br>
                            <span>webmypham.com</span><br>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 column">
                    <div class="link_widgets">
                    <h4 class="footer-title">Hỗ trợ</h4>
                    <a href="{{URL::to('/logout-checkout')}}" >Đăng ký</a><br>
                    <a href="{{URL::to('/logout-checkout')}}">Đăng nhập</a>
                    </div>
                </div>
                
                <div class="col-lg-3 column">
                    <div class="widget">
                        <div class="pay_widget">
                            <h4 class="footer-title">Phương thức thanh toán</h4>
                            <a> <i class="fa fa-cc-mastercard" aria-hidden="true"></i></a>&nbsp&nbsp&nbsp
                            <a> <i class="fa fa-paypal" aria-hidden="true"></i></a>&nbsp&nbsp&nbsp
                            <a> <i class="fa fa-credit-card-alt" aria-hidden="true"></i></a>&nbsp&nbsp&nbsp
                            <a> <i class="fa fa-cc-jcb" aria-hidden="true"></i></a>
                               
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-line">
        <span>© Design by  </span>
        
    </div>
</footer>



<script type="text/javascript" src="https://code.jquery.com/jquery-latest.pack.js"></script>
<script src="{{asset('public/fontend/js/jquery.js')}}"></script>
<script src="{{asset('public/fontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/fontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('public/fontend/js/price-range.js')}}"></script>
<script src="{{asset('public/fontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('public/fontend/js/main.js')}}"></script>
<script src="{{asset('public/fontend/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                if(parseInt(cart_product_qty)>parseInt(cart_product_quantity)){
                    alert(cart_product_name + " chỉ còn lại " + cart_product_quantity + " sản phẩm");
                }
                else{

                
                    $.ajax({
                        url: '{{url('/add-cart-ajax')}}',
                        method: 'POST',
                        data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
                        success:function(){

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để thay đổi số lượng và tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{url('/gio-hang')}}";
                                });

                        }

                    });
            }
            });
        });
    </script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script>
    function checkPhoneNumber1() {
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
    function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
</script>
<script>
    function validate() {
    
    const email = $("#email").val();
    

    if (validateEmail(email)) {
        return true;
    } else {
        return false;
    }
    return false;
}
</script>

<script type="text/javascript">
    $(document).ready(function(){
            $('.send_order').click(function(){
                if( $('.shipping_email').val()==null || $('.shipping_email').val()==""||
                $('.shipping_name').val()==null || $('.shipping_name').val()==""||
                $('.shipping_address').val()==null || $('.shipping_address').val()==""||
                $('.shipping_phone').val()==null || $('.shipping_phone').val()==""||
                $('.shipping_notes').val()==null || $('.shipping_notes').val()==""||
                $('.shipping_method').val()==3 || $('.shipping_method').val()=="3"||
                $('.order_fee').val()==null|| $('.order_fee').val()==""
                    ){
                    swal("Thông báo", "Vui lòng điền đầy đủ thông tin gửi hàng để hoàn tất đặt hàng", "error");
                }
                
                else if(!checkPhoneNumber1()){
                        swal("Thông báo", "Số điện thoại không tồn tại vui lòng kiểm tra lại", "error");
                }
                else if(!validate()){
                    swal("Thông báo","Email không hợp lệ", "error");
                }
                else
                swal({
                  title: "Xác nhận đơn hàng",
                  text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Cảm ơn, Mua hàng",

                    cancelButtonText: "Đóng,chưa mua",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                     if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
          
                        var shipping_name = $('.shipping_name').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_notes = $('.shipping_notes').val();
                        var shipping_method = $('.shipping_method').val();
                        var order_fee = $('.order_fee').val();
                        var order_coupon = $('.order_coupon').val();
                        var _token = $('input[name="_token"]').val();

                        $.ajax({
                            url: '{{url('/confirm-order')}}',
                            method: 'POST',
                            data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_notes:shipping_notes,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method},
                            success:function(){
                               swal("Thành công", "Đơn hàng của bạn đã được gửi thành công", "success");
                            }
                        });

                        window.setTimeout(function(){ 
                            location.reload();
                        } ,2000);

                      } else {
                        swal("Đóng", "Đơn hàng chưa được gửi, vui lòng hoàn tất đơn hàng", "error");

                      }
              
                });

               
            });
        });
    



</script>


<script type="text/javascript">
$(document).ready(function(){
  $('.choose').on('change',function(){
  var action = $(this).attr('id');
  var ma_id = $(this).val();
  var _token = $('input[name="_token"]').val();
  var result = '';
 
  if(action=='city'){
      result = 'province';
  }else{
      result = 'wards';
  }
  $.ajax({
      url : '{{url('/select-delivery-home')}}',
      method: 'POST',
      data:{action:action,ma_id:ma_id,_token:_token},
      success:function(data){
         $('#'+result).html(data);     
      }
  });
});
});

</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.calculate_delivery').click(function(){
      var matp = $('.city').val();
      var maqh = $('.province').val();
      var xaid = $('.wards').val();
      var _token = $('input[name="_token"]').val();
      if(matp == '' && maqh =='' && xaid ==''){
          alert('Vui lòng chọn địa chỉ để tính phí vận chuyển');
      }else{
          $.ajax({
          url : '{{url('/calculate-fee')}}',
          method: 'POST',
          data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
          success:function(){
             location.reload(); 
          }
          });
      } 
});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.checkuser').click(function(){
      var customer_name = $('.customer_name').val();
      var _token = $('input[name="_token"]').val();
      if(customer_name == '' ){
          alert('Vui lòng nhập Họ tên');
      }else{
          $.ajax({
          url : '{{url('/calculate-fee')}}',
          method: 'POST',
          data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
          success:function(){
             location.reload(); 
          }
          });
      } 
});
});
</script>
<script type="text/javascript">
        jQuery(document).ready(function($) {
            var $filter = $('.navmenu');
            var $filterSpacer = $('<div />', {
                "class": "vnkings-spacer",
                "height": $filter.outerHeight()
            });
            if ($filter.size())
            {
                $(window).scroll(function ()
                {
                    if (!$filter.hasClass('fix') && $(window).scrollTop() > $filter.offset().top)
                    {
                        $filter.before($filterSpacer);
                        $filter.addClass("fix");
                    }
                    else if ($filter.hasClass('fix')  && $(window).scrollTop() < $filterSpacer.offset().top)
                    {
                        $filter.removeClass("fix");
                        $filterSpacer.remove();
                    }
                });
            }
 
        });
    </script>
</body>
</html>
