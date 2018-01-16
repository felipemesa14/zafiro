<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MovimientoTipo implements FixtureInterface {

    public function load(ObjectManager $manager) {
        $arMovimientoTipo = $manager->getRepository('App:MovimientoTipo')->find(1);
        if (!$arMovimientoTipo) {
            $arMovimientoTipo = new \App\Entity\MovimientoTipo();
            $arMovimientoTipo->setCodigoMovimientoTipoPk(1);
            $arMovimientoTipo->setNombre('FACTURA DE VENTA');
            $manager->persist($arMovimientoTipo);
        }

        $arMovimientoTipo = $manager->getRepository('App:MovimientoTipo')->find(2);
        if (!$arMovimientoTipo) {
            $arMovimientoTipo = new \App\Entity\MovimientoTipo();
            $arMovimientoTipo->setCodigoMovimientoTipoPk(2);
            $arMovimientoTipo->setNombre('COMPRA');
            $manager->persist($arMovimientoTipo);
        }
        $manager->flush();
    }

}
