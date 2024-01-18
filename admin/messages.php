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
        <div class="col-md-3">
          <!-- Contacts -->
          <div class="card contacts">
            <div class="card-header">
              <h3 class="card-title">Contacts</h3>
            
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0 contact-list">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="#" class="nav-link">
                    <i class="fas fa-inbox"></i> Inbox
                    <span class="badge bg-primary float-right">12</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-file-alt"></i> Drafts
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-filter"></i> Junk
                    <span class="badge bg-warning float-right">65</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                  </a>
                </li>
                <li class="nav-item active">
                  <a href="#" class="nav-link">
                    <i class="fas fa-inbox"></i> Inbox
                    <span class="badge bg-primary float-right">12</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-file-alt"></i> Drafts
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-filter"></i> Junk
                    <span class="badge bg-warning float-right">65</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                  </a>
                </li>
                <li class="nav-item active">
                  <a href="#" class="nav-link">
                    <i class="fas fa-inbox"></i> Inbox
                    <span class="badge bg-primary float-right">12</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-file-alt"></i> Drafts
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-filter"></i> Junk
                    <span class="badge bg-warning float-right">65</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <!-- Direct Chat -->
          <div class="card direct-chat direct-chat-primary  card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Direct Chat</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <!-- /.direct-chat-infos -->
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp ml-2 float-left">23 Jan 2:00 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
        
                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <!-- /.direct-chat-infos -->
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    You better believe it!
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp mr-2 float-right">23 Jan 2:05 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
        
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    Working with AdminLTE on a great new app! Wanna join?
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp ml-2 float-left">23 Jan 5:37 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
        
                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    I would love to.
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp mr-2 float-right">23 Jan 6:10 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
                
                
                
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <!-- /.direct-chat-infos -->
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp ml-2 float-left">23 Jan 2:00 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
        
                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <!-- /.direct-chat-infos -->
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    You better believe it!
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp mr-2 float-right">23 Jan 2:05 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
        
                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    Working with AdminLTE on a great new app! Wanna join?
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp ml-2 float-left">23 Jan 5:37 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
        
                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <img class="direct-chat-img" src="../assets/img/user.png" alt="message user image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    I would love to.
                  </div>
                  <!-- /.direct-chat-text -->
                  <span class="direct-chat-timestamp mr-2 float-right">23 Jan 6:10 pm</span>
                </div>
                <!-- /.direct-chat-msg -->
      
              </div>
              <!--/.direct-chat-messages-->
      
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <form method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                  <span class="input-group-append">
                          <button type="button" class="btn btn-primary">Send</button>
                        </span>
                </div>
              </form>
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include_once "../includes/footer.inc.php";

?>