<?php
@mysql_connect("localhost", "root", "") or die("Error connecting to database: " . mysql_error());
mysql_select_db("shop") or die(mysql_error());
include ('header.php');
$request_uri = $_SERVER['REQUEST_URI'];
require_once("inc/dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css"/>

        <title>AFYC - Cautare</title>
        <link rel="shortcut icon" type="image/png" href="images/logomic.png"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="source/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />
        <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
        <script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        <script type="text/javascript" src="source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

            <style type="text/css">
                .fancybox-custom .fancybox-skin {
                    box-shadow: 0 0 50px #222;
                }
            </style>

    </head>
    <body>
        <div class="container">
            <div style="background: none repeat scroll 0% 0% #fff;
                 padding-left: 20px;
                 padding-top: 10px;
                 padding-bottom: 10px;
                 color: #EC2426;
                 font-size: 25px;
                 border-radius: 10%;
                 font-weight: bold;">Rezultatele Cautarii</div>
                 <?php
                 $query = $_GET['query'];
                 $min_length = 3;

                 if (strlen($query) >= $min_length) {
                     $query = htmlspecialchars($query);
                     $query = mysql_real_escape_string($query);

                     $raw_results = mysql_query("SELECT * FROM tblproduct WHERE (`name` LIKE '%" . $query . "%')") or die(mysql_error());

                     if (mysql_num_rows($raw_results) > 0) {
//                         while ($results = mysql_fetch_array($raw_results)) {
                         ?>

                    <div id="product-grid">
                        <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE (`name` LIKE '%" . $query . "%')");


                        foreach ($product_array as $key => $value) {
                            $id = $product_array[$key]["id"];
                            ?>


                            <div class="col-md-3" >
                                <div class="minicontainers">
                                    <div class="product-item">
                                        <form method="post" action="cosulmeu.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                            <div><strong><a id="nume" href="produs_details.php?id=<?php echo $id ?>"><?php echo $product_array[$key]["name"]; ?></a></strong></div>
                                            <div class="product-image"><a href="produs_details.php?id=<?php echo $product_array[$key]["id"]; ?>"><img style="margin-top: 22px;" class="img-thumbnail" src="<?php echo $product_array[$key]["image"]; ?>"></a></div>
                                            <div class="product-price"><?php echo "Pret : " . $product_array[$key]["price"] . " Lei"; ?></div>
                                            <div>
                                                <input class="pull-left form-control" style="width: 80px; margin-left: 10px; margin-top:-100px; visibility: hidden;" type="number" name="quantity" value="1" />
                                                <input class="pull-right" type="submit" value="Adauga in cos" class="btnAddAction">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    echo "Nu au fost gasite rezultate , cautati altceva.";
                }
            } else {
                echo "Minimum length is " . $min_length;
            }
            ?>
        </div>
        <?php
        include('footer.php');
        ?>
    </body>
</html>