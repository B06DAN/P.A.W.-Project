<?php
include ('header.php');
session_start();
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

<title>AFYC - All For Your Computer</title>
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

<div class="container">


    <div style="background: none repeat scroll 0% 0% #fff;
         padding-left: 20px;
         padding-top: 10px;
         padding-bottom: 10px;
         color: #EC2426;
         font-size: 25px;
         font-weight: bold;">Produse</div>



    <div id="product-grid">
        <?php
        $product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");



        if (!empty($product_array)) {
            foreach ($product_array as $key => $value) {
                $id = $product_array[$key]["id"];
                $category = $product_array[$key]["category"];
                if ($request_uri == "/shop/produs.php?category=$category") {
                    ?>
                    <div class="col-md-3" >
                        <div class="minicontainers">
                            <div class="product-item">
                                <form method="post" action="cosulmeu.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                    <div><strong><a id="nume" href="produs_details.php?id=<?php echo $id ?>"><?php echo $product_array[$key]["name"]; ?></a></strong></div>
                                    <div class="product-image"><a href="produs_details.php?id=<?php echo $product_array[$key]["id"]; ?>"><img style="margin-top: 22px;" class="img-thumbnail" src="<?php echo $product_array[$key]["image"]; ?>"></a></div>
                                    <div class="product-price"><?php echo "Pret : " . $product_array[$key]["price"] . " Lei"; ?></div>
                                    <input class="pull-left form-control" style="width: 80px; margin-right: 10px; margin-top:-100px; visibility: hidden;" type="number" name="quantity" value="1" />
                                    <div><input class="pull-right" type="submit" value="Adauga in cos" class="btnAddAction" /></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
//            echo "nothign";
                }
            }
        }
        ?>
    </div>

</div>
<?php
include ('footer.php');
?>