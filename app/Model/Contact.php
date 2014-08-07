<?php
class Contact extends AppModel {
	public $order = array('created' => 'desc');
	public $validate = array(
		'name' => array(
			'between' => array(
                'rule'    => array('between', 3, 50),
                'message' => 'Between 3 and 50 characters',
            ),
		),
		'email' => array(
			'rule' => 'email',
			'message' => 'Enter a correct email address',
		),
		'subject' => array(
			'between' => array(
                'rule'    => array('between', 3, 100),
                'message' => 'Between 3 and 100 characters',
            ),
		),
		'text' => array(
			'rule' => array('minLength', '30'),
			'message' => 'At least 30 characters',
		),
	);

	public function getContactById($id) {
		$params = array();
		$params['fields'] = array('id', 'type', 'name', 'email', 'subject', 'text', 'created');
		$params['conditions']['Contact.id'] = $id;
		return $this->find('first', $params);
	}
}