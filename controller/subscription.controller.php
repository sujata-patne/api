<?php
	use Store\Curl as Curl;
	class Subscription {
		public function __construct(){
			 // include "../../../site/lib/bootstrap.php";
			 // include "../../models/store.model.php";	
			 // include  "../../../site/lib/functions.php";
			// $this->error = null;
			$this->curlObj = new Curl\Curl();
			// $dbCMS = new Db($config['Db']['icon_cms']['User'], $config['Db']['icon_cms']['Password'],$config['Db']['icon_cms']['Name']);
			// $this->dbCon = $dbCMS->getConnection();
		}

		public function getPlanDetails(){
			// $result_packageids = getSubscriptionPlans($this->dbCon,$packageId);
			// return $result_packageids;
			$url = 'http://192.168.1.159:9875/v3/subscription/getSubscriptionDetails';
			$data = json_encode(array(
				"storeId" => 2
			));
			$result = $this->curlObj->executePostCurl($url,$data);
			$result = json_decode($result['Content']); 
			return ($result->message);
			// print_r($result);
		}
	}

?> 