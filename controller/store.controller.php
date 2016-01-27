<?php
	use Store\Curl as Curl;

	class Store {

		public function __construct(){

			include_once '../config.php';
	
			// include_once "../models/store.model.php";	

			$this->userStatus = $userStatus;
			$this->storeId = $storeID;
			$this->promoId = $promo;
			$this->linkUrl = $linkUrl;
			$this->subParam = $subParam;
			$this->curlObj = new Curl\Curl();
			// $dbCMS = new Db($config['Db']['icon_cms']['User'], $config['Db']['icon_cms']['Password'],$config['Db']['icon_cms']['Name']);
			// $this->dbCon = $dbCMS->getConnection();
		}
		public function setStoreConfigs($pageName,$storeId){
			$this->pageName = $pageName;
			$this->storeId = $storeId;
			
		}
		



		public function getPortletContent(){
			
			// $url = "http://localhost:9090/wICONapi/web/api/v1/index.php/pages/pageDetails";
			// $url = "http://localhost:9090/wICONapi/web/api/v2/index.php/page/getPageDetails";
			$url = "http://192.168.1.159:9875/v3/page/getPageDetails";
			//$url = "http://localhost/apiICON/v3/page/getPageDetails";
			$data = array(
					"pageName" => $this->pageName,
					"storeId" => $this->storeId,
					"deviceHeight" => 200,
					"deviceWidth" => 200
				 );
			$data = json_encode($data);
			$result_portletContent = $this->curlObj->executePostCurl($url,$data);
			// print_r(json_decode($result_portletContent['Content'])->message->potletMapDetails);
			// exit;
			// print_r($result_portletContent); exit;
			// $result_packageids = getPackageIdsByPageName($this->dbCon,$this->pageName,$this->storeId);
			// $packageIds = Array();
			$portlet = Array();
			// while( $res = $result_packageids->fetch_assoc()){
			$portlet['portletData'] = json_decode($result_portletContent['Content'])->message->potletMapDetails;
			//echo "<pre>"; print_r($portlet['portletData']);			exit;
			$portlet['portletContent'] = json_decode($result_portletContent['Content'])->message->portletDetails;

			$this->portletArray = $portlet;

			// 	if($res['packageId'] > 0)
			// 		$packageIds[] = $res['packageId'];
			// }
			// $result_portletContent = getPortletContentByPackageId($this->dbCon,$packageIds);
		
			/*while( $res = $result_portletContent->fetch_assoc()){
					$portlet['portletContent'][] = $res;
			}*/

			return $portlet;
		}


		public function getPortletWallpapers($portletId){
			$arr = Array();
			foreach ($this->portletArray['portletContent'] as $key => $value) {
				foreach ($value->packageDetails as $packageDetail ) {
					//array_push(cgImages, $packageDetail->cg_images);
					if($packageDetail->cd_name == 'Wallpaper' && $portletId == $packageDetail->portletId ){
						$arr[] = $packageDetail;
					}
				}
			}
			return $arr;
		}

		// public function getPortletWallpapersBySearchKeywords($portletId){
		// 	$arr = Array();
		// 	foreach ($this->getPortletContent()['portletContent'] as $key => $value) {
		// 			if($value->cd_name == 'Wallpaper' && $portletId == $value->portletId){
		// 				$arr[] = $value;
		// 			}
				
		// 	}
		// 	return $arr;
		// }	


		public function getPortletVideos($portletId){
				$arr = Array();
				// $portletArray = $this->getPortletContent();
				foreach ($this->portletArray['portletContent'] as $key => $value) {
					foreach ($value->packageDetails as $packageDetail ) {
						if(($packageDetail->cd_name == 'Video' || $packageDetail->cd_name == 'Video Clip')  && $portletId == $packageDetail->portletId ){
							$arr[] = $packageDetail;
						}
					}
				}
			  return $arr;
		}


		// public function getPortletVideosBySearchKeywords($portletId){
		// 	$arr = Array();
		// 	foreach ($this->getPortletContent()['portletContent'] as $key => $value) {
		// 			if($value->cd_name == 'Video' && $portletId == $value->portletId){
		// 				$arr[] = $value;
		// 			}
		// 	}
		// 	return $arr;
		// }


		public function getPortletBestseller($portletId){
			// $arr = Array();
			// $portletArray = $this->getPortletContent();
			// foreach ($portletArray['portletContent'] as $key => $value) {
			// 	foreach ($value->packageDetails as $packageDetail ) {
			// 		if($packageDetail->cd_name == 'Wallpaper' && $portletId == $packageDetail->portletId ){
			// 			$arr[] = $packageDetail;
			// 		}
			// 	}
			// }
			// return $arr;
			//---
			$arr = Array();
			$portletArray = $this->getPortletContent();
			foreach ($portletArray['portletContent'] as $key => $value) {
				foreach ($value->packageDetails as $packageDetail ) {
					if(($packageDetail->cd_name == 'Video' || $packageDetail->cd_name == 'Wallpaper' ) && $portletId == $packageDetail->portletId ){
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
				echo $tmpFile[2];
	        	$fileName = md5($tmpFile[2]);
	        	return $fileName;
	        }
	     
		}
		// public function getGenreName($genreId){
		// 	$genreName = getValuefromTable($this->dbCon, 'catalogue_detail', 'cd_id', 22);
		// 	return "GLAMOUR";
		// }
		// public function getUserStatus(){
		
				
		// 	return $this->userStatus;
		// }
		// public function getPromoId(){
		// 	return  'z_'.uniqid();
		// }
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
