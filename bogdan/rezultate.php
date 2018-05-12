<?php
include ('header.php');
require_once (__DIR__ . '/inc/common.php');



//mysql-urile adaugate de mine
mysql_connect("localhost", "root", "") or die("Error connecting to database: " . mysql_error());
mysql_select_db("proiect") or die(mysql_error());



//if adaugat de mine
if  ($raw_results = mysql_query("SELECT * FROM products WHERE (`name` LIKE '%" . $query . "%')") or die(mysql_error())){
    
    
    
    
    
    $product = new Products();
    $p = $product->getProducts();
    
    
    
    
    
    
}







$no_of_element = count($p);
error_reporting(E_ALL);
?>

<title>AFYC</title>
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







    <style type="text/css">
        .fancybox-custom .fancybox-skin {
            box-shadow: 0 0 50px #222;
        }
    </style>

    <div style="background: none repeat scroll 0% 0% #fff;
         padding-left: 20px;
         padding-top: 10px;
         padding-bottom: 10px;
         color: #EC2426;
         font-size: 25px;
         border-radius: 10%;
         font-weight: bold;">Produse</div>




    <div class="row">
        <?php
        for ($i = 0; $i < $no_of_element; $i++) {
            ?>
            <div style="width: 390px;min-height: 200px;margin-top: 20px;" class="col-md-2"> 
                <!--50-->
                <?php
                if (!empty($p[$i]->image)) {
                    ?>
                    <span class="titlup">
                        <?php echo "<a href='product_details.php?id=" . $p[$i]->id . "'>", $p[$i]->name, "</a>";
                        ?>
                    </span>
                    <?php
                    echo "<div class='imagine_produs'><a href='" . $p[$i]->image . "' class='fancybox' data-fancybox-group='gallery'><img style='border-radius: 10px;width: 150px;' src='" . $p[$i]->thumb . "'/></a><br>";
                    echo "<div style='display:inline-block;margin-left:10px;'>";
                    $rate_vote = $p[$i]->rate_vote;
                    $rate_number = $p[$i]->rate_number;
                    $total_rate = $rate_vote / $rate_number;
                    $total_rate = round($total_rate * 2) / 2;
                    //echo $rate_vote/$rate_number;

                    if (empty($total_rate)) {
                        echo "<img width='100' src='images/rating/0.png'>";
                    } else {
                        echo "<img style='margin-top:-3px;' width='100' src='images/rating/$total_rate.png'>";
                    }

                    if (!empty($p[$i]->rate_number)) {
                        echo "<div style='display:inline-block;'>", round($total_rate, 1), "</div>"; //$rate_vote/$rate_number, 1, '.', '5');
                    } else {
                        echo"0";
                    }

                    echo "</div>";
                    echo"</div>";
                } else {
                    ?>

                    <span class="titlup"><?php echo "<a href='product_details.php?id=" . $p[$i]->id . "'>", $p[$i]->name, "</a>"; ?><span class="price"><?php //echo $p[$i]->price, " RON";      ?></span></span>
                    <?php
                    echo "<div class='imagine_produs'><img style='width: 150px;' src='images/default.jpg'></div>";
                }
                ?>

                <br/>
                <span class="price"><?php echo $p[$i]->price_party, " Lei"; ?> </span>
                <br/>

                <?php
//                echo "<div class='descr'>", $p[$i]->description, "</div></br>";
                ?>



                <div class="clear"></div>
                <div class="details_button">
                    <a  data-toggle="tooltip" title="Click pentru vizualizarea detaliilor" alt="Click pentru vizualizarea detaliilor" href="<?php echo 'product_details.php?id=' . $p[$i]->id . ''; ?>"> Detalii</a>
                </div>





                <?php
                if (isset($_POST['submit'])) {
                    $product = new Pizza();
                    $p = $product->getPizzas();
                    $pid = $_GET['id'];
                    $p = $product->getPizza($pid);
                    
                    $query = $_GET['query'];

                    @mysql_connect("localhost", "root", "") or die(mysql_error());
                    mysql_select_db("proiect") or die(mysql_error());

                    $nota = $_POST['rate_vote'];
                    if (empty($nota)) {
                        echo "Eroare";
                    }

                    $raw_results = mysql_query("SELECT * FROM products WHERE (`name` LIKE '%" . $query . "%')") or die(mysql_error());

                    if (empty($_POST['rate_vote']) || trim($_POST['rate_vote']) === '') {
                        $errors = "Complete the fields.";
                    }

                    if (empty($errors) === true) {
                        $product->rate_vote = htmlentities(trim($_POST['rate_vote']));
                    }

                    header("Location: index.php");
                    exit();
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
include ('footer.php');
?>