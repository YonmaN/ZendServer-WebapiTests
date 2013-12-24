<?php
use Zend\Uri\Http;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

define('ZEND_SERVER_GUI_PATH', '/usr/local/zend/gui');
set_include_path(ZEND_SERVER_GUI_PATH . '/vendor' . PATH_SEPARATOR . get_include_path() . PATH_SEPARATOR . zend_deployment_library_path('Zend Framework 1'));

require_once  'Zend/Http/Client.php';
require_once 'Zend/Uri.php';
// direct the following to the proper location
require_once ZEND_SERVER_GUI_PATH . '/module/WebAPI/src/WebAPI/SignatureGenerator.php';

require_once 'Zend/Db.php';

$db = Zend_Db::factory('Pdo_Sqlite', array('dbname' => '/usr/local/zend/var/db/gui.db'));
$WebapiKey = $db->query('SELECT * FROM GUI_WEBAPI_KEYS WHERE NAME = \'admin\'')->fetchObject();

function cleaning($what_to_clean, $tidy_config='' ) {

	$config = array(
			'input-xml'			=> false,
			'output-xml'		=> true,
			'indent'			=> true,
			'indent-attributes'	=> true,
			'wrap'				=> true,
			'indent-spaces'		=> 2,
	);

	if( $tidy_config == '' ) {
		$tidy_config = &$config;
	}

	$what_to_clean = str_replace('<![CDATA[', '<[CDATA[', $what_to_clean);
	
	$tidy = new tidy();
	$out = $tidy->parseString($what_to_clean, $tidy_config, 'UTF8');
	$tidy->cleanRepair();
	
	$value = str_replace(array('&lt;[CDATA[', ']]&gt;'), array('<![CDATA[', ']]>'), $tidy);
	return($value);
}

require_once ZEND_SERVER_GUI_PATH . '/init_autoloader.php';
require_once ZEND_SERVER_GUI_PATH . '/module/WebAPI/Module.php';

class WebAPIClient extends \Zend\Http\Client {
    /**
     * @var ResultSet
     */
    private $webapiKey;
    
    /**
     * @var string
     */
    private $version = \WebAPI\Module::WEBAPI_CURRENT_VERSION;
    /**
     * @var string
     */
    private $output = 'xml';
    
    public function __construct($uri = null, $options = null) {
        parent::__construct($uri, $options);
        
        $db = new Adapter(array(
					'driver'         => 'Pdo',
					'dsn'            => "sqlite:/usr/local/zend/var/db/gui.db",
					'username'       =>'',
					'password'      =>'',
					'driver_options' => array(
					),
			));
        $this->webapiKey = $db->query('SELECT * FROM GUI_WEBAPI_KEYS WHERE NAME = \'admin\' LIMIT 1', Adapter::QUERY_MODE_EXECUTE)->current();
    }
    
    protected function doRequest(Http $uri, $method, $secure = false, $headers = array(), $body = '') {
        
        $headers['User-Agent'] = 'Zend the first';
        $headers['Date'] = gmdate('D, d M Y H:i:s') . ' GMT';
        
        $signatureGenerator = new \WebAPI\SignatureGenerator();
        $signature =
        $signatureGenerator->setHost("{$uri->getHost()}:{$uri->getPort()}")
            ->setUserAgent($headers['User-Agent'])
            ->setDate($headers['Date'])
            ->setRequestUri($uri->getPath())
            ->generate($this->webapiKey->HASH);
        
        $headers['X-Zend-Signature'] = "{$this->webapiKey->NAME};$signature";
        $headers['Accept'] = "application/vnd.zend.serverapi+{$this->output};version={$this->version}";
        
        if ($method == 'POST') {
            $this->setEncType(\Zend\Http\Client::ENC_FORMDATA);
            $headers['Content-Length'] = strlen($body);
        }
        
        return parent::doRequest($uri, $method, $secure, $headers, $body);
    }
}

