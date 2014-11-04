<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Factory;

class AddPropiedadEmpresaLiquidacionForm extends Form {
	public function __construct($name = null) {
		parent::__construct ( $name );
		// we want to ignore the name passed
		// parent::__construct('album');
		
		$this->setInputFilter ( new \Application\Form\AddPropiedadEmpresaLiquidacionValidator () );
		
		$this->setAttributes ( array (
				
				// 'action' => $this->url.'/modulo/recibirformulario',
				'action' => "",
				'method' => 'post' 
		) );
		
		$this->add ( array (
				'name' => 'id',
				'type' => 'Hidden' 
		) );
		
		$this->add ( array (
				'name' => 'descripcion',
				'options' => array (
						'label' => 'Propiedad: ' 
				),
				'attributes' => array (
						'type' => 'text',
						'class' => 'input form-control',
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tipo_de_campo',
				'options' => array (
						'label' => 'Tipo: ' 
				),
				'attributes' => array (
						'type' => 'text',
						'class' => 'input form-control',
						'required' => 'required' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Agregar',
						'title' => 'Agregar',
						'class' => 'btn btn-success' 
				) 
		) );
	}
}
?>