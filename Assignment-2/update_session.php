<?php
    session_start();
    
    $car = $_POST["car"];
    $rental_days = $_POST["rental_days"];
    if (($key = array_search($car, $_SESSION['cart'])) !== false) {
        $_SESSION['cart'][$key]["rental_days"] = $rental_days;
        $response = "Success";
    }
    else{
        $response = "Failed";
    }
    
    echo json_encode($response);
?>