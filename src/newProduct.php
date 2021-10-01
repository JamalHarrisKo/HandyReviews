<?php session_start();

$servername='db';
$username='root';
$password='root';
$dbname = "testdb_two";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if (!$conn){
    die('Could not Connect MySql Server:' .mysql_error());
}

if (isset($_POST['submit'])) {
    //Get product info to save to db
    $product_name = $_POST['product_name'];
    $product_img = $_POST['product_img'];
    $product_description = $_POST['product_description'];
    $category_ids=[];
    //get ids of choosen categorys
    if (isset($_POST['cats']) && is_array($_POST['cats'])) {
        $category_ids = $_POST['cats'];
    }
  
    //Add to database
    $stmt = $conn->prepare("INSERT INTO products (product_name, product_image, product_description) VALUES(?, ?, ?)");
    $stmt->bind_param("sss", $product_name, $product_img, $product_description);
         if ($stmt->execute()) {
         } else {
            echo "Error: " . $sql . ":-" . mysqli_error($conn);
         }
    //Get product id
    $sql = "SELECT product_id FROM products WHERE product_id=LAST_INSERT_ID();";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach($result as $r){
      $product_id = $r['product_id'];
    }//Insert into products_categories table
    foreach($category_ids as $cat){
      $stmt = $conn->prepare("INSERT INTO products_categories(product_id, categorie_id) VALUES(?, ?)");
      $stmt->bind_param("ii", $product_id, $cat);
      if($stmt->execute()) {
      }else{
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
      }
    };

    mysqli_close($conn);
    header("Location: displayProduct.php");
}
