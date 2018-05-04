<?php

namespace App\Controller\Buscar\Tercero;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BuscarTerceroController extends Controller
{

    /**
     * @Route("/buscar/tercero/lista", name="zaf_buscar_tercero_lista")
     */
    public function listaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $codigoEmpresa = $this->getUser()->getCodigoEmpresaFk(); //Se debe capturar del usuario
        $arTerceros = $em->getRepository('App:Tercero')->findBy(array('codigoEmpresaFk' => $codigoEmpresa));

        return $this->render('Buscar/Tercero/tercero.html.twig', array(
            'arTerceros' => $arTerceros
        ));
    }

}
