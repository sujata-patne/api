<?php
include_once '../config.php';


$title = 'Welcome to Daily Magic';
$siteDescription = '';
$siteKeywords = '';
$siteAuthor = '';

$includeCustomCss = null;
$includeCustomJs = null;
//$RootPath = $_SERVER['DOCUMENT_ROOT'];
if($_GET['responseId'] == '999999'){
	header( "refresh:5; url=index.php" );
}

 //include 'header.php';

$cgImages = array(
	'http://dailymagic.in/unsubImages/ApexOS_Adrienne_pool.jpg',
	'http://dailymagic.in/unsubImages/GG_Cassie_bikini.jpg',
	'http://dailymagic.in/unsubImages/GG_Kayleigh_lingerie.jpg',
	'http://dailymagic.in/unsubImages/GG_Lindsey_bed.jpg',
	'http://dailymagic.in/unsubImages/Lizzie_wall.jpg'
);

$rand_keys = array_rand($cgImages);
	
$image_url = $cgImages[$rand_keys];

//$ErrorLogFile = $RootPath.'/logs/ErrorLog_'.date('d-m-Y').'.log';

// $fs = fopen($ErrorLogFile, 'a') or die("can't open file");
// $datetmp = date('Y-m-d H:i:s');
// fwrite($fs, "\r\n");
// fwrite($fs, 'DATE AND TIME:');
// fwrite($fs, $datetmp);
// fwrite($fs, "\r\n");
// fwrite($fs, 'Msisdn:');
// fwrite($fs, $msisdn);
// fwrite($fs, "\r\n");
// fwrite($fs, 'User Session Id:');
// fwrite($fs, $sessionId);
// fwrite($fs, "\r\n");
// fwrite($fs, 'Error Response Id:');
// fwrite($fs, $_GET['responseId']);
// fwrite($fs, "\r\n");
// fwrite($fs, 'Error Response:');
// fwrite($fs, $_GET['resDesc']);
// fwrite($fs, "\r\n");
// fclose($fs);

?>
<tr>
	<td align="center">
		<img src="<?=$image_url?>?<?=$timestamp?>" width="100%" alt="" />
	</td>
</tr>

<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
		<?php
		if($_GET['responseId'] == '999999'){
		?>
		<p><center>Currently this service is not available on your Operator. Stay connected will get back to you soon.</center></p>
		<?php
		}else{
		?>
		<p><center>[<?=$_GET['responseId']?>] : <?=$_GET['resDesc']?></center></p>
		<?php
		}
		?>
	</td>
</tr>
<?php
//include 'footer.php';
?>