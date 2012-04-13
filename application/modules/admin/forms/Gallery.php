<?php
class Admin_Form_Gallery extends Zend_Form {

	public function init() {
		$this->setName('gallery');
		
		$id = $this->createElement('hidden', 'id');

		$folderName = $this->createElement('text', 'folder_name')
			->setLabel('Nazwa Galerii');
		
		$submit = $this->createElement('submit', 'save')
			->setLabel('Zapisz galerię');

		$this->addElements(array(
			$id,
			$folderName,
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