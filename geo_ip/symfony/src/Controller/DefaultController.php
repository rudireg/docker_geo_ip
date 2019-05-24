<?php
namespace App\Controller;
/**
 * @copyright Copyright (c) 2019 Eduard Rudakan.
 * @author    Eduard Rudakan <rudiwork@ya.ru>
 * Project: geo_ip
 * File: DefaultController.php
 * Date: 22.05.19
 * Time: 0:57
 */


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * Matches /
     * @Route("/", name="index")
     * @return Response
     */
    public function index()
    {
        return $this->render('index.html.twig', []);
    }
}