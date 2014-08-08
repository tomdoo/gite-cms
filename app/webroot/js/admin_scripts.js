$('document').ready(function() {
	if ($('.alert').length > 0) {
		window.setTimeout(function() {
			$('.alert').alert('close');
		}, 3000);
	}

	if ($('.wysiwyg').length > 0) {
		tinyMCE.init({
			selector: '.wysiwyg',
			plugins: 'image responsivefilemanager code link paste preview lists table',
			external_filemanager_path: '/filemanager/',
			filemanager_title: 'Responsive Filemanager',
			external_plugins: {
				filemanager: '/filemanager/plugin.min.js',
			},
			height: 500,
		});
	}

	if ($('.datepicker').length > 0) {
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
			weekStart: 1,
		});
	}
});