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


    <!--    <div style="background: none repeat scroll 0% 0% #fff;
             padding-left: 20px;
             padding-top: 10px;
             padding-bottom: 10px;
             color: #EC2426;
             font-size: 25px;
             border-radius: 10%;
             font-weight: bold;">Produse</div>-->


    <div id="product-grid">
        <?php
        $product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY name ASC");



        if (!empty($product_array)) {
            foreach ($product_array as $key => $value) {
                $id = $product_array[$key]["id"];
                if ($request_uri == "/shop/produs_details.php?id=$id") {
                    ?>
                    <div class="product-item">
                        <div class="col-md-12" style=" margin-top: -20px;background-color: #fff;">
                            <h2 style="color: #E41F26;font-family: 'Open Sans Condensed';padding-left: 20px;margin-top: 0px; margin-bottom: 20px;">  <?php echo $product_array[$key]["name"]; ?></h2>

                            <div style="margin-top: -32px;border-bottom: 2px solid #000; padding-left: 25px;margin-bottom: 23px;padding-bottom: 15px;">

                            </div> 

                            <div class="col-md-12" style="background-color: #fff;">    
                                <div class="col-md-3">

                                    <?php
                                    if (!empty($product_array[$key]["image"])) {
                                        echo "<a href='" . $product_array[$key]["image"] . "' class='fancybox' data-fancybox-group='gallery'><img style='border-radius: 10px;width: 423px;' src='" . $product_array[$key]["image"] . "'/></a><br>";
                                    } else {
                                        echo "<a href='#'><img style='width: 300px;' src='images/default.jpg'/></a><br>";
                                    }
                                    ?>
                                </div>

                                <div style="display: inline-block;margin-left: 210px;width: 350px;height: 450px;padding-right: 10px;border: 1px solid #CCC;">
                                    <h2 style="padding-left: 20px;font-size: 18px;margin-top: 0px;font-family: 'Open Sans Condensed';">Detalii:</h2>
                                    <?php echo "<div style='font-size: 14px;'>", $product_array[$key]["descriere"], "</div><br/><br/>"; ?>
                                </div>


                                <div class="col-md-12">
                                    <div style=" position: relative; margin-top: -362px;float:right;">
                                        <div class='clear'></div>
                                        <div style="float: right;color: #F00;font-size: 25px;margin-top: -50px;margin-right: 88px;width:87%;" class="col-md-3">
                                            <div style="color: #000;display: inline-block; float:right;padding-right: 32px;font-weight: bold;">Pret:</div>
                                        </div>




                                        <div style="float: right;color: #F00;font-size: 24px;margin-top: 4px;width:87%;font-weight: bold;font-family: 'Open Sans Condensed';" class="col-md-3">
                                            <?php echo "<div style='float:right;font-size: 30px;'>", $product_array[$key]["price"], " Lei"; ?>
                                        </div>
                                    </div>
                                    <br>
                                    <br>   
                                    <br/>
                                    <br/>

                                    <form method="post" action="cosulmeu.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                        <div class="caic">
                                            <div>
                                                <p class="btninstoc" style="margin-left: 80px;">
                                                    in stoc
                                                </p>
                                                <p id="quantity" style="margin-left: 80px;">
                                                    Garantie inclusa. <br>
                                                    Persoane fizice: 36 luni <br>
                                                    Persoane juridice: 12 luni
                                                </p>
                                                <input class="pull-left form-control" style="width: 80px;  margin-left: 66px;margin-top: 20px;" type="number" name="quantity" value="1" />

                                                <input class="pull-right-details" type="submit" value="Adauga in cos" class="btnAddAction" /></div>

                                        </div>
                                    </form>
                                </div>


                                <div class="clear"></div>
                                <h5 style="width: 319px;margin-top: 34px;">Daca v-a placut produsul de la noi acordati o nota!</h5>
                                <div class="stars">
                                    <input onchange="do_submit()" value="5" class="star star-5" id="star-5" type="radio" name="rate_vote"/>
                                    <label class="star star-5" for="star-5"></label>
                                    <input onchange="do_submit()" value="4" class="star star-4" id="star-4" type="radio" name="rate_vote"/>
                                    <label class="star star-4" for="star-4"></label>
                                    <input onchange="do_submit()" value="3" class="star star-3" id="star-3" type="radio" name="rate_vote"/>
                                    <label class="star star-3" for="star-3"></label>
                                    <input onchange="do_submit()" value="2" class="star star-2" id="star-2" type="radio" name="rate_vote"/>
                                    <label class="star star-2" for="star-2"></label>
                                    <input onchange="do_submit()" value="1" class="star star-1" id="star-1" type="radio" name="rate_vote"/>
                                    <label class="star star-1" for="star-1"></label>
                                </div>
                            </div>
                        </div> 
































                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--CLASIC-->
                        <!--                        <div class="row">
                                                    <div class="col-md-6">
                                                        <form method="post" action="cosulmeu.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                                            <div><strong><?php echo $product_array[$key]["name"]; ?></strong></div>
                                                            <div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
                        
                        
                                                            <div><input class="pull-left form-control" style="width: 100px; margin-right: 10px; visibility: hidden;" type="number" name="quantity" value="1" /><input class="pull-left" type="submit" value="Add to cart" class="btnAddAction" /></div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="product-price"><?php echo "$" . $product_array[$key]["price"]; ?></div>
                        <?php
                        echo $product_array[$key]["descriere"];
                        ?>
                                                    </div>
                                                </div>-->

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