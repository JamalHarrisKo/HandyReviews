<?php session_start();

if(!$_SESSION['user']){
include "Assets/header.php";
?>    
<div class="login_required"><h4>Um diese Funktion zu nutzten melden sie sich bitte <a href="register.php">hier</a> an, oder gehen sie zurueck zur <a href="displayProduct.php">Produktübersicht</a></h4></div>
<?php exit;
}

$servername = 'db';
$username = 'root';
$password = 'root';
$dbname = "testdb_two";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not Connect MySql Server:' . mysqli_error($conn));
}
//Kommentar in db speichern
if (isset($_POST['submit'])) {
    $comment = $_POST['comment_content'];
    $review_id = $_POST['review_id'];
    $user_id = $_SESSION['id'];
    $stmt = $conn->prepare("INSERT INTO comments (comment_content, review_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $comment, $review_id, $user_id);
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
    mysqli_close($conn);
    header("Location: displayProduct.php");
}
