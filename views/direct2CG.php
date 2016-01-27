<?php
#userstatus -> NEWUSER || UNSUBSCRIBED
require_once '../config.php';
include_once '../controller/direct2CG.controller.php';
use Store\Direct2CG as Direct2CG;
use Store\Campaign as Campaign;

// use Store\User as User;
//get config parameters;
$t = $_GET['t'];
$n = $_GET['n'];
$d = $_GET['d'];
$m = $_GET['m'];
$i = isset($_GET['i']) ? $_GET['i'] : null;

echo "<pre>"; print_r($_GET);
echo "<pre>"; print_r($extractParams);
exit;


$f = (isset($extractParams['f']))?$extractParams['f']:$currentPage;
$promo = (isset($extractParams['promo']))? $extractParams['promo']:$promo;

$price_point = (isset($extractParams['EventId']) and $extractParams['EventId'] != '' and $extractParams['EventId'] != null)? base64_decode($extractParams['EventId']): $OprSubParam['CPEVENT'];

// $userStatus = 'NEWUSER';
if($userStatus == 'NEWUSER' or $userStatus == 'UNSUBSCRIBED' ){
	if( !in_array($operator, $config->allowedOperators) ){
		header("Location: error.php?responseId=999999&resDesc=Invalid Operator Info");
		exit();
	}else{

	//	$direct2cg = new Direct2CG\direct2cg($promo, $f);
	//	$image_url = $direct2cg->getCGimages();
		$retUrl = $direct2cg->getUrlFromParams();
		$urlPart = strtok($_SERVER["REQUEST_URI"],'?');
		$urlPart = substr(strtok($_SERVER["REQUEST_URI"],'?'),0,strrpos($urlPart,"/"));
		if(stripos($hostName, "http://") !== false){
   			$fUrl = $hostName.$urlPart.'/error.php';   
 		}else{
   			$fUrl = 'http://'.$hostName.$urlPart.'/error.php';   
  		}
		// echo $price_point;
        if( isset($t) and isset($n) and isset($d) and isset($m) ){
			$n1 = base64_decode($n);
			if($i == null){
				$retUrl .= '?t='.$t.'_n='.$n1.'_d='.$d.'_m='.$m;
			}else{
				$retUrl .= '?t='.$t.'_n='.$n1.'_d='.$d.'_m='.$m.'_i='.$i;
			}
		}
		//if(!empty($extractParams) and isset($extractParams['promo']) and $extractParams['promo'] != '' and $extractParams['promo'] != null and ctype_digit($extractParams['promo'])){
		if(!(!empty($promo) and isset($promo) and $promo != '' and $promo != null and ctype_digit($promo))){
			$checkPromoId = explode("_",$promo);
			if($checkPromoId[0] != 'z'){
				$fUrl = $campaignDetails->getNOKUrl();
				$retUrl = $campaignDetails->getLandingUrl();
				$price_point = $campaignDetails->getPromoPricePoint();
				$bannerId = $campaignDetails->getPromoBannerId();
				$direct2cg->logBGWBanner($msisdn,$operator, $TransId,$campaignDetails,$fUrl,$retUrl,$price_point,$bannerId);
			}
		}else{
			if( empty($OprSubParam) ){
				header("Location: ".$fUrl);
				exit();
			}else{
				$logCmode = $OprSubParam['CMODE'];
			}
		}

		$subscribeData = array(
			'transactionId' => $TransId,
			'msisdn' => $msisdn,
			'clientIp' => $clientIp,
			'retUrl' => $retUrl,
			'extractParams' => $extractParams,
			'promoBannerId' => $promo,
		);
		// $billing_gateway = 'http://103.43.2.5/'.$config->operatorData[$operator]['BillingServiceSub'].'?REQUESTTYPE=NEW_SUB&APPCONTID=123&UNITTYPE=SUBSCRIPTION&CPEVENT='.$price_point.'&MSISDN='.$msisdn.'&OPERATOR='.$operator.'&CMODE='.$OprSubParam['CMODE'].'&UID='.($config::UID).'&PASS='.($config::Paswd).'&TRANSID='.$TransId.'&RETURL='.$retUrl.'&FLRETURL='.$fUrl.'&OTHER1='.$image_url.'&OTHER2='.$hostName.'&TOKENCALL='.$Token;
		$billing_gateway = 'http://192.168.1.156/'.$config->operatorData[$operator]['BillingServiceSub'].'?REQUESTTYPE=NEW_SUB&APPCONTID=123&UNITTYPE=SUBSCRIPTION&CPEVENT='.$price_point.'&MSISDN='.$msisdn.'&OPERATOR='.$operator.'&CMODE='.$OprSubParam['CMODE'].'&UID='.($config::UID).'&PASS='.($config::Paswd).'&TRANSID='.$TransId.'&RETURL='.$retUrl.'&FLRETURL='.$fUrl.'&OTHER1='.$image_url.'&OTHER2='.$hostName.'&TOKENCALL='.$Token;

		setcookie('D2C_promo', "", time()-3600, '/');
		setcookie('D2C_tid', "", time()-3600, '/');

		unset($_COOKIE['D2C_promo']);
		unset($_COOKIE['D2C_tid']);

		header("Location: ".$billing_gateway);
		exit();
	}
}
else{
	$checkPromoId = explode("_",$extractParams['promo']);
	//print_r($checkPromoId);
	if( $userStatus == 'UNKNOWN' ){
		header("Location: error.php?responseId=999999&resDesc=Invalid Operator Info");
		exit();
	}else{
	#	header("Location: index.php");
		echo "User status is unknown.";
		exit();
	}
}


?>