<?php include_once '../templates/header.php'; ?>

<body>
  <?php include_once '../templates/topbar.php'; ?>

    <div id="Intro">

        <img src="../resources/imgNewRestaurant.jpg" />
        <h1> Novo Restaurante <h1>
    </div>




    <div id="FormNewRestaurant">

    <?php if(isset($_SESSION['user']))
    {
    ?>
      <form action="newRestaurant.php"  method="post" enctype="multipart/form-data">

        <?php

        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $country = $_POST['country'];
        $type = $_POST['type'];

        echo '
        <label> Nome </label>
          <input type="text" name="name" value="'.$name.'"required >
        <label> Rua </label>
          <input type="text" name="address" value="'.$address.'"required>
        <label> Cidade </label>
          <input type="text" name="city" value="'.$city.'"required>
        <label> Distrito </label>
          <input type="text" name="district" value="'.$district.'"required>
        <label> País </label>
          <input type="text" name="country" value="'.$country.'"required>
        <label> Tipo </label>
          <input type="text" name="type" value="'.$type.'" required>';

        ?>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" name="Regist" value="Submit">

      </form>


      <!--form action="../templates/uploadImage.php" method="post" enctype="multipart/form-data">
          <label>Select image to upload:</label>
          <input type="submit" value="Upload Image" name="submit">
      </form-->

      <?php
        } else {
        echo '<h1> Precisa de iniciar sessão para criar um restaurante </h1>';
      }
      ?>
    </div>

<?php
 if( isset($_POST['Regist'] )){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $country = $_POST['country'];
        $type = $_POST['type'];

        include_once '../Database/Connect.php';
        include_once '../templates/uploadImage.php';

        $query = $db->prepare("INSERT INTO Restaurants (name, address, type, city, district, country, avgClass)
                               VALUES ('$name','$address','$type','$city','$district','$country',NULL);");

        try {
            $query->execute();
        } catch (PDOException $e) {
            echo '<div id = Msg >
                      <h2> O restaurante já se encontra registado </h2>
                      </div>
                      ';
        }

        $getid = $db->prepare("SELECT rowid FROM Restaurants WHERE name = '$name' AND address = '$address' AND country = '$country' AND type = '$type';");
        $getid->execute();
        $id = $getid->fetchAll();
        $id = $id[0];
        $num = $id['rowid'];

        $username = $_SESSION["user"];
        $getuserid = $db->prepare("SELECT rowid FROM Users WHERE usr = '$username';");
        $getuserid->execute();
        $use = $getuserid->fetchAll();
        $userid = $use[0];
        $usernum = $userid['rowid'];

        $insertowner = $db->prepare("INSERT INTO Owners (owner, restaurant) VALUES('$usernum', '$num');");
        try {
            $insertowner->execute();
            echo '<div id ="Msg" >
                      <h2> O restaurante foi registado </h2>
                      </div>';
        } catch (PDOException $e){
            echo '<div id ="Msg" >
                      <h2> Erro ao registar restaurante </h2>
                      </div>';
        }
        if(uploadImage()){
        $imageurl = "../resources/uploads/" . $_FILES['fileToUpload']['name'];
        $insertimage = $db->prepare("INSERT INTO Images (restaurant, name) VALUES ('$num', '$imageurl');");
        $insertimage->execute();
        }

}
?>


</body>



<?php include_once '../templates/footer.php'; ?>
