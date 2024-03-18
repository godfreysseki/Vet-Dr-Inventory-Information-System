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
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <section class="col-md-12">
            <div class="systemMsg"></div>
            <?php
            
              if (isset($_POST['replyBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
              	$reply = new Contact();
              	$reply->emailReply($_POST['contactId'], $_POST['reply']);
              }
            
            ?>
          </section>
          <section class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?= PAGE ?></h3>
              </div>
              <div class="card-body">
                <?php
                  
                  $data = new Contact();
                  echo $data->displayContactsTable();
                
                ?>
              </div>
            </div>
          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include "../includes/footer.inc.php";

?>