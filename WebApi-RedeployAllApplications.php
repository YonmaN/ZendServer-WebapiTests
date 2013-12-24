<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/redeployAllApplications');
/**
 * The following variable should hold the same preshared key of the server set in
 * zend-server-user.ini under zendServer\apiKey
 */
$psk = '0e49585dd7d41e2abd5eaf08e20e8abd213e63cb3bc6bf61f79bf1693699d570';

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
	));
	
//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::POST);
echo cleaning(nl2br(htmlentities($response->getBody())));


