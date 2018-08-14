
<?php 
	echo $this->Html->link( "Return to Dashboard", array('controller' => 'users','action'=>'index', 0)); 
?>
<br/>
<?php 
	echo $this->Html->link( "Logout",   array('controller' => 'users','action'=>'logout') ); 
?>

<div class=" form">
	<?php
	$ownerID = $application['Application']['user_id'];
	if($ownerID == $userId){
		echo $this->Html->link( "Edit",   array('controller' => 'applications','action'=>'editApplication') ); 
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
</div>