<?php
class UsersController extends AppController {
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(___('users-login-fail', 'Incorrect username or password'), 'error');
			}
		}
	}

	public function logout() {
		$this->autoRender = false;
		$this->Auth->logout();
		$this->Session->setFlash(___('users-logout-success', 'You are now logged out'), 'success');
		return $this->redirect('/');
	}

	public function admin_index() {
		$users = $this->User->find('all');
		$this->set('users', $users);
	}

	public function admin_edit($id = null) {
		if ($this->request->is('put') || $this->request->is('post')) {
			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
			}
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved', 'success');
				return $this->redirect('/admin/users');
			} else {
				$this->Session->setFlash('Some errors occured', 'error');
			}
		}

		$pageTitle = 'Create user';
		if(!empty($id)) {
			$user = $this->User->findById($id);
			$pageTitle = 'Edit user <small>'.$user['User']['username'].'</small>';
			if (empty($this->request->data['User']) && !empty($user)) {
				$this->request->data['User'] = $user['User'];
				$this->request->data['User']['password'] = null;
			}
		} else {
			$this->set('create', true);
		}

		$this->set('roles', array('admin' => 'Admin'));
		$this->set('pageTitle', $pageTitle);
	}

	public function admin_delete($id) {
		$this->autoRender = false;
		if ($id !=1 && $this->User->delete($id)) {
			$this->Session->setFlash('User deleted', 'success');
		} else {
			$this->Session->setFlash('An error occured while deleting user', 'error');
		}
		return $this->redirect($this->referer());
	}
}