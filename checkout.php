<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the keys exist in the $_POST array before accessing them
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : "";
} else {
    $product_name = "";
    $product_price = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="container">
        <form action="#" method="post"> <!-- Change the action to your desired action -->
        <?php
            // Database connection
            $hostName = "localhost";
            $dbUser = "root";
            $dbPassword = "";
            $dbName = "shoeportal";
            $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

            if (mysqli_connect_error()) {
            echo "Could not connect to the mysql database. Error: " . mysqli_connect_error();
            }
            
            // Function to validate if a string contains only letters
            function validateCharacterOnly($str) {
                return preg_match('/^[A-Za-z\s]+$/', $str);
            }

            // Handle form submission
            if (isset($_POST['submit'])) {
                $productname = $_POST["productname"];
                $productprice = $_POST["productprice"];
                $fullname = $_POST["fullname"];
                $email = $_POST["email"];
                $address = $_POST["address"];
                $city = $_POST["city"];
                $state = $_POST["state"];
                $zipcode = $_POST["zipcode"];

                // Validate Full Name, City, and State
                if (!validateCharacterOnly($fullname)) {
                    echo "Full Name should contain only letters.<br>";
                }
                if (!validateCharacterOnly($city)) {
                    echo "City should contain only letters.<br>";
                }
                if (!validateCharacterOnly($state)) {
                    echo "State should contain only letters.<br>";
                }

                // Proceed with database insertion if all validations pass
                if (validateCharacterOnly($fullname) && validateCharacterOnly($city) && validateCharacterOnly($state)) {
                    $sql="INSERT INTO checkout ( `productname`, `productprice`, `fullname`, `email`, `address`, `city`, `state`, `zipcode`) VALUES ( '$productname', '$productprice', '$fullname', '$email', '$address', '$city', '$state', '$zipcode')";

                    if ($conn->query($sql) === true) {
                        echo "successful!";
                        // Redirect to another page after successful payment
                        header("Location: payment.php");
                        exit(); // Ensure script stops executing after redirection
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Close connection
                $conn->close();
            }
          
    ?>
            <div class="row">
                <div class="col">
                    <h3 class="title">Billing Address</h3>
                    <div class="inputBox">
                        <span>Product Name :</span>
                        <input type="text" name="productname" value="<?php echo $product_name; ?>">
                    </div>
                    <div class="inputBox">
                        <span>Product Price :</span>
                        <input type="text" name="productprice" value="<?php echo $product_price; ?>">
                    </div>
                    <div class="inputBox">
                        <span>Full Name :</span>
                        <input type="text" name="fullname" >
                    </div>
                    <div class="inputBox">
                        <span>Email :</span>
                        <input type="email" name="email">
                    </div>
                    <div class="inputBox">
                        <span>Address :</span>
                        <input type="text" name="address">
                    </div>
                    <div class="inputBox">
                        <span>City :</span>
                        <input type="text" name="city">
                    </div>
                    <div class="flex">
                        <div class="inputBox">
                            <span>State :</span>
                            <input type="text" name="state">
                        </div>
                        <div class="inputBox">
                            <span>Zip Code :</span>
                            <input type="text" name="zipcode" pattern="[0-9]{6}" placeholder="000000">
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" value="Proceed to Pay" name="submit" class="submit-btn">
        </form>
    </div>
</body>
</html>
