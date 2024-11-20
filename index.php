<?php
session_start(); // Start the session

// Include database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shoeportal";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a product to the cart if the 'add_to_cart' parameter is set in the URL
if(isset($_GET['add_to_cart']) && isset($_GET['product_id']) && isset($_GET['category'])) {
  $product_id = $_GET['product_id'];
  $category = $_GET['category'];
  
  // Here, you can add the product to the cart based on the product ID and category
  // For example, using sessions:
  $_SESSION['cart'][] = array('product_id' => $product_id, 'category' => $category);
  
  // Redirect the user back to the index page
  header("Location: index.php");
  exit();
}


// Handle adding a product to the like list if the 'like' parameter is set in the URL
if(isset($_GET['like']) && isset($_GET['product_id']) && isset($_GET['category'])) {
    $product_id = $_GET['product_id'];
    $category = $_GET['category'];
    
    // Add the product to the 'like' list based on the product ID and category

    $_SESSION['like'][] = array('product_id' => $product_id, 'category' => $category);
    
    // Redirect the user to like.php
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoe Portal</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="">
  <style>
    .footer {
  bottom: 0;
  width: 100%;
  background-color:  #283c53;
  color: #fff;
  padding: 20px 0;
  text-align: center;
}

.footer-section {
  display: inline-block;
  margin: 0 20px;
}

.footer-section h3 {
  margin-bottom: 10px;
}

.footer-section ul {
  list-style-type: none;
  padding-left: 10px;
  margin: 0;
}

.footer-section ul li {
  margin-bottom: 5px;
}

.social-media-icons {
  font-size: 20px;
}
</style>
</head>
<body>
  <header>
    <nav class="navbar">
     
<div class="profile-dropdown">
  <div onclick="toggle()" class="profile-dropdown-btn">
    <div class="profile-img">
      <i class="fa-solid fa-circle"></i>
    </div>

    <span>
      <b>My Profile</b>
    </span>
  </div>

  <ul class="profile-dropdown-list">
    <li class="profile-dropdown-list-item">
      <a href="myorder.php">
    
       My Order 
      </a>
    </li>

    <li class="profile-dropdown-list-item">
      <a href="contactus.php">
        
        Contact Us 
      </a>
    </li>

    <li class="profile-dropdown-list-item">
      <a href="4logout.php">
        
        Log out
      </a>
    </li>

  </ul>



</div>
<div class="heading">
<b><h1>Shoe <span>Portal</span></h1></b>

</nav>
</div>

  <div class="user">

</div>

  </header>

  <nav>
      <a href="#men-section">Men</a>
      <a href="#women-section">Women</a>
      <a href="#kids-section">Kids</a>
      <a href="cart.php">Cart</a>
      <a href="like.php">Like</a>
</nav>
  
<section class="advertise">
      <div class="para">
      <p><br><br>Created for the hardwood but taken to the streets, this '80s basketball <br> icon returns with classic details and throwback hoops flair. <br> The synthetic leather overlays help the Nike Dunk <br>channel vintage style while its padded, <br> low-cut collar lets you take your <br> game anywhere—in comfort.</p> <br>

      <h2 class="nike"><span>Nike</span><span class="span2">Dunk</span></h2>
    </div>
    <div class="shoe">
      <img src="img/shoe1.png" height="800px">
    </div>
    </section>


  <section id="men-section" class="shoe-section">
   <div class="men-collection">
    <b><h2>Men's <span>Collection</span></h2></b><br><br>
    </div>
    <div class="shoe-container" id="men-shoe-container">
      <?php
        // Fetch data from the database for men's shoes
        $sql = "SELECT * FROM Shoes";
        $result = $conn->query($sql);

        // Display shoe cards for men's shoes
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='shoe-card'>";
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<h3>" . $row["name"] . "</h3>";
                echo "<p>₹" . $row["price"] . "</p>";
                echo "<a href='index.php?add_to_cart=true&product_id=" . $row["id"] . "&category=men' class='cart-btn'>Add to Cart</a>";
                echo "<a href='index.php?like=true&product_id=" . $row["id"] . "&category=men' class='like-btn'>Like</a>"; // Updated like button
                echo "</div>";
            }
        } else {
            echo "No shoes available for men.";
        }
      ?>
    </div>
  </section>

  <section id="women-section" class="shoe-section">
  <div class="men-collection">
    <b><h2>Women's <span>Collection</span></h2></b><br><br>
    </div>
    <div class="shoe-container" id="women-shoe-container">
      <?php
        // Fetch data from the database for women's shoes
        $sql = "SELECT * FROM womenshoes";
        $result = $conn->query($sql);

        // Display shoe cards for women's shoes
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='shoe-card'>";
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<h3>" . $row["name"] . "</h3>";
                echo "<p>₹" . $row["price"] . "</p>";
                echo "<a href='index.php?add_to_cart=true&product_id=" . $row["id"] . "&category=women' class='cart-btn'>Add to Cart</a>";
                echo "<a href='index.php?like=true&product_id=" . $row["id"] . "&category=women' class='like-btn'>Like</a>"; // Updated like button
                echo "</div>";
            }
        } else {
            echo "No shoes available for women.";
        }
      ?>
    </div>
  </section>

  <section id="kids-section" class="shoe-section">
  <div class="men-collection">
    <b><h2>Kid's <span>Collection</span></h2></b><br><br>
    </div>
    <div class="shoe-container" id="kids-shoe-container">
      <?php
        // Fetch data from the database for kids' shoes
        $sql = "SELECT * FROM kidsshoes";
        $result = $conn->query($sql);

        // Display shoe cards for kids' shoes
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='shoe-card'>";
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<h3>" . $row["name"] . "</h3>";
                echo "<p>₹" . $row["price"] . "</p>";
                echo "<a href='index.php?add_to_cart=true&product_id=" . $row["id"] . "&category=kids' class='cart-btn'>Add to Cart</a>";
                echo "<a href='index.php?like=true&product_id=" . $row["id"] . "&category=kids' class='like-btn'>Like</a>"; // Updated like button
                echo "</div>";
            }
        } else {
            echo "No shoes available for kids.";
        }
      ?>
    </div>
  </section>

    <footer class="footer" id="contact">                                                         <!-- FOOTER -->
        <div class="footer-section">
            <h3><i class="fa-solid fa-location-dot"></i> Address</h3>
            <ul>                                                                       
                <li>2nd Floor, New Excelsior Building,</li>
                <li>HVPM College Road</li>
                <li>Amravati- 444601</li>
                <li>India</li>
            </ul>
        </div>

        <div class="footer-section">
            <h3><i class="fa-solid fa-at"></i> Email</h3>
            <ul>
                <li><i class="fa-solid fa-envelope"></i> aryandore@gmail.com</li>
                <li><i class="fa-solid fa-envelope"></i> sanketpachade05@gmail.com</li>
                <li><i class="fa-solid fa-phone"></i> 8177910231,9307916576</li>
                <li><i class="fa-solid fa-phone"></i> Toll free number-1800-000-0000</li>
            </ul>
        </div>

    </footer>

  <script src="script.js"></script>
</body>
</html>
