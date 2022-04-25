 <?php
    require "dbConnect.php";

    $id = $_GET["id"];

    try {
        
          $a= new Database();
         $a->connect();
         $a->delete('user',' user_id = '.$id);
       
        header("Location:./allUsers.php");
        

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?> 