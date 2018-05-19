<?php
require_once (__DIR__ . '/inc/common.php');
require_once ('inc/config.php');
require 'header.php';

$product = new Products();
$pid = $_GET['id'];
$p = $product->getProduct($pid);
//error_reporting(E_ALL);
$comments = new Comments();
$com = $comments->get_by_pid($pid);
$no_of_element=count($com);
//print_r($com);


@mysql_connect("localhost", "root", "ionut93") or die(mysql_error()); 
mysql_select_db("magazin") or die(mysql_error()); 

//Adds one to the counter 
mysql_query("UPDATE products SET views = views + 1 WHERE id = $pid");

//Retreives the current count 
//$count = mysql_fetch_array(mysql_query("SELECT views FROM products WHERE = $pid"));

//Displays the count on your site print "$count[0]";
?>
<title><?php echo $p->name; ?></title>

    
        <div class="container">
<?php
require 'categorii.php';
require 'menu.php';

?>
        <div class="col-md-9" style=" margin-top: 10px;background: white;">

            
    <h2>  <?php echo $p->name; ?></h2>
            
        

<form class="form-horizontal"  action="addcart.php?id=<?php echo $p->id; ?>" method="POST">

    
<div class="col-md-12">    

    

<div class="col-md-3">
<?php echo "<a href='$p->image'><img style='width: 300px;' src='".$p->image."'/></a><br>";?>
</div>
    
<div style="float: right;color: #F00;font-size: 24px;font-weight: bold;margin-top: 117px;margin-right: 47px;" class="col-md-3">
<?php echo $p->price," USD";?>
</div>
    <div style="float: right;font-size: 15px;color: #2E71B5;font-weight: bold;margin-right: 47px;margin-top: 2px;margin-left: 108px;" class="col-md-3">
<?php echo "Stock: ",$p->stock, " pcs"; ?>
    </div>


    
</div>
        
<input style="position:relative;float: right;margin-top: -119px;margin-right: 98px;width: 154px;font-size: 16px;" type="submit" id="submit" class="btn btn-primary btn-sm" name="submit" value="Add to cart">
</form>
    
    
    
    
    
    
    <!--Start Comments-->
    <div class="clear"></div>
    
    <div style="padding-left: 10px;border: 1px solid #CCC;">
    <h2 style="padding-left: 20px;">Description</h2>
    <?php echo $p->description,"<br/><br/>";?>
    </div>
    <h2>Comments</h2>
    <?php  
$users = new Comments();

 $errors = '';

if(isset($_POST['submit'])) { 
	
	if (empty($_POST['product_id']) || trim($_POST['product_id']) ==='' || empty($_POST['comment']) || trim($_POST['comment']) ===''
	 || empty($_POST['nume']) || trim($_POST['nume']) ==='' || empty($_POST['email']) || trim($_POST['email']) ==='')   {
		$errors = "Complete the fields.";
	} 
	if (empty($errors) === true) {
		$users->product_id = htmlentities(trim($_POST['product_id']));
		$users->comment = htmlentities(trim($_POST['comment']));
                $users->nume = htmlentities(trim($_POST['nume']));
                $users->email = htmlentities(trim($_POST['email']));
                $users->rate = htmlentities(trim($_POST['rate']));
		
		
		
		
		
		
		if($users->save()) {
			$errors = "Comment added succesfuly.";
                        //$users->redirect_to('products.php');
			
		} 
		else {
			// Failure
			$users->message("Ups! Error!");
		}
	}
}
?>
    <p style="color:red; font-size:16px;">  <?php echo $errors; ?> </p> <br/>
    <?php
    
for($i=0;$i<$no_of_element;$i++)
{
    if(empty($com)){
        
echo "Nu exista comentarii!";
    
    }else{
        echo "<div style='border: 1px solid #CCC; margin-top: 10px;'>";
        echo "<div style='padding-left: 10px;padding-top: 10px;padding-bottom: 10px;border-bottom: 1px solid #CCC;'>";
        echo "Added by: ",$com[$i]->nume,"&nbsp;";
        echo $com[$i]->email;
        echo "</div>";
        echo "<div style='padding-left: 20px;padding-top: 10px; padding-bottom: 5px;'>";
        echo $com[$i]->comment;
        echo "</div>";
        echo "</div>";
    }
    
    }
    ?>
    
    
    
                <h2>Add Comment</h2>

      <form class="form-horizontal"  action="" method="POST">
                                 
                                          <!-- Name -->
<select name="rate">
<option value=" ">Select rate for this product!</option>
<option value="1">1</option>
<option  value="2">2</option>
<option  value="3">3</option>
<option value="4">4</option>
<option  value="5">5</option>
</select> 
                                        <div style="display: none;" class="form-group">
                                            <label class="control-label col-md-2" for="name">Product ID:</label>
                                            <div class="col-md-4">
                                              <input type="text"  class="form-control" id="name" name="product_id" maxlength="30" value="<?php echo $p->id; ?>" />
					    </div>
                                        </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-2" for="name">Name:</label>
                                            <div class="col-md-4">
                                              <input type="text"  class="form-control" id="name" name="nume" maxlength="30" />
					    </div>
                                        </div>
                                          
                                          <div class="form-group">
                                            <label class="control-label col-md-2" for="name">Email:</label>
                                            <div class="col-md-4">
                                              <input type="email"  class="form-control" id="name" name="email" maxlength="30" <?php echo $p->id; ?> />
					    </div>
                                        </div>
					
                                        <div class="form-group">
					<label class="control-label col-md-2" for="description">Comment</label>
                                            <div class="col-md-4">
                                                <textarea type="text"  class="form-control" id="description" name="comment" maxlength="400" ></textarea>
					   </div>
                                        </div>			  
                                          
				
                 <div class="col-md-4" style="margin-top:20px; margin-left:20px;">
                 <!--<input type="submit" id="submit" class="btn btn-primary btn-sm" name="submit" value="Save">-->
                 <input type="submit" id="submit" class="btn btn-primary btn-sm" name="submit" value="Submit">
	      </div>
             
					
</form>      
<!--End Comments-->








    
        </div>
  
            
            
        </div>

<?php
require'footer.php';
?>