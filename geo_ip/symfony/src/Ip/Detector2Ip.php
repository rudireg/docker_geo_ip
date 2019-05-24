<?php
/**
 * @copyright Copyright (c) 2019 Eduard Rudakan.
 * @author    Eduard Rudakan <rudiwork@ya.ru>
 * Project: geo_ip
 * File: Detector.php
 * Date: 22.05.19
 * Time: 0:51
 */
namespace App\Ip;

/**
 * Class Detector2Ip
 * @package App\Ip
 */
class Detector2Ip implements DetectorInterface
{
    /**
     * Detector constructor.
     */
    public function __construct()
    {
    }

    /**
     * Определить Geo информацию об IP адресе
     * @param string $ip - IP адрес
     * @return string - JSON ответ
     */
    public function getGeoIp(string $ip): string
    {
        $rv = '{}';
        $ip = trim($ip);
        if (!empty($ip)) {
            $opt = [
                'http'=>[
                    'method'=>'GET',
                    'header'=>"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8\r\n" .
                        "Accept-Encoding: gzip, deflate, br\r\n" .
                        "Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7\r\n" .
                        "Cache-Control: no-cache\r\n" .
                        "Connection: keep-alive\r\n" .
                        "Host: api.2ip.ua\r\n" .
                        "Pragma: no-cache\r\n" .
                        "Upgrade-Insecure-Requests: 1\r\n" .
                        "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36\r\n",
                ]
            ];
            $context = stream_context_create($opt);
            $rv = file_get_contents("https://api.2ip.ua/geo.json?ip=$ip", false, $context);
        }
        return $rv;
    }
}
