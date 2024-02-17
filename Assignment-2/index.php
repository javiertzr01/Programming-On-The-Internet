<html>
    <head>
        <title>Hertz-UTS Car Rentals</title>
        <link href="index.css" rel="stylesheet" />
    </head>
    <body>
        <div class="l-title">
            <div class="l-title-logo">
                <a href = "/">
                    <img src="assets/logo.png" alt="Hertz-UTS Logo">
                </a>
            </div>
            <div class="l-title-text">
                <p class="title-text">Car Rental Center</p>
            </div>
            <div class="l-title-car-reservation-button">
                <a href="/reservations.php" class="button">CAR RESERVATION</a>
            </div>
        </div>
        <div class="l-container">
            <?php include "catalog.php"; ?>
        </div>
    </body>
<!-- DATABASE STUFF -->
<!-- mysql -h awseb-e-xrbeaeab8x-stack-awsebrdsdatabase-hbotqyqvtboy.cmi9bqussbyd.us-east-1.rds.amazonaws.com -u username -p -->
<!-- password -->
<!-- use assignment2; -->
<!-- select * from rental; -->

<!-- user_email, rent_date, bond_amount -->
</html>
