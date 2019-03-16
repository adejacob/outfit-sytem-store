<?php
	session_start();
	include("inc/function.php");
	if(!isset($_SESSION['u_email'])){
		echo delete_cart_items();
	}
	else{
		echo delete_user_cart();	
	}
?>