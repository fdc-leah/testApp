<?php 

	$userloggedIn = $this->Session->read('User.id');
	echo "Welcome ".$user['User']['full_name'].'!	';
	echo $this->Html->link(
	    'Logout',
		array('controller' => 'users', 'action' => 'logout')
	);
?>
	<br/>
<?php 
	echo $this->Html->link(
		'Update Profile',
		array('controller' => 'users', 'action' => 'updateProfile')
	);
?> <br/>
<?php 
	echo $this->Html->link(
		'Add new application',
		array('controller' => 'applications', 'action' => 'addApplication')
	);
?><br/> <br/>
<h3> Applications </h3>
<table style="width:100%">
	<tr>
	    <th>Name</th>
		<th>Description</th> 
		<th>Version</th>
		<th>Action</th>
	</tr>
	<?php
		foreach ($applications as $application) {
			$name = $application['Application']['title'];
			$desc = $application['Application']['description'];
			$version = $application['Application']['version'];
			echo "<tr>
					<td>$name</td>
					<td>$desc</td> 
					<td>$version</td>";
			echo "<td>".$this->Html->link('View', array('controller' => 'applications', 'action' => 'viewApplication',$application['Application']['id']));
			echo "</td></tr>";
		}
	?>
</table>