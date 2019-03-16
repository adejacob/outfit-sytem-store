<?php
	function overview(){
		include("inc/db.php");
		$get_pro=$con->prepare("select * from products");
		$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$get_pro->execute();
		$count_pro=$get_pro->rowCount();
		
		$get_cat=$con->prepare("select * from main_cat");
		$get_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$get_cat->execute();
		$count_cat=$get_cat->rowCount();
		
		$get_cat_sub=$con->prepare("select * from sub_cat");
		$get_cat_sub->setFetchMode(PDO:: FETCH_ASSOC);
		$get_cat_sub->execute();
		$count_cat_sub=$get_cat_sub->rowCount();
		
		$comp_ord=$con->prepare("select * from payment where status='Complete'");
		$comp_ord->setFetchMode(PDO:: FETCH_ASSOC);
		$comp_ord->execute();
		$count_comp_ord=$comp_ord->rowCount();
		
		$pen_ord=$con->prepare("select * from payment where status='Pendding'");
		$pen_ord->setFetchMode(PDO:: FETCH_ASSOC);
		$pen_ord->execute();
		$count_pen_ord=$pen_ord->rowCount();
		
		$can_ord=$con->prepare("select * from payment where status='Cancle'");
		$can_ord->setFetchMode(PDO:: FETCH_ASSOC);
		$can_ord->execute();
		$count_can_ord=$can_ord->rowCount();
		
		$dis_pro=$con->prepare("select * from products where pro_dis>0");
		$dis_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$dis_pro->execute();
		$count_dis_pro=$dis_pro->rowCount();
		
		$out_pro=$con->prepare("select * from products where pro_qty=0");
		$out_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$out_pro->execute();
		$count_out_pro=$out_pro->rowCount();
		
		$get_user=$con->prepare("select * from user");
		$get_user->setFetchMode(PDO:: FETCH_ASSOC);
		$get_user->execute();
		$count_cust=$get_user->rowCount();
		
		$get_country=$con->prepare("select * from country");
		$get_country->setFetchMode(PDO:: FETCH_ASSOC);
		$get_country->execute();
		$count_con=$get_country->rowCount();
		
		$get_state=$con->prepare("select * from state");
		$get_state->setFetchMode(PDO:: FETCH_ASSOC);
		$get_state->execute();
		$count_state=$get_state->rowCount();
		
		$get_wish=$con->prepare("select * from user_wishlist");
		$get_wish->setFetchMode(PDO:: FETCH_ASSOC);
		$get_wish->execute();
		$count_wish=$get_wish->rowCount();
		
		echo"<h3>Overview</h3>
				<div id='main_part'>
					<div id='part' style='background:#2e2e2e'>
						<h4><b>$count_pro</b><br />Total products</h4>
						<h2><i style='color:#000' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#000'><a href='index.php?viewall_products'>View More</a></p>
					</div>
					<div id='part' style='background:#ff4000'>
						<h4><b>$count_cat</b><br />Total Categories</h4>
						<h2><i style='color:#b43104' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#b43104'><a href='index.php?viewall_cat'>View More</a></p>
					</div>
					<div id='part' style='background:#0c9'>
						<h4><b>$count_cat_sub</b><br />Total Sub Categories</h4>
						<h2><i style='color:#0c6' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#0c6'><a href='index.php?viewall_sub_cat'>View More</a></p>
					</div>
					<div id='part' style='background:#06f'>
						<h4><b>$count_comp_ord</b><br />Order Shipped</h4>
						<h2><i style='color:#03f' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#03f'><a href='index.php?complete_order'>View More</a></p>
					</div>
					<div id='part' style='background:#060'>
						<h4><b>$count_pen_ord</b><br />Pending Orders</h4>
						<h2><i style='color:#090' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#090'><a href='index.php?pending_order'>View More</a></p>
					</div>
					<div id='part' style='background:#004080'>
						<h4><b>$count_can_ord</b><br />Order Cancel</h4>
						<h2><i style='color:#008080' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#008080'><a href='index.php?cancle_order'>View More</a></p>
					</div>
					<div id='part' style='background:#FF8000'>
						<h4><b>$count_dis_pro</b><br />Discount Products</h4>
						<h2><i style='color:#804000' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#804000'><a href='index.php?dis_pro'>View More</a></p>
					</div>
					<div id='part' style='background:#800000'>
						<h4><b>$count_out_pro</b><br />Out Of Stock products</h4>
						<h2><i style='color:#400000' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#400000'><a href='index.php?out_stock'>View More</a></p>
					</div>
					<div id='part' style='background:#f0f'>
						<h4><b>$count_cust</b><br />Total Customers</h4>
						<h2><i style='color:#FF80FF' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#FF80FF'><a href='index.php?customer'>View More</a></p>
					</div>
					<div id='part' style='background:#96f'>
						<h4><b>$count_con</b><br />Total Countries</h4>
						<h2><i style='color:#99f' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#99f'><a href='index.php?country'>View More</a></p>
					</div>
					<div id='part' style='background:#CD5C5C'>
						<h4><b>$count_state</b><br />Total States</h4>
						<h2><i style='color:#f08080' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#F08080'><a href='index.php?state'>View More</a></p>
					</div>
					<div id='part' style='background:#4863a0'>
						<h4><b>$count_wish</b><br />Total Wishlist Products</h4>
						<h2><i style='color:#737ca1' class='fa fa-user' area-hidden='true'></i></h2><br clear='all' />
						<p style='background:#737ca1'><a href='index.php?wish'>View More</a></p>
					</div>
				</div>";	
	}
	function login(){
		include("inc/db.php");
		if(isset($_POST['login'])){
			$a_name=md5($_POST['a_name']);
			$a_email=md5($_POST['a_email']);
			$a_pass=md5($_POST['a_pass']);
			
			$get_user=$con->prepare("select * from admin where a_name='$a_name' AND a_email='$a_email' And a_pass='$a_pass'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$count=$get_user->rowCount();
			if($count==1){
				$_SESSION['a_email']=$a_email;
				header("Location:index.php");	
			}else{
				echo"<script>alert('Invalide UserName Or Email Or Password');</script>";
			}	
		}	
	}
	
	function add_cat(){
		include("inc/db.php");
		if(isset($_POST['add_cat'])){
			$cat_name=$_POST['cat_name'];
			$add_cat=$con->prepare("insert into main_cat(cat_name)values('$cat_name')");
			
			if($add_cat->execute()){
				echo "<script>alert('Category Added Successfully !!!');</script>";	
				echo "<script>window.open('index.php?viewall_cat','_self');</script>";
			}
			else{
				echo "<script>alert('Category Not Added Successfully !!!');</script>";	
			}	
		}	
	}
	
	function add_sub_cat(){
		include("inc/db.php");
		if(isset($_POST['add_sub_cat'])){
			$cat_id=$_POST['main_cat'];
			$sub_cat_name=$_POST['sub_cat_name'];
			
			$add_sub_cat=$con->prepare("insert into sub_cat(sub_cat_name,cat_id)values('$sub_cat_name','$cat_id')");
			
			if($add_sub_cat->execute()){
				echo "<script>alert('Sub Category Added Successfully !!!');</script>";	
				echo "<script>window.open('index.php?viewall_sub_cat','_self');</script>";
			}
			else{
				echo "<script>alert('Sub Category Not Added Successfully !!!');</script>";	
			}	
		}	
	}
	
	function up_slider(){
		include("inc/db.php");
		if(isset($_POST['up_slider'])){
			if($pro_img1_tmp=$_FILES['pro_img1']['tmp_name']==""){}else{
				$pro_img1=$_FILES['pro_img1']['name'];
				$pro_img1_tmp=$_FILES['pro_img1']['tmp_name'];
				move_uploaded_file($pro_img1_tmp,"../imgs/slider/$pro_img1");
				
				$up1=$con->prepare("update slider set s_img1='$pro_img1'");
				$up1->execute();
			}
			if($pro_img2_tmp=$_FILES['pro_img2']['tmp_name']==""){}else{
				$pro_img2=$_FILES['pro_img2']['name'];
				$pro_img2_tmp=$_FILES['pro_img2']['tmp_name'];
				move_uploaded_file($pro_img2_tmp,"../imgs/slider/$pro_img2");
				
				$up2=$con->prepare("update slider set s_img2='$pro_img2'");
				$up2->execute();
			}
			if($pro_img3_tmp=$_FILES['pro_img3']['tmp_name']==""){}else{
				$pro_img3=$_FILES['pro_img3']['name'];
				$pro_img3_tmp=$_FILES['pro_img3']['tmp_name'];
				move_uploaded_file($pro_img3_tmp,"../imgs/slider/$pro_img3");
				
				$up3=$con->prepare("update slider set s_img3='$pro_img3'");
				$up3->execute();
			}
			if($pro_img4_tmp=$_FILES['pro_img4']['tmp_name']==""){}else{
				$pro_img4=$_FILES['pro_img4']['name'];
				$pro_img4_tmp=$_FILES['pro_img4']['tmp_name'];
				move_uploaded_file($pro_img4_tmp,"../imgs/slider/$pro_img4");
				
				$up4=$con->prepare("update slider set s_img4='$pro_img4'");
				$up4->execute();
			}
			if($pro_img5_tmp=$_FILES['pro_img5']['tmp_name']==""){}else{
				$pro_img5=$_FILES['pro_img5']['name'];
				$pro_img5_tmp=$_FILES['pro_img5']['tmp_name'];
				move_uploaded_file($pro_img5_tmp,"../imgs/slider/$pro_img5");
				
				$up5=$con->prepare("update slider set s_img5='$pro_img5'");
				$up5->execute();
			}
			if($pro_img6_tmp=$_FILES['pro_img6']['tmp_name']==""){}else{
				$pro_img6=$_FILES['pro_img6']['name'];
				$pro_img6_tmp=$_FILES['pro_img6']['tmp_name'];
				move_uploaded_file($pro_img6_tmp,"../imgs/slider/$pro_img6");
				
				$up6=$con->prepare("update slider set s_img6='$pro_img6'");
				$up6->execute();
			}
			if($pro_img7_tmp=$_FILES['pro_img7']['tmp_name']==""){}else{
				$pro_img7=$_FILES['pro_img7']['name'];
				$pro_img7_tmp=$_FILES['pro_img7']['tmp_name'];
				move_uploaded_file($pro_img7_tmp,"../imgs/slider/$pro_img7");
				
				$up7=$con->prepare("update slider set s_img7='$pro_img7'");
				$up7->execute();
			}
			if($pro_img8_tmp=$_FILES['pro_img8']['tmp_name']==""){}else{
				$pro_img8=$_FILES['pro_img8']['name'];
				$pro_img8_tmp=$_FILES['pro_img8']['tmp_name'];
				move_uploaded_file($pro_img8_tmp,"../imgs/slider/$pro_img8");
				
				$up8=$con->prepare("update slider set s_img8='$pro_img8'");
				$up8->execute();
			}
			if($pro_img9_tmp=$_FILES['pro_img9']['tmp_name']==""){}else{
				$pro_img9=$_FILES['pro_img9']['name'];
				$pro_img9_tmp=$_FILES['pro_img9']['tmp_name'];
				move_uploaded_file($pro_img9_tmp,"../imgs/slider/$pro_img9");
				
				$up9=$con->prepare("update slider set s_img9='$pro_img9'");
				$up9->execute();
			}
			if($pro_img10_tmp=$_FILES['pro_img10']['tmp_name']==""){}else{
				$pro_img10=$_FILES['pro_img10']['name'];
				$pro_img10_tmp=$_FILES['pro_img10']['tmp_name'];
				move_uploaded_file($pro_img10_tmp,"../imgs/slider/$pro_img10");
				
				$up10=$con->prepare("update slider set s_img10='$pro_img10'");
				$up10->execute();
			}
			echo"<script>alert('Slider Updated Successfully');</script>";
			echo"<script>window.open('index.php?slider','_self');</script>";	
		}	
	}
	
	function add_pro(){
		include("inc/db.php");
		if(isset($_POST['add_product'])){
			$pro_name=$_POST['pro_name'];
			$cat_id=$_POST['cat_name'];
			$sub_cat_id=$_POST['sub_cat_name'];
			
			$pro_img1=$_FILES['pro_img1']['name'];
			$pro_img1_tmp=$_FILES['pro_img1']['tmp_name'];
			
			$pro_img2=$_FILES['pro_img2']['name'];
			$pro_img2_tmp=$_FILES['pro_img2']['tmp_name'];
			
			$pro_img3=$_FILES['pro_img3']['name'];
			$pro_img3_tmp=$_FILES['pro_img3']['tmp_name'];
			
			$pro_img4=$_FILES['pro_img4']['name'];
			$pro_img4_tmp=$_FILES['pro_img4']['tmp_name'];
			
			move_uploaded_file($pro_img1_tmp,"../imgs/pro_img/$pro_img1");
			move_uploaded_file($pro_img2_tmp,"../imgs/pro_img/$pro_img2");
			move_uploaded_file($pro_img3_tmp,"../imgs/pro_img/$pro_img3");
			move_uploaded_file($pro_img4_tmp,"../imgs/pro_img/$pro_img4");
			
			$pro_feature1=$_POST['pro_Feature1'];
			$pro_feature2=$_POST['pro_Feature2'];
			$pro_feature3=$_POST['pro_Feature3'];
			$pro_feature4=$_POST['pro_Feature4'];
			$pro_feature5=$_POST['pro_Feature5'];
			
			$pro_price=$_POST['pro_price'];
			$pro_dis=$_POST['pro_dis'];
			$pro_sell_price=$pro_price - ($pro_price * $pro_dis/100);
			$pro_qty=$_POST['pro_qty'];
			$pro_model=$_POST['pro_model'];
			$pro_warrnaty=$_POST['pro_warranty'];
			$pro_for_whome=$_POST['for_whome'];
			$pro_keyword=$_POST['pro_keyword'];
			
			$add_cat=$con->prepare("insert into products
									(pro_name,cat_id,sub_cat_id,pro_img1,pro_img2,pro_img3,pro_img4,
									pro_feature1,pro_feature2,pro_feature3,pro_feature4,pro_feature5,
									pro_price,pro_dis,pro_dis_price,pro_qty,pro_model,pro_warranty,pro_keyword,pro_added_date,for_whome)
									values
									('$pro_name','$cat_id','$sub_cat_id','$pro_img1','$pro_img2','$pro_img3','$pro_img4',
									'$pro_feature1','$pro_feature2','$pro_feature3','$pro_feature4','$pro_feature5',
									'$pro_price','$pro_dis','$pro_sell_price','$pro_qty','$pro_model','$pro_warrnaty','$pro_keyword',NOW(),'$pro_for_whome')");
			
			if($add_cat->execute()){
				echo "<script>alert('Product Added Successfully !!!');</script>";	
			}
			else{
				echo "<script>alert('Product Not Added Successfully !!!');</script>";	
			}	
		}	
	}
	
	function viewall_cust(){
		include("inc/db.php");
		
		if(isset($_POST['u_search'])){
			$u_query=$_POST['u_query'];
			$fetch_pro=$con->prepare("select * from user where u_name like'%$u_query%' ORDER BY 1 DESC");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();	
		}else{
			$fetch_pro=$con->prepare("select * from user ORDER BY 1 DESC");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();
		}
		$i=1;
		while($row=$fetch_pro->fetch()):
			$u_country=$row['u_country'];
			$u_state=$row['u_state'];
			
			$fetch_cat=$con->prepare("select * from country where c_id='$u_country' ORDER BY country_name");
			$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_cat->execute();
			$row_c=$fetch_cat->fetch();
			
			$get_state=$con->prepare("select * from state where state_id='$u_state'");
			$get_state->setFetchMode(PDO:: FETCH_ASSOC);
			$get_state->execute();
			$row_s=$get_state->fetch();
			
			echo"<tr>
					<td>".$i++."</td>
					<td>".$row['u_name']."</td>
					<td>".$row['u_email']."</td>
					<td>".$row['u_pass']."</td>
					<td>".$row['u_add']."</td>
					<td>".$row['u_pin']."</td>
					<td>".$row['u_dob']."</td>
					<td>".$row['u_phone']."</td>
					<td><img src='../imgs/u_img/".$row['u_img']."' /></td>
					<td>".$row_c['country_name']."</th>
					<td>".$row_s['state_name']."</td>
					<td>".$row['u_reg_date']."</td>
				</tr>";
		endwhile;	
	}
	
	function viewall_cat(){
		include("inc/db.php");
		$fetch_cat=$con->prepare("select * from main_cat");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();
							
		while($row=$fetch_cat->fetch()):
			echo"<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";
		endwhile;	
	}
	
	function viewall_products(){
		include("inc/db.php");
		
		if(isset($_POST['pro_search'])){
			$pro_name=$_POST['pro_query'];
			$fetch_pro=$con->prepare("select * from products where pro_name like'%$pro_name%' or pro_keyword like'%$pro_name%' ORDER BY 1 DESC");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();	
		}else{
			$fetch_pro=$con->prepare("select * from products ORDER BY 1 DESC");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();
		}
		$i=1;
		while($row=$fetch_pro->fetch()):
			echo"<tr>
					<td>".$i++."</td>
					<td><a href='index.php?edit_pro=".$row['pro_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_pro=".$row['pro_id']."'>Delete</a></td>
					<td style='min-width:200px'>".$row['pro_name']."</td>
					<td style='min-width:200px'>
						<img src='../imgs/pro_img/".$row['pro_img1']."' />
						<img src='../imgs/pro_img/".$row['pro_img2']."' />
						<img src='../imgs/pro_img/".$row['pro_img3']."' />
						<img src='../imgs/pro_img/".$row['pro_img4']."' />
					</td>
					<td>".$row['pro_feature1']."</td>
					<td>".$row['pro_feature2']."</td>
					<td>".$row['pro_feature3']."</td>
					<td>".$row['pro_feature4']."</td>
					<td>".$row['pro_feature5']."</td>
					<td>".$row['pro_price']."</td>
					<td>".$row['pro_dis']."%</td>
					<td>".$row['pro_qty']."</td>
					<td>".$row['pro_dis_price']."</th>
					<td>".$row['pro_model']."</td>
					<td>".$row['pro_warranty']."</td>
					<td>".$row['pro_keyword']."</td>
					<td style='min-width:200px'>".$row['pro_added_date']."</td>
				</tr>";
		endwhile;	
	}
	
	function dis_pro(){
		include("inc/db.php");
		
		$fetch_pro=$con->prepare("select * from products where pro_dis_price>1 ORDER BY 1 DESC");
		$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pro->execute();
		$i=1;
		while($row=$fetch_pro->fetch()):
			echo"<tr>
					<td>".$i++."</td>
					<td><a href='index.php?edit_pro=".$row['pro_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_pro=".$row['pro_id']."'>Delete</a></td>
					<td style='min-width:200px'>".$row['pro_name']."</td>
					<td style='min-width:200px'>
						<img src='../imgs/pro_img/".$row['pro_img1']."' />
						<img src='../imgs/pro_img/".$row['pro_img2']."' />
						<img src='../imgs/pro_img/".$row['pro_img3']."' />
						<img src='../imgs/pro_img/".$row['pro_img4']."' />
					</td>
					<td>".$row['pro_feature1']."</td>
					<td>".$row['pro_feature2']."</td>
					<td>".$row['pro_feature3']."</td>
					<td>".$row['pro_feature4']."</td>
					<td>".$row['pro_feature5']."</td>
					<td>".$row['pro_price']."</td>
					<td>".$row['pro_dis']."%</td>
					<td>".$row['pro_qty']."</td>
					<td>".$row['pro_dis_price']."</th>
					<td>".$row['pro_model']."</td>
					<td>".$row['pro_warranty']."</td>
					<td>".$row['pro_keyword']."</td>
					<td style='min-width:200px'>".$row['pro_added_date']."</td>
				</tr>";
		endwhile;	
	}
	
	function wish_pro(){
		include("inc/db.php");
		$wish=$con->prepare("select * from user_wishlist");
		$wish->setFetchMode(PDO:: FETCH_ASSOC);
		$wish->execute();
		while($row_wish=$wish->fetch()):
		$wish_id=$row_wish['pro_id'];
		
		$fetch_pro=$con->prepare("select * from products where pro_id='$wish_id'");
		$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pro->execute();
		$i=1;
		while($row=$fetch_pro->fetch()):
			echo"<tr>
					<td>".$i++."</td>
					<td><a href='index.php?edit_pro=".$row['pro_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_pro=".$row['pro_id']."'>Delete</a></td>
					<td style='min-width:200px'>".$row['pro_name']."</td>
					<td style='min-width:200px'>
						<img src='../imgs/pro_img/".$row['pro_img1']."' />
						<img src='../imgs/pro_img/".$row['pro_img2']."' />
						<img src='../imgs/pro_img/".$row['pro_img3']."' />
						<img src='../imgs/pro_img/".$row['pro_img4']."' />
					</td>
					<td>".$row['pro_feature1']."</td>
					<td>".$row['pro_feature2']."</td>
					<td>".$row['pro_feature3']."</td>
					<td>".$row['pro_feature4']."</td>
					<td>".$row['pro_feature5']."</td>
					<td>".$row['pro_price']."</td>
					<td>".$row['pro_dis']."%</td>
					<td>".$row['pro_qty']."</td>
					<td>".$row['pro_dis_price']."</th>
					<td>".$row['pro_model']."</td>
					<td>".$row['pro_warranty']."</td>
					<td>".$row['pro_keyword']."</td>
					<td style='min-width:200px'>".$row['pro_added_date']."</td>
				</tr>";
		endwhile;
		endwhile;	
	}
	
	function out_stock(){
		include("inc/db.php");
		
		$fetch_pro=$con->prepare("select * from products where pro_qty<1 ORDER BY 1 DESC");
		$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pro->execute();
		$i=1;
		while($row=$fetch_pro->fetch()):
			echo"<tr>
					<td>".$i++."</td>
					<td><a href='index.php?edit_pro=".$row['pro_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_pro=".$row['pro_id']."'>Delete</a></td>
					<td style='min-width:200px'>".$row['pro_name']."</td>
					<td style='min-width:200px'>
						<img src='../imgs/pro_img/".$row['pro_img1']."' />
						<img src='../imgs/pro_img/".$row['pro_img2']."' />
						<img src='../imgs/pro_img/".$row['pro_img3']."' />
						<img src='../imgs/pro_img/".$row['pro_img4']."' />
					</td>
					<td>".$row['pro_feature1']."</td>
					<td>".$row['pro_feature2']."</td>
					<td>".$row['pro_feature3']."</td>
					<td>".$row['pro_feature4']."</td>
					<td>".$row['pro_feature5']."</td>
					<td>".$row['pro_price']."</td>
					<td>".$row['pro_dis']."%</td>
					<td>".$row['pro_qty']."</td>
					<td>".$row['pro_dis_price']."</th>
					<td>".$row['pro_model']."</td>
					<td>".$row['pro_warranty']."</td>
					<td>".$row['pro_keyword']."</td>
					<td style='min-width:200px'>".$row['pro_added_date']."</td>
				</tr>";
		endwhile;	
	}
	
	function viewall_order(){
		include("inc/db.php");
		
		if(isset($_POST['ord_search'])){
			$trx=$_POST['trx'];
			$fetch_pay=$con->prepare("select * from payment where status='Complete' AND trx_id like'%$trx%' ORDER BY 1 DESC");
			$fetch_pay->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pay->execute();	
		}else{
			$fetch_pay=$con->prepare("select * from payment where status='Complete' ORDER BY 1 DESC");
			$fetch_pay->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pay->execute();
		}
		$i=1;
		while($row=$fetch_pay->fetch()):
			$pro_id=$row['pro_id'];
			$u_id=$row['u_id'];
			$qty=$row['qty'];
			$amt=$row['amt'];
			
			$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
			$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$get_pro->execute();
			$row_pro=$get_pro->fetch();
			$pro_name=$row_pro['pro_name'];
			$pro_img=$row_pro['pro_img1'];
			
			$get_user=$con->prepare("select * from user where u_id='$u_id'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user=$get_user->fetch();
			$u_email=$row_user['u_email'];
			
			echo"<tr>
					<td>".$i++."</td>
					<td style='min-width:200px'>$u_email</td>
					<td>
						<img style='width:40px; height:40px;' src='../imgs/pro_img/$pro_img' />
					</td>
					<td>$pro_name</td>
					<td>$qty</td>
					<td>".$row['trx_id']."</td>
					<td>$amt</td>
					<td>".$row['pay_date']."</td>
					<td><a href='invoice.php?gen=".$row['pay_id']."' target='_blank'>Genrate Bill</a></td>
				</tr>";
		endwhile;	
	}
	
	function pending_order(){
		include("inc/db.php");
		
		$fetch_pay=$con->prepare("select * from payment where status='Pending' ORDER BY 1 DESC");
		$fetch_pay->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pay->execute();
		$i=1;
		while($row=$fetch_pay->fetch()):
			$pro_id=$row['pro_id'];
			$u_id=$row['u_id'];
			$qty=$row['qty'];
			$amt=$row['amt'];
			
			$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
			$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$get_pro->execute();
			$row_pro=$get_pro->fetch();
			$pro_name=$row_pro['pro_name'];
			$pro_img=$row_pro['pro_img1'];
			
			$get_user=$con->prepare("select * from user where u_id='$u_id'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user=$get_user->fetch();
			$u_email=$row_user['u_email'];
			
			echo"<tr>
					<td>".$i++."</td>
					<td style='min-width:200px'>$u_email</td>
					<td>
						<img style='width:40px; height:40px;' src='../imgs/pro_img/$pro_img' />
					</td>
					<td>$pro_name</td>
					<td>$qty</td>
					<td>".$row['trx_id']."</td>
					<td>$amt</td>
					<td>".$row['pay_date']."</td>
					<td><a href='confirm.php?confirm_order=".$row['pay_id']."'>Confirm Order</a></td>
				</tr>";
		endwhile;	
	}
	
	function con_order(){
		include("inc/db.php");
		if(isset($_GET['confirm_order'])){
			$id=$_GET['confirm_order'];
			
			$update=$con->prepare("update payment set status='Complete' where pay_id='$id'");
			if($update->execute()){
				echo"<script>alert('Order Confirm');</script>";
				echo"<script>window.open('index.php?complete_order','_self');</script>";	
			}	
		}	
	}
	
	function cancle_order(){
		include("inc/db.php");
		
		$fetch_pay=$con->prepare("select * from payment where status='Cancle' ORDER BY 1 DESC");
		$fetch_pay->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_pay->execute();
		$i=1;
		while($row=$fetch_pay->fetch()):
			$pro_id=$row['pro_id'];
			$u_id=$row['u_id'];
			$qty=$row['qty'];
			$amt=$row['amt'];
			
			$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
			$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$get_pro->execute();
			$row_pro=$get_pro->fetch();
			$pro_name=$row_pro['pro_name'];
			$pro_img=$row_pro['pro_img1'];
			
			$get_user=$con->prepare("select * from user where u_id='$u_id'");
			$get_user->setFetchMode(PDO:: FETCH_ASSOC);
			$get_user->execute();
			$row_user=$get_user->fetch();
			$u_email=$row_user['u_email'];
			
			echo"<tr>
					<td>".$i++."</td>
					<td style='min-width:200px'>$u_email</td>
					<td>
						<img style='width:40px; height:40px;' src='../imgs/pro_img/$pro_img' />
					</td>
					<td>$pro_name</td>
					<td>$qty</td>
					<td>".$row['trx_id']."</td>
					<td>$amt</td>
					<td>".$row['pay_date']."</td>
				</tr>";
		endwhile;	
	}
	
	function add_country(){
		include("inc/db.php");
		if(isset($_POST['add_country'])){
			$cat_name=$_POST['c_name'];
			$add_cat=$con->prepare("insert into country(country_name)values('$cat_name')");
			
			if($add_cat->execute()){
				echo "<script>alert('Country Added Successfully !!!');</script>";	
				echo "<script>window.open('index.php?country','_self');</script>";
			}
			else{
				echo "<script>alert('Country Not Added Successfully !!!');</script>";	
			}	
		}	
	}
	
	function veiewall_country(){
		include("inc/db.php");
		
		$fetch_cat=$con->prepare("select * from country ORDER BY country_name");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();	
		$i=1;
		while($row=$fetch_cat->fetch()):
			echo "<tr>
					<td>".$i++."</td>
					<td>".$row['country_name']."</td>
					<td><a href='index.php?edit_country=".$row['c_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_country=".$row['c_id']."'>Delete</a></td>
				</tr>";
		endwhile;
	}
	
	function edit_country(){
		include("inc/db.php");
		if(isset($_GET['edit_country'])){
			$cat_id=$_GET['edit_country'];
			
			$fetch_cat_name=$con->prepare("select * from country where c_id='$cat_id'");
			$fetch_cat_name->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_cat_name->execute();
			$row=$fetch_cat_name->fetch();
			echo "<form method='post'>
					<table>
						<tr>
							<td>Update Country Name :</td>
							<td><input type='text' name='up_c_name' value='".$row['country_name']."' /></td>
						</tr>
					</table>
					<center><button name='update_country'>Update country</button></center>
				</form>";
				
				if(isset($_POST['update_country'])){
					$up_cat_name=$_POST['up_c_name'];
					
					$update_cat=$con->prepare("update country set country_name='$up_cat_name' where c_id='$cat_id'");
					
					if($update_cat->execute()){
						echo "<script>alert('Country Updated Successfully');</script>";	
						echo "<script>window.open('index.php?country','_self');</script>";
					}
					
						
				}
		}
			
	}
	
	function delete_country(){
		include("inc/db.php");
			
			$delete_cat_id=$_GET['delete_country'];
			
			$delete_cat=$con->prepare("delete from country where c_id='$delete_cat_id'");
			
			if($delete_cat->execute()){
				echo "<script>alert('Country Deleted Successfully !!!')</script>";	
				echo "<script>window.open('index.php?country','_self');</script>";
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
	
	function add_state(){
		include("inc/db.php");
		if(isset($_POST['add_state'])){
			$cat_id=$_POST['country'];
			$sub_cat_name=$_POST['state_name'];
			
			$add_sub_cat=$con->prepare("insert into state(state_name,c_id)values('$sub_cat_name','$cat_id')");
			
			if($add_sub_cat->execute()){
				echo "<script>alert('State Added Successfully !!!');</script>";	
				echo "<script>window.open('index.php?state','_self');</script>";
			}
			else{
				echo "<script>alert('State Not Added Successfully !!!');</script>";	
			}	
		}	
	}
	
	function veiewall_state(){
		include("inc/db.php");
		
		$fetch_cat=$con->prepare("select * from state ORDER BY state_name");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();	
		$i=1;
		while($row=$fetch_cat->fetch()):
			$country_id=$row['c_id'];
			$get_c=$con->prepare("select * from country where c_id='$country_id'");
			$get_c->setFetchMode(PDO:: FETCH_ASSOC);
			$get_c->execute();
			$row_c=$get_c->fetch();
			echo "<tr>
					<td>".$i++."</td>
					<td>".$row_c['country_name']."</td>
					<td>".$row['state_name']."</td>
					<td><a href='index.php?edit_state=".$row['state_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_state=".$row['state_id']."'>Delete</a></td>
				</tr>";
		endwhile;
	}
	function edit_state(){
		include("inc/db.php");
		if(isset($_GET['edit_state'])){
			$sub_cat_id=$_GET['edit_state'];
			
			$fetch_sub_cat=$con->prepare("select * from state where state_id='$sub_cat_id'");
			$fetch_sub_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_sub_cat->execute();
			$row=$fetch_sub_cat->fetch();
			$cat_id=$row['c_id'];
			
			$fetch_cat=$con->prepare("select * from country where c_id='$cat_id'");
			$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_cat->execute();
			$row_cat=$fetch_cat->fetch();
			echo "<form method='post'>
					<table cellspacing='0'>
						<tr>
							<td>Select Country Name : </td>
							<td>
								<select name='up_country'>
									<option value='".$row_cat['c_id']."'>".$row_cat['country_name']."</option>";
									echo get_country();
								echo"</select>
							</td>
						</tr>
						<tr>
							<td>Update State Name : </td>
							<td><input type='text' name='up_state' value='".$row['state_name']."' /></td>
						</tr>
					</table>
					<center><button name='update_state'>Update State</button></center>
				</form>";
				
			if(isset($_POST['update_state'])){
				$cat_name=$_POST['up_country'];
				$sub_cat_name=$_POST['up_state'];
				
				$update_cat=$con->prepare("update state set state_name='$sub_cat_name',c_id='$cat_name' where state_id='$sub_cat_id'");
				if($update_cat->execute()){
					echo"<script>alert('State Updated Successfully !!!')</script>";	
					echo "<script>window.open('index.php?state','_self');</script>";
				}
					
			}	
		}	
	}
	function delete_state(){
		include("inc/db.php");
		$delete_sub_cat_id=$_GET['delete_state'];
		
		$delete_sub_cat=$con->prepare("delete from state where state_id='$delete_sub_cat_id'");
		
		if($delete_sub_cat->execute()){
			echo "<script>alert('State Deleted Successfully !!!')</script>";	
			echo "<script>window.open('index.php?state','_self');</script>";
	
		}	
	}
	function veiewall_category(){
		include("inc/db.php");
		
		$fetch_cat=$con->prepare("select * from main_cat ORDER BY cat_name");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();	
		$i=1;
		while($row=$fetch_cat->fetch()):
			echo "<tr>
					<td>".$i++."</td>
					<td>".$row['cat_name']."</td>
					<td><a href='index.php?edit_cat=".$row['cat_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_cat=".$row['cat_id']."'>Delete</a></td>
				</tr>";
		endwhile;
	}
	
	function veiewall_sub_category(){
		include("inc/db.php");
		
		$fetch_cat=$con->prepare("select * from sub_cat ORDER BY sub_cat_name");
		$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_cat->execute();	
		$i=1;
		while($row=$fetch_cat->fetch()):
			echo "<tr>
					<td>".$i++."</td>
					<td>".$row['sub_cat_name']."</td>
					<td><a href='index.php?edit_sub_cat=".$row['sub_cat_id']."'>Edit</a></td>
					<td><a href='delete_cat.php?delete_sub_cat=".$row['sub_cat_id']."'>Delete</a></td>
				</tr>";
		endwhile;
	}
	
	function viewall_sub_cat(){
		include("inc/db.php");
		$fetch_sub_cat=$con->prepare("select * from sub_cat");
		$fetch_sub_cat->setFetchMode(PDO:: FETCH_ASSOC);
		$fetch_sub_cat->execute();
							
		while($row=$fetch_sub_cat->fetch()):
			echo"<option value='".$row['sub_cat_id']."'>".$row['sub_cat_name']."</option>";
		endwhile;	
	}
	
	function edit_cat(){
		include("inc/db.php");
		if(isset($_GET['edit_cat'])){
			$cat_id=$_GET['edit_cat'];
			
			$fetch_cat_name=$con->prepare("select * from main_cat where cat_id='$cat_id'");
			$fetch_cat_name->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_cat_name->execute();
			$row=$fetch_cat_name->fetch();
			echo "<form method='post'>
					<table cellspacing='0'>
						<tr>
							<td>Update Category Name :</td>
							<td><input type='text' name='up_cat_name' value='".$row['cat_name']."' /></td>
						</tr>
					</table>
					<center><button name='update_cat'>Update Category</button></center>
				</form>";
				
				if(isset($_POST['update_cat'])){
					$up_cat_name=$_POST['up_cat_name'];
					
					$update_cat=$con->prepare("update main_cat set cat_name='$up_cat_name' where cat_id='$cat_id'");
					
					if($update_cat->execute()){
						echo "<script>alert('Category Updated Successfully');</script>";	
						echo "<script>window.open('index.php?viewall_cat','_self');</script>";
					}
					
						
				}
		}
			
	}
	
	function edit_sub_cat(){
		include("inc/db.php");
		if(isset($_GET['edit_sub_cat'])){
			$sub_cat_id=$_GET['edit_sub_cat'];
			
			$fetch_sub_cat=$con->prepare("select * from sub_cat where sub_cat_id='$sub_cat_id'");
			$fetch_sub_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_sub_cat->execute();
			$row=$fetch_sub_cat->fetch();
			$cat_id=$row['cat_id'];
			
			$fetch_cat=$con->prepare("select * from main_cat where cat_id='$cat_id'");
			$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_cat->execute();
			$row_cat=$fetch_cat->fetch();
			echo "<form method='post'>
					<table cellspacing='0'>
						<tr>
							<td>Select Main Category Name : </td>
							<td>
								<select name='main_cat'>
									<option value='".$row_cat['cat_id']."'>".$row_cat['cat_name']."</option>";
									echo viewall_cat();
								echo"</select>
							</td>
						</tr>
						<tr>
							<td>Update Sub Category Name : </td>
							<td><input type='text' name='up_sub_cat' value='".$row['sub_cat_name']."' /></td>
						</tr>
					</table>
					<center><button name='update_sub_cat'>Update Sub Category</button></center>
				</form>";
				
			if(isset($_POST['update_sub_cat'])){
				$cat_name=$_POST['main_cat'];
				$sub_cat_name=$_POST['up_sub_cat'];
				
				$update_cat=$con->prepare("update sub_cat set sub_cat_name='$sub_cat_name',cat_id='$cat_name' where sub_cat_id='$sub_cat_id'");
				if($update_cat->execute()){
					echo"<script>alert('Sub Category Updated Successfully !!!')</script>";	
					echo "<script>window.open('index.php?viewall_sub_cat','_self');</script>";
				}
					
			}	
		}	
	}
	
	function edit_pro(){
		include("inc/db.php");
		
		if(isset($_GET['edit_pro'])){
			$pro_id=$_GET['edit_pro'];
			
			$fetch_pro=$con->prepare("select * from products where pro_id='$pro_id'");
			$fetch_pro->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_pro->execute();
			
			$row=$fetch_pro->fetch();
			$cat_id=$row['cat_id'];
			$sub_cat_id=$row['sub_cat_id'];
			
			$fetch_cat=$con->prepare("select * from main_cat where cat_id='$cat_id'");
			$fetch_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_cat->execute();
			$row_cat=$fetch_cat->fetch();
			$cat_name=$row_cat['cat_name'];
			
			$fetch_sub_cat=$con->prepare("select * from sub_cat where sub_cat_id='$sub_cat_id'");
			$fetch_sub_cat->setFetchMode(PDO:: FETCH_ASSOC);
			$fetch_sub_cat->execute();
			$row_sub_cat=$fetch_sub_cat->fetch();
			$sub_cat_name=$row_sub_cat['sub_cat_name'];
			
			echo "<form method='post' enctype='multipart/form-data'>
					<table cellspacing='0'>
						<tr>
							<td>Update Product Name :</td>
							<td><input type='text' name='pro_name' value='".$row['pro_name']."' /></td>
						</tr>
						<tr>
							<td>Update Category Name :</td>
							<td>
								<select name='cat_name'>
									<option value='".$row['cat_id']."'>".$cat_name."</option>
									"; echo viewall_cat();echo"
								</select>
							</td>
						</tr>
						<tr>
							<td>Update Sub Category Name :</td>
							<td>
								<select name='sub_cat_name'>
									<option value='".$row['cat_id']."'>".$sub_cat_name."</option>
									"; echo viewall_sub_cat(); echo"
								</select>
							</td>
						</tr>
						<tr>
							<td>Update Product Image 1 :</td>
							<td>
								<input type='file' name='pro_img1' />
								<img src='../imgs/pro_img/".$row['pro_img1']."' style='width:60px; height:60px' />
							</td>
						</tr>
						<tr>
							<td>Update Product Image 2 :</td>
							<td>
								<input type='file' name='pro_img2' />
								<img src='../imgs/pro_img/".$row['pro_img2']."' style='width:60px; height:60px' />
							</td>
						</tr>
						<tr>
							<td>Update Product Image 3 :</td>
							<td>
								<input type='file' name='pro_img3' />
								<img src='../imgs/pro_img/".$row['pro_img3']."' style='width:60px; height:60px' />
							</td>
						</tr>
						<tr>
							<td>Update Product Image 4 :</td>
							<td>
								<input type='file' name='pro_img4' />
								<img src='../imgs/pro_img/".$row['pro_img4']."' style='width:60px; height:60px' />
							</td>
						</tr>
						<tr>
							<td>Update Feature1 :</td>
							<td><input type='text' name='pro_Feature1' value='".$row['pro_feature1']."' /></td>
						</tr>
						<tr>
							<td>Update Feature2 :</td>
							<td><input type='text' name='pro_Feature2' value='".$row['pro_feature2']."' /></td>
						</tr>
						<tr>
							<td>Update Feature3 :</td>
							<td><input type='text' name='pro_Feature3' value='".$row['pro_feature3']."' /></td>
						</tr>
						<tr>
							<td>Update Feature4 :</td>
							<td><input type='text' name='pro_Feature4' value='".$row['pro_feature4']."' /></td>
						</tr>
						<tr>
							<td>Update Feature5 :</td>
							<td><input type='text' name='pro_Feature5' value='".$row['pro_feature5']."' /></td>
						</tr>
						<tr>
							<td>Update Price :</td>
							<td><input type='text' name='pro_price' value='".$row['pro_price']."' /></td>
						</tr>
						<tr>
							<td>Update Product Discount :</td>
							<td><input type='text' name='pro_dis' value='".$row['pro_dis']."' /></td>
						</tr>
						<tr>
							<td>Update Product Quantity :</td>
							<td><input type='text' name='pro_qty' value='".$row['pro_qty']."' /></td>
						</tr>
						<tr>
							<td>Update Model No. :</td>
							<td><input type='text' name='pro_model' value='".$row['pro_model']."' /></td>
						</tr>
						<tr>
							<td>Update Warranty :</td>
							<td><input type='text' name='pro_warranty' value='".$row['pro_warranty']."' /></td>
						</tr>
						<tr>
							<td>Update Keyword :</td>
							<td><input type='text' name='pro_keyword' value='".$row['pro_keyword']."' /></td>
						</tr>
					</table>
					<center><button name='up_product'>Update Product</button></center>
				</form>";
				
			if(isset($_POST['up_product'])){
				$pro_name=$_POST['pro_name'];
				$cat_id=$_POST['cat_name'];
				$sub_cat_id=$_POST['sub_cat_name'];
				
				if($_FILES['pro_img1']['tmp_name']==""){}else{
					$pro_img1=$_FILES['pro_img1']['name'];
					$pro_img1_tmp=$_FILES['pro_img1']['tmp_name'];
					move_uploaded_file($pro_img1_tmp,"../imgs/pro_img/$pro_img1");
					$up_img1=$con->prepare("update products set pro_img1='$pro_img1' where pro_id='$pro_id'");
					$up_img1->execute();	
				}
				if($_FILES['pro_img2']['tmp_name']==""){}else{
					$pro_img2=$_FILES['pro_img2']['name'];
					$pro_img2_tmp=$_FILES['pro_img2']['tmp_name'];
					move_uploaded_file($pro_img2_tmp,"../imgs/pro_img/$pro_img2");
					$up_img2=$con->prepare("update products set pro_img2='$pro_img2' where pro_id='$pro_id'");
					$up_img2->execute();	
				}
				if($_FILES['pro_img3']['tmp_name']==""){}else{
					$pro_img3=$_FILES['pro_img3']['name'];
					$pro_img3_tmp=$_FILES['pro_img3']['tmp_name'];
					move_uploaded_file($pro_img3_tmp,"../imgs/pro_img/$pro_img3");
					$up_img3=$con->prepare("update products set pro_img3='$pro_img3' where pro_id='$pro_id'");
					$up_img3->execute();	
				}
				if($_FILES['pro_img4']['tmp_name']==""){}else{
					$pro_img4=$_FILES['pro_img4']['name'];
					$pro_img4_tmp=$_FILES['pro_img4']['tmp_name'];
					move_uploaded_file($pro_img4_tmp,"../imgs/pro_img/$pro_img4");
					$up_img4=$con->prepare("update products set pro_img4='$pro_img4' where pro_id='$pro_id'");
					$up_img4->execute();	
				}
				
				$pro_feature1=$_POST['pro_Feature1'];
				$pro_feature2=$_POST['pro_Feature2'];
				$pro_feature3=$_POST['pro_Feature3'];
				$pro_feature4=$_POST['pro_Feature4'];
				$pro_feature5=$_POST['pro_Feature5'];
				
				$pro_price=$_POST['pro_price'];
				$pro_dis=$_POST['pro_dis'];
				$pro_sell_price=$pro_price - ($pro_price * $pro_dis/100);
				$pro_qty=$_POST['pro_qty'];
				$pro_model=$_POST['pro_model'];
				$pro_warrnaty=$_POST['pro_warranty'];
				$pro_keyword=$_POST['pro_keyword'];
				
				$up_pro=$con->prepare("update products set pro_name='$pro_name',cat_id='$cat_id',
										sub_cat_id='$sub_cat_id',pro_feature1='$pro_feature1', 
										pro_feature2='$pro_feature2',pro_feature3='$pro_feature3',pro_feature4='$pro_feature4',
										pro_feature5='$pro_feature5',pro_price='$pro_price',pro_dis='$pro_dis',pro_dis_price='$pro_sell_price',pro_qty='$pro_qty',pro_model='$pro_model', 
										pro_warranty='$pro_warrnaty',pro_keyword='$pro_keyword' where pro_id='$pro_id'");
				
				if($up_pro->execute()){
					echo"<script>alert('Product Updated Successfully !!!');</script>";	
					echo"<script>window.open('index.php?viewall_products','_self');</script>";
				}	
			}	
		}	
	}
	
	function delete_cat(){
		include("inc/db.php");
			
			$delete_cat_id=$_GET['delete_cat'];
			
			$delete_cat=$con->prepare("delete from main_cat where cat_id='$delete_cat_id'");
			
			if($delete_cat->execute()){
				echo "<script>alert('Category Deleted Successfully !!!')</script>";	
				echo "<script>window.open('index.php?viewall_cat','_self');</script>";
			}	
	}
	
	function delete_sub_cat(){
		include("inc/db.php");
		$delete_sub_cat_id=$_GET['delete_sub_cat'];
		
		$delete_sub_cat=$con->prepare("delete from sub_cat where sub_cat_id='$delete_sub_cat_id'");
		
		if($delete_sub_cat->execute()){
			echo "<script>alert('Sub Category Deleted Successfully !!!')</script>";	
			echo "<script>window.open('index.php?viewall_sub_cat','_self');</script>";
	
		}	
	}
	
	function delete_product(){
		include("inc/db.php");
		
		$delete_product_id=$_GET['delete_pro'];
		
		$delete_pro=$con->prepare("delete from products where pro_id='$delete_product_id'");
		
		if($delete_pro->execute()){
			echo "<script>alert('Product Deleted Successfully !!!')</script>";	
			echo "<script>window.open('index.php?viewall_products','_self');</script>";
	
		}	
	}
?>