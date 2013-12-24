<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/applicationDeploy');
/**
 * The following variable should hold the same preshared key of the server set in
 * zend-server-user.ini under zendServer\apiKey
 */
$psk = $WebapiKey->HASH;
$keyName = $WebapiKey->NAME;

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
		'X-Zend-Signature'  => $keyName.';' . $signature,
		'Accept'	=> 'application/vnd.zend.serverapi+xml;version=1.6'
	))
	->setFileUpload('/usr/zlocal/packaging/qa-stuff/apps/sanity/sanity.zpk', 'fileupload');

$client->setParameterPost('baseUrl', 'http://sadfasdfasdf123:801/asdfasdf');
//$client->setParameterPost('baseUrl', 'http://asdfasdf/asdf2as3df');
$client->setParameterPost('userAppName', 'asdfasd12346');
$client->setParameterPost('defaultServer', 'FALSE');
$client->setParameterPost('createVhost', 'TRUE');
$client->setParameterPost('userParams', array(
	'some_parameter' => 'sddsfadsfa'
));

//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::POST);
echo cleaning(nl2br(htmlentities($response->getBody())));


