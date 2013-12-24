<?php
require_once 'bootstrap.php';

$userAgent = 'Zend';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/codetracingDownloadTraceFile');
/**
 * The following variable should hold the same preshared key of the server set in
 * zend-server-user.ini under zendServer\apiKey
 */
$psk = '76e2d0695f1c341b0efa04454fbf62f258793dbf8e2635f9d9f4688093f9d078';

$signatureGenerator = new Zwas_Api_SignatureGenerator();
$signature =
$signatureGenerator->setHost("{$uri->getHost()}:{$uri->getPort()}")
				->setUserAgent($userAgent)
				->setDate($date)
				->setRequestUri($uri->getPath())
				->generate($psk);
                                       

$client = new Zend_Http_Client();
$client
	->setUri($uri)
	->setHeaders(array(
		'User-Agent'        => $userAgent,
		'Date'              => $date,
		'X-Zend-Signature'  => 'username;' . $signature,
		'Accept'	=> 'application/vnd.zend.serverapi+xml;version=1.3'
	))
	->setParameterGet('eventsGroupId', '88');
	
//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

$client->setConfig(array('timeout' => 60));
//$client->setParameterGet('nodekey', '1234');
$response = $client->request(Zend_Http_Client::GET);
echo '<pre>';
echo print_r($response->getHeaders());
echo PHP_EOL;
echo $response->getBody();
file_put_contents('/tmp/boom.amf', $response->getBody());

