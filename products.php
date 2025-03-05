<?php 
session_start();
?>

<!DOCTYPE html>

<html lang="en">
<title>Product Page</title>
    <head>
        <link href="assets/styles/product_page/styles.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include("components/nav.php"); ?>
        <!-- END OF MENU PAGE --> 

        <!-- MAIN BODY -->
        <div id="product-page-body">
            <?php include("pages/product_category.php"); ?>

            <?php include("pages/headphone_section.php"); ?>
          

            <!-- FIRST PROMOTION SECTION -->
            <?php include("pages/first_promo.php"); ?>
             <!-- END OF SECOND PROMOTION SECTION -->
             <?php include("pages/mobilephone_section.php"); ?>
           
            <!-- SECOND PROMOTION SECTION -->
           <?php include("pages/second_promo.php"); ?>
            <!-- END OF SECOND PROMOTION SECTION -->


            <!-- Watch SECTION -->
            <?php include("pages/smartwatch_section.php"); ?>
            <!-- END OF Watch COLLECTION -->
            
            <!-- END OF PRODUCT SECTIONS -->

        </div> <!-- END OF MAIN BODY -->
    </body>
    <?php include("components/footer.php"); ?>
</html>
