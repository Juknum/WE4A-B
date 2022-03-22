<?php
    // phpinfo();
    require_once("./php/classes/SQLconn.php");
    $SQLconn = new SQLconn("users");

    echo file_get_contents("./html/header.html");

    require_once("./php/multipart/navbar.php");

    echo file_get_contents("./html/footer.html");
?>