<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="movimiento_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoDetalleRepository")
 */
class MovimientoDetalle {

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoMovimientoDetallePk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer")
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_movimiento_fk", type="integer")
     */
    private $codigoMovimientoFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="Movimiento", inversedBy="movimientosDetallesMovimientoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_fk", referencedColumnName="codigo_movimiento_pk")
     */
    protected $movimientoRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoDetallePk()
    {
        return $this->codigoMovimientoDetallePk;
    }

    /**
     * @param mixed $codigoMovimientoDetallePk
     */
    public function setCodigoMovimientoDetallePk($codigoMovimientoDetallePk): void
    {
        $this->codigoMovimientoDetallePk = $codigoMovimientoDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * @param mixed $codigoEmpresaFk
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk): void
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoMovimientoFk()
    {
        return $this->codigoMovimientoFk;
    }

    /**
     * @param mixed $codigoMovimientoFk
     */
    public function setCodigoMovimientoFk($codigoMovimientoFk): void
    {
        $this->codigoMovimientoFk = $codigoMovimientoFk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getMovimientoRel()
    {
        return $this->movimientoRel;
    }

    /**
     * @param mixed $movimientoRel
     */
    public function setMovimientoRel($movimientoRel): void
    {
        $this->movimientoRel = $movimientoRel;
    }
}
