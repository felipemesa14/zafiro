<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BuscarTerceroController extends Controller {

    /**
     * @Route("/buscar/tercero/lista", name="zaf_buscar_tercero_lista")
     */
    public function listaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $codigoEmpresa = 1; //Se debe capturar del empleado
        $arTerceros = $em->getRepository('App:Tercero')->findBy(array('codigoEmpresaFk' => $codigoEmpresa));

        return $this->render('Buscar/tercero.html.twig', array(
                    'arTerceros' => $arTerceros
        ));
    }

}
