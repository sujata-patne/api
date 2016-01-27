<?php
require_once '../config.php';

$title = 'Welcome to Daily Magic';
$siteDescription = '';
$siteKeywords = '';
$siteAuthor = '';

$includeCustomCss = null;
$includeCustomJs = null;

//include 'header.php';
if($userStatus == 'NEWUSER' || $userStatus == 'UNKNOWN' || $userStatus == 'UNSUBSCRIBED' ){ 	
	header("Location: ".$linkUrl);
}	

$cgImages = array(
	'http://dailymagic.in/unsubImages/ApexOS_Adrienne_pool.jpg',
	'http://dailymagic.in/unsubImages/GG_Cassie_bikini.jpg',
	'http://dailymagic.in/unsubImages/GG_Kayleigh_lingerie.jpg',
	'http://dailymagic.in/unsubImages/GG_Lindsey_bed.jpg',
	'http://dailymagic.in/unsubImages/Lizzie_wall.jpg'
);

$rand_keys = array_rand($cgImages);
	
$image_url = $cgImages[$rand_keys];

?>
<table width="100%" style="font-family:Arial;font-size:100%" align="center">
	<tr>
		<td align="center">
		<img src="<?=$image_url?>" style="width:100%" alt="" />	
		</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
			<a href="unsubscription.php">Confirm to Unsubscribe</a>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
			<a href="index.php?pg=home.php">Continue to DailyMagic</a>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
<?php
// include 'footer.php';
 ?>