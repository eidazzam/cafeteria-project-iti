<?php include("../database/db.php"); ?>

<?php include('adminNav.html') ?>
<?php
if (isset($_GET["errors"])) {
    $errors = json_decode($_GET["errors"]);
}

if (isset($_GET["data"])) {
    $data = json_decode($_GET["data"]);
}
if (isset($data->name)) {
    $product_name = $data->name;
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM product WHERE product_id=$id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $product_name = $row['name'];
    }
}
if (isset($data->price)) {
    $product_price = $data->price;
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM product WHERE product_id=$id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $product_price = $row['price'];
    }
}
if (isset($data->file)) {
    $product_file = $data->file;
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM product WHERE product_id=$id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $product_file = $row['pic'];
    }
}




?>
<?php

session_start();
// If the user is not logged in navajowhiteirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
}
if ($_SESSION['is_admin'] != 1) {
    die("Access Denied");
}
?>




<?php
// include('../includes/header.php'); 
?>
<html>

<head>
    <link rel="stylesheet" href="../css/adminNav.css" />

    <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        body {
            background-image: url("../images/coffe_black.jpg");
            background-repeat: no-repeat;
            background-origin: content-box;
            background-position: center;
            background-size: cover;
        }

        #update {
            background-color: navajowhite;
            color: black;
            font-size: 20px;
            font-weight: bold;
        }

        h1 {
            color: navajowhite;
            text-align: center;
        }

        .card {
            margin-top: 30px;
            background-color: black;
            border-radius: 20px;
        }
    </style>
</head>

<body>


    <main class="container p-4">
        <div class="row">
            <div class="col-md-4 "></div> <!-- Just Padding  -->
            <div class="col-md-5">

                <div class="card card-body ">
                    <form action="save_edited_product.php?id=<?php echo "{$_GET['id']}" ?>" method="POST" enctype="multipart/form-data">

                        <div class="title form-group mb-3">
                            <h1> Update Product </h1>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Product Name" value='<?php echo $product_name; ?>' autofocus>
                            <p style="color: navajowhite;">
                                <?php
                                if (isset($errors->name)) {
                                    echo "{$errors->name} ";
                                }
                                ?>
                            </p>
                        </div>

                        <div class="form-group mb-3">
                            <input type="number" name="price" class="form-control" placeholder="cost" min="0" value='<?php echo $product_price; ?>' autofocus>
                            <p style="color: navajowhite;">
                                <?php
                                if (isset($errors->price)) {
                                    echo "{$errors->price} ";
                                }
                                ?>
                            </p>
                        </div>

                        <div class="form-group mb-3">
                            <select class="form-control" id="exampleFormControlSelect1" name="category">

                                <?php
                                $query = "SELECT * FROM category";
                                $result_tasks = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result_tasks)) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01" value='<?php echo $product_file ?>'>
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>

                            </div>


                        </div>
                        <p style="color: navajowhite;" class="mb-3">

                            <?php
                            if (isset($errors->file)) {
                                echo "{$errors->file} ";
                            }
                            ?>

                        </p>
                        <input type="submit" name="update_task" class="btn  btn-block mb-3" value="Update " id="update">
                    </form>

                </div>
            </div>

        </div>

        </div>
    </main>
</body>

</html>
<?php
// include('../includes/footer.php'); 
?>