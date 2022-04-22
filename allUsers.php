<?php 

  // session_start();
  // // If the user is not logged in redirect to the login page...
  // if (!isset($_SESSION['loggedin'])) {
  //     header('Location: ../login.php');
  // }
  // if ($_SESSION['is_admin']!=1){
  //     die ("Access Denied");
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Cafatiria</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" href="#">Home</a>
            <a class="nav-link " href="#">Products</a>
            <a class="nav-link " href="#">Users</a>
            <a class="nav-link " href="#">Manual Order</a>
            <a class="nav-link " href="#">Checks</a>
          </div>
        </div>
        
      </nav>
    <div class="container">
        
    <div class="text-center">
            <a href="#" class="mt-4 btn btn-success">Add user</a>
        </div>
        <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">User Name</th>
                <th scope="col">Room</th>
                <th scope="col">Image</th>
                <th scope="col">Ext.</th>
                <th scope="col">Action</th>
                
              </tr>
            </thead>
            <tbody>

            <?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "dbConnect.php";



    try {
     
      $a= new Database();
      $a->connect(); 
      $users=$a->select('user','*'); 

        while($user=$users->fetch_assoc()){ 

  ?>
 <tr>
          <th scope="row"><?php echo $user['username'];?></th>
          <td><?php echo $user['room'];?></td>
          <td><?php echo'<img height="50" width="60" src="./images/'.$user['profile_pic'].'">';?></td>
          <td><?php echo $user['ext'];?></td>
          <td>
              
              <a class="btn btn-primary" href="./edituser.php?id=<?php echo $user['user_id'];?>">Edit</a>
              <a class="btn btn-danger" href="./deleteuser.php?id=<?php echo $user['user_id'];?>">Delete</a>
          </td>
        </tr>
    <?php

     }

    ?>


            
             
            </tbody>
          </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    </body>
    </html>

    <?php

      }catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      }


?>

