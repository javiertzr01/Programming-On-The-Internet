<html>
<body>
  <?php
    // Process New Cookie Requests
    if (isset($_GET['cookieValue']) && isset($_GET['cookieId'])) {
        $value = $_GET['cookieValue'];
        $id = $_GET['cookieId'];
        
        $expirationDate = time() + (60 * 60 * 24);
        $deleteDate = time() - (60 * 60);
        
        
        // Modify Cookie Values
        if(isset($_COOKIE[$id])) {
          if($value > 50){
            $value = 50;  // Max Quantity = 50    TODO: Or stock quantity
          }
          if ($value <= 0){
            setcookie($id, $value, $deleteDate, '/');  // Delete Cookie
          }
          else{
            setcookie($id, $value, $expirationDate, '/');  // Update Cookie
          }
        } else {
          setcookie($id, $value, $expirationDate, '/');  // New Cookie
        }
        
    }
    ?>
</body>
</html>
