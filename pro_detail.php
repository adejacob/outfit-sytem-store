<html>
	<head>
    	<title>OutFits System Store</title>
        <link rel="stylesheet" href="css/stylesz.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
        <link rel="icon" href="imgs/outfit_logo.png">
        <script src="js/jquery.js"></script>
        <script>
        	$(document).ready(function(){
                $('#img_contain img').hover(function(){
					$('#main_img img').attr("src",$(this).attr("src"));
				});
            });
        </script>
    </head>
    
    <body>
    	<?php
			include("inc/function.php"); 
			include("inc/header.php"); 
			include("inc/navbar.php");
			echo pro_details();
			include("inc/footer.php"); 
		?>
    </body>
</html>