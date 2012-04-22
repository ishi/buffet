<?php
class Admin_Form_Photo extends Zend_Form {

	public function init() {
		$this->setAttrib('enctype', 'multipart/form-data');
		$this->setName('gallery');
		
		$id = $this->createElement('hidden', 'id');
		$galleryId = $this->createElement('hidden', 'gallery_id');

		$file = $this->createElement('file', 'file')
			->setLabel('Obrazek do uploudu');
		
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
				array('HtmlTag', array('tag' => 'table', 'class' => 'gallery')),
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
		$galleryId->setDecorators(array('ViewHelper'));
		$file->setDecorators(array(
			'File',
			array('Errors'),
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
			));
		$submit->setDecorators(array(
			'ViewHelper', 
			array('HtmlTag', array('tag' => 'td')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))));
	}
}