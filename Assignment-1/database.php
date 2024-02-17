<html>
    <body>
        <?php 
        $conn = mysqli_connect("awseb-e-8ximt7vxkm-stack-awsebrdsdatabase-moyn11a2j8dh.cmi9bqussbyd.us-east-1.rds.amazonaws.com", "username", "password", "assignment1");
        if (!$conn){
            die("Could not connect to server");
        }
        ?>
    </body>
</html>