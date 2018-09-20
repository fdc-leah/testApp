<?php 
	echo $this->element('header_menu');
?>
<div class=" form">
<h1>Upload Application</h1>
	<?php
		echo $this->Form->create('AppFile', array('enctype' => 'multipart/form-data')); ?>
	<?php 
		echo $this->Form->hidden('AppFile.application_id', array('value' => $app['Application']['id']));
	?>
	<?php 
		echo $this->Form->input('File.file', array('label' => 'Application File','type' => 'file'));
	?>
	<?php echo $this->Form->end("Upload File"); ?>
</div>