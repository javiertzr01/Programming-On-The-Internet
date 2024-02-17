<html>
    <head>
        <link href="catalog.css" rel="stylesheet" />
        <script src="catalog.js"></script>
    </head>
    <body>
        <div class="catalog-container">
        <?php
        
        // Connect to Database
        include "database.php";
        
        function SQL_Query_Addition($firstParam){
            if($firstParam){
                return " WHERE ";
            }
            else{
                return " AND ";
            }
        }
        
        $firstParam = true;
        
        $query_string = "SELECT * FROM products";
        
        if (isset($_GET['category'])){
            $category = $_GET['category'];
            $category_string = "sub_category = '".$category."'";
            $query_string = $query_string . SQL_Query_Addition($firstParam) . $category_string;
            $firstParam = false;
        }
        if (isset($_GET['search_text'])){
            $search_text = $_GET['search_text'];
            $search_text = strtolower($search_text);
            $text_string = "LOWER(product_name) LIKE '%".$search_text."%'";
            $query_string = $query_string . SQL_Query_Addition($firstParam) . $text_string;
            $firstParam = false;
        }
        if (isset($_GET['search_min'])){
            $search_min = intval($_GET['search_min']);
            if ($search_min > 0){
                $min_string = "unit_price >=".$search_min;
                $query_string = $query_string . SQL_Query_Addition($firstParam) . $min_string;
                $firstParam = false;
            }
        }
        if (isset($_GET['search_max'])){
            $search_max = intval($_GET['search_max']);
            if ($search_max > 0){
                $max_string = "unit_price <= ".$search_max;
                $query_string = $query_string . SQL_Query_Addition($firstParam) . $max_string;
                $firstParam = false;
            }
        }
        // SELECT * FROM products 
        // WHERE sub_category = '".$category."'
        // AND ...
        // AND ...
        $result = mysqli_query($conn, $query_string);
        // Query number of rows of $result
        $num_rows = mysqli_num_rows($result);
        
        if($num_rows > 0){
            while ($row = mysqli_fetch_assoc($result)){
                display_items($row);
            }
        }
        
        // Create Function to display items, with query string as input
        function display_items($row){ 
            $name = $row["product_name"];
            $size = $row["unit_quantity"];
            $price = $row["unit_price"];
            $stock = $row["in_stock"];
            $id = $row['product_id'];
            ?>
            <div class="catalog-item">
              <h2><?php echo $name;?></h2>
              <div class="image-container">
                  <img src="assets/products/<?php echo $name;?>.jpg" alt="<?php echo $name;?>">
              </div>
              <div class="info-container">
                  <div class="info">
                      <?php if ($stock == 0) {
                          ?><p class="info-out-of-stock">OUT OF STOCK</p><?php
                        } else {
                          ?><p class="info-in-stock">IN STOCK: <?php echo $stock;?></p><?php
                        }
                        ?>
                      <p>Size: <?php echo $size?></p>
                      <p>Price: $<?php echo $price; ?></p>
                      
                  </div>
                  <div class="customer-input">
                      <div class="desired-quantity-container">
                          <p>Quantity:</p>
                          <input 
                            type="number",
                            id="<?php echo $id ?>_quantity",
                            min="0",
                            max="<?php echo min($stock, 50); ?>",
                            oninput="handleOnInput('<?php echo $id; ?>_quantity', <?php echo $stock; ?>)"
                            >
                      </div>
                      <div class="add-button-container">
                        <div class="button-image" onclick="handleAddCart(<?php echo $id;?>, <?php echo $stock; ?>)">
                            <img src="assets/add-to-cart.png" onload="changeBackground(this)" alt="add to cart">
                        </div>
                      </div>
                  </div>
              </div>
           </div>
        <?php } ?>
        </div>
    </body>
</html>