<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>

    <style>
        /* Header styles */
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
        .heading a{
            font-size: larger;
            padding-right: 1150px;
            color: #fff;
        }
  
        /* CSS for minimizing the size of shoe images */
        img {
            max-width: 200px; /* Set maximum width for images */
            height: auto; /* Maintain aspect ratio */
        }

        /* Additional CSS for cart item boxes */
        .cart-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 10px;
            overflow: hidden;
        }
        .cart-item img {
            float: left;
            margin-right: 10px;
            width: 100px;
            height: auto;
        }
        .cart-item-details {
            overflow: hidden;
        }
        .cart-item-details h3 {
            margin-top: 0;
            margin-bottom: 5px;
        }
        .cart-item-details p {
            margin: 0;
            color: #888;
        }
        .cart-item-actions {
            overflow: hidden;
        }
        .cart-item-actions button {
            float: left;
            border-radius: 40px;
        }
        .cart-item-actions button:hover {
            color: orange;
        }
        .cart {
            align-items: center;
        }
    </style>
</head>
<body>

<nav>
    <div class="heading">
        <b><h1>Shoe <span>Portal</span></h1></b> 
        <a href="index.php">HOME</a>
    </div>
</nav>
<section class="cart"> 
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

// Check if the 'cart' session variable is set and is an array
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    // Loop through each item in the cart
    foreach($_SESSION['cart'] as $key => $item) {
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
                echo "<div class='cart-item'>";
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<div class='cart-item-details'>";
                echo "<h3>" . $row["name"] . "</h3>";
                echo "<p>₹" . $row["price"] . "</p>";
                echo "<p>Category: $category</p>";
                echo "</div>";
                echo "<label for='shoe_size'>Select Size:</label>";
                echo "<select name='shoe_size' id='shoe_size'>";
                echo "<option value='6'>6</option>"; // Example options, you can modify accordingly
                echo "<option value='7'>7</option>";
                echo "<option value='8'>8</option>";
                echo "<option value='9'>9</option>";
                echo "<option value='10'>10</option>";
                // Add more options as needed
                echo "</select>";
                echo "<div class='cart-item-actions'>";
                echo "<form action='remove_from_cart.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                echo "<input type='hidden' name='category' value='" . $category . "'>";
                echo "<button type='submit' name='remove_from_cart'>Remove</button>";
                echo "</form>";
                echo "<form action='checkout.php' method='post'>"; // Form for "Buy Now" button
                echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                echo "<input type='hidden' name='category' value='" . $category . "'>";
                echo "<input type='hidden' name='product_name' value='" . $row["name"] . "'>"; // Add product name as hidden input
                echo "<input type='hidden' name='product_price' value='" . $row["price"] . "'>"; // Add product price as hidden input
                echo "<button type='submit' name='buy_now'>Buy Now</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            // Handle if $item is not an array (optional)
            // echo "Invalid item in cart.";
        }
    }
} else {
    echo "Your cart is empty."; // Displayed if the cart is empty
}
?>
</section>

</body>
</html>
