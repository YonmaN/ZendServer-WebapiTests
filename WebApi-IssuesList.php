<?php
require_once 'bootstrap.php';

$userAgent = 'Zend Server Development';
$date = gmdate('D, d M Y H:i:s') . ' GMT';
$uri = Zend_Uri::factory('http://yonni-desktop:10081/ZendServer/Api/monitorGetIssuesByPredefinedFilter?filters'. urlencode('[applicationIds][0]').'=5');
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
	->setParameterGet('issueId', 13)
	->setParameterGet('limit', 3)
	->setHeaders(array(
		'User-Agent'        => $userAgent,
		'Date'              => $date,
		'X-Zend-Signature'  => $keyName.';' . $signature,
		'Accept'			=> 'application/vnd.zend.serverapi+xml;version=1.3'
	))->setParameterGet('filterId', 'All Issues');
	
$client->setConfig(array('timeout' => 60));
$response = $client->request(Zend_Http_Client::GET);
echo cleaning(nl2br(htmlentities($response->getBody())));


