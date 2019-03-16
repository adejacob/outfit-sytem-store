<div id="bodyright">
	<h3>View All Products From Here</h3>
    <form id='search' method="post">
    	<input type="text" name="pro_query" placeholder="Enter Product Name" />
        <button name='pro_search'>Search</button>
    </form>
    <div class="scroll">
	<form method="post" enctype="multipart/form-data">
    	<table cellspacing="0">
        	<tr>
            	<th>Sr No.</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Product Name</th>
                <th>Product Images</th>
                <th>Feature 1</th>
                <th>Feature 2</th>
                <th>Feature 3</th>
                <th>Feature 4</th>
                <th>Feature 5</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Quantity</th>
                <th>Sell Price</th>
                <th>Model No.</th>
                <th>Warranty</th>
                <th>Keyword</th>
                <th>Added Date</th>
            </tr>
            <?php include("inc/function.php"); echo viewall_products(); ?>
        </table>
    </form>
    </div>
</div>