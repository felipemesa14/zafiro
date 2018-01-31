<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_item_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoItemPk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer")
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_bodega_fk", type="integer", nullable=true)
     */
    private $codigoBodegaFk;

    /**
     * @ORM\Column(name="nombre", type="text", nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="referencia", type="text", nullable=true)
     */
    private $referencia;

    /**
     * @ORM\Column(name="vr_precio", type="float")
     */
    private $vrPrecio = 0;

    /**
     * @ORM\Column(name="porcentaje", type="float")
     */
    private $porcentaje = 0;

    /**
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad = 0;

    /**
     * @ORM\Column(name="url_imagen", type="text",nullable=true)
     */
    private $urlImagen;

    /**
     * @ORM\Column(name="descripcion", type="text",nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="itemsEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;

    /**
     * @ORM\OneToMany(targetEntity="MovimientoDetalle", mappedBy="itemRel")
     */
    protected $movimientosDetallesItemRel;

    /**
     * @return mixed
     */
    public function getCodigoItemPk()
    {
        return $this->codigoItemPk;
    }

    /**
     * @param mixed $codigoItemPk
     */
    public function setCodigoItemPk($codigoItemPk): void
    {
        $this->codigoItemPk = $codigoItemPk;
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
    public function getCodigoBodegaFk()
    {
        return $this->codigoBodegaFk;
    }

    /**
     * @param mixed $codigoBodegaFk
     */
    public function setCodigoBodegaFk($codigoBodegaFk): void
    {
        $this->codigoBodegaFk = $codigoBodegaFk;
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
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param mixed $referencia
     */
    public function setReferencia($referencia): void
    {
        $this->referencia = $referencia;
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
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * @param mixed $porcentaje
     */
    public function setPorcentaje($porcentaje): void
    {
        $this->porcentaje = $porcentaje;
    }

    /**
     * @return mixed
     */
    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    /**
     * @param mixed $urlImagen
     */
    public function setUrlImagen($urlImagen): void
    {
        $this->urlImagen = $urlImagen;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getEmpresaRel()
    {
        return $this->empresaRel;
    }

    /**
     * @param mixed $empresaRel
     */
    public function setEmpresaRel($empresaRel): void
    {
        $this->empresaRel = $empresaRel;
    }

    /**
     * @return mixed
     */
    public function getMovimientosDetallesItemRel()
    {
        return $this->movimientosDetallesItemRel;
    }

    /**
     * @param mixed $movimientosDetallesItemRel
     */
    public function setMovimientosDetallesItemRel($movimientosDetallesItemRel): void
    {
        $this->movimientosDetallesItemRel = $movimientosDetallesItemRel;
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

}
