<div id="bodyright">
	<h3>View All Sub Categories</h3>
    <form id='scroll' method="post" enctype="multipart/form-data">
    	<table cellspacing="0">
        	<tr>
            	<th>Sr No.</th>
				<th>Sub Category Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
			<?php include("inc/function.php"); echo veiewall_sub_category(); ?>
        </table>
    </form>
	<h3 id="add_cat">Add New Sub Category From Here</h3>
	<form method="post">
    	<table cellspacing="0">
        	<tr>
            	<td>Select Category Name :</td>
                <td>
                	<select name="main_cat">
                    	<?php echo viewall_cat(); ?>
                    </select>
                </td>
            </tr>
        	<tr>
            	<td>Enter Sub Category Name :</td>
                <td><input type="text" name="sub_cat_name" /></td>
            </tr>
        </table>
        <center><button name="add_sub_cat">Add Sub Category</button></center>
    </form>
</div>

<?php echo add_sub_cat(); ?>