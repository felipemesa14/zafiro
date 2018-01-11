<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoTipo
 *
 * @ORM\Table(name="movimiento_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoTipoRepository")
 */
class MovimientoTipo
{
    /**
     * @var int
     *
     * @ORM\Column(name="codigo_movimiento_tipo_pk", type="integer")
     * @ORM\Id
     */
    private $codigoMovimientoTipoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="movimientoTipoRel")
     */
    protected $movimientosMovimientoTipoRel;

    /**
     * @return int
     */
    public function getCodigoMovimientoTipoPk(): int
    {
        return $this->codigoMovimientoTipoPk;
    }

    /**
     * @param int $codigoMovimientoTipoPk
     */
    public function setCodigoMovimientoTipoPk(int $codigoMovimientoTipoPk): void
    {
        $this->codigoMovimientoTipoPk = $codigoMovimientoTipoPk;
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
     * @return mixed
     */
    public function getMovimientosMovimientoTipoRel()
    {
        return $this->movimientosMovimientoTipoRel;
    }

    /**
     * @param mixed $movimientosMovimientoTipoRel
     */
    public function setMovimientosMovimientoTipoRel($movimientosMovimientoTipoRel): void
    {
        $this->movimientosMovimientoTipoRel = $movimientosMovimientoTipoRel;
    }


}
