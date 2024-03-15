<?php
  
  
  class Blogs extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    
    public function saveBlog($data, $user_id)
    {
      if (isset($data['bid']) && !empty($data['bid'])) {
        return $this->updateBlog($data, $user_id);
      } else {
        return $this->insertBlog($data, $user_id);
      }
    }
    
    private function insertBlog($data, $user_id)
    {
      // Handle file uploads
      $images = [];
  
      if (!empty($_FILES['images']['name'][0])) {
        $files     = $_FILES['images'];
        $uploadDir = '../assets/img/blogs/'; // Set the upload directory path
    
        foreach ($files['name'] as $key => $fileName) {
          $tempName    = $files['tmp_name'][$key];
          $extension   = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension
          $newFileName = 'blog_' . uniqid() . '.' . $extension;  // Create a unique filename with the original extension
          $destination = $uploadDir . $newFileName;
      
          // Move the uploaded file to the desired location
          if (move_uploaded_file($tempName, $destination)) {
            $images[] = $newFileName;
          }
        }
    
      }
  
  
      $sql    = "INSERT INTO blogs (image, title, author, tags, description, regdate) VALUES (?, ?, ?, ?, ?, ?)";
      $params = [
        implode(', ', $images), // Convert array of image filenames to a comma-separated string
        $data['title'],
        $data['author'],
        $data['tags'],
        $data['description'],
        date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
      ];
  
      $insertedId = $this->insertQuery($sql, $params);
  
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added Blog', 'Blog inserted with ID ' . $insertedId, 'Blogs', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Blog record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert blog record.']);
      }
    }
    
    private function updateBlog($data, $user_id)
    {
      // Handle file uploads
      $images = explode(", ", $this->getBlogById($data['bid'])['image']);
  
      if (!empty($_FILES['images']['name'][0])) {
        $files = $_FILES['images'];
        $uploadDir = '../assets/img/blogs/';
    
        foreach ($files['name'] as $key => $fileName) {
          $tempName = $files['tmp_name'][$key];
          $extension = pathinfo($fileName, PATHINFO_EXTENSION);
          $newFileName = 'blog_' . uniqid() . '.' . $extension;
          $destination = $uploadDir . $newFileName;
      
          if (move_uploaded_file($tempName, $destination)) {
            $images[] = $newFileName;
          }
        }
      }
  
      // Prepare the SQL query for updating event data
      $sql = "UPDATE blogs SET image = ?, title = ?, description = ?, tags = ?, author = ? WHERE bid = ?";
      $params = [
        implode(', ', $images), // Convert array of image filenames to a comma-separated string
        $data['title'],
        $data['description'],
        $data['tags'],
        $data['author'],
        $data['bid']
      ];
  
      // Execute the update query
      $updatedRows = $this->updateQuery($sql, $params);
  
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $updatedRows, 'Updated Blog', 'Blog updated with ID ' . $updatedRows, 'Blogs', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Blog record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to update blog record.']);
      }
    }
    
    public function deleteBlog($blog_id, $user_id)
    {
      $uploadDir = '../assets/img/blogs/';
  
      // Fetch the images associated with the event
      $sql = "SELECT image FROM blogs WHERE bid = ?";
      $params = [$blog_id];
      $result = $this->selectQuery($sql, $params);
  
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $images = explode(', ', $row['images']); // Assuming images are stored as comma-separated values in the database
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No blog found with the provided ID.']);
      }
  
      // Delete the event from the database
      $sql = "DELETE FROM blogs WHERE bid = ?";
      $deletedRows = $this->deleteQuery($sql, $params);
  
      if ($deletedRows) {
        // Log the activity
        $this->auditTrail->logActivity($user_id, 3, $deletedRows, 'Deleted Blog', 'Blog deleted with ID ' . $deletedRows, 'Blogs', 'Success');
    
        // Delete associated images
        foreach ($images as $image) {
          $filePath = $uploadDir . $image;
          if (file_exists($filePath)) {
            unlink($filePath); // Delete the file if it exists
          }
        }
    
        return json_encode(['status' => 'success', 'message' => 'Blog deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Blog could not be deleted.']);
      }
    }
    
    public function getAllBlogs()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM blogs ORDER BY bid DESC";
      
      // Execute the query and fetch the results
      $result = $this->selectQuery($sql);
      
      // Initialize an array to store the fetched data
      $animalsData = [];
      
      // Fetch each row as an associative array
      while ($row = $result->fetch_assoc()) {
        $animalsData[] = $row;
      }
      
      return $animalsData;
    }
    
    public function displayBlogsTable()
    {
      $clientsData = $this->getAllBlogs(); // Assume you have a method to fetch all animals data
      $no = 1;
  
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Author</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
      
      // Populate table rows with data
      foreach ($clientsData as $clientsData) {
        $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . dates($clientsData['regdate']) . '</td>
                    <td>' . $clientsData['title'] . '</td>
                    <td>' . $clientsData['author'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-success btn-sm viewBlog" data-id="' . $clientsData['bid'] . '">View</button>
                        <button class="btn btn-info btn-sm editBlog" data-id="' . $clientsData['bid'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteBlog" data-id="' . $clientsData['bid'] . '">Delete</button>
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
    
    public function getBlogById($client_id)
    {
      $sql    = "SELECT * FROM blogs WHERE bid = ?";
      $params = [$client_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayBlogForm($client_id = null)
    {
      if ($client_id !== null) {
        $data = $this->getBlogById($client_id);
      } else {
        $data = [
          'bid' => '',
          'image' => '',
          'title' => '',
          'author' => '',
          'tags' => '',
          'description' => ''
        ];
      }
      
      $form = '
            <form class="needs-validation" method="post" id="blogsForm" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="bid" value="' . $data['bid'] . '">
                
                <div class="form-group">
                    <label for="images">Blog Images <small>(' . $data['image'] . ')</small>:</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                    <div class="invalid-feedback">Please enter at least 1 image.</div>
                </div>
                
                <div class="form-group">
                    <label for="title">Blog Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="' . $data['title'] . '" required>
                    <div class="invalid-feedback">Please enter the Author.</div>
                </div>
                
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" class="form-control" id="author" name="author" value="' . $data['author'] . '" required>
                    <div class="invalid-feedback">Please enter the Author.</div>
                </div>
                
                <div class="form-group">
                    <label for="tags">Tags <small>(Separate with comma and space)</small>:</label>
                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Animal Care, Treatment ..." value="' . $data['tags'] . '" required>
                    <div class="invalid-feedback">Please enter the Tags.</div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description/Content:</label>
                    <textarea class="form-control editor" id="description" name="description" required>' . $data['description'] . '</textarea>
                    <div class="invalid-feedback">Please enter the Blog Content.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>';
      
      return $form;
    }
    
    public function displayBlogs()
    {
      $data = '';
      $blogs = $this->getAllBlogs();
  
      foreach ($blogs as $blog) {
        $data .= '<div class="col-sm-6 col-md-3 blog">
                    <div class="post-entry">
                      <a href="blog.php?id='.$blog['bid'].'" class="d-block mb-1">
                        <img src="assets/img/blogs/'.str_replace("../", "", explode(", ", $blog['image'])[0]).'" alt="Image" class="img-fluid">
                      </a>
                      <div class="post-text px-3 py-1">
                        <span class="post-meta">'.dates($blog['regdate']).' &bullet; By <a href="#">'.$blog['author'].'</a></span>
                        <h3><a href="blog.php?id='.$blog['bid'].'">'.$blog['title'].'</a></h3>
                        <p>'.reduceWords(strip_tags($blog['description']), 50).'</p>
                        <p><a href="blog.php?id='.$blog['bid'].'" class="readmore">Read more</a></p>
                      </div>
                    </div>
                  </div>';
      }
      
      return $data;
    }
    
  }