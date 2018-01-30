<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="App\Repository\EmpresaRepository")
 */
class Empresa
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoEmpresaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="empresaRel")
     */
    protected $movimientosEmpresaRel;

    /**
     * @ORM\OneToMany(targetEntity="Tercero", mappedBy="empresaRel")
     */
    protected $tercerosEmpresaRel;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="empresaRel")
     */
    protected $itemsEmpresaRel;

    /**
     * @return mixed
     */
    public function getCodigoEmpresaPk()
    {
        return $this->codigoEmpresaPk;
    }

    /**
     * @param mixed $codigoEmpresaPk
     */
    public function setCodigoEmpresaPk($codigoEmpresaPk): void
    {
        $this->codigoEmpresaPk = $codigoEmpresaPk;
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
    public function getMovimientosEmpresaRel()
    {
        return $this->movimientosEmpresaRel;
    }

    /**
     * @param mixed $movimientosEmpresaRel
     */
    public function setMovimientosEmpresaRel($movimientosEmpresaRel): void
    {
        $this->movimientosEmpresaRel = $movimientosEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getTercerosEmpresaRel()
    {
        return $this->tercerosEmpresaRel;
    }

    /**
     * @param mixed $tercerosEmpresaRel
     */
    public function setTercerosEmpresaRel($tercerosEmpresaRel): void
    {
        $this->tercerosEmpresaRel = $tercerosEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getItemsEmpresaRel()
    {
        return $this->itemsEmpresaRel;
    }

    /**
     * @param mixed $itemsEmpresaRel
     */
    public function setItemsEmpresaRel($itemsEmpresaRel): void
    {
        $this->itemsEmpresaRel = $itemsEmpresaRel;
    }

}
