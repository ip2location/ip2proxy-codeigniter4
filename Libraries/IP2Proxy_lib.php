<?php namespace App\Libraries;

// Web Service Settings
if(defined('IP2LOCATION_IO_API_KEY')) {
	define('USE_IO', true);
} else  {
	define('USE_IO', false);
	if(!defined('IP2PROXY_API_KEY')) {
		define('IP2PROXY_API_KEY', 'demo');
	}

	if(!defined('IP2PROXY_PACKAGE')) {
		define('IP2PROXY_PACKAGE', 'PX1');
	}

	if(!defined('IP2PROXY_USESSL')) {
		define('IP2PROXY_USESSL', false);
	}
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
		if (USE_IO) {
			// Using IP2Location.io API
			$ioapi_baseurl = 'https://api.ip2location.io/?';
			$params = [
				'key'     => IP2LOCATION_IO_API_KEY,
				'ip'      => self::getIP($ip),
				'lang'    => ((defined('IP2LOCATION_IO_LANGUAGE')) ? IP2LOCATION_IO_LANGUAGE : ''),
			];
			// Remove parameters without values
			$params = array_filter($params);
			$url = $ioapi_baseurl . http_build_query($params);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FAILONERROR, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);

			$response = curl_exec($ch);

			if (!curl_errno($ch)) {
				if (($data = json_decode($response, true)) === null) {
					return false;
				}
				if (array_key_exists('error', $data)) {
					throw new \Exception(__CLASS__ . ': ' . $data['error']['error_message'], $data['error']['error_code']);
				}
				return $data;
			}

			curl_close($ch);

			return false;
		} else {
			$ws = new \IP2Proxy\WebService(IP2PROXY_API_KEY, IP2PROXY_PACKAGE, IP2PROXY_USESSL);
			return $ws->lookup(self::getIP($ip));
		}
	}

	protected function getIP($ip=NULL) {
		return ($ip) ? $ip : $_SERVER['REMOTE_ADDR'];
	}
}
?>
