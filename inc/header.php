<?php session_start(); ?>
<div id="header">
    <div id="logo">
        <a href="index.php"><img src="imgs/outfit_logo.png" /></a>
        <h5>OutFit Systems</h5>
    </div><!--end of logo-->
    
    <div id="link">
        <ul>
            <?php if(!isset($_SESSION['u_email'])){ ?>
            <li><a href="#"><i class="fa fa-user-plus"></i> Signup</a>
                <form method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td><i class="fa fa-user"></i> Enter Your Username</td>
                            <td><input type="text" name="u_name" required="required" pattern="[a-z A-Z]{2,30}" maxlength="30" minlength='2' /></td>
                        </tr>
                        <tr>
                                <td><i class="fa fa-envelope-square"></i> Enter Your Email</td>
                            <td><input type="email" name="u_email" required="required" pattern="[a-z A-Z 0-9 ^@._-]{5,50}" maxlength="50" minlength='5' /></td>
                        </tr>
                        <tr>
                            <td>Enter Your Password</td>
                            <td><input type="password" name="u_pass" required="required" maxlength="20" minlength='8' /></td>
                        </tr>
                        <!-- <tr>
                            <td><i class="fa fa-image"></i> Upload Your Picture</td>
                            <td><input type="file" name="u_img" required="required" accept="image/jpeg" /></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-address-card"></i> Enter Your Address</td>
                            <td><textarea name='u_add' required="required" pattern="[a-z A-Z 0-9 ^/-.]{10,100}" maxlength="100" minlength='10'></textarea></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-globe"></i> Enter Your Country</td>
                            <td>
                            	<select name='u_country' id='country' required="required">
                                	<option value="">Select Country</option>
                            		<?php echo get_country(); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-flag"></i> Enter Your State</td>
                            <td>
                            	<select name='u_state' id='state' required="required">
                                	<option value="">Select State</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-barcode"></i> Enter Your Zip/Postal code</td>
                            <td><input type="tel" name="u_pin" required="required" pattern="[0-9]{6}" maxlength="6" minlength='6' /></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-calendar"></i> Enter Date Of Birth</td>
                            <td><input type="date" name="u_date" required="required" /></td>
                        </tr> -->
                        <tr>
                            <td><i class="fa fa-phone"></i> Enter Your Phone No.</td>
                            <td><input type="tel" name="u_phone" required="required" pattern="[0-9 ^+]{10,13}" maxlength="13" minlength='10' /></td>
                        </tr>
                    </table>
                    <center>
                        <input type="submit" name="u_signup" Value='SignUp' />
                        <input type="reset" name="reset" Value='Reset' />
                    </center>
                </form>
            </li>
            <li><a href="#"><i class="fa fa-sign-in"></i> Login</a>
                <form method="post" id='login'>
                    <table>
                        <tr>
                            <td>Enter Your Email</td>
                            <td><input type="email" name="login_email" required="required" pattern="[a-z A-Z 0-9 ^@._-]{5,50}" maxlength="50" minlength='5' /></td>
                        </tr>
                        <tr>
                            <td>Enter Your Password</td>
                            <td><input type="password" name="login_pass" required="required" maxlength="20" minlength='8' /></td>
                        </tr>
                    </table>
                    <center>
                        <input type="submit" name="login_btn" value='Login' />
                        <input type="button" name="for_pass" value="Forget Password ?" />     
                   </center>
                </form>
            </li>
            <?php echo login(); }else{ ?>
            <div id="acct">
                <li><a href='user_pro.php' target="_blank"> <?php echo $_SESSION['u_email']; ?></a>
                <ul>
                    <li><a href='user_pro.php'><i class="fa fa-user-circle"></i> My Account</a></li>
                    <li><a href='user_pro.php?myorder'><i class="fa fa-truck"></i> My Orders</a></li>
                    <li><a href='user_pro.php?mycart'><i class="fa fa-cart-arrow-down"></i> My Shopping Cart <span style="float:right; margin-right:4%"><i class="fa fa-arrow-circle-down"></i> <?php echo cart_caount(); ?></span></a></li>
                    <li><a href='user_pro.php?mywishlist'><i class='fa fa-heart'></i> My Wishlist</a></li>
                    <li><a href='user_pro.php?mypass'><i class="fa fa-unlock"></i> Change Password</a></li>
                    <li><a href='logout.php'><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </li>
            </div>
            <li><a href="#"><i class="fa fa-download"></i> Download App</a></li>
            <?php } ?>
        </ul>
    </div><!--end of link-->
    <div id="search">
        <form method="get" action="search.php" enctype="multipart/form-data">
            <input type="text" name='user_query' placeholder="Search From Here..." />
            <button name='search' id="search_btn"><i class="fa fa-search"></i> Search</button>
            <button id="cart_btn"><a href='cart.php'><i class="fa fa-cart-arrow-down"></i>  Cart <i class="fa fa-arrow-circle-down"></i> <?php echo cart_caount(); ?></a></button>
        </form>
    </div><!--end of search-->
</div><!--end of header-->

<script>
	$(document).ready(function(){
		$('#country').change(function(){
			var state_id=$(this).val();
			$.ajax({
				url:"get_state.php",
				method:"POST",
				data:{stateId:state_id},
				dataType:"text",
				success:function(data){
					$('#state').html(data);	
				}
			});
		});
	});
</script>