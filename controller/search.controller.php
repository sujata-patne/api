<?php
	use Store\Curl as Curl;
	class Search {
		public function __construct(){
			/* Bootstrap.php includes config and db.php  */

			include_once '../config.php';
			//include_once "../../site/lib/functions.php";
			
			$this->storeId = $storeID;
			$this->userStatus = $userStatus;
			// $this->userStatus = "SUBSCRIBED";
			$this->promoId = $promo;
			$this->linkUrl = $linkUrl;
			$this->subParam = $subParam;

			$this->curlObj = new Curl\Curl();


		}

	    public function setStoreConfigs($storeId){
			$this->storeId = $storeId;
		}
		
		public function getSearchContent($searchKeyword){
			// $url = 'http://192.168.1.159:9875/v2/search';
			$url = 'http://192.168.1.159:9875/v3/page/searchPageContents';
			// $data = json_encode(array(
			// 	"storeId" => $this->storeId,
			// 	"keyword" => $searchKeyword
			// ));
			$data = json_encode(array(
				"storeId" => $this->storeId,
				"searchKey" => $searchKeyword
			));
			// print_r($data);

			// $ch = curl_init(); 
			// curl_setopt($ch, CURLOPT_URL, $url);								
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
			// curl_setopt($ch, CURLOPT_POST, count($data));
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	

			// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			// 	'Content-Type: application/json'
			// ));

			// $content = curl_exec ($ch);  
			// curl_close ($ch);
			$result = $this->curlObj->executePostCurl($url,$data); 

					// print_r();
			$objects = json_decode($result['Content'], true);
		
			
			return $objects['message']['searchContents'];
			// foreach($objects as $object){
			// 	foreach($object as $key => $value){
			// 		echo $key;
			// 	}
			// }

		}

		public function getPortletFilteredContent($searchKeyword,$contentType){
			// $filteredContent = Array();
				$searchContent= $this->getSearchContent($searchKeyword);
				return(array_filter($searchContent, function ($var) use ($contentType) { 
					// return (stripos($var, 'Jan') === false);
					return ($var['parentId'] == $contentType);
				}));
		}
  	}
?>
