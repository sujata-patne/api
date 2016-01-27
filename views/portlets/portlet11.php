<!-- Internal Wallpaper more page -->
<?php
    //$SUBPARAM = $storeObj->subParam."&packageId=".$packages[$value->portletId];
    // Portlet Config : 
    $CURRENT_PORTLETID = 11;
    $PORTLET_CONTENT_TYPE = 'Wallpaper';
    $PORTLET_RESOLUTION = '';
    $THUMBNAIL_LIMIT = 10;
    $THUMBURL = "http://d85mhbly9q6nd.cloudfront.net/";
    $EACHPAGE = 4; //IN each page how many content will be displayed.
?>

<div style="height: 30px;
    background: #ccc;
     padding-top: 6px;">
    <h5 style="margin-top: 7px;">Photos</h5>
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
    //print_r(count($storeObj->getPortletWallpapers($CURRENT_PORTLETID)));
     //FOR PAGINATION
    $allWallpapers = $storeObj->contentPagination($storeObj->getPortletWallpapers($CURRENT_PORTLETID),$startFrom,$EACHPAGE);
     
     
     if($startFrom == 0){
        $startFrom = 1; //For next iteration
     }
       foreach ( $allWallpapers as $key => $value ) {
        if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
            if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
	          
?>		
        <td align="center">
            <a href="../<?=$SUBPARAM?>&f=home&t=<?=$value->contentTypeMD5?>&n=<?=base64_encode($storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,$PORTLET_RESOLUTION))?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&i=<?=$value->cf_template_id?>">
            	<img src="<?=$THUMBURL?><?=$value->cf_cm_id?>_thumb_125_125.jpg" width="125" height="125" alt="" /></a>
            <br />
        </td>
<?php
      }else{
       
?>

            <td align="center" style="padding:0 8px 4px 0;">
                <a href="<?=$DOWNLOADPATH?>?&t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,$PORTLET_RESOLUTION)?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&i=<?=$value->cf_template_id?>">
                    <img src="<?=$THUMBURL?><?=$value->cf_cm_id?>_thumb_125_125.jpg" width="125" height="125" alt="" /></a>
                    <!-- <img src="http://media02.hongkiat.com/ww-flower-wallpapers/roundflower.jpg" width="125" height="125" alt="" /></a> -->
                <br />
             </td>
<?php
            }
            //For showing only two td in each row.
            if($i%2 == 0){
                         echo "</tr>";
             }
		}
?>
    </tr>
    <tr >
        <td height="30" colspan="3" align="right">
            <?php
                  if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
                    $isMoreContent= $storeObj->isMore($storeObj->getPortletWallpapers($CURRENT_PORTLETID),$_GET['startFrom']+1,$EACHPAGE);

                      //print_r($count);
                    // if($_GET['startFrom'] > 0){
            if($isMoreContent) {             ?>
                <a href="../<?=$SUBPARAM?>&f=home" style="text-decoration:none;">More >></a>
            <?php
                     }
                }else{
                    //For hiding more link :
                 $isMoreContent= $storeObj->isMore($storeObj->getPortletWallpapers($CURRENT_PORTLETID),$_GET['startFrom']+1,$EACHPAGE);
                   //print_r($count);
                 if($_GET['startFrom'] > 0){
            ?>
                 <a href="?pg=photos.php&startFrom=<?=$_GET['startFrom']-1?>" style="text-decoration:none;"> << Back </a>
              <?php   }
                 if($isMoreContent) {
            ?>
                 <a href="?pg=photos.php&startFrom=<?=$_GET['startFrom']+1?>" style="text-decoration:none;">More >></a>
            <?php
                 }
            }
            ?>
        </td>
    </tr>
</table>

<?php
    include_once 'footer.php';
?>