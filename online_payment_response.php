<?php

function getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
	 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	 
		return $ip;
	}
	

include("inc/db.php");
session_start();
$ip=getIp();
$u_email=$_SESSION['u_email'];
$get_user=$con->prepare("select * from user where u_email='$u_email'");
$get_user->setFetchMode(PDO:: FETCH_ASSOC);
$get_user->execute();
$row_user=$get_user->fetch();
$u_id=$row_user['u_id'];

$get_cart_item=$con->prepare("select * from user_cart where ip_add='$ip' AND u_id='$u_id'");
$get_cart_item->setFetchMode(PDO:: FETCH_ASSOC);
$get_cart_item->execute();
$cart_empty=$get_cart_item->rowCount();
$net_total=0;

$get_cart=$con->prepare("select * from user_cart where u_id='$u_id'");
$get_cart->setfetchMode(PDO:: FETCH_ASSOC);
$get_cart->execute();
while($row_u=$get_cart->fetch()):
	$p_id=$row_u['pro_id'];
	$q=$row_u['qty'];
	$get_p=$con->prepare("select * from products where pro_id='$p_id'");
	$get_p->setfetchMode(PDO:: FETCH_ASSOC);
	$get_p->execute();
	$row_p=$get_p->fetch();
	$price=$row_p['pro_dis_price'];
	
	$amt=$price * $q;
	$trx_id="ORD".substr(mt_rand(),0,10)."RCV";
	$insert=$con->prepare("insert into payment(u_id,pro_id,amt,qty,trx_id,ip_add,status,pay_date)values('$u_id','$p_id','$amt','$q','$trx_id','$ip','Pending',NOW())");
	if($insert->execute()){
		echo"<script>alert('We Recive Your Order')</script>";
		echo"<script>window.open('user_pro.php?myorder','_self')</script>";	
	}
	$new_qty=$row_p['pro_qty'] - $q;
	$up_qty=$con->prepare("update products set pro_qty='$new_qty' where pro_id='$p_id'");
	$up_qty->execute();
endwhile;
$del_cart=$con->prepare("delete from user_cart where u_id='$u_id'");
$del_cart->execute();	