<?php include("../db.php"); ?>
<link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/myorders.css">
  
<?php
session_start();
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['loggedin'])) {
  header('Location: ../login.php');
}
if ($_SESSION['is_admin']==1){
  die ("Access Denied");
}
?>

<?php


$from = NULL;
$to = NULL;
$user_id = NULL;
global $res;
global $stack;
$stack = array();

if (isset($_GET['from'])) {

  $from = $_GET['from'];
}

if (isset($_GET['to'])) {

  $to = $_GET['to'];
}

if (isset($_GET['user_id'])) {

  $from = $_GET['user_id'];
}



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


 require_once './userNav.html';
?>



<!-- <div class="nav-bar">
        <div class="left-nav">
            <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <span>|</span>
            <a href="myorders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Orders</a>
        </div>

        <div class="right-nav">
                <img class="user-pic" src=<?php echo $_SESSION['profile_pic']?>>
                <a><?php echo $_SESSION['name']?></a>
            <div class=log-out>
                <div>|</div>
                <a id="logOut" href="../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
            </div>
        </div>
        <i class="fa fa-bars" aria-hidden="true"></i>

    </div> -->
    <!-- <link rel="stylesheet" href="../css/adminNav.css" /> -->


<!-- <div class="container"> -->

  <!-- Date Start -->
  <div>
  <!-- <div class="row"> -->
    <!-- <div class="col-md-4"></div>
    <br>
    <div class="col-md-4"> -->
      <form action="<?php $_PHP_SELF ?>" method="GET" class="myform">
        <!-- <input type="date" name="from" value="<?= $from ?>" class="form-control"> from
        <input type="date" name="to" value="<?= $to ?>" class="form-control">for <br>
        <input type="submit" value="Find" class="btn btn-dark"><br> -->
        <div class="date-from-to">
          <div class="date-from">
                      <label for="" class=" control-label"> From <i class="fa fa-calendar" aria-hidden="true"></i></label>
                      <div class="">
                          <input type="date" name="from" value="<?=$from?>" class="form-control">
                      </div>
          </div>
          <div class="date-to">
                  <label for="" class=" control-label"> To <i class="fa fa-calendar" aria-hidden="true"></i></label>
                  <div class="">
                      <input type="date" name="to" value="<?=$to?>" class="form-control">
                  </div>
          </div>
          <div class="find-outer" style="margin-top: 65px;">
                      <input type="submit" value="Find" class="btn btn-primary">
          </div>
        </div>
      </form>
    <!-- </div> -->
  </div>
  <!-- Date End -->


  <!-- Table Start -->
  <br>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Order Date</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php

          // $id= $_SESSION['id'];
          
          // $query = "SELECT date as orderDate, status, SUM(price*quantity)as total, orders.order_id as order_id, order_product.product_id as product_item_id, product.pic as pic_path
          //     from orders ,order_product ,product 
          //     where orders.order_id=order_product.order_id AND 
          //     product.product_id=order_product.product_id and orders.user_id =1
          //     GROUP by orders.order_id ";


          $q2 = "SELECT SUM(price*quantity)as total, status, date as orderDate , orders.order_id
          from orders ,order_product ,product 
          where orders.order_id=order_product.order_id AND 
          product.product_id=order_product.product_id and orders.user_id = 1".$andWhere."
          GROUP by orders.order_id ";


        

          $result_tasks = mysqli_query($conn, $q2);
          // var_dump($result_tasks);               
          // die();

          // $id= $_SESSION['id'];



          while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <?php
            $res = $row;
            $q3 = "SELECT
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
          AND orders.order_id = {$row['order_id']}";
         


            ?>
            <tr>
              <td>
                <i class='fa fa-plus' aria-expanded="false" onclick="toggle('toggel-userid'+<?= $res['order_id'] ?>)"></i>
                <?php echo $row['orderDate']; ?>
              </td>
              <td><?php echo $row['status']; ?></td>
              <td><?php echo $row['total']; ?></td>
              <td>

                <a href="delete_order.php?id=<?php echo $row['order_id'] ?>" class="btn btn-danger <?php if ($row['status'] != 'processing') {
                                                                                                        echo 'd-none';
                                                                                                      } ?>">
                  <i class="far fa-trash-alt"></i>
                </a>

              </td>
            </tr>

            <tr></tr>
              <td colspan="4">
                <div class="collapse " id="toggel-userid<?= $res['order_id'] ?>">
                  <!-- <div class="card card-body" id="toggel-orderid<?= $row['order_id'] ?>"> -->
                    <div class='order-details'>
                    <?php
                     $result_items = mysqli_query($conn, $q3);
                     
                     foreach ($result_items as $itm) {
                       
                       ?>
                      <div class="item-card">
                       <div class='item-img'><img src="../images/<?=$itm['pic'] ?>" alt='img'></div>
                       <div class='item-name'><?=$itm['name'] ?></div>
                       <div class='item-price'> <?="price: ".$itm['price']."  L.E" ?></div>
                       <div class='item-quantity'><?="Qty: ".$itm['quantity'] ?></div>
                     </div>
                    <!-- <div id="orderid<?= $row['product_id'] ?>" class="item">
                      <div>
                        <img src="<?php echo $itm['pic']; ?>" alt="" width=50px>
                        <li><?php echo $itm['quantity']; ?></li>
                        
                      </div>
                      
                    </div> -->

                    <?php }?>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
    <!-- Table End -->
  </div>



<!-- Container End -->

<!-- Shoing Order Details -->


<script>
  function toggle(id) {

    $("#" + id).toggle();
  }
</script>

<?php
//  include('../includes/footer.php'); 
 ?>