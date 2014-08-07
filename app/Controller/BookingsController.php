<?php
class BookingsController extends AppController {
	public $uses = array('Booking');

	public function index($year = null, $month = null) {
		if (empty($year)) {
			$year = date('Y');
		}
		if (empty($month)) {
			$month = date('m');
		}

		$monthTime = mktime(0,0,0,$month,1,$year);
		$totalDays = date('t', $monthTime);
		$dayOffset = date('w', $monthTime) - 1;
		if ($dayOffset < 0) {
			$dayOffset = $dayOffset + 7;
		}


		$days = array();
		for ($i = 1; $i <= $totalDays; $i++) {
			$days[$i] = $this->Booking->getDayStatus($year.'-'.$month.'-'.$i);
		}

		$this->set('year', $year);
		$this->set('month', $month);
		$this->set('monthTime', $monthTime);
		$this->set('days', $days);
		$this->set('dayOffset', $dayOffset);
	}

	public function admin_index() {
		$bookings = $this->Paginate('Booking');
		$this->set('bookings', $bookings);
	}

	public function admin_edit($id = null) {
		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->Booking->save($this->request->data)) {
				$this->Session->setFlash('The booking has been saved', 'success');
				return $this->redirect('/admin/bookings');
			} else {
				$this->Session->setFlash('Some errors occured', 'error');
			}
		} elseif (!empty($id)) {
			$booking = $this->Booking->getBookingById($id);
			if (empty($this->request->data['Booking'])) {
				$this->request->data['Booking'] = $booking['Booking'];
			}
		}
	}

	public function admin_delete($id) {
		if ($this->Booking->delete($id)) {
			$this->Session->setFlash('The booking has been deleted', 'success');
		} else {
			$this->Session->setFlash('The booking hasn\'t been deleted', 'error');
		}
		return $this->redirect($this->referer());
	}
}