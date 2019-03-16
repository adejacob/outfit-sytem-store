<?php
	include("inc/function.php");
	if(isset($_GET['delete_cat'])){
		echo delete_cat();	
	}
	
	if(isset($_GET['delete_sub_cat'])){
		echo delete_sub_cat();	
	}
	
	if(isset($_GET['delete_pro'])){
		echo delete_product();	
	}
	
	if(isset($_GET['delete_country'])){
		echo delete_country();	
	}
	
	if(isset($_GET['delete_state'])){
		echo delete_state();	
	}
	
?>