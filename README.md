IP2Proxy CodeIgniter 4 Library
===============================
This module allows user to reverse search of IP address to detect VPN servers, open proxies, web proxies, Tor exit nodes, search engine robots, data center ranges and residential proxies. Other information available includes proxy type, country, state, city, ISP, domain name, usage type, AS number, AS name, threats, last seen date and provider names.

This library will only work with CodeIgniter 4. For CodeIgniter 3, you can get it from [here](https://github.com/ip2location/codeigniter-ip2proxy).

## Installation
Upload `Controllers` and `Libraries` to CodeIgniter `app` folder.

## Usage
This module is able to query the IP address information from either BIN database or web service. This section will explain how to use this extension to query from BIN database and web service.

Sample codes are given in this project, under **Controllers** folder. You may run the sample code by using <your_domain>/index.php/ip2proxy_test.

### BIN Database
Use following codes in your application for get geolocation information.

    // (optional) Define IP2Proxy database path.
    define('IP2PROXY_DATABASE', '/path/to/ip2proxy/database');

    $ipx = new IP2Proxy_lib();
    $countryCode = $ipx->getCountryShort('1.0.241.135');

Below are the methods supported for BIN data file lookup.

    $countryShort = $ipx->getCountryShort($ip);
    $countryLong = $ipx->getCountryLong($ip);
    $region = $ipx->getRegion($ip);
    $city = $ipx->getCity($ip);
    $isp = $ipx->getISP($ip);
    $doamin = $ipx->getDomain($ip);
    $usageType = $ipx->getUsageType($ip);
    $proxyType = $ipx->getProxyType($ip);
    $asn = $ipx->getASN($ip);
    $as = $ipx->getAS($ip);
    $lastSeen = $ipx->getLastSeen($ip);
    $threat = $ipx->getThreat($ip);
    $provider = $ipx->getProvider($ip);
    $isProxy = $ipx->isProxy($ip);

### Web Service
Use following codes in your application for get geolocation information.

    // (required) Define IP2Proxy API key.
    define('IP2PROXY_API_KEY', 'your_api_key');

    // (required) Define IP2Proxy Web service package of different granularity of return information.
    define('IP2PROXY_PACKAGE', 'PX1');

    // (optional) Define to use https or http.
    define('IP2PROXY_USESSL', false);

    $ipx = new IP2Proxy_lib();
    print_r ($ipx->getWebService('1.0.241.135'));

### MySQL Query
Use following codes in your application for get geolocation information.

    define('IP2PROXY_DATABASE_TABLE', 'ip2proxy_table_name');

    $db = model('IP2Proxy_model', false);
    print_r ($db->lookup('1.0.241.135'));

## Dependencies
This module requires IP2Proxy BIN data file or IP2Proxy API key to function. You may download the BIN data file at

* IP2Proxy LITE BIN Data (Free): https://lite.ip2location.com
* IP2Proxy Commercial BIN Data (Comprehensive): https://www.ip2location.com/proxy-database

You can also sign up for [IP2Proxy Web Service](https://www.ip2location.com/web-service/ip2proxy) to get one free API key.

## IPv4 BIN vs IPv6 BIN
* Use the IPv4 BIN file if you just need to query IPv4 addresses.
* Use the IPv6 BIN file if you need to query BOTH IPv4 and IPv6 addresses.

## SUPPORT
Email: support@ip2location.com

Website: https://www.ip2location.com
