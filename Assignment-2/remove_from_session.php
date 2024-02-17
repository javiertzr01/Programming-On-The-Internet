<?php
    session_start();
    
    $car = $_POST;
    if (($key = array_search($car, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $response = "Success";
    }
    else{
        $response = "Failed";
    }
    
    echo json_encode($response);
?>