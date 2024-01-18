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
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title m-0"><?= PAGE ?></h3>
              </div>
              <div class="card-body">
                
                <form action="reports.php" method="post" target="_blank">
                  <input type="hidden" name="report_type" value="payroll">
                  <div class="row">
                    <div class="col-5">
                      <label for="start_date">Start Date</label>
                      <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="col-5">
                      <label for="end_date">End Date</label>
                      <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                    <div class="col-2">
                      <label>&nbsp;</label>
                      <input type="submit" class="btn btn-primary btn-block" value="Generate Report">
                    </div>
                  </div>
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