<?php echo ___('contacts-new-form-submission', 'New contact form submission from your website:'); ?>

<?php echo ___('contacts-name', 'Name'); ?>
<?php echo $data['name']; ?>

<?php echo ___('contacts-email', 'Email'); ?>
<?php echo $data['email']; ?>

<?php echo ___('contacts-subject', 'Subject'); ?>
<?php echo $data['subject']; ?>

<?php echo ___('contacts-text', 'Text'); ?>
<?php echo nl2br($data['text']); ?>