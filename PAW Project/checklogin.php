<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$mysqli = new mysqli("localhost", "root", "", "first_db");
    if ($mysqli->connect_errno) {
        Print '<script>alert("Inregistrarea s-a realizat cu succes.");</script>';
    }
    $exist = $mysqli->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    if($exist->num_rows > 0){
        $_SESSION['user'] = $username;  
        header("location: index.php");
    }else{
        Print '<script>alert("Incorect Username sau Password");</script>';
        Print '<script>window.location.assign("autentificare.php");</script>';
    }
?>