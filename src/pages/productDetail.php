<?php session_start();
include "../Assets/header.php" ?>
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
//Produkt filtern
$sql = "SELECT * FROM products WHERE product_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $product) {
    //Kategorien Id's
    $stmt = $conn->prepare("SELECT * FROM products_categories wHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $cat_result = $stmt->get_result();
    $categorie_ids = [];
    $categorie_names = [];
    foreach ($cat_result as $pro_cat) {
        $categorie_ids[] = $pro_cat['categorie_id'];
    }
    //Kategorien Namen
    foreach ($categorie_ids as $cat_id) {
        $stmt = $conn->prepare("SELECT * FROM categories WHERE categorie_id=?");
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        $cat_result = $stmt->get_result();
        foreach ($cat_result as $cr) {
            $categorie_names[] = $cr['categorie_name'];
        }
    };
    //preiskategorien

    // Id's
    $stmt = $conn->prepare("SELECT * FROM products_price_categories wHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $price_cat_result = $stmt->get_result();
    $price_categorie_ids = [];
    $price_categorie_names = [];
    foreach ($price_cat_result as $pro_cat) {
        $price_categorie_ids[] = $pro_cat['price_categorie_id'];
    }
    // Namen
    foreach ($price_categorie_ids as $cat_id) {
        $stmt = $conn->prepare("SELECT * FROM price_categories WHERE price_categorie_id=?");
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        $cat_result = $stmt->get_result();
        foreach ($cat_result as $cr) {
            $price_categorie_names[] = $cr['price_categorie_name'];
        }
    };

    $name = $product['product_name'];
    $description = $product['product_description'];
    $image = $product['product_image'];
    //new
    $image_back = $product['product_image_backside'];
    $screensize = $product['product_screensize'];
    $resoltution = $product['product_screen_resolution'];
    $weight = $product['product_weight'];
    $company_info = $product['product_company_info'];
}
?>
<div class='product'>
    <h3 class='product_title'><?= $name ?></h3>
    <br>
    <img src="<?= $image ?>" class='product_image--list'>
    <img src="<?= $image_back ?>" class='product_image--back'>
    <p class='product_description'><?= htmlspecialchars($description) ?></p>
    <ul class= "product__information">
        <li class="product__information__single">Bildschirmgröße: <?=$screensize?></li>
        <li class="product__information__single">Bildschirmauflösung: <?=$resoltution?></li>
        <li class="product__information__single">Gewicht: <?=$weight?></li>
        <li class="product__information__single"><a class="btn btn-primary" href="<?=$company_info?>">Herstellerinfos</a></li>
    </ul>
    <div class='product_categorie'>
        <h5>Kategorien: &nbsp</h5>
        <?php foreach ($categorie_names as $cn) { ?>
            <p><?= $cn ?>;&nbsp</p>
        <?php } ?>
        <?php if (!$categorie_names) { ?>
            <p>Keine Angaben</p>
        <?php } ?>
        <h5>Preisklasse: &nbsp</h5>
        <?php foreach ($price_categorie_names as $cn) { ?>
            <p><?= $cn ?>;&nbsp</p>
        <?php } ?>
        <?php if (!$price_categorie_names) { ?>
            <p>Keine Angaben</p>
        <?php } ?>
    </div>
    <div class='clear'></div><br>
    <form class='submitform' action='productReview.php' method='POST'>
        <input type='hidden' name='product_id' value='<?= $product_id ?>'>
        <div class='center-div'>
            <button type='submit' name='submit' class='btn btn-primary btn-center'>Neues Review verfassen</button>
        </div>
    </form>
</div>
<?php
//Produkt Reviews auslesen
$stmt = $conn->prepare("SELECT * FROM reviews WHERE product_id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
foreach ($result as $review_result) {
    $review_id = $review_result['review_id'];
    $user_id = $review_result['user_id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach($result as $user){
        $user_name = $user['user_name'];
    }
    //Review Rating
    $rating_count = 0;
    $ratings_total = 0;

    $stmt = $conn->prepare("SELECT * FROM ratings WHERE review_id=?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $rating_result = $stmt->get_result();
    foreach ($rating_result as $ratingresult) {
        //Prepare rating results
        $rating_count += 1;
        $rating_id = $ratingresult['rating_id'];
        //Rating Id's
        $stmt = $conn->prepare("SELECT * FROM ratings WHERE rating_id=?");
        $stmt->bind_param("i", $rating_id);
        $stmt->execute();
        $rating_value_result = $stmt->get_result();
        foreach ($rating_value_result as $rv) {
            $rating_value_id = $rv['rating_value_id'];
            //Rating Values (-> from rating_value_id)
            $stmt = $conn->prepare("SELECT * FROM rating_values WHERE rating_value_id=?");
            $stmt->bind_param("i", $rating_value_id);
            $stmt->execute();
            $rating_result = $stmt->get_result();
            //Add up rating and count number of ratings
            foreach ($rating_result as $rating_value) {
                $rating_value = $rating_value['rating_value_value'];
                $ratings_total += $rating_value;
            }
        }
    }
?>
        <p class='review_text'>Review by: <strong><?= $user_name ?></strong><br><?= $review_result['review_content'] ?></p>
        <form class='rating' action='/functions/rate.php' method='POST'>
            <select id='rating_select' name='rating_select'>
                <option name='one' value=1>1 Stern</option>
                <option name='two' value=2>2 Sterne</option>
                <option name='three' value=3>3 Sterne</option>
                <option name='four' value=4>4 Sterne</option>
                <option name='five' value=5>5 Sterne</option>
            </select>
            <input type='hidden' name='review_id' value='<?= $review_result['review_id'] ?>'>
            <button type='submit' name='submit'>Review Berwerten</button>
        </form>
        <?php if ($rating_count == 0) { ?>
            <br>
            <p>Review Rating: <strong><?= $ratings_total ?> Stars</strong> (<?= $rating_count ?> votes)</p>
        <?php } else { ?>
            <br>
            <p>Review Rating: <strong><?= round($ratings_total / $rating_count, 1) ?> Stars</strong> (<?= $rating_count ?> votes)</p>
            <hr>
    <?php }
    
    ?>
    <h6>Kommentar verfassen:</h6>
    <form class='comment_form' action='/functions/comment.php' method='POST'>
        <textarea class='comment_text' rows='10' name='comment_content' required></textarea>
        <input type='hidden' name='review_id' value='<?= $review_id ?>'>
        <button type='submit' name='submit'>Kommentar veröffentlichen</button>
    </form>
    <hr>
    <h5>Kommentare:</h5>
    <?php
    //Filter comments by review
    $stmt = $conn->prepare("SELECT * FROM comments WHERE review_id=?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $comment_review_result = $stmt->get_result();
    //Review without comments
    if (!$comment_review_result->fetch_assoc()) {
    ?>
        <p><i>Zu diesem Review sind noch keine Kommentare vorhanden</i></p>
        <?php
    }
    //If comments are available:
    foreach ($comment_review_result as $comment_review_result) {
        $comment_id = $comment_review_result['comment_id'];
        //get comments
        $stmt = $conn->prepare("SELECT * FROM comments WHERE comment_id=?");
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $comment_result = $stmt->get_result();
        //print comments
        foreach ($comment_result as $cr) {
            $comment_content = $cr['comment_content'];
            $uid = $cr['user_id'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            $result = $stmt->get_result();
            foreach($result as $user){
                $username = $user['user_name'];
            }
        ?>
            <p class='comment'>comment by <strong><?= $username ?></strong>:</br><?= $comment_content ?></p>

        <?php } ?>
        <br>
        <hr>
    <?php
    }}
    ?>
<?php
?>


<!--Content end-->
<?php include "../Assets/footer.php" ?>