<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7PpdL
 *
 * @ORM\Table(name="n7_ppd_l", indexes={@ORM\Index(name="Index_3", columns={"propiedad_id"}), @ORM\Index(name="Index_2", columns={"objeto_id"}), @ORM\Index(name="Index_4", columns={"objeto_id", "propiedad_id"})})
 * @ORM\Entity
 */
class N7PpdL
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
     * @ORM\Column(name="objeto_id", type="integer", nullable=false)
     */
    private $objetoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="propiedad_id", type="integer", nullable=false)
     */
    private $propiedadId;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=120, nullable=false)
     */
    private $valor;



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
     * Set objetoId
     *
     * @param integer $objetoId
     * @return N7PpdL
     */
    public function setObjetoId($objetoId)
    {
        $this->objetoId = $objetoId;

        return $this;
    }

    /**
     * Get objetoId
     *
     * @return integer 
     */
    public function getObjetoId()
    {
        return $this->objetoId;
    }

    /**
     * Set propiedadId
     *
     * @param integer $propiedadId
     * @return N7PpdL
     */
    public function setPropiedadId($propiedadId)
    {
        $this->propiedadId = $propiedadId;

        return $this;
    }

    /**
     * Get propiedadId
     *
     * @return integer 
     */
    public function getPropiedadId()
    {
        return $this->propiedadId;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return N7PpdL
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }
}
