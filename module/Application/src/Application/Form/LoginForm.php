<?php
namespace Application\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct($name);

		$this->setAttributes(array(
				'action'=>"",
				'method' => 'post',
				'class'  => 'form-signin'
		));
		
		$this->add(array(
				'name' => 'usuario',
				'attributes' => array(
						'type' => 'text',
						'class' => 'input form-control',
						'required'=>'required'
				)
		));
		 
		$this->add(array(
				'name' => 'clave',
				'attributes' => array(
						'type' => 'password',
						'class' => 'input form-control',
						'required'=>'required'
				)
		));

		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type' => 'submit',
						'value' => 'Entrar',
						'title' => 'Entrar',
						'class' => 'btn btn-lg btn-primary btn-block'
				),
		));
	}
}