<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/configurationExport');
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
		'Accept'	=> 'application/vnd.zend.serverapi+xml;version=1.8'
	))
// 	->setParameterGet('snapshotName', 'sadfsdafsafd')
;
        
$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::GET);

file_put_contents('/tmp/config-test.zip', $response->getBody());

$zip = new ZipArchive();
$zip->open('/tmp/config-test.zip');
echo $zip->getStatusString();
