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

	public function getDayStatus($date) {
		$params = array();
		$params['conditions']['Booking.from <='] = $date;
		$params['conditions']['Booking.to >='] = $date;
		if ($bookings = $this->find('all', $params)) {
			foreach ($bookings as $booking) {
				if (!empty($booking['Booking']['full'])) {
					return 'full';
				}
			}
			return 'partial';
		}
		return 'empty';
	}
}