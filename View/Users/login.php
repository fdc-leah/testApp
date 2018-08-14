<?php 
echo $this->Html->link(
    'Register User',
    array('controller' => 'users', 'action' => 'register')
);
 ?>
<div class="users form">
<h1>Login User</h1>
<?php echo $this->Form->create('User'); ?>
	<?php
	echo $this->Form->input('email');
	?>
	<?php
	echo $this->Form->input('password');
	?>

<br />

<?php echo $this->Form->end("Login"); ?>
</div>