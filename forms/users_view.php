<?php
  
  include_once "../includes/config.inc.php";
  
  $data   = new AuditTrail();
  $trails = $data->getUserAuditTrails($_POST['dataId']);

?>


<div class="table-responsive">
	<table class="table table-bordered table-sm table-striped dataTable">
		<thead>
		<tr>
			<th>#</th>
			<th>Time</th>
			<th>Activity Type</th>
			<th>Entity Id</th>
			<th>Activity</th>
			<th>Details</th>
			<th>Old Value</th>
			<th>New Value</th>
			<th>Module</th>
			<th>User Agent</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
    <?php $no = 1; ?>
    <?php foreach ($trails as $trail) : ?>
			<tr>
				<td><?= $no ?></td>
				<td><?= esc($trail['timestamp']); ?></td>
				<td><?= activityType(esc($trail['activity_type'])); ?></td>
				<td><?= esc($trail['entity_id']); ?></td>
				<td><?= esc($trail['activity']); ?></td>
				<td><?= esc($trail['details']); ?></td>
				<td><?= nl2br(esc($trail['old_value'])); ?></td>
				<td><?= nl2br(esc($trail['new_value'])); ?></td>
				<td><?= esc($trail['module']); ?></td>
				<td><?= esc($trail['user_agent']); ?></td>
				<td><?= ((esc($trail['status']) === "success") ? "<span class='badge badge-success'>".esc($trail['status'])."</span>" : "<span class='badge badge-warning'>".esc($trail['status'])."</span>"); ?></td>
			</tr>
      <?php $no++; ?>
    <?php endforeach; ?>
		</tbody>
	</table>
</div>
