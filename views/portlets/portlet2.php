
<?php 
 // TOP BANNER : 
$cgImages = array(
 // 'http://dailymagic.in/unsubImages/ApexOS_Adrienne_pool.jpg',
 // 'http://dailymagic.in/unsubImages/GG_Cassie_bikini.jpg',
 // 'http://dailymagic.in/unsubImages/GG_Kayleigh_lingerie.jpg',
 // 'http://dailymagic.in/unsubImages/GG_Lindsey_bed.jpg',
 // 'http://dailymagic.in/unsubImages/Lizzie_wall.jpg'
	// 'https://lh6.ggpht.com/SkwnZx2duBQfzregu8_4PnBOnADfYG4VND1J6TfRTDl57a_vn4vOA_ZQqjqEJQ4pm9A_=h900'
	'../assets/img/topbanner.jpg'
);

$rand_keys = array_rand($cgImages);
 
$image_url = $cgImages[$rand_keys];
// Currently showing banner for all cases .. links can be changed later. 
// if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
?>
	<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		 <td id="#content" align="center">
		   <!-- <a href="subscriptionplans.php"> -->
		  <img  style="max-width:100%" src="<?=$image_url?>?<?=$timestamp?>" />
		<!-- </a> -->
		 </td>
		</tr>
	</table>
<?php 
	// } 
?>