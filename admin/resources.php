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
	      <div class="systemMsg"></div>
        <?php
    
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addProduct = new Resources();
            $id = $addProduct->addResource($_POST);
      
            echo alert('success', 'Resource Added Successfully. Id: '.$id);
          }
  
        ?>
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title m-0"><?= PAGE ?></h3>
                <div class="card-tools">
                  <button class="newResource btn btn-sm btn-primary m-0">New Resource</button>
                </div>
              </div>
              <div class="card-body">
                
                <?php
                  
                  $data = new Resources();
                  echo $data->displayResourcesTable();
                
                ?>
              
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