<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * N7Empresas
 *
 * @ORM\Table(name="n7_empresas")
 * @ORM\Entity
 */
class N7Empresas
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
     * @ORM\Column(name="codigo", type="string", length=4, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=120, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=200, nullable=false)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=200, nullable=false)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_postal", type="string", length=10, nullable=false)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=30, nullable=false)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="email_administrador", type="string", length=200, nullable=false)
     */
    private $emailAdministrador;

    /**
     * @var string
     *
     * @ORM\Column(name="inactiva", type="string", length=1, nullable=false)
     */
    private $inactiva = '';

    /**
     * @var string
     *
     * @ORM\Column(name="v1", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v1;

    /**
     * @var string
     *
     * @ORM\Column(name="v2", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v2;

    /**
     * @var string
     *
     * @ORM\Column(name="v3", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v3;

    /**
     * @var string
     *
     * @ORM\Column(name="v4", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v4;

    /**
     * @var string
     *
     * @ORM\Column(name="v5", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v5;

    /**
     * @var string
     *
     * @ORM\Column(name="v6", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v6;

    /**
     * @var string
     *
     * @ORM\Column(name="v7", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v7;

    /**
     * @var string
     *
     * @ORM\Column(name="v8", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v8;

    /**
     * @var string
     *
     * @ORM\Column(name="v9", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v9;

    /**
     * @var string
     *
     * @ORM\Column(name="v10", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v10;

    /**
     * @var string
     *
     * @ORM\Column(name="v11", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v11;

    /**
     * @var string
     *
     * @ORM\Column(name="v12", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v12;

    /**
     * @var string
     *
     * @ORM\Column(name="v13", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v13;

    /**
     * @var string
     *
     * @ORM\Column(name="v14", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v14;

    /**
     * @var string
     *
     * @ORM\Column(name="v15", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v15;

    /**
     * @var string
     *
     * @ORM\Column(name="v16", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v16;

    /**
     * @var string
     *
     * @ORM\Column(name="v17", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v17;

    /**
     * @var string
     *
     * @ORM\Column(name="v18", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v18;

    /**
     * @var string
     *
     * @ORM\Column(name="v19", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v19;

    /**
     * @var string
     *
     * @ORM\Column(name="v20", type="decimal", precision=12, scale=4, nullable=false)
     */
    private $v20;

    /**
     * @var integer
     *
     * @ORM\Column(name="dato_legajo_baja", type="integer", nullable=false)
     */
    private $datoLegajoBaja;

    /**
     * @var string
     *
     * @ORM\Column(name="comparacion", type="string", length=10, nullable=false)
     */
    private $comparacion;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_dato_baja", type="string", length=120, nullable=false)
     */
    private $valorDatoBaja;



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
     * Set codigo
     *
     * @param string $codigo
     * @return N7Empresas
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return N7Empresas
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     * @return N7Empresas
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return N7Empresas
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     * @return N7Empresas
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string 
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return N7Empresas
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set emailAdministrador
     *
     * @param string $emailAdministrador
     * @return N7Empresas
     */
    public function setEmailAdministrador($emailAdministrador)
    {
        $this->emailAdministrador = $emailAdministrador;

        return $this;
    }

    /**
     * Get emailAdministrador
     *
     * @return string 
     */
    public function getEmailAdministrador()
    {
        return $this->emailAdministrador;
    }

    /**
     * Set inactiva
     *
     * @param string $inactiva
     * @return N7Empresas
     */
    public function setInactiva($inactiva)
    {
        $this->inactiva = $inactiva;

        return $this;
    }

    /**
     * Get inactiva
     *
     * @return string 
     */
    public function getInactiva()
    {
        return $this->inactiva;
    }

    /**
     * Set v1
     *
     * @param string $v1
     * @return N7Empresas
     */
    public function setV1($v1)
    {
        $this->v1 = $v1;

        return $this;
    }

    /**
     * Get v1
     *
     * @return string 
     */
    public function getV1()
    {
        return $this->v1;
    }

    /**
     * Set v2
     *
     * @param string $v2
     * @return N7Empresas
     */
    public function setV2($v2)
    {
        $this->v2 = $v2;

        return $this;
    }

    /**
     * Get v2
     *
     * @return string 
     */
    public function getV2()
    {
        return $this->v2;
    }

    /**
     * Set v3
     *
     * @param string $v3
     * @return N7Empresas
     */
    public function setV3($v3)
    {
        $this->v3 = $v3;

        return $this;
    }

    /**
     * Get v3
     *
     * @return string 
     */
    public function getV3()
    {
        return $this->v3;
    }

    /**
     * Set v4
     *
     * @param string $v4
     * @return N7Empresas
     */
    public function setV4($v4)
    {
        $this->v4 = $v4;

        return $this;
    }

    /**
     * Get v4
     *
     * @return string 
     */
    public function getV4()
    {
        return $this->v4;
    }

    /**
     * Set v5
     *
     * @param string $v5
     * @return N7Empresas
     */
    public function setV5($v5)
    {
        $this->v5 = $v5;

        return $this;
    }

    /**
     * Get v5
     *
     * @return string 
     */
    public function getV5()
    {
        return $this->v5;
    }

    /**
     * Set v6
     *
     * @param string $v6
     * @return N7Empresas
     */
    public function setV6($v6)
    {
        $this->v6 = $v6;

        return $this;
    }

    /**
     * Get v6
     *
     * @return string 
     */
    public function getV6()
    {
        return $this->v6;
    }

    /**
     * Set v7
     *
     * @param string $v7
     * @return N7Empresas
     */
    public function setV7($v7)
    {
        $this->v7 = $v7;

        return $this;
    }

    /**
     * Get v7
     *
     * @return string 
     */
    public function getV7()
    {
        return $this->v7;
    }

    /**
     * Set v8
     *
     * @param string $v8
     * @return N7Empresas
     */
    public function setV8($v8)
    {
        $this->v8 = $v8;

        return $this;
    }

    /**
     * Get v8
     *
     * @return string 
     */
    public function getV8()
    {
        return $this->v8;
    }

    /**
     * Set v9
     *
     * @param string $v9
     * @return N7Empresas
     */
    public function setV9($v9)
    {
        $this->v9 = $v9;

        return $this;
    }

    /**
     * Get v9
     *
     * @return string 
     */
    public function getV9()
    {
        return $this->v9;
    }

    /**
     * Set v10
     *
     * @param string $v10
     * @return N7Empresas
     */
    public function setV10($v10)
    {
        $this->v10 = $v10;

        return $this;
    }

    /**
     * Get v10
     *
     * @return string 
     */
    public function getV10()
    {
        return $this->v10;
    }

    /**
     * Set v11
     *
     * @param string $v11
     * @return N7Empresas
     */
    public function setV11($v11)
    {
        $this->v11 = $v11;

        return $this;
    }

    /**
     * Get v11
     *
     * @return string 
     */
    public function getV11()
    {
        return $this->v11;
    }

    /**
     * Set v12
     *
     * @param string $v12
     * @return N7Empresas
     */
    public function setV12($v12)
    {
        $this->v12 = $v12;

        return $this;
    }

    /**
     * Get v12
     *
     * @return string 
     */
    public function getV12()
    {
        return $this->v12;
    }

    /**
     * Set v13
     *
     * @param string $v13
     * @return N7Empresas
     */
    public function setV13($v13)
    {
        $this->v13 = $v13;

        return $this;
    }

    /**
     * Get v13
     *
     * @return string 
     */
    public function getV13()
    {
        return $this->v13;
    }

    /**
     * Set v14
     *
     * @param string $v14
     * @return N7Empresas
     */
    public function setV14($v14)
    {
        $this->v14 = $v14;

        return $this;
    }

    /**
     * Get v14
     *
     * @return string 
     */
    public function getV14()
    {
        return $this->v14;
    }

    /**
     * Set v15
     *
     * @param string $v15
     * @return N7Empresas
     */
    public function setV15($v15)
    {
        $this->v15 = $v15;

        return $this;
    }

    /**
     * Get v15
     *
     * @return string 
     */
    public function getV15()
    {
        return $this->v15;
    }

    /**
     * Set v16
     *
     * @param string $v16
     * @return N7Empresas
     */
    public function setV16($v16)
    {
        $this->v16 = $v16;

        return $this;
    }

    /**
     * Get v16
     *
     * @return string 
     */
    public function getV16()
    {
        return $this->v16;
    }

    /**
     * Set v17
     *
     * @param string $v17
     * @return N7Empresas
     */
    public function setV17($v17)
    {
        $this->v17 = $v17;

        return $this;
    }

    /**
     * Get v17
     *
     * @return string 
     */
    public function getV17()
    {
        return $this->v17;
    }

    /**
     * Set v18
     *
     * @param string $v18
     * @return N7Empresas
     */
    public function setV18($v18)
    {
        $this->v18 = $v18;

        return $this;
    }

    /**
     * Get v18
     *
     * @return string 
     */
    public function getV18()
    {
        return $this->v18;
    }

    /**
     * Set v19
     *
     * @param string $v19
     * @return N7Empresas
     */
    public function setV19($v19)
    {
        $this->v19 = $v19;

        return $this;
    }

    /**
     * Get v19
     *
     * @return string 
     */
    public function getV19()
    {
        return $this->v19;
    }

    /**
     * Set v20
     *
     * @param string $v20
     * @return N7Empresas
     */
    public function setV20($v20)
    {
        $this->v20 = $v20;

        return $this;
    }

    /**
     * Get v20
     *
     * @return string 
     */
    public function getV20()
    {
        return $this->v20;
    }

    /**
     * Set datoLegajoBaja
     *
     * @param integer $datoLegajoBaja
     * @return N7Empresas
     */
    public function setDatoLegajoBaja($datoLegajoBaja)
    {
        $this->datoLegajoBaja = $datoLegajoBaja;

        return $this;
    }

    /**
     * Get datoLegajoBaja
     *
     * @return integer 
     */
    public function getDatoLegajoBaja()
    {
        return $this->datoLegajoBaja;
    }

    /**
     * Set comparacion
     *
     * @param string $comparacion
     * @return N7Empresas
     */
    public function setComparacion($comparacion)
    {
        $this->comparacion = $comparacion;

        return $this;
    }

    /**
     * Get comparacion
     *
     * @return string 
     */
    public function getComparacion()
    {
        return $this->comparacion;
    }

    /**
     * Set valorDatoBaja
     *
     * @param string $valorDatoBaja
     * @return N7Empresas
     */
    public function setValorDatoBaja($valorDatoBaja)
    {
        $this->valorDatoBaja = $valorDatoBaja;

        return $this;
    }

    /**
     * Get valorDatoBaja
     *
     * @return string 
     */
    public function getValorDatoBaja()
    {
        return $this->valorDatoBaja;
    }
}
