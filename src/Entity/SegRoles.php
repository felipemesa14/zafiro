<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SegRolesRepository")
 */
class SegRoles
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_rol_pk", type="string", length=50)
     */
    private $codigoRolPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=150, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="rolRel")
     */
    protected $usersRolRel;

    /**
     * @return mixed
     */
    public function getCodigoRolPk()
    {
        return $this->codigoRolPk;
    }

    /**
     * @param mixed $codigoRolPk
     */
    public function setCodigoRolPk($codigoRolPk): void
    {
        $this->codigoRolPk = $codigoRolPk;
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
    public function getUsersRolRel()
    {
        return $this->usersRolRel;
    }

    /**
     * @param mixed $usersRolRel
     */
    public function setUsersRolRel($usersRolRel): void
    {
        $this->usersRolRel = $usersRolRel;
    }
}
