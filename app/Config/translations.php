<?php
App::uses('Translation', 'Model');
function ___($id, $message, $args = null) {
	if (empty($id) || empty($message)) {
		return false;
	}

	$translation = new Translation();
	$translated = $translation->translate(Configure::read('Config.language'), $id);
	if (empty($translated)) {
		$translated = $message;
	}

	if ($args === null) {
		return $translated;
	} else {
		$args = array_slice(func_get_args(), 2);
	}
	return vsprintf($translated, $args);
}