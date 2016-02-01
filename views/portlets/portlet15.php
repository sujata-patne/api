<!-- Internal Wallpaper more page -->
<?php
    // Portlet Config :
    $CURRENT_PORTLETID = 15;
    $PORTLET_RESOLUTION = '';
    $THUMBNAIL_LIMIT = 10;
    $THUMBURL = "http://d85mhbly9q6nd.cloudfront.net/";
    $EACHPAGE = 6; //IN each page how many content will be displayed.
?>

<div style="height: 30px;
    background: #ccc;
     padding-top: 6px;">
    <h5 style="margin-top: 7px;">Bestseller</h5>
</div>

<table width="70%" style="margin-top:20px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
<?php $i = 0;
     $startFrom = 0 * $EACHPAGE;
    if(isset($_GET['startFrom'])){
         $startFrom = $_GET['startFrom'] * $EACHPAGE;
    }
    $allWallpapers = $storeObj->contentPagination($storeObj->getPortletWallpapers($CURRENT_PORTLETID),$startFrom,$EACHPAGE);
    $allVideos= $storeObj->contentPagination($storeObj->getPortletVideos($CURRENT_PORTLETID),$startFrom,$EACHPAGE);
     if($startFrom == 0){
        $startFrom = 1; //For next iteration
    }
    if(!empty($allWallpapers)){
        foreach ( $allWallpapers as $key => $value ) {
            if (++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
            if ($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED') { ?>
                <td align="center">
                    <a href="../<?= $SUBPARAM . $pricepoint ?>&f=home&t=<?= $value->contentTypeMD5 ?>&n=<?= base64_encode($storeObj->getDifferentFileNames($value->cf_url, "Wallpaper", $PORTLET_RESOLUTION)) ?>&m=<?= $value->cf_cm_id ?>&d=<?= $value->cd_id ?>&i=<?= $value->cf_template_id ?>">
                        <img src="<?= $THUMBURL ?><?= $value->cf_cm_id ?>_thumb_125_125.jpg" width="125" height="125"
                             alt=""/></a>
                    <br/>
                </td>
            <?php } else { ?>
                <?php echo substr($value->cm_title, 0, 25);
                    echo (strlen($value->cm_title) > 25)? "...":"";
                    echo "<br/>";
                ?>
                <td align="center" style="padding:0 8px 4px 0;">
                    <a href="<?= $DOWNLOADPATH ?>?&t=<?= $value->contentTypeMD5 ?>&n=<?= $storeObj->getDifferentFileNames($value->cf_url, "Wallpaper", $PORTLET_RESOLUTION) ?>&m=<?= $value->cf_cm_id ?>&d=<?= $value->cd_id ?>&i=<?= $value->cf_template_id ?>">
                        <img src="<?= $THUMBURL ?><?= $value->cf_cm_id ?>_thumb_125_125.jpg" width="125" height="125"
                             alt=""/></a>
                    <br/>
                </td>
            <?php }
            echo "</tr>";
        }
    }
    if(!empty($allVideos)) {
        foreach ($allVideos as $key => $value) {
            if (++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
            if ($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED') { ?>
                <td align="center">
                    <a href="../<?= $SUBPARAM . $pricepoint ?>&f=home&t=<?= $value->contentTypeMD5 ?>&n=<?= base64_encode($storeObj->getDifferentFileNames($value->cf_url, "Video", $PORTLET_RESOLUTION)) ?>&m=<?= $value->cf_cm_id ?>&d=<?= $value->cd_id ?>&i=<?= $value->cf_template_id ?>">
                        <img src="<?= $THUMBURL ?><?= $value->cf_cm_id ?>_thumb_125_125.jpg" width="125" height="125" alt=""/></a>
                    <br/>
                    <?php echo $value->cm_title; ?>
                </td>
            <?php } else { ?>
                <td align="center" style="padding:0 8px 4px 0;">
                    <?php echo substr($value->cm_title, 0, 25);
                        echo (strlen($value->cm_title) > 25)? "...":"";
                        echo "<br/>";  ?>
                    <a title="<?=$value->cm_title?>" href="<?= $DOWNLOADPATH ?>?&t=<?= $value->contentTypeMD5 ?>&n=<?= $storeObj->getDifferentFileNames($value->cf_url, "Video", $PORTLET_RESOLUTION) ?>&m=<?= $value->cf_cm_id ?>&d=<?= $value->cd_id ?>&i=<?= $value->cf_template_id ?>">
                        <img src="<?= $THUMBURL ?><?= $value->cf_cm_id ?>_thumb_125_125.jpg" width="125" height="125" alt=""/></a>
                    <br/>
                    <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,"Video",'high')?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=360">High</a>
                    <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,"Video",'medium')?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=240">Medium</a>
                    <br/>
                </td>
            <?php }
            echo "</tr>";
        }
    }?>
    </tr>
    <tr >
        <td height="30" colspan="3" align="right">
        <?php if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
            $isMoreContent= $storeObj->isMore($storeObj->getPortletVideos($CURRENT_PORTLETID),$_GET['startFrom']+1,$EACHPAGE);
            if($isMoreContent) { ?>
                <a href="../<?=$SUBPARAM.$pricepoint?>&f=home" style="text-decoration:none;">More >></a>
    <?php   }
        }else{                     //For hiding more link :
             $isMoreContent= $storeObj->isMore($storeObj->getPortletVideos($CURRENT_PORTLETID),$_GET['startFrom']+1,$EACHPAGE);
             if($_GET['startFrom'] > 0){ ?>
                <a href="?pg=bestsellerall.php&startFrom=<?=$_GET['startFrom']-1?>" style="text-decoration:none;"> << Back </a>
          <?php   }
             if($isMoreContent) { ?>
                <a href="?pg=bestsellerall.php&startFrom=<?=$_GET['startFrom']+1?>" style="text-decoration:none;">More >></a>
        <?php }
        } ?>
        </td>
    </tr>
</table>

<?php
    include_once 'footer.php';
?>