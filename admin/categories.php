<?php
include 'includes/connection.php';
include 'includes/insertCategory.php';
$db = new Connection();
$pdo = $db->getConnection();

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
                                Category List
                                <a href="category_add.php" class="btn btn-info float-right">Add Categories</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM category";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();

                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if ($result) {
                                            foreach ($result as $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['cat_id']; ?></td>
                                                    <td><?php echo $row['cat_name']; ?></td>
                                                    <td><?php echo $row['created_at']; ?></td>
                                                    <td><?php echo $row['updated_at']; ?></td>
                                                    <td> 
                                                        <a href="category_edit.php?cat_id=<?php echo $row['cat_id']; ?>" class="btn btn-warning btn-cust m-1">Edit</a>
                                                        <a href="category_delete.php?cat_id=<?php echo $row['cat_id']; ?>" class="btn btn-danger btn-cust m-1">Delete</a>
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

</html>