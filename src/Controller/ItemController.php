<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\ItemType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ItemController extends Controller
{

    /**
     * @Route("/admin/item/lista", name="zaf_admin_item_lista")
     */
    public function listaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $codigoEmpresa = 1; // esta variable se debe consultar con la entidad del usuario que tiene relacion con la empresa
        $form = $this->formularioLista();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $strRespuesta = $em->getRepository('App:Item')->eliminar($arrSeleccionados);
                if ($strRespuesta != "") {
                    $strRespuesta;
                }
                return $this->redirectToRoute('zaf_admin_item_lista');
            }
        }
        //Consultar los item de la empresa
        $arItems = $em->getRepository('App:Item')->findBy(array(
            'codigoEmpresaFk' => $codigoEmpresa));
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
     * @Route("/admin/item/item/{codigoItem}", name="zaf_admin_item_detalle")
     */
//    public function detalleAction(Request $request, $codigoitem) {
//        $em = $this->getDoctrine()->getManager();
//        $arItem = $em->getRepository('App:item')->find($codigoitem);
//        return $this->render('item/detalle.html.twig', array(
//                    'aritem' => $arItem));
//    }

    private function formularioLista()
    {
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class)
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtar'))
            ->add('BtnEliminar', SubmitType::class, array('label' => 'Eliminar'))
            ->getForm();

        return $form;
    }

}
