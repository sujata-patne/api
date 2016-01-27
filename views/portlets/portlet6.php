<?php 
	//Bottom banner  : 
	$cgImages = array(
		// 'https://lh6.ggpht.com/SkwnZx2duBQfzregu8_4PnBOnADfYG4VND1J6TfRTDl57a_vn4vOA_ZQqjqEJQ4pm9A_=h900'
		'../assets/img/banner.jpg'
	);
	$rand_keys = array_rand($cgImages);
	 
	$image_url = $cgImages[$rand_keys];
	//Showing bottom banner for unsubscribed (with link) and subscribed (without link).
	if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
?>
	<table width="90%"  border="0" style="margin-top:20px" align="center" cellpadding="0" cellspacing="0">
		<tr>
		 <td align="center">
		   <a href="subscriptionplans.php">
		  <img style="max-width:100%" src="<?=$image_url?>?<?=$timestamp?>"  alt=""/></a>
		 </td>
		</tr>
	</table>
<?php 
  }else{
 ?>
	<table width="90%"  border="0" style="margin-top:20px" align="center" cellpadding="0" cellspacing="0">
		<tr>
		 <td align="center">
		   <a href="#">
		  <img style="max-width:100%" src="<?=$image_url?>?<?=$timestamp?>"  alt=""/></a>
		 </td>
		</tr>
	</table>
 <?php
 	 } 
?>