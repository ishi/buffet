<?php
class Admin_Form_Event extends Zend_Form {

	public function init() {
		$this->setName('event');
		
		$id = $this->createElement('hidden', 'id');
		$pictureId = $this->createElement('hidden', 'picture_id');
		
		$eventNews = $this->createElement('checkbox', 'event_news', array('checkedValue'=>'T', 'uncheckedValue'=>'N'))
			->setLabel('News');
		$eventAnnouncement = $this->createElement('checkbox', 'event_announcement', array('checkedValue'=>'T', 'uncheckedValue'=>'N'))
			->setLabel('Zapowiedź');
		$title = $this->createElement('text', 'title')
			->setLabel('Tytuł pl');
		$titleEn = $this->createElement('text', 'title_en')
			->setLabel('Tytuł en');
		$dateFrom = $this->createElement('text', 'date_from')
			->setLabel('Data (od)');
		$dateTo = $this->createElement('text', 'date_to')
			->setLabel('Data (do)');
		$preContentPl = $this->createElement('text', 'pre_content_pl')
			->setLabel('Pre treść pl');
		$contentPl = $this->createElement('textarea', 'content_pl')
			->setLabel('Treść pl');
		$preContentEn = $this->createElement('text', 'pre_content_en')
			->setLabel('Pre treść en');
		$contentEn = $this->createElement('textarea', 'content_en')
			->setLabel('Treść en');
		
		$submit = $this->createElement('submit', 'save')
			->setLabel('Zapisz');

		$this->addElements(array(
			$id,
			$eventNews,
			$eventAnnouncement,
			$pictureId,
			$title,
			$titleEn,
			$dateFrom,
			$dateTo,
			$preContentPl,
			$contentPl,
			$preContentEn,
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