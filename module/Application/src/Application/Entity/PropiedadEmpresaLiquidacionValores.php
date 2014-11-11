<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Propiedad EmpresaLiquidacionValores.
 *
 * @ORM\Entity
 * @ORM\Table(name="n7_valores_posibles_empresas")
 * 
 * @property int $id
 * @property int $propiedad_id
 * @property string $valor_posible
 * @property string $significado
 */
class PropiedadEmpresaLiquidacionValores implements InputFilterAwareInterface {
	protected $inputFilter;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="integer");
	 */
	protected $propiedad_id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $valor_posible;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $significado;
	
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
	 * Set propiedad_id
	 *
	 * @param int $propiedad_id
	 * @return PropiedadEmpresaLiquidacionValores
	 */
	public function setPropiedadId($propiedad_id)
	{
		$this->propiedad_id = $propiedad_id;
		 
		return $this;
	}
	
	/**
	 * Get propiedad_id
	 *
	 * @return int
	 */
	public function getPropiedadId()
	{
		return $this->propiedad_id;
	}
	
	/**
	 * Set valor_posible
	 *
	 * @param string $valor_posible
	 * @return PropiedadEmpresaLiquidacionValores
	 */
	public function setValorPosible($valor_posible)
	{
		$this->valor_posible = $valor_posible;
		 
		return $this;
	}
	
	/**
	 * Get valor_posible
	 *
	 * @return string
	 */
	public function getValorPosible()
	{
		return $this->valor_posible;
	}
	
	/**
	 * Set significado
	 *
	 * @param string $significado
	 * @return PropiedadEmpresaLiquidacionValores
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
		$this->propiedad_id = $data ['propiedad_id'];
		$this->valor_posible = $data ['valor_posible'];
		$this->significado = $data ['significado'];
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			
// 			$inputFilter->add ( array (
// 					'name' => 'id',
// 					'required' => true,
// 					'filters' => array (
// 							array (
// 									'name' => 'Int' 
// 							) 
// 					) 
// 			) );

			$inputFilter->add ( array (
					'name' => 'propiedad_id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int'
							)
					)
			) );
			
			$inputFilter->add ( array (
					'name' => 'valor_posible',
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
											'max' => 120 
									) 
							) 
					) 
			) );
			
			$inputFilter->add ( array (
					'name' => 'significado',
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
											'max' => 120 
									) 
							) 
					) 
			) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}
