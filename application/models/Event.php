<?php

// application/models/Event.php

class Application_Model_Event extends Core_Model_Abstract {

	protected $_params = array('id', 'content_pl', 'content_en', 'title',
		'title_en', 'pre_content_pl', 'pre_content_en', 'picture_id',
		'event_news', 'event_announcement', 'date_from', 'date_to', 'arch_date',
		'user', 'picture_id_small', 'picture_id_archive');

	public function __construct($options=null){
		$options['date_to'] = $options['date_to'] ?: null; 
		parent::__construct($options);
	}
	/**
	 * Funkcja do pobierania tresci newsa w zaleznosci od tego czy jest 
	 * menu polskie czy angielskie
	 * 
	 * @return string Treść newsa
	 */
	
	
	public function getContent() {
		if ($_SESSION['lang'] == 'en') {
			return $this->getContentEn();
		} else {
			return $this->getContentPl();
		}
	}

	/**
	 * Funkcja do pobierania zajawki newsa w zaleznosci od tego czy jest 
	 * menu polskie czy angielskie
	 * 
	 * @return string Zajawka
	 */
	public function getPreContent() {
		if ($_SESSION['lang'] == 'en') {
			return $this->getPreContentEn();
		} else {
			return $this->getPreContentPl();
		}
	}

	/**
	 * Funkcja do pobierania tytulu newsa w zaleznosci od tego czy jest menu
	 * polskie czy angielskie
	 * 
	 * @return string Tytuł newsa
	 */
	public function getTitleLng() {
		if ($_SESSION['lang'] == 'en') {
			return $this->getTitleEn();
		} else {
			return $this->getTitle();
		}
	}

	public function hasLargePicture() {
		return $this->hasPictureId();
	}

	public function getLargePictureName() {
		if (!$this->hasLargePicture()) {
			return null;
		}
		return preg_replace('/\-s.(\w)/', '-c.$1', $this->_getPictureName($this->getPictureId()));
	}

	public function getLargePictureId() {
		if (!$this->hasLargePicture()) {
			return null;
		}
		return $this->getPictureId();
	}
	
	public function getLargePictureRatio() {
		return 370/517;
	}

	public function hasSmallPicture() {
		return $this->hasPictureIdSmall() || $this->hasPictureId();
	}

	public function getSmallPictureName() {
		if (!$this->hasSmallPicture()) {
			return null;
		}

		$pictureId = $this->getPictureIdSmall();
		if ($pictureId) {
			return $this->_getPictureName($pictureId);
		}

		return $this->_getPictureName($this->getPictureId());
	}

	public function getSmallPictureId() {
		if (!$this->hasSmallPicture()) {
			return null;
		}
		return $this->hasPictureIdSmall() ? $this->getPictureIdSmall() : $this->getPictureId();
	}
	
	public function getSmallPictureRatio() {
		return 'T' == $this->getEventAnnouncement() ? 370/170 : 257/292;
	}

	public function hasArchivePicture() {
		return $this->hasPictureIdArchive() || $this->hasPictureId();
	}

	public function getArchivePictureName() {
		if (!$this->hasArchivePicture()) {
			return null;
		}

		$pictureId = $this->getPictureIdArchive();
		if ($pictureId) {
			return $this->_getPictureName($pictureId);
		}

		return preg_replace('/\-s.(\w)/', '-a.$1', $this->_getPictureName($this->getPictureId()));
	}

	public function getArchivePictureId() {
		if (!$this->hasArchivePicture()) {
			return null;
		}
		return $this->hasPictureIdArchive() ? $this->getPictureIdArchive() : $this->getPictureId();
	}
	
	public function getArchivePictureRatio() {
		return 257/62;
	}

	private function _getPictureName($id) {
		$picture = Core_Model_MapperAbstract::getInstance('Photo')->find($id);
		return $picture ? $picture->getCroppedName() : null;
	}

	//funkcja do wybierania daty od (jak jest podana jedna data) lub zakredu dat (jak są podane obie daty)
	public function getDate() {
		$data_od = date('d.m.Y', strtotime($this->getDateFrom()));
		$data_do = strtotime($this->getDateTo());

		if ($data_do > 0) {
			$data_do = date('d.m.Y', strtotime($this->getDateTo()));
			$data = $data_od . " - " . $data_do;
		} else {
			$data = $data_od;
		}

		return $data;
	}
	
	

}
