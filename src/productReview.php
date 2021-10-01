<?php session_start();
 include "Assets/header.php"; 
 if(!$_SESSION['user']){
?>    
<div class="login_required"><h4>Um diese Funktion zu nutzten melden sie sich bitte <a href="register.php">hier</a> an, oder gehen sie zurueck zur <a href="displayProduct.php">Produktübersicht</a></h4></div>
<?php exit;
}?>
<!--Content-->
<?php

if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
}
$servername = 'db';
$username = 'root';
$password = 'root';
$dbname = "testdb_two";
$conn = mysqli_connect($servername, $username, $password, "$dbname");
if (!$conn) {
    die('Could not Connect MySql Server:' . mysql_error());
}
//Ausgewaehltes Produkt filtern
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
//Produkt Variabeln auslesen und Produkt ausgeben
foreach ($result as $product) {
    $name = $product['product_name'];
    $image = $product['product_image'];
?>
    <div class='product_review'>
        <div class='product_review_info'>
            <h3 class='product_reviewpage_title'><?= $name ?></h3>
            <br>
            <img src=<?= $image ?> class='product_image--review'>
        </div>

        <form class='reviewsubmit' action='productReviewSubmit.php' method='POST'>
            <input type='hidden' name='product_id' value='<?= $product_id ?>'>
            <textarea rows='15' name='review_content' class='review_input' placeholder='Write you review here...'></textarea>
            <div class='center-div'>
                <button type='submit' name='submit' class='btn btn-primary btn-center btn-review'>Review veröffentlichen</button>
            </div>
        </form>

    </div>
<?php
}
?>


<!--Content end-->
<?php include "Assets/footer.php" ?>