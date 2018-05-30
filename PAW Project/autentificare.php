<?php
require_once (__DIR__ . '/inc/common.php');
$request_uri = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="keywords" content="keywords"/>
        <meta name="description" content="description"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
        <script type='text/javascript' src='js/jquery.dcverticalmegamenu.1.3.js'></script>
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="fonts/css/font-awesome.css" type='text/css'>
        <link rel="stylesheet" href="fonts/css/font-awesome.min.css" type="text/css">      
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">		
        <script type="text/javascript">$('.dropdown-toggle').dropdown()</script>

        <title>AFYC - Autenficare</title>
        <link rel="shortcut icon" type="image/png" href="images/logomic.png"/>
    </head>

    <body>
        <header class="header">

            <div class="container" style="background: transparent;">

                <div class="row">
                    <div class="logo">
                        <div align="center">
                        <div class="logo">
                            <a href="index.php"><img src="images/headerai.png"/></a>
                        </div>
                        </div>
                    </div>
                    <div class="menu">

                    </div>
                </div>
            </div>			
        </header>

        <div class="login-boxai">
            <img src="./images/avatar.png" class="avatarai">
            <h1 style="margin: 0;padding: 0 0 20px;text-align: center;font-size: 22px;">Autenficare</h1>
            
            <form action="checklogin.php" method="POST">
                <p>Username</p>
                <input type="text" name="username" placeholder="Enter Username" required="required">
                <p>Password</p>
                <input type="password" name="password" placeholder="Enter Password" required="required">
                <input type="submit" name="submit" value="Login">
                <h6>Nu ai un cont? Fa-ti unul <a href="inregistrare.php">aici!</a></h6>
            </form>
        </div>
    </body>





