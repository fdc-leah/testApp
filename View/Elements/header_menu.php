
<?php 
	echo $this->Html->link( "Return to Dashboard", array('controller' => 'pages','action' => 'index'));
?>
<br/>
<?php 
	echo $this->Html->link( "Logout",   array('controller' => 'users','action'=>'logout') ); 
?>
