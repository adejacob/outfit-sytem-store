<div id="bodyleft">
	<h3>Content Management</h3>
    
    <ul>
    	<li><a href="index.php">Home</a></li>
        <h3>Category Management</h3>
        <li><a href="index.php?viewall_cat">Viewall Categories</a></li>
        <li><a href="index.php?viewall_sub_cat">Viewall Sub Categories</a></li>
        <h3>Product Management</h3>
        <li><a href="index.php?add_products">Add New Products</a></li>
        <li><a href="index.php?viewall_products">View All Products</a></li>
        <li><a href="index.php?dis_pro">View All Discount Products</a></li>
        <li><a href="index.php?wish">View All WishList Products</a></li>
        <li><a href="index.php?out_stock">View All Out Of Stock Products</a></li>
    	<h3>Order Management</h3>
        <li><a href="index.php?complete_order">View All Complete Orders</a></li>
    	<li><a href="index.php?pending_order">View All Pending Orders</a></li>
    	<li><a href="index.php?cancle_order">View All Cancle Orders</a></li>
        <h3>Other Management</h3>
        <li><a href="index.php?customer">View All Customers</a></li>
        <li><a href="index.php?country">View All Country</a></li>
        <li><a href="index.php?state">View All State</a></li>
        <li><a href="index.php?slider">Edit Image Slider</a></li>
    </ul>        	
</div><!--end of bodyleft-->

<?php
	if(isset($_GET['wish'])){
		include("wish.php");	
	}
	if(isset($_GET['state'])){
		include("state.php");	
	}
	if(isset($_GET['country'])){
		include("country.php");	
	}
	if(isset($_GET['slider'])){
		include("slider.php");	
	}
	if(isset($_GET['customer'])){
		include("customer.php");	
	}
	if(isset($_GET['cancle_order'])){
		include("cancle_order.php");	
	}
	if(isset($_GET['pending_order'])){
		include("pending_order.php");	
	}
	if(isset($_GET['complete_order'])){
		include("complete_order.php");	
	}
	if(isset($_GET['out_stock'])){
		include("out_stock.php");	
	}
	if(isset($_GET['dis_pro'])){
		include("dis_pro.php");	
	}
	if(isset($_GET['viewall_cat'])){
		include("cat.php");	
	}
	if(isset($_GET['viewall_sub_cat'])){
		include("sub_cat.php");	
	}
	if(isset($_GET['viewall_products'])){
		include("viewall_products.php");	
	}
	if(isset($_GET['add_products'])){
		include("add_products.php");	
	}
?>