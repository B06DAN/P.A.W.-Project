<?php
//require_once(LIB_PATH.DS.'database.php');


class DatabaseObject {

protected static $table_name;
// Common Database Methods
	public static function find_all() {
		return static::find_by_sql("SELECT * FROM ".static::$table_name);
	}

    public static function find_by_sql($sql="") {
    global $db;
    $result_set = $db->query($sql);
    $object_array = array();
    while ($row = $db->fetch_array($result_set)) {
    $object_array[] = static::instantiate($row);
    }
    return $object_array;
  }
  private static function instantiate($record) {
		// Could check that $record exists and is an array
	$class_name = get_called_class();
    $object = new $class_name;
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
        private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}
        protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(static::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
        
        
        public static function find_by_id($id=0) {
        $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
        }
        
public static function find_by_views() {
    global $db;
    
    $sql  = "SELECT * FROM ".static::$table_name;
    $sql .= " ORDER by id ASC";
    $result = $db->query($sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
      $object_array = array();
    while ($row = $db->fetch_array($result)) {
    $object_array[] = static::instantiate($row);
    }
    return $object_array;
    } 
    else {
      return false;
    }
	}
	
	
	public static function find_by_ordine() {
    global $db;
    
    $sql  = "SELECT * FROM ".static::$table_name;
    $sql .= " ORDER by id DESC";
    $result = $db->query($sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
      $object_array = array();
    while ($row = $db->fetch_array($result)) {
    $object_array[] = static::instantiate($row);
    }
    return $object_array;
    } 
    else {
      return false;
    }
	}
        
        
        public static function find_by_ids() {
    global $db;
    
    $sql  = "SELECT * FROM ".static::$table_name;
    $sql .= " ORDER by id ASC";
    $result = $db->query($sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
      $object_array = array();
    while ($row = $db->fetch_array($result)) {
    $object_array[] = static::instantiate($row);
    }
    return $object_array;
    } 
    else {
      return false;
    }
	}
        
    public static function check_if_exists($key="", $value="") {
    global $db;
    $key = $db->escape_value($key);
    $value = $db->escape_value($value);
    $sql  = "SELECT * FROM ".static::$table_name;
    $sql .= " WHERE {$key} = '{$value}'";
    $result = $db->query($sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
      return true;
    } 
    else {
      return false;
    }
	}
	
	public function create() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
                
	  if($db->query($sql)) {
	    $this->id = $db->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}
        
        
        
        
  
  public function insert($sql) {
    global $db;
    $db->query($sql);
  }
  
  
    /*public function update() {
	  global $db;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $db->escape_value($this->id);
	  $db->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}*/
  
  	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
        
        
        
        
        	public function delete() {
		global $db;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".static::$table_name;
	  //$sql .= " WHERE id=". $db->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $db->query($sql);
	  return ($db->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}
        
        protected function sanitized_attributes() {
        global $db;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
          $clean_attributes[$key] = $db->escape_value($value);
        }
        return $clean_attributes;
	}
        
 public function redirect_to($location = NULL) {
	if ($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

public function message($message="") {
	if(!empty($message)) {
		return "<p class=\"message\">{$message}</p>";
	}
	else {
	
		return "";
	}
}
        
	public static function service_providers($user_id="") {
		return static::find_by_sql("SELECT * FROM 5m9pw_users WHERE id in (SELECT id_accountant FROM 5m9pw_client_accountant_asoc WHERE id_client = {$user_id})");
	}
  
  //public static function find_by_id($id=0) {
   // $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1");
	//	return !empty($result_array) ? array_shift($result_array) : false;
 // }
  
//  public static function find_by_sql($sql="") {
//    global $database;
//    $result_set = $database->query($sql);
//    $object_array = array();
//    while ($row = $database->fetch_array($result_set)) {
//      $object_array[] = static::instantiate($row);
//    }
//    return $object_array;
//  }
//  
  public static function query_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
    $array = new stdClass();
      foreach ($row as $key=>$val) {
        if (!is_int($key)) {
          $array->$key = $database->escape_value($val);
        }
      }
      $object_array[] = $array;
    }
    return $object_array;
  }
//  
//
//	public static function count_all() {
//	  global $database;
//	  $sql = "SELECT COUNT(*) FROM ".static::$table_name;
//    $result_set = $database->query($sql);
//	  $row = $database->fetch_array($result_set);
//    return array_shift($row);
//	}
//
//	private static function instantiate($record) {
//		// Could check that $record exists and is an array
//	$class_name = get_called_class();
//    $object = new $class_name;
//		// More dynamic, short-form approach:
//		foreach($record as $attribute=>$value){
//		  if($object->has_attribute($attribute)) {
//		    $object->$attribute = $value;
//		  }
//		}
//		return $object;
//	}
//	
//	private function has_attribute($attribute) {
//	  // We don't care about the value, we just want to know if the key exists
//	  // Will return true or false
//	  return array_key_exists($attribute, $this->attributes());
//	}
//
//	
//	
//	protected function attributes() { 
//		// return an array of attribute names and their values
//	  $attributes = array();
//	  foreach(static::$db_fields as $field) {
//	    if(property_exists($this, $field)) {
//	      $attributes[$field] = $this->$field;
//	    }
//	  }
//	  return $attributes;
//	}
//	
//	protected function sanitized_attributes() {
//	  global $database;
//	  $clean_attributes = array();
//	  // sanitize the values before submitting
//	  // Note: does not alter the actual value of each attribute
//	  foreach($this->attributes() as $key => $value){
//	    $clean_attributes[$key] = $database->escape_value($value);
//	  }
//	  return $clean_attributes;
//	}
//	
//	public function save() {
//	  // A new record won't have an id yet.
//	  return isset($this->id) ? $this->update() : $this->create();
//	}
//	
//	
//	 
//	 // $row = $database->fetch_array($result_set);
//	//	return array_shift($row);
//	
//	
//	public static function check_if_exists($key="", $value="") {
//    global $database;
//    $key = $database->escape_value($key);
//    $value = $database->escape_value($value);
//    $sql  = "SELECT * FROM ".static::$table_name;
//    $sql .= " WHERE {$key} = '{$value}'";
//    $result = $database->query($sql);
//    $num_rows = mysqli_num_rows($result);
//    if ($num_rows > 0) {
//      return true;
//    } 
//    else {
//      return false;
//    }
//	}
//	
//	public function create() {
//		global $database;
//		// Don't forget your SQL syntax and good habits:
//		// - INSERT INTO table (key, key) VALUES ('value', 'value')
//		// - single-quotes around all values
//		// - escape all values to prevent SQL injection
//		$attributes = $this->sanitized_attributes();
//	  $sql = "INSERT INTO ".static::$table_name." (";
//		$sql .= join(", ", array_keys($attributes));
//	  $sql .= ") VALUES ('";
//		$sql .= join("', '", array_values($attributes));
//		$sql .= "')";
//	  if($database->query($sql)) {
//	    $this->id = $database->insert_id();
//	    return true;
//	  } else {
//	    return false;
//	  }
//	}
//  
//  public function insert($sql) {
//    global $database;
//    $database->query($sql);
//  }

  /**
   * // Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
   * @global type $database
   * @return type
   
	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

  public static function escape_string($string) {
    global $database;
    return $database->escape_value($string);
  }
  
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".static::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

  /**
   * insert a row into a specific table
   * @global type $database
   * @param type $table
   * @param type $keys -  an array with the names of the columns from database, eg id,name,password
   * @param type $values an array with the values that you want to insert in database
   * @return type
   
  public static function insert_row($table, $keys, $values) {
    global $database;
    $sql = "INSERT INTO ".$table."(".implode(',',$keys).") VALUES ('".implode("','",$values)."')";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? $database->insert_id() : false;
  }
  
  /**
   * update a row in a specific table; the sql is created using double quotes "
   * @global type $database
   * @param type $table
   * @param type $keys an array with the names of the columns from database, eg id,name,password
   * @param type $values an array with the values that you want to insert in database
   
  public static function update_row($table, $keys, $values) {
    global $database;
    $sql = "UPDATE ".$table." SET ";
    $error = true;
    if (count($keys) == count($values)) {
      foreach ($keys as $k=>$key) {
        $sql .= "`$key` = '".$database->escape_value($values[$k])."'";
      }
    } else {
      $error = 'The arrays doesn\'t have the same number of values';
    }
    return $error;
  }
	*/
  
  
    public static function update_row($table, $keys, $values) {
    global $database;
    $sql = "UPDATE ".$table." SET ";
    $error = true;
    if (count($keys) == count($values)) {
      foreach ($keys as $k=>$key) {
        $sql .= "`$key` = '".$database->escape_value($values[$k])."'";
      }
    } else {
      $error = 'The arrays doesn\'t have the same number of values';
    }
    return $error;
  }
  
  
  


  
  
}

?>