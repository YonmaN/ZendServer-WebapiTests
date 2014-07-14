<?php
require_once 'bootstrap.php';

$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/libraryVersionDeploy');
$client
->setEncType(\Zend\Http\Client::ENC_FORMDATA)
->setMethod('POST')
->setFileUpload('/usr/zlocal/packaging/qa-stuff/apps/ibmi toolkit/PHPToolkitForIBMi-1.5.1-userparams.zpk', 'fileupload')
->getRequest()->getPost()->fromArray(array('userParams' => array(
		'db_type' => 'adsasd', 
		'db_name' => 'asdasd', 
		'db_username' => 'asdasd', 
		'db_password' => 'asdfasd', 
		'db_host' => 'asddasads',
		'site_name' => 'asddasads',
		'site_email' => 'local-part@hostname.com',
		'admin_username' => 'asddasads',
		'admin_email' => 'local-part@hostname.com',
		'admin_password' => 'asddasads',
		'admin_confirm_password' => 'asddasads',
		'server_timezone' => 'asddasads',
		'server_clean_urls' => 'asddasads',
		'server_update_notifications' => 'asddasads',
)));


//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

$response = $client->send();
echo cleaning(nl2br(htmlentities($response->getBody())));


