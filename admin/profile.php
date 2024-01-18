<?php
  
  include_once "../includes/header.inc.php";

?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
	        <div class="col-md-12">
            <?php
      
              if (isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $usersUpdates = new Users();
                echo $usersUpdates->updateProfile($_POST);
        
                if ($_SESSION['user'] !== $_POST['full_name']) {
                  $_SESSION['user'] = $_POST['full_name'];
                }
              }
            
              /*if (isset($_POST['btnimg']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $changeImg = new Users();
                $changeImg->updatepicture(basename($_FILES['profimg']['name']), $_FILES["profimg"]["tmp_name"]);
              }*/
      
              if (isset($_POST['btnChng']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $changePass = new Users();
                echo $changePass->updatepassword($_POST['old'], $_POST['new']);
              }
              
              // Get user data
	            $data = new Users();
            ?>
	        </div>
          <div class="col-md-3">
            
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                
                <h3 class="profile-username text-center"><?= $_SESSION['user'] ?></h3>
                
                <p class="text-muted text-center"><?= ucwords(strtolower(str_replace("_", " ", $_SESSION['role']))) ?></p>
                
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Username</b> <a class="float-right"><?= $_SESSION['username'] ?></a>
                  </li>
                </ul>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
	              <?php
	              
		              $items = $data->getUserById($_SESSION['user_id']);

	              ?>
                <strong><i class="fas fa-envelope mr-1"></i> Email Address</strong>
                <p class="text-muted"><?= email($items['email']) ?></p>
                <hr>
	              
                <strong><i class="fas fa-envelope mr-1"></i> Telephone</strong>
                <p class="text-muted"><?= phone($items['phone_number']) ?></p>
                <hr>
                
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Primary Address</strong>
                <p class="text-muted"><?= $items['address_line1'] ?></p>
                <hr>
                
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Secondary Address</strong>
                <p class="text-muted"><?= $items['address_line2'] ?></p>
                <hr>
                
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Postal Code</strong>
                <p class="text-muted"><?= $items['postal_code'] ?></p>
                <hr>
                
                <strong><i class="fas fa-map-marker-alt mr-1"></i> City</strong>
                <p class="text-muted"><?= $items['city'] ?></p>
                <hr>
                
                <strong><i class="fas fa-map mr-1"></i> Country</strong>
                <p class="text-muted"><?= $items['country'] ?></p>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Update Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Update Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
	                  <?php
    
                      $data   = new AuditTrail();
                      $trails = $data->getUserAuditTrails($_SESSION['user_id']);
		                  
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
					                  <td><?= ($trail['details']); ?></td>
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
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="profile">
                    <?php
  
                      $data = new Users();
                      echo $data->addUserFormSelf($_SESSION['user_id']);
	                    
                    ?>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="password">
	                  <!--<h5 class="mt-4">Change Profile Picture</h5>
	                  <form method="post" enctype="multipart/form-data" class="forms-sample mt-4">
		                  <div class="form-group row">
			                  <label for="profimg" class="col-sm-3 col-form-label">New Profile Image</label>
			                  <div class="col-sm-9">
				                  <input type="file" name="profimg" id="profimg" required="required" accept="image/*"
				                         class="form-control">
			                  </div>
		                  </div>
		                  <div class="form-group row">
			                  <label for="location" class="col-sm-3 col-form-label"></label>
			                  <div class="col-sm-9">
				                  <input type="submit" name="btnimg" value="Upload Image" class="btn btn-primary">
			                  </div>
		                  </div>
	                  </form>
	
	                  <hr class="my-4">-->
	
<!--	                  <h5>Change Password</h5>-->
	                  <form method="post" class="forms-sample mt-4">
		                  <div class="form-group row">
			                  <label for="old" class="col-sm-3 col-form-label">Old Password</label>
			                  <div class="col-sm-9">
				                  <input type="password" name="old" id="old" required="required" class="form-control">
			                  </div>
		                  </div>
		                  <div class="form-group row">
			                  <label for="new" class="col-sm-3 col-form-label">New Password</label>
			                  <div class="col-sm-9">
				                  <input type="password" name="new" id="new" required="required" class="form-control">
			                  </div>
		                  </div>
		                  <div class="form-group row">
			                  <label for="retype" class="col-sm-3 col-form-label">Retype Password</label>
			                  <div class="col-sm-9">
				                  <input type="password" name="retype" id="retype" required="required" class="form-control">
			                  </div>
		                  </div>
		                  <div id="divCheckPasswordMatch" class="col-12 pt-0 pb-2 text-center text-danger"></div>
		                  <div class="form-group row">
			                  <label for="location" class="col-sm-3 col-form-label"></label>
			                  <div class="col-sm-9">
				                  <input type="submit" name="btnChng" id="passSubmit" value="Change Password"
				                         class="btn btn-primary">
			                  </div>
		                  </div>
	                  </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
  
  include_once "../includes/footer.inc.php";

?>