<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bool = true;
    $mysqli = new mysqli("localhost", "root", "", "first_db");
    if ($mysqli->connect_errno) {
        Print '<script>alert("Eroare la conectarea cu baza de date.");</script>';
    }
    $rows = $mysqli->query("SELECT * FROM users WHERE username = '$username'");

    if ($rows->num_rows != 0) {
        Print '<script>alert("Numele de utilizator este luat!");</script>';
    } else {
        $mysqli->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");

//        Print '<script>alert("Inregistrarea s-a realizat cu succes.");</script>';
        Print '<script>window.location.assign("autentificare.php");</script>';
    }
}
?>