<?php
class AdminHelper extends AppHelper {
	public function onlineRender($online) {
		if (empty($online)) {
			return '<span class="label label-default">Offline</span>';
		}
		return '<span class="label label-success">Online</span>';
	}

	public function fullRender($full) {
		if (empty($full)) {
			return '<span class="label label-default">Not full</span>';
		}
		return '<span class="label label-success">Full</span>';
	}
}