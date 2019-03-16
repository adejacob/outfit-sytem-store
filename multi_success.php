<?php
	session_start();
	
	if(!isset($_SESSION['u_email'])){
		echo"<script>window.open('index.php','_self');</script>";	
	}else{
		include("inc/function.php");
		echo paypal_multi_buy();
	}
?>