<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7ValoresPosiblesFamiliares
 *
 * @ORM\Table(name="n7_valores_posibles_familiares", indexes={@ORM\Index(name="Index_2", columns={"propiedad_id"})})
 * @ORM\Entity
 */
class N7ValoresPosiblesFamiliares
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
     * @ORM\Column(name="valor_posible", type="string", length=120, nullable=false)
     */
    private $valorPosible;

    /**
     * @var string
     *
     * @ORM\Column(name="significado", type="string", length=120, nullable=false)
     */
    private $significado;

    /**
     * @var \Application\Entity\N7PropiedadesF
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\N7PropiedadesF")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="propiedad_id", referencedColumnName="id")
     * })
     */
    private $propiedad;



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
     * Set valorPosible
     *
     * @param string $valorPosible
     * @return N7ValoresPosiblesFamiliares
     */
    public function setValorPosible($valorPosible)
    {
        $this->valorPosible = $valorPosible;

        return $this;
    }

    /**
     * Get valorPosible
     *
     * @return string 
     */
    public function getValorPosible()
    {
        return $this->valorPosible;
    }

    /**
     * Set significado
     *
     * @param string $significado
     * @return N7ValoresPosiblesFamiliares
     */
    public function setSignificado($significado)
    {
        $this->significado = $significado;

        return $this;
    }

    /**
     * Get significado
     *
     * @return string 
     */
    public function getSignificado()
    {
        return $this->significado;
    }

    /**
     * Set propiedad
     *
     * @param \Application\Entity\N7PropiedadesF $propiedad
     * @return N7ValoresPosiblesFamiliares
     */
    public function setPropiedad(\Application\Entity\N7PropiedadesF $propiedad = null)
    {
        $this->propiedad = $propiedad;

        return $this;
    }

    /**
     * Get propiedad
     *
     * @return \Application\Entity\N7PropiedadesF 
     */
    public function getPropiedad()
    {
        return $this->propiedad;
    }
}
