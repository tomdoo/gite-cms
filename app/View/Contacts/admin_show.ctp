<div class="page-header">
	<h2>Contact <small><?php echo $contact['Contact']['subject']; ?></small></h2>
</div>

<dl class="dl-horizontal">
	<dt>Date</dt>
	<dd><?php echo $this->Time->i18nFormat($contact['Contact']['created']); ?></dd>
	<dt>Name</dt>
	<dd><?php echo $contact['Contact']['name']; ?></dd>
	<dt>Email</dt>
	<dd><?php echo $contact['Contact']['email']; ?></dd>
	<dt>Subject</dt>
	<dd><?php echo $contact['Contact']['subject']; ?></dd>
	<dt>Text</dt>
	<dd><?php echo $contact['Contact']['text']; ?></dd>
</dl>

<div class="btn-toolbar" role="toolbar">
	<div class="btn-group">
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-envelope"></i> Reply', 'mailto:'.$contact['Contact']['email'].'?subject='.rawurlencode($contact['Contact']['subject']).'&body='.rawurlencode($contact['Contact']['text']), array('escape' => false, 'class' => 'btn btn-default')); ?>
	</div>
	<div class="btn-group">
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i> Delete', '/admin/contacts/delete', array('escape' => false, 'class' => 'btn btn-default')); ?>
	</div>
</div>