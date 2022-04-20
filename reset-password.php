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
            <br />
            <form method="post" action="" name="update">
                <input type="hidden" name="action" value="update" />
                <br /><br />
                <label><strong>Enter New Password:</strong></label><br />
                <input type="password" name="pass1" maxlength="15" required />
                <br /><br />
                <label><strong>Re-Enter New Password:</strong></label><br />
                <input type="password" name="pass2" maxlength="15" required />
                <br /><br />
                <input type="hidden" name="email" value="<?php echo $email; ?>" />
                <input type="submit" value="Reset Password" />
            </form>
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