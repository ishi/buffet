<?php
class Admin_Form_PhotoE extends Zend_Form {

	public function init() {
		$this->setAttrib('enctype', 'multipart/form-data');
		$this->setName('gallery');
		
		$id = $this->createElement('hidden', 'id');
		//->setValue($_SESSION['pict_id']);
		
		$idS = $this->createElement('hidden', 'idS');
		//->setValue($_SESSION['pict_id_small']);
		
		$eventId = $this->createElement('hidden', 'eventId');
		//->setValue($_SESSION['event_id']);
				
		$file = $this->createElement('file', 'file')
		->setLabel('Zdjęcie duże');
		
		$file2 = $this->createElement('file', 'file2')
		->setLabel('Zdjęcie małe');
		
		$submit = $this->createElement('submit', 'save')
			->setLabel('Dodaj zdjęcie')
			->setOptions(array('class' => 'button'));

		$this->addElements(array(
			$id,
			$idS,
			$eventId,
			$file,
			$file2,
			$submit
		));

		$this->setDecorators(array(
				'FormElements',
				//array('HtmlTag', array('tag' => 'table', 'class' => 'gallery')),
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
		$file->setDecorators(array(
			'File',
			array('Errors'),
			array('HtmlTag', array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
			));
		$file2->setDecorators(array(
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