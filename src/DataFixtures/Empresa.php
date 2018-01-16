<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Empresa implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $arEmpresa = $manager->getRepository('App:Empresa')->find(1);
        if (!$arEmpresa) {
            $arEmpresa = new \App\Entity\Empresa();
            $arEmpresa->setCodigoEmpresaPk(1);
            $arEmpresa->setNombre('PRUEBA');
            $manager->persist($arEmpresa);
        }
        $manager->flush();
    }

}
