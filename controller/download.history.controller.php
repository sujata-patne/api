<?php
	use Store\Curl as Curl;
use Store\Logger as Logger;

class History {
		public function __construct(){
			
			//include_once "store.controller.php";
			
			//$this->userStatus = $userStatus;
			// $this->userStatus="SUBSCRIBED";
			// $this->promoId = $promo;
			// $this->linkUrl = $linkUrl;
			// $this->subParam = $subParam;
			// $this->userId = $userId;
			// $this->msisdn = $msisdn;
			$this->app_id = 2;

			$this->curlObj = new Curl\Curl();
			$this->logger = new Logger\Logger();


		}

	    public function setStoreConfigs($storeId){
			$this->storeId = $storeId;
		}
		public function setMsisdn($msisdn){
			$this->msisdn = $msisdn;
		}
		public function setUserid($userId){
			$this->userId = $userId;
		}
		public function setUserStatus($userStatus){
			$this->userStatus = $userStatus;
		}
		public function getDownloadHistoryData(){
			if($this->userStatus != 'NEWUSER' and $this->userStatus != 'UNKNOWN' and $this->userStatus != 'UNSUBSCRIBED' ){
               $url = 'http://192.168.1.159:9875/v3/contentDownloadHistory/getContentDownloadHistory';
               $data = json_encode(array(
				"cd_msisdn"  => "918879940283",
				"cd_user_id" =>  "25641",
				"cd_app_id" => $this->app_id
				// "cd_msisdn"  => $this->msisdn,
				// "cd_user_id" => $this->userId,
				// "cd_app_id" => $this->app_id
			    ));
              
               $curlResult = $this->curlObj->executePostCurl($url,$data);
				$this->logger->logCurlAPI($curlResult['Info']);

				$result = json_decode($curlResult['Content'], true);
			   // echo "<pre>";
			   // print_r($result);
			   // exit();
			   if($result['message']['status_code'] == 200){

               $details = $result['message']['contentHistoryDetails'];
			      $Video = $this->getDownloadData($details,array('Video Clip','Video','Movie'));
			     
			     
			      $Photo = $this->getDownloadData($details,array('Wallpaper'));
			      return array(
						"Video"  =>$Video,
						"Wallpaper" =>$Photo
			           );
			    }else{
			    	print_r($result['message']['msgs']);
			    }
			  }	
	        }
	    


		public function getDownloadData($historyResult,$contentTypeArray){
			$history = array();
			foreach ($historyResult as $key => $value) {
				if(in_array($value['cd_name'], $contentTypeArray)){
					$history[] = $value;
				}
			}
 		 return $history;
	}
		
		public function getUserSubscribeInfo(){
               $isSubscribed = false;
               if($this->userStatus != 'NEWUSER' and $this->userStatus != 'UNKNOWN' and $this->userStatus != 'UNSUBSCRIBED' ){
                    $isSubscribed = true;
					$data['user_id'] = $this->userId;
					$data['bgw_AppID'] = '2';

					$serviceUrl = USERPROFILE;
					$result = $this->curlObj->executePostCurl($serviceUrl,$data,0);
				    $this->logger->logCurlAPI($result['Info']);

				   $UserSubscribeInfo = json_decode($result['Content'],true);
					//print_r($UserSubscribeInfo);
				}
				return array(
						"isSubscribed"  => $isSubscribed,
						"UserSubscribeInfo" => $UserSubscribeInfo
			           );
			}
 

		
  	}

?>
