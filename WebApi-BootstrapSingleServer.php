<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/bootstrapSingleServer');
/**
 * The following variable should hold the same preshared key of the server set in
 * zend-server-user.ini under zendServer\apiKey
 */
                                       

$client = new Zend_Http_Client();
$client
	->setUri($uri)
	->setHeaders(array(
		'User-Agent'        => $userAgent,
		'Date'              => $date,
		'Accept'	=> 'application/vnd.zend.serverapi+json;version=1.7'
	));
       

	$client->setParameterPost('adminPassword', '1234');
	$client->setParameterPost('orderNumber', 'pe');
	$client->setParameterPost('licenseKey', 'D5127010001G21DD07DE791B619D7EA3');
	$client->setParameterPost('production', 'TRUE');
// 	$client->setParameterPost('dontWait', 'TRUE');

//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::POST);
echo cleaning(nl2br(htmlentities($response->getBody())));
echo cleaning(nl2br(htmlentities(print_r($response->getHeaders(),true))));


