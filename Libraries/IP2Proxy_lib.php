<?php namespace App\Libraries;

// Web Service Settings
if(!defined('IP2PROXY_API_KEY')) {
	define('IP2PROXY_API_KEY', 'demo');
}

if(!defined('IP2PROXY_PACKAGE')) {
	define('IP2PROXY_PACKAGE', 'PX1');
}

if(!defined('IP2PROXY_USESSL')) {
	define('IP2PROXY_USESSL', false);
}

require_once('IP2Proxy/Database.php');
require_once('IP2Proxy/WebService.php');

class IP2Proxy_lib {
	private $database;

	protected static $ip2proxy;

	public function __construct() {
		self::$ip2proxy = new \IP2Proxy\Database(IP2PROXY_DATABASE, \IP2Proxy\Database::FILE_IO);
	}

	public function getCountryShort($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::COUNTRY_CODE);
	}

	public function getCountryLong($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::COUNTRY_NAME);
	}

	public function getRegion($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::REGION_NAME);
	}

	public function getCity($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::CITY_NAME);
	}

	public function getISP($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::ISP);
	}

	public function getDomain($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::DOMAIN_NAME);
	}

	public function getUsageType($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::USAGE_TYPE);
	}

	public function getProxyType($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::PROXY_NAME);
	}

	public function getASN($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::ASN);
	}

	public function getAS($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::_AS);
	}

	public function getLastSeen($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::LAST_SEEN);
	}

	public function getThreat($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::THREAT);
	}

	public function getProvider($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::PROVIDER);
	}

	public function isProxy($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::IS_PROXY);
	}

	public function getAll($ip=NULL) {
		return self::$ip2proxy->lookup(self::getIP($ip), \IP2Proxy\Database::ALL);
	}

	public function getWebService($ip=NULL) {
		$ws = new \IP2Proxy\WebService(IP2PROXY_API_KEY, IP2PROXY_PACKAGE, IP2PROXY_USESSL);
		return $ws->lookup(self::getIP($ip));
	}

	protected function getIP($ip=NULL) {
		return ($ip) ? $ip : $_SERVER['REMOTE_ADDR'];
	}
}
?>
