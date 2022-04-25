<?php 

  session_start();
  // If the user is not logged in redirect to the login page...
  if (!isset($_SESSION['loggedin'])) {
      header('Location: ../login.php');
  }
  if ($_SESSION['is_admin']!=1){
      die ("Access Denied");
  }
?>


<?php

include '../config.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" href="css/login.css" /> -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/checks.css">
    <link rel="stylesheet" href="../css/adminNav.css" />
    <title>Users orders</title>

    <style>


* {
    box-sizing: border-box;
  }
  
  html, body {
    height: 100%;
    margin: 0;
  }

body {
    background-color: #faf9f4;
    font-family: 'Tajawal', sans-serif;
    /* padding-top: 20px; */

}

.container{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    height: 100%;

    /* max-width: unset; */

}
.myform{
    margin: 10px;
    padding: 10px;
    width: 100%;
    display: flex;
    /* flex-direction: column; */
    align-items: center;
    justify-content: center;
    background-color: rgb(44 98 98);
}

#table-head{
    text-align: center;
    background-color: midnightblue;
    color: navajowhite;
    font-size: 1.3rem;
}

.item-tab{
    text-align: center;
}

.order-details{
    display: flex;
    align-content: center;
    justify-content: center;
    background-color: #241a08;
}
.date-from-to{
    display: flex;
    margin-bottom: 5px;
    justify-content: space-between;
    width: 100%;
    color :#fff;
}

.date-from{
    margin-right: 10px;

}

.input-container-user{
    display: flex;
    flex-direction: column;
    /* justify-content: space-between; */
    align-items: center;
    width: 100%;
     margin-left: 10px;
    /*margin-bottom: 10px; */
}

.input-container-user label{
    margin-right: 25px;
    color: #fff;
}

.input-user{
    flex-basis: 80%;

}

.input-user select{
    font-size: 16px;
    text-align: center;
    width: max-content;

}

.find-outer{
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.find-inner input{
    width: 5rem;
}

/* .user {

    margin: 10px;
    padding: 10px;
    background-color: #f3f1e4;
} */

.order {
    /* background: #999; */
    padding: 10px;

    margin: 10px;
}

.item-card {
    background: #faf9f4;
    text-align: center;
    padding: 10px;
    margin: 10px;
}
.btn-primary{
    background-color: #f3f1e4;
    border-color: #f3f1e4;
    color: #241a08;
    margin-top: 27px;
}
.item-img img{
    width: 75px;

}
.table-head {
    border: 1px solid #666;
    margin-bottom:5px;
}


        </style>


</head>

<body>

    <?php include('adminNav.html') ?>

    <!-- ********************* -->


    <div class="container">


        <?php


    $from=NULL;
    $to=NULL;
    $user_id=NULL;

    if(isset($_GET['from']))
    {
    
        $from=$_GET['from'];
    }
    if(isset($_GET['to']))
    {
    
        $to=$_GET['to'];
    }
    if(isset($_GET['user_id']))
    {
    
        $user_id=$_GET['user_id'];
    }

$allUsers=getAllUser();

?>
        <div>
            <form action="<?php $_PHP_SELF ?>" method="get" class="myform">
                <div class="date-from-to">
                    <div class="date-from">
                        <label for="" class=" control-label"> From <i class="fa fa-calendar"
                                aria-hidden="true"></i></label>
                        <div class="">
                            <input type="date" name="from" value="<?=$from?>" class="form-control">
                        </div>
                    </div>
                    <div class="date-to">
                        <label for="" class=" control-label"> To <i class="fa fa-calendar"
                                aria-hidden="true"></i></label>
                        <div class="">
                            <input type="date" name="to" value="<?=$to?>" class="form-control">
                        </div>
                    </div>
                    <div class="input-container-user">
                        <label for="" class=" control-label"> users</label>
                        <div class="input-user">
                            <select class="form-control" name="user_id" id="">
                                <option value=""></option>
                                <?php 
                      
                      foreach($allUsers as $user)
                      {
                          
                          $selected='';
                          if($user['user_id']==$user_id){$selected='selected';}

                          echo "<option ".$selected. "  value='".$user['user_id']."'>".$user['username']."</option>";
                        }
                        
                        
                        ?>

                            </select>
                        </div>
                    </div>
                    <div class="find-outer">
                        <input type="submit" value="Find" class="btn btn-primary">
                    </div>

                </div>

            </form>
        </div>

        <div class="container2">

            <div class="row">
                <span id='table-head' class="col-md-6 table-head"> Client </span>
                <span id='table-head' class="text-center col-md-6 table-head">Total Amount</span>
                <?php  
        $users= getUsers($from ,$to ,$user_id );
        foreach ($users as  $user) {
           ?>

                <div id="userid<?=$user['user_id'] ?>" class="col-md-12 user">

                    <div class="row">
                        <span class="text-left col-md-6 item-tab">
                            <i class='fa fa-plus' onclick="toggle('toggel-userid'+<?=$user['user_id'] ?>)"></i>
                            <?=$user['username'] ?></span>
                        <span class="text-center col-md-6"> <?=$user['total']."$" ?></span>

                    </div>
                    <div id="toggel-userid<?=$user['user_id'] ?>" style="display:none" class="row order user-list">
                        <span id='table-head' class=" col-md-6 table-head"> Order Date </span>
                        <span id='table-head' class="text-center col-md-6 table-head"> Amount</span>
                        <?php 
             $orders=getUserOrders($user['user_id'],$from ,$to);
              foreach ($orders as  $order) {
                
              ?>
                        <div id="orderid<?=$order['order_id'] ?>" class=" col-md-12">
                            <div class="row ">

                                <span class="text-left col-md-6">

                                    <i class='fa fa-plus'
                                        onclick="toggle('toggel-orderid'+<?=$order['order_id'] ?>)"></i>
                                    <?=$order['orderDate'] ?>
                                </span>
                                <span class="text-center col-md-6"> <?=$order['total']."$" ?></span>

                            </div>

                            <div class='order-details' id="toggel-orderid<?=$order['order_id'] ?>" style="display:none">

                                <?php 
              $items=getOrderItem($order['order_id']);
              foreach ($items as  $item) {                
              ?>
                                <div class="item-card">
                                    <div>
                                        <div class='item-img'><img src=<?="../images/".$item['pic']."" ?> alt='img'>
                                        </div>
                                        <div class='item-name'><?=$item['name'] ?></div>
                                        <div class='item-price'> <?="price: ".$item['price']."$" ?></div>
                                        <div class='item-quantity'><?="Qty: ".$item['quantity'] ?></div>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <?php
        }
        
        ?>
            </div>
        </div>

    </div>
</body>

</html>



<?php


function getUsers($from=NULL , $to=NULL,$user_id=NULL)
{
   
    global $db;
    $andWhere='';
    if($to && $from)
    {
        $andWhere .= " AND orders.date >= '" . $from . "' AND orders.date <= '" . $to . "'";
    }
     else if($from)
     {
        $andWhere .= " AND orders.date >= '" . $from . "'";
        
     }
     else if($to)
     {
        $andWhere .=  " AND orders.date <= '" . $to . "'";  
     }

     if($user_id)
     {
        $andWhere=" AND  user.user_id= ".$user_id; 
     }

 
    $stm=$db->prepare("SELECT SUM(price*quantity)as total ,username, user.user_id
    from orders ,order_product , product ,user
    where orders.order_id=order_product.order_id AND 
    product.product_id=order_product.product_id 
    and user.user_id=orders.user_id ".$andWhere."
    GROUP by username");


    $stm->execute();
    $rows=$stm->fetchAll();
    return $rows; 
}


function getUserOrders($user_id,$from=NULL , $to=NULL)
{
    global $db;
    $andWhere='';
    if($to && $from)
    {
        $andWhere .= " AND orders.date >= '" . $from . "' AND orders.date <= '" . $to . "'";
    }
     else if($from)
     {
        $andWhere .= " AND orders.date >= '" . $from . "'";
        
     }
     else if($to)
     {
        $andWhere .=  " AND orders.date <= '" . $to . "'";  
     }
  
    $stm=$db->prepare("SELECT SUM(price*quantity)as total,date as orderDate , orders.order_id
    from orders ,order_product ,product 
    where orders.order_id=order_product.order_id AND 
    product.product_id=order_product.product_id and orders.user_id = $user_id".$andWhere."
    GROUP by orders.order_id ");


    $stm->execute();
    $rows=$stm->fetchAll();
    return $rows; 
}


function getOrderItem($order_id)
{
    global $db;
   
    $stm=$db->prepare("SELECT
                            quantity,
                            pic,name,price,
                            orders.order_id
                        FROM
                            orders,
                            product,
                            order_product
                        WHERE
                            orders.order_id = order_product.order_id 
                            AND product.product_id = order_product.product_id
                            AND orders.order_id = $order_id");
                        
  
   $stm->execute();
    $rows=$stm->fetchAll();
    return $rows; 
}
function getAllUser()
{
    global $db;
   
    $stm=$db->prepare("SELECT
                           username,
                           user_id
                        FROM
                           user");
                     
    $stm->execute();
    $rows=$stm->fetchAll();
    return $rows; 
}


?>
<script>
function toggle(id) {

    $("#" + id).toggle();
}
</script>