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
			echo "<div id='bodyleft'><ul>"; echo add_cart(); cat_detail(); sub_cat_detail(); bd_kids(); bd_men(); bd_women(); all_about_men(); all_about_women(); all_about_kids(); echo"</ul></div>";
			if(isset($_GET['cat_id']) or isset($_GET['sub_cat_id'])){
				echo "<div class='bodyright' id='bodyright'>
						<ul>"; viewall_sub_cat(); viewall_cat(); echo"</ul>
					</div><br clear='all' />";
			}
			else{
				include("inc/bodyright.php");	
			}
			include("inc/footer.php"); 
		?>
    </body>
</html>