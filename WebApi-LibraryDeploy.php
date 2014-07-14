<?php
require_once 'bootstrap.php';

$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/libraryVersionDeploy');
$client
->setEncType(\Zend\Http\Client::ENC_FORMDATA)
->setMethod('POST')
->setFileUpload('/usr/zlocal/packaging/qa-stuff/apps/libraries/ZendFramework-2.1.5.zpk', 'fileupload');


//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

$response = $client->send();
echo cleaning(nl2br(htmlentities($response->getBody())));


