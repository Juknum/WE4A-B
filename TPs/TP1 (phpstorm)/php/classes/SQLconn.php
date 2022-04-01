<?php
require_once("loginStatus.php");

class SQLconn {
    public $conn = null;
    public $loginStatus = null;

    function __construct(string $dbname) {
        $hostname = "localhost";
        $username = "root";
        $password = "root";

        $this->conn = new mysqli($hostname, $username, $password, $dbname);
        if ($this->conn->connect_error) die("Connexion failed: " . $this->conn->connect_error);

        $this->loginStatus = new LoginStatus($this);
    }

    function stringify(string $str) {
        $str = trim($str);
        $str = stripcslashes($str);
        $str = addslashes($str);
        $str = addslashes($str);
        return htmlspecialchars($str);
    }

    function newAccount() {
        $attempted = false;
        $success = false;
        $error = NULL;

        if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
            $attempted = true;

            if (strlen($_POST["name"]) < 4) $error = "Username must be at least 4 characters long!";
            elseif ($_POST["password"] != $_POST["confirm"]) $error = "Passwords are different!";
            else {
                $username = $this->stringify($_POST["name"]);
                $password = md5($_POST["password"]);

                $query = "INSERT INTO `login` VALUES (NULL, '$username', '$password')";
                $result = $this->conn->query($query);

                // todo: mysql_affected_rows verification is deprecated since php 7

                $success = true;
            }
        }

        return array($attempted, $success, $error);
    }

    function disconnectSQL() {
        $this->conn->close();
    }

}

?>