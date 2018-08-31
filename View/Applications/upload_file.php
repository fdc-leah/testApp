<div class=" form">
<h1>Add New Application</h1>

	<?php echo $this->Form->create('AppFile', array('type' => 'file')); ?>
	<?php 
		echo $this->Form->hidden('application_id', array('value' => $pplication['Application']['application_id']));
	?>
	<?php 
		echo $this->Form->input('file', array('label' => 'Application File','type' => 'file'));
	?>
	<?php echo $this->Form->end("Upload File"); ?>
</div>