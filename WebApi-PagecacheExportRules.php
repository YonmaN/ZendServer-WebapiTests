<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/pagecacheExportRules');
/**
 * The following variable should hold the same preshared key of the server set in
 * zend-server-user.ini under zendServer\apiKey
 */
$psk = '0123456789012345678901234567890123456789012345678901234567890123';
$psk = 'e23fc375d7e9f0f8effa8b76d1c525b191d4d2c77bac4ca5c5503388c5159c6d';

$signatureGenerator = new \WebAPI\SignatureGenerator();
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
		'X-Zend-Signature'  => 'QAWebAPITestKey;' . $signature,
// 		'X-Zend-Signature'  => 'yonni.m;' . $signature,
		'Accept'	=> 'application/vnd.zend.serverapi+xml;version=1.3'
	))->setParameterGet('applicationId', -1);
        
$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::GET);
echo cleaning(nl2br(print_r($response->getHeaders(), true)));
echo cleaning(nl2br(htmlentities($response->getBody())));


