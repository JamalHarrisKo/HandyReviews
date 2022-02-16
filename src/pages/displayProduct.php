<?php session_start();
include "../Assets/header.php"; ?>
<!--Content-->
<?php
$servername = 'db';
$username = 'root';
$password = 'root';
$dbname = "smartphoneportal_JamalHarris";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die('Could not Connect MySql Server:' . mysql_error());
}
//Produkte Laden
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$stmt_result = $stmt->get_result();
?>
<div class="product_list">
  <!--fuer jedes produkt werte auslesen und ausgeben-->
  <?php foreach ($stmt_result as $product) {
    $name = $product['product_name'];
    $description = $product['product_description'];
    $image = $product['product_image'];
    $product_id = $product['product_id'];
  ?>
    <div class="product">
      <h3 class="product_title"><?= $name ?></h3>
      <br>
      <img src="<?= htmlspecialchars($image) ?>" class="product_image--list">
      <p class="product_description"><?= htmlspecialchars($description) ?></p>
      <div class="clear"></div>
      <form class='submitform' action='productDetail.php' method='POST'>
        <input type='hidden' name='product_id' value='<?= htmlspecialchars($product_id) ?>'>
        <div class='center-div'>
          <button type='submit' name='submit' class='btn btn-primary btn-center'>View Product Reviews</button>
        </div>
      </form>
      <br>
    </div>
    <?php } ?>
</div>

<!--Content end-->
<?php include "../Assets/footer.php" ?>