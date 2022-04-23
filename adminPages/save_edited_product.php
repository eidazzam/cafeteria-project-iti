
<?php
include('../db.php');

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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// -------------- check for validations ---------------
$errors = [];
$oldData = [];
$oldData["category"] = "{$_POST["category"]}";
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
            $oldData['file'] = $_FILES["file"]["name"];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


if (count($errors) > 0) {
    $err = json_encode($errors);
    if (count($oldData) > 0) {
        $data = json_encode($oldData);
        header("location:edit_product.php?errors={$err}&data={$data}&id={$id}");
    } else {
        header("location:edit_product.php?errors={$err}&id={$id}");
    }
} else {

    if (isset($_POST['update_task'])) {
        $name = $_POST['name'];
        $price = (int)$_POST['price'];
        $category = (int)$_POST['category'];
        $img_path = "$filename";


        $query = "UPDATE product SET name = '$name', price = '$price', pic = '$img_path', category_id = $category WHERE product_id=$id";


        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query Failed.");
        }

        $_SESSION['message'] = 'Product Updated Successfully';
        $_SESSION['message_type'] = 'success';
        header('Location: list_products.php');
    }
}



?>




