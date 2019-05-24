<?php
/**
 * @copyright Copyright (c) 2019 Eduard Rudakan.
 * @author    Eduard Rudakan <rudiwork@ya.ru>
 * Project: geo_ip
 * File: DetectorInterface.php
 * Date: 22.05.19
 * Time: 0:47
 */
namespace App\Ip;

/**
 * Interface DetectorInterface
 * @package App\Ip
 */
interface DetectorInterface
{
    /**
     * Определить Geo информацию об IP адресе
     * @param string $ip - IP адрес
     * @return string - JSON ответ
     */
    public function getGeoIp(string $ip): string;
}