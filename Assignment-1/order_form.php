<html>
    <head>
        <link href="order_form.css" rel="stylesheet" />
        <script src="order_form.js"></script>
    </head>
    <body>
        <?php 
            $order = unserialize(urldecode($_GET["order"]));
            
            $serializedOrder = serialize($order);
        ?>
        <div class="container">
          <form action="email.php" method="POST" onsubmit="return submit_form()">
              
                <h3>Delivery Information</h3>
                
                <label for="fname">Full Name<span class="required">*</span></label>
                <input type="text" id="fname" name="firstname" required>
                
                <label for="adr"> Address<span class="required">*</span></label>
                <input type="text" id="adr" name="address" required>
                
                <label for="suburb"> Suburb<span class="required">*</span></label>
                <input type="text" id="suburb" name="suburb" required>
                
                <label for="state">State<span class="required">*</span></label>
                <input type="text" id="state" name="state" required>
                
                <label for="country">Country<span class="required">*</span></label>
                <input type="text" id="country" name="country" required>
                
                <label for="email">Email<span class="required">*</span></label>
                <input type="text" id="email" name="email" required>
                
                <input type="hidden" name="order" value="<?php echo htmlspecialchars($serializedOrder, ENT_QUOTES); ?>">
                
                <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
                
                <input type="submit" value="Place Order" class="btn">
          </form>
        </div>
    </body>
</html>