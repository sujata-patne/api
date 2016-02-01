<?php
	use Store\Curl as Curl;
	use Store\Logger as Logger;

	class Store {

		public function __construct(){

			include_once '../config.php';

			$this->userStatus = $userStatus;
			$this->storeId = $storeID;
			$this->promoId = $promo;
			$this->linkUrl = $linkUrl;
			$this->subParam = $subParam;
			$this->curlObj = new Curl\Curl();
			$this->logger = new Logger\Logger();

			// $dbCMS = new Db($config['Db']['icon_cms']['User'], $config['Db']['icon_cms']['Password'],$config['Db']['icon_cms']['Name']);
			// $this->dbCon = $dbCMS->getConnection();
		}
		public function setStoreConfigs($pageName,$storeId){
			$this->pageName = $pageName;
			$this->storeId = $storeId;
			
		}

		public function getPortletContent(){

			$url = "http://192.168.1.159:9875/v3/page/getPageDetails";
			$data = array(
					"pageName" => $this->pageName,
					"storeId" => $this->storeId,
					"deviceHeight" => 200,
					"deviceWidth" => 200
				 );
			$data = json_encode($data);
			$result_portletContent = $this->curlObj->executePostCurl($url,$data);
			$this->logger->logCurlAPI($result_portletContent['Info']);

			$portlet = Array();
			$portlet['portletData'] = json_decode($result_portletContent['Content'])->message->potletMapDetails;
			$portlet['portletContent'] = json_decode($result_portletContent['Content'])->message->portletDetails;
			$this->portletArray = $portlet;

			return $portlet;
		}


		public function getPortletWallpapers($portletId){
			$arr = Array();
			foreach ($this->portletArray['portletContent'] as $key => $value) {
				foreach ($value->packageDetails as $packageDetail ) {
					//array_push(cgImages, $packageDetail->cg_images);
					if($packageDetail->cd_name == 'Wallpaper' && $portletId == $packageDetail->portletId ){
						foreach ($this->portletArray['portletData'] as $k => $v) {
							if($portletId == $v->portletId){
								$packageDetail->pricePoint = $v->pricePoint;
								$packageDetail->planId = $v->subscriptionPlan;
							}
						}
						$arr[] = $packageDetail;
					}
				}
			}
			return $arr;
		}

		public function getPortletVideos($portletId){
			$arr = Array();
			foreach ($this->portletArray['portletContent'] as $key => $value) {
				foreach ($value->packageDetails as $packageDetail ) {
					if(($packageDetail->cd_name == 'Video' || $packageDetail->cd_name == 'Video Clip')  && $portletId == $packageDetail->portletId ){
						foreach ($this->portletArray['portletData'] as $k => $v) {
							if($portletId == $v->portletId){
								$packageDetail->pricePoint = $v->pricePoint;
								$packageDetail->planId = $v->subscriptionPlan;
							}
						}
						$arr[] = $packageDetail;
					}
				}
			}
		  return $arr;
		}

		public function getPortletBestseller($portletId){
			$arr = Array();
			$portletArray = $this->getPortletContent();
			foreach ($portletArray['portletContent'] as $key => $value) {
				foreach ($value->packageDetails as $packageDetail ) {
					if(($packageDetail->cd_name == 'Video' || $packageDetail->cd_name == 'Wallpaper' ) && $portletId == $packageDetail->portletId ){
						foreach ($this->portletArray['portletData'] as $k => $v) {
							if($portletId == $v->portletId){
								$packageDetail->pricePoint = $v->pricePoint;
								$packageDetail->planId = $v->subscriptionPlan;
							}
						}
						$arr[] = $value;
					}
				}
			}
			return $arr;
		}
       
		public function getDifferentFileNames($fileUrl,$contentType,$resolution){
			$getAllFiles = explode(',',$fileUrl);
	        $tmpFile = explode('/',$getAllFiles[0]);
	        if($contentType == 'Video' || $contentType == 'Bestsellers' ){
	        	   $getFileName = explode('_',$tmpFile[2]);
			       $fileName = $getFileName[0];
			       switch ($resolution) {
				       	case 'high':
	 							 $high = md5($fileName.'_640x320.mp4');			 
	 							 return $high;      		
	 							 break; 	
	 					case 'low':
	 							 $medium = md5($fileName.'_240x160.mp4');		 
	 							 return $medium;      		
	 							 break; 	
	 					case 'medium':
	 							 $low = md5($fileName.'_640x320.mp4');			 
	 							 return $low;      		
	 							 break;
				       	default:
				       		break;
			       }
	        }
	        if($contentType == 'Wallpaper'){
 	        	$fileName = md5($tmpFile[3]);
	        	return $fileName;
	        }
	     
		}
		public function contentPagination($arr,$startFrom,$eachPage){
			 $allContent = $arr;
			 $allContent = array_slice($allContent,$startFrom,$eachPage);
			 // echo "<pre>";
			 // print_r($allContent);
			 return $allContent;
		}

		public function isMore($arr,$startFrom,$eachPage){
			 $allContent = $arr;
			 $startFrom = $startFrom * $eachPage;
			 $allContent = array_slice($allContent,$startFrom,$eachPage);
			 // echo "<pre>";
			 // print_r($allContent);
			 if(count($allContent) > 0){
			 	return true;
			 }else{
			 	return false;
			 }
		}

	}
?>
