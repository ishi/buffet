<?php
class Admin_Form_Photo extends Zend_Form {

	public function init() {
		$this->setAttrib('enctype', 'multipart/form-data');
		$this->setName('gallery');
		
		$id = $this->createElement('hidden', 'id');
		$galleryId = $this->createElement('hidden', 'galleryId');

		$file = $this->createElement('file', 'file[]')
			->setAttrib('multiple', true)
			->setLabel('Zdjęcie')
			->setValueDisabled(true)
			->setRequired()
			// only JPEG, PNG, and GIFs
			->addValidator('Extension', false, 'jpg,png,gif,zip');
		
		$submit = $this->createElement('submit', 'save')
			->setLabel('Dodaj zdjęcie')
			->setOptions(array('class' => 'button'));

		$this->addElements(array(
			$id,
			$galleryId,
			$file,
			$submit
		));

		$this->setDecorators(array(
				'FormElements',
				'Form'
		));
		
		$this->setElementDecorators(array('ViewHelper', 'Errors', 'Label'));
		
		$id->setDecorators(array('ViewHelper'));
		$galleryId->setDecorators(array('ViewHelper'));
		$file->setDecorators(array('File', 'Errors'));
		$submit->setDecorators(array('ViewHelper'));	
	}
}