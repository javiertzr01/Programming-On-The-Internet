<html>
    <head>
        <link href="index.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body>
        <div class="l-title">
            <div class="l-title-logo">
                <a href = "/">
                    <img src="assets/logo.png" alt="Hertz-UTS Logo">
                </a>
            </div>
            <div class="l-title-text">
                <p class="title-text">Car Reservations</p>
            </div>
        </div>
        <div class="l-container">
            <?php 
                session_start();
                $reservedArray = $_SESSION["cart"];
                if (count($reservedArray) == 0){
            ?>   
                <p>You do not have any cars in your cart</p>
            <?php
                }
                else{
            ?>
                <table>
                <tr>
                    <th>Thumbnail</th>
                    <th>Vehicle</th>
                    <th>Price Per Day</th>
                    <th>Rental Days</th>
                    <th>Actions</th>
                </tr>
                <?php
                    
                    foreach($reservedArray as $car){
                ?>
                        <tr>
                            <td><img src=<?php echo $car["img_src"];?> alt=<?php echo $car["name"];?>></td>
                            <td><?php echo $car["name"];?></td>
                            <td>$<?php echo $car["ppd"];?></td>
                            <td><input type="number" required="required" value=<?php echo $car["rental_days"];?> onchange='validateInput(this, <?php echo json_encode($car); ?>)'></td>
                            <td><div class="button" onclick='remove(<?php echo json_encode($car); ?>)'>Delete</div></td>
                        </tr>
                <?php
                    }
                ?>
                </table>
                <a class="button" href="/order_form.php">Proceed To Checkout</a>
            <?php
                }
            ?>
        </div>
        
        <script>
            function remove(car){
                $(document).ready(function() {
                    $.ajax({
                        url: "remove_from_session.php",
                        type: "POST",
                        data: car,
                        dataType: "json",
                        success: function(response) {
                            console.log("Car deleted:", response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                            // Handle the error, if needed
                        }
                    });
                });
            }
            
            function validateInput(input, car){
                var value = parseInt(input.value);
                if (value < 1 || isNaN(value)) {
                    input.value = 1; // Set the value to 1
                }
                if (value > 30) {
                    input.value = 30; // Set the value to 1
                }
                $(document).ready(function() {
                    $.ajax({
                        url: "update_session.php",
                        type: "POST",
                        data: {car: car, rental_days: input.value},
                        dataType: "json",
                        success: function(response) {
                            console.log("Updated: ", response);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                            // Handle the error, if needed
                        }
                    });
                });
            }
        </script>
    </body>
</html>