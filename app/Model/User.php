<?php
class User extends AppModel {

	public $validate = array(
		'username' => array(
			'rule' => 'isUnique',
			'allowEmpty' => false,
			'message' => 'This username is already in use'
		),
		'password' => array(
			'rule' => 'notEmpty',
			'message' => 'Enter a password'
		),
	);

	public function beforeSave($options = array()) {
		if (!empty($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}

}