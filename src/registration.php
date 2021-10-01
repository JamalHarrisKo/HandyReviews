<?php session_start();

$servername = 'testproject_db_1';
$username = 'root';
$password = 'root';
$dbname = "testdb_two";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not Connect MySql Server:' . mysqli_error());
}
//Variabeln aus POST auslesen
if (isset($_POST['submit'])) {
    $uname = $_POST['name'];
    $umail = $_POST['email'];
    //Pruefen ob email breits vorhanden ist
    if ($umail != "") {
        $stmt = $conn->prepare("SELECT * FROM users where user_mail=?");
        $stmt->bind_param("s", $umail);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $num_rows = mysqli_num_rows($result);
            if ($num_rows >= 1) {
                echo "email exist";
                exit;
            }
        }
    }
    $upw = $_POST['password'];
    //Benutzter zu DB hinzufuegen
    $stmt = $conn->prepare("INSERT INTO users (user_name, user_mail, user_pw) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $uname, $umail, $upw);
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
    mysqli_close($conn);
    header("Location: index.php");
}
