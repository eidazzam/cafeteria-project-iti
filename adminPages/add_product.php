<?php
if (isset($_GET["errors"])) {
    $errors = json_decode($_GET["errors"]);
}

if (isset($_GET["data"])) {
    $data = json_decode($_GET["data"]);
}

?>
<?php

session_start();
// // If the user is not logged in redirect to the login page...
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: ../login.php');
// }
// if ($_SESSION['is_admin'] != 1) {
//     die("Access Denied");
// }
?>


<?php include("../db.php"); ?>

<?php include('adminNav.html') ?>


<?php
// include('../includes/header.php'); 
?>
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

    #add {
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
<main class="container p-4">
    <div class="row">
        <div class="col-md-4"></div> <!-- Just Padding  -->
        <div class="col-md-5">

            <div class="card card-body">
                <form action="save_product.php" method="POST" enctype="multipart/form-data">

                    <div class="title form-group mb-3">
                        <h1> Add Product </h1>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Product Name" value="<?php if (isset($data->name)) echo "{$data->name}"; ?>" autofocus>
                        <p style="color: red;">
                            <?php
                            if (isset($errors->name)) {
                                echo "{$errors->name} ";
                            }
                            ?>
                        </p>
                    </div>

                    <div class="form-group mb-3">
                        <input type="number" name="price" class="form-control" placeholder="cost" min="0" value="<?php if (isset($data->price)) echo "{$data->price}"; ?>" autofocus>
                        <p style="color: red;">
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
                            <input type="file" name="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>

                        </div>


                    </div>
                    <p style="color: red;" class="mb-3">

                        <?php
                        if (isset($errors->file)) {
                            echo "{$errors->file} ";
                        }
                        ?>

                    </p>
                    <input type="submit" name="save_task" id="add" class="btn btn-success btn-block mb-3" value="Add ">
                </form>

            </div>
        </div>

    </div>

    </div>
</main>


<?php
// include('../includes/footer.php'); 
?>