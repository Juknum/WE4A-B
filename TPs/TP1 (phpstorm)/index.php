<?php
    // phpinfo();

    require("db.php");
    echo file_get_contents("./html/header.html");

    echo $SQLconn->loginStatus->attempted;
    require_once("./php/multipart/navbar.php");

?>

<h1>Fondations d'un system de blog</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores atque, culpa dolorem ex, excepturi exercitationem iure laborum libero nisi officia porro quidem recusandae repellat rerum sunt tempore ullam ut, voluptate!</p>

<?php
    echo file_get_contents("./html/footer.html");
?>