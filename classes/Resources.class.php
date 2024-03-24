<?php
  
  
  class Resources extends Config
  {
    private $auditTrail;
  
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
  
    // Add a new resource to the database
    public function addResource($resourceData)
    {
      if (isset($resourceData['resource_id']) && !empty($resourceData['resource_id'])) {
        $resourceImages = $this->getResourceImage($resourceData['resource_id']);
        // Handle image upload
      
        if (!empty($_FILES['image']['name'])) {
          $uploadDir      = '../assets/img/resources/';
          $uniqueFilename = 'resource_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
          // Remove Old Image
          if (file_exists($uploadDir . $resourceImages)) {
            unlink($uploadDir . $resourceImages);
          }
        
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $resourceImage = $uniqueFilename;
          } else {
            // Image upload failed
            $resourceImage = $resourceImages; // or set to a default image
          }
        } else {
          $resourceImage = $resourceImages; // No image provided
        }
      } else {
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
          $uploadDir      = '../assets/img/resources/';
          $uniqueFilename = 'resource_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
        
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $resourceImage = $uniqueFilename;
          } else {
            // Image upload failed
            $resourceImage = ''; // or set to a default image
          }
        } else {
          $resourceImage = ''; // No image provided
        }
      }
    
      if (isset($resourceData['resource_id']) && !empty($resourceData['resource_id'])) {
        // Update Resource
        $sql    = 'update resources set title=?, description=?, link=?, image=? where resource_id=?';
        $params = [
          $resourceData['title'],
          $resourceData['description'],
          $resourceData['link'],
          $resourceImage,
          $resourceData['resource_id']
        ];
      
        $resourceId = $this->insertQuery($sql, $params);
      
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, $resourceId, 'Resource added', 'Resource ID: ' . $resourceId);
      
        return $resourceId;
      } else {
        $sql    = 'insert into resources (image, title, description, link) values (?, ?, ?, ?)';
        $params = [
          $resourceImage,
          $resourceData['title'],
          $resourceData['description'],
          $resourceData['link']
        ];
      
        $resourceId = $this->insertQuery($sql, $params);
      
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, $resourceId, 'Resource added', 'Resource ID: ' . $resourceId);
      
        return $resourceId;
      }
    }
  
    // Get the resource form for adding a new resource or updating an existing one
    public function resourceForm($resourceId = null)
    {
      // Define the resource data array with empty values for the form
      $resourceData = [
        'resource_id' => '',
        'title' => '',
        'description' => '',
        'link' => '',
        'image' => '' // Assuming the image filename/path is provided in the resource data
      ];
    
      // If $resourceId is provided, fetch the resource data from the database
      if ($resourceId !== null) {
        $sql         = "select * from resources where resource_id = ?";
        $params      = [$resourceId];
        $resourceData = $this->selectQuery($sql, $params)->fetch_assoc();
      }
    
      // Start building the HTML form
      $form = '<form method="post" enctype="multipart/form-data" class="resource_form">
                  <input type="hidden" name="resource_id" value="' . $resourceId . '">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="image">Resource Image <small>(' . htmlspecialchars($resourceData['image']) . ')</small></label>
                        <input type="file" class="form-control-file" id="image" name="image">
                      </div>
                      <div class="form-group">
                        <label for="link">Resource Link<small>(Youtube Share Link)</small></label>
                        <input type="url" class="form-control" id="link" name="link" value="' . htmlspecialchars($resourceData['link']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="title">Resource Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="' . htmlspecialchars($resourceData['title']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">' . htmlspecialchars($resourceData['description']) . '</textarea>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary float-right">' . ($resourceId !== null ? 'Update' : 'Add') . ' Resource</button>
                      </div>
                    </div>
                  </div>
                </form>';
    
      return $form;
    }
  
    // Delete a resource from the database
    public function deleteResource($resourceId)
    {
      $sql    = 'delete from resources where resource_id = ?';
      $params = [$resourceId];
      if ($this->deleteQuery($sql, $params)) {
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 3, $resourceId, 'Resource deleted', 'Resource ID: ' . $resourceId, 'Resources', 'Success');
      
        return json_encode(['status' => 'success', 'message' => 'Resource/Item deleted Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Resource/Item already deleted. Reload to see effect.']);
      }
    }
  
    // Example method using the SELECT query template
    public function getResourceById($resourceId)
    {
      $sql    = 'select * from resources where resource_id = ?';
      $params = [$resourceId];
    
      $result = $this->selectQuery($sql, $params);
    
      if ($result->num_rows > 0) {
        // Fetch and return the resource data
        return $result->fetch_assoc();
      } else {
        return null;
      }
    }
  
    // Get all resources from the database
    public function getResources()
    {
      $sql    = 'select * from resources ORDER BY resource_id DESC';
      $result = $this->selectQuery($sql);
    
      $resources = [];
      while ($row = $result->fetch_assoc()) {
        $resources[] = $row;
      }
    
      return $resources;
    }
  
    public function displayResourcesTable()
    {
      $clientsData = $this->getResources(); // Assume you have a method to fetch all animals data
      $no = 1;
    
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($clientsData as $clientData) {
        $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td><img src="../assets/img/resources/' . $clientData['image'] . '" alt="Resource image"></td>
                    <td>' . $clientData['title'] . '</td>
                    <td>' . $clientData['description'] . '</td>
                    <td><a href="' . $clientData['link'] . '" target="_blank">' . $clientData['link'] . '</a></td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editResource" data-id="' . $clientData['resource_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteResource" data-id="' . $clientData['resource_id'] . '">Delete</button>
                    </td>
                </tr>';
        $no++;
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
    
      return $tableHtml;
    }
    
    private function getResourceImage($product_id)
    {
      $sql  = "select image from resources where resource_id=?";
      $data = $this->selectQuery($sql, [$product_id])->fetch_assoc();
      return $data['image'];
    }
  
    public function displayResourcesUser()
    {
      $data = '';
      $rows = $this->getResources();
      foreach ($rows as $row) {
        $data .= '<div class="col-6 col-md-3">
                    <div class="video-item">
                      <div class="video-thumbnail">
                        <a href="'.$row['link'].'" class="venobox" data-vbtype="video" data-autoplay="true">
                          <!-- Embed video thumbnail image -->
                          <img src="assets/img/resources/'.$row['image'].'" alt="Video Thumbnail" class="img-fluid">
                          <!-- Play button overlay -->
                          <div class="play-button"></div>
                        </a>
                      </div>
                      <div class="video-details">
                        <h3 class="video-title">'.$row['title'].'</h3>
                        <p class="video-description">'.$row['description'].'</p>
                      </div>
                    </div>
                  </div>';
      }
      return $data;
    }
  
  }