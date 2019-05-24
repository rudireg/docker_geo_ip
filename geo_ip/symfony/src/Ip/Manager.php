<?php
/**
 * @copyright Copyright (c) 2019 Eduard Rudakan.
 * @author    Eduard Rudakan <rudiwork@ya.ru>
 * Project: geo_ip
 * File: Manager.php
 * Date: 24.05.19
 * Time: 9:56
 */
namespace App\Ip;

use App\Entity\Ips;
use \Doctrine\ORM\EntityManagerInterface;

class Manager
{
    /**
     * @var DetectorInterface
     */
    private $detector;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Manager constructor.
     * @param DetectorInterface $detector
     * @param EntityManagerInterface $em
     */
    public function __construct(DetectorInterface $detector, EntityManagerInterface $em)
    {
        $this->detector = $detector;
        $this->em = $em;
    }

    /**
     * Определение GEO данных IP
     * @param string $ip
     * @return mixed
     * @throws \Exception
     */
    public function detectGeoIp(string $ip)
    {
        if(empty($ip = trim($ip))) {
            throw new \InvalidArgumentException('Ip si empty');
        }
        if (!($geoData = json_decode($this->detector->getGeoIp($ip), true))) {
            throw new \Exception('Geo data is empty');
        }
        $ipEntity = $this->em->getRepository(Ips::class)->findOneBy(['ip'=>$ip]);
        if (!$ipEntity) {
            $ipEntity = new Ips();
        }
        $ipEntity->setIp($geoData['ip']);
        $ipEntity->setCountryCode($geoData['country_code']);
        $ipEntity->setCountry($geoData['country']);
        $ipEntity->setCountryRus($geoData['country_rus']);
        $ipEntity->setRegion($geoData['region']);
        $ipEntity->setRegionRus($geoData['region_rus']);
        $ipEntity->setCity($geoData['city']);
        $ipEntity->setCityRus($geoData['city_rus']);
        $ipEntity->setLatitude($geoData['latitude']);
        $ipEntity->setLongitude($geoData['longitude']);
        $ipEntity->setZipCode($geoData['zip_code']);
        $ipEntity->setTimeZone($geoData['time_zone']);
        $this->em->persist($ipEntity);
        $this->em->flush();
        return $geoData;
    }
}