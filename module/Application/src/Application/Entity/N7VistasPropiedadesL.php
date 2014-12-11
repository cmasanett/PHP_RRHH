<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7VistasPropiedadesL
 *
 * @ORM\Table(name="n7_vistas_propiedades_l", indexes={@ORM\Index(name="Index_2", columns={"propiedad_id"}), @ORM\Index(name="Index_3", columns={"formulario_id"})})
 * @ORM\Entity
 */
class N7VistasPropiedadesL
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
     * @ORM\Column(name="propiedad_id", type="integer", nullable=false)
     */
    private $propiedadId;

    /**
     * @var integer
     *
     * @ORM\Column(name="formulario_id", type="integer", nullable=false)
     */
    private $formularioId;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="smallint", nullable=false)
     */
    private $orden;

    /**
     * @var string
     *
     * @ORM\Column(name="solo_lectura", type="string", length=1, nullable=false)
     */
    private $soloLectura;



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
     * Set propiedadId
     *
     * @param integer $propiedadId
     * @return N7VistasPropiedadesL
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
     * Set formularioId
     *
     * @param integer $formularioId
     * @return N7VistasPropiedadesL
     */
    public function setFormularioId($formularioId)
    {
        $this->formularioId = $formularioId;

        return $this;
    }

    /**
     * Get formularioId
     *
     * @return integer 
     */
    public function getFormularioId()
    {
        return $this->formularioId;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return N7VistasPropiedadesL
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set soloLectura
     *
     * @param string $soloLectura
     * @return N7VistasPropiedadesL
     */
    public function setSoloLectura($soloLectura)
    {
        $this->soloLectura = $soloLectura;

        return $this;
    }

    /**
     * Get soloLectura
     *
     * @return string 
     */
    public function getSoloLectura()
    {
        return $this->soloLectura;
    }
}
