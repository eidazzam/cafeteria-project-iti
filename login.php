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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center login">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section login-title">
                        Welcome to ITI Cafeteria
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 bg-dark py-5" style="border-radius: 15px">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Login</h3>
                        <form action="authenticate.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" value="" required />
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" value="" required />
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3" value="Login">
                                    Sign In
                                </button>
                            </div>
                            <div class="form-group d-md-flex">
                                <!-- <div class="w-50">
                    <label class="checkbox-wrap checkbox-primary"
                      >Remember Me
                      <input type="checkbox" checked />
                      <span class="checkmark"></span>
                    </label>
                  </div> -->
                                <div class="w-50 text-md-right">
                                    <a href="forgetPassword.php" style="color: #fff">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>