<?php
function addentities($data){
   if(trim($data) != ''){
   $data = htmlentities($data, ENT_QUOTES);
   return str_replace('\\', '&#92;', $data);
   } else return $data;
}
function strip_zeros_from_date($marked_string=""){
	$no_zeros = str_replace('*0', '',$marked_string);
	$cleaned_string = str_replace('*', '', $no_zeros);
	return $cleaned_string;
}

function redirect_to($location = NULL) {
	if ($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

function output_message($message="") {
	if(!empty($message)) {
		return "<p class=\"message\">{$message}</p>";
	}
	else {
	
		return "";
	}
}

//function __autoload($class_name) {
//	$class_name = strtolower($class_name);
//  $path = LIB_PATH.DS."{$class_name}.php";
//  if(file_exists($path)) {
//    require_once($path);
//  } else {
//		die("The file {$class_name}.php could not be found.");
//	}
//}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.DS.'layouts'.DS.$template);
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function random_chars($nr_chars) {
  $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789!@#$%^&*()'); // and any other characters
  shuffle($seed); // probably optional since array_is randomized; this may be redundant
  $rand = '';
  foreach (array_rand($seed, $nr_chars) as $k) $rand .= $seed[$k];
  return $rand;
}

function language_id($lang_short) {
  $language = Languages::find_by_sql("SELECT id FROM languages WHERE lang_short LIKE '".$lang_short."'");
  return $language[0]->id;
}

function exist_days($array_days, $weekdays, $day, $no_days = array()) {
  if (in_array(date("l", strtotime($day)), $weekdays)) {
    if (in_array($day, $array_days)) {
      exist_days($array_days, $weekdays, date('Y-m-d', strtotime('+1 day', strtotime($day))));
    } else {
      $no_days[count($no_days)+1] = $day;
    }
  } else {
    exist_days($array_days, $weekdays, date('Y-m-d', strtotime('+1 day', strtotime($day))));
  }
 // return $no_days;
}


/**
 * return the name of the day
 * @param type $nr - the nr of day 
 * @param type $type =  type of name of day( 1 - Monday, 2-Mon)
 * @return type
 */
 



?>