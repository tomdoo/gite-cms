<?php
class AjaxController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->autoRender = false;
	}

	public function fileUpload() {
		if (!empty($this->request->data['Media'])) {
			if (!empty($this->request->data['Media'])) {
				if (empty($this->request->data['Media']['file']['error'])) {
					$filename = String::uuid().'_'.$this->request->data['Media']['file']['name'];
					move_uploaded_file($this->request->data['Media']['file']['tmp_name'], Configure::read('Config.paths.mediaPath').$filename);
					echo $filename;
				}
			}
		}
	}
}