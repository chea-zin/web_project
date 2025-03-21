<?php 
session_start();
    include 'includes/connection.php';
    include 'includes/users_register.php';
    $db = new Connection();
    $user = new UserRegister($db);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"]?? "");
        $password = trim($_POST["password"]?? "");

        if (!empty($name) && !empty($password)) {
            // Authenticate user
            if ($user->login($name, $password)) {
                $_SESSION['user_name'] = $name; // Store name in session
                header("Location: index.php"); // Redirect after login
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Both fields are required.";
        }
    }
    
?>
<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Admin Panel</title>
    <link href="dist/css/style.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
            <div class="auth-box row">
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <h2 class="mt-3 text-center">Sign In</h2>
                        <?php if(!empty($error_message)): ?>
                            <p class="text-center text-danger"><?php echo $error_message?></p>
                        <?php endif?>
                        <form class="mt-4" method="POST" action="login.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="name">Username</label>
                                        <input class="form-control" id="name" name="name" type="text"
                                            placeholder="enter your names">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pwd">Password</label>
                                        <input class="form-control" id="pwd" name="password" type="password"
                                            placeholder="enter your password">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5">
                                    Don't have an account? <a href="register.php" class="text-danger">Sign Up</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js "></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <script>
        $(".preloader ").fadeOut();
    </script>
</body>

</html>