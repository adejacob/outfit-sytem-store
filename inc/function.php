<?php
	function u_signup(){
		include("inc/db.php");
		if(isset($_POST['u_signup'])){
			$u_name=$_POST['u_name'];
			$u_email=$_POST['u_email'];
			
			$u_pass=$_POST['u_pass'];
			
			$u_img=$_FILES['u_img']['name'];
			$u_img_tmp=$_FILES['u_img']['tmp_name'];
			
			move_uploaded_file($u_img_tmp,"imgs/u_img/$u_img");
			
			$u_add=$_POST['u_add'];
			$u_country=$_POST['u_country'];
			$u_state=$_POST['u_state'];
			$u_pin=$_POST['u_pin'];
			$u_date=$_POST['u_date'];
			$u_phone=$_POST['u_phone'];
			
			
			$check_email=$con->prepare("select * from user where u_email='$u_email'");
			$check_email->setfetchMode(PDO:: FETCH_ASSOC);
			$check_email->execute();
			$user_count=$check_email->rowCount();
			
			if($user_count==1){
				echo"<script>alert('Email Is Already Registerd Please Try Somthing Else')</script>";
			}else{
				$add_user=$con->prepare("insert into user(u_name,u_email,u_img,u_add,u_country,u_state,u_pin,u_dob,u_phone,u_pass,u_reg_date)values('$u_name','$u_email','$u_img','$u_add','$u_country','$u_state','$u_pin','$u_date','$u_phone','$u_pass',NOW())");	
				if($add_user->execute()){
					$get_info=$con->prepare("select * from user where u_email=$u_email");
					$get_info->setFetchMode(PDO:: FETCH_ASSOC);
					$get_info->execute();
					$row_info=$get_info->fetch();
					
					$user_email=$row_info['u_email'];
					$pass=$row_info['u_pass'];
					
					$headers="MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <service@royalcollection.tk>' . "\r\n";
					
					$subject= "Registration Details";
					$msg= "<html>
								<p>Hellow Dear Customer Your Registration Details Is Here</p>
								<h5>Your Email : $user_email</h5>
								<h5>Your Password : $pass</h5>
								Let's Try To Login By <a href='#'>Click Here</a>
						</html>";
					mail($user_email,$subject,$msg,$headers);
					
					echo"<script>alert('Congratulation Your Registration Was Successful Check Your Email We Send Password There')</script>";
					echo"<script>window.open('index.php','_self');</script>";	
				}
				else{
					echo"<script>alert('Registration Fail Please Try Again')</script>";
				}
			}
		}	
	}
	
	function get_country(){
		include("inc/db.php");
		$fetch_cat=$con->prepare("select * from country ORDER BY country_name");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();	
		while($row=$fetch_cat->fetch()):
			echo"<option value='".$row['c_id']."'>".$row['country_name']."</option>";
		endwhile;
	}
	
	function get_state(){
		include("inc/db.php");
		$id=$_POST['stateId'];
		$fetch_cat=$con->prepare("select * from state where c_id='$id' ORDER BY state_name");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();	
		while($row=$fetch_cat->fetch()):
			echo"<option value='".$row['state_id']."'>".$row['state_name']."</option>";
		endwhile;
	}
	
	function login(){
		include("inc/db.php");
		if(isset($_POST['login_btn'])){
			$email=$_POST['login_email'];
			$pass=$_POST['login_pass'];
			
			$select=$con->prepare("select * from user where u_email='$email' AND u_pass='$pass'");
			$select->setFetchMode(PDO:: FETCH_ASSOC);
			$select->execute();
			$get_u_id=$select->fetch();
			$u_id=$get_u_id['u_id'];
			
			$check=$select->rowCount();
			if($check==1){
				$_SESSION['u_email']=$email;

				$ip=getIp();
				
				$get_g_cart=$con->prepare("select * from cart where ip_add='$ip'");
				$get_g_cart->setFetchMode(PDO:: FETCH_ASSOC);
				$get_g_cart->execute();
				while($row=$get_g_cart->fetch()):
					$pro_id=$row['pro_id'];
					$qty=$row['qty'];
					
					$user_cart=$con->prepare("select * from user_cart where pro_id='$pro_id' AND ip_add='$ip' AND u_id='$u_id'");
					$user_cart->setFetchMode(PDO:: FETCH_ASSOC);
					$user_cart->execute();
					
					$count_cart=$user_cart->rowCount();
					if($count_cart==1){
						$delete_cart=$con->prepare("delete from cart where ip_add='$ip'");
						$delete_cart->execute();	
					}else{
						$add_to_user_cart=$con->prepare("insert into user_cart(pro_id,qty,ip_add,u_id)values('$pro_id','$qty','$ip','$u_id')");
						$add_to_user_cart->execute();
						
						$delete_cart=$con->prepare("delete from cart where ip_add='$ip'");
						$delete_cart->execute();	
					}
				endwhile;	
				echo"<script>window.open('index.php','_self')</script>";
			}
			else{
				echo"<script>alert('Login Not Success')</script>";
			}
				
		}	
	}
	
	function getIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
	 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	 
		return $ip;
	}
	
	function add_cart(){
		include("inc/db.php");
		if(isset($_POST['cart_btn'])){
			$pro_id=$_POST['pro_id'];
			$ip=getIp();
			if(!isset($_SESSION['u_email'])){
				$check_cart=$con->prepare("select * from cart where pro_id='$pro_id' AND ip_add='$ip'");
				$check_cart->execute();
				
				$row_check=$check_cart->rowCount();
				
				if($row_check==1){
					echo"<script>alert('This Product Already Added In Your Cart');</script>";	
				}else{
					$add_cart=$con->prepare("insert into cart(pro_id,qty,ip_add)values('$pro_id','1','$ip')");	
					
					if($add_cart->execute()){
						echo "<script>alert('Product Added In Your Cart !!'); </script>";
						echo"<script>window.open('index.php','_self');</script>";	
					}
					else{
						echo"<script>alert('Try Again !!!');</script>";
					}
				}
			}else{
				$u_email=$_SESSION['u_email'];
				$get_user=$con->prepare("select * from user where u_email='$u_email'");
				$get_user->setFetchMode(PDO:: FETCH_ASSOC);
				$get_user->execute();
				$row_user=$get_user->fetch();
				$u_id=$row_user['u_id'];
				
				$check_cart=$con->prepare("select * from user_cart where pro_id='$pro_id' AND ip_add='$ip' AND u_id='$u_id'");
				$check_cart->execute();
				
				$row_check=$check_cart->rowCount();
				
				if($row_check==1){
					echo"<script>alert('This Product Already Added In Your Cart');</script>";	
				}else{
					$add_cart=$con->prepare("insert into user_cart(pro_id,qty,ip_add,u_id)values('$pro_id','1','$ip','$u_id')");	
					
					if($add_cart->execute()){
						echo "<script>alert('Product Added In Your Cart !!'); </script>";
						echo"<script>window.open('index.php','_self');</script>";	
					}
					else{
						echo"<script>alert('Try Again !!!');</script>";
					}
				}	
			}
		}	
	}
	
	function cart_caount(){
		include("inc/db.php");
		$ip=getIp();
		if(!isset($_SESSION['u_email'])){
			$get_cart_item=$con->prepare("select * from cart where ip_add='$ip'");
			$get_cart_item->execute();
		}else{
			$u_email=$_SESSION['u_email'];
			$get_user=$con->prepare("select * from user where u_email='$u_email'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user=$get_user->fetch();
			$u_id=$row_user['u_id'];
			
			$get_cart_item=$con->prepare("select * from user_cart where ip_add='$ip' AND u_id='$u_id'");
			$get_cart_item->execute();	
		}
		
		$count_cart=$get_cart_item->rowCount();
		
		echo $count_cart;	
	}
	
	function user_order(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$row_user=$get_user->fetch();
		$u_id=$row_user['u_id'];
		$ip=getIp();
		
		$get_payment=$con->prepare("select * from payment where u_id='$u_id'");
		$get_payment->setFetchMode(PDO:: FETCH_ASSOC);
		$get_payment->execute();
		echo"<table cellpadding='0' cellspacing='0'>
					<tr>
						<th>Invoice No.</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Date</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Status</th>
						<th>Action</td>
					</tr>";
					
		while($row=$get_payment->fetch()):
			$pro_id=$row['pro_id'];
			$qty=$row['qty'];
			$amt=$row['amt'];
			$trx_id=$row['trx_id'];
			$date=$row['pay_date'];
			$status=$row['status'];
			$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
			$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$get_pro->execute();
			$row_pro=$get_pro->fetch();
			
			echo"<tr>
					<td>$trx_id</td>
					<td>".$row_pro['pro_name']."</td>
					<td><img src='imgs/pro_img/".$row_pro['pro_img1']."' style='width:40px; height:40px' /></td>
					<td>$date</td>
					<td>$amt</td>
					<td>$qty</td>
					<td>$status</td>";
					if($status == 'Complete'){
						echo"<td>Completed</td>";
					}elseif($status=='Cancle'){
						echo"<td>Order Cancelled</td>";
					}else{
						echo"<td><a href='user_pro.php?myorder&cancle=".$row['pay_id']."'><i class='fa fa-times'></i></a></td>";
					}
				echo"</tr>";
		endwhile;
		if(isset($_GET['cancle'])){
			$pay_id=$_GET['cancle'];
			
			$update_order=$con->prepare("update payment set status='Cancle' where pay_id='$pay_id' AND u_id='$u_id'");
			
			if($update_order->execute()){
				echo"<script>
						alert('Order Cancle Successfully');
						window.open('user_pro.php?myorder','_self');	
					</script>";
			}
		}	
	}
	
	function wish_display(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$row_user=$get_user->fetch();
		$u_id=$row_user['u_id'];
		$ip=getIp();
			
		$get_cart_item=$con->prepare("select * from user_wishlist where ip_add='$ip' AND u_id='$u_id'");
		$get_cart_item->setFetchMode(PDO:: FETCH_ASSOC);
		$get_cart_item->execute();
		$cart_empty=$get_cart_item->rowCount();
		$net_total=0;
		if($cart_empty==0){
			echo "<center><h2>No Product Found In Cart <br><br><br><button id='buy_now'><a href='index.php'>Continue Shopping</a></button></h2></center>";	
		}else{
			if(isset($_POST['up_qty'])){
				$quantity=$_POST['qty'];
					
				foreach($quantity as $key=>$value){
				$update_qty=$con->prepare("update user_wishlist set qty='$value' where user_cart_id='$key'");
					if($update_qty->execute()){
						echo"<script>window.open('user_pro.php?mywishlist','_self');</script>";	
					}
				}	
			}
			echo"<table cellpadding='0' cellspacing='0'>
					<tr>
						<th>Image</th>
						<th>Product Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Remove</th>
						<th>Sub Total</th>
						<th>Shipping fee</th>
					</tr>";
			while($row=$get_cart_item->fetch()):
				$pro_id=$row['pro_id'];
				
				$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
				$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
				$get_pro->execute();
				$row_pro=$get_pro->fetch();
				echo"<tr>
						<td><img src='imgs/pro_img/".$row_pro['pro_img1']."' /></td>
						<td>".$row_pro['pro_name']."</td>
						<td><input type='text' name='qty[".$row['u_wish_id']."]' value='".$row['qty']."' /><input type='submit' name='up_qty' value='Save' /></td>
						<td>".$row_pro['pro_price']."</td>
						<td><a href='delete.php?user_delete_id=".$row_pro['pro_id']."'><i class='fa fa-trash'></i></a></td>
						<td>";
							$qty=$row['qty'];
							$pro_price=$row_pro['pro_price'];
							$sub_total=$pro_price*$qty;
							echo $sub_total;
							$net_total=$net_total+$sub_total+2000;
						echo"</td>
						<td>2000</td>
					</tr>";
			endwhile;
			echo"</table>
			<center>
				<button id='buy_now'>
					<a href='index.php'>Continue Shopping</a>
				</button>
				<form method='post'>
					<button id='buy_now' name='buy_now'>Checkout</button>
				</form>
				<button id='buy_now'><b>Net Total = ₦ $net_total </b></button></center>
				</center>";
				if(isset($_POST['buy_now'])){
						if(!isset($_SESSION['u_email'])){
							echo"<script>alert('Please Login Or Signup')</script>";	
						}else{
							echo"<script>window.open('checkout.php?checkout=$pro_id','_self')</script>";	
						}	
					}

			}	

	}
	
	
	function cart_display(){
		include("inc/db.php");
		$ip=getIp();
		if(!isset($_SESSION['u_email'])){
			$get_cart_item=$con->prepare("select * from cart where ip_add='$ip'");
			$get_cart_item->setFetchMode(PDO:: FETCH_ASSOC);
			$get_cart_item->execute();
			$cart_empty=$get_cart_item->rowCount();
			$net_total=0;
			if($cart_empty==0){
				echo "<center><h2>No Product Found In Cart <br><br><br><button id='buy_now'><a href='index.php'>Continue Shopping</a></button></a></h2></center>";	
			}else{
				if(isset($_POST['up_qty'])){
					$quantity=$_POST['qty'];
					
					foreach($quantity as $key=>$value){
						$update_qty=$con->prepare("update cart set qty='$value' where cart_id='$key'");
						if($update_qty->execute()){
							echo"<script>window.open('cart.php','_self');</script>";	
						}
					}	
				}
				echo"<table cellpadding='0' cellspacing='0'>
						<tr>
							<th>Image</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Remove</th>
							<th>Sub Total</th>
							<th>Shipping fee </th>
						</tr>";
			while($row=$get_cart_item->fetch()):
				$pro_id=$row['pro_id'];
				
				$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
				$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
				$get_pro->execute();
				$row_pro=$get_pro->fetch();
				echo"<tr>
						<td><img src='imgs/pro_img/".$row_pro['pro_img1']."' /></td>
						<td>".$row_pro['pro_name']."</td>
						<td><input type='text' name='qty[".$row['cart_id']."]' value='".$row['qty']."'  /><input type='submit' name='up_qty' value='Save' /></td>
						<td>".$row_pro['pro_price']."</td>
						<td><a href='delete.php?delete_id=".$row_pro['pro_id']."'><i class='fa fa-trash'></i></a></td>
						<td>";
							$qty=$row['qty'];
							$pro_price=$row_pro['pro_price'];
							$sub_total=$pro_price*$qty;
							echo $sub_total;
							$net_total=$net_total+$sub_total+2000;
						echo"</td>
						<td>2000</td>
					</tr>";
			endwhile;
			echo"</table>
				<center>
				<button id='buy_now'>
					<a href='index.php'>Continue Shopping</a>
				</button>
				<form method='post'>
					<button id='buy_now' name='cart_checkout'>Checkout</button>
				</form>
				<button id='buy_now'><b>Net Total = ₦ $net_total </b></button></center>
				</center>";
				if(isset($_POST['cart_checkout'])){
					echo"<script>alert('Please Login Or Signup');</script>";
					echo"<script>window.open('cart.php','_self')</script>";	
				}
			}
		}else{
			$u_email=$_SESSION['u_email'];
			$get_user=$con->prepare("select * from user where u_email='$u_email'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user=$get_user->fetch();
			$u_id=$row_user['u_id'];
			
			$get_cart_item=$con->prepare("select * from user_cart where ip_add='$ip' AND u_id='$u_id'");
			$get_cart_item->setFetchMode(PDO:: FETCH_ASSOC);
			$get_cart_item->execute();
			$cart_empty=$get_cart_item->rowCount();
			$net_total=0;
			if($cart_empty==0){
				echo "<center><h2>No Product Found In Cart <a href='index.php'><br><br><br><button id='buy_now'><a href='index.php'>Continue Shopping</a></button></a></h2></center>";	
			}else{
				if(isset($_POST['up_qty'])){
					$quantity=$_POST['qty'];
					
					foreach($quantity as $key=>$value){
						$update_qty=$con->prepare("update user_cart set qty='$value' where user_cart_id='$key'");
						if($update_qty->execute()){
							if(isset($_GET['checkout_cart'])){
								echo"<script>window.open('checkout.php?checkout_cart','_self');</script>";
							}else{
								echo"<script>window.open('cart.php','_self');</script>";
							}
						}
					}	
				}
				echo"<table cellpadding='0' cellspacing='0'>
						<tr>
							<th>Image</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Remove</th>
							<th>Sub Total</th>
							<th>Shipping fee </th>
						</tr>";
			while($row=$get_cart_item->fetch()):
				$pro_id=$row['pro_id'];
				
				$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
				$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
				$get_pro->execute();
				$row_pro=$get_pro->fetch();
				echo"<tr>
						<td><img src='imgs/pro_img/".$row_pro['pro_img1']."' /></td>
						<td>".$row_pro['pro_name']."</td>
						<td><input type='text' name='qty[".$row['user_cart_id']."]' value='".$row['qty']."' /><input type='submit' name='up_qty' value='Save' /></td>
						<td>".$row_pro['pro_dis_price']."</td>
						<td><a href='delete.php?user_delete_id=".$row_pro['pro_id']."'><i class='fa fa-trash'></i></a></td>
						<td>";
							$qty=$row['qty'];
							$pro_price=$row_pro['pro_dis_price'];
							$sub_total=$pro_price*$qty;
							echo $sub_total;
							$net_total=$net_total+$sub_total+2000;
						echo"</td>
						<td>2000</td>
					</tr>";
			endwhile;
			echo"</table>";
					if(isset($_GET['checkout_cart'])){
						echo"<center><button id='buy_now'>
								<a href='index.php'>Continue Shopping</a>
							</button>
							<button id='buy_now'><b>Net Total = ₦ $net_total </b></button>
							<form method='post'>
							<script src='https://js.paystack.co/v1/inline.js'></script>
							<button type='button' id='buy_now' name='multi_buy' onclick='payWithPaystack()'> Pay </button> 
							</form></center>
							<script>
							function payWithPaystack(){
							var handler = PaystackPop.setup({
							  key: 'pk_test_88fcb9c28b9a7ea83941a7b38fe770dab430688e',
							  email: 'outfitsystem@gmail.com',
							  amount: $net_total*100,
							  currency: 'NGN',
							  ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
							  firstname: 'Stephen',
							  lastname: 'King',
							  // label: 'Optional string that replaces customer email'
							  metadata: {
							     custom_fields: [
							        {
							            display_name: 'Mobile Number',
							            variable_name: 'mobile_number',
							            value: '+2348012345678'
							        }
							     ]
							  },
							  callback: function(response){
							  	console.log(response)
							      // window.open('index.php','_self');
							      if(response.status == 'success'){
							      	alert('success. transaction ref is ' + response.reference);
									window.open('online_payment_response.php','_self');
							      }else{
							      	alert('Payment failed');
							      }
							  },
							  onClose: function(){
							      alert('window closed');
							  }
							});
							handler.openIframe();
							}
							</script>
							";
						if(isset($_POST['multi_buy'])){
							$get_cart=$con->prepare("select * from user_cart where u_id='$u_id'");
							$get_cart->setfetchMode(PDO:: FETCH_ASSOC);
							$get_cart->execute();
							while($row_u=$get_cart->fetch()):
								$p_id=$row_u['pro_id'];
								$q=$row_u['qty'];
								$get_p=$con->prepare("select * from products where pro_id='$p_id'");
								$get_p->setfetchMode(PDO:: FETCH_ASSOC);
								$get_p->execute();
								$row_p=$get_p->fetch();
								$price=$row_p['pro_dis_price'];
								
								$amt=$price * $q;
								$trx_id=" ORD".substr(mt_rand(),0,10)."RCV";
								$insert=$con->prepare("insert into payment(u_id,pro_id,amt,qty,trx_id,ip_add,status,pay_date)values('$u_id','$p_id','$amt','$q','$trx_id','$ip','Pending',NOW())");
								if($insert->execute()){
									echo"<script>alert('We Recive Your Order')</script>";
									echo"<script>window.open('user_pro.php?myorder','_self')</script>";	
								}
								$new_qty=$row_p['pro_qty'] - $q;
								$up_qty=$con->prepare("update products set pro_qty='$new_qty' where pro_id='$p_id'");
								$up_qty->execute();
							endwhile;
							$del_cart=$con->prepare("delete from user_cart where u_id='$u_id'");
							$del_cart->execute();	
						}
					}else{
						echo"<center><button id='buy_now'>
								<a href='index.php'>Continue Shopping</a>
							</button>
							<form method='post'>
								<button id='buy_now' name='checkout_cart'>Checkout</button>
							</form>
							<button id='buy_now'><b>Net Total = ₦ $net_total </b></button></center>";
					}
				if(isset($_POST['checkout_cart'])){
					echo"<script>window.open('checkout.php?checkout_cart','_self')</script>";	
				}
			}	
		}
	}
	
	function delete_cart_items(){
		include("inc/db.php");
		if(isset($_GET['delete_id'])){
			$pro_id=$_GET['delete_id'];
			$ip=getIp();
			$delete_pro=$con->prepare("delete from cart where pro_id='$pro_id' AND ip_add='$ip'");	
			if($delete_pro->execute()){
				echo "<script>alert('Product Deleted Successfull')</script>";
				echo "<script>window.open('cart.php','_self');</script>";	
			}	
		}	
	}
	
	function delete_user_cart(){
		include("inc/db.php");
		if(isset($_GET['user_delete_id'])){
			$pro_id=$_GET['user_delete_id'];
			$u_email=$_SESSION['u_email'];
			$get_user=$con->prepare("select * from user where u_email='$u_email'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user=$get_user->fetch();
			$u_id=$row_user['u_id'];
			
			$delete_pro=$con->prepare("delete from user_cart where pro_id='$pro_id' AND u_id='$u_id'");	
				
			if($delete_pro->execute()){
				echo "<script>alert('Product Deleted Successfull')</script>";
				echo "<script>window.open('cart.php','_self');</script>";	
			}	
		}	
	}
	
	function add_whilist(){
		include("inc/db.php");
		if(isset($_POST['whish_btn'])){
			if(!isset($_SESSION['u_email'])){
				echo"<script>alert('Login Or Signup First');</script>";
			}else{
				$u_email=$_SESSION['u_email'];
				
				$get_user=$con->prepare("select * from user where u_email='$u_email'");
				$get_user->setFetchMode(PDO:: FETCH_ASSOC);
				$get_user->execute();
				
				$row=$get_user->fetch();
				$u_id=$row['u_id'];
				
				$pro_id=$_POST['pro_id'];
				$ip=getIp();
				$user_wish=$con->prepare("select * from user_wishlist where pro_id='$pro_id' AND ip_add='$ip' AND u_id='$u_id'");
				$user_wish->setFetchMode(PDO:: FETCH_ASSOC);
				$user_wish->execute();
					
				$count_wish=$user_wish->rowCount();
				if($count_wish==1){
					echo"<script>alert('The Product Is Already In Your Wishlist');</script>";	
				}else{
					$add_to_user_wish=$con->prepare("insert into user_wishlist(pro_id,qty,ip_add,u_id)values('$pro_id','1','$ip','$u_id')");
					$add_to_user_wish->execute();
				}	
			}	
		}	
	}
	
	function get_u_img(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
				
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		
		$row=$get_user->fetch();
		echo"<img src='imgs/u_img/".$row['u_img']."' />";	
	}
	
	function up_pass(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
				
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		
		$row=$get_user->fetch();
		$u_id=$row['u_id'];
		
		echo"<form method='post' enctype='multipart/form-data'>
				<table>
					<tr>
						<td>Enter Current Password</td>
						<td><input type='password' name='c_pass' required='required' maxlength='20' minlength='8' /></td>
					</tr>
					<tr>
						<td>Enter New Password</td> 
						<td><input type='password' name='n_pass1' required='required' maxlength='20' minlength='8' /></td>
					</tr>
					<tr>
						<td>Enter Confirm Password</td>
						<td><input type='password' name='n_pass2' required='required' maxlength='20' minlength='8' /></td>
					</tr>
				</table>
				<center><input type='submit' value='Save' name='up_user_pass' /></center>
			</form>";
			
			if(isset($_POST['up_user_pass'])){
				$u_email=$_SESSION['u_email'];
				$c_pass=$_POST['c_pass'];
				$n_pass1=$_POST['n_pass1'];
				$n_pass2=$_POST['n_pass2'];
				
				$check_pass=$con->prepare("select * from user where u_email='$u_email' AND u_pass='$c_pass'");
				$check_pass->setFetchMode(PDO:: FETCH_ASSOC);
				$check_pass->execute();

				if(strlen($n_pass1)<8){
					echo"<script>alert('Please Enter Above 8 Digit Password')</script>";
					echo"<script>window.open('user_pro.php?mypass','_self')</script>";	
					exit();
				}
				
				if($n_pass1==$n_pass2){}else{
					echo"<script>alert('New Password And Current Password Does Not Metched')</script>";
					echo"<script>window.open('user_pro.php?mypass','_self')</script>";	
					exit();
				}
				
				if($check_pass->rowCount()==1){
					$up_pass=$con->prepare("update user set u_pass='$n_pass2' where u_email='$u_email' AND u_id='$u_id'");
					if($up_pass->execute()){
						echo"<script>alert('Password Updated Successfully')</script>";	
					}
				}else{
					echo"<script>alert('Your Enter Wrong Password')</script>";
					echo"<script>window.open('user_pro.php?mypass','_self')</script>";	
				}	
			}	
	}
	
	function slider(){
		include("inc/db.php");
		
		$get_img=$con->prepare("select * from slider");
		$get_img->setFetchMode(PDO:: FETCH_ASSOC);
		$get_img->execute();
		$row_img=$get_img->fetch();
		
		echo"<img src='imgs/slider/".$row_img['s_img1']."' />
            <img src='imgs/slider/".$row_img['s_img2']."' />
            <img src='imgs/slider/".$row_img['s_img3']."' />
            <img src='imgs/slider/".$row_img['s_img4']."' />
            <img src='imgs/slider/".$row_img['s_img5']."' />
            <img src='imgs/slider/".$row_img['s_img6']."' />
            <img src='imgs/slider/".$row_img['s_img7']."' />
            <img src='imgs/slider/".$row_img['s_img8']."' />
            <img src='imgs/slider/".$row_img['s_img9']."' />
            <img src='imgs/slider/".$row_img['s_img10']."' />";	
	}
	
	function user_pro(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
				
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		
		$row=$get_user->fetch();
		$u_id=$row['u_id'];
		
		echo"<form method='post' enctype='multipart/form-data'>
				<table>
					<tr>
						<td>Your Name : </td>
						<td><input type='text' name='u_name' value='".$row['u_name']."' required='required' pattern='[a-z A-Z]{2,30}' maxlength='30' minlength='2' /></td>
					</tr>
					<tr>
						<td>Your Picture : </td>
						<td><input type='file' name='u_img' accept='image/jpeg' /></td>
					</tr>
					<tr>
						<td>Your Address : </td>
						<td><input type='text' name='u_add' value='".$row['u_add']."' required='required' pattern='[a-z A-Z 0-9 ^/-.]{10,100}' maxlength='100' minlength='10' /></td>
					</tr>
					<tr>
						<td>Your Pincode : </td>
						<td><input type='tel' name='u_pin' value='".$row['u_pin']."' required='required' pattern='[0-9]{6}' maxlength='6' minlength='6' /></td>
					</tr>
					<tr>
						<td>Your Phone No. : </td>
						<td><input type='tel' name='u_phone' required='required' pattern='[0-9 ^+]{10,13}' maxlength='13' minlength='10' value='".$row['u_phone']."' /></td>
					</tr>
				</table>
				<center><input type='submit' value='Save' name='up_user_info' /></center>
			</form>";
			
			if(isset($_POST['up_user_info'])){
				$u_name=$_POST['u_name'];
				$u_add=$_POST['u_add'];
				$u_pin=$_POST['u_pin'];
				$u_phone=$_POST['u_phone'];
				
				if($_FILES['u_img']['tmp_name']==''){}else{
					$u_img=$_FILES['u_img']['name'];
					$u_img_tmp=$_FILES['u_img']['tmp_name'];
					
					move_uploaded_file($u_img_tmp,"imgs/u_img/$u_img");
					
					$up_img=$con->prepare("update user set u_img='$u_img' where u_id='$u_id'");
					$up_img->execute();
				}
				
				$up_user_info=$con->prepare("update user set u_name='$u_name',u_add='$u_add',u_pin='$u_pin',u_phone='$u_phone' where u_id='$u_id'");
				
				if($up_user_info->execute()){
					echo"<script>window.open('user_pro.php','_self');</script>";	
				}
					
			}
	}
	
	function offer(){
		include("inc/db.php");
		echo"<h3>Offers For You</h3>";
		$fetch_pro=$con->prepare("select * from products where pro_dis>0 ORDER BY 1 DESC LIMIT 0,3");
		$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pro->execute();
		
		while($row_pro=$fetch_pro->fetch()):
			echo"<li>
					<form method='post' enctype='multipart/form-data'>
					<a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'>
						<h4>".$row_pro['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_pro['pro_img1']."' />
						<center>
							<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'><i class='fa fa-eye'></i></a></button>
							<input type='hidden' value='".$row_pro['pro_id']."' name='pro_id' />
							<button id='pro_btn' name='cart_btn'><i class='fa fa-cart-plus'></i></button>
							<button id='pro_btn' name='whish_btn'><i class='fa fa-heart'></i></button>
						</center>
					</a>
					</form>
				</li>";
		endwhile;	
	}
	
	function electronics(){
		include("inc/db.php");
		
		$fetch_cat=$con->prepare("select * from main_cat");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();
		
		while($row_cat=$fetch_cat->fetch()):
		$cat_id=$row_cat['cat_id'];
		echo"<h3>".$row_cat['cat_name']."</h3><ul>";
		
		$fetch_pro=$con->prepare("select * from products where cat_id='$cat_id' ORDER BY 1 DESC LIMIT 0,4");
		$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pro->execute();
		
			while($row_pro=$fetch_pro->fetch()):
				echo"<li>
						<form method='post' enctype='multipart/form-data'>
						<a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'>
							<h4>".$row_pro['pro_name']."</h4>
							<img src='imgs/pro_img/".$row_pro['pro_img1']."' />
							<center>
								<button id='pro_btn' title='View More Details'><a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'><i class='fa fa-eye'></i></a></button>
								<input type='hidden' value='".$row_pro['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn' title='Add To Cart'><i class='fa fa-cart-arrow-down'></i> </button>
								<button id='pro_btn' name='whish_btn' title='Add To Whislist'><i class='fa fa-heart'></i></button>
							</center>
						</a>
						</form>
					</li>";
			endwhile;
			echo"<ul/><br clear='all' />";
		endwhile;	
	}
	
	function pro_details(){
		include("inc/db.php");
		
		if(isset($_GET['pro_id'])){
			$pro_id=$_GET['pro_id'];
			
			$update_count=$con->prepare("update products set pro_count=pro_count+1 where pro_id='$pro_id'");
			$update_count->execute();
			
			$pro_fetch=$con->prepare("select * from products where pro_id='$pro_id'");	
			$pro_fetch->setFetchMode(PDO:: FETCH_ASSOC);
			$pro_fetch->execute();
			
			$row_pro=$pro_fetch->fetch();
			$cat_id=$row_pro['cat_id'];
			$pro_price=$row_pro['pro_price'];
			$pro_dis=$row_pro['pro_dis'];
			$pro_sell_price=($pro_price * $pro_dis/100);
			echo"<div id='pro_img'>
					<div id='main_img'>
					<img src='imgs/pro_img/".$row_pro['pro_img1']."' />
					</div>
					<ul id='img_contain'>
						<li><img src='imgs/pro_img/".$row_pro['pro_img1']."' /></li>
						<li><img src='imgs/pro_img/".$row_pro['pro_img2']."' /></li>
						<li><img src='imgs/pro_img/".$row_pro['pro_img3']."' /></li>
						<li><img src='imgs/pro_img/".$row_pro['pro_img4']."' /></li>
					</ul>
				</div>
				<div id='pro_features'>
					<h3>".$row_pro['pro_name']."</h3>
					<ul>
						<li>".$row_pro['pro_feature1']."</li>
						<li>".$row_pro['pro_feature2']."</li>
						<li>".$row_pro['pro_feature3']."</li>
						<li>".$row_pro['pro_feature4']."</li>
						<li>".$row_pro['pro_feature5']."</li>
					</ul>
					<ul>
						<li>Model No. : ".$row_pro['pro_model']."</li>
						<li>Warranty : ".$row_pro['pro_warranty']."</li>
						
					</ul><br clear='all' />
					<center>";
					if($row_pro['pro_qty'] > 1){ 
						if($pro_dis > 0){
							echo"<h4> Price : ".$row_pro['pro_price']."</h4>
							<h4 style='color:green; text-decoration:none'>Discount : ".$row_pro['pro_dis']."%</h4>
							<h4 style='color:green; text-decoration:none'>Total Saving : #. $pro_sell_price</h4>";
						}
						echo"<h4 style='color:#2e2e2e; text-decoration:none'>Selling Price : ".$row_pro['pro_dis_price']."</h4>
								<p>This Product Is Viewed By ".$row_pro['pro_count']." People</p><br />
							<form method='post'>
								<input type='hidden' value='".$row_pro['pro_id']."' name='pro_id' />
								<button id='buy_now' name='buy_now'>Buy Now</button>
								<button id='buy_now' name='cart_btn'>Add To Cart</button>
							</form>";
					}
					if(isset($_POST['buy_now'])){
						if(!isset($_SESSION['u_email'])){
							echo"<script>alert('Please Login Or Signup')</script>";	
						}else{
							echo"<script>window.open('checkout.php?checkout=$pro_id','_self')</script>";	
						}	
					}
					if($row_pro['pro_qty'] < 1){
						echo"<h3 style='text-align:center'>In Stock : <span style='color:#f00'>Out Of Stock</span></h3>";	
					}else{
						echo"<h3 style='text-align:center'>In Stock : <span style='color:green'>Available</span></h3>";	
					}
				echo"<div id='share'>
						<div id='f'>
							<a href='http://www.facebook.com/sharer.php?u=http://127.0.0.0/online%20store/pro_detail.php?pro_id=$pro_id' title='Facebook Share' target='_blank'>Fb Share</a>
						</div>
						<div id='gp'>
							<a href='http://plus.google.com/share?url=http://127.0.0.0/online%20store/pro_detail.php?pro_id=$pro_id' target='_blank' title='Google Plus Share'>G+ Share</a>
						</div>
						<div id='t'>
							<a href='https://twitter.com/intent/tweet?text=Check Out This At http://127.0.0.0/online%20store/pro_detail.php?pro_id=$pro_id' target='_blank' title='Twitter Tweet'>Tweet</a>
						</div>
						<div id='wp'>
							<a href='whatsapp://send?text=".$row_pro['pro_name']." http://127.0.0.0/online%20store/pro_detail.php?pro_id=$pro_id' target='_blank'>Whatsapp Share</a>
						</div>					
					</div></center>
					<span id='keystrok'>Cash On Delivery Available</span>
					<span id='keystrok'>30 day Replacement Guarantee.</span>
					<span id='keystrok'>Delivered In 2-3 Working Days</span>
				</ul>
				</div><br clear='all' />
				<div id='sim_pro'>
					<h3>Related Products</h3>
					<ul>";
						echo add_cart();
						$sim_pro=$con->prepare("select * from products where pro_id!=$pro_id AND cat_id='$cat_id' LIMIT 0,5");
						$sim_pro->setFetchMode(PDO:: FETCH_ASSOC);
						$sim_pro->execute();
						while($row=$sim_pro->fetch()):
							echo"<li>
									<a href='pro_detail.php?pro_id=".$row['pro_id']."'>
										<img src='imgs/pro_img/".$row['pro_img1']."' />
										<p>".$row['pro_name']."</p>
										<p>Price : ".$row['pro_price']."</p>
									</a>
								</li>";
						endwhile;
					echo"</ul>
				</div><br clear='all' />";
		}
			
	}
	
	function checkout_user_address(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$row_user_get=$get_user->fetch();
		echo"<h3>".$row_user_get['u_name']."</h3>
			<p>".$row_user_get['u_add']."</p>
			<p>".$row_user_get['u_state']." , ".$row_user_get['u_country']."</p>
			<p>".$row_user_get['u_pin'].".</p>
			<p>".$row_user_get['u_phone']."</p>";	
	}
	
	function up_user_checkout(){
		include("inc/db.php");
		$u_email=$_SESSION['u_email'];
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$row_user_get=$get_user->fetch();
		echo"<form method='post' enctype='multipart/form-data'>
				<table>
					<tr>
						<td>Update User Name :</td>
						<td><input required='required' type='text' name='u_name' value='".$row_user_get['u_name']."' /></td>
					</tr>
					<tr>
						<td>Update User Address :</td>
						<td><input required='required' type='text' name='u_add' value='".$row_user_get['u_add']."' /></td>
					</tr>
					<tr>
						<td>Update User State :</td>
						<td><input required='required' type='text' name='u_state' value='".$row_user_get['u_state']."' /></td>
					</tr>
					<tr>
						<td>Update User Country :</td>
						<td><input required='required' type='text' name='u_country' value='".$row_user_get['u_country']."' /></td>
					</tr>
					<tr>
						<td>Update User Postal Code :</td>
						<td><input required='required' type='text' name='u_pin' value='".$row_user_get['u_pin']."' /></td>
					</tr>
					<tr>
						<td>Update User Phone :</td>
						<td><input required='required' type='text' name='u_phone' value='".$row_user_get['u_add']."' /></td>
					</tr>
				</table>
				<center><input type='submit' name='up_u_add' value='Update' /></center>
			</form>";
			if(isset($_POST['up_u_add'])){
				$u_name=$_POST['u_name'];
				$u_add=$_POST['u_add'];
				$u_state=$_POST['u_state'];
				$u_country=$_POST['u_country'];
				$u_pin=$_POST['u_pin'];
				$u_phone=$_POST['u_phone'];
				
				$update_user=$con->prepare("update user set u_name='$u_name',u_add='$u_add',u_state='$u_state',u_country='$u_country',u_pin='$u_pin',u_phone='$u_phone'");
				if($update_user->execute()){
					echo"<script>alert('Address Updated');</script>";
					echo"<script>window.open('checkout.php','_self');</script>";	
				}	
			}	
	}
	
	function single_pro(){
		include("inc/db.php");
		if(isset($_GET['checkout'])){
			$ip=getIp();
			$u_email=$_SESSION['u_email'];
			$get_user=$con->prepare("select * from user where u_email='$u_email'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user_get=$get_user->fetch();
			$u_id=$row_user_get['u_id'];
			$u_name=$row_user_get['u_name'];
			
			$pro_id=$_GET['checkout'];
			$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
			$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$get_pro->execute();
			$row_pro=$get_pro->fetch();
			$amt=$row_pro['pro_dis_price'];
			$main_qty=$row_pro['pro_qty'];

			$get_qty=$con->prepare("select * from user_cart where u_id='$u_id' AND pro_id='$pro_id'");
			$get_qty->setFetchMode(PDO:: FETCH_ASSOC);
			$get_qty->execute();
			$row_qty=$get_qty->fetch();
			$q=$row_qty['qty'];
	
			$total=$amt * $q;		
			$row_cart_count=$get_qty->rowCount();
			if($row_cart_count==1){}else{
				$add_to_cart=$con->prepare("insert into user_cart(pro_id,qty,ip_add,u_id)value('$pro_id',1,'$ip','$u_id')");
				
				if($add_to_cart->execute()){
					echo"<script>window.open('checkout.php?checkout=$pro_id','_self');</script>";	
				}	
			}
			$net_total=0;
			echo"<form method='post'>
					<table cellpadding='0' cellspacing='0'>
							<tr>
								<th>Image</th>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Remove</th>
								<th>Sub Total</th>
								<th>Shipping fee</th>
							</tr>
							<tr>
							<td><img src='imgs/pro_img/".$row_pro['pro_img1']."' /></td>
							<td>".$row_pro['pro_name']."</td>
							<td><input type='text' pattern='[0-9]{0,2}' name='qty' value='".$row_qty['qty']."' /><input type='submit' name='up_qty' value='Save' /></td>
							<td>".$row_pro['pro_dis_price']."</td>
							<td><a href='delete.php?delete_id=".$row_pro['pro_id']."'><i class='fa fa-trash'></i></a></td>
							<td>";
								$sub_total=$row_qty['qty']*$row_pro['pro_dis_price'];
								echo $sub_total;
								$net_total=$net_total+$sub_total+2000;
							echo"</td>
							<td>2000</td>
						</tr>
						<tr>
							<td></td><td></td><td></td><td></td>
							<td>Amout Payable : </td>
							<td>$net_total</td>
						</tr>
					</table>
					<center>
						<button id='buy_now'><a href='index.php'>Continue Shopping</a></button>
						<button id='buy_now'><b>Net Total = ₦ $net_total </b></button>
						<form method='post'>
							<script src='https://js.paystack.co/v1/inline.js'></script>
							<button type='button' id='buy_now' name='multi_buy' onclick='payWithPaystack()'> Pay </button> 
							</form></center>
							<script>
							function payWithPaystack(){
							var handler = PaystackPop.setup({
							  key: 'pk_test_88fcb9c28b9a7ea83941a7b38fe770dab430688e',
							  email: 'outfitsystem@gmail.com',
							  amount: $net_total*100,
							  currency: 'NGN',
							  ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
							  firstname: 'Stephen',
							  lastname: 'King',
							  // label: 'Optional string that replaces customer email'
							  metadata: {
							     custom_fields: [
							        {
							            display_name: 'Mobile Number',
							            variable_name: 'mobile_number',
							            value: '+2348012345678'
							        }
							     ]
							  },
							  callback: function(response){
							  	console.log(response)
							      // window.open('index.php','_self');
							      if(response.status == 'success'){
							      	alert('Payment Successfull. transaction ref is ' + response.reference);
									window.open('online_payment_response.php','_self');
							      }else{
							      	alert('Payment failed');
							      }
							  },
							  onClose: function(){
							      alert('window closed');
							  }
							});
							handler.openIframe();
							}
							</script>
							";
				if(isset($_POST['single_buy'])){
					$ip=getIp();
					$trx_id="ORD".substr(mt_rand(),0,10)."RCV";
					$insert=$con->prepare("insert into payment(pro_id,u_id,amt,qty,ip_add,status,pay_date,trx_id)values('$pro_id','$u_id','$total','$q','$ip','Pending',NOW(),'$trx_id')");	
					if($insert->execute()){
						echo"<script>alert('We Recive Your Order')</script>";
						echo"<script>window.open('user_pro.php?myorder','_self');</script>";	
					}
					
					$new_qty= $main_qty - $q;
					
					$price_c=$main_qty * $row_pro['pro_dis_price'];
					
					$up_qty=$con->prepare("update products set pro_qty='$new_qty' where pro_id='$pro_id'");
					$up_qty->execute();
					
					$del=$con->prepare("delete from user_cart where pro_id='$pro_id' AND u_id='$u_id'");
					$del->execute();
					
					$headers="MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <service@royalcollection.tk>' . "\r\n";
					
					$subject= "Order Details";
					$msg= "<html>
							<p>Hello Dear Costumer $u_name We Receive Your Order And Here Is Your Order Summery</p>
								<center style='font-family:verdana'>
									<table style='font-family:verdana' width='90%'>
										<tr>
											<th style='height:30px; color:#FFF;background:#400040' colspan='5'><h3>Order Details</h3></th>
										</tr>
										<tr>
											<th style='height:25px; background:#e6e6e6'>Order ID</th>
											<th style='height:25px; background:#e6e6e6'>Item Name</th>
											<th style='height:25px; background:#e6e6e6'>Qty</th>
											<th style='height:25px; background:#e6e6e6'>Price</th>
											<th style='height:25px; background:#e6e6e6'>Sub Total</th>
										</tr>
										<tr>
											<td style='height:20px;text-align:center'>$trx_id</td>
											<td style='height:20px;text-align:center'>".$row_pro['pro_name']."</td>
											<td style='height:20px;text-align:center'>$main_qty</td>
											<td style='height:20px;text-align:center'>".$row_pro['pro_dis_price']."</td>
											<td style='height:20px;text-align:center'>$price_c</td>
										</tr>
										<tr>
											<td></td><td></td><td></td><td></td>
											<td style='height:20px'><b>Payable Amount : $price_c</b></td>
										</tr>
									</table>
								</center>
								<p>Go To Your Account Using <a href='#'>Click Here</a> Happy Shopping Thank You</p>
						</html>";
					mail($u_mail,$subject,$msg,$headers);
				}
				if(isset($_POST['up_qty'])){
					$qty=$_POST['qty'];
					$up_qty=$con->prepare("update user_cart set qty='$qty' where pro_id='$pro_id' AND u_id='$u_id'");
					if($up_qty->execute()){
						echo"<script>window.open('checkout.php?checkout=$pro_id','_self');</script>";	
					}	
				}	
		}else{
			echo cart_display();	
		}
	}
	function paypal_buy(){
		include("inc/db.php");
		
		$u_email=$_SESSION['u_email'];
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$row_user=$get_user->fetch();
		
		$u_id=$row_user['u_id'];
		$pro_id=$_GET['item_number'];
		$qty=$_GET['qty'];
		$amt=$_GET['amt'];
		$trx_id=$_GET['tx'];
		$ip=getIp();
		$status='Pending';
		
		$get_qty=$con->prepare("select * from products where pro_id=$pro_id");
		$get_qty->setFetchMode(PDO:: FETCH_ASSOC);
		$get_qty->execute();
		$row_qty=$get_qty->fetch();
		$main_qty=$row_qty['pro_qty'];
		
		$insert=$con->prepare("insert into payment(pro_id,u_id,amt,qty,ip_add,status,pay_date,trx_id)values('$pro_id','$u_id','$amt','$qty','$ip','$status',NOW(),'$trx_id')");	
		if($insert->execute()){
			echo"<script>alert('We Recive Your Order')</script>";
			echo"<script>window.open('user_pro.php?myorder','_self');</script>";	
		}
		
		$new_qty= $main_qty - $qty;
		
		$up_qty=$con->prepare("update products set pro_qty='$new_qty' where pro_id='$pro_id'");
		$up_qty->execute();
		
		$del=$con->prepare("delete from user_cart where pro_id='$pro_id' AND u_id='$u_id'");
		$del->execute();

	}
	function paypal_multi_buy(){
		include("inc/db.php");
		$ip=getIp();
		$u_email=$_SESSION['u_email'];
		$get_user=$con->prepare("select * from user where u_email='$u_email'");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$row_user=$get_user->fetch();
		$u_id=$row_user['u_id'];
			
		$get_cart_item=$con->prepare("select * from user_cart where ip_add='$ip' AND u_id='$u_id'");
		$get_cart_item->setFetchMode(PDO:: FETCH_ASSOC);
		$get_cart_item->execute();	
		
		while($row_cart=$get_cart_item->fetch()):
			$pro_id=$row_cart['pro_id'];
			$qty=$row_cart['qty'];
			$trx_id="ORD".substr(mt_rand(),0,10)."RCV";
			
			$get_qty=$con->prepare("select * from products where pro_id='$pro_id'");
			$get_qty->setFetchMode(PDO:: FETCH_ASSOC);
			$get_qty->execute();
			$row_qty=$get_qty->fetch();
			
			$pro_price=$row_qty['pro_dis_price'];
			
			$total=$pro_price * $qty;
			
			$insert=$con->prepare("insert into payment(u_id,pro_id,amt,qty,trx_id,ip_add,status,pay_date)values('$u_id','$pro_id','$total','$qty','$trx_id','$ip','Pending',NOW())");	
			if($insert->execute()){
				echo"<script>alert('We Recive Your Order')</script>";
				echo"<script>window.open('user_pro.php?myorder','_self')</script>";	
			}
			$new_qty=$row_qty['pro_qty'] - $qty;
			$up_qty=$con->prepare("update products set pro_qty='$new_qty' where pro_id='$pro_id'");
			$up_qty->execute();
		endwhile;
		$del_cart=$con->prepare("delete from user_cart where u_id='$u_id'");
		$del_cart->execute();
	}
	function all_cat(){
		include("inc/db.php");
		
		$all_cat=$con->prepare("select * from main_cat");
		$all_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$all_cat->execute();
		
		while($row=$all_cat->fetch()):
			echo"<li><a href='cat_detail.php?cat_id=".$row['cat_id']."'>".$row['cat_name']."</a></li>";
		endwhile;	
	}
	
	function cat_detail(){
		include("inc/db.php");
		
		if(isset($_GET['cat_id'])){
			$cat_id=$_GET['cat_id'];
			$cat_pro=$con->prepare("select * from products where cat_id='$cat_id'");
			$cat_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$cat_pro->execute();
			
			$cat_name=$con->prepare("select * from main_cat where cat_id='$cat_id'");
			$cat_name->setFetchMode(PDO:: FETCH_ASSOC);
			$cat_name->execute();
			
			$row=$cat_name->fetch();
			$row_main_cat=$row['cat_name'];
			echo"<h3>$row_main_cat</h3>"
;			
			while($row_cat=$cat_pro->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_cat['pro_id']."'>
						<h4>".$row_cat['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_cat['pro_img1']."' />
						<center>
						<form method='post'>
							<input type='hidden' value='".$row_cat['pro_id']."' name='pro_id' />
							<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_cat['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
							<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
							<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
						</form>
						</center>
					</a>
				</li>";
			endwhile;		
		}	
	}
	
	function viewall_sub_cat(){
		include("inc/db.php");
		if(isset($_GET['cat_id'])){
			$cat_id=$_GET['cat_id'];
			$sub_cat=$con->prepare("select * from sub_cat where cat_id='$cat_id'");
			$sub_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$sub_cat->execute();
			echo "<h3>Sub Categories</h3>";
			while($row=$sub_cat->fetch()):
				echo"<li><a href='cat_detail.php?sub_cat_id=".$row['sub_cat_id']."'>".$row['sub_cat_name']."</a></li>";
			endwhile;
		}	
	}
	
	function sub_cat_detail(){
		include("inc/db.php");
		
		if(isset($_GET['sub_cat_id'])){
			$sub_cat_id=$_GET['sub_cat_id'];
			$sub_cat_pro=$con->prepare("select * from products where sub_cat_id='$sub_cat_id'");
			$sub_cat_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$sub_cat_pro->execute();
			
			$sub_cat_name=$con->prepare("select * from sub_cat where sub_cat_id='$sub_cat_id'");
			$sub_cat_name->setFetchMode(PDO:: FETCH_ASSOC);
			$sub_cat_name->execute();
			
			$row=$sub_cat_name->fetch();
			$row_sub_cat=$row['sub_cat_name'];
			echo"<h3>$row_sub_cat</h3>";			
			while($row_sub_cat=$sub_cat_pro->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_sub_cat['pro_id']."'>
						<h4>".$row_sub_cat['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_sub_cat['pro_img1']."' />
						<center>
							<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_sub_cat['pro_id']."'>View</a></button>
							<button id='pro_btn'><a href='#'>Cart</a></button>
							<button id='pro_btn'><a href='#'>Wishlist</a></button>
						</center>
					</a>
				</li>";
			endwhile;		
		}	
	}
	
	function viewall_cat(){
		include("inc/db.php");
		if(isset($_GET['sub_cat_id'])){
			$main_cat=$con->prepare("select * from main_cat");
			$main_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$main_cat->execute();
			echo "<h3>Categories</h3>";
			while($row=$main_cat->fetch()):
				echo"<li><a href='cat_detail.php?cat_id=".$row['cat_id']."'>".$row['cat_name']."</a></li>";
			endwhile;
		}	
	}
	
	function bd_men(){
		include("inc/db.php");
		if(isset($_GET['bd_men'])){
			$fetch_pro=$con->prepare("select * from products where for_whome='men'");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();
			echo "<h3>Birthday Gifts For Men</h3>";
			while($row_men=$fetch_pro->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_men['pro_id']."'>
						<h4>".$row_men['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_men['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_men['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_men['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;		
		}	
	}
	
	function bd_women(){
		include("inc/db.php");
		if(isset($_GET['bd_women'])){
			$fetch_pro=$con->prepare("select * from products where for_whome='women'");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();
			echo "<h3>Birthday Gifts For WoMen</h3>";
			while($row_men=$fetch_pro->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_men['pro_id']."'>
						<h4>".$row_men['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_men['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_men['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_men['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;		
		}	
	}
	
	function bd_kids(){
		include("inc/db.php");
		if(isset($_GET['bd_kids'])){
			$fetch_pro=$con->prepare("select * from products where for_whome='kids'");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();
			echo "<h3>Birthday Gifts For Kids</h3>";
			while($row_men=$fetch_pro->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_men['pro_id']."'>
						<h4>".$row_men['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_men['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_men['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_men['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;		
		}	
	}
	
	function all_about_men(){
		include("inc/db.php");
		if(isset($_GET['men_watch'])){
			$men_watch="watch";
			
			$watch=$con->prepare("select * from products where for_whome='men' and pro_name like '%$men_watch%'");
			$watch->setFetchMode(PDO:: FETCH_ASSOC);
			$watch->execute();
			
			echo "<h3>Watches For Men</h3>";
			while($row_watch=$watch->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_watch['pro_id']."'>
						<h4>".$row_watch['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_watch['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_watch['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_watch['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}
		
		if(isset($_GET['men_belt'])){
			$men_belt="belt";
			
			$belt=$con->prepare("select * from products where for_whome='men' and pro_name like '%$men_belt%'");
			$belt->setFetchMode(PDO:: FETCH_ASSOC);
			$belt->execute();
			
			echo "<h3>Belts For Men</h3>";
			while($row_belt=$belt->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_belt['pro_id']."'>
						<h4>".$row_belt['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_belt['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_belt['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_belt['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}
		
		if(isset($_GET['men_perfuemes'])){
			$men_per="perfumes";
			
			$per=$con->prepare("select * from products where for_whome='men' and pro_name like '%$men_per%'");
			$per->setFetchMode(PDO:: FETCH_ASSOC);
			$per->execute();
			
			echo "<h3>Belts For Perfumes</h3>";
			while($row_per=$per->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_per['pro_id']."'>
						<h4>".$row_per['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_per['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_per['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_per['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}	
	}
	
	function all_about_women(){
		include("inc/db.php");
		if(isset($_GET['women_watch'])){
			$men_watch="watch";
			
			$watch=$con->prepare("select * from products where for_whome='women' and pro_name like '%$men_watch%'");
			$watch->setFetchMode(PDO:: FETCH_ASSOC);
			$watch->execute();
			
			echo "<h3>Watches For WoMen</h3>";
			while($row_watch=$watch->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_watch['pro_id']."'>
						<h4>".$row_watch['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_watch['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_watch['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_watch['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}
		
		if(isset($_GET['women_belt'])){
			$men_belt="belt";
			
			$belt=$con->prepare("select * from products where for_whome='women' and pro_name like '%$men_belt%'");
			$belt->setFetchMode(PDO:: FETCH_ASSOC);
			$belt->execute();
			
			echo "<h3>Belts For WoMen</h3>";
			while($row_belt=$belt->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_belt['pro_id']."'>
						<h4>".$row_belt['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_belt['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_belt['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_belt['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}
		
		if(isset($_GET['women_perfuemes'])){
			$men_per="perfumes";
			
			$per=$con->prepare("select * from products where for_whome='women' and pro_name like '%$men_per%'");
			$per->setFetchMode(PDO:: FETCH_ASSOC);
			$per->execute();
			
			echo "<h3>Perfumes For Women</h3>";
			while($row_per=$per->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_per['pro_id']."'>
						<h4>".$row_per['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_per['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_per['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_per['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}	
	}
	
	function all_about_kids(){
		include("inc/db.php");
		if(isset($_GET['kids_watch'])){
			$men_watch="watch";
			
			$watch=$con->prepare("select * from products where for_whome='kids' and pro_name like '%$men_watch%'");
			$watch->setFetchMode(PDO:: FETCH_ASSOC);
			$watch->execute();
			
			echo "<h3>Watches For Kids</h3>";
			while($row_watch=$watch->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_watch['pro_id']."'>
						<h4>".$row_watch['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_watch['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_watch['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_watch['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}
		
		if(isset($_GET['kids_belt'])){
			$men_belt="belt";
			
			$belt=$con->prepare("select * from products where for_whome='kids' and pro_name like '%$men_belt%'");
			$belt->setFetchMode(PDO:: FETCH_ASSOC);
			$belt->execute();
			
			echo "<h3>Belts For Kids</h3>";
			while($row_belt=$belt->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_belt['pro_id']."'>
						<h4>".$row_belt['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_belt['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_belt['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_belt['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}
		
		if(isset($_GET['kids_games'])){
			$men_per="game";
			
			$per=$con->prepare("select * from products where for_whome='kids' and pro_name like '%$men_per%'");
			$per->setFetchMode(PDO:: FETCH_ASSOC);
			$per->execute();
			
			echo "<h3>Games For Kids</h3>";
			while($row_per=$per->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row_per['pro_id']."'>
						<h4>".$row_per['pro_name']."</h4>
						<img src='imgs/pro_img/".$row_per['pro_img1']."' />
						<center>
							<form method='post'>
								<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_per['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
								<input type='hidden' value='".$row_per['pro_id']."' name='pro_id' />
								<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
								<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
							</form>
						</center>
					</a>
				</li>";
			endwhile;	
		}	
	}
	function search(){
		include("inc/db.php");
		if(isset($_GET['search'])){
		$user_query=$_GET['user_query'];
		
		$search=$con->prepare("select * from products where pro_name like '%$user_query%' or pro_keyword like '%$user_query%'");
		$search->setFetchMode(PDO:: FETCH_ASSOC);
		$search->execute();
		echo"<div id='bodyleft'><ul>";
		if($search->rowCount()==0){
			echo"<h2>Product NOt Found With This Keyword</h2>";	
		}
		else{
		while($row=$search->fetch()):
			echo"<li>
					<a href='pro_detail.php?pro_id=".$row['pro_id']."'>
						<h4>".$row['pro_name']."</h4>
						<img src='imgs/pro_img/".$row['pro_img1']."' />
						<center>
						<form method='post'>
							<input type='hidden' value='".$row['pro_id']."' name='pro_id' />
							<button id='pro_btn'><a href='pro_detail.php?pro_id=".$row['pro_id']."'><i class='fa fa-eye' area-hidden='true'></i></a></button>
							<button id='pro_btn' name='cart_btn'><i class='fa fa-shopping-cart' area-hidden='true'></i></i></button>
							<button id='pro_btn' name='whish_btn'><i class='fa fa-heart' area-hidden='true'></i></button>
						</form>
						</center>
					</a>
				</li>";
		endwhile;
		}
		echo"</ul></div>";
		}
	}
?>