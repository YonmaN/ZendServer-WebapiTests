<?php
require_once 'bootstrap.php';
class test {
	private $boom = '1boom';
	public $boom2 = '1boom';
	
}



$test = new test();
// var_dump(unserialize(serialize($test)));
session_start();
 $_SESSION = array('boom' => '', 'boom2' => array('noarray'), 'myarray' => new ArrayObject(array('boom' => array(), 'mine')), 'test' => $test);
 
 
$client = new WebAPIClient('http://yonni-desktop:10081/ZendServer/Api/zrayGetRequestEnvironment');
$client
	->setEncType(\Zend\Http\Client::ENC_FORMDATA)
	->setMethod('GET')
	->setWebapiOutput('xml')
	->getRequest()->getQuery()->fromArray(
	    array('requestId' => '22709')
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
echo htmlentities(cleaning($response->getBody(), array(
			'input-xml'			=> true,
			'output-xml'		=> true,
			'indent'			=> true,
			'indent-attributes'	=> true,
			'wrap'				=> true,
			'indent-spaces'		=> 2,
	)));

session_write_close();