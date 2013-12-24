<?php
require_once 'bootstrap.php';
                                       
$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/vhostGetStatus');
$client
	->setMethod('GET')
	->getRequest()->getQuery()->fromArray(
	    array('limit' => 0, 'offset' => 1)
    );
	
	
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

