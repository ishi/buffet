<?php
class Application_Form_Newsletter extends Zend_Form {

	public function init() {

		$this->setName('newsletter');
		$id = $this->createElement('hidden', 'id');

		$email = $this->createElement('text', 'email')
			->setLabel('E-mail');
			
		$submit = $this->createElement('submit', 'save')
			->setLabel('Zapisz e-mail');

		$this->addElements(array(
			$id,
			$email,
			$submit
		));

		$this->setDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'table')),
				'Form'
		));

		$this->setElementDecorators(array(
			array('ViewHelper'),
			array('Errors'),
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		));

		$id->setDecorators(array('ViewHelper'));
		$submit->setDecorators(array(
			'ViewHelper', 
			array('HtmlTag', array('tag' => 'td')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))));
	}
}