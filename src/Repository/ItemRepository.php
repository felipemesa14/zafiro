<?php

namespace App\Repository;

use App\Entity\Item;
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
        $em = $this->getEntityManager();
        $strRespuesta = "";
        if (count($arrSeleccionados) > 0) {
            foreach ($arrSeleccionados as $codigoItem) {
                //Realizar validacion al momento de relacionar el detalle de la factura con los items
                $arMovimientoDetalle = $em->getRepository("App:MovimientoDetalle")->findBy(array('codigoItemFk' => $codigoItem));
                if (!$arMovimientoDetalle) {
                    $arItem = $em->getRepository('App:Item')->find($codigoItem);
                    $em->remove($arItem);
                } else {
                    $strRespuesta = "El item se encuentra asociado a un movimiento, no se puede eliminar.";
                }
            }
        }
        return $strRespuesta;
    }
}
