<?php
	use Store\Curl as Curl;
	use Store\Config as Config;
use Store\Logger as Logger;

	class Subscription {
		public function __construct($operator){
			$this->curlObj = new Curl\Curl();
 			$this->BGWAPPID = Config\Config::BGWAPPID;
			$this->operator = $operator;
			$this->logger = new Logger\Logger();
		}

		public function getPlanDetails(){
			$url = "http://192.168.1.159:9875/v3/store/getSubscriptionPricePoints";

			$data = array(
				"storeId" => $this->BGWAPPID,
				"operatorId" => $this->operator
			);

			$result = $this->curlObj->executePostCurl($url,json_encode($data));
			$this->logger->logCurlAPI($result);

			$pricePoints = json_decode($result['Content'])->message;

			return $pricePoints;
		}
	}

?> 