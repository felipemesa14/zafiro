<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FormaPago implements FixtureInterface {

    public function load(ObjectManager $manager) {
        $arFormaPago = $manager->getRepository('App:FormaPago')->find(1);
        if (!$arFormaPago) {
            $arFormaPago = new \App\Entity\FormaPago();
            $arFormaPago->setCodigoFormaPagoPk(1);
            $arFormaPago->setNombre('CONTADO');
            $arFormaPago->setDias(0);
            $manager->persist($arFormaPago);
        }

        $arFormaPago = $manager->getRepository('App:FormaPago')->find(2);
        if (!$arFormaPago) {
            $arFormaPago = new \App\Entity\FormaPago();
            $arFormaPago->setCodigoFormaPagoPk(2);
            $arFormaPago->setNombre('8 DIAS');
            $arFormaPago->setDias(8);
            $manager->persist($arFormaPago);
        }
        
        $arFormaPago = $manager->getRepository('App:FormaPago')->find(3);
        if (!$arFormaPago) {
            $arFormaPago = new \App\Entity\FormaPago();
            $arFormaPago->setCodigoFormaPagoPk(15);
            $arFormaPago->setNombre('15 DIAS');
            $arFormaPago->setDias(15);
            $manager->persist($arFormaPago);
        }
        
        $arFormaPago = $manager->getRepository('App:FormaPago')->find(4);
        if (!$arFormaPago) {
            $arFormaPago = new \App\Entity\FormaPago();
            $arFormaPago->setCodigoFormaPagoPk(4);
            $arFormaPago->setNombre('30 DIAS');
            $arFormaPago->setDias(30);
            $manager->persist($arFormaPago);
        }
        
        $arFormaPago = $manager->getRepository('App:FormaPago')->find(5);
        if (!$arFormaPago) {
            $arFormaPago = new \App\Entity\FormaPago();
            $arFormaPago->setCodigoFormaPagoPk(1);
            $arFormaPago->setNombre('60 DIAS');
            $arFormaPago->setDias(60);
            $manager->persist($arFormaPago);
        }
        $manager->flush();
    }

}
