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

    function disconnectSQL() {
        $this->conn->close();
    }

}

?>