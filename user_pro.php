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
        <div id='user_left'>
            <?php
            	if(isset($_GET['mycart'])){
					echo"<h3>My Cart</h3>
							<form class='mycart' method='post' enctype='multipart/form-data'>
									";echo cart_display();
								echo"</form><br clear='all' />";	
				}
				else if(isset($_GET['mywishlist'])){
					echo"<h3>My Wishlist</h3>
						<form class='mycart' method='post' enctype='multipart/form-data'>
							";echo wish_display();
							echo"</table>
						</form><br clear='all' />";	
				}
				else if(isset($_GET['mypass'])){
					echo"<h3>Update Password</h3>";
					echo up_pass();	
				}
				elseif(isset($_GET['myorder'])){
					echo"<h3>My Orders</h3>
						<form class='myorder' method='post' enctype='multipart/form-data'>
							";echo user_order();
							echo"</table>
						</form><br clear='all' />";	
				}
				else{
			?>
            <h3>My Account</h3>
            <?php echo user_pro(); }?>
        </div>
        <div id='user_right'>
        	<h3>Welcome</h3>
            <?php echo get_u_img(); ?>
            <ul>
            	<li><a href="user_pro.php">My Account</a></li>
                <li><a href="user_pro.php?myorder">My Orders</a></li>
                <li><a href="user_pro.php?mycart">My Shopping Cart</a></li>
                <li><a href="user_pro.php?mywishlist">My Wishlist</a></li>
                <li><a href="user_pro.php?mypass">Change Password</a></li>
            </ul>
        </div><br clear="all" />
        <?php
			include("inc/footer.php"); 
		?>
    </body>
</html>