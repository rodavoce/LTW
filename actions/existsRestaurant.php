<?php
$db = new PDO('sqlite:../Database/dataBase.db');

if (isset($_POST["name"])) {
    $name = htmlentities($_POST["name"]);
    $address = htmlentities($_POST["address"]);

    $stmt = $db->prepare("SELECT * FROM Restaurants WHERE name='".$name."' AND address='".$address."';");
    $stmt->execute();
    $result = $stmt->fetchAll();

    echo json_encode($result);
}
?>
