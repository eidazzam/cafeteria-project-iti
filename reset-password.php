<?php
include('config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$error = "";
if (
    isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) // check if the key and email is set
    && ($_GET["action"] == "reset") && !isset($_POST["action"]) // check if the form is submitted
) { // if all the conditions are met
    $key = $_GET["key"];
    $email = $_GET["email"];
    $curDate = date("Y-m-d H:i:s"); // current date
    $query = $db->query("SELECT * FROM `password_reset_temp` WHERE `key`='" . $key . "' and `email`='" . $email . "';"); // check if the key and email is in the database
    $query->setFetchMode(PDO::FETCH_ASSOC); // set the fetch mode to fetch associative array
    if (!$row = $query->fetch()) { // if the key and email is not in the database
        $error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link
from the email, or you have already used the key in which case it is 
deactivated.</p>';
    } else {
        //   $row = mysqli_fetch_assoc($query);
        $expDate = $row['expDate']; // get the expiry date
        if ($expDate >= $curDate) { // if the expiry date is greater than the current date
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Password Reset</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
                <style>
                    body {
                        background-image: url("./images/back2.jpg");
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                    }
                </style>
            </head>

            <body>
                <br />
                <form method="post" action="" name="update" class="container d-flex justify-content-center py-5 my-5 text-center" style="background-color:#212529; border-radius:1rem;max-width:500px;min-width:350px;">
                    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 justify-content-evenly text-white">
                        <div class="col-12 col-lg-8 col-lg-offset-8">
                            <input type="hidden" name="action" value="update" />
                        </div>
                        <div class="col-12 col-lg-8 col-lg-offset-8">
                            <label><strong>Enter New Password:</strong></label><br />
                            <input type="password" name="pass1" maxlength="15" required />
                        </div>
                        <div class="col-12 col-lg-8 col-lg-offset-8">
                            <label><strong>Re-Enter New Password:</strong></label><br />
                            <input type="password" name="pass2" maxlength="15" required />
                        </div>
                        <div class="col-12 col-lg-8 col-lg-offset-8">
                            <input type="hidden" name="email" value="<?php echo $email; ?>" />
                            <input type="submit" class="btn btn-outline-light btn-lg px-5 my-2" value="Reset Password" />
                        </div>
                    </div>
                </form>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
            </body>

            </html>
<?php
        } else {
            $error .= "<h2>The reset Link (key) is Expired</h2>
<p>The link is expired. You are trying to use the expired link which 
is valid only for 24 hours (1 days after request).<br /><br /></p>";
        }
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    }
} // isset email key validate end


if (
    isset($_POST["email"]) && isset($_POST["action"]) &&
    ($_POST["action"] == "update")
) {
    $error = "";
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    $email = $_POST["email"];
    $curDate = date("Y-m-d H:i:s");
    if ($pass1 != $pass2) {
        $error .= "<p>Password does not match, please check your input.<br /><br /></p>";
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    } else {
        // $pass1 = password_hash($pass1, PASSWORD_DEFAULT); // encrypt the password before storing in the database
        $db->query(
            "UPDATE `user` SET `password`='" . $pass1 . "' WHERE `email`='" . $email . "';" // update the password in the database
        );

        $db->query("DELETE FROM `password_reset_temp` WHERE `email`='" . $email . "';"); // delete the key from the database

        echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p>
<p><a href="login.php">
Click here</a> to Login.</p></div><br />'; // display the success message
    }
}
?>