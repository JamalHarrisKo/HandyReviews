<?php session_start();
include "Assets/header.php" ?>
<!--Content-->
<?php
    if (isset($_POST['submit'])){
        $searchterm =$_POST['searchterm'];
    }
    $servername = 'db';
    $username = 'root';
    $password = 'root';
    $dbname = "testdb_two";
    $conn = mysqli_connect($servername, $username, $password, "$dbname");
    if (!$conn) {
        die('Could not Connect MySql Server:' . mysql_error());
    }
    $product_ids=[];
    //todo tabellen durchsuchen sql like "%searchterm%", produkt ids speichern, dopplungen entfernen
    //und produkte nach ids ausgeben
    //name (tabelle produkt)
    $sql = "SELECT * FROM products WHERE product_name LIKE CONCAT('%',?,'%')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $searchterm);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach ($result as $r){
        array_push($product_ids, $r['product_id']);
       // print_r($product_ids); ----------------------Works------------->
    }



    //hersteller/kategorie (tabelle categories) + via category id tabelle products_categories -> product id
    $sql = "SELECT * FROM categories WHERE categorie_name LIKE CONCAT('%',?,'%')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $searchterm);
    $stmt->execute();
    $result = $stmt->get_result();
    $cat_ids = [];
    foreach ($result as $r){
        array_push($cat_ids, $r['categorie_id']);
    }
    foreach ($cat_ids as $cat){

        $sql = "SELECT * FROM products_categories WHERE categorie_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $cat);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    foreach ($result as $r){
        array_push($product_ids, $r['product_id']);
    }
    //price kategorie (tabelle price_categories) + via price_cateorie id tabelle products_price_categories -> product id
    $sql = "SELECT * FROM price_categories WHERE price_categorie_name LIKE CONCAT('%',?,'%')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $searchterm);
    $stmt->execute();
    $result = $stmt->get_result();
    $price_ids = [];
    foreach ($result as $r){
        array_push($price_ids, $r['price_categorie_id']);
    }
    foreach ($price_ids as $pricecat){
        $sql = "SELECT * FROM products_price_categories WHERE price_categorie_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $pricecat);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    foreach ($result as $r){
        
        array_push($product_ids, $r['product_id']);

    }


$product_ids = array_unique($product_ids);

foreach($product_ids as $pid):
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $pid);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    ?>
    <div class="product_list">
    <?php
    foreach ($stmt_result as $product): 
        $name = $product['product_name'];
        $description = $product['product_description'];
        $image = $product['product_image'];
        $product_id = $product['product_id'];
    endforeach;
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
    
    <?php
endforeach;



//Produkte Laden

?>
</div>

  <!--fuer jedes produkt werte auslesen und ausgeben-->


    


<!--Content end-->
<?php include "Assets/footer.php" ?>