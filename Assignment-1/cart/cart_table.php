<html>
<body>
    <table id="table">
        <?php 
        // connect to database
        include "../database.php";
        
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
        
        
        function displayRow($product){
        ?>
            <td><?php echo $product["name"]; ?></td>
            <td><?php echo $product["size"]; ?></td>
            <td>$<?php echo number_format((float)$product["unit_price"], 2, '.', ''); ?></td>
            <td>
              <input 
                type="number",
                id="<?php echo $product["id"]; ?>_quantity",
                class="cart-input",
                min="0",
                max= <?php echo min($product["stock"], "50"); ?>,
                value="<?php echo $product["quantity"]; ?>",
                style="width: 60px",
                onchange="handleQuantityChange(event, this, <?php echo $product["id"] ?>, <?php echo $product["stock"] ?>)"
              >
            </td>
            <td id="<?php echo $product["id"]; ?>_price">$<?php echo number_format((float)$product["price"], 2, '.', ''); ?></td>
            <td class="no-style"><button class="remove-btn" onclick="delete_item(this, <?php echo $product["id"] ?>)"></button></td>
        <?php
        }


        if (isset($_GET['mode'])){
            if (isset($_GET['id']) && isset($_GET['quantity'])) {
                // Mode = Change Values
                if ($_GET['mode'] == "change"){
                    $value = $_GET['quantity'];
                    $id = $_GET['id'];
                    $product = queryDatabase($conn, $id, $value);
                    if ($value > 0){
                        displayRow($product);
                    }
                }
                // Mode = Remove Row
                else if ($_GET['mode'] == "remove"){}
                else{
                    print("cart_table.php Display Error");
                }
            }
        }
        else
        // New Instance (Get memory from Cookies)
        {   
            ?>
        
            <!--Start of Table-->
            <tr class="no-hover">
                <th>Name</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th class="no-style"> </th>
            </tr>
          
            <?php 
            foreach($_COOKIE as $name => $value){
                if(is_int($name) && $value > 0){
                    $product = queryDatabase($conn, $name, $value);
            ?>
                    <tr>
                    <?php
                    displayRow($product);
                    ?>
                    </tr>
                    <?php
                }
            }
        }
        
        ?>
      </table>
</body>
</html>