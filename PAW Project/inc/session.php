<?php

class Session {

	private $logged_in=false;
	public $user_id;
	public $message;
	
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
    if($this->logged_in) {
      // actions to take right away if user is logged in
    } else {
      // actions to take right away if user is not logged in
    }
	}
	
  public function is_logged_in() {
    return $this->logged_in;
  }

	public function login($user) {
    // database should find user based on username/password
    if($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->logged_in = true;
    }
  }
  
  /**
   * login only with the id( after the user register)
   * @param type $user_id
   */
	public function login_id($user_id) {
    // database should find user based on username/password
    if($user_id){
      $this->user_id = $_SESSION['user_id'] = $user_id;
      $this->logged_in = true;
    }
  }
  
  public function logout() {
    unset($this->user_id);
    session_destroy();
    $this->logged_in = false;
  }
  
  public function message($msg="") {
	  if(!empty($msg)) {
	    // then this is "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = $msg;
	  } else {
	    // then this is "get message"
			return $this->message;
	  }
	}

	private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
	}
		public function get_user() {
			 global $db;  
			if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
			
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['user_id']."'" ;
    $result = $db->query($sql);
    
    $c = $result->fetch_object();     
    if ($c) {
			$this->logged_in = true;
      return $c;
    } else {
			unset($this->user_id);
			unset($_SESSION['user_id']);
      $this->logged_in = false;
			return FALSE;
    }
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
}


$session = new Session();
$message = $session->message();

?>