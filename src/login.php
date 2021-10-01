<?php session_start();
$servername = 'handyreviews_db_1';
$username = 'root';
$password = 'root';
$dbname = "testdb_two";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not Connect MySql Server:' . mysqli_error($conn));
}
//Variabeln aus POST auslesen
if (isset($_POST['submit'])) {
    $umail = $_POST['email'];
    $upw = $_POST['password'];
    //Pruefen ob email und Passwort stimmen
        $stmt = $conn->prepare("SELECT * FROM users where user_mail=?");
        $stmt->bind_param("s", $umail);
        $stmt->execute();
        $result = $stmt->get_result();
        $result_array = $result->fetch_assoc();
        if ($result_array) { 
            foreach($result as $r){
                if($r['user_pw'] == $upw){
                    $_SESSION['user'] = $r['user_name'];
                    $_SESSION['id'] = $r['user_id'];
                }else{
                    echo('Das Passwort stimmt nicht mit der Email überein...'); exit;
                }
            }
        }else{
            echo('Fehler, für diese Email wurde noch kein Account angelegt...');exit;
        }
    }

    mysqli_close($conn);
    header("Location: index.php");


?>