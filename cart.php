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
		?>
        <div id='cart'>
        <div class="cart">
        	<form method="post" enctype="multipart/form-data">
            	<?php echo cart_display(); ?>
            </form>
        </div>
        </div>
        <?php include("inc/footer.php"); ?>
    </body>
</html>