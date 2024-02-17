<?php
    session_start();
    
    // Accept data
    $car = $_POST['data'];
    
    // Check if there is current cart, if not, create a new cart session
    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    if (($key = array_search($car, $_SESSION['cart'])) === false) {
        array_push($_SESSION['cart'], $car);
    }
    
    $response = "Success";
    
    echo json_encode($response);
?>