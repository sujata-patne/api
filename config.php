<?php
include_once('plugin/wurfl/autoload.php');
include_once('plugin/Mobile_Detect.php');
include_once('controller/user.class.php');
include_once('lib/config.class.php');
include_once('lib/curl.class.php');
include_once('controller/device.class.php');
include_once('controller/campaign.class.php');
include_once('controller/logger.class.php'); 
include_once('controller/direct2CG.controller.php');

// include_once "controller/direct2CG.controller.php";
use Store\User as User;
use Store\Device as Device;
use Store\Config as Config;
use Store\Curl as Curl;
use Store\Campaign as Campaign;
use Store\Logger as Logger;
use Store\Direct2CG as Direct2CG;

$user = new User\User();
$campaignDetails = new Campaign\Campaign();

$promo = $user->PromoBannerId;
$userStatus = $user->getUserStatus();
// echo $userStatus;

 $storeID = Config\Config::BGWAPPID;
 // $userStatus = "SUBSCRIBED";
 $userId = $user->getUserId();   

// $userId=2761661;


$operator = $user->getOperator();
// echo $operator;
// exit;
// $operator = 'voda';
$clientIp = $user->getClientIp();
$msisdn = $user->getMsisdn();
$pricePoint = $user->getPricePoint();


$TransId = $user->getTransId();
$Token = $user->getToken();
$deviceInfo = $user->getDeviceSize();

$mobileInfo = $user->getMobileInfo();

$OprSubParam = $user->getOperatorSubscribeParam($operator);

 // $mobileDocTD = $user->getLanguage(); //doc type declaration xhtml/html5
$sessionId = $user->getSessionId();
$extractParams = $user->getQueryParams();
$config = $user->getConfigData();
//$campaignDetails = $user->getCampaignDetails();

$currentPage = $user->getCurrentPage();
$hostName = $user->hostName;
$linkUrl =$user->getLinkUrl();

$subParam = $user->getSubParam();

$bannerDetails = $user->getBannerDetails();
//echo $user->topBanner; echo $user->bottomBanner;

$f = (isset($extractParams['f']))? $extractParams['f']:$currentPage;
$promo = (isset($extractParams['promo']))? $extractParams['promo']:$promo;

$direct2cg = new Direct2CG\direct2cg($promo, $f);
$image_url = $direct2cg->getCGimages($deviceInfo,$pkgId);

?>