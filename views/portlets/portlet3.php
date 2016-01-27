<!-- VIDEO -->
<?php
  //  echo $SUBPARAM .= "&EventId=".$value->pricePoint;
//echo "<pre>"; print_r(explode('&',$SUBPARAM));
    // Portlet Config :
    $CURRENT_PORTLETID = 3;
    $PORTLET_CONTENT_TYPE = 'Video';
    $PORTLET_RESOLUTION = 'low';
    $THUMBNAIL_LIMIT = 2;
    $THUMBURL = "http://d85mhbly9q6nd.cloudfront.net/";
?>
<?php
//     echo $_GET['search_txt'];
    if( sizeof($storeObj->getPortletVideos($CURRENT_PORTLETID)) > 0 ) {
?>
<div style="height: 30px;
    background: #ccc;
     padding-top: 6px;">
    <h5 style="margin-top: 7px;">Videos</h5>
</div>
<?php
      }
 ?>
<table width="90%" style="margin-top:20px" border="0" align="center" cellpadding="0" cellspacing="0">
	    <tr>
<?php 
	 $i = 0;
	 foreach ($storeObj->getPortletVideos($CURRENT_PORTLETID) as $key => $value) {
         //echo "<pre>"; print_r($value); exit;
        //$user->setPricePoint($value->);
	 	if(++$i > $THUMBNAIL_LIMIT) break; //For restricting thumbnails.
            if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){
?>		
        <td align="center">
            <a href="../<?=$SUBPARAM?>&f=home&t=<?=$value->contentTypeMD5?>&n=<?=base64_encode(1)?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>">
            	<img src="<?=$THUMBURL?><?=$value->cf_cm_id?>_thumb_125_125.jpg" width="125" height="125" alt="" /></a>
            <br />
            <?php
                // echo $value->genre; 
            ?>
        </td>
<?php
        }else{
            //If user is subscribed :  clicking on thumbnail for video will download the same in low res.
?>
    
         <td align="center">
            <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,$PORTLET_RESOLUTION)?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=176">
                   <img src="<?=$THUMBURL?><?=$value->cf_cm_id?>_thumb_125_125.jpg" width="125" height="125" alt="" /></a>
            <br/>
            <?php 

            // echo $value->genre."<br/>"; 

            ?>
            <!-- Links for medium and high res -->
           
            <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,'high')?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=360">High</a>
            <a href="<?=$DOWNLOADPATH?>?t=<?=$value->contentTypeMD5?>&n=<?=$storeObj->getDifferentFileNames($value->cf_url,$PORTLET_CONTENT_TYPE,'medium')?>&m=<?=$value->cf_cm_id?>&d=<?=$value->cd_id?>&r=240">Medium</a>
        </td>
 <?php
            }//else
		} // foreach
?>
    </tr>
    <tr>
        <td height="30" colspan="3" align="right">
            <?php 
            //TO CHANGE :: PROMO ID     

                  if($USERSTATUS == 'NEWUSER' || $USERSTATUS == 'UNKNOWN' || $USERSTATUS == 'UNSUBSCRIBED' ){                  
                        if(count($storeObj->getPortletVideos($CURRENT_PORTLETID))>$THUMBNAIL_LIMIT) {
                            
            ?>
                    
                        <a href="../<?=$SUBPARAM?>&f=home" style="text-decoration:none;">More >></a>
            <?php
                        }
                    }else{ 
                        
                        if(count($storeObj->getPortletVideos($CURRENT_PORTLETID))>$THUMBNAIL_LIMIT) {
            ?>
                 <a href="?pg=video.php" style="text-decoration:none;">More >></a>
            <?php

                    }
                }
            ?>

        </td>
    </tr>
</table>

