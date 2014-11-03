<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;

class AddPropiedadValidator extends InputFilter {
	public function __construct() {
		$this->add ( array (
				'name' => 'descripcion',
				'required' => true,
				'filters' => array (
						array (
								'name' => 'HtmlEntities' 
						),
						array (
								'name' => 'StripTags' 
						),
						array (
								'name' => 'StringTrim' 
						) 
				),
				'validators' => array (
						array (
								'name' => 'Alpha',
								'options' => array (
										'allowWhiteSpace' => true,
										'messages' => array (
												I18nValidator\Alpha::INVALID => 'El nombre de la propiedad puede estar formado por letras.',
												I18nValidator\Alpha::NOT_ALPHA => 'El nombre de la propiedad sólo puede estar formado por letras.',
												I18nValidator\Alpha::STRING_EMPTY => 'El nombre de la propiedad no puede estar vacío.' 
										)
										// I18nValidator\Alpha::NOT_ALNUM=>'Tu nombre esta mal',
										 
								) 
						) 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tipo_de_campo',
				'required' => true,
				'filters' => array (
						array (
								'name' => 'HtmlEntities' 
						),
						array (
								'name' => 'StripTags' 
						),
						array (
								'name' => 'StringTrim' 
						) 
				),
				'validators' => array (
						array (
								'name' => 'Alpha',
								'options' => array (
										'allowWhiteSpace' => false,
										'messages' => array (
												I18nValidator\Alpha::INVALID => 'El tipo de campo sólo puede estar formado por letras.',
												I18nValidator\Alpha::NOT_ALPHA => 'El tipo de campo sólo puede estar formado por letras.',
												I18nValidator\Alpha::STRING_EMPTY => 'El tipo de campo no puede estar vacío.' 
										)
										// I18nValidator\Alpha::NOT_ALNUM=>'Tu nombre esta mal',
										 
								) 
						) 
				) 
		) );
	}
}
?>