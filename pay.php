<html>
	<head>
    	<title>OutFits System Store</title>
        <link rel="stylesheet" href="css/stylesz.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
        <link rel="icon" href="imgs/outfit_logo.png">
    </head>
    
    <body>
    	<?php
			include("inc/function.php"); 
			include("inc/header.php"); 
			include("inc/navbar.php");
			$u_email=$_SESSION['u_email'];
			if(!isset($_SESSION['u_email'])){
				echo"<script>window.open('index.php','_self');</script>";	
			}
		?>
        <div id='checkout_user'>
        	<h4>Your Loggin Id is : <?php echo $u_email; ?></h4>
            <h2>Delivery Address</h2>
            <div id='checkout_user_left'>
            	<?php echo checkout_user_address(); ?>
            </div>
            <div id='checkout_user_right'>
            	<?php echo up_user_checkout(); ?>
            </div><br clear="all" />
            <h2>Order Summary</h2>
            <div class="cart">
            	<form method="post" enctype="multipart/form-data">
            	<?php echo single_pro(); ?>
                </form>
            </div><br claer='all' />
        </div>
        <br claer='all' />
        <?php
			include("inc/footer.php");	 
		?>
    </body>
</html>