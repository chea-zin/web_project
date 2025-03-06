<?php
session_start();
include_once "includes/connection.php";
require_once "includes/insertProduct.php";

$db = new Connection();
$pro = new Products($db);
$pdo = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateProduct"])) {
    $id = trim($_POST["id"] ?? "");
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = trim($_POST["price"]);
    // Handle image upload properly
    $image = isset($_FILES["image"]["name"]) ? $_FILES["image"]["name"] : "";

    // Fetch existing image if no new image is uploaded
    if (empty($image)) {
        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $image = $row['image'] ?? "";  // Keep the existing image if no new one is uploaded
    }


    if (!empty($id) && !empty($name) && !empty($description) && !empty($price)) {
        $data = [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
        ];
        if ($pro->update($id, $data)) {
            echo "<script>alert('Product updated Successfully!'); window.location.href='products.php';</script>";
        } else {
            echo "<script>alert('Failed to update');</script>";
        }
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$res) {
        echo "<h5>No Product Found!</h5>";
        exit;
    }
} else {
    echo "<h2>No ID Found!</h2>";
    exit;
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
                                Update Products
                            </h2>
                        </div>
                        <div class="card-body">
                            <form action="product_edit.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value="<?= $res['name'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <input type="text" name="description" value="<?= $res['description'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" value="<?= $res['price'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image">Image</label> <br />
                                            <input type="file" name="image" accept="image/*">
                                            <br />
                                            <?php if (!empty($res['image'])): ?>
                                                <img src="assets/image/product_page<?= htmlspecialchars($res['image']) ?>" width="100">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3 text-right">
                                            <br />
                                            <button type="submit" class="btn btn-info" name="updateProduct">Accept</button>
                                            <a href="products.php" class="btn btn-danger" name="cancelUser">Cancel</a>
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