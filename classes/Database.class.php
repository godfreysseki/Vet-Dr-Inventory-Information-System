<?php
  
  class Database
  {
    private static $instance;
    private        $host     = DB_HOST;
    private        $username = DB_USER;
    private        $password = DB_PASS;
    private        $database = DB_NAME;
    private        $connection;
    
    public function __construct()
    {
      $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
      
      if ($this->connection->connect_error) {
        die('Database connection failed: ' . $this->connection->connect_error);
      }
    }
    
    public static function getInstance()
    {
      if (!self::$instance) {
        self::$instance = new self();
      }
      
      return self::$instance;
    }
    
    public function getConnection()
    {
      return $this->connection;
    }
  }