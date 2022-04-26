<?php
session_start();
require '../database/dbConnect.php';
$db= new Database();
$dbcon= $db->connect();
$randNum=rand(10, 1000);
$date=date('Y-m-d H:i:s');
$ins="INSERT INTO `orders` (`order_id`,`user_id`, `date`, `status`,`totalPrice`) VALUES ($randNum,'{$_GET['id']}', '{$date}','processing','{$_POST['totalPrice']}')";

if ($dbcon->query($ins) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $ins . "<br>" . $dbcon->error;
  }
  
foreach ($_POST as $key=>$value){
    if($key!="totalPrice"){
        $ins="INSERT INTO `order_product` (`order_id`,`product_id`, `quantity`) VALUES ($randNum,'{$key}', '{$value}')";
        $insert=$dbcon->query($ins);
        //         var_dump($key);//product id
        // echo '<br/>';

        //         var_dump($value); //quantity
        // echo '<br/>';

    }
}

// var_dump($_POST);
// echo '<br/>';
// echo '<br/>';
// echo '<br/>';
// var_dump($_GET);
if($_SESSION['is_admin']==1){
  header ("Location:../adminPages/homeAdmin.php?id=" . $_GET['id']);
}else{
  header ("Location:../userPages/home.php?id=" . $_GET['id']);
}
?>