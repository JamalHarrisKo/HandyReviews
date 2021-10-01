<?php session_start();
include "Assets/header.php";
if(!$_SESSION['user']){
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
    die('Could not Connect MySql Server:' . mysql_error());
}
//Alle Kategorien die Definiert sind aus db holen
$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$stmt_result = $stmt->get_result();
$categories = [];
foreach ($stmt_result as $r) {
    $categories[(int) $r["categorie_id"]] = $r["categorie_name"];
}

?>
<form class="newProductForm" action="newProduct.php" method="POST">
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_name">Proukt-Name:</span>
        <input type="text" name="product_name" class="form-control" placeholder="Apple iPhone X/Apple IPad 10.2/..." aria-label="ProductName" aria-describedby="productname">
    </div>
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_img">Produkt Bild Link:</span>
        <input type="text" name="product_img" class="form-control" placeholder="https://..." aria-label="product_img" aria-describedby="product_img">
    </div>
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_description">Product Beschreibung:</span>
        <textarea name="product_description" class="form-control" rows="5" aria-label="product_description" aria-describedby="product_description" placeholder="Beschreibung des Produktes..."></textarea>
    </div>
    <span class="input-group-text" id="product_categories">Produkt Kategorien:</span>
    <div class="checkboxes">
        <?php foreach ($categories as $catId => $cat) { ?>
            <div>
                <label for="product_cat_<?= htmlspecialchars($catId) ?>"><?= htmlspecialchars($cat) ?></label>
                <input id="product_cat_<?= htmlspecialchars($catId) ?>" type='checkbox' name='cats[]' aria-label='product_cat' aria-describedby='product_cat' value="<?= htmlspecialchars($catId) ?>">
            </div>
        <?php } ?>
    </div>
    <button type="submit" name="submit" class="btn btn-register btn-primary">Produkt Hinzufügen</button>
</form>

<!----END----->
<?php include "Assets/footer.php" ?>