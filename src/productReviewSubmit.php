<?php session_start();

$servername='db';
$username='root';
$password='root';
$dbname = "testdb_two";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
    die('Could not Connect MySql Server:' .mysql_error());
}
//Review aus POST array auslesen
if (isset($_POST['submit'])){
    $review_content = $_POST['review_content'];
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['id'];
    //Review zu db hinzufuegen
    $stmt = $conn->prepare("INSERT INTO reviews (review_content, product_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $review_content, $product_id, $user_id);
    if ($stmt->execute()) {
    } else {
    echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
    mysqli_close($conn);
    header("Location: displayProduct.php");
}
