<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="contactus.css">
</head>
<body>
    <section>
    
        <div class="section-header">
          <div class="container">
            <h2>Contact Us</h2>
            <p>
"Welcome to our Contact Us page! Whether you have inquiries or just want to say hello, we're here for you. Our team is dedicated to providing prompt and helpful assistance. Feel free to reach out and connect with us. Your questions matter to us, and we're committed to ensuring your needs are met with care and efficiency. Let's start a conversation today!".</p>
          </div>
        </div>
        
        <div class="container">
          <div class="row">
            
            <div class="contact-info">
              <div class="contact-info-item">
                <div class="contact-info-icon">
                  <i class="fas fa-home"></i>
                </div>
                
                <div class="contact-info-content">
                  <h4>Address</h4>
                  <p>2nd Floor, New Excelsior Building,
HVPM College Road
Amravati- 444601
India</p>
                </div>
              </div>
              
              <div class="contact-info-item">
                <div class="contact-info-icon">
                  <i class="fas fa-phone"></i>
                </div>
                
                <div class="contact-info-content">
                  <h4>Phone</h4>
                  <p>+91 93079 16576 (Sanket Pachade)<br>+91 81779 10231 (Aryan Dore)<br>+91 9175563771 (Devanshu Joshi)<br>+91 96991 01018 (Viraj Manohar)</p>
                </div>
              </div>
              
              <div class="contact-info-item">
                <div class="contact-info-icon">
                  <i class="fas fa-envelope"></i>
                </div>
                
                <div class="contact-info-content">
                  <h4>Email</h4>
                 <p>sanketpachade05@gmail.com<br>aryandore@gmail.com<br>joshi,drj23@gmail.com<br>virajmanohar800@gmail.com</p>
                </div>
              </div>
            </div>
            
            <div class="contact-form">
              <form action="contactus.php" method="post" id="contact-form">

              <?php
    // Database connection
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "contactus";
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

    if (mysqli_connect_error()) {
      echo "Could not connect to the mysql database. Error: " . mysqli_connect_error();
    }

    // Handle form submission
    if (isset($_POST['submit'])) {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        

        $sql="INSERT INTO contact (`fullname`, `email`, `message`) VALUES ('$fullname', '$email', '$message')";

        if ($conn->query($sql) === true) {
            echo "successful!";
            exit(); // Ensure script stops executing after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>


                <h2>Send Message</h2>
                <div class="input-box">
                  <input type="text" required="true" placeholder="Enter Your Name" name="fullname">
               
                </div>
                
                <div class="input-box">
                  <input type="email" required="true" placeholder="Enter Your Email" name="email">
                
                </div>
                
                <div class="input-box">
                  <textarea required="true" placeholder="Type your Message..." name="message"></textarea>
                 
                </div>
                
                <div class="input-box">
                  <input type="submit" value="Send" name="submit">
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </section>
      <script src="https://kit.fontawesome.com/c32adfdcda.js" crossorigin="anonymous"></script>
</body>
</html>