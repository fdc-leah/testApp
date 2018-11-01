<?php 
	echo $this->element('header_menu');
?>
<div class="users form">
<h1>Update Profile</h1>


	<?php if($imagePath != "") { ?>
		<img src="<?php echo $imagePath;?>" width="150px" height="150px" > <br/> <br/>
	<?php }?> 
	<?php echo $this->Html->link(
		"Upload Photo",
		array('controller' => 'profileImages','action' => 'uploadImage')
	);  ?>

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