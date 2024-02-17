<html>
  <head>
    <link rel="stylesheet" href="cart.css">
    <script src="cart.js"></script>
  </head>
  <body>
      <div id="update_cookies">
      <?php include "update_cookies.php"; ?>
      </div>
      <!--display table-->
      <div class="frame-container">
        <div class="table-container">
          <?php include "cart_table.php"; ?>
        </div>
        <div class="total-container">
          <div class="total">
            <h1>TOTAL:</h1>
          </div>
          <div class="total-price" id="total-price">
            <?php include "cart_total_price.php"; ?>
          </div>
          <div class="clear-cart">
            <button id="clear-cart" onclick="clear_cart()">Clear Cart</button>
          </div>
        </div>
      </div>
    </body>
    
</html>