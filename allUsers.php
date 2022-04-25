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
    <link rel="stylesheet" href="css/adminNav.css" />
<link rel="stylesheet" href="css/users.css" />
<link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
 table th,
 table tr,
 table td {
    border-left: 1px solid navajowhite;
    border-right: 1px solid navajowhite;
    border-top: 1px solid navajowhite;
    border-collapse: collapse;
    padding: 5px;
    text-align: center;

}
</style>  
</head>


<body>
<?php include('adminNav.html') ?>
<main id='main-container' class="container p-4">
<div id="table-container">

      <div class='table-title'>
            <div>All Users</div>
            <button onclick="window.location.href='addUser.php'">Add User</button>
        </div>
        <table >
            
            <tr class="table-header">
                <th>User Name</th>
                <th>Room</th>
                <th>Image</th>
                <th>Ext.</th>
                <th>Action</th>
                
              </tr>
            
            

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
          <td><?php echo $user['username'];?></td>
          <td><?php echo $user['room'];?></td>
          <td><?php echo'<img  width=50px src="./images/'.$user['profile_pic'].'">';?></td>
          <td><?php echo $user['ext'];?></td>
          <td>
              
              <a class="btn btn-primary" href="./edituser.php?id=<?php echo $user['user_id'];?>" class="btn btn-warning"><i class="fas fa-sloid fa-marker"> </i></a>
              <a class="btn btn-danger" href="./deleteuser.php?id=<?php echo $user['user_id'];?>" class="btn btn-danger"> <i class="far fa-trash-alt"></i></a>
          </td>
        </tr>
    <?php

     }

    ?>  
           
          </table>

    
    </div>

</main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    
  </body>
    </html>

    <?php

      }catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      }


?>

