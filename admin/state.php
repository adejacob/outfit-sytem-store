<div id="bodyright">
	<h3>View All State</h3>
    <form method="post" enctype="multipart/form-data">
    	<table cellspacing="0">
        	<tr>
            	<th>Sr No.</th>
                <th>Country Name</th>
				<th>State Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
			<?php include("inc/function.php"); echo veiewall_state(); ?>
        </table>
    </form>
	<h3 id="add_cat">Add New Sub Category From Here</h3>
	<form method="post">
    	<table cellspacing="0">
        	<tr>
            	<td>Select Country Name :</td>
                <td>
                	<select name="country" required>
                    	<option value="">Select Country</option>
                    	<?php echo get_country(); ?>
                    </select>
                </td>
            </tr>
        	<tr>
            	<td>Enter Sub Category Name :</td>
                <td><input type="text" name="state_name" /></td>
            </tr>
        </table>
        <center><button name="add_state">Add State</button></center>
    </form>
</div>

<?php echo add_state(); ?>