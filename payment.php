<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Page</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        margin-top: 0;
        font-size: 24px;
        color: #333;
    }
    .payment-methods {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 20px;
    }
    .payment-method {
        flex-basis: calc(50% - 10px);
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: box-shadow 0.3s;
    }
    .payment-method:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .payment-method h3 {
        margin-top: 0;
        font-size: 20px;
        color: #333;
    }
    .payment-method p {
        color: #666;
    }
    .payment-details {
        display: none;
        margin-top: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }
    .payment-details.show {
        display: block;
    }
    .pay-button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
    .pay-button:hover {
        background-color: #45a049;
    }
</style>
<script>
    function togglePaymentDetails(paymentId) {
        var paymentDetails = document.getElementById(paymentId + '-details');
        var allDetails = document.querySelectorAll('.payment-details');
        allDetails.forEach(function(element) {
            element.classList.remove('show');
        });
        paymentDetails.classList.add('show');
    }
</script>
</head>
<body>

<div class="container">
    <h2>Select Payment Method</h2>
    <div class="payment-methods">
        <div class="payment-method" onclick="togglePaymentDetails('card')">
            <h3>Credit/Debit Card</h3>
            <p>Pay securely online with your credit/debit card.</p>
        </div>
        <div class="payment-method" onclick="togglePaymentDetails('cash-on-delivery')">
            <h3>Cash on Delivery</h3>
            <p>Pay with cash when your order is delivered.</p>
        </div>
    </div>
    <div id="card-details" class="payment-details">
        <h3>Card Payment Details</h3>
        <form action="payment.php" method="post">
            <label for="cardnumber">Card Number:</label>
            <input type="text" id="cardnumber" name="cardnumber" pattern="[0-9]{12}" placeholder="000000000000"><br><br>
            <label for="expirydate">Expiry Date:</label>
            <input type="date" id="datepicker" name="expirydate"><br><br>
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" pattern="[0-9]{3}" placeholder="000"><br><br>
            <a href="myorder.php"></a>
            <button class="pay-button" type="submit" name="submit">PLACE ORDER</button>
            
        </form>
    </div>

    <div id="cash-on-delivery-details" class="payment-details">
        <h3>Cash on Delivery Details</h3>
        <!-- Add cash on delivery details inputs here -->
        <!-- <button class="pay-button">PLACE ORDER</button> -->
        <a href="myorder.php" >
          <button type="button" class="btn-buy">PLACE ORDER</button>
        </a>
    </div>
</div>

<?php
// Database connection
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "payment";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (mysqli_connect_error()) {
  echo "Could not connect to the mysql database. Error: " . mysqli_connect_error();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $cardnumber = $_POST["cardnumber"];
    $expirydate = $_POST["expirydate"];
    $cvv = $_POST["cvv"];

    $sql="INSERT INTO card (`cardnumber`, `expirydate`, `cvv`) VALUES ('$cardnumber', '$expirydate', '$cvv')";

    if ($conn->query($sql) === true) {
        echo "Payment successful!";
        // Redirect to index.php after successful payment
        header("Location: myorder.php");
        exit; // Ensure script stops executing after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>




</body>
</html>
