
<?php

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

include("../db.php");
var_dump($_GET);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM product WHERE product_id = $id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query Failed.");
    }

    $_SESSION['message'] = 'Product Removed Successfully';
    $_SESSION['message_type'] = 'danger';
    header('Location: list_products.php');
}

?>
