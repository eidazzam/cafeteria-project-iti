
<?php
include('../db.php');

session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
}
if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}
?>


<?php


// -------------- check for validations ---------------
$errors = [];
$oldData = [];
if ($_POST["name"] == "") {
    $errors["name"] = "product name is required";
} else {
    $oldData["name"] = "{$_POST["name"]}";
}
if ($_POST["id"] == "") {
    $errors["id"] = "product id is required";
} else {
    $oldData["id"] = "{$_POST["id"]}";
}

if (count($errors) > 0) {
    $err = json_encode($errors);
    if (count($oldData) > 0) {
        $data = json_encode($oldData);
        header("location:add_category.php?errors={$err}&data={$data}");
    } else {
        header("location:add_category.php?errors={$err}");
    }
} else {

    if (isset($_POST['save_task'])) {
        $id = (int)$_POST['id'];
        $name = $_POST['name'];

        $query = "INSERT INTO category(id,name) VALUES ( $id,'$name')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query Failed.");
        }

        $_SESSION['message'] = 'Product Added Successfully';
        $_SESSION['message_type'] = 'success';
        header('Location: add_product.php');
    }
}

?>



