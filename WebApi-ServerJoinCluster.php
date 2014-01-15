<?php
require_once 'bootstrap.php';
$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/serverAddToCluster');
$client
->setEncType(\Zend\Http\Client::ENC_FORMDATA)
->setMethod('POST')
->getRequest()->getPost()->fromArray(array(
	
));

$response = $client->send();
echo cleaning(nl2br(htmlentities($response->getBody())));


