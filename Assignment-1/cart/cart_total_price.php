<html>
<body>
    <?php
    // Helper Functions
    function queryDatabaseForCost($conn, $id, $quantity){
        $query_string = "SELECT * FROM products WHERE product_id = '".$id."'";
        $result = mysqli_query($conn, $query_string);
        $num_rows = mysqli_num_rows($result);
        
        $product = array();
        
        if($num_rows == 1){
            $row = mysqli_fetch_assoc($result);
            $product["unit_price"] = $row["unit_price"];
            $product["quantity"] = $quantity;
            $product["price"] = $product["unit_price"] * $quantity;
        return $product["price"];
        }
    }
    
    
    // Update from Catalog
    if (isset($_GET['quantity']) & isset($_GET['id']) & isset($_GET['current'])){
        // connect to database
        include "../database.php";
        
        $quantity = $_GET['quantity'];
        $id = $_GET['id'];
        $current_total = floatval($_GET['current']);
        
        $cost = floatval(queryDatabaseForCost($conn, $id, $quantity));
        
        $total_price = $current_total + $cost;
    }
    
    
    // Update from cart
    else if (isset($_GET['total'])){
        $total_price = $_GET['total'];
    }
    
    
    // Initialize
    else{
        $total_price = 0;
        foreach($_COOKIE as $name => $value){
            if(is_int($name) && $value > 0){
                $price = queryDatabaseForCost($conn, $name, $value);
                $total_price += $price;
            }
        }
    }
    ?>
    <h3 id="total-price-value">$<?php echo number_format((float)$total_price, 2, '.', ''); ?></h3>
</body>
</html>