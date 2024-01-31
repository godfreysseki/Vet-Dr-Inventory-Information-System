<?php
  
  class Animals extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveAnimal($data, $user_id)
    {
      if (isset($data['animal_id']) && !empty($data['animal_id'])) {
        return $this->updateAnimal($data, $user_id);
      } else {
        return $this->insertAnimal($data, $user_id);
      }
    }
    
    private function insertAnimal($data, $user_id)
    {
      $sql    = "INSERT INTO animals (name, species, breed, age, client_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";
      $params = [
        $data['name'],
        $data['species'],
        $data['breed'],
        $data['age'],
        $data['client_id'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added Animal','Animal inserted with ID ' . $insertedId, "Animals", "Success");
        return json_encode(['status' => 'success', 'message' => 'Animal record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert animal record.']);
      }
    }
    
    private function updateAnimal($data, $user_id)
    {
      $sql    = "UPDATE animals SET name = ?, species = ?, breed = ?, age = ?, client_id = ?, user_id = ? WHERE animal_id = ?";
      $params = [
        $data['name'],
        $data['species'],
        $data['breed'],
        $data['age'],
        $data['client_id'],
        $user_id,
        $data['animal_id']
      ];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $updatedRows, 'Updated Animal','Animal updated with ID ' . $data['animal_id'],  "Animals", "Success");
          return json_encode(['status' => 'success', 'message' => 'Animal record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to update animal record.']);
      }
    }
    
    public function deleteAnimal($animal_id, $user_id)
    {
      $sql    = "DELETE FROM animals WHERE animal_id = ?";
      $params = [$animal_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $deletedRows, 'Deleted Animal','Animal deleted with ID ' . $animal_id, "Animals",  "Success");
        return json_encode(['status' => 'success', 'message' => 'Animal record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Animal record already deleted. Reload page to see effect.']);
      }
    }
    
    public function getAllAnimals()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM animals";
      
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
    
    public function displayAnimalsTable()
    {
      $animalsData = $this->getAllAnimals(); // Assume you have a method to fetch all animals data
      
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Species</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Owner</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
      
      // Populate table rows with data
      foreach ($animalsData as $animal) {
        $tableHtml .= '
                <tr>
                    <td>' . $animal['animal_id'] . '</td>
                    <td>' . $animal['name'] . '</td>
                    <td>' . $animal['species'] . '</td>
                    <td>' . $animal['breed'] . '</td>
                    <td>' . $animal['age'] . '</td>
                    <td>' . $this->getClientName($animal['client_id']) . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editAnimal" data-id="' . $animal['animal_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteAnimal" data-id="' . $animal['animal_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
      
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
      
      return $tableHtml;
    }
    
    public function getAnimalById($animal_id)
    {
      $sql    = "SELECT * FROM animals WHERE animal_id = ?";
      $params = [$animal_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayAnimalForm($animal_id = null)
    {
      if ($animal_id !== null) {
        $data = $this->getAnimalById($animal_id);
      } else {
        $data = [
          'animal_id' => '',
          'name' => '',
          'species' => '',
          'breed' => '',
          'age' => '',
          'client_id' => ''
          // Add more fields as needed
        ];
      }
      
      // Form HTML with Bootstrap 4.5 styling
      $form = '
        <form class="needs-validation" id="animalForm" method="post" novalidate> <!-- Adjust the action accordingly -->
            <input type="hidden" name="animal_id" value="' . $data['animal_id'] . '">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="' . $data['name'] . '" required>
                <div class="invalid-feedback">Please enter the name.</div>
            </div>
            
            <div class="form-group">
                <label for="species">Species:</label>
                <input type="text" class="form-control" id="species" name="species" value="' . $data['species'] . '" required>
                <div class="invalid-feedback">Please enter the species.</div>
            </div>
            
            <div class="form-group">
                <label for="breed">Breed:</label>
                <input type="text" class="form-control" id="breed" name="breed" value="' . $data['breed'] . '" required>
                <div class="invalid-feedback">Please enter the breed.</div>
            </div>
            
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="text" class="form-control" id="age" name="age" value="' . $data['age'] . '" required>
                <div class="invalid-feedback">Please enter the age.</div>
            </div>
            
            <div class="form-group">
                <label for="client_id">Client/Owner:</label>
                <select class="custom-select select2" id="client_id" name="client_id" required>
                  '.$this->getClientComboOptions($data['client_id']).'
                </select>
                <div class="invalid-feedback">Please enter the Animal Owner.</div>
            </div>
            
            <!-- Add more form fields as needed -->
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
      
      return $form;
    }
    
  }