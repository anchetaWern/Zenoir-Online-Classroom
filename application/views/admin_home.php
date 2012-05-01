<!--admin home page-->
<ul class="tabs left">
	<li><a href="#main">Menu</a></li>
</ul>
<div id="main" class="tab-content">
	<table>
		<tbody>
			<tr>
				<td><a href="<?php echo $this->config->item('admin_base'); ?>users"><button class="large orange">Users</button></a></td>
				<td><a href="<?php echo $this->config->item('admin_base'); ?>classes"><button class="large blue">Classes</button></a></td>
			</tr>
			<tr>
				<td><a href="<?php echo $this->config->item('admin_base'); ?>subjects"><button class="large green">Subjects</button></a></td>
				<td><a href="<?php echo $this->config->item('admin_base'); ?>courses"><button class="large red">Courses</button></a></td>
			</tr>
		</tbody>
	</table>
</div>