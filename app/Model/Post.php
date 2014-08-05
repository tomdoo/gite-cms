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

	/*public function getMenuPages() {
		$params = array();
		$params['fields'] = array('title', 'slug');
		$params['conditions']['Post.type'] = 'page';
		$params['conditions']['Post.online'] = true;
		return $this->find('all', $params);
	}*/

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

	/*public function getPageBySlug($slug) {
		$params = array();
		$params['fields'] = array('title', 'slug', 'content');
		$params['conditions']['Post.type'] = 'page';
		$params['conditions']['Post.slug'] = $slug;
		return $this->find('first', $params);
	}

	public function getById($id) {
		$params = array();
		$params['conditions']['Post.id'] = $id;
		return $this->find('first', $params);
	}

	public function getPageById($id) {
		$params = array();
		$params['fields'] = array('id', 'title', 'slug', 'content', 'online', 'order');
		$params['conditions']['Post.id'] = $id;
		$params['conditions']['Post.type'] = 'page';
		return $this->find('first', $params);
	}

	public function getTitleById($id) {
		$params = array();
		$params['fields'] = array('title');
		$params['conditions']['Post.id'] = $id;
		if ($post = $this->find('first', $params)) {
			return $post['Post']['title'];
		}
		return null;
	}*/
}