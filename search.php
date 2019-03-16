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
			echo search(); echo add_cart();
			include("inc/bodyright.php");
			include("inc/footer.php"); 
		?>
    </body>
</html>