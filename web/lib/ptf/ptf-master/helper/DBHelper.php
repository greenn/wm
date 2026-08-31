<?php

class DBHelper {

  static $dbConfig;
  private static $dbHelper;
  private $mysqli;
  private $db;
  
  private function __construct() {
    $config = static::$dbConfig; //require __DIR__.'/../config.php';
    if ($config['print_config']) print_r($config);

    $this->mysqli = new mysqli($config['dbhost'], $config['username'], $config['password']) or die("Could not connect");
    $this->db = $this->mysqli->select_db ($config['db']) or die("Database does not exist or no permission");
  }
  
  public static function getInstance() {
      if(DBHelper::$dbHelper == null) {
		return new DBHelper();
      }
      
      return static::dbHelper;
  }

  public function selectQuery($query) {
    $result =  $this->mysqli->query($query);
    $response = array();
    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
	array_push($response, $row);
      }
    }
    return $response;
  }
  
  public function insertUpdateQuery($query) {
    $result =  $this->mysqli->query($query);
    $id = $this->mysqli->insert_id;
    return $id;
  }
  
  public function deleteQuery($query) {
    $this->mysqli->query($query);
  }
}


?>