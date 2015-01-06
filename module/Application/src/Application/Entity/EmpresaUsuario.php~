<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaUsuario
 *
 * @ORM\Table(name="empresa_usuario", indexes={@ORM\Index(name="usuario_id", columns={"usuario_id"}), @ORM\Index(name="empresa_id", columns={"empresa_id"})})
 * @ORM\Entity
 */
class EmpresaUsuario
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
     * @var \Application\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \Application\Entity\Empresas
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Empresas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     * })
     */
    private $empresa;



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
     * Set usuario
     *
     * @param \Application\Entity\Usuarios $usuario
     * @return EmpresaUsuario
     */
    public function setUsuario(\Application\Entity\Usuarios $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Application\Entity\Usuarios 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set empresa
     *
     * @param \Application\Entity\Empresas $empresa
     * @return EmpresaUsuario
     */
    public function setEmpresa(\Application\Entity\Empresas $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Application\Entity\Empresas 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
