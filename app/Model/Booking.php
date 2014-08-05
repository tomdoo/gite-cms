<?php
class Booking extends AppModel {
	public $order = array(
		'from' => 'asc',
		'to' => 'asc',
	);

	public function getBookingById($id) {
		$params = array();
		$params['fields'] = array('id', 'from', 'to', 'full', 'details');
		$params['conditions']['Booking.id'] = $id;
		return $this->find('first', $params);
	}
}