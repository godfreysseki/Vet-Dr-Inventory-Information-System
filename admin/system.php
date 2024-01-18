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
            <div class="systemMsg"></div>
            <?php
    
              if (isset($_POST['backup']) && $_POST['backup'] === 'true') {
                // Instantiate the AuditTrail class
                $auditTrail = new AuditTrail();
                // Run the backup
                try {
                  $auditTrail->runBackup();
                } catch (\Exception $e) {
                  // Handle any errors or exceptions here
                  echo 'Backup failed: ' . $e->getMessage();
                  exit;
                }
                // Delete the folder after downloading
                $auditTrail->deleteDirectory('../Backup');
              }
  
            ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title m-0"><?= PAGE ?></h3>
              </div>
              <div class="card-body">
  
                <p>
                  Ensure the safety of your valuable data by taking a proactive step – create backups today. Backups act as a safety net, guarding against unexpected data loss due to accidents, hardware failures, or other unforeseen circumstances. By
                  regularly backing up your information, you ensure that your hard work, important files, and precious memories remain protected and easily recoverable. Don't wait until it's too late – start the habit of backing up your data now to enjoy
                  peace of mind and the assurance that your digital assets are safeguarded.
                </p>
                <form method="post">
                  <button type="submit" name="backup" value="true" class="btn btn-primary">Backup Now</button>
                </form>
                
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