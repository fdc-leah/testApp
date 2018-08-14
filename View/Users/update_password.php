
<?php 
	echo $this->Html->link( "Return to Update Profile",   array('action'=>'updateProfile') ); 
?>
<br/>
<?php 
	echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
?>

<div class="users form">
<h1>Update Password</h1>
<?php echo $this->Form->create('User'); ?>

	<?php 
		echo $this->Form->hidden('id', array('value' => $userId));
	?>
	<?php
		echo $this->Form->input('password_old', array('label' => 'Old Password', 'title' => 'Old password', 'type'=>'password'));
	?>
	<?php
		echo $this->Form->input('password_new', array('label' => 'New Password', 'title' => 'New password', 'type'=>'password'));
	?>
	<?php
		echo $this->Form->input('password_new_confirm', array('label' => 'Confirm New Password', 'title' => 'Confirm new password', 'type'=>'password'));
	?>

<br />

<?php echo $this->Form->end("Update Password"); ?>
</div>