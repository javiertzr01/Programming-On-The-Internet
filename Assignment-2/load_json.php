<?php
// Read the contents of the JSON file
$strJSONContents = file_get_contents("cars.json");

// Set the response content type to JSON
header("Content-Type: application/json");

// Output the JSON data
echo $strJSONContents;
?>
