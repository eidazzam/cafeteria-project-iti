<?php
    session_start(); 
    if(empty($_SESSION['loggedin'])){
        header('Location: ../login.php');
    }
    if($_SESSION['is_admin']==1){
        die ("Access Denied");
    }

    $_session['shopping_cart'] = array();

    $db=require('../database/dbConnect.php'); 
    $data=new Database();
    $dbcon= $data->connect();
    $selectAllProduct=$data->select("product");

    $previous_week = strtotime("-1 week +1 day");
    // var_dump($previous_week);
    $start_week = strtotime("last sunday midnight",$previous_week);
    $end_week = strtotime("next saturday",$start_week);

    $start_week = date("Y-m-d",$start_week);
    $end_week = date('Y-m-d H:i:s');
    // var_dump($start_week);
    // var_dump($end_week);
    
    
    $query="SELECT Distinct `product`.* FROM `orders`,`product`,`order_product` WHERE product.product_id = order_product.product_id AND order_product.order_id = orders.order_id AND orders.date BETWEEN '{$start_week}' AND '{$end_week}' ORDER BY orders.date desc ";
    $result=$dbcon->query($query);


      if(isset($_POST["add_to_cart"]))  
       {  
        if(isset($_SESSION["shopping_cart"]))  
        {  
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
            if(!in_array($_GET["id"], $item_array_id))  
            {  
                    $count = count($_SESSION["shopping_cart"]);  
                    $item_array = array(  
                        'item_id'               =>     $_GET["id"],  
                        'item_name'               =>     $_POST["hidden_name"],  
                        'item_price'          =>     $_POST["hidden_price"],  
                        'item_quantity'          =>     $_POST["quantity"]  
                    );  
                    $_SESSION["shopping_cart"][$count] = $item_array;  
            }  
            else  
            {  
                    echo '<script>alert("Item Already Added")</script>';  
                    echo '<script>window.location="index.php"</script>';  
            }  
        }  
        else  
        {  
            $item_array = array(  
                    'item_id'               =>     $_GET["id"],  
                    'item_name'               =>     $_POST["hidden_name"],  
                    'item_price'          =>     $_POST["hidden_price"],  
                    'item_quantity'          =>     $_POST["quantity"]  
            );  
            $_SESSION["shopping_cart"][0] = $item_array;  
        }  
 } 
 require_once './userNav.html';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete responsive coffee shop website design</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php
    
    // require_once './userNav.html';
    
    ?>
    
<!-- header section starts  -->

<!-- <header class="header">

    <a href="#" class="logo">
        <img src="images/logo.png" alt="">
    </a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#menu">menu</a>
        <a href="#products">products</a>
        <a href="#review">review</a>
        <a href="#contact">contact</a>
        <a href="#blogs">blogs</a>
    </nav>

    <div class="icons">
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>

    <div class="search-form">
        <input type="search" id="search-box" placeholder="search here...">
        <label for="search-box" class="fas fa-search"></label>
    </div>

    <div class="cart-items-container">
        <div class="cart-item">
            <span class="fas fa-times"></span>
            <img src="../images/cart-item-1.png" alt="">
            <div class="content">
                <h3>cart item 01</h3>
                <div class="price">$15.99/-</div>
            </div>
        </div>
        <div class="cart-item">
            <span class="fas fa-times"></span>
            <img src="../images/cart-item-2.png" alt="">
            <div class="content">
                <h3>cart item 02</h3>
                <div class="price">$15.99/-</div>
            </div>
        </div>
        <div class="cart-item">
            <span class="fas fa-times"></span>
            <img src="../images/cart-item-3.png" alt="">
            <div class="content">
                <h3>cart item 03</h3>
                <div class="price">$15.99/-</div>
            </div>
        </div>
        <div class="cart-item">
            <span class="fas fa-times"></span>
            <img src="../images/cart-item-4.png" alt="">
            <div class="content">
                <h3>cart item 04</h3>
                <div class="price">$15.99/-</div>
            </div>
        </div>
        <a href="#" class="btn">checkout now</a>
    </div>

</header> -->

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3>fresh coffee in the morning</h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Placeat labore, sint cupiditate distinctio tempora reiciendis.</p>
        <a href="#" class="btn">get yours now</a>
    </div>

</section>

<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

    <h1 class="heading"> <span>about</span> us </h1>

    <div class="row">

        <div class="image">
            <img src="../images/about-img.jpeg" alt="">
        </div>

        <div class="content">
            <h3>what makes our coffee special?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus qui ea ullam, enim tempora ipsum fuga alias quae ratione a officiis id temporibus autem? Quod nemo facilis cupiditate. Ex, vel?</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit amet enim quod veritatis, nihil voluptas culpa! Neque consectetur obcaecati sapiente?</p>
            <a href="#" class="btn">learn more</a>
        </div>

    </div>

</section>

<!-- about section ends -->

<!-- menu section starts  -->

<section class="menu" id="menu">

    <h1 class="heading">Latest <span>orders</span> </h1>
    <div class="box-container">
    <?php while($row=$result->fetch_array()){ ?>
        
        <div class="box">
            <img src="../images/<?php echo $row['pic'];?>" alt="">
            <h3><?php echo $row['name'];?></h3>
            <div class="price"><?php echo $row['price'];?> <span><?php echo ((int) $row['price'])+((int) $row['price'])*20/100;?></span></div>
            <!-- <a href="addCard.php" class="btn" onclick="">add to cart</a> -->
            <?php
               echo "<a  class='btn' onclick='addcard( {$row['product_id']})'>add to cart</a>"
            ?>
            
        </div>

        <?php } ?>
    </div>


    <h1 class="heading"> our <span>menu</span> </h1>

    <div class="box-container">
        <?php
            while($row=$selectAllProduct->fetch_assoc()){
        ?>
        <div class="box">
            <img src="../images/<?php echo $row['pic'];?>" alt="">
            <h3><?php echo $row['name'];?></h3>
            <div class="price"><?php echo $row['price'];?> <span><?php echo ((int) $row['price'])+((int) $row['price'])*20/100;?></span></div>
            <!-- <a href="addCard.php" class="btn" onclick="">add to cart</a> -->
            <?php
               echo "<a  class='btn' onclick='addcard( {$row['product_id']})'>add to cart</a>"
            ?>
            
        </div>
        <?php } ?>
        
    </div>
    <br/>
    <form action="../cartProcess/addCard.php?id=1" method="post">
        <input type="hidden" name="cardItems" id='cardItems' value="">    
        <center><input type="submit" value="Check your card" class="btn" style="margin-top:10px"></center>
        
    </form>
</section>

<!-- menu section ends -->



<!-- footer section starts  -->

<section class="footer">

    <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-linkedin"></a>
        <a href="#" class="fab fa-pinterest"></a>
    </div>

    <div class="links">
        <a href="#">home</a>
        <a href="#">about</a>
        <a href="#">menu</a>
        <a href="#">products</a>
        <a href="#">review</a>
        <a href="#">contact</a>
        <a href="#">blogs</a>
    </div>

    <div class="credit">created by <span>iti team </span> | all rights reserved</div>

</section>

<!-- footer section ends -->

















<!-- custom js file link  -->
<script src="../js/script.js"></script>

</body>
</html>