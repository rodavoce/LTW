<?php
    include_once("../Database/Connect.php");
    include_once("../templates/uploadImage.php");

    $id = $_POST['id'];
    uploadImage();
    $image = $_FILES['fileToUpload']['name'];
    $image = "../resources/uploads/" . $image;

    $update = $db->prepare("UPDATE Images SET name = '$image' WHERE restaurant = '$id';");
    $update->execute();

    $link =  "restaurant.php?id=" . $id;
    header('Location:'. $link);

?>