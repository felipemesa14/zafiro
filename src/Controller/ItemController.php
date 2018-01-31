<?php

namespace App\Controller;

use App\Funciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\ItemType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;

class ItemController extends Controller
{
    var $codigoEmpresa = "";

    /**
     * @Route("/admin/item/lista", name="zaf_admin_item_lista")
     */
    public function listaAction(Request $request)
    {
        $objFuncion = new Funciones();
        $em = $this->getDoctrine()->getManager();
        $form = $this->formularioLista();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnFiltrar')->isClicked()) {
                $this->filtrar($form);
            }
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:Item')->eliminar($arrSeleccionados);
                $strRespuesta != "" ? $objFuncion->Mensaje('error', $strRespuesta) : $em->flush();
                return $this->redirectToRoute('zaf_admin_item_lista');
            }
        }
        //Consultar los item de la empresa
        $arItems = $this->lista();
        return $this->render('Item/lista.html.twig', array(
            'arItems' => $arItems,
            'form' => $form->createView()));
    }

    /**
     *
     * @Route("/admin/item/nuevo/{codigoItem}", name="zaf_admin_item_nuevo")
     */
    public function nuevoAction(Request $request, $codigoItem)
    {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = $em->getRepository('App:Empresa')->find(1); //Consultar la empresa del usuario
        $arItem = new \App\Entity\Item();
        if ($codigoItem != 0) {
            $arItem = $em->getRepository('App:Item')->find($codigoItem);
        }
        $form = $this->createForm(ItemType::class, $arItem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arItem = $form->getData();
            $arItem->setEmpresaRel($arEmpresa);
            $em->persist($arItem);
            $em->flush();
            return $this->redirectToRoute('zaf_admin_item_lista');
        }
        return $this->render('Item/nuevo.html.twig', array(
            'aritem' => $arItem,
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/admin/item/detalle/{codigoItem}", name="zaf_admin_item_detalle")
     */
    public function detalleAction(Request $request, $codigoitem)
    {
        $em = $this->getDoctrine()->getManager();
        $arItem = $em->getRepository('App:item')->find($codigoitem);
        return $this->render('item/detalle.html.twig', array(
            'aritem' => $arItem));
    }

    public function filtrar($form)
    {
        $session = new Session();
        $session->set('filtroNombreItem', $form->get('nombre')->getData());
        $session->set('filtroReferenciaItem', $form->get('referencia')->getData());
    }

    public function lista()
    {
        $session = new Session();
        $em = $this->getDoctrine();
        $arItem = $em->getRepository("App:Item")->listaDql(
            $session->get('arEmpresa')->getCodigoEmpresaPk(),
            $session->get('filtroNombreItem'),
            $session->get('filtroReferenciaItem'));
        return $arItem;
    }

    private function formularioLista()
    {
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class)
            ->add('referencia', TextType::class)
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
            ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
            ->getForm();

        return $form;
    }


}
