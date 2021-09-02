<?php namespace App\Controllers;

use App\Libraries\IP2Proxy_lib;
use App\Models\IP2Proxy_model;

define('IP2PROXY_DATABASE', 'LOCATION OF YOUR BIN FILE');
define('IP2PROXY_DATABASE_TABLE', 'YOUR IP2PROXY TABLE NAME');

class IP2Proxy_test extends BaseController {
    public function index() {
        $ipx = new IP2Proxy_lib();

        // BIN Database
        $countryCode = $ipx->getCountryShort('1.0.241.135');

        echo '<p>Country code for 1.0.241.135: ' . $countryCode . '</p>';

        echo '
        <div>You can download the latest BIN database at
            <ul>
                <li><a href="https://lite.ip2location.com">IP2Proxy LITE BIN Database (Free)</a></li>
                <li><a href="https://www.ip2location.com/proxy-database">IP2Proxy BIN Database (Comprehensive)</a></li>
            </ul>
        </div>';

        // Web Service
        echo '<pre>';
        print_r ($ipx->getWebService('1.0.241.135'));
        echo '</pre>';

        // MySQL Query
        $db = model('IP2Proxy_model', false);
        $data = $db->lookup('1.0.241.135');
        echo '<pre>';
        print_r ($data);
        echo '</pre>';
    }
}

