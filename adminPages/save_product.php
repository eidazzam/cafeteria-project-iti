
<?php
include('../database/db.php');

session_start();

// If the user is not logged in redirect to the login page...
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: ../login.php');
// }
// if ($_SESSION['is_admin'] != 1) {
//     die("Access Denied");
// }
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
if ($_POST["price"] == "") {
    $errors["price"] = "product price is required";
} else {
    $oldData["price"] = "{$_POST["price"]}";
}
if ($_FILES["file"]["name"] == "") {
    $errors["file"] = "uploading image is required";
} else {
    try {

        $filename = $_FILES['file']['name'];
        $filetype = $_FILES['file']['type'];
        $filetmp_name = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $ext = explode(".", $_FILES['file']['name']);
        $fileExt = strtolower(end($ext));
        $extensions = ["png", "jpg", "jpeg"];
        if (in_array($fileExt, $extensions) === false) {
            $errors["file"] = "image extension must png, jpg or jpeg";
        } else {
            move_uploaded_file($filetmp_name, "../images/" . $filename);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


if (count($errors) > 0) {
    $err = json_encode($errors);
    if (count($oldData) > 0) {
        $data = json_encode($oldData);
        header("location:add_product.php?errors={$err}&data={$data}");
    } else {
        header("location:add_product.php?errors={$err}");
    }
} else {

    if (isset($_POST['save_task'])) {
        $name = $_POST['name'];
        $price = (int)$_POST['price'];
        $category = (int)$_POST['category'];
        $img_path = "$filename";



        $query = "INSERT INTO product(name, price, pic, category_id) VALUES ('$name', $price, '$img_path',$category)";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query Failed.");
        }

        $_SESSION['message'] = 'Product Added Successfully';
        $_SESSION['message_type'] = 'success';
        header('Location: list_products.php');
    }
}



?>




