

<?php
// Database connection
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "shoeportal";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (mysqli_connect_error()) {
    die("Could not connect to the MySQL database. Error: " . mysqli_connect_error());
}

// Check if a cancel request is made
if (isset($_GET['cancel'])) {
    $id_to_cancel = $_GET['cancel'];
    // Delete the order from the database
    $delete_sql = "DELETE FROM checkout WHERE id = $id_to_cancel";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Order canceled successfully.";
        // Redirect to refresh the page and remove the canceled order from the displayed list
        header("Location: myorder.php");
        exit();
    } else {
        echo "Error canceling the order: " . mysqli_error($conn);
    }
}

// Retrieve orders from the database
$sql = "SELECT * FROM checkout";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
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
 
    
<body>

<nav>
    <div class="heading">
        <b><h1>Shoe <span>Portal</span></h1></b>
    </div>
      <a href="index.php">HOME</a>
</nav>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #283c53;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color:#283c53;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #fff;
        }

        tr:hover {
            background-color: #f4f4f4;
        }

        .cancel-btn {
            background-color: #f26c4f;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background-color: #e65a3f;
        }

        .cancel-btn:active {
            background-color: #d25635;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Orders</h2>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['productname'] . "</td>";
                    echo "<td>" . $row['productprice'] . "</td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td><a class='cancel-btn' href='myorder.php?cancel=" . $row['id'] . "'>Cancel</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
