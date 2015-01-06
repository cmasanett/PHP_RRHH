<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7EmpresaUsuario
 *
 * @ORM\Table(name="n7_empresa_usuario", indexes={@ORM\Index(name="usuario_id", columns={"usuario_id"}), @ORM\Index(name="empresa_id", columns={"empresa_id"})})
 * @ORM\Entity
 */
class N7EmpresaUsuario
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
     * @var \Application\Entity\N7Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\N7Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \Application\Entity\N7Empresas
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\N7Empresas")
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
     * @param \Application\Entity\N7Usuarios $usuario
     * @return N7EmpresaUsuario
     */
    public function setUsuario(\Application\Entity\N7Usuarios $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Application\Entity\N7Usuarios 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set empresa
     *
     * @param \Application\Entity\N7Empresas $empresa
     * @return N7EmpresaUsuario
     */
    public function setEmpresa(\Application\Entity\N7Empresas $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Application\Entity\N7Empresas 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
