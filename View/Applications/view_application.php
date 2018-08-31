<?php 
	echo $this->element('header_menu');
?>
<div class=" form">
	<?php
	$ownerID = $application['Application']['user_id'];
	if($ownerID == $userId){
		echo $this->Html->link( "Edit",   array('controller' => 'applications','action'=>'updateApplication',$application['Application']['id']) ); 
	}
	?>
	<h1>
		<?php echo $application['Application']['title']; ?>
	</h1>
	<p>
		<?php echo $application['Application']['description']; ?>
	</p>
	<ul>
		<?php foreach ($appCategories as $category) { ?>
		<li>
			<?php echo $category['Category']['category']; ?>
		</li>
		<?php } ?>
	</ul>

	<br/>
	<br/>
	<h1>Comments</h1>
	<br/>
	<ul>
		<?php
		if (count($appComments) != 0){
			foreach ($appComments as $comment) { ?>
			<li>
				<h1><b><?php echo $comment['User']['full_name']; ?></b></h1><br/>
				<p><?php echo $comment['Comment']['comment']; ?></p>
			</li>
			<?php }
		} ?>
	</ul>
	<?php echo $this->Form->create('Comment'); ?>
	<?php 
		echo $this->Form->hidden('Comment.application_id', array('value' => $application['Application']['id']));
	?>
	<?php 
		echo $this->Form->hidden('Comment.deleted', array('value' => 0));
	?>
	<?php 
		echo $this->Form->hidden('Comment.user_id', array('value' => $userId));
	?>
	<?php
		echo $this->Form->input('Comment.comment', array('placeholder'=>'Your comment here...','type' => 'textarea'));
	?>
	<?php echo $this->Form->end("Submit"); ?>
</div>