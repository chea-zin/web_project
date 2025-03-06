<?php
session_start();
include_once "includes/connection.php";
require_once "includes/insertUser.php";

$db = new Connection();
$user = new User($db);
$pdo = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUser"])) {
    $id = trim($_POST["id"] ?? "");
    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $is_ban = isset($_POST["is_ban"]) ? 1 : 0;
    $role = trim($_POST["role"] ?? "");

    if (!empty($id) && !empty($name) && !empty($phone) && !empty($email) && !empty($role)) {
        $data = [
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "is_ban" => $is_ban,
            "role" => $role
        ];

        // If password is provided, update it
        if (!empty($password)) {
            $data["password"] = password_hash($password, PASSWORD_BCRYPT);
        }

        if ($user->update($id, $data)) {
            echo "<script>alert('User updated Successfully!'); window.location.href='user.php';</script>";
        } else {
            echo "<script>alert('Failed to update');</script>";
        }
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}

if (isset($_GET['id'])) {
    $us_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->bindParam(1, $us_id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$res) {
        echo "<h5>No User Found!</h5>";
        exit;
    }
} else {
    echo "<h5>No ID Found!</h5>";
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
        <?php include 'includes/header.php' ?>

        <?php include 'includes/sideBar.php' ?>

        <div class="page-wrapper">
            <div class="row m-2">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>
                                Update User
                            </h2>
                        </div>
                        <div class="card-body">
                            <form action="user_edit.php" method="POST">
                            <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value="<?=$res['name']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone">Phone No.</label>
                                            <input type="text" name="phone" value="<?=$res['phone']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" value="<?=$res['email']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Select Role</label>
                                            <br />
                                            <select name="role" class="form-select text-secondary">
                                                <option value="">Select Role</option>
                                                <option value="admin" <?= $res['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="user" <?= $res['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="role">Is Ban</label>
                                            <br>
                                            <input type="checkbox" name="is_ban" <?= $res['is_ban'] ? 'checked' : '' ?> style="width: 20px; height: 20px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 text-right">
                                            <br />
                                            <button href="#" type="submit" class="btn btn-info mr-2" name="updateUser">Accept</button>
                                            <a href="user.php" class="btn btn-danger" name="cancelUser">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'includes/footer.php' ?>
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