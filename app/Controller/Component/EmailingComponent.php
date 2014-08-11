<?php
App::uses('CakeEmail', 'Network/Email');

class EmailingComponent extends Component {
	public $email;
	public $defaultViewVars = array();

	public function __construct(ComponentCollection $collection, $settings = array()) {		
		$this->email = new CakeEmail();
		$this->email->config('smtp');
	}

	public function contact($to, $data) {
		$this->email->to($to);
		$this->email->subject('[Gîte] Contact: '.$data['subject']);
		$this->email->template('contact', 'default');
		$this->email->replyTo($data['email']);

		$viewVars = array(
			'data' => $data,
		);

		$this->email->viewVars(array_merge($this->defaultViewVars, $viewVars));
		$this->email->send();
	}
}