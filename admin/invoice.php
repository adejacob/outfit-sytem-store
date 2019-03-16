<html>
	<head>
    	<title>Admin Panel</title>
        <link rel="stylesheet" href="css/styles.css" />
    </head>
    
    <body style="background:#fff">
    <?php
    	include("inc/db.php");
		$gen=$_GET['gen'];
		
		$get_pay=$con->prepare("select * from payment where pay_id='$gen'");
		$get_pay->setFetchMode(PDO:: FETCH_ASSOC);
		$get_pay->execute();
		$row=$get_pay->fetch();
		
		$pro_id=$row['pro_id'];
		$qty=$row['qty'];
		$trx_id=$row['trx_id'];
		$amt=$row['amt'];
		$u_id=$row['u_id'];
		$pay_date=$row['pay_date'];
		
		$get_user=$con->prepare("select * from user where u_id=$u_id");
		$get_user->setFetchMode(PDo:: FETCH_ASSOC);
		$get_user->execute();
		$row_user=$get_user->fetch();
		
		$get_pro=$con->prepare("select * from products where pro_id='$pro_id'");
		$get_pro->setFetchMode(PDO:: FETCH_ASSOC);
		$get_pro->execute();
		$row_pro=$get_pro->fetch();
		$pro_name=$row_pro['pro_name'];
		$pro_price=$row_pro['pro_dis_price'];
	?>
    	<div id='invoice'>
        	<h3>Royal Collection</h3>
            
            <div id='order'>
            	<h4>Order</h4>
                <p><b>Order ID : <?php echo $trx_id; ?></b></p>
                <p>Order Date : <?php echo $pay_date; ?></p>
                <p>Invoice Date : <?php echo date('d-m-y'); ?></p>
            </div>
            <div id='buyer'>
            	<h4>Buyer</h4>
                <p><b><?php echo $row_user['u_name']; ?></b></p>
                <span>
                	<?php echo $row_user['u_add']; ?>,<br />
                	<?php echo $row_user['u_state']; ?>,
					<?php echo $row_user['u_country']; ?>,  
                    <?php echo $row_user['u_pin'] ?>.
                </span>
            	<p><b>Phone No. : <?php echo $row_user['u_phone'] ?></b></p>
            </div>
            <div id='seller'>
            	<h4>Seller</h4>
                <p><b>Royal Collection</b></p>
                <span>SB-4, Blue Chip Complex, Shevasram Road, Gujarat, Bharuch - 392001.</span>
            	<p><b>Phone No. : 9898989898</b></p>
            </div><br clear="all" />
            <h3>Order Details</h3>
            <table cellspacing="0">
            	<tr>
                	<th style="text-align:left;">Product Name</th>
                    <th style="text-align:left">Product Quantity</th>
                    <th style="text-align:left">Product Price</th>
                    <th style="text-align:left">Sub Total</th>
                </tr>
                <tr>
                	<td><?php echo $pro_name; ?></td>
                    <td><?php echo $qty ?></td>
                    <td><?php echo $pro_price ?> RS.</td>
                    <td><?php echo $amt ?> RS.</td>
                </tr>
                <tr>
                	<td></td>
                    <td></td>
                    <td style="text-align:right !important">Amount Payable : </td>
                    <td><?php echo $amt ?> RS.</td>
                </tr>
            </table>
            <button id='viewall_btn' onClick="window.print()">Print</button>
        </div>
    </body>
</html>