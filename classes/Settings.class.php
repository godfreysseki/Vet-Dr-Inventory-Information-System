<?php
  
  class Settings extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function addSettings($company_name, $company_slogan, $address, $phone1, $phone2, $email, $currency)
    {
      // Handle Logo upload
      if (!empty($_FILES['logo']['name'])) {
        $uploadDir      = '../assets/img/';
        $uniqueFilename = 'logo.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $uploadFile     = $uploadDir . $uniqueFilename;
        
        if (file_exists($uploadFile)) {
          unlink($uploadFile);
        }
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
          // Image uploaded successfully, save the unique filename to the database
          $logo = $uniqueFilename;
        } else {
          // Image upload failed
          $logo = 'logo.png'; // or set to a default image
        }
      } else {
        $logo = 'logo.png'; // No image provided
      }
      
      // Check to update or insert to the database
      $check = $this->getGeneralSettings();
      if ($check) {
        $sql    = 'update general_settings set logo=?, company_name=?, company_slogan=?, address=?, phone1=?, phone2=?, email=?, currency=? WHERE setting_id=?';
        $params = [
          $logo,
          $company_name,
          $company_slogan,
          $address,
          $phone1,
          $phone2,
          $email,
          $currency,
          1
        ];
        $settingsId = $this->updateQuery($sql, $params);
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, 1, 'Setting Updated', 'Updated for the company profile', $company_name, $company_name, 'Settings');
      } else {
        $sql    = 'insert into general_settings (logo, company_name, company_slogan, address, phone1, phone2, email, currency) values (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = [
          $logo,
          $company_name,
          $company_slogan,
          $address,
          $phone1,
          $phone2,
          $email,
          $currency,
        ];
        $settingsId = $this->insertQuery($sql, $params);
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, null, 'Setting added', 'Added the company profile', '', $company_name, 'Settings');
      }
  
      if ($settingsId) {
        return alert('success', 'Saved Company Profile Successfully.');
      } else {
        return alert('warning', 'Saving Company Profile Failed.');
      }
    }
    
    public function addSettingsForm()
    {
      $settingData = [
        'logo' => '',
        'company_name' => '',
        'company_slogan' => '',
        'address' => '',
        'phone1' => '',
        'phone2' => '',
        'email' => '',
        'currency' => '',
      ];
      
      $sql    = "select * from general_settings";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $settingData = $result->fetch_assoc();
      }
      
      // Build the HTML form
      $form = '<form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="logo">Company Logo</label>
                  <input type="file" class="form-control-file" id="logo" name="logo" accept="image/png">
                </div>
                <div class="form-group">
                  <label for="company_name">Business Name</label>
                  <input type="text" class="form-control" id="company_name" name="company_name" value="' . esc($settingData['company_name']) . '" required>
                </div>
                <div class="form-group">
                  <label for="company_slogan">Company Slogan</label>
                  <input type="text" class="form-control" id="company_slogan" name="company_slogan" value="' . esc($settingData['company_slogan']) . '">
                </div>
                <div class="form-group">
                  <label for="address">Location Address</label>
                  <input type="text" class="form-control" id="address" name="address" value="' . esc($settingData['address']) . '" required>
                </div>
                <div class="form-group">
                  <label for="phone1">Telephone Line 1</label>
                  <input type="text" class="form-control" id="phone1" name="phone1" value="' . esc($settingData['phone1']) . '" required>
                </div>
                <div class="form-group">
                  <label for="phone2">Telephone Line 2</label>
                  <input type="text" class="form-control" id="phone2" name="phone2" value="' . esc($settingData['phone2']) . '">
                </div>
                <div class="form-group">
                  <label for="email">Business Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="' . esc($settingData['email']) . '" required>
                </div>
                <div class="form-group">
                  <label for="currency">Currency Symbol</label>
                  <input type="text" class="form-control" id="currency" name="currency" placeholder="UGX" value="' . esc($settingData['currency']) . '" required>
                </div>
                <button type="submit" class="btn btn-primary">' . (($settingData['company_name'] !== null || $settingData['company_name'] !== "") ? 'Update' : 'Add') . ' Setting</button>
              </form>';
      
      return $form;
    }
    
    // General Settings
    public function getGeneralSettings()
    {
      $sql = "select * from general_settings";
      return $this->selectQuery($sql)->fetch_assoc();
    }
  }
