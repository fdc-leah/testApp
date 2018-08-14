<?php
	echo $this->Html->link(
	    'Login',
	    array('controller' => 'users', 'action' => 'login')
	);
?>
<div class="users form">
<h1>Register User</h1>
<?php echo $this->Form->create('User'); ?>

	<?php 
	echo $this->Form->input('full_name');
	?>
	<?php
	echo $this->Form->input('email');
	?>
	<?php
	echo $this->Form->input('birthday', array( 'label' => 'Date of birth', 
	   'dateFormat' => 'DMY', 
	   'minYear' => date('Y') - 70,
	   'maxYear' => date('Y') - 18,
	   'empty' => true
	 ));
	?>
	<?php
	echo $this->Form->input('password');
	?>
	<?php
		echo $this->Form->input('password_confirm', array('label' => 'Confirm Password', 'title' => 'Confirm password', 'type'=>'password'));
	?>
<br />

<?php echo $this->Form->end("Register"); ?>
</div>