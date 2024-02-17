<?php
include ("database.php");

$email = $_GET["email"];

$query_string = "SELECT * FROM rental WHERE user_email = '".$email."'";

$result = mysqli_query($conn, $query_string);

$num_rows = mysqli_num_rows($result);

$currentDate = new DateTime();

$response = 200;

if($num_rows > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $dateString = $row["rent_date"];
        $date = DateTime::createFromFormat('Y-m-d', $dateString);
        $diff = $currentDate->diff($date);
        $monthsDifference = ($diff->y * 12) + $diff->m;
        if ($monthsDifference < 3){
            $response = 0;
            break;
        }
    }
}
echo json_encode($response);
?>