<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="movimiento_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoDetalleRepository")
 */
class MovimientoDetalle
{

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
     * @ORM\Column(name="codigo_item_fk", type="integer")
     */
    private $codigoItemFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="vr_precio", type="float",nullable=true)
     */
    private $vrPrecio = 0;

    /**
     * @ORM\Column(name="por_iva", type="float",nullable=true)
     */
    private $porIva = 0;

    /**
     * @ORM\Column(name="por_descuento", type="float",nullable=true)
     */
    private $porDescuento = 0;

    /**
     * @ORM\Column(name="vr_subtotal", type="integer",nullable=true)
     */
    private $vrSubtotal = 0;

    /**
     * @ORM\Column(name="vr_descuento", type="integer",nullable=true)
     */
    private $vrDescuento = 0;

    /**
     * @ORM\Column(name="vr_iva", type="integer",nullable=true)
     */
    private $vrIva = 0;

    /**
     * @ORM\Column(name="vr_total", type="integer",nullable=true)
     */
    private $vrTotal = 0;

    /**
     * @ORM\Column(name="cantidad", type="integer",nullable=true)
     */
    private $cantidad = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Movimiento", inversedBy="movimientosDetallesMovimientoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_fk", referencedColumnName="codigo_movimiento_pk")
     */
    protected $movimientoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="movimientosDetallesItemRel")
     * @ORM\JoinColumn(name="codigo_item_fk", referencedColumnName="codigo_item_pk")
     */
    protected $itemRel;

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
    public function getCodigoItemFk()
    {
        return $this->codigoItemFk;
    }

    /**
     * @param mixed $codigoItemFk
     */
    public function setCodigoItemFk($codigoItemFk): void
    {
        $this->codigoItemFk = $codigoItemFk;
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
    public function getVrPrecio()
    {
        return $this->vrPrecio;
    }

    /**
     * @param mixed $vrPrecio
     */
    public function setVrPrecio($vrPrecio): void
    {
        $this->vrPrecio = $vrPrecio;
    }

    /**
     * @return mixed
     */
    public function getPorIva()
    {
        return $this->porIva;
    }

    /**
     * @param mixed $porIva
     */
    public function setPorIva($porIva): void
    {
        $this->porIva = $porIva;
    }

    /**
     * @return mixed
     */
    public function getPorDescuento()
    {
        return $this->porDescuento;
    }

    /**
     * @param mixed $porDescuento
     */
    public function setPorDescuento($porDescuento): void
    {
        $this->porDescuento = $porDescuento;
    }

    /**
     * @return mixed
     */
    public function getVrSubtotal()
    {
        return $this->vrSubtotal;
    }

    /**
     * @param mixed $vrSubtotal
     */
    public function setVrSubtotal($vrSubtotal): void
    {
        $this->vrSubtotal = $vrSubtotal;
    }

    /**
     * @return mixed
     */
    public function getVrDescuento()
    {
        return $this->vrDescuento;
    }

    /**
     * @param mixed $vrDescuento
     */
    public function setVrDescuento($vrDescuento): void
    {
        $this->vrDescuento = $vrDescuento;
    }

    /**
     * @return mixed
     */
    public function getVrIva()
    {
        return $this->vrIva;
    }

    /**
     * @param mixed $vrIva
     */
    public function setVrIva($vrIva): void
    {
        $this->vrIva = $vrIva;
    }

    /**
     * @return mixed
     */
    public function getVrTotal()
    {
        return $this->vrTotal;
    }

    /**
     * @param mixed $vrTotal
     */
    public function setVrTotal($vrTotal): void
    {
        $this->vrTotal = $vrTotal;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
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

    /**
     * @return mixed
     */
    public function getItemRel()
    {
        return $this->itemRel;
    }

    /**
     * @param mixed $itemRel
     */
    public function setItemRel($itemRel): void
    {
        $this->itemRel = $itemRel;
    }

}
