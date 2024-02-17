<?php
include ("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['email'];
    $date = new DateTime();
    $rent_date= $date->format('Y-m-d');
    $bond_amount = $_POST['bond'];
    
    $query = "INSERT INTO rental (user_email, rent_date, bond_amount) VALUES ('$user_email', '$rent_date', $bond_amount)";
    
    if (mysqli_query($conn, $query)) {
        echo "Thank you for renting from HertzUTS. Record has been added into our system";
    } else {
        echo "Error inserting row: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
    
    session_start();
    foreach($_SESSION['cart'] as $c){
        $strJSONContents = file_get_contents("cars.json");
        $array = json_decode($strJSONContents, true);
        foreach($array as &$car){
            $cart_name = $car["model year"] . "-" . $car["brand"] . "-" . $car["model"];
            if($cart_name == $c["name"]){
                $car["availability"] = false;
            }
        }
        $newStr = json_encode($array);
        $newStrPretty = json_encode($array, JSON_PRETTY_PRINT);
        
        header('Content-Type: application/json');
        
        // Editing JSON file
        file_put_contents("cars.json", $newStrPretty);
        
        session_destroy();
    }
}
?>
