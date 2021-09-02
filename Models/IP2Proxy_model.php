<?php 
namespace App\Models;
use CodeIgniter\Model;

class IP2Proxy_model extends Model
{
    protected $table = IP2PROXY_DATABASE_TABLE;

    public function lookup($ip=NULL) {
        $data = $this->where('ip_to >=', $this->Dot2LongIP($ip))->first();
        return $data;
    }

    protected function Dot2LongIP ($ipAddr) {
        if ($ipAddr == "") {
            return 0;
        } elseif (strpos($ipAddr, ':') !== false) {
            $ipNum = inet_pton($ipAddr);
            $bin = '';
            for ($bit = strlen($ipNum) - 1; $bit >= 0; $bit--) {
                $bin = sprintf('%08b', ord($ipNum[$bit])) . $bin;
            }

            if (function_exists('gmp_init')) {
                return gmp_strval(gmp_init($bin, 2), 10);
            } elseif (function_exists('bcadd')) {
                $dec = '0';
                for ($i = 0; $i < strlen($bin); $i++) {
                    $dec = bcmul($dec, '2', 0);
                    $dec = bcadd($dec, $bin[$i], 0);
                }
                return $dec;
            }
        } else {
            $ips = explode(".", $ipAddr);
            return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
        }
    }
}