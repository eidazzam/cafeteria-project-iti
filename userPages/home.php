<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.php');
}
if ($_SESSION['is_admin']==1){
    die ("Access Denied");
}
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    

    <title>Home</title>
</head>

<body>
    <!-- TO DO getting all user info  -->
    <div class="nav-bar">
        <div class="left-nav">
            <a href="#"><i class="fa fa-fw fa-home"></i> Home</a>
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

    </div>

    <div class="main">
            <form  class="order-data" id="form" action="insertOrder.php" method="post">
                <div  class="order">
                    <p>My Order</p>
                    <hr>
                    <div class='order-details'>Order Details :</div>
                    <div id="list"></div>
                </div>
                <hr>
                <div class="notes">
                    <label id="notes" for="notes">Notes:</label>
                    <textarea name="notes" id="notes" rows="4" cols="50">
                    </textarea>
                </div>
                <div class="room">
                    <label for="room">Room</label>
                    <select name="room" id="room">
                        <option value="1001">1001</option>
                        <option value="1002">1002</option>
                        <option value="1003">1003</option>
                    </select>
                </div>
                <div class='footer'>
                <div id="orderFooter" class="orderFooter">
                <hr>
                    <span id=total>Total: 0 L.E</span><br>
                    <hr>                    
                </div>
                <button class="confirm" type="submit">Confirm</button>
                </div>                
            </form>
        <div class="product-list-addUser">
            <input type="text" name="search" id="search">
            <?php
            include '../config.php';
            //latest order
            $user_id=$_SESSION['id'];

            $query="SELECT p.name , o.quantity ,p.pic FROM order_product o,product p WHERE p.product_id=o.product_id AND order_id=(SELECT order_id FROM orders WHERE user_id=$user_id ORDER by date DESC limit 1 )";
            $stmt = $db->query($query);
            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            echo "<div class='latest-order'>
            <div class='latestOrder-title'>Latest Order</div>
            <div class='all-items'>";

            while ($ele = $stmt->fetch()) {
                echo ("<div class='order-item'>
                <img class='item-img' src={$ele['pic']}  />
                <div>{$ele['name']}</div>
                <div>Qty: {$ele['quantity']}</div>
            </div>");
            } 
            echo "</div></div>";

            // show all products
            $query = "SELECT product_id,name,price,pic FROM product";
            $stmt = $db->query($query);

            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            echo "<div class='products-list'><div class='produts-list-title'>Available Products</div>";
            echo "<div class='search-bar'><input type='text' placeholder='find product' name='search' id='search'></div>";
            echo "<div class='items-list'>";
            while ($ele = $stmt->fetch()) {
                echo ("<div class=item>
                <img class='item-img product'  data-price={$ele['price']} data-name={$ele['name']} data-id={$ele['product_id']} src={$ele['pic']}  />
                <div>{$ele['name']} </div>
                <div>{$ele['price']} L.E</div>

            </div>");
            }
            echo "</div>";
            echo "</div>";
            $db = null;
            ?>
        </div>
    </div>
    
    <div class="footer">
        <p>Footer</p>
    </div>


    <script src="../js/home.js"></script>
</body>

</html>
