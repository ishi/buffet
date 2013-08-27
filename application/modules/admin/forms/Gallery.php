<?php
class Admin_Form_Gallery extends Zend_Form {

	public function init() {
		$this->setName('gallery');
		
		$id = $this->createElement('hidden', 'id');

		$folderName = $this->createElement('text', 'folder_name')
			->setLabel('Nazwa Galerii');
		$folderContent = $this->createElement('textarea', 'folder_content')
			->setLabel('Opis Galerii');
		
		$folderDate = $this->createElement('text', 'folder_date')
			->setLabel('Data')
			->addValidator('date', false, array('YYYY-MM-dd'));
		
		$submit = $this->createElement('submit', 'save')
			->setLabel('Zapisz galerię')
			->setAttrib('class', 'button');

		$this->addElements(array(
			$id,
			$folderName,
			$folderContent,
			$folderDate,
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
		$submit->setDecorators(array(
			'ViewHelper', 
			array('HtmlTag', array('tag' => 'td')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))));
	}
}