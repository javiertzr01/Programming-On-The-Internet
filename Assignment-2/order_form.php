<html>
    <head>
        <link href="order_form.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="order_form.js"></script>
    </head>
    <body>
        <?php
        // TODO: Add in the $200 thing from SQL (Need AJAX from entering email)
            session_start();
            $cart = $_SESSION["cart"];
            $total_cost = 0;
            foreach($cart as $car){
                $cost = $car["rental_days"] * $car["ppd"];
                $total_cost += $cost;
            }
        ?>
        <div class="container">
          <form action="submit.php" method="POST" onsubmit="return submit_form()">
              
                <h3>Customer Details and Payment</h3>
                <h4>Please fill in your details. <span class="required">*</span> indicates required field.</h4>
                
                <label for="fname">Full Name<span class="required">*</span></label>
                <input type="text" id="fname" name="firstname" required>
                
                <label for="adr"> Address<span class="required">*</span></label>
                <input type="text" id="adr" name="address" required>
                
                <label for="city"> City<span class="required">*</span></label>
                <input type="text" id="city" name="city" required>
                
                <label for="state">State<span class="required">*</span></label>
                <input type="text" id="state" name="state" required>
                
                <label for="post-code">Post Code<span class="required">*</span></label>
                <input type="text" id="post-code" name="post-code" required>
                
                <label for="email">Email<span class="required">*</span></label>
                <input type="text" id="email" name="email" onchange="onEmailChange(this, <?php echo $total_cost; ?>)" required>
                
                <label for="payment">Payment Type:<span class="required">*</span></label>
                <select name="payment" id="payment" required>
                    <option value="visa">Visa</option>
                    <option value="master">MasterCard</option>
                </select>
                
                <input type="hidden" id="bond" name="bond" value="200">
                
                <h2 id="payment-quote">You are required to pay: $<?php echo $total_cost + 200; ?></h2>
                <h3 id="deposit"><span class="required">*</span>An extra $200 deposit was added since you have not rented with us for the past 3 months.</h3>
                
                <div class="btns-container">
                <a class="btn" href="/">Continue Selection</a>
                <input type="submit" value="Booking" class="btn">
                </div>
          </form>
        </div>
        
        <script>
            function onEmailChange(email, cost) {
                var emailValue = email.value;
                $(document).ready(function() {
                    $.ajax({
                        url: "query_sql.php?email=" + encodeURIComponent(emailValue),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            var total_cost = cost + response;
                            $("#payment-quote").text('You are required to pay: $' + total_cost);
                            $("#bond").val(response);
                            if (response == 0){
                                $("#deposit").hide();
                            }
                            else{
                                $("#deposit").show();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                        }
                    });
                });
            }
        </script>
    </body>
</html>