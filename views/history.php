<!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content=" initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,width=device-width" /> 
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Welcome to Daily Magic</title>
 </head>
 <body>

<?php
include_once '../config.php';
//include_once "../../site/lib/functions.php";
include_once "../controller/download.history.controller.php";
$historyObj = new History(); 

$THUMBNAIL_LIMIT = 2;
$STOREID = $storeID;
$historyObj->setStoreConfigs($STOREID);
$USERSTATUS = $historyObj->userStatus;
$PROMOID = $historyObj->promoId;
$LINKURL = $historyObj->linkUrl;
$SUBPARAM= $historyObj->subParam;
$USERINFO = $historyObj->getUserSubscribeInfo();
$FINALRESULT = $historyObj->getDownloadHistoryData();
$historyVideo = $FINALRESULT['Video'];

$historyPhoto = $FINALRESULT['Wallpaper']; 
$THUMBURL = "http://d85mhbly9q6nd.cloudfront.net/";


if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){ 	
	header("Location: ".$LINKURL);
}
?>
	<tr>
		<td><strong>User Download History</strong></td>
	</tr>
	<tr>
		<td height="10" ><br><br>&nbsp;</td>
	</tr>
<?php
if($USERSTATUS != 'NEWUSER' and $USERSTATUS != 'UNKNOWN' and $USERSTATUS != 'UNSUBSCRIBED' ){
	if(!empty($historyVideo)){
	?>
	<tr>
		<td><strong>Videos</strong></td>
	</tr>
	<tr>
		<td align="center">
			<table width="100%">
				<tr>
					<?php
						 $i = 0;
					   
						foreach ( $historyVideo as $key => $value ) {
							
                      	 	 if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
						?>
						<td align="center">
							<img src="<?=$THUMBURL?><?=$value['cm_id']?>_thumb_125_125.jpg" width="125" height="125" alt="" />
							<?php
							if(!empty($value['cm_genre'])){
								echo "<br />".$value['cm_genre']."<br />";
							}  
							?>
						</td>
						<?php
						}
					?>	
      			</tr>    
			</table>
		</td>
	</tr>
	<tr>
		<td height="10" align="center">&nbsp;</td>
	</tr>
	<?php
	}
	if(!empty($historyPhoto)){
	?>
	<tr>
		<td><strong>Photos</strong></td>
	</tr>
	<tr>
		<td align="center">
			<table width="100%">
				<tr>
						<?php
						 $i = 0;
					    
						foreach ( $historyPhoto as $key => $value ) {
							
                        if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
						?>
						<td align="center">
							<img src="<?=$THUMBURL?><?=$value['cm_id']?>_thumb_125_125.jpg" width="125" height="125" alt="" />
						</td>
						<?php
					   }
					?>	
        			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="10" align="center">&nbsp;</td>
	</tr>
	<?php }
	}
	?>