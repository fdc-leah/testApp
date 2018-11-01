<?php 
	echo $this->Html->script('jquery.infinitescroll.min');
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
?>
<?php  $page=$this->Paginator->counter(array('format' => ('%pages%'))) ;  ?>
<div class="form" id="application-list">
	<ul class="nav">
		<li> 
			<a href="#">Categories</a>
			 <ul class="dropdown-menu">
				<?php foreach ($categories as $category){?>
					<li> <?= $this->Html->link($category['Category']['category'], array('action' => 'index', '?' => array('category' => $category['Category']['id']))) ?></li>
				<?php }?>
		  	</ul>
		</li>
	</ul>
	<h3> Applications </h3>
	<table style="width:100%" id="table1">
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
				echo "<tr class='row'>
						<td>$name</td>
						<td>$desc</td> 
						<td>$version</td>";
				echo "<td>".$this->Html->link('View', array('controller' => 'applications', 'action' => 'viewApplication',$application['Application']['id']));
				echo "</td></tr>";
			}
		?> 
	</table>

<?php echo $this->Paginator->prev('Previous');?> |
<?php echo $this->Paginator->next('Next'); 
	  // echo $this->Paginator->numbers();
?> 
</div>

<script>
// $('#content').on("scroll", function() {
// 	var ias = jQuery.ias({
// 	    container:  '#table1',
// 	    item:       '.row',
// 	    pagination: '#pagination',
// 	    next:       '.next'
// 	  });
// });

// $('#content').on('scroll', function() {
// 	console.log('tesst');
//     $.ajax({
//         method: "GET",
//         url: "/cake/myapp/applications/applications",
//         success: (e) => {
//         	let data = JSON.parse(e);
//             $("#table1").append(data);
//         }
//     });
// });

</script>