<?php
function check_user($username,$password)
{
	global $conexion;
	
	$sql = "SELECT 
				id,
				username,
				password
			FROM 
				users
			WHERE
				username='".$username."'
			AND
				password='".md5($password)."'
			";
	//echo $sql;
	$result = mysql_query($sql) or die(mysql_error());
	//aici verifici daca esista in baza de date 
	$row = mysql_num_rows($result);

	if($row>0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

function userid($username,$password)
{
		global $conexion;
	
		$sql = "SELECT 
					id,
					username,
					password
				FROM 
					users
				WHERE
					username='".$username."'
				AND
					password='".md5($password)."'
				";
		//echo $sql;
		$result = mysql_query($sql) or die(mysql_error());
		
		if($result)
		{
			$user_dates=mysql_fetch_assoc($result);
			$user_id=$user_dates['id'];
			return $user_id;
		}
		else
		{
			$user_id=0;
		   	return $user_id;
		}
}

function secured_pwd($pwd)
{
	$salt="infinit@eight#$";
	$new_pw=$salt.$pwd;
	echo $new_pw;
	return $new_pw;

}


?>