<?php
require_once '../config.php';
//require_once  "../../site/lib/functions.php";
use Store\Curl as Curl;
$title = 'Welcome to Daily Magic';
$siteDescription = '';
$siteKeywords = '';
$siteAuthor = '';

$includeCustomCss = null;
$includeCustomJs = null;

// echo S3STATUS;

if($userStatus != 'NEWUSER' and $userStatus != 'UNKNOWN' and $userStatus != 'UNSUBSCRIBED' ){

	$data['unq_msg_id'] = '';
	$data['AppId'] = ($config :: STOREID);
	$data['user_id'] = $userId;

	$serviceUrl = S3STATUS;
	// echo  $serviceUrl;
	// exit;
    $curlObj = new Curl\Curl();
    // print_r($data);
    $output = $curlObj->executePostCurl($serviceUrl,$data,0);
    
	$output = json_decode($output['Content'], true);

	if(!empty($output)){
		if($output['status'] != 'UNSUBSCRIBED'){
			$opr = $output['operator'];
			$cpevent = $output['price_point'];		

			if( in_array($opr, $config->allowedOperators) ){							
				$current_url = BILLINGHOST.$config->operatorData[$opr]['BillingServiceUnSub'];
				$UnSubData['REQUESTTYPE'] = 'UNSUB';
				$UnSubData['CPEVENT'] = $cpevent;
				$UnSubData['MSISDN'] = $msisdn;
				$UnSubData['OPERATOR'] = $opr;
				$UnSubData['CMODE'] = $config->operatorData[$opr]['Cmode'];
				
				$UnSubData['UID'] = ($config::UID);
				$UnSubData['PASS'] = ($config::Paswd);
				
				$UnSubData['APPCONTID'] = 123;

				$UnSubData['TRANSID'] = $TransId;
				$UnSubData['UNITTYPE'] = 'UNSUBSCRIPTION';
				$UnSubData['RETURL'] = 'success.php';
				$UnSubData['FLRETURL'] = 'error.php';
				$UnSubData['OTHER1'] = '';
				$UnSubData['OTHER2'] = '';
				
				$pString = '';
				//print_r($_SERVER['HTTP_HOST']);
				foreach($UnSubData as $key => $value){
					$pString .= $key.'='.$value.'&';
				}
				
				$pString = rtrim($pString, '&');

				$u=$curlObj->executePostCurlHeader($current_url,1,$pString);

				$Data = array(
					'Response' => $output,
					'MSISDN' => $msisdn,
					'OPERATOR' => $opr,
					'Transactionid' => $TransId,
					'PricePoint' => $cpevent,
					'CMode' => $operator,
					'Fail Return url' => $ErrorUrl,
					'CMODE'=> $cmode
		        );

				$headers = $curlObj->get_headers_from_curl_response($u['Content']);

				// print_r($headers); exit;
				
			}
			//include 'header.php';
?>
<tr>
	<td>
		<p><center><?=$headers['resDesc']?></center></p>
	</td>
</tr>
<?php
			//include 'footer.php';			
		}else{
			header("Location: index.php?pg=home.php");
			exit();
		}
	}
}else{
	header("Location: index.php?pg=home.php");
	exit();
}

// function FetchInfoFromCurlResponse($attrib, $obj){
// 	if(preg_match('#'.$attrib.': (.*)#', $obj, $r))
// 		return trim($r[1]);
// }

?>