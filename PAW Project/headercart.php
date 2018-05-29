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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">		
        <script type="text/javascript">$('.dropdown-toggle').dropdown()</script>
    </head>

    <body>
        <header class="header">


            <form action="search.php" method="GET">
                <div class="search-box" >
                    <input class="search-txt" type="text" name="query" placeholder="Cauta produsul dorit..." >
                    <a class="search-btn" href="#" >
                        <i class="fas fa-search"></i>
                    </a>
                </div>
            </form>



            <div class="container" style="background: transparent;">

                <div class="row">
                    <div class="telefon" style="float:right">



                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height: 30px;font-size: 13px;width:100px">
                                <?php
                                session_start();
                                echo $_SESSION['user'];
                                ?> 
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="inregistrare.php">Inregistrare</a></li>
                                <li><a href="autentificare.php">Autentificare</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout.php">Deconectare</a></li>          
                            </ul>


                        </div>
                        <a href="cosulmeu.php">
                            <button type="button" class="btn btn-default btn-lg" style="height: 30px;font-size: 14px;width:100px">
                                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" ></span>Cosul meu
                            </button>
                        </a>


                        <!--                        <div class="logo"style="float: left;">
                                                    <div class="logo"style="float: left;height: 100px;">-->
                        <a href="index.php"><img style="float: left;height: 100px;margin-right: 500px;margin-top: 36px;" src="images/logost.png"/></a>
                        <!--                            </div>
                                                </div>-->
                    </div>

                </div>
            </div>

        </header>

