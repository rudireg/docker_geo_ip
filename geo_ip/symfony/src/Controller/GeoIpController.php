<?php
/**
 * @copyright Copyright (c) 2019 Eduard Rudakan.
 * @author    Eduard Rudakan <rudiwork@ya.ru>
 * Project: geo_ip
 * File: GeoIpController.php
 * Date: 22.05.19
 * Time: 8:50
 */
namespace App\Controller;

use App\Ip\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeoIpController  extends AbstractController
{
    /**
     * Matches /api/check/*
     *
     * @Route("/api/check/{ip}", name="api_check_ip", methods={"GET"}, defaults={"ip":null})
     * @param Request $request
     * @param string|null $ip
     * @param Manager $manager
     * @return Response
     */
    public function checkIp(Request $request, ? string $ip, Manager $manager)
    {
        $ip = trim($ip);
        if (!empty($ip)) {
            try {
                $geoData = $manager->detectGeoIp($ip);
                return new JsonResponse($geoData);
            } catch (\Exception $e) {
                return new JsonResponse(['error'=>1, 'code'=>$e->getCode(), 'message'=>$e->getMessage()]);
            }
        }
        return new JsonResponse(['error'=>1, 'message'=>'ip is empty']);
    }
}