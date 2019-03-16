<div id="bodyright">
	<h3>View All Complete Orders From Here</h3>
    <form id='search' method="post">
    	<input type="text" name="trx" placeholder="Enter Invoice No." />
        <button name='ord_search'>Search</button>
    </form>
    <div class="scroll">
	<form method="post" enctype="multipart/form-data">
    	<table cellspacing="0">
        	<tr>
            	<th>Sr No.</th>
                <th>Customer Email</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Invoice No.</th>
                <th>Price</th>
                <th>Order Date</th>
                <th>Genrate Bill</th>
            </tr>
            <?php include("inc/function.php"); echo viewall_order(); ?>
        </table>
    </form>
    </div>
</div>