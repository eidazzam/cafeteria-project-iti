<?php

  session_start();
  // If the user is not logged in redirect to the login page...
  if (!isset($_SESSION['loggedin'])) {
      header('Location: ../login.php');
  }
  if ($_SESSION['is_admin']!=1){
      die ("Access Denied");
  }
?>


<?php
$response = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET["user"])) {
        $response = "";
    } else {
        $response = $_GET['user'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            background-image: url("../images/back2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body onload="dbreaction()">
    <?php include('adminNav.html') ?>
    <form class="container d-flex justify-content-center py-5 my-5 needs-validation" style="background-color:#212529; color:white;border-radius:1rem;max-width:500px;min-width:350px;" action="addUserdb.php" method="POST" id="form" enctype="multipart/form-data" novalidate>
        <div class="row mx-3 py-3">
            <div class="col-md-12">
                <h2 class="text-center">Add New User</h2>
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="username" pattern="[a-zA-Z_]+[a-zA-Z0-9]{2,10}" title="Name should start with letter or underscore, 3 characters at least 'No special characters are allowed'" required>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationCustom01" class="form-label">Email</label>
                <input placeholder="User@gmail.com" class="form-control" id="validationCustom01" type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationCustom02" class="form-label">Password</label>
                <input class="form-control" id="validationCustom02" type="password" name="password" pattern="[a-zA-Z0-9._%+-]{3,}" title="password should not be less than 3 characters or contain a special character" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-12">
                <label for="validationCustom03" class="form-label">Confirm password</label>
                <input class="form-control" id="validationCustom03" type="password" name="confirm" required>
                <div class="invalid-feedback">
                    Please confirm password.
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Room</label>
                <input type="text" class="form-control" name="room" pattern="[0-9]{0,5}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Ext.</label>
                <input type="text" class="form-control" type="tel" name="ext" pattern="01[0-9]{9}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Role</label>
                <div class="form-check">
                    <input value="1" class="form-check-input" type="radio" name="admin" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input value="0" class="form-check-input" type="radio" name="admin" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        User
                    </label>
                </div>
            </div>
            <div class="col-12 my-2">
                <label for="formFile" class="form-label">Profile Picture</label>
                <input class="form-control" type="file" name="image" id="img" accept=".png, .jpeg, .jpg" id="formFile">
            </div>
            <div class="col-12">
                <input type="hidden" name="hidden_id" value="">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </div>
    </form>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        let response = <?php echo json_encode($response) ?>;
        console.log(response)
        let notification = document.getElementById("notification");

        function dbreaction() {
            if (response == "accepted") {
                notification.innerHTML = "<p class='note'>User added successfully</p>";
                notification.style.display = 'block';
                notification.style.animation = 'notify 5s forwards';

            } else if (response == "notAccepted") {
                notification.innerHTML = "<p class='note'>User already exists</p>";
                notification.style.display = 'block';
                notification.style.animation = 'notify 2s forwards';

            }
        }
    </script>
</body>

</html>