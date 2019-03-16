<html>
	<head>
    	<title>OutFits System Store</title>
        <link rel="stylesheet" href="css/stylesz.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
	    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	    <link rel="icon" href="imgs/outfit_logo.png">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
			include("inc/bodyleft.php");
			include("inc/bodyright.php");
			include("inc/footer.php");
			echo add_cart();
			echo u_signup();
			echo add_whilist();	 
		?>
    </body>
</html>