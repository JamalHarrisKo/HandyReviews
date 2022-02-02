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
$stmt = $conn->prepare("SELECT * FROM price_categories");
$stmt->execute();
$stmt_result = $stmt->get_result();
$price_categories = [];
foreach ($stmt_result as $r) {
    $price_categories[(int) $r["price_categorie_id"]] = $r["price_categorie_name"];
}

?>
<form class="newProductForm" action="newProduct.php" method="POST">
    <!--Name-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_name">Proukt-Name:</span>
        <input type="text" name="product_name" class="form-control" placeholder="Apple iPhone X/Apple IPad 10.2/..." aria-label="ProductName" aria-describedby="productname">
    </div>
    <!--Bild-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_img">Produkt Bild Link:</span>
        <input type="text" name="product_img" class="form-control" placeholder="https://..." aria-label="product_img" aria-describedby="product_img">
    </div>
    <!--img rueckseite-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_backside_img">Produkt Bild (Rückseite):</span>
        <input type="text" name="product_backside_img" class="form-control" placeholder="https://..." aria-label="product_backsides_img" aria-describedby="product_img">
    </div>
    <!--screensize-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_screensize">Bildschirmgröße:</span>
        <input type="text" name="product_screensize" class="form-control" placeholder="12 Zoll" aria-label="product_screensize" aria-describedby="product_screensize">
    </div>
        <!--aufloesung-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_resolution">Bildschirmauflösung:</span>
        <input type="text" name="product_resolution" class="form-control" placeholder="1000px x 2000px" aria-label="product_resolution" aria-describedby="product_resolution">
    </div>

    <!--gewicht-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_weight">Produktgewicht:</span>
        <input type="text" name="product_weight" class="form-control" placeholder="300g" aria-label="product_weight" aria-describedby="product_weight">
    </div>
    <!--herstellerinfos-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_company_info">Herstellerinfos:</span>
        <input type="text" name="product_company_info" class="form-control" placeholder="https://..." aria-label="product_company_info" aria-describedby="product_company_info">
    </div>
    <!--beschreibung-->
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="product_description">Product Beschreibung:</span>
        <textarea name="product_description" class="form-control" rows="5" aria-label="product_description" aria-describedby="product_description" placeholder="Beschreibung des Produktes..."></textarea>
    </div>
    <!--Kategorie-->
    <span class="input-group-text" id="product_categories">Produkt Kategorien:</span>
    <div class="checkboxes">
        <?php foreach ($categories as $catId => $cat) { ?>
            <div>
                <label for="product_cat_<?= htmlspecialchars($catId) ?>"><?= htmlspecialchars($cat) ?></label>
                <input id="product_cat_<?= htmlspecialchars($catId) ?>" type='checkbox' name='cats[]' aria-label='product_cat' aria-describedby='product_cat' value="<?= htmlspecialchars($catId) ?>">
            </div>
        <?php } ?>
        <div class="input-group price_cats">
            <div class="input-group-text product_price_categories" id="product_price_categories">Preis Kategorien:</div>
            <div class="price_cats_container">
                <?php foreach ($price_categories as $catId => $cat) { ?>
                    <div>
                        <label for="price_cat_<?= htmlspecialchars($catId) ?>"><?= htmlspecialchars($cat) ?></label>
                        <input id="price_cat_<?= htmlspecialchars($catId) ?>" type='checkbox' name='price_cats[]' aria-label='price_cat' aria-describedby='price_cat' value="<?= htmlspecialchars($catId) ?>">
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <button type="submit" name="submit" class="btn btn-register btn-primary">Produkt Hinzufügen</button>
</form>

<!----END----->
<?php include "Assets/footer.php" ?>