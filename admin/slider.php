<?php 
	include("inc/function.php");
	include("inc/db.php");
	$get_img=$con->prepare("select * from slider");
	$get_img->setFetchMode(PDO:: FETCH_ASSOC);
	$get_img->execute();
	$row_img=$get_img->fetch();	
?>
<div id="bodyright">
	<h3>Edit Image Slider From Here</h3>
	<form method="post" enctype="multipart/form-data">
    	<table>
            <tr>
            	<td>Select Slider Image 1 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img1']; ?>' /><input type="file" name="pro_img1" /></td>
            </tr>
            <tr>
            	<td>Select Slider Image 2 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img2']; ?>' /><input type="file" name="pro_img2" /></td>
            </tr>
            <tr>
            	<td>Select Slider Image 3 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img3']; ?>' /><input type="file" name="pro_img3" /></td>
            </tr>
            <tr>
            	<td>Select Slider Image 4 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img4']; ?>' /><input type="file" name="pro_img4" /></td>
            </tr>
            <tr>
                <td>Select Slider Image 5 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img5']; ?>' /><input type="file" name="pro_img5" /></td>
            </tr>
            <tr>
                <td>Select Slider Image 6 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img6']; ?>' /><input type="file" name="pro_img6" /></td>
            </tr>
            <tr>
                <td>Select Slider Image 7 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img7']; ?>' /><input type="file" name="pro_img7" /></td>
            </tr>
            <tr>
                <td>Select Slider Image 8 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img8']; ?>' /><input type="file" name="pro_img8" /></td>
            </tr>
            <tr>
                <td>Select Slider Image 9 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img9']; ?>' /><input type="file" name="pro_img9" /></td>
            </tr>
            <tr>
                <td>Select Slider Image 10 :</td>
                <td><img style='width:60px; height:60px' src='../imgs/slider/<?php echo $row_img['s_img10']; ?>' /><input type="file" name="pro_img10" /></td>
            </tr>
        </table>
        <center><button name="up_slider">Update Slider</button></center>
    </form>
</div>

<?php echo up_slider(); ?>