<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once './Libraries/IP2Proxy_lib.php';

class FunctionTest extends TestCase
{
	public function testGetDb() {
		define('IP2PROXY_DATABASE', '.\Libraries\IP2Proxy\IP2PROXY.BIN');
		$ipx = new \App\Libraries\IP2Proxy_lib();
		$countryCode = $ipx->getCountryShort('1.0.241.135');

		$this->assertEquals(
			'TH',
			$countryCode,
		);
	}

	public function testGetWebService() {
		$ipx = new \App\Libraries\IP2Proxy_lib();
		$record = $ipx->getWebService('1.0.241.135');

		$this->assertEquals(
			'TH',
			$record['countryCode'],
		);
	}
}