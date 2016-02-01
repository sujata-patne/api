<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', 32767);
ini_set("error_log", $_SERVER['DOCUMENT_ROOT']."logs/php_error.log");

//- turn off compression on the server
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 'Off');

header("access-control-allow-origin: *");

include_once '../config.php';
use Store\Logger as Logger;

use Store\Curl as Curl;
$curlObj = new Curl\Curl();
$logger = new Logger\Logger();

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
	$cd_details = $curlObj->executePostCurl($url,$data);
	$logger->logCurlAPI($cd_details['Info']);

	$cd_name = $cd_details['Content'];
	$cd_name = json_decode($cd_name);

	$cd_name = $cd_name->message->catalogueDetail->cd_name;

	//Cloudfront Download Link Start		// Configure the private key
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

	$signed_url = $config->create_signed_url($asset_path, $private_key_filename, $key_pair_id, $expires);

	$cd_data = array(
		"cd_cmd_id" => $content_metadata_id,
		"cd_msisdn" => $msisdn,
		"cd_user_id" => $userId,
		"cd_app_id" => 2,
		"cd_cd_id" => $catalogue_detail_id,
		"cd_download_count" => 1,
		"cd_download_date" => date('Y-m-d H:i:s')
	);

	$insert_data = json_encode($cd_data);

	$insertURL = "http://192.168.1.159:9875/v3/contentDownloadHistory/insertDownloadInfo";
	$insert_meta = $curlObj->executePostCurl($insertURL,$insert_data);
	$result = json_decode($updated_meta['Content'])->message->contentHistoryDetails;


	header("Location: ".$signed_url);
	exit();
/******************************************************************************************************************

	$url = "http://192.168.1.159:9875/v3/contentDownloadHistory/checkDownloadInfo";
	//$url = "http://localhost/apiICON/v3/contentDownloadHistory/checkDownloadInfo";

	$cd_data = json_encode($cd_data);

	$meta = $curlObj->executePostCurl($url,$cd_data);
	$logger->logCurlAPI($result['Info']);

	$checkDownloadInfo = json_decode($meta['Content'])->message->contentHistoryDetails;
	 $noDataExist = json_decode($meta['Content'])->message->msgs;

	if( !empty($noDataExist) and count($checkDownloadInfo) > 0 ){

		$downloadCount = $checkDownloadInfo[0]->cd_download_count + 1;
		$cd_data = json_decode($cd_data);
		$cd_data->cd_download_count = $downloadCount;
		$cd_data->cd_download_date = date('Y-m-d H:i:s');
		$updateURL = "http://192.168.1.159:9875/v3/contentDownloadHistory/updateDownloadInfo";
		$update_data = json_encode($cd_data);
		$updated_meta = $curlObj->executePostCurl($updateURL,$update_data);
		$logger->logCurlAPI($updated_meta['Info']);

		$result = json_decode($updated_meta['Content'])->message->contentHistoryDetails;

	}
	else{
		$cd_data = json_decode($cd_data);
		$cd_data->cd_download_count = 1;
		$cd_data->cd_download_date = date('Y-m-d H:i:s');
		$insert_data = json_encode($cd_data);
		//echo "<pre>"; print_r($insert_data); exit;

		$insertURL = "http://192.168.1.159:9875/v3/contentDownloadHistory/insertDownloadInfo";
		$insert_meta = $curlObj->executePostCurl($insertURL,$insert_data);
		$result = json_decode($updated_meta['Content'])->message->contentHistoryDetails;

	}

	header("Location: ".$signed_url);
	exit();
*************************************************************************************************************************************8/
/*
	http://d12m6hc8l1otei.cloudfront.net/video/1024_640_320_720p.mp4?Expires=1450332494&Signature=GYGRFwmXymoB9omI5pKVvc-E5oaxuXQtx1AIqBzq2L5V65G8ekkXZPRCePNJOiB4XzbO~kOOVkjsW0Yg4vfc~vlph-T1QzWCrgTlDhLD9zWdPy91iaWRR6AOgBjawrUXESxveEHUk0tSvdEOVju1~6ULyYfr3AoFbKZ7LyUmkJtqM2OJLY3hyVAChD2wnQ3ZPyf2pvIVmv3Et~cIRzg9Toeyi92TwpYs6akagygldEF-WnSTMlETNW0EYmcr2It~0~WxD9FVBQVGL5BYX38MN79pkrHq1bNH5If1T2uwMPtBpQ59msReI~7tWU-lEnTPbeZzh-RNFFu8O6rxzulOOA__&Key-Pair-Id=APKAI6KQIZYCKQ2ZFREA
*/
?>