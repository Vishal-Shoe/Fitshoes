<?php
session_start(); // Start the session

// Check if the 'remove_from_cart' form has been submitted
if(isset($_POST['remove_from_like'])) {
    $product_id = $_POST['product_id'];
    $category = $_POST['category'];

    // Find the index of the item to remove from the cart
    $index = array_search(array('product_id' => $product_id, 'category' => $category), $_SESSION['like']);

    // Remove the item from the cart array
    if($index !== false) {
        unset($_SESSION['like'][$index]);
        // Reorder array keys to prevent gaps
        $_SESSION['like'] = array_values($_SESSION['like']);
    }

    // Redirect back to the cart page
    header("Location: like.php");
    exit();
}
?>
