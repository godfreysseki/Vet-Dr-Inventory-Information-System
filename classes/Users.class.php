<?php
  
  class users extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function addUser($data)
    {
      if ($data['user_id'] !== null && $data['user_id'] !== "") {
        // Update user data
        $sql    = "UPDATE users SET username=?, full_name=?, email=?, phone_number=?, password=?, salary=?, role=? WHERE user_id=? ";
        $params = [$data['username'], $data['full_name'], $data['email'], $data['phone'], password_hash($data['password'], PASSWORD_DEFAULT), $data['salary'], $data['role'], $data['user_id']];
        $id     = $this->updateQuery($sql, $params);
        // Update Addresses
        $sql    = "UPDATE useraddresses SET address_line1=?, address_line2=?, city=?, postal_code=?, country=? WHERE user_id=? ";
        $params = [$data['address_line1'], $data['address_line2'], $data['city'], $data['postal_code'], $data['country'], $data['user_id']];
        $this->updateQuery($sql, $params);
        return alert('success', 'User Updated Successfully. User Id: ' . $id);
      } else {
        // Insert user data
        $sql    = "INSERT INTO users (username, full_name, email, phone_number, password, salary, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$data['username'], $data['full_name'], $data['email'], $data['phone'], password_hash($data['password'], PASSWORD_DEFAULT), $data['salary'], $data['role']];
        $id     = $this->insertQuery($sql, $params);
        // Insert Addresses
        $sql    = "INSERT INTO useraddresses (user_id, address_line1, address_line2, city, postal_code, country) VALUES (?, ?, ?, ?, ?, ?) ";
        $params = [$id, $data['address_line1'], $data['address_line2'], $data['city'], $data['postal_code'], $data['country']];
        $this->insertQuery($sql, $params);
        return alert('success', 'User Added Successfully. User Id: ' . $id);
      }
    }
    
    public function addUserForm($user_id = null)
    {
      $userData = [
        'username' => '',
        'full_name' => '',
        'email' => '',
        'phone_number' => '',
        'password' => '',
        'salary' => '',
        'role' => '',
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'postal_code' => '',
        'country' => '',
        'user_id' => null,
      ];
      // Get user details for editing
      if ($user_id !== null) {
        $userData = $this->getUserById($user_id);
      }
      
      $form = '<form method="post">
                <input type="hidden" name="user_id" value="' . ($userData['userid'] ?? "") . '">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" id="username" value="' . ($userData['username']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="text" name="full_name" id="full_name" value="' . ($userData['full_name']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" id="email" value="' . ($userData['email']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="phone">Telephone</label>
                      <input type="text" name="phone" id="phone" value="' . ($userData['phone_number']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="text" name="password" id="password" placeholder="Type Current/New Password" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="salary">Salary</label>
                      <input type="number" min="0" name="salary" id="salary" value="'.($userData['salary']).'" required class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="role">User Role</label>
                      <select name="role" id="role" class="select2 form-control">
                        <option value="">-- Select User\'s Role --</option>
                        <option value="admin" ' . (($userData['role'] === "admin") ? "selected" : "") . '>Administrator</option>
                        <option value="tenant" ' . (($userData['role'] === "tenant") ? "selected" : "") . '>Tenant</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="address_line1">Address Line 1</label>
                      <input type="text" name="address_line1" id="address_line1" value="' . ($userData['address_line1']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="address_line2">Address Line 2</label>
                      <input type="text" name="address_line2" id="address_line2" value="' . ($userData['address_line2']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" name="city" id="city" value="' . ($userData['city']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="postal_code">Postal Code</label>
                      <input type="text" name="postal_code" id="postal_code" value="' . ($userData['postal_code']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" name="country" id="country" value="' . ($userData['country']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary float-right">' . ($user_id !== null ? 'Update' : 'Add') . ' User</button>
                    </div>
                  </div>
                </div>
               </form>';
      return $form;
    }
    
    public function addUserFormSelf($user_id = null)
    {
      $userData = [
        'username' => '',
        'full_name' => '',
        'email' => '',
        'phone' => '',
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'postal_code' => '',
        'country' => '',
        'user_id' => null,
      ];
      // Get user details for editing
      if ($user_id !== null) {
        $userData = $this->getUserById($user_id);
      }
      
      $form = '<form method="post">
                <input type="hidden" name="user_id" value="' . ($userData['userid'] ?? "") . '">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" id="username" value="' . ($userData['username']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="text" name="full_name" id="full_name" value="' . ($userData['full_name']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" id="email" value="' . ($userData['email']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="phone">Telephone</label>
                      <input type="text" name="phone" id="phone" value="' . ($userData['phone_number']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="address_line1">Address Line 1</label>
                      <input type="text" name="address_line1" id="address_line1" value="' . ($userData['address_line1']) . '" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="address_line2">Address Line 2</label>
                      <input type="text" name="address_line2" id="address_line2" value="' . ($userData['address_line2']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" name="city" id="city" value="' . ($userData['city']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="postal_code">Postal Code</label>
                      <input type="text" name="postal_code" id="postal_code" value="' . ($userData['postal_code']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" name="country" id="country" value="' . ($userData['country']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <button name="btn" class="btn btn-primary float-right">' . ($user_id !== null ? 'Update' : 'Add') . ' Profile</button>
                    </div>
                  </div>
                </div>
               </form>';
      return $form;
    }
  
    public function getAllUsers()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT *, users.user_id AS userid FROM users LEFT JOIN useraddresses u ON users.user_id = u.user_id";
    
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
  
    public function displayUsersTable()
    {
      $expensesData = $this->getAllUsers(); // Assume you have a method to fetch all animals data
    
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Salary</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Reg. Date</th>
                        <th>Last Login</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($expensesData as $expense) {
        $tableHtml .= '
                <tr>
                    <td>' . $expense['userid'] . '</td>
                    <td>' . $expense['username'] . '</td>
                    <td>' . $expense['full_name'] . '</td>
                    <td>' . email($expense['email']) . '</td>
                    <td>' . phone($expense['phone_number']) . '</td>
                    <td>' . number_format($expense['salary']) . '</td>
                    <td>' . $expense['postal_code'] . '<br>' . $expense['address_line1'] . ', ' . $expense['address_line2'] . '<br>' . $expense['city'] . ', ' . $expense['country'] . '</td>
                    <td>' . $expense['role'] . '</td>
                    <td>' . datel($expense['registration_date']) . '</td>
                    <td>' . datel($expense['last_login']) . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editUser" data-id="' . $expense['userid'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteUser" data-id="' . $expense['userid'] . '">Delete</button>
                    </td>
                </tr>';
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
    
      return $tableHtml;
    }
    
    public function getUserById($user_id)
    {
      $sql    = "SELECT users.*, users.user_id AS userid, useraddresses.* FROM users LEFT JOIN useraddresses ON users.user_id=useraddresses.user_id WHERE users.user_id=?";
      $params = [$user_id];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    public function loginUser($username, $password)
    {
      $sql    = "SELECT user_id, username, full_name, password, role FROM users WHERE username = ?";
      $params = [$username];
      $result = $this->selectQuery($sql, $params);
      
      if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
          // Update last login
          $this->updateQuery("UPDATE users SET last_login=? WHERE user_id=?", [date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']), $user['user_id']]);
          // Login the user
          // Password is correct, set up the session
          $_SESSION['user_id']  = $user['user_id'];
          $_SESSION['user']     = $user['full_name'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['role']     = $user['role'];
          switch ($_SESSION['role']) {
            case 'admin':
              header('location: admin/');
              break;
            case 'tenant':
              header('location: tenant/');
              break;
            default:
              header('location: ./');
          }
        }
      }
      return false;
    }
    
    public function logoutUser()
    {
      session_unset();
      session_destroy();
      header('location: ./');
    }
    
    public function checkRole($requiredRole)
    {
      if (isset($_SESSION['role'])) {
        $sessionRole = strtolower(str_replace("_", "", $_SESSION['role']));
        $dir         = strtolower($requiredRole);
        if ($sessionRole !== $dir) {
          header('location: ../logout.php');
        }
      } else {
        header('location: ../logout.php');
      }
    }
    
    public function deleteUser($userId)
    {
      $sql    = "DELETE FROM users WHERE user_id=?";
      $params = [$userId];
      $this->deleteQuery($sql, $params);
      
      $sql    = "DELETE FROM useraddresses WHERE user_id=?";
      $params = [$userId];
      $this->deleteQuery($sql, $params);
      return alert('success', 'User Deleted Successfully. User Id: ' . $userId);
    }
    
    // User Profile Management
    
    // Change password from the email after forgetting your login credentials.
    public function updatepassword($old, $new)
    {
      $oldpassword = ($old);
      $newpassword = password_hash($new, PASSWORD_DEFAULT);
      
      // Check if the old password matches with the one in database
      $sql    = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "' ";
      $result = $this->selectQuery($sql);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if (password_verify($oldpassword, $row['password'])) {
            // Change the user's Password
            $sqls = "UPDATE users SET password='" . $newpassword . "' WHERE username='" . $_SESSION['username'] . "' ";
            if ($this->updateQuery($sqls)) {
              return alert('success', 'Password Changed Successfully.');
            } else {
              return alert('warning', 'Password Update Failed.');
            }
          } else {
            return alert('warning', 'Your Passwords don\'t match the one in the database.');
          }
        }
      } else {
        return alert('warning', 'Your Username does not exist.');
      }
    }
    
    public function updatepicture($pic, $tmp)
    {
      if (!empty($_FILES["profimg"]["name"])) {
        $imagedir = "../assets/img/users/";
        $images   = $pic;
        $image    = $imagedir . $pic;
        
        // Update Profile image
        if (!empty($_FILES["profimg"]["name"])) {
          // Get old image and delete it from folder
          $gets = "SELECT image FROM users WHERE username='" . $_SESSION['username'] . "' ";
          $get  = $this->runSQL($gets);
          if ($get->num_rows > 0) {
            while ($row = $get->fetch_array()) {
              $imager = $row['image'];
              // Remove Image
              if (file_exists($imager)) {
                unlink($imager);
              }
            }
          }
          
          if (move_uploaded_file($tmp, $image)) {
            // Rename File
            $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $timer     = time();
            rename($image, $imagedir . $timer . "." . $extension);
            $newname = $imagedir . $timer . "." . $extension;
            
            // Write to database image and system log
            $datas = "UPDATE users SET image='" . $newname . "' WHERE username='" . $_SESSION['username'] . "' ";
            
            $this->logs($datas, "Updated Profile Picture");
            $this->runSQL($datas);
            alert('success', 'Image Updated Successfully');
          }
        }
      }
    }
    
    public function updateProfile($data)
    {
      // Update user data
      $sql    = "UPDATE users SET username=?, full_name=?, email=?, phone_number=? WHERE user_id=? ";
      $params = [$data['username'], $data['full_name'], $data['email'], $data['phone'], $_SESSION['user_id']];
      $id     = $this->updateQuery($sql, $params);
      // Update Addresses
      $sql    = "UPDATE useraddresses SET address_line1=?, address_line2=?, city=?, postal_code=?, country=? WHERE user_id=? ";
      $params = [$data['address_line1'], $data['address_line2'], $data['city'], $data['postal_code'], $data['country'], $_SESSION['user_id']];
      $this->updateQuery($sql, $params);
      return alert('success', 'Profile Updated Successfully.');
    }
    
  }