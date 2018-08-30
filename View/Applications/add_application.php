
<?php 
	echo $this->Html->link( "Return to Dashboard", array('controller' => 'pages','action' => 'index'));
?>
<br/>
<?php 
	echo $this->Html->link( "Logout",   array('controller' => 'users','action'=>'logout') ); 
?>

<div class=" form">
<h1>Add New Application</h1>
	<?php echo $this->Form->create('Application'); ?>
	<?php 
		echo $this->Form->hidden('Application.user_id', array('value' => $userId));
	?>
	<?php 
		echo $this->Form->hidden('Application.deleted', array('value' => 0));
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

	<?php echo $this->Form->end("Add New App"); ?>
	<br/>
</div>