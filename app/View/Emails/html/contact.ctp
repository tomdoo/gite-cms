<p><?php echo ___('contacts-new-form-submission', 'New contact form submission from your website:'); ?></p>
<p><b><?php echo ___('contacts-name', 'Name'); ?></b><br />
<?php echo $data['name']; ?></p>
<p><b><?php echo ___('contacts-email', 'Email'); ?></b><br />
<?php echo $data['email']; ?></p>
<p><b><?php echo ___('contacts-subject', 'Subject'); ?></b><br />
<?php echo $data['subject']; ?></p>
<p><b><?php echo ___('contacts-text', 'Text'); ?></b><br />
<?php echo nl2br($data['text']); ?></p>