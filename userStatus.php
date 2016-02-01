<?php
include 'config.php';

echo("----------------Auth Service Response----------------");
echo "</br >";
echo("MSISDN: ".$msisdn);
echo "</br >";
echo("Client IP: ".$clientIp);
echo "</br >";
echo("Operator: ".$operator);
echo "</br >";
echo("User Status: ".$userStatus);
echo "</br >";
echo("----------------App State Response----------------");
echo "</br >";
echo("MSISDN: ".$msisdn);
echo "</br >";
echo("Client IP: ".$clientIp);
echo "</br >";
exec("dig +short -x $clientIp 2>&1", $output, $retval);
if ($retval != 0){
    // there was an error performing the command
}else{
    $x=0;
    while ($x < (sizeof($output))){
        $string = $output[$x];
        $x++;
    }
}
$operator = $output[0];

if($operator == ''){
    $auth = 2;

    $data['MSISDN'] = $msisdn ;
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, SVCHOST.'Service2.svc/GetTelcoInfo');
    curl_setopt($ch, CURLOPT_URL, SVCHOST.USER_STATUS);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);  // RETURN THE CONTENTS OF THE CALL

    $info = curl_getinfo($ch);
    $content= curl_exec ($ch);
    curl_close ($ch); // close curl handle

    $content = ltrim($content,'[');
    $content = rtrim($content,']');

    $content_data = explode(',',$content);
    $operator = $content_data[2];
    $auth = 2;
    $operatorData = array($operator,$auth);
}

echo "Operator: ".$operator;
echo "</br >";
$operator = strtolower($operator);

$qry_str = "MSISDN=".$msisdn."&UID=jet";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SVCHOST.'appstate?'.$qry_str);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$content = trim(curl_exec($ch));
curl_close($ch);
$response_array = explode('|',$content);
$user_status_array = explode('=',$response_array[0]);
$current_user_status = $user_status_array[1];
echo ("Current_user_status: ".$current_user_status);
echo "</br >";

$user_array_msisdn = explode('=',$response_array[1]);
$current_user_msisdn_number = $user_array_msisdn[1];

?>