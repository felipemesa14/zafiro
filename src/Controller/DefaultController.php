<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine();
        $session = new Session();
//        $arUsuario = $em->getRepository("App:User");
        $arEmpresa = $em->getRepository('App:Empresa')->find(1);// empresa del usuario logeado
        $session->set('arEmpresa', $arEmpresa);
        return $this->render('Prueba/inicio.html.twig');
    }

}
