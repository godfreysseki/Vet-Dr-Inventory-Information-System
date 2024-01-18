<?php
  
  class AuditTrail extends Config
  {
    
    public function __construct()
    {
      parent::__construct();
    }
    
    public function logActivity($userId, $activityType, $entityId, $activity, $details = '', $module = '', $status = '')
    {
      
      $userAgent = $this->getBrowser() . " on " . $this->getOS();
      $status    = 'Success';
      $sql       = 'insert into audittrail (user_id, activity_type, entity_id, activity, details, module, user_agent, status) values (?, ?, ?, ?, ?, ?, ?, ?)';
      $params    = [
        $userId,
        $activityType,
        $entityId,
        $activity,
        $details,
        $module,
        $userAgent,
        $status
      ];
      
      return $this->insertQuery($sql, $params);
    }
    
    public function getAuditTrails()
    {
      $sql         = "select * from audittrail INNER JOIN users on audittrail.user_id=users.user_id order by log_id desc";
      $result      = $this->selectQuery($sql);
      $auditTrails = [];
      
      while ($row = $result->fetch_assoc()) {
        $auditTrails[] = $row;
      }
      
      return $auditTrails;
    }
  
    public function getUserAuditTrails($userId)
    {
      $id = intval($userId);
      $sql = "select * from audittrail where user_id=? order by log_id desc ";
      $params = [$id];
      $result = $this->selectQuery($sql, $params);
    
      $trails = [];
      while ($row = $result->fetch_assoc()) {
        $trails[] = $row;
      }
    
      return $trails;
    }
    
    private function getOS()
    {
      $user_agent  = $_SERVER['HTTP_USER_AGENT'];
      $os_platform = "Unknown OS";
      $os_array    = [
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
      ];
      foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
          $os_platform = $value;
        }
      }
      
      return $os_platform;
    }
    
    private function getBrowser()
    {
      $u_agent = $_SERVER['HTTP_USER_AGENT'];
      $bname   = 'Unknown';
      $version = "";
      
      // Next get the name of the useragent yes seperately and for good reason
      if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub    = "MSIE";
      } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub    = "Firefox";
      } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub    = "Chrome";
      } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub    = "Safari";
      } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub    = "Opera";
      } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub    = "Netscape";
      }
      
      // finally get the correct version number
      $known   = ['Version', $ub, 'other'];
      $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
      
      if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
      }
      
      // see how many we have
      $i = count($matches['browser']);
      
      if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
          $version = $matches['version'][0];
        } else {
          $version = $matches['version'][1];
        }
      } else {
        $version = $matches['version'][0];
      }
      
      // check if we have a number
      if ($version == null || $version == "") {
        $version = "?";
      }
      
      return $bname . ' ' . $version;
    }
    
    public function runBackup()
    {
      //$this->logActivity($_SESSION['user_id'], );
      // Define backup folders
      $backupDir     = '../Backup';
      $dbBackupDir   = $backupDir . '/database';
      $imgBackupDir  = $backupDir . '/img';
      $imgUploadsDir = $imgBackupDir . '/uploads';
      
      $folders = [$backupDir, $dbBackupDir, $imgBackupDir, $imgUploadsDir];
      
      // Create folders if not available
      foreach ($folders as $folder) {
        if (!is_dir($folder) && !mkdir($folder) && !is_dir($folder)) {
          throw new \RuntimeException(sprintf('Directory "%s" was not created', $folder));
        }
      }
      
      // Backup database
      $dbBackupFilename = $dbBackupDir . '/' . DB_NAME . '_backup_' . date('Y_m_d_H_i', $_SERVER['REQUEST_TIME']) . '.sql';
      try {
        $this->backupDatabase($dbBackupFilename);
      } catch (Exception $e) {
      }
  
      // Backup image files
      $this->backupImageFiles('../assets/img', $imgBackupDir);
      $this->backupImageFiles('../assets/img/uploads', $imgUploadsDir);
      
      // Create zip file
      $this->createZippedFile($backupDir);
    }
    
    private function backupDatabase($backupFilename)
    {
      // Define backup directory and filename
      $backupDir = '../Backup/database/';
      $backupFilename = $backupDir . DB_NAME . '_backup_' . date('YmdHis') . '.sql';
    
      // Initialize SQL dump
      $sqlDump = '';
    
      // Fetch list of tables
      $tables = $this->selectQuery("SHOW TABLES");
      while ($row = $tables->fetch_row()) {
        $tableName = $row[0];
      
        // Fetch table structure
        $tableCreate = $this->selectQuery("SHOW CREATE TABLE $tableName");
        $createRow = $tableCreate->fetch_row();
        $tableStructure = $createRow[1];
  
        // Get table fields
        $data_fields = [];
        $work        = $this->selectQuery("SELECT * FROM ".$tableName);
        $fields      = $work->fetch_fields();
        // Fields Array
        foreach ($fields as $field) {
          $data_fields[] = "`".$field->name."`";
        }
  
        // Append table structure to SQL dump
        $sqlDump .= "\n-- Creating Table `$tableName`\n";
        $sqlDump .= "\n".$tableStructure . ";\n\n";
      
        // Fetch table data
        $tableData = $this->selectQuery("SELECT * FROM $tableName");
        while ($dataRow = $tableData->fetch_assoc()) {
          $sqlDump .= "INSERT INTO $tableName (".implode(", ", $data_fields).") VALUES (";
          foreach ($dataRow as $value) {
            $sqlDump .= "'" . esc($value) . "', ";
          }
          $sqlDump = rtrim($sqlDump, ', ') . ");\n";
        }
      }
    
      // Save SQL dump to backup file
      file_put_contents($backupFilename, $sqlDump);
    
      // Provide user feedback
      if (file_exists($backupFilename)) {
        return "Database backup created successfully.";
      } else {
        throw new Exception("Failed to create database backup.");
      }
    }
    
    private function backupImageFiles($sourceDir, $backupDir)
    {
      $images = glob($sourceDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
      
      foreach ($images as $image) {
        $newImage = $backupDir . '/' . basename($image);
        if (!copy($image, $newImage)) {
          throw new \RuntimeException('Failed to copy image: ' . $image);
        }
      }
    }
    
    private function createZippedFile($backupDir)
    {
      $zip      = new ZipArchive();
      $filename = '../Backup/' . COMPANY . '_' . date('Y_m_d_H_i', $_SERVER['REQUEST_TIME']) . '.zip';
      
      if ($zip->open($filename, ZipArchive::CREATE) !== true) {
        throw new \RuntimeException('Failed to create zip file');
      }
      
      $this->addToZip($zip, $backupDir);
      
      $zip->close();
      
      // Download the zip file
      $this->downloadZipFile($filename);
      
      // Delete the zip file
      unlink($filename);
    }
    
    private function addToZip($zip, $dir)
    {
      $files = scandir($dir);
      
      foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
          $path = $dir . '/' . $file;
          
          if (is_dir($path)) {
            $this->addToZip($zip, $path);
          } else {
            $zip->addFile($path, substr($path, strlen('../Backup/')));
          }
        }
      }
    }
    
    private function downloadZipFile($filename)
    {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($filename));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($filename));
      ob_clean();
      flush();
      readfile($filename);
      //delete_directory('../Backup/');
    }
  
    public function deleteDirectory($dir) {
      if (!is_dir($dir)) {
        throw new InvalidArgumentException("$dir must be a directory");
      }
    
      if (substr($dir, -1) != '/') {
        $dir .= '/';
      }
    
      $files = glob($dir . '*', GLOB_MARK);
      foreach ($files as $file) {
        if (is_dir($file)) {
          $this->deleteDirectory($file);
        } else {
          unlink($file);
        }
      }
      rmdir($dir);
    }
  
    public function clearAllAuditTrails()
    {
      if (ucwords(strtolower($_SESSION['role'])) == 'Admin') {
        $sql = "TRUNCATE TABLE audittrail";
        if ($this->selectQuery($sql)) {
          return json_encode(['status' => 'success', 'message' => 'All Audit Trails have been cleared successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Audit trails already cleared from the database. Reload to see effect.']);
        }
      } else {
        return json_encode(['status' => 'warning', 'message' => 'You are not allowed to perform this operation.']);
      }
    }
  
  
  }
  /*
   // Usage example:
   $config     = new Config();
   $auditTrail = new AuditTrail($config);
   
   // Example of logging an activity with old and new values for an update operation
   $userId       = 123;                         // The ID of the user performing the activity
   $activityType = 1;                           // Numeric identifier for the activity type (e.g., 1 for "Update")
   $entityId     = 456;                         // ID of the affected entity (e.g., product ID)
   $activity     = 'Product updated';           // Description of the activity
   $details      = 'Product ID: 456';           // Additional details (optional)
   $oldValue     = 'Old product name';          // Old value of the affected data
   $newValue     = 'New product name';          // New value of the affected data
   $module       = 'Product Management';        // Context or module where the activity occurred
   $userAgent    = $_SERVER['HTTP_USER_AGENT']; // User agent information
   $status       = 'success';                   // Status of the activity (e.g., 'success' or 'failure')
   
   // Call the logActivity method (assuming it's implemented in the audittrail class)
   $logId = $auditTrail->logActivity($userId, $activityType, $entityId, $activity, $details, $oldValue, $newValue, $module, $userAgent, $status);
   
   
   $config->closeConnection();*/
