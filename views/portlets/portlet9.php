<!-- VIDEO INTERNAL PAGE-->
<?php
    //$SUBPARAM = $storeObj->subParam."&packageId=".$packages[$value->portletId];

    // Portlet Config : 
    $CURRENT_PORTLETID = 9;
    $PORTLET_CONTENT_TYPE = 'Video';
    $PORTLET_RESOLUTION = 'low';
    $THUMBNAIL_LIMIT = 10;
    $THUMBURL = "http://d85mhbly9q6nd.cloudfront.net/";
    $EACHPAGE = 4; //IN each page how many content will be displayed.
?>

<div style="height: 30px;
    background: #ccc;
     padding-top: 6px;">
    <h5 style="margin-top: 7px;">Videos</h5>
</div>

<table width="70%" style="margin-top:20px" border="0" align="center" cellpadding="0" cellspacing="0">
	    <tr>
<?php 
	 $i = 0;
     $startFrom = 0 * $EACHPAGE;

     //FOR PAGINATION
     if(isset($_GET['startFrom'])){
         $startFrom = $_GET['startFrom'] * $EACHPAGE;
     }

      //FOR PAGINATION
      $allVideos= $storeObj->contentPagination($storeObj->getPortletVideos($CURRENT_PORTLETID),$startFrom,$EACHPAGE);
     
     
     if($startFrom == 0){
        $startFrom = 1; //For next iteration
     }


	 foreach ($allVideos as $key => $value) {
	 	if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
            if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
?>		
        <td align="center">
            <a href="../<?=$SUBPARAM.$pricepoint?>&f=home&t=<?=$value->contentTypeMD5?>&n=<?=base64_encode($storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,$PORTLET_RESOLUTION))?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>">
            	<img src="<?=$THUMBURL?><?=$value->cf_cm_id?>_thumb_125_125.jpg" width="125" height="125" alt="" /></a>
            <br />
            <?php echo $value->cm_title; ?>
        </td>
<?php
        }else{  //If user is subscribed :  clicking on thumbnail for video will download the same in low res. ?>
         <td align="center">
            <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,$PORTLET_RESOLUTION)?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=176">
                   <img src="<?=$THUMBURL?><?=$value->cf_cm_id?>_thumb_125_125.jpg" width="125" height="125" alt="" /></a>
            <br/>
            <!-- Links for medium and high res -->
            <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,'high')?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=360">High</a>
            <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,'medium')?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=240">Medium</a>
        </td>
        <td> 
             <?php  echo $value->cm_title."<br/>"; ?> 
        </td>
 <?php  }//else
            echo "</tr>";
    }  ?>
    <tr >
        <td height="30" colspan="3" align="right">
            <?php    //For hiding more link :
            $isMoreContent= $storeObj->isMore($storeObj->getPortletVideos($CURRENT_PORTLETID),$_GET['startFrom']+1,$EACHPAGE);
            //TO CHANGE :: PROMO ID
                if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
                    if($isMoreContent) { ?>
                        <a href="../<?= $SUBPARAM.$pricepoint ?>&f=home" style="text-decoration:none;">More >></a>
                <?php  }
                } else{
                    if($_GET['startFrom'] > 0){        ?>
                        <a href="?pg=video.php&startFrom=<?=$_GET['startFrom']-1?>" style="text-decoration:none;"> << Back </a>
              <?php }
                    if($isMoreContent) {          ?>
                        <a href="?pg=video.php&startFrom=<?=$_GET['startFrom']+1?>" style="text-decoration:none;">More >></a>
              <?php }
              } ?>

        </td>
    </tr>
</table>
<?php
    include_once 'footer.php';
?>
