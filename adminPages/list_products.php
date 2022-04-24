<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
}
if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}
?>


<?php include("../db.php");

$results_per_page = 2;
$sql = "select * from product";
$result = mysqli_query($conn, $sql);
$number_of_results = mysqli_num_rows($result);
$number_of_pages = ceil($number_of_results / $results_per_page);

if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$this_page_first_result = ($page - 1) * $results_per_page;
$sql = 'SELECT * FROM product LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
$result = mysqli_query($conn, $sql);

?>

<!-- <'?php include('../includes/header.php'); ?> -->
<?php include('adminNav.html') ?>
<link rel="stylesheet" href="../css/adminNav.css" />
<link rel="stylesheet" href="../css/listProducts.css" />
<link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<main id='main-container' class="container p-4">

    <!-- ********************* -->

    <div id="table-container">


        <div class='table-title'>
            <div>All Products</div>
            <button onclick="window.location.href='add_product.php'">Add Product</button>
        </div>

        <table>
            <tr class="table-header">
                <th>Product</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Action</th>
            </tr>

            <?php
            $query = "SELECT p.* ,c.name as category FROM product p, category c Where p.category_id=c.id  LIMIT " . $this_page_first_result . "," .  $results_per_page;
            $result_tasks = mysqli_query($conn, $query);


            while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?> EGP</td>
                    <td><img src="../images/<?php echo $row['pic']; ?>" alt="image" width=50px></td>
                    <td><?php echo $row['category']; ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['product_id'] ?>" class="btn btn-warning">
                            <i class="fas fa-sloid fa-marker"> </i>
                        </a>
                        <a href="delete_product.php?id=<?php echo $row['product_id'] ?>" class="btn btn-danger">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php }

            ?>
        </table>

    </div>

</main>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item " style="margin:1px"><a class="page-link text-dark" style="background-color:navajowhite; font-weight:bold;" href="list_products.php?page=1">First</a></li>

        <?php

        for ($page = 1; $page <= $number_of_pages; $page++) {
            echo ' <li class="page-item " style="margin:1px" ><a class="page-link text-dark" href="list_products.php?page=' . $page . '" style="background-color:navajowhite; font-weight:bold;">' . $page . '</a></li>';
        }
        ?>

        <li class="page-item " style="margin:1px"><a class="page-link text-dark" style="background-color:navajowhite; font-weight:bold;" href="?page=<?php echo $number_of_pages; ?>">Last</a></li>
    </ul>
</nav>

<!-- <'?php include('../includes/footer.php'); ?> -->