<?php
   
   require "../database/dbConnect.php";

  ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

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


    if (isset($_GET["errors"])){
        $errors = json_decode($_GET["errors"]);
    }
   
    if (isset($_GET["olddata"])){
      $olddata = json_decode($_GET["olddata"]);
  }


     $id = $_GET["id"];
    

    try{
        $a= new Database();
        $a->connect();
        $users=$a->select('user','*',' user_id = '.$id);

      


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
    <link rel="stylesheet" href="../css/adminNav.css" />
   
<link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Edit User</title>
    <style>
      .error {color: #FF0000;}
      
        body {
            background-image: url("../images/coffe_black.jpg");
            background-size: cover;
            background-origin: content-box;
            background-repeat: no-repeat;
            background-attachment: fixed;
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

    .block {
        margin-top: 30px;
        background-color: black;
        border-radius: 20px;
    }
    label{
      color:navajowhite;
    }
        </style>
</head>
<body>
    <?php
while($user=$users->fetch_array()){
     	
    ?>

<?php include('adminNav.html') ?>
    
        
<main class="container p-4">
    <div class="row">
        <div class="col-md-4"></div> 
        <div class="col-md-5">

       <div class="block card-body"> 
      
        <form action="./updatevalidation.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data" >
        <div class="title form-group mb-3">
                        <h1> Edit User </h1>
                    </div>   
        <div class="form-group">
              <label for="name">User Name</label>
              <input type="text" name="username" class="form-control" id="name" value="<?php if(isset($olddata->username)) {echo $olddata->username;} else if(empty($errors->username) ){echo $user[1];} ?>" >
		<p class="error"><?php if(isset($errors->username)){echo $errors->username;}?></p>	
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" class="form-control" id="email"  value="<?php if(isset($olddata->email)) {echo $olddata->email;} else if(empty($errors->email) ) {echo $user[3]; }?>"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
		<p class="error"><?php if(isset($errors->email)){echo $errors->email;} ?></p>	
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" id="password" value="<?php if(isset($olddata->password)) {echo $olddata->password;} else if(empty($errors->password) ) echo $user[2]; ?>" pattern="[a-zA-Z0-9._%+-]{3,}" >
		<p class="error"><?php if(isset($errors->password)){echo $errors->password; } ?></p>	
            </div>

            <div class="form-group">
              <label for="room">Room</label>
              <input type="text" name="room" class="form-control" id="room" value="<?php if(isset($olddata->room)) {echo $olddata->room;} else if(empty($errors->room) ) {echo $user[4]; }?>">
		<p class="error"><?php if(isset($errors->room)){echo $errors->room; }?></p>	
            </div>

            <div class="form-group">
              <label for="ext">Ext</label>
              <input type="tel" name="ext" class="form-control" id="ext" value="<?php if(isset($olddata->ext)) {echo $olddata->ext;} else if(empty($errors->ext)) {echo $user[6];} ?>" pattern="01[0-9]{9}">
		<p class="error"><?php if(isset($errors->ext)){echo $errors->ext;} ?></p>	
            </div>

              <div class="form-group">
                <label for="profile_pic">Image</label>
                <input type="file" name="profile_pic" class="form-control" id="profile_pic" value="<?php echo $user[5];?>" >
		<p class="error"><?php if(isset($errors->profile_pic)) {echo $errors->profile_pic;}?></p>	
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-3" id="add">Update User</button>
          </form>
          </div>
          </div>
        </div>

    </div>

    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
</body>
</html>
        <?php

   }  
   }catch (Exception $e){
    echo $e->getMessage();
}
?>