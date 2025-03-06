
=======
<?php
session_start();
include 'includes/connection.php';
include 'includes/insertProduct.php';
$db = new Connection();
$pdo = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Product deleted successfully!";
            header("Location: products.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to delete Product!";
            header("Location: products.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: products.php");
        exit();
    }
} else {
    $_SESSION['error'] = "No ID provided!";
    header("Location: products.php");
    exit();
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
        <?php include 'includes/header.php' ?>

        <?php include 'includes/sideBar.php' ?>

        <div class="page-wrapper">
            <div class="row m-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>
                                Products List
                                <a href="product_add.php" class="btn btn-info float-right">Add Products</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM products";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();

                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if ($result) {
                                            foreach ($result as $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['description'];?></td>
                                                    <td><?php echo $row['price']; ?></td>
                                                    <td><?php echo $row['created_at']; ?></td>
                                                    <td> 
                                                        <a href="product_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-cust m-1">Edit</a>
                                                        <a href="product_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-cust m-1" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                    </td>
                                                </tr>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="6">No data found.</td>
                                            </tr>
                                        <?php

                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

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

>>>>>>> mony
</html>