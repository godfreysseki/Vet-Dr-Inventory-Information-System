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
    
              if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $settingsManager = new Settings();
                $settingsId      = $settingsManager->addSettings($_POST['company_name'], $_POST['company_slogan'], $_POST['address'], $_POST['phone1'], $_POST['phone2'], $_POST['email'], $_POST['currency']);
      
                if ($settingsId) {
                  echo $settingsId;
                } else {
                  echo $settingsId;
                }
              }
  
            ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title m-0"><?= PAGE ?></h3>
              </div>
              <div class="card-body">
  
                <div class="row">
                  <div class="col-sm-6">
                    <?php
        
                      $form = new Settings();
                      echo $form->addSettingsForm();
      
                    ?>
                  </div>
                  <div class="col-sm-6 justify-content-center text-center">
      
                    <?php
        
                      $settingsManager = new Settings();
                      $settings      = $settingsManager->getGeneralSettings();
        
                      if ($settings) {
                        echo "<img src='../assets/img/" . esc($settings['logo']) . "' class='w-50' alt='logo'>";
                        echo "<h2>" . esc($settings['company_name']) . "</h2>";
                        echo "<p>" . esc($settings['company_slogan']) . "</p>";
                        echo "<p>" . esc($settings['address']) . "</p>";
                        echo "<p>" . esc($settings['phone1']) . "</p>";
                        echo "<p>" . esc($settings['phone2']) . "</p>";
                        echo "<p>" . esc($settings['email']) . "</p>";
                        echo "<p><b>Currency: </b>" . esc($settings['currency']) . "</p>";
                      }
                    ?>
                  </div>
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