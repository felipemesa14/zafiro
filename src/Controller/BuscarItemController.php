<?php

namespace App\Controller;

use App\Funciones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class BuscarItemController extends Controller
{

    /**
     * @Route("/ingreso/factura/detalle/nuevo/item/{codigoMovimiento}", name="zaf_ingreso_factura_detalle_nuevo_item")
     */
    public function detalleNuevoItemAction(Request $request, $codigoMovimiento)
    {
        $objFuncion = new Funciones();
        $objItem = new ItemController();
        $em = $this->getDoctrine()->getManager();
        $form = $this->formularioNuevoItem();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnFiltrar')->isClicked()) {
                $objItem->filtrar($form);
            }
            if ($form->get('BtnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:MovimientoDetalle')->nuevoFacturaDetalle($arrSeleccionados);
                if ($strRespuesta != "") {
                    $objFuncion->Mensaje('error', $strRespuesta);
                }
                return $this->redirectToRoute('zaf_ingreso_factura_detalle_nuevo_item');
            }
        }
        //Consultar los item de la empresa
        $arItems = $this->listaItem();
        return $this->render('Factura/detalleNuevoItem.html.twig', array(
            'arItems' => $arItems,
            'form' => $form->createView()));

    }

    public function formularioNuevoItem()
    {
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class)
            ->add('referencia', TextType::class)
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
            ->add('BtnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();

        return $form;
    }

    public function listaItem()
    {
        $session = new Session();
        $em = $this->getDoctrine();
        $arItem = $em->getRepository("App:Item")->listaDql(
            $session->get('arEmpresa')->getCodigoEmpresaPk(),
            $session->get('filtroNombreItem'),
            $session->get('filtroReferenciaItem'));
        return $arItem;
    }

}
