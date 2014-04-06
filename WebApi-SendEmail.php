<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/emailSend');
/**
 * The following variable should hold the same preshared key of the server set in
 * zend-server-user.ini under zendServer\apiKey
 */

$signatureGenerator = new \WebAPI\SignatureGenerator();
$signature =
$signatureGenerator->setHost("{$uri->getHost()}:{$uri->getPort()}")
				->setUserAgent($userAgent)
				->setDate($date)
				->setRequestUri($uri->getPath())
				->generate($WebapiKey->HASH);
                                       

$client = new Zend_Http_Client();
$client
	->setUri($uri)
	->setHeaders(array(
		'User-Agent'        => $userAgent,
		'Date'              => $date,
		'X-Zend-Signature'  => $WebapiKey->NAME.';' . $signature,
		'Accept'	=> 'application/vnd.zend.serverapi+xml;version=1.7'
	))
	->setParameterPost('templateName', 'event')
	->setParameterPost('to', 'yonni.m@zend.net')
	->setParameterPost('from', 'yonni.m@zend.com')
	->setParameterPost('templateParams', array('eventGroupId' => 0))
;

        
$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::POST);
echo cleaning(nl2br(htmlentities($response->getBody())));


