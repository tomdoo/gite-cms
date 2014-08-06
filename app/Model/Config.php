<?php
class Config extends AppModel {
	public $actsAs = array(
		'Translate' => array('value'),
	);
	public $validate = array(
		'name' => array(
			'rule' => '/^[a-z0-9\-_]+$/',
			'allowEmpty' => false,
			'message' => 'Field "name" is mandatory',
		),
	);

	public function getValue($name) {
		$params = array();
		$params['fields'] = array('value');
		$params['conditions']['Config.name'] = $name;
		if ($config = $this->find('first', $params)) {
			return $config['Config']['value'];
		}
		return null;
	}
}