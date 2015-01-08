<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7Legajos
 *
 * @ORM\Table(name="n7_legajos", indexes={@ORM\Index(name="Index_1", columns={"empresa_id"})})
 * @ORM\Entity
 */
class N7Legajos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="empresa_id", type="integer", nullable=false)
     */
    private $empresaId;

    /**
     * @var string
     *
     * @ORM\Column(name="legajo", type="decimal", precision=15, scale=0, nullable=false)
     */
    private $legajo;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_y_nombre", type="string", length=80, nullable=false)
     */
    private $apellidoYNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=240, nullable=false)
     */
    private $foto;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set empresaId
     *
     * @param integer $empresaId
     * @return N7Legajos
     */
    public function setEmpresaId($empresaId)
    {
        $this->empresaId = $empresaId;

        return $this;
    }

    /**
     * Get empresaId
     *
     * @return integer 
     */
    public function getEmpresaId()
    {
        return $this->empresaId;
    }

    /**
     * Set legajo
     *
     * @param string $legajo
     * @return N7Legajos
     */
    public function setLegajo($legajo)
    {
        $this->legajo = $legajo;

        return $this;
    }

    /**
     * Get legajo
     *
     * @return string 
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     * Set apellidoYNombre
     *
     * @param string $apellidoYNombre
     * @return N7Legajos
     */
    public function setApellidoYNombre($apellidoYNombre)
    {
        $this->apellidoYNombre = $apellidoYNombre;

        return $this;
    }

    /**
     * Get apellidoYNombre
     *
     * @return string 
     */
    public function getApellidoYNombre()
    {
        return $this->apellidoYNombre;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return N7Legajos
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }
}
