<?php
require_once 'bootstrap.php';

$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/configurationImport');
$client
->setMethod('POST')
->setFileUpload('/home/yonni/Downloads/zs_config_2014_04_06_10_11_36.zip', 'fileupload');


//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

// $client->setConfig(array('timeout' => 60));
//$client->setParameterGet('nodekey', '1234');

$response = $client->send();

echo '<pre>';
echo htmlentities($response->getBody());

