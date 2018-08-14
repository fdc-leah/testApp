
<?php 
	echo $this->Html->link( "Return to Dashboard", array('controller' => 'users','action'=>'index', 0)); 
?>
<br/>
<?php 
	echo $this->Html->link( "Logout",   array('controller' => 'users','action'=>'logout') ); 
?>

<div class="application form">
<h1>Update Profile</h1>
	<?php echo $this->Form->create('Application'); ?>
	<?php 
		echo $this->Form->hidden('id', array('value' => $appId));
	?>
	<?php 
		echo $this->Form->hidden('Application.user_id', array('value' => $userId));
	?>
	<?php
		echo $this->Form->input('Application.title', array('label' => 'Application Name'));
	?>
	<?php
		echo $this->Form->input('Application.description', array('label' => 'Description', 'type' => 'text'));
	?>
	<?php
		echo $this->Form->input('Application.version', array('label' => 'Application Version'));
	?>
	<h3> Categories </h3>
	<?php
		echo $this->Form->input('AppCategory.category',array('label' => 'Category',
			'legend' => false,
			'div' => false,
			'multiple'=>'checkbox',
			'options' => $categories
		));	
	?>

	<br />

	<?php echo $this->Form->end("Update"); ?>
</div>