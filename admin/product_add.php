<?php
session_start();
include_once 'includes/connection.php';
require_once 'includes/insertProduct.php';

$db = new Connection();
$pdo = $db->getConnection();
$pro = new Products($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $image = trim(string: $_FILES["image"]['name'] ?? "");
    $pro_image_tmp_name = trim($_FILES["image"]['tmp_name'] ?? "");
    $pro_image_folder = "assets/images/product_page/" .$image;

    if (!empty($name) && !empty($description) && !empty($price) && !empty($image)) {

        // Insert product into database
        if ($pro->insert($name, $description, $price, $image)) {
            $_SESSION['message'] = "Product Created Successfully!";
            header("Location: products.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to insert product.";
        }
        //For add new image
        move_uploaded_file($pro_image_tmp_name, $pro_image_folder);
    } else {
        $_SESSION['error'] = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include 'includes/head.php' ?>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <?php include 'includes/header.php' ?>

        <?php include 'includes/sideBar.php' ?>

        <div class="page-wrapper">
            <div class="row m-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>
                                Add Products
                            </h2>
                        </div>
                        <div class="card-body">
                            <form action="product_add.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <input type="text" name="description" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image">Image</label><br/>
                                            <input type="file" name="image" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3 text-right">
                                            <br />
                                            <button type="submit" class="btn btn-info mr-2" name="acceptProduct">Accept</button>
                                            <a href="products.php" type="reset" class="btn btn-danger" name="cancelUser">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <script src="dist/js/custom.min.js"></script>
    <script src="assets/extra-libs/c3/d3.min.js"></script>
    <script src="assets/extra-libs/c3/c3.min.js"></script>
    <script src="assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/pages/dashboards/dashboard1.min.js"></script>
</body>

</html>