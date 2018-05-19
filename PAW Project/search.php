<?php
include ('/inc/products');
mysql_connect("localhost", "root", "") or die("Error connecting to database: " . mysql_error());
mysql_select_db("proiect") or die(mysql_error());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <?php
        $query = $_GET['query'];
       

            $query = htmlspecialchars($query);
            $query = mysql_real_escape_string($query);
            
            $raw_results = mysql_query("SELECT * FROM products WHERE (`name` LIKE '%" . $query . "%')") or die(mysql_error());
            if (mysql_num_rows($raw_results) > 0) {
                while ($results = mysql_fetch_array($raw_results)) {
                    
                    Print '<script>window.location.assign("rezultate.php");</script>';
//                    echo "<p><h3>" . $results['name'] . "</h3></p>";
                }
            } else {
                Print '<script>window.location.assign("noresult.php");</script>';
            }
        ?>
    </body>
</html>