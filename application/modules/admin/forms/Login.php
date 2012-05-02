<?php
class Admin_Form_Login extends Zend_Form {

	public function init() {
		$back = $this->createElement('hidden', 'back');

		$username = $this->createElement('text', 'username')
			->setLabel('Użytkownik')
			->setRequired();
		$password = $this->createElement('password', 'password')
			->setLabel('Hasło')
			->setRequired();
		
		$submit = $this->createElement('submit', 'login')
			->setLabel('Zaloguj')
			->setAttrib('class', 'button');

		$this->addElements(array(
			$back,
			$username,
			$password,
			$submit
		));

		$back->setDecorators(array('ViewHelper'));
		$submit->removeDecorator('Label');
	}
}