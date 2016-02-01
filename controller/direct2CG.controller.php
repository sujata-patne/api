<?php
namespace Store\Direct2CG;
use Store\Logger as Logger;
use Store\Config as Config;

use Store\Curl as Curl;

 class direct2cg{
	 public $curlMethods;
	 public $campaignDetails;
	 private $promo;
	 private $currentPage;
	 private $sesionId;

	 public function __construct($promo,$currentPage, $sesionId){
		$this->promo = $promo;
		$this->currentPage = $currentPage;
		$this->curlMethods = new Curl\Curl();
		$this->user = new Curl\Curl();
		$this->hostName = "http://".$_SERVER['HTTP_HOST'];
		$this->sesionId = $sesionId;
		$this->logger = new Logger\Logger();
	}

	public function logSubscription($logData){
		$this->logger = new Logger\Logger($logData);
		$this->logger->logSubscription();
	}
	public function logBGWBanner($msisdn,$operator, $TransId,$campaignDetails,$fUrl,$retUrl,$price_point,$bannerId){
		$bgwHeader = array();
		$BGWBanner = array();
		$bannerId = 0;
		foreach($_SERVER as $key => $value){
			$bgwHeader[] = $key.':'.$value;
		}
		$bgwHeader[] = 'Operator:'.$operator;
		$bgwHeader[] = 'Z_MSISDN: 91'.$msisdn;
		$BGWBanner['substore'] = 'jet';
		$BGWBanner['bgw_id'] = $TransId;

		$this->campaignDetails = $campaignDetails;
		if( count($campaignDetails) > 0 ){

			if( empty($OprSubParam) ){
				header("Location: ".$fUrl);
				exit();
			}else{

				$logCmode = $OprSubParam['CMODE'];

				if( isset($row['cp_cg_image_path']) and $row['cp_cg_image_path'] != null and $row['cp_cg_image_path'] != '' ){

					$userScreenWidth = isset($_COOKIE['D2C_screen_width'])
						? (intval($_COOKIE['D2C_screen_width']) > 640)
							? '640'
							: $_COOKIE['D2C_screen_width']
						: '640' ;

					if( intval($userScreenWidth) >= 640 ){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
					}elseif( intval($userScreenWidth) < 640 and intval($userScreenWidth) >= 480){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_480'];
					}elseif( intval($userScreenWidth) < 480 and intval($userScreenWidth) >= 360){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_360'];
					}elseif( intval($userScreenWidth) < 360 and intval($userScreenWidth) >= 320){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_320'];
					}elseif( intval($userScreenWidth) < 320 and intval($userScreenWidth) >= 240){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_240'];
					}elseif( intval($userScreenWidth) < 240 and intval($userScreenWidth) >= 176){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_176'];
					}else{
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
					}

					if($image_url == null or $image_url == ''){
						$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
					}

					//$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
				}else{
					$image_url = $OprSubParam['IMAGE'];
				}
			}
		}else{

			if( empty($OprSubParam) ){
						
				header("Location: ".$fUrl);
				exit();
			}else{
				$logCmode = $OprSubParam['CMODE'];
			}
		}

		$BGWBanner['banner_id'] = $bannerId;
		$tplTid = isset($extractParams['transaction_id']) ? $extractParams['transaction_id'] : 0;

		foreach($extractParams as $key => $value){
			if($key != 'c' and $key != 'promo' and $key != 'transaction_id' and $key != 'f'){
				$tplTid .= '&'.$key.'='.$value;
			}else{
				$BGWBanner[$key] = $value;
			}
		}
		$BGWBanner['transaction_id'] = rawurlencode($tplTid);
		$BGWBanner['promo_id'] = $extractParams['promo'];
		$BGWBanner['session_id'] = $sessionId;

		$videofileDetails = random_video();
		$videoFileName = $videofileDetails.'_176x144.3gp';

		//$retUrl .= '?t='.md5('video').'_n='.base64_encode(md5($videoFileName)).'_d=9_m='.$videofileDetails;

		$Token = $sessionId.'-'.$BGWBanner['substore'].'-'.$BGWBanner['promo_id'].'-'.$BGWBanner['banner_id'];

		$campaignContent = $this->curlMethods->executePostCurlHeader(ADD_BG_BANNER,$bgwHeader,$BGWBanner);
		$this->logger->logCurlAPI($campaignContent['Info']);

		$subscribeData = array(
			'bannerId' => $BGWBanner['banner_id'],
			'transactionId' => $TransId,
			'sessionId' => $sessionId,
			'retUrl' => $retUrl,
			'campaignContent' => $campaignContent,
			'promoBannerId' => $BGWBanner['promo_id'],
		);

		$this->logSubscription($subscribeData);

	}
	public function getUrlFromParams(){

		$urlPart = strtok($_SERVER["REQUEST_URI"],'?');
		$urlPart = substr($urlPart,0,strrpos($urlPart,"/"));
		/*if(stripos($this->hostName, "http://") !== false){
			$fUrl = $this->hostName.$urlPart.'/error.php';
 	 	}else{
   			$fUrl = 'http://'.$this->hostName.$urlPart.'/error.php';
   		}*/

		if($this->currentPage == 'home'){
  			$retUrl = $this->hostName.$urlPart."/index.php";
		}elseif($this->currentPage  == 'video'){
			//$retUrl = 'http://dailymagic.in/video.php';
			$retUrl = $this->hostName.$urlPart."/index.php";
		}elseif($this->currentPage  == 'photos'){
			//$retUrl = 'http://dailymagic.in/photos.php';
			$retUrl = $this->hostName.$urlPart."/index.php";
		}elseif($this->currentPage  == 'search'){
			//$retUrl = 'http://dailymagic.in/search.php';
			$retUrl = $this->hostName.$urlPart."/search.php";
		}elseif($this->currentPage  == 'account'){
			//$retUrl = 'http://dailymagic.in/myaccount.php';
			$retUrl = $this->hostName.$urlPart."/myaccount.php";
		}elseif($this->currentPage  == 'bestseller'){
			//$retUrl = 'http://dailymagic.in/bestseller.php';
			$retUrl = $this->hostName.$urlPart."/bestseller.php";
		}else{
			//$retUrl = 'http://dailymagic.in/success.php';
			$retUrl = $this->hostName.$urlPart."/success.php";
		}
		return $retUrl;
    }

    public function getCGImages($deviceInfo){
		if( ctype_digit($this->promo) ){
			$cgImages = array(
				'http://dailymagic.in/cgImage/01/001_320x480_JSS.jpg',
				'http://dailymagic.in/cgImage/81456/81456_320x480.jpg',
				'http://dailymagic.in/cgImage/002/002_320x480_JSS.jpg',
				'http://dailymagic.in/cgImage/111416/111416_320x480.jpg',
				'http://dailymagic.in/cgImage/003/003_320x480_JSS.jpg',
				'http://dailymagic.in/cgImage/126343/126343_320x480.jpg',
				'http://dailymagic.in/cgImage/126353/320x480.jpg',
				'http://dailymagic.in/cgImage/babes9/118965_320x480.jpg'
			);
			$rand_keys = array_rand($cgImages);

			$image_url = $cgImages[$rand_keys];
		}else {
			$url = "http://192.168.1.159:9875/v3/store/getCGImagesByStoreId";
			$data = array(
				"storeId" => Config\Config::BGWAPPID
			);
			$data = json_encode($data);
			$result_storeCGImages = $this->curlMethods->executePostCurl($url, $data);
			$this->logger->logCurlAPI($result_storeCGImages['Info']);

			$storeCGImages = json_decode($result_storeCGImages['Content'])->message->storeCGImages;

			$cgImages = array();
			foreach ($storeCGImages as $key => $value) {
				$filesize = explode('X',$value->pci_image_size);
				$files = explode('/',$value->cg_images);

				$fileName = $this->hostName.'/cgImage/iconCGImages/'.$files[2];
				//$fileName = 'http://114.143.181.228:90/cgImage/iconCGImages/'.$files[2];
				//if($deviceInfo['Width'] < $filesize[0] && $deviceInfo['Height'] < $filesize[1] ){
					array_push($cgImages, $fileName);
				//}
			}
			$rand_keys = array_rand($storeCGImages);
			$image_url = $cgImages[$rand_keys];
		}
		return $image_url;
	}
    public function getCGimages123(){
    	if( ctype_digit($this->promo) ){
			$cgImages = array(
				'http://dailymagic.in/cgImage/01/001_320x480_JSS.jpg',
				'http://dailymagic.in/cgImage/81456/81456_320x480.jpg',
				'http://dailymagic.in/cgImage/002/002_320x480_JSS.jpg',
				'http://dailymagic.in/cgImage/111416/111416_320x480.jpg',
				'http://dailymagic.in/cgImage/003/003_320x480_JSS.jpg',
				'http://dailymagic.in/cgImage/126343/126343_320x480.jpg',
				'http://dailymagic.in/cgImage/126353/320x480.jpg',
				'http://dailymagic.in/cgImage/babes9/118965_320x480.jpg'
			);
			$rand_keys = array_rand($cgImages);
				
			$image_url = $cgImages[$rand_keys];
		}else{
			//$image_url = $hostName.$config['CgImage']['TopBanner'];
			
			$cgImages = array(
				'http://dailymagic.in/cgImage/16-10-2015/cg_1.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_2.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_3.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_4.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_5.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_6.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_7.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_8.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_9.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_10.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_11.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_12.jpg',
				'http://dailymagic.in/cgImage/16-10-2015/cg_15.jpg'
			);
			$rand_keys = array_rand($cgImages);
				
			$image_url = $cgImages[$rand_keys];
		}
		return $image_url;
	}
  //   public function getUserStatus(){
		// return "UNSUBSCRIBED";
		// }

  //   public function getPromo(){
  //      	$this->promo = "";
		// }

	public function random_video($dir = 'video'){
		$files = glob($dir . '/*.*');
		$file = array_rand($files);
		$breakFileName = explode('_', basename($files[$file]));
		return $breakFileName[0];
	    }   



	// public function getNOKUrl($row){
 //        if(stripos($row['cg_cp_nok_url'], "http://") !== false){
	// 					$fUrl = $row['cg_cp_nok_url'];
	// 		}else{
	// 					$fUrl = 'http://'.$row['cg_cp_nok_url'];	
	// 		}

 //          return $fUrl;
 //        }
    public function getImageUrl($row,$OprSubParam){

        if( isset($row['cp_cg_image_path']) and $row['cp_cg_image_path'] != null and $row['cp_cg_image_path'] != '' ){
							
			$userScreenWidth = isset($_COOKIE['D2C_screen_width']) 
			? (intval($_COOKIE['D2C_screen_width']) > 640)
			? '640'
			: $_COOKIE['D2C_screen_width']
			: '640' ;
							
			if( intval($userScreenWidth) >= 640 ){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
			}elseif( intval($userScreenWidth) < 640 and intval($userScreenWidth) >= 480){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_480'];
			}elseif( intval($userScreenWidth) < 480 and intval($userScreenWidth) >= 360){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_360'];
			}elseif( intval($userScreenWidth) < 360 and intval($userScreenWidth) >= 320){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_320'];
			}elseif( intval($userScreenWidth) < 320 and intval($userScreenWidth) >= 240){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_240'];
			}elseif( intval($userScreenWidth) < 240 and intval($userScreenWidth) >= 176){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path_176'];
			}else{
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
			}
								
			if($image_url == null or $image_url == ''){
				$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];
			}
						
							//$image_url = 'http://banner.wakau.in:3030'.$row['cp_cg_image_path'];	
	    }else{						
			$image_url = $OprSubParam['IMAGE'];	
		   }
		return $image_url;
      }
  }

?>