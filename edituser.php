<?php
   
    require "dbConnect.php";

    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);



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
    <title>Edit User</title>
    <style>
      .error {color: #FF0000;}
    </style>
</head>
<body>
    <?php
while($user=$users->fetch_array()){
     	
    ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light ">
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
    <div class="container container-fluid w-50 bg-light position-absolute top-50 start-50 translate-middle mt-4" >
        <h1 class="text-center mb-3 mt-3">Edit user</h1>

        <form action="./updatevalidation.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
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
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
</body>
</html>
        <?php

   }  
   }catch (Exception $e){
    echo $e->getMessage();
}
?>