<div id="bodyright">
	<h3>View All Country</h3>
    <form method="post" enctype="multipart/form-data">
    	<table cellspacing="0">
        	<tr>
            	<th>Sr No.</th>
				<th>Country Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
			<?php include("inc/function.php"); echo veiewall_country(); ?>
        </table>
    </form>
	<h3 id="add_cat">Add New Country From Here</h3>
	<form method="post">
    	<table cellspacing="0">
        	<tr>
            	<td>Enter Country Name :</td>
                <td><input type="text" name="c_name" /></td>
            </tr>
        </table>
        <center><button name="add_country">Add Country</button></center>
    </form>
</div>

<?php echo add_country(); ?>