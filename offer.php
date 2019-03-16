<html>
	<head>
    	<title>OutFits System Store</title>
        <link rel="stylesheet" href="css/stylesz.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
        <link rel="icon" href="imgs/outfit_logo.png">
		<script src="js/jquery.js"></script>
        <script src="js/cycle.js"></script>
        <script>
        	$('#slide').cycle('all');
        </script>
    </head>
    
    <body>
    	<?php
			include("inc/function.php"); 
			include("inc/header.php"); 
			include("inc/navbar.php");
		?>
        <div id='bodyleft'>
        	<ul><?php echo offer(); ?></ul>
        </div>
        <?php
			include("inc/bodyright.php");
			echo add_cart();
			echo u_signup();
			echo add_whilist();	 
		?><br clear="all" />
        <?php include("inc/footer.php"); ?>
    </body>
</html>