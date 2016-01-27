<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', 32767);
ini_set("error_log", $_SERVER['DOCUMENT_ROOT']."logs/php_error.log");

//- turn off compression on the server
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 'Off');

header("access-control-allow-origin: *");

// include 'site/config.inc.php';
// include '../../site/lib/bootstrap.php';
// include '../../site/lib/Db.php';
include_once '../config.php';

use Store\Curl as Curl;
// $dbCMS = new Db('root', '','icon_cms');
// $dbCon = $dbCMS->getConnection();
$curlObj = new Curl\Curl();



 // print_r($dbCon);
// session_start();
// $_SESSION['downloadAllowed'] = true;
// if (!isset($_SESSION['downloadAllowed'])){
// 	header("Location: index.php");
// 	exit();
// }else{
// 	if($_SESSION['downloadAllowed'] == 'false'){
// 		header("Location: index.php");
// 		exit();
// 	}else{
		$fileType = $_GET['t'];
		$fileName = $_GET['n'];
		$cont_reso_type = isset($_GET['r']) ? $_GET['r'] : '0';
		$catalogue_detail_id = $_GET['d'];
		$content_metadata_id = $_GET['m'];
		// $content_metadata_id = 601;
		$cd_name =  "" ;
		// $content_metadata_id = 2;
				
		$url = "http://192.168.1.159:9875/v3/contentDownloadHistory/getContentMetaData";
		$data = array(
				"cd_cmd_id" => $content_metadata_id
			 );
		$data = json_encode($data);
		$meta = $curlObj->executePostCurl($url,$data);

		$meta = $meta['Content'];
		$meta = json_decode($meta);
		$downloadingUrl = $meta->message->contentMetaDataDetail->cm_downloading_url;
		

		$url = "http://192.168.1.159:9875/v3/contentDownloadHistory/getCatalogueDetail";
		$data = array(
				"cd_cd_id" => $_GET['d']
			 );
		$data = json_encode($data);
		$cd_name = $curlObj->executePostCurl($url,$data);

		$cd_name = $cd_name['Content'];
		$cd_name = json_decode($cd_name);
		
		$cd_name = $cd_name->message->catalogueDetail->cd_name;
		// print_r($cd_name);
		// exit;
	//	}
			
		//Cloudfront Download Link Start
		// Configure the private key
		$private_key_filename = '../lib/pk-APKAI6KQIZYCKQ2ZFREA.pem';
		$key_pair_id = 'APKAI6KQIZYCKQ2ZFREA';
		
		//Configure the URL of the file
		$Domain = 'http://d12m6hc8l1otei.cloudfront.net/';
		if($cd_name == 'Video' || $cd_name == 'Video Clip'){
			if ($cont_reso_type == 176){
				$asset_path  = $downloadingUrl.'.3gp';
			}elseif ($cont_reso_type == 240){
				$asset_path  = $downloadingUrl.'_240p.mp4';
			}else{
				$asset_path  = $downloadingUrl.'_360p.mp4';
			}
		}else{
			if( isset($mobileInfo['Wallpaper_Width']) and !empty($mobileInfo['Wallpaper_Width'])){
				$WallpaperWidth = $mobileInfo['Wallpaper_Width'];
				$WallpaperHeight = $mobileInfo['Wallpaper_Height'];
			}else{
				if( isset($mobileInfo['Resolution_Width']) && $mobileInfo['Resolution_Width'] > 800 ){
					$WallpaperWidth = '720';
					$WallpaperHeight = '1280';
				}else{
					if(isset($mobileInfo['Resolution_Width']) && $mobileInfo['Resolution_Width'] == 800){
						if($mobileInfo['Resolution_Width'] == 800 and $mobileInfo['Resolution_Height'] == 1280){
							$WallpaperWidth = '720';
							$WallpaperHeight = '1280';
						}else{
							$WallpaperWidth = '800';
							$WallpaperHeight = '600';
						}
					}elseif(isset($mobileInfo['Resolution_Width']) && $mobileInfo['Resolution_Width'] < 800 and $mobileInfo['Resolution_Width'] >= 768){
						$WallpaperWidth = '720';
						$WallpaperHeight = '1280';
					}else{
						// $WallpaperWidth = $mobileInfo['Resolution_Width'];
						// $WallpaperHeight = $mobileInfo['Resolution_Height'];
						$WallpaperWidth = 125;
						$WallpaperHeight = 125;
					}
				}
			}
			
			$alldmUrlParams = explode('/', $downloadingUrl);
			$asset_path = $Domain.'wallpapers/'.$_GET['m'].'_'.$WallpaperWidth.'_'.$WallpaperHeight.'.'.$alldmUrlParams[5];
		}
		$expires = time() + (20); // (5 minutes from now in UNIX timestamp)
			
		//create the signed image url for display
		$signed_url = create_signed_url($asset_path, $private_key_filename, $key_pair_id, $expires);   	
			 		
		/* Currently keeping the download insert as queries as the queries belong to site user */
		/*$dbSiteUser = mysqli_connect($config->dbData['siteuser']['host'],$config->dbData['siteuser']['username'], $config->dbData['siteuser']['password'], $config->dbData['siteuser']['name']);
		
		if (!$dbSiteUser) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}*/

		$cd_data = array(
			"cd_cmd_id" => $content_metadata_id,
			"cd_msisdn" => $msisdn,
			"cd_user_id" => $userId,
			"cd_app_id" => 2,
			"cd_cd_id" => $catalogue_detail_id
		);

//	$url = "http://192.168.1.159:9875/v3/contentDownloadHistory/checkDownloadInfo";
	$url = "http://localhost/apiICON/v3/contentDownloadHistory/checkDownloadInfo";

	$cd_data = json_encode($cd_data);
	$meta = $curlObj->executePostCurl($url,$cd_data);

	$checkDownloadInfo = json_decode($meta['Content'])->message->contentHistoryDetails;

		//$queryGetDownloadInfo = "select * from content_download where cd_cmd_id = ".$content_metadata_id." and cd_cd_id = ".$catalogue_detail_id." and cd_user_id = ".$userId." and cd_msisdn = ".$msisdn." and cd_app_id = 2";
		//$checkDownloadInfo = mysqli_query($dbSiteUser, $queryGetDownloadInfo);
	if(count($checkDownloadInfo) > 0 ){

		//$checkDownloadInfo = json_encode($checkDownloadInfo);
		//echo "<pre>"; print_r($checkDownloadInfo[0]); exit;

		$downloadCount = $checkDownloadInfo[0]->cd_download_count + 1;
		$cd_data = json_decode($cd_data);
		$cd_data->cd_download_count = $downloadCount;
		$cd_data->cd_download_date = date('Y-m-d H:i:s');

		//$updateURL = "http://192.168.1.159:9875/v3/contentDownloadHistory/updateDownloadInfo";
		//$updateURL = "http://localhost/apiICON/v3/contentDownloadHistory/updateDownloadInfo";
		$update_data = json_encode($cd_data);
		$updated_meta = $curlObj->executePostCurl($updateURL,$update_data);
 		$result = json_decode($updated_meta['Content'])->message->contentHistoryDetails;

		/*$queryUpdateDownloadInfo = "update content_download set cd_download_count = ".$downloadCount.", cd_download_date = NOW() where
		cd_cmd_id = ".$content_metadata_id." and cd_cd_id = ".$catalogue_detail_id." and cd_user_id = ".$userId." and cd_msisdn = ".$msisdn." and cd_app_id = 2 and cd_id = ".$data['cd_id'];

		$result = mysqli_query($dbSiteUser, $queryUpdateDownloadInfo);*/

	}
	else{
		/*$queryInsertDownloadInfo = sprintf("insert into content_download
		(cd_user_id, cd_msisdn, cd_cmd_id, cd_download_count, cd_cd_id, cd_app_id, cd_download_date) values(%s, %s, %s, 1, %s, 2, NOW())",$userId, $msisdn, $content_metadata_id, $catalogue_detail_id );

		$result = mysqli_query($dbSiteUser, $queryInsertDownloadInfo);*/
		//$insertURL = "http://192.168.1.159:9875/v3/contentDownloadHistory/insertDownloadInfo";
		$cd_data = json_decode($cd_data);
		$cd_data->cd_download_date = date('Y-m-d H:i:s');

		$insertURL = "http://localhost/apiICON/v3/contentDownloadHistory/insertDownloadInfo";
		$insert_data = json_encode($cd_data);
		$insert_meta = $curlObj->executePostCurl($insertURL,$insert_data);
		$result = json_decode($updated_meta['Content'])->message->contentHistoryDetails;

	}
	//mysqli_free_result($result);
	//mysqli_close($dbSiteUser);
	/* 		 print_r($signed_url);		 exit;	*/

	header("Location: ".$signed_url);
	exit();
// 	}	
// }	

			
//Create the cloudfront signed URL
function create_signed_url($asset_path, $private_key_filename, $key_pair_id, $expires){
	// Build the policy.
	$canned_policy = '{"Statement":[{"Resource":"' . $asset_path . '","Condition":{"DateLessThan":{"AWS:EpochTime":'. $expires . '}}}]}';

	/*$canned_policy = '
	{
		"Id": "Policy1440586376040",
		"Version": "2012-10-17",
		"Statement": [
			{
				"Sid": "Stmt1440586363543",
				"Action": [
					"s3:GetObject"
				],
				"Effect": "Allow",
				"Resource": "arn:aws:s3:::direct2consumer/*",
				"Principal": {
					"CanonicalUser": [
						"8a09356196995b1dc7ea047cf369b33d7ecdeb9c0e65fbdebcd3f52d17c2979c6fc14c8e7f7afa5f39d8ed644c677480"
					]
				}
			}
		]
	}'; */
	  
	// Sign the policy.
	$signature = rsa_sha1_sign($canned_policy, $private_key_filename);

	// Make the signature contains only characters that 
	// can be included in a URL.
	$encoded_signature = url_safe_base64_encode($signature);

	// Combine the above into a properly formed URL name
	return $asset_path . '?Expires=' . $expires . '&Signature=' . $encoded_signature . '&Key-Pair-Id=' . $key_pair_id;
}

function rsa_sha1_sign($policy, $private_key_filename){
	$signature = '';

	// Load the private key.
	$fp = fopen($private_key_filename, 'r');
	$private_key = fread($fp, 8192);
	fclose($fp);

	$private_key_id = openssl_get_privatekey($private_key);

	// Compute the signature.
	openssl_sign($policy, $signature, $private_key_id);

	// Free the key from memory.
	openssl_free_key($private_key_id);

	return $signature;
}

function url_safe_base64_encode($value){
	$encoded = base64_encode($value);

	// Replace characters that cannot be included in a URL.
	return str_replace(array('+', '=', '/'), array('-', '_', '~'), $encoded);
}

/*
	http://d12m6hc8l1otei.cloudfront.net/video/1024_640_320_720p.mp4?Expires=1450332494&Signature=GYGRFwmXymoB9omI5pKVvc-E5oaxuXQtx1AIqBzq2L5V65G8ekkXZPRCePNJOiB4XzbO~kOOVkjsW0Yg4vfc~vlph-T1QzWCrgTlDhLD9zWdPy91iaWRR6AOgBjawrUXESxveEHUk0tSvdEOVju1~6ULyYfr3AoFbKZ7LyUmkJtqM2OJLY3hyVAChD2wnQ3ZPyf2pvIVmv3Et~cIRzg9Toeyi92TwpYs6akagygldEF-WnSTMlETNW0EYmcr2It~0~WxD9FVBQVGL5BYX38MN79pkrHq1bNH5If1T2uwMPtBpQ59msReI~7tWU-lEnTPbeZzh-RNFFu8O6rxzulOOA__&Key-Pair-Id=APKAI6KQIZYCKQ2ZFREA
*/
?>