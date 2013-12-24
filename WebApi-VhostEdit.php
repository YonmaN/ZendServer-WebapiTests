<?php
require_once 'bootstrap.php';
                                       
$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/vhostEdit');
$client
	->setEncType(\Zend\Http\Client::ENC_FORMDATA)
	->setMethod('POST')
	->getRequest()->getPost()->fromArray(
	    array('vhostId' => 4, 'template' => '
# Created by Zend Server

<VirtualHost *:${port}>

    DocumentRoot "${docroot}"
    <Directory "${docroot}">
        Options +Indexes FollowSymLinks
        DirectoryIndex index.php
        Order allow,deny
        Allow from all
        AllowOverride All
    </Directory>

    SSLEngine on
    SSLCertificateFile "${certificate_file}"
    SSLCertificateKeyFile "${certificate_key_file}"
    SSLCertificateChainFile "${certificate_chain_file}"

    ServerName ${vhost}:${port}
    
    # include the folder containing the vhost aliases for zend server deployment
    Include "${aliasdir}/*.conf"
    
</VirtualHost>', 'sslCertificatePath' => '/home/yonni/yonni.crt')
    );
	
	
//	$client->setCookie('debug_host', '10.1.2.174');
//	$client->setCookie('debug_port', '10137');
//	$client->setCookie('_bm', '2897');
//	$client->setCookie('debug_session_id', rand(3000, 1000000));
//	$client->setCookie('ZDEDebuggerPresent', 'php%2Cphtml%2Cphp3');

// $client->setConfig(array('timeout' => 60));
//$client->setParameterGet('nodekey', '1234');

$response = $client->send();
echo '<pre>';
echo htmlentities($response->getBody());

