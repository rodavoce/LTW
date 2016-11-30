<!DOCTYPE html>
<html>

<head>
    <title>Já Comia - Feed</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>


<body>

    <div id="topbar">
        <h1>Já Comia</h1>
        <p>USER NAME </p>

        <div id="searchbar">
            <form action="" method="get">
                <input type="text" name="search" placeholder="Search">
            </form>
        </div>
    </div>

    <div id="main">
        <img src="../resources/mainimg.gif"/>
        <div id="maincontent">
            <h1>Já Comia</h1>
            <div id="mainsearch"/>
                <form action="feed.php" method="get">
                    <?php
                        $rname = $_GET['rname'];
                        $local = $_GET['local'];

                        echo '<input type="text" name="rname" placeholder="Restaurant" value="' . $rname . '">';
                        echo '<input type="text" name="local" placeholder="Location" value="' . $local . '">';
                     ?>
                    <input type="submit" value="">
                </form>
            </div>
        </div>
    </div>

    <div id="restaurantslist">
        <?php
            $rname = $_GET['rname'];
            $local = $_GET['local'];

            $db = new PDO('sqlite:../Database/dataBase.db');

            $stmt;

            if($rname == '' && $local == '')
                $stmt = $db->prepare("SELECT * FROM Restaurants ORDER BY avgClass DESC");
            else
                $stmt = $db->prepare("SELECT * FROM Restaurants WHERE name = '$rname' OR city = '$local' OR district = '$local' OR country = '$local' ORDER BY avgClass DESC");

            $stmt->execute();
            $result = $stmt->fetchAll();


             foreach ($result as $row)
             {
                 echo  '<div class="restaurant">';

                 echo '<img src="../resources/rex.jpg">';

                 echo '<h1>' . $row['name'] . '</h1>';

                 echo '<h2>' . $row['city'] , ", " , $row['district'], ", ", $row['country']  . '</h2>';

                 echo '<p>' .  "Proin ex tortor, rutrum a risus vitae, tincidunt varius nulla. Nulla vulputate velit non justo luctus molestie.
                     Quisque eleifend lacus eu sagittis dignissim. Duis pharetra eget odio et tempor. Morbi vitae tincidunt neque, eget consectetur purus.
                     Nam in diam mi. Duis ut odio sit amet risus tincidunt consectetur. " . '</p>';

                     echo '<div class="rrating">';
                     echo '<p>' . $row['avgClass'], "/5" . '</p>';
                     echo '</div>';

                 echo '</div>';
                 echo '<hr>';

             }
        ?>

    </div>



</body>


</html>
