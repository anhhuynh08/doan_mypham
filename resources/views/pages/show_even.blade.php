@extends('layout')
@section('content')

   
            <div class="panel-heading">
              <h2>  Các ưu đãi đang hot!! </h2>
            </div>

            <div class="panel-heading">
            <table class="table table-striped b-t b-light">
                   
                   <tbody>
                  
                   @foreach($coupon as $key => $cou)
           
                   @if($cou!==null)
                   
                   
                       <h4>Ưu đãi đặc biệt 
                       <span style="color:red;">
                       {{$cou->coupon_name}}
                        </sqan>
                       </h4><br>
                       @if($cou->coupon_condition==1)
                        <span>Được giảm giá {{$cou->coupon_number}}% trên mỗi đơn hàng</span><br><br>
                       @else
                       <span>Được giảm giá {{$cou->coupon_number}}₫ trên mỗi đơn hàng</span><br>   <br> 
                       @endif
                       <span>Nhập mã:<span style="color:red;"> {{$cou->coupon_code}} </span> để được hưởng ưu đãi nhé!!</sqan><br><br>
                       
                       
                   @else
                   Hiện tại không có ưu đãi và khuyến mãi nào.
                   @endif
               @endforeach
                       
                       
                   </tbody>
               </table>
            </div>
           
@endsection
