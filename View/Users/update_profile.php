
<?php 
	echo $this->Html->link( "Return to Dashboard", array('controller' => 'pages','action' => 'index'));
?>
<br/>
<?php 
	echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
?>

<div class="users form">
<h1>Update Profile</h1>
	<?php echo $this->Form->create('User'); ?>
	<?php 
		echo $this->Form->hidden('id', array('value' => $userId));
	?>
	<?php
		echo $this->Form->input('full_name');
	?>
	<?php
		echo $this->Form->input('email');
	?>

	<br />

	<?php echo $this->Form->end("Update"); ?>
	<br/>

	<?php 
		echo $this->Html->link(
			"Update Password",
			array('action'=>'updatePassword')
		); 
	?>
</div>