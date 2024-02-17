<html>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstname'];
    $adr = $_POST['address'];
    $suburb = $_POST['suburb'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $order = unserialize($_POST['order']);
    
    $subject = "New order";
    
    $message = "Transaction processed at ".$_POST['date']."\nDelivery Details\nFirst Name: ".$fname."\nAddress: ".$adr."\nSuburb: ".$suburb."\nState: ".$state."\nCountry: ".$country."\n";
    
    $total = 0;
    
    foreach($order as $product){
        $message = $message."Item: ".$product['name']."        Size: $".$product['size']."        Cost: $".number_format((float)$product["price"], 2, '.', '')."\n";
        $total += floatval($product['price']);
    }
    
    $message = $message."Total: $".number_format((float)$total, 2, '.', '');;
    
    $headers = "From: fresh@shop.com";
    
    if (mail($email, $subject, $message, $headers)) {
      echo "Email sent successfully.";
      ?><<script>window.close()</script><?php
    } else {
      echo "Error: Unable to send email.";
    }
}
?>
</body>
</html>
