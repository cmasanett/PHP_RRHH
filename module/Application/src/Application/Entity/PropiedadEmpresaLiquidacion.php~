<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Propiedad EmpresaLiquidacion.
 *
 * @ORM\Entity
 * @ORM\Table(name="n7_propiedades_e")
 *
 * @property int $id
 * @property string $descripcion
 * @property string $tipo_de_campo
 */
class PropiedadEmpresaLiquidacion implements InputFilterAwareInterface {
	protected $inputFilter;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $descripcion;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $tipo_de_campo;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set descripcion
	 *
	 * @param string $descripcion        	
	 * @return PropiedadEmpresaLiquidacion
	 */
	public function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
		
		return $this;
	}
	
	/**
	 * Get descripcion
	 *
	 * @return string
	 */
	public function getDescripcion() {
		return $this->descripcion;
	}
	
	/**
	 * Set tipo_de_campo
	 *
	 * @param string $tipo_de_campo        	
	 * @return PropiedadEmpresaLiquidacion
	 */
	public function setTipo($tipo_de_campo) {
		$this->tipo_de_campo = $tipo_de_campo;
		
		return $this;
	}
	
	/**
	 * Get tipo_de_campo
	 *
	 * @return string
	 */
	public function getTipo() {
		return $this->tipo_de_campo;
	}
	
	/**
	 * Magic getter to expose protected properties.
	 *
	 * @param string $property        	
	 * @return mixed
	 */
	public function __get($property) {
		return $this->$property;
	}
	
	/**
	 * Magic setter to save protected properties.
	 *
	 * @param string $property        	
	 * @param mixed $value        	
	 */
	public function __set($property, $value) {
		$this->$property = $value;
	}
	
	/**
	 * Convert the object to an array.
	 *
	 * @return array
	 */
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data        	
	 */
	public function exchangeArray($data) {
		$this->id = $data ['id'];
		$this->descripcion = $data ['descripcion'];
		$this->tipo_de_campo = $data ['tipo_de_campo'];
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			
			// $inputFilter->add ( array (
			// 'name' => 'id',
			// 'required' => true,
			// 'filters' => array (
			// array (
			// 'name' => 'Int'
			// )
			// )
			// ) );
			
			$inputFilter->add ( array (
					'name' => 'descripcion',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 80
									) 
							) 
					) 
			) );
			
			$inputFilter->add ( array (
					'name' => 'tipo_de_campo',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 1 
									) 
							) 
					) 
			) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}

    /**
     * Set tipo_de_campo
     *
     * @param string $tipoDeCampo
     * @return PropiedadEmpresaLiquidacion
     */
    public function setTipoDeCampo($tipoDeCampo)
    {
        $this->tipo_de_campo = $tipoDeCampo;

        return $this;
    }

    /**
     * Get tipo_de_campo
     *
     * @return string 
     */
    public function getTipoDeCampo()
    {
        return $this->tipo_de_campo;
    }
}
