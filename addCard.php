<?php
  session_start(); 
  require('./database/dbConnect.php'); 
  $data=new Database();
  $data->connect();
  if(isset($_REQUEST['cardItems'] )){
    $cards=$_REQUEST['cardItems'];
  }
  if(isset($_GET['cardItems'])){
    $cards=$_GET['cardItems'];
  }
  
  
  $cards=explode(" ",$cards);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="css/card.css" />

    <title>Document</title>
  </head>
  <body>
    <div class="card">
      <div class="row">
        <div class="col-md-8 cart">
          <div class="title">
            <div class="row">
              <div class="col">
                <h4><b>Shopping Cart</b></h4>
              </div>
              <div class="col align-self-center text-right text-muted">
                3 items
              </div>
            </div>
          </div>
          <?php 
            $collection=implode(",",$cards);
            // var_dump($collection);
           
              $sum=0;
              $count=0;
              $items=$data->select("product","*","product_id in (".substr($collection,0,-1) .")");
              while($item=$items->fetch_array()){
              $sum+=$item['price'];
              $count++;
          ?>
          <div class="row border-top border-bottom">
            <div class="row main align-items-center">
              <div class="col-2">
                <img class="img-fluid" src="images/<?php echo $item['pic']?>" />
              </div>
              <div class="col">
                <div class="row text-muted"><?php echo $item['name']?></div>
                <!-- <div class="row">Cotton T-shirt</div> -->
              </div>
              <div class="col">
                <a href="#">-</a><a href="#" class="border">1</a><a href="#">+</a>
              </div>
              <div class="col">
                &euro; <?php echo $item['price']?> 
                <a href="./removeFromCard.php?items=<?php echo $collection.'&item='.$item['product_id'] ?>">  <span  class="close">&#10005;</span></a>
              </div>
            </div>
          </div>
          <?php  }?>
          <div class="back-to-shop">
            <a href="#">&leftarrow;</a
            ><span class="text-muted">Back to shop</span>
          </div>
        </div>
        <div class="col-md-4 summary">
          <div>
            <h5><b>Summary</b></h5>
          </div>
          <hr />
          <div class="row">
            <div class="col" style="padding-left: 0">ITEMS <?php echo $count ?></div>
            <div class="col text-right">&euro; <?php echo $sum  ?></div>
          </div>
          <form>
            <p>SHIPPING</p>
            <select>
              <option class="text-muted">Standard-Delivery- &euro;5.00</option>
            </select>
            <p>GIVE CODE</p>
            <input id="code" placeholder="Enter your code" />
          </form>
          <div
            class="row"
            style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding: 2vh 0"
          >
            <div class="col">TOTAL PRICE</div>
            <div class="col text-right">&euro; <?php echo $sum +5 ?></div>
          </div>
          <button class="btn">CHECKOUT</button>
        </div>
      </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </body>
</html>
