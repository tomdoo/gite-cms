<?php
App::uses('AppModel', 'Model');
class Translation extends AppModel {
	public $useTable = 'i18n';

	public function translate($locale, $messageId) {
		$params = array();
		$params['fields'] = array('content');
		$params['conditions']['locale'] = $locale;
		$params['conditions']['model'] = 'View';
		$params['conditions']['foreign_key'] = 0;
		$params['conditions']['field'] = $messageId;
		if ($translation = $this->find('first', $params)) {
			return stripslashes($translation['Translation']['content']);
		}
		return null;
	}
}