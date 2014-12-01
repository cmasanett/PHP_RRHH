<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7PropiedadesL
 *
 * @ORM\Table(name="n7_propiedades_l", indexes={@ORM\Index(name="Index_2", columns={"descripcion"})})
 * @ORM\Entity
 */
class N7PropiedadesL
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
     * @ORM\Column(name="descripcion", type="string", length=80, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_de_campo", type="string", length=1, nullable=false)
     */
    private $tipoDeCampo;



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
     * @return N7PropiedadesL
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
     * Set tipoDeCampo
     *
     * @param string $tipoDeCampo
     * @return N7PropiedadesL
     */
    public function setTipoDeCampo($tipoDeCampo)
    {
        $this->tipoDeCampo = $tipoDeCampo;

        return $this;
    }

    /**
     * Get tipoDeCampo
     *
     * @return string 
     */
    public function getTipoDeCampo()
    {
        return $this->tipoDeCampo;
    }
}
