<?php
class Admin_Form_Event extends Zend_Form {

	public function init() {
		$this->setName('event');
		$this->setDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'table')),
				'Form'
		));

		// Tworzymy elementy formularza	
		$this->addElements(array(
			array('checkbox', 'event_news', 
				array(	'label' => 'News',
					'checkedValue'=>'T', 
					'uncheckedValue'=>'N')),
			array('checkbox', 'event_announcement', 
				array(	'label' => 'Zapowiedź',
					'checkedValue'=>'T',
			 		'uncheckedValue'=>'N')),
			array('text', 'date_from', 
				array(	'label' => 'Data (od)')),
			array('text', 'date_to', 
				array(	'label' => 'Data (do)')),
			// Hack aby wyświetlić nagłówki dla kolumn językowych
			array('hidden', 'test', 
				array(
    					'description' => '<tr><td></td><td>PL</td><td>EN</td></tr>',
    					'ignore' => true)),
			array('text', 'title', array('label' => 'Tytuł')),
			array('text', 'title_en'),
			array('textarea', 'pre_content_pl', array('label' => 'Zajawka')),
			array('textarea', 'pre_content_en'),
			array('textarea', 'content_pl', array('label' => 'Treść')),
			array('textarea', 'content_en')
		));
		// Elementy językowe wyświetlamy w dwóch kolumnach, tworzymy grupy kolumn
		$this->addDisplayGroup(array('title', 'title_en'), 'title_group');
		$this->addDisplayGroup(array('pre_content_pl', 'pre_content_en'), 'pre_content_group');
		$this->addDisplayGroup(array('content_pl', 'content_en'), 'content_group');

		// Domyślne dekoratory
		$this->setElementDecorators(array(
				array('ViewHelper'),
				array('Errors'),
				array('HtmlTag', array('tag' => 'td')),
				array('Label', array('tag' => 'td')),
				array(array('row' => 'HtmlTag'), array('tag' => 'tr'))))
			// Dekoratory dla pierwszej kolumny pól językowych
			->setElementDecorators(array(
					array('ViewHelper'),
					array('Errors'),
					array('HtmlTag', array('tag' => 'td')),
					array('Label', array('tag' => 'td'))),
				array('title', 'pre_content_pl', 'content_pl'))
			// Dekoratory dla pozostałych kolumn pól językowych
			->setElementDecorators(array(
					array('ViewHelper'),
					array('Errors'),
					array('HtmlTag', array('tag' => 'td'))),
				 array('title_en', 'pre_content_en', 'content_en'))
			// Hack dekorator
			->setElementDecorators(array(array('Description', array('escape'=>false, 'tag'=>''))), array('test'))
			// Dekoratory dla grup językowych
			->setDisplayGroupDecorators(array(
        			'FormElements',
				array(array('row' => 'HtmlTag'), array('tag' => 'tr'))));
		
		
		// Upload plików, każdy w osobnym wierszu
		$file = $this->createElement('file', 'file')
			->setLabel('Zdjęcie duże')
			->addDecorators(array(
				array('HtmlTag', array('tag' => 'td')),
				array('Label', array('tag' => 'td')),
				array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$file2 = $this->createElement('file', 'file2')
			->setLabel('Zdjęcie małe')
			->addDecorators(array(
				array('HtmlTag', array('tag' => 'td')),
				array('Label', array('tag' => 'td')),
				array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));

		$submit = $this->createElement('submit', 'save', 
			array('label' => 'Zapisz', 'class' => 'button'))
			->addDecorator('HtmlTag', array('tag' => 'td', 'colspan' => '3'));
		$this->addElements(array($file, $file2, $submit));
		
		//elementy ukryte
		$this->addElements(array(
			array('hidden', 'id', array('decorators' => array('ViewHelper'))),
			array('hidden', 'picture_id', array('decorators' => array('ViewHelper')))
		));
	}
}
