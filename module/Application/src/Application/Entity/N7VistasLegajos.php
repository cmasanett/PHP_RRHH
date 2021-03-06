<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7VistasLegajos
 *
 * @ORM\Table(name="n7_vistas_legajos")
 * @ORM\Entity
 */
class N7VistasLegajos
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=60, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="extranet_permitido", type="string", length=1, nullable=false)
     */
    private $extranetPermitido;



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
     * Set descripcion
     *
     * @param string $descripcion
     * @return N7VistasLegajos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set extranetPermitido
     *
     * @param string $extranetPermitido
     * @return N7VistasLegajos
     */
    public function setExtranetPermitido($extranetPermitido)
    {
        $this->extranetPermitido = $extranetPermitido;

        return $this;
    }

    /**
     * Get extranetPermitido
     *
     * @return string 
     */
    public function getExtranetPermitido()
    {
        return $this->extranetPermitido;
    }
}
