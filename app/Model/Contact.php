<?php
class Contact extends AppModel {
	public function getContactById($id) {
		$params = array();
		$params['fields'] = array('id', 'name', 'email', 'subject', 'text', 'created');
		$params['conditions']['Contact.id'] = $id;
		return $this->find('first', $params);
	}
}