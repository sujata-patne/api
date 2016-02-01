<?php
namespace Store\Campaign;
use Store\Config as Config;
use Store\Curl as Curl;
use Store\Logger as Logger;

class Campaign {
    private $PromoBannerId;
    private $config ;
    private $hostName;
    public $price_point;
    public $tokenId;
    public $landingUrl;
    public $nokUrl;

    public function __construct($data){
        
        $this->hostName = "http://".$_SERVER['HTTP_HOST'];
        // Promo Code
        $promoRedirect = false;
        $landingUrl = '';
        $this->PromoBannerId = $data['promoBannerId'];
        $this->TransactionId = $data['transactionId'];
        $this->sessionId = $data['sessionId'];
        $this->AppId = $data['appId'];
        $this->operator = $data['operator'];

        $this->config = new Config\Config();
        $this->curlMethods = new Curl\Curl();
        $this->logger = new Logger\Logger();

        $promoParameters = $data['promoParameters'];
        // echo "<pre>"; print_r($data);

        $CampaignDetails = $this->getCampaignDetails($this->PromoBannerId,Config\Config::BGWAPPID);
        // Promo Code
        $promoRedirect = false;
        $landingUrl = '';

        if(!empty($promoParameters) and isset($promoParameters['promo']) and $promoParameters['promo'] != '' and $promoParameters['promo'] != null and !isset($promoParameters['c'])  and ctype_digit($promoParameters['promo']) ){

            if(!empty($CampaignDetails)){
                $this->price_point = (string)$CampaignDetails['cp_promo_price_point'];
                $this->banner_id = $CampaignDetails['cp_banner_id'];

                $this->tokenId = $this->sessionId.'-'.$this->AppId.'-'.$this->PromoBannerId.'-'.$CampaignDetails['cp_banner_id'];

                if(stripos($CampaignDetails['cg_cp_nok_url'], "http://") !== false){
                    $nokUrl = $CampaignDetails['cg_cp_nok_url'];

                }else{
                    $nokUrl = 'http://'.$CampaignDetails['cg_cp_nok_url'];
                 
                }
                if(intval($CampaignDetails['cp_cg_direct_flag']) == 1 ){
                    $mobileDetails = $this->GetMsisdnDetails($this->getMsidsn());

                    if(in_array( $this->PromoBannerId, $this->PromoInterim) ){
                        $landingUrl = $this->hostName.'/proceed_to_subscription.php?c=1&f=home';
                    }else{
                        $landingUrl = $this->hostName.'/direct2Cg.php?c=1&f=home';
                    }
                }else{
                    $landingUrl = 'http://'.$CampaignDetails['cp_landing_url'].'/?c=1';
                }

                if( isset($promoParameters['referrer']) ){
                    $landingUrl .= '&promo='.$promoParameters['promo'].'&transaction_id=';
                    $tpl = $promoParameters['referrer'];
                    foreach($promoParameters as $key => $value){
                        if($key != 'c' and $key != 'promo' and $key != 'referrer'){
                            $tpl .= '&'.$key.'='.$value;
                        }
                    }
                    $tpl = rawurlencode($tpl);
                    $landingUrl .= $tpl;
                }else{
                    if( isset( $this->PromoBannerId ) && isset($this->TransactionId) ){
                        $landingUrl .= '&promo='.$this->PromoBannerId.'&transaction_id='.$this->TransactionId;
                    }else{
                        foreach($promoParameters as $key => $value){
                            $landingUrl .= '&'.$key.'='.$value;
                        }
                    }
                }
                $this->nokUrl = $nokUrl;
                $this->landingUrl = $landingUrl;
                $promoRedirect = true;

            }else{
                $this->tokenId = $this->sessionId.'-'.$this->AppId.'-0-0';
            }
        }else{

            if( !empty($promoParameters) and isset($promoParameters['c']) and $promoParameters['c'] == '1' and ctype_digit($promoParameters['promo'])  ) {
                if(!empty($CampaignDetails)){
                    $this->tokenId = $this->sessionId.'-'.$this->AppId.'-'.$this->PromoBannerId.'-'.$CampaignDetails['cp_banner_id'];
                    $this->price_point = (string)$CampaignDetails['cp_promo_price_point'];
                }else{
                    //$this->price_point = $this->config['BGW']['OperatorConfig'][$this->operator]['DefaultPP'];
                    $this->tokenId = $this->sessionId.'-'.$this->AppId.'-0-0';
                }
            }else{
                if( !empty($promoParameters) and !isset($promoParameters['c']) and ctype_digit($promoParameters['promo'])  ) {
                    $this->price_point = (string)$CampaignDetails['cp_promo_price_point'];
                    $this->tokenId = $this->sessionId.'-'.$this->AppId.'-'.$this->PromoBannerId.'-'.$CampaignDetails['cp_banner_id'];

                }else{
                    //$this->price_point = $this->config['BGW']['OperatorConfig'][$this->operator]['DefaultPP'];
                    $this->tokenId = $this->sessionId.'-'.$this->AppId.'-0-0';
                }
            }
        }
        if($promoRedirect == true){
            header("Location: ".$landingUrl);
            exit();
        }
    }
    public function getPromoBannerId(){
        return $this->banner_id;
    }
    public function getPromoPricePoint(){
        return $this->price_point;
    }
    public function getNOKUrl(){
        if(stripos($this->nokUrl, "http://") !== false){
            return $this->nokUrl;
        }else{
            return 'http://'.$this->nokUrl;
        }
    }
    public function getLandingUrl(){
        if(stripos($this->landingUrl, "http://") !== false){
            return $this->landingUrl;
        }else{
            return 'http://'.$this->landingUrl;
        }
    }
    public function getFullCampaignDetails($promoId){
        if(ctype_digit($promoId)){
            $url = "http://192.168.1.159:9875/v3/campaign/getCampaignDetailsByPromoId";
            $data = array(
                "promoId" => $promoId
            );
            $data = json_encode($data);
            $resultCampaign = $this->curlMethods->executePostCurl($url,$data);
            $this->logger->logCurlAPI($resultCampaign['Info']);

            $campaignDetails = json_decode($resultCampaign['Content'])->message->campaignDetails;

            if( count($campaignDetails) > 0 ){
                return $campaignDetails;
            }else{
                return array();
            }
        }else{
            return array();
        }
    }

    private function getCampaignDetails($promoId,$storeId){
        if( ctype_digit($promoId) ){

            $url = "http://192.168.1.159:9875/v3/campaign/getCampaignDetailsByStore";
            $data = array(
                "promoId" => $promoId,
                "storeId" => $storeId
            );
            $data = json_encode($data);
            $resultCampaign = $this->curlMethods->executePostCurl($url,$data);
            $this->logger->logCurlAPI($resultCampaign['Info']);

            $row = json_decode($resultCampaign['Content'])->message->campaignDetails;


           // if( $dbCampaign->getRecordsCount($resultCampaign) > 0 ){
            if( count($row) > 0 ){
                //$row = $dbCampaign->getData($resultCampaign);
                return array(
                    'CGFlag' => $row['cp_cg_direct_flag'],
                    'CampaignVendor' => $row['ca_client_name'],
                    'CampaignName' => str_replace(' ', '_', $row['cp_promo_title'])
                );
            }else{
                return array(
                    'CGFlag' => 0,
                    'CampaignVendor' => $this->AppId,
                    'CampaignName' => $this->AppId
                );
            }
        }else{
            return array(
                'CGFlag' => 0,
                'CampaignVendor' => $this->AppId,
                'CampaignName' => $this->AppId
            );
        }
    }
}