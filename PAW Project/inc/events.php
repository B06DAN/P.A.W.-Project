<?php
require_once(LIB_PATH.DS.'database.php');
class Events extends DatabaseObject {
	
	protected static $table_name="events";
	protected static $db_fields = array('id', 'title', 'select_members', 'start', 'end', 'customer_name', 'phone', 'created_at',
	'email', 'original_address', 'destination_address', 'fro_who', 'ref', 'truck', 'description', 'foreman', 'employee', 'photo', 'color', 'created_by', 'modified_at');
  
	public $id;
        public $title;
	public $select_members;
	public $start;
	public $end;
	public $customer_name;
	public $phone;
	public $email;
	public $original_address;
	public $destination_address;
	public $fro_who;
	public $ref;
	public $truck;
	public $description;
	public $foreman;
	public $employee;
	public $photo;
	public $color;
	public $created_by;
	
	public $created_at;
        public $modified_at;
	
	public $errors=array();
	
	
	
	
	
}