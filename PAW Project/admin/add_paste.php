<?php 
require_once ('../inc/common.php');

//if (!$session->is_logged_in()) {
// redirect_to('login.php');
//}
error_reporting(E_ALL);

?>
<title>Admin Panel :: Adauga Pizza</title>

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
  <li class="<?php if (strstr($request_uri, 'pizza.php')) {  echo 'active'; } ?>"><a  href="add_pizza.php">Pizza</a></li>
  <li class="<?php if (strstr($request_uri, 'meniuri.php')) {  echo 'active'; } ?>"><a href="add_meniu.php">Meniuri</a></li>
  <li class="<?php if (strstr($request_uri, 'paste.php')) {  echo 'active'; } ?>"><a href="add_paste.php">Paste</a></li>
  <li class="<?php if (strstr($request_uri, 'salate.php')) {  echo 'active'; } ?>"><a href="add_salate.php">Salate</a></li>
  <li class="<?php if (strstr($request_uri, 'desert.php')) {  echo 'active'; } ?>"><a href="add_desert.php">Desert / Bauturi</a></li>
  <li class="<?php if (strstr($request_uri, 'contact.php')) {  echo 'active'; } ?>"><a href="contact.php">Contact</a></li>
</ul>
            </div>
           
        </div>
        
        
        

    </div>			
</header>
      

<?php

$users = Paste::find_by_id();
$types=array("image/png","image/jpeg","image/jpg");

$errors = '';

if(isset($_POST['submit'])) {
    
    
    	//if($_FILES['image'])
	//{
	//	$image=$form->upload('image',$types);
	//	
	//	if($image)
	///	{
	//		$prod_image=$_FILES['image']['name'];
	//	}
	//	else
	//	{
	//		$prod_image='';
	//	}
	//}
	
	if (empty($_POST['name']) || trim($_POST['name']) ==='' || empty($_POST['description']) || trim($_POST['description']) ===''
	 )   {
		$errors = "Complete the fields.";
	} 
	else {
            $users=new Paste();
		if ($users->check_if_exists('name', htmlentities(trim($_POST['name'])))===true){
				$errors = "Product already exists.";
		}

		else if (strlen($_POST['name']) >30){
			$errors = 'The name of product cannot be more than 30 characters long';
		}
                

		
	}
	if (empty($errors) === true) {
		$users->name = htmlentities(trim($_POST['name']));
		$users->description = htmlentities(trim($_POST['description']));
                $users->price = htmlentities(trim($_POST['price']));
                $users->price2 = htmlentities(trim($_POST['price2']));
		$users->image = htmlentities(trim($_POST['image']));
		
		
		
		
		
		if($users->save()) {
			$errors = "Produsul a fost adaugat cu succes.";
                        $users->redirect_to('../pizza.php');
			
		} 
		else {
			// Failure
			$users->message("Ups! Error!");
		}
	}
}

?>


<div id="page-wrapper">

<div align="center" style="line-height: 25px;margin-left: 10%; width: 80%; text-align: left; padding-left: 0.8em; height: 100%;margin-top: 5%;" class="jumbotron">
          <h3>Adauga Meniu</h3>
<form class="form-horizontal"  action="" method="POST">
                                 <p style="color:red; font-size:16px;">  <?php echo $errors; ?> </p> <br/>
                                          <!-- Name -->
                                        <div class="form-group">
                                            <label class="control-label col-md-2" for="name">Denumire:</label>
                                            <div class="col-md-4">
                                              <input type="text"  class="form-control" id="name" name="name" maxlength="30" />
					    </div>
                                        </div>
					
                                        <div class="form-group">
					<label class="control-label col-md-2" for="description">Ingrediente</label>
                                            <div class="col-md-4">
                                               <input type="text"  class="form-control" id="description" name="description" maxlength="400" />
					   </div>
                                        </div>
                                        
                                        <div class="form-group">
                                        	<label class="control-label col-md-2" for="price">Pret Spaghete / pene</label>
                                            <div class="col-md-4">
                                               <input type="text"  class="form-control" id="price" name="price" maxlength="30" />
					   </div>
                                        </div>
                                          
                                        <div class="form-group">
                                        	<label class="control-label col-md-2" for="price2">Pret Tortellini cu branza</label>
                                            <div class="col-md-4">
                                               <input type="text"  class="form-control" id="price" name="price2" maxlength="30" />
					   </div>
                                        </div>
                                          
                                       
                                          
                                          
                                          
                                          
                                          
                                        
										  
                        <!--<div class="form-group">		
				<label class="col-md-2 control-label" for="image">Product Image</label>
				<div class="col-sm-4">
					<input type="file" name="image" id="color" class="pick-a-color form-control"/>
				</div>
			</div>-->						  
										  
				<div class="form-group">		
                                            <label class="col-md-2 control-label" for="image">Product Image</label>
                                        <div class="col-sm-4">
                                             <input type="text" value="" name="image" id="color" class="pick-a-color form-control"/>
                                         </div>
                                </div>				  
                                          
				
                 <div class="col-md-4" style="margin-top:20px; margin-left:20px;">
                 <!--<input type="submit" id="submit" class="btn btn-primary btn-sm" name="submit" value="Save">-->
                 <input type="submit" id="submit" class="btn btn-primary btn-sm" name="submit" value="Submit">
	      </div>
             
					
</form>
</div>
</div>




      <br/><br/>

<?php
include ('../footer.php');
?>

	


