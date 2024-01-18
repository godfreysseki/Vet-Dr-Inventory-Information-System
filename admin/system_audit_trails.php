<?php
  
  include_once "../includes/header.inc.php";

?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= PAGE ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
              <li class="breadcrumb-item active">System</li>
              <li class="breadcrumb-item active"><?= PAGE ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title m-0"><?= PAGE ?></h3>
                <div class="card-tools">
                  <button class="clearTrails btn btn-sm btn-primary m-0">Clear All Trails</button>
                </div>
              </div>
              <div class="card-body">
  
                <?php
    
                  $auditTrails = new AuditTrail();
                  $trails      = $auditTrails->getAuditTrails();
  
                ?>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-striped dataTable">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Time</th>
                      <th>Activity Type</th>
                      <th>Entity Id</th>
                      <th>Activity</th>
                      <th>Details</th>
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
                        <td><?= esc($trail['full_name']); ?></td>
                        <td><?= esc($trail['timestamp']); ?></td>
                        <td><?= activityType(esc($trail['activity_type'])); ?></td>
                        <td><?= esc($trail['entity_id']); ?></td>
                        <td><?= esc($trail['activity']); ?></td>
                        <td><?= esc($trail['details']); ?></td>
                        <td><?= esc($trail['module']); ?></td>
                        <td><?= esc($trail['user_agent']); ?></td>
                        <td><?= ((esc($trail['status']) === "success") ? "<span class='badge badge-success'>".esc($trail['status'])."</span>" : "<span class='badge badge-warning'>".esc($trail['status'])."</span>"); ?></td>
                      </tr>
                      <?php $no++; ?>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              
              </div>
            </div>
          </div>
          <!-- /.col-12 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include_once "../includes/footer.inc.php";

?>