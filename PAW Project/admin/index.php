<!DOCTYPE html>
<html>
  <head>
   
    
    <meta charset="UTF-8"/>
    <meta name="keywords" content="keywords"/>
    <meta name="description" content="description"/>
		
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
    <script type='text/javascript' src='js/jquery.dcverticalmegamenu.1.3.js'></script>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../fonts/css/font-awesome.css" type='text/css'>
    <link rel="stylesheet" href="../fonts/css/font-awesome.min.css" type="text/css">
		
<script type="text/javascript">
$(document).ready(function($){

	$('#mega-1').dcVerticalMegaMenu({
		rowItems: '3',
		speed: 'fast',
		effect: 'show',
		direction: 'right'
	});


});
</script>
<script type="text/javascript">$('.dropdown-toggle').dropdown()</script>
<title>Pizza Roys :: Admin</title>
    </head>
  <body>
<header class="header">
    
    <div class="container" style="background: transparent;">
        
        <div class="row">
            <div class="logo">
                <a href="index.php"><img src="../images/logoroys.png"/></a>
            </div>
 			
            <div class="menu">


<ul>
  <li class="<?php if (strstr($request_uri, 'index.php')) {  echo 'active'; } ?>"><a  href="index.php">Acasa</a></li>
  <li class="<?php if (strstr($request_uri, 'pizza.php')) {  echo 'active'; } ?>"><a  href="pizza.php">Pizza</a></li>
  <li class="<?php if (strstr($request_uri, 'meniuri.php')) {  echo 'active'; } ?>"><a href="meniuri.php">Meniuri</a></li>
  <li class="<?php if (strstr($request_uri, 'paste.php')) {  echo 'active'; } ?>"><a href="paste.php">Paste</a></li>
  <li class="<?php if (strstr($request_uri, 'salate.php')) {  echo 'active'; } ?>"><a href="salate.php">Salate</a></li>
  <li class="<?php if (strstr($request_uri, 'desert.php')) {  echo 'active'; } ?>"><a href="desert.php">Desert / Bauturi</a></li>
  <li class="<?php if (strstr($request_uri, 'contact.php')) {  echo 'active'; } ?>"><a href="contact.php">Contact</a></li>
</ul>
            </div>
           
        </div>
        
        
        

    </div>			
</header>

      <div class="container">
          
          <div class="row">
              
              <div class="col-md-12">
                  
                  <a href="add_pizza.php">Adauga Pizza</a><br/>
                  <a href="add_meniu.php">Adauga Meniuri</a><br/>
                  <a href="add_paste.php">Adauga Paste</a><br/>
                  <a href="add_salate.php">Adauga Salate</a><br/>
                  <a href="add_desert.php">Adauga Desert</a><br/>
                  <a href="add_bauturi.php">Adauga Bauturi Racoritoare</a><br/>
                  <a href="add_bauturia.php">Adauga Bauturi Alcoolice</a>
                  
              </div>
              
          </div>
          
      </div>