<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormaPago
 *
 * @ORM\Table(name="forma_pago")
 * @ORM\Entity(repositoryClass="App\Repository\FormaPagoRepository")
 */
class FormaPago {

    /**
     * @var int
     *
     * @ORM\Column(name="codigo_forma_pago_pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoFormaPagoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="dias", type="integer", length=50)
     */
    private $dias;

    /**
     * @ORM\OneToMany(targetEntity="Tercero", mappedBy="formaPagoRel")
     */
    protected $tercerosFormaPagoRel;

    /**
     * @return int
     */
    public function getCodigoFormaPagoPk(): int
    {
        return $this->codigoFormaPagoPk;
    }

    /**
     * @param int $codigoFormaPagoPk
     */
    public function setCodigoFormaPagoPk(int $codigoFormaPagoPk): void
    {
        $this->codigoFormaPagoPk = $codigoFormaPagoPk;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return int
     */
    public function getDias(): int
    {
        return $this->dias;
    }

    /**
     * @param int $dias
     */
    public function setDias(int $dias): void
    {
        $this->dias = $dias;
    }

    /**
     * @return mixed
     */
    public function getTercerosFormaPagoRel()
    {
        return $this->tercerosFormaPagoRel;
    }

    /**
     * @param mixed $tercerosFormaPagoRel
     */
    public function setTercerosFormaPagoRel($tercerosFormaPagoRel): void
    {
        $this->tercerosFormaPagoRel = $tercerosFormaPagoRel;
    }
}
