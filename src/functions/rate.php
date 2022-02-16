<?php session_start();
//include "Assets/header.php";
//pruefen ob user eingeloggt ist
if (!$_SESSION['user']) {
    include "../Assets/header.php";
?>

    <div class="login_required">
        <h4>Um diese Funktion zu nutzten melden sie sich bitte <a href="register.php">hier</a> an, oder gehen sie zurueck zur <a href="displayProduct.php">Produktübersicht</a></h4>
    </div>
<?php exit;
}


$servername = 'db';
$username = 'root';
$password = 'root';
$dbname = "smartphoneportal_JamalHarris";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not Connect MySql Server:' . mysql_error());
}
//Read/translate rating & save to db
if (isset($_POST['submit'])) {
    $rating = $_POST['rating_select'];
    $review_id = $_POST['review_id'];
    //Get rating_value_id
    $stmt = $conn->prepare("SELECT * FROM rating_values WHERE rating_value_value=?");
    $stmt->bind_param("i", $rating);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach ($result as $rating_value) {
        $rating_value_id = $rating_value['rating_value_id'];
    }

    //Add rating to db
    $user_id = $_SESSION['id']; 
    //Check if user has already rated the Product
    $stmt = $conn->prepare("SELECT * FROM ratings WHERE review_id=? AND user_id=? ");
    $stmt->bind_param("ii", $review_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result_array = $result->fetch_assoc();
    if(!empty($result_array)){
        print("<p>review has already been rated...<p><p><strong>Return to <a href='/displayProduct.php'>Produkt Übersicht</a></strong>");exit;
    }
    $stmt = $conn->prepare("INSERT INTO ratings(rating_value_id, review_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $rating_value_id, $review_id, $user_id);
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
    mysqli_close($conn);
    header("Location: /pages/displayProduct.php");
}
