<?php
class Admin_Form_Information extends Zend_Form {

	public function init() {
		$this->setName('information');
		
		$id = $this->createElement('hidden', 'id');
		$pictureId = $this->createElement('hidden', 'picture_id');
		
		$type = $this->createElement('text', 'type')
			->setLabel('Podstrona')
			->setAttrib('disabled', 'disabled');
		$content = $this->createElement('textarea', 'content')
			->setLabel('Treść [pl]')
			->setAttrib('cols', '100');
		$contentEn = $this->createElement('textarea', 'content_en')
			->setLabel('Treść [en]')
			->setAttrib('cols', '100');
		
		$submit = $this->createElement('submit', 'save')
			->setLabel('Zapisz');

		$this->addElements(array(
			$id,
			$pictureId,
			$type,
			$content,
			$contentEn,
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