<?php
// Name of the data file
$filename = 'flush.sql';
// MySQL host
$mysqlHost = 'handyreviews_db_1';
// MySQL username
$mysqlUser = 'root';
// MySQL password
$mysqlPassword = 'root';
// Database name
$mysqlDatabase = 'smartphoneportal_JamalHarris';

// Connect to MySQL server
$link = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword) or die('Error connecting to MySQL Database: ' . mysqli_error($link));

$tempLine = '';
// Read in the full file (as array)
$lines = file($filename);
// Loop through each line
foreach ($lines as $line) {
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        //start loop on next line
        continue;
    // Add this line to the current segment
    $tempLine .= $line;
    // Check last character, if its a semicolon at the end, it's the end of one query
    if (substr(trim($line), -1, 1) == ';')  {
        // Perform the query
        mysqli_query($link, $tempLine) or print("Error in " . $tempLine .":". mysqli_error($link));
        // Reset temp variable to empty
        $tempLine = '';
    }
}
 //echo "Tables imported successfully";
mysqli_close($link);
header("Location: /pages/register.php");
