<?php
include('config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // for debugging

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

$error = "";
if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
   $email = $_POST["email"]; // Set email variable
   $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitizing email(Remove unexpected symbol like <,>,?,#,!, etc.)
   $email = filter_var($email, FILTER_VALIDATE_EMAIL); // Validate email(Remove invalid email)

   if (!$email) { // if email is not valid
      $error .= "<p>Invalid email address please type a valid email address!</p>";
   } else {
      $sel_query = "SELECT * FROM `user` WHERE email='$email'";
      $results = $db->query($sel_query);
      $results->setFetchMode(PDO::FETCH_ASSOC);// Fetch data in associative array
      if (!$results->fetch()) { // if email not found
         $error .= "<p>No user is registered with this email address!</p>";
      }
   }
   if ($error != "") { // if error occured
      echo "<div class='error'>" . $error . "</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   } else { // if there is no error, then send reset password link
      $expFormat = mktime( // mktime(hour,minute,second,month,day,year)
         date("H"), 
         date("i"),
         date("s"),
         date("m"),
         date("d") + 1,
         date("Y")
      );
      $expDate = date("Y-m-d H:i:s", $expFormat); // Date after 1 day
      $key = md5((string)(2418 * 2).$email); // Generate reset key
      $addKey = substr(md5(uniqid(rand(), 1)), 3, 10); // بعمل رقم عشوائي بحجم 10 حرف و تضيفه إلى الكى المكتوب في الخطوة الأولى
      $key = $key . $addKey; // تجميع الكى المكتوب في الخطوة الأولى بالكى المكتوب في الخطوة الثانية
      // just like encrypt and decrypt
      // Insert Temp Table
      $db->query("INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES ('" . $email . "', '" . $key . "', '" . $expDate . "');");

      $output = '<p>Dear user,</p>';
      $output .= '<p>Please click on the following link to reset your password.</p>';
      $output .= '<p>================================================================</p>';
      $output .= '<p><a href="http://localhost/cafeteria-project-iti/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset" target="_blank">
http://localhost/cafeteria-project-iti/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
      $output .= '<p>================================================================</p>';
      $output .= '<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reasons.</p>';
      $output .= '<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may consider changing your password
just in case someone is trying to hack it.</p>';
      $output .= '<p>Have a great day!,</p>';
      $output .= '<p>Cafeteria Team</p>';
      $body = $output;
      $subject = "Password Recovery - Cafeteria";

      $email_to = $email;
      $fromserver = "OS.cafeteria.42@gmail.com"; // Email address to send emails from (user)
      $mail = new PHPMailer(); // create a new object
      $mail->IsSMTP();
      $mail->Host = 'smtp.gmail.com'; // Enter your host here
      $mail->SMTPAuth = true;
      $mail->Username = 'OS.cafeteria.42@gmail.com'; // Enter your email here
      $mail->Password = '#itiphppro'; // Enter your password here
      $mail->SMTPSecure = 'tls'; // For Gmail
      $mail->Port = 587;
      $mail->IsHTML(true);
      $mail->From =  'OS.cafeteria.42@gmail.com';
      $mail->FromName = "abdelrahman gbr";
      $mail->Sender = $fromserver; // indicates ReturnPath header
      $mail->Subject = $subject;
      $mail->Body = $body; 
      $mail->AddAddress($email_to); // Add a recipient
      if (!$mail->Send()) {
         echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
         echo "<div class='error'>
<p>An email has been sent to you with instructions on how to reset your password.</p>
</div><br /><br /><br />";
      }
   }
} else {
?>
   <link rel="stylesheet" href="css/forgetPass.css">
   <form method="post" action="" class='form' name="reset"><br /><br />
      <label>Enter Your Email Address:</label><br /><br />
      <input type="email" name="email" placeholder="username@email.com" />
      <br /><br />
      <input type="submit" value="Reset Password" />
   </form>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
<?php } ?>