<?php
    $errors = [];
    $olddata= [];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $image = $_FILES['profile_pic'];
    $room = $_POST['room'];
    $Ext = $_POST['ext'];
   

    



    try {
		$image_name = $image['name'];
        $tmp_name = $image['tmp_name'];
        $image_size = $image['size'];
        $ext = pathinfo($image_name)["extension"];
        $extensions = ['png', 'jpg', 'jepg'];

		if(empty($image_name) or $image_name==""){

			$errors['profile_pic'] = "Image is required!";

		}elseif(!in_array($ext, $extensions)){

            $errors['profile_pic'] = "Invalid image type!";

        }else{
            move_uploaded_file($tmp_name, "../images/".$image_name);
        }
        
    }catch (Exception $e) {
            echo $e->getMessage();
    }

    if (empty($username) or $username=="") {
        $errors["username"] = "Name is required!";
    }else {
        $olddata["username"] = $_POST['username'];
    }


    if(empty($email) or $email==""){
        $errors["email"] ="Email is required!";
    }
    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        
        $olddata["email"] = $_POST["email"];
    }else{
        $errors["email"] = "Invalid Email format";
    }

        
       
    if (empty($password) or $password=="") {
        $errors["password"] = "Password is required!";
    }else if(strlen($password)<8){
            $errors["password"] = "Password must be greater than 8 characters!";
        }
     else{
            $olddata["password"] = $_POST["password"];
        }

    if (empty($room) or $room=="") {
        $errors["room"] = "Room number is required!";
    } else{
        $olddata["password"] = $_POST["password"];
    }

    if (empty($Ext) or $Ext=="") {
        $errors["ext"] = "Ext is required!";
    }else{
        $olddata["ext"] = $_POST["ext"];
    }


    

    if(sizeof($errors)>0){
        $errors = json_encode($errors);
        if (count($olddata) > 0) {
            var_dump($olddata);
            $old = json_encode($olddata);

            header("Location:./edituser.php?errors={$errors}&id={$_GET['id']}&olddata={$old}");
        }else
        {header("Location:./edituser.php?errors={$errors}&id={$_GET['id']}");}
    }else{
        
   
       
        require "../database/dbConnect.php";

        $user_id = $_GET["id"];
       

        try {
            $a= new Database();
            $a->connect();

            $upd=array('username'=>$_POST['username'],'email'=>$_POST['email'],'password'=>$_POST['password'],'profile_pic'=> $_FILES['profile_pic']['name'],'room'=>$_POST['room'],'ext'=>$_POST['ext']);
      
            $a->update('user', $upd, array('user_id = '. $user_id));

            header("Location:./allUsers.php");
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();

        }
    }
?>



