<?php
session_start();
include ('headercart.php');

require_once("inc/dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('image' =>  $_POST["image"], 'name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"]));

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

<title>AFYC - Cosul meu</title>
<link rel="shortcut icon" type="image/png" href="images/logomic.png"/>


<div class="container">
    <script type="text/javascript">
        $('.rating').on('click', function () {
            $.post('bogdan.php?id=<?php echo $p[$i]->id; ?>', {rating: $(this).attr('rel')}, function () {
                alert('rating saved');
            }
        });
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="source/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type="text/javascript" src="source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">




    <?php
    if (isset($_SESSION["cart_item"])) {
        $item_total = 0;
        ?>	
        <table class="table" cellpadding="10" cellspacing="1" style="background-color: #fff; border-radius:10px;">
            <tbody>
                <tr>
                    <th style="text-align:left;"><strong>Img</strong></th>
                    <th style="text-align:left;"><strong>Nume</strong></th>
                    <th style="text-align:left;"><strong>Codul produsului</strong></th>
                    <th style="text-align:right;"><strong>Cantitatea</strong></th>
                    <th style="text-align:right;"><strong>Pret</strong></th>
                    <th style="text-align:center;"><strong>Actiune</strong></th>
                </tr>	
                <?php
                foreach ($_SESSION["cart_item"] as $item) {
                    ?>
                    <tr>
                        <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["image"]; ?></strong></td>
                        <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
                        <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
                        <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["price"] . " Lei"; ?></td>
                        <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="cosulmeu.php?action=remove&code=<?php echo $item["code"]; ?>" style="color: #E41F26;" class="btnRemoveAction">Remove Item</a></td>
                    </tr>
                    <?php
                    $item_total += ($item["price"] * $item["quantity"]);
                }
                ?>

                <tr>
                    <td colspan="5" align=right style="font-size:20px;"><strong>TOTAL : </strong> <?php echo $item_total . " Lei"; ?></td>

                </tr>

            </tbody>

        </table>
        <a href="index.php" class="btn btn-primary" style="background-color: #48999F;border-radius:10px;">Continua cumparaturile</a>
        <a id="show_comanda" href="#" class="btn btn-danger" style="background-color: #E41F26;border-radius:10px;">Finalizeaza comanda</a>

        <div class="row">
            <div class="col-md-2"></div>
            <div id="checkout" class="col-md-8">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="min-width: 132px;">Nume</span>
                    <input type="text" class="form-control" placeholder="Nume" aria-describedby="basic-addon1">
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="min-width: 132px;">Prenume</span>
                    <input type="text" class="form-control" placeholder="Prenume" aria-describedby="basic-addon1">
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="min-width: 132px;">Telefon</span>
                    <input type="text" class="form-control" placeholder="Telefon" aria-describedby="basic-addon1">
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="min-width: 132px;">Oras</span>
                    <input type="text" class="form-control" placeholder="Oras" aria-describedby="basic-addon1">
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="min-width: 132px;">Adresa</span>
                    <input type="text" class="form-control" placeholder="Adresa" aria-describedby="basic-addon1">
                </div>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="min-width: 132px;">Cod postal</span>
                    <input type="text" class="form-control" placeholder="Cod postal" aria-describedby="basic-addon1">
                </div>

                <a style="float:right; margin-top: 20px; background-color: #E41F26;border-radius:10px;" href="produs.php?action=remove&code=<?php echo $item["code"]; ?>" class="btn btn-danger">Trimite comanda</a>
            </div>
        </div>


        <?php
    } else {
        echo "Nu aveti nimic in cos.";
    }
    ?>





</div>

<?php

?>
<script>
        $(document).ready(function () {

            $("body").on("click", "#show_comanda", function (e) {
                e.preventDefault();
                $("#checkout").fadeIn();
            });
        });
</script>