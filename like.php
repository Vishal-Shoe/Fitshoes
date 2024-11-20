<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Likes</title>
    <!-- <link rel="stylesheet" href="like.css"> -->

<style>
    .heading {
    background-color: #283c53;
  padding: 5px 10px;
  text-align: center;
    font-size: 20px;
    color:rgb(249, 160, 8);
  }
  .heading span{
    color: #fff;
  }
  
 /* CSS for minimizing the size of shoe images */
img {
    max-width: 200px; /* Set maximum width for images */
    height: auto; /* Maintain aspect ratio */
}


/* Additional CSS for liked item boxes */
.liked-item {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    overflow: hidden;
}
.liked-item img {
    float: left;
    margin-right: 10px;
    width: 100px;
    height: auto;
}
.liked-item-details {
    overflow: hidden;
}
.liked-item-details h3 {
    margin-top: 0;
    margin-bottom: 5px;
}
.liked-item-details p {
    margin: 0;
}
.liked-item-actions {
    overflow: hidden;
}
.liked-item-actions button {
    float:left;
}
.-item-actions button hover{
    color: orange;
}
.heading{
    color: #d1650c;
    margin-right: 470px;
    font-size: x-large;
    padding-left: 470px;
  }
  .heading span{
    color: #fff;
  }
  nav a{
    color : #ffff;
    
  text-decoration: none;
  font-size: x-large;
  }
  nav{
      text-align: left;
      background-color: #283c53;


  }
  </style>


</head>
<body>
<header>
    <nav class="navbar">
     

<div class="heading">
<b><h1>Shoe <span>Portal</span></h1></b>
<!-- <a href="cart.php">Cart</a>
<a href="like.php">Like</a> -->
</div>
</nav>

  </header>

  
  <nav>
      <a href="index.php">HOME</a>

</nav>

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

// Check if the 'like' session variable is set and is an array
if(isset($_SESSION['like']) && is_array($_SESSION['like'])) {
    // Loop through each item in the 'like' session
    foreach($_SESSION['like'] as $key => $item) {
        // Check if $item is an array
        if(is_array($item)) {
            $product_id = $item['product_id'];
            $category = $item['category'];

            // Fetch the product details from the database based on the product ID and category
            $sql = "";
            if($category == 'men') {
                $sql = "SELECT * FROM Shoes WHERE id = $product_id";
            } elseif($category == 'women') {
                $sql = "SELECT * FROM womenshoes WHERE id = $product_id";
            } elseif($category == 'kids') {
                $sql = "SELECT * FROM kidsshoes WHERE id = $product_id";
            }

            $result = $conn->query($sql);

            // Display the product details
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='liked-item'>";
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<div class='liked-item-details'>";
                echo "<h3>" . $row["name"] . "</h3>";
                echo "<p>$" . $row["price"] . "</p>";
                echo "<p>Category: $category</p>";
                echo "</div>";
                echo "<div class='liked-item-actions'>";
                echo "<form action='remove_from_like.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                echo "<input type='hidden' name='category' value='" . $category . "'>";
                echo "<button type='submit' name='remove_from_like'>Remove</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            // Handle if $item is not an array (optional)
            // echo "Invalid item in 'like' session.";
        }
    }
} else {
    echo "Your 'like' list is empty."; // Displayed if the 'like' list is empty
}
?>
</body>
</html>
