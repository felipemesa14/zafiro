<?php

namespace App\Repository;

use App\Entity\Item;
use App\Funciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function listaDql($codigoEmpresa, $nombre = "", $referencia = "")
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
            ->from("App:Item", "item")
            ->select("item")
            ->where("item.codigoEmpresaFk = {$codigoEmpresa}");
        if ($nombre) {
            $qb->andWhere("item.nombre = '{$nombre}'");
        }
        if ($referencia) {
            $qb->andWhere("item.referencia = '{$referencia}'");
        }

        return $qb->getQuery()->execute();
    }

    public function eliminar($arrSeleccionados)
    {
        $objMensaje = new Funciones();
        $em = $this->getEntityManager();
        if ($arrSeleccionados > 0) {
            try {
                foreach ($arrSeleccionados as $codigoItem) {
                    $arItem = $em->getRepository('App:Item')->find($codigoItem);
                    $em->remove($arItem);
                }
                $em->flush();
            } catch (\Exception $exception) {
                $objMensaje->Mensaje("error", "No se puede eliminar el registro, se esta utilizando en el sistema.");
            }
        }
    }
}
