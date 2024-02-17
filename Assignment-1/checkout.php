<html>
    <head>
        <link href="checkout.css" rel="stylesheet" />
        <script src="checkout.js"></script>
    </head>
    <body>
        <div id="checkout_button">
        <?php
        
        // Connect to database
        include "database.php";
        
        // Helper Functions
        function queryDatabase($conn, $id, $quantity){
            $query_string = "SELECT * FROM products WHERE product_id = '".$id."'";
            $result = mysqli_query($conn, $query_string);
            $num_rows = mysqli_num_rows($result);
            
            $product = array();
            
            if($num_rows == 1){
                $row = mysqli_fetch_assoc($result);
                $product["name"] = $row["product_name"];
                $product["id"] = $id;
                $product["unit_price"] = $row["unit_price"];
                $product["size"] = $row["unit_quantity"];
                $product["quantity"] = $quantity;
                $product["price"] = $product["unit_price"] * $quantity;
                $product["stock"] = $row["in_stock"];
            return $product;
            }
        }
        
        // Update
        if (isset($_GET["enabled"])){
            $enabled = $_GET["enabled"];
        }
        // New Instance (Check Cookies)
        else{
            $enabled = "false";
            foreach($_COOKIE as $name => $value){
                // print($name);   // Debug
                if(is_int($name) && $value > 0){
                    $enabled = "true";
                    break;
                }
            }
            
        }
        
        
        if ($enabled == "true"){
            // Get the information to be passed to the final order
            $order = array();
            foreach($_COOKIE as $name => $value){
                if(is_int($name) && $value > 0){
                    $product = queryDatabase($conn, $name, $value);
                    array_push($order, $product);
                }
            };
            $order = urlencode(serialize($order));
        ?>
            <div class="page-container" onclick="checkout('<?php echo $order ?>')">
        <?php
        }
        else{
        ?>
            <div class="page-container disabled">
        <?php
        }
        ?>
                <h1>Checkout</h1>
            </div>
        </div>
    </body>
</html>