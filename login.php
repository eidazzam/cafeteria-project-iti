<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
    if ($_SESSION['is_admin'] != 1) {
        header("Location: userPages/home.php");
    } else {
        header("Location: adminPages/manualOrder.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <form action="authenticate.php" method="POST" class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="mb-md-2 mt-md-2 pb-2">Welcome To ITI Cafeteria</h2>
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">
                                    Please enter your login and password!
                                </p>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" placeholder="Your UserName" value="" required class="form-control form-control-lg" />
                                    <label class="form-label">User name</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" placeholder="Your Password" value="" required class="form-control form-control-lg" />
                                    <label class="form-label">Password</label>
                                </div>

                                <p class="small mb-5 pb-lg-2">
                                    <a href="forgetPassword.php" class="ForgetPwd text-white-50">Forget Password?</a>
                                </p>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit" value="Login">
                                    Login
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>