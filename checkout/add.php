<?php
include "../connect.php";
$userid=filterRequest("userid");
$addressid=filterRequest("addressid");
$ordertype=filterRequest("ordertype");
$orderdelivery=filterRequest("orderdelivery");
$orderprice=filterRequest("orderprice");
$ordercoupon=filterRequest("ordercoupon");
$orderpaymethod=filterRequest("orderpaymethod");
$coupondiscount=filterRequest("coupondiscount");
$totalprice=$orderprice+$orderdelivery;
//check coupon
$now=date("Y-m-d H:i:s");
$checkcoupon=getData("coupon","coupon_id='$ordercoupon' AND coupon_count>0 AND coupon_expired>'$now'",null,false);
if($checkcoupon>0){
    $totalprice=$totalprice-($totalprice*$coupondiscount/100)+$orderdelivery;
    $stmt=$con->prepare("UPDATE `coupon` SET `coupon_count`=`coupon_count`-1 WHERE coupon_id=$ordercoupon");
    $stmt->execute();
}
$data=array(
    'orders_users_id'=>$userid,
    'orders_address'=>$addressid,
    'orders_type'=>$ordertype,
    'orders_pricedelivery'=>$orderdelivery,
    'orders_price'=>$orderprice,
    'orders_coupon'=>$ordercoupon,
    'orders_paymentmethod'=>$orderpaymethod,
    'orders_totalprice'=>$totalprice,
);
$count=insertData('orders',$data,false);

if($count>0){
    $stmt =$con->prepare("SELECT Max(orders_id) FROM orders WHERE orders_users_id=$userid ");
    $stmt->execute();
    $orderid=$stmt->fetchColumn();
    $cart_order=array(
        'cart_orders'=>$orderid
    );

    updateData('cart',$cart_order,"cart_usersid=$userid AND cart_orders=0" );
}    


?>