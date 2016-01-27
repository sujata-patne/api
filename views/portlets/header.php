<!-- HEADER -->
<?php
 
	if($USERSTATUS != 'NEWUSER' && $USERSTATUS != 'UNKNOWN' && $USERSTATUS != 'UNSUBSCRIBED' ){
		$search_width = 25;
	}else{
		$search_width = 33.3;
	}
?>
<div>
	<ul style=" list-style-type: none;
	            margin: 0;
	            padding: 0;
	            overflow: hidden;">
	    <li  style="float: left;background: #5d3b6e; width:<?=$search_width?>%; height:30px; padding-top: 6px;" align="center"><a href="index.php?pg=home.php" style="text-decoration:none; color:#fff;">Home</a></li>
	    <li  style="float: left;background: #5d3b6e;width: <?=$search_width?>%;height:30px; padding-top: 6px;" align="center"><a  href="index.php?pg=video.php" style="text-decoration:none; color:#fff;">Videos</a></li>
	    <li  style="float: left;background: #5d3b6e;width: <?=$search_width?>%;height:30px; padding-top: 6px;" align="center"><a href="index.php?pg=photos.php" style="text-decoration:none; color:#fff;">Photos</a></li>
		<?php 
			if($USERSTATUS != 'NEWUSER' && $USERSTATUS != 'UNKNOWN' && $USERSTATUS != 'UNSUBSCRIBED' ){
		?>
		<li style="float: left;background: #5d3b6e;width: <?=$search_width?>%;height:30px; padding-top: 6px;" align="center">
			 <a href="?pg=home.php&search=true">
				<img src="../assets/img/search-icon.png" alt="search" />
			 </a>
		</li>
		<?php
				if(isset($_GET['search']) && $_GET['search'] == true){
		?>
				<br/> 
				<br/>
				<center><form method="get" action="search.php" style="padding-top:5px;">
					<input type="hidden" name="pg" value="home.php"/>
					<input type="hidden" name="search" value="true"/>
					<input type="text" name="search_txt" />
					<input type="submit" value="SEARCH" />
				</form></center>
		<?php
				}

			 }
		?>
	</ul>
</div>
