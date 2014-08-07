<?php
class Post extends AppModel {
	public $order = array('order' => 'asc');
	public $actsAs = array(
		'Tree',
		'Translate' => array('title', 'slug', 'content'),
	);
	public $validate = array(
		'slug' => array(
			'rule' => '/^[a-z0-9\-]+$/',
			'allowEmpty' => true,
			'message' => 'Incorrect slug',
		),
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'The title is empty',
		),
	);

	public function beforeSave($options = array()) {
		if (empty($this->data['Post']['slug']) && !empty($this->data['Post']['title'])) {
			$this->data['Post']['slug'] = strtolower(Inflector::slug($this->data['Post']['title'], '-'));
		}
		return true;
	}

	public function getPagesTree($parentId = 1, $includeParent = false) {
		$params = array();
		$params['fields'] = array('id', 'lft', 'rght');
		$params['conditions']['Post.type'] = 'page';
		$params['conditions']['Post.id'] = $parentId;
		if ($parentPost = $this->find('first', $params)) {
			$params = array();
			$params['conditions']['or'][0]['and'][0]['Post.parent_id >='] = $parentPost['Post']['lft'];
			$params['conditions']['or'][0]['and'][1]['Post.parent_id <='] = $parentPost['Post']['rght'];
			if ($includeParent) {
				$params['conditions']['or'][1]['Post.id'] = $parentPost['Post']['id'];
			}
			return $this->find('threaded', $params);
		}
		return null;
	}

	public function getPageBySlug($slug) {
		$params = array();
		$params['conditions']['Post.type'] = 'page';
		$params['conditions']['I18n__slug`.`content'] = $slug;
		$page = $this->find('first', $params);
		return $page;
	}
}