<?php

class loginStatus {
    public $successful = false;
    public $attempted = false;
    public $error = "";
    public $userID = -1;
    public $userName = "";

    function __construct(&$SQLconn) {
        $password = null;
        $this->successful = false;

        // login
        if (isset($_POST["name"]) && isset($_POST["password"])) {
            $this->userName = $SQLconn->stringify($_POST["name"]);
            $this->attempted = true;
            $password = md5($_POST["password"]);
        }

        // login with cookie
        elseif (isset($_COOKIE["name"]) && isset($_COOKIE["password"])) {
            $this->userName = $_COOKIE["name"];
            $this->attempted = true;
            $password = md5($_POST["password"]);
        }

        if ($this->attempted) {
            $query = "SELECT * FROM login WHERE username = $this->userName AND password = $password";
            $result = $SQLconn->conn->query($query);

            if ($result){
                $row = $result->fetch_assoc();
                $this->userID = $row["ID"];
                $this->userName = $row["logname"];
                $this->createLoginCookie($this->userName, $password, $_POST["remember"]);
                $this->successful = true;
            }
            else $this->error = "This user does not exist/cannot be found; please create an account.";

        }
    }

    function createLoginCookie($username, $encryptedPassword, $remember) {
        setcookie("name", $username, time() + ($remember ? 24 * 3600 : 3600));
        setcookie("password", $encryptedPassword, time() + ($remember ? 24 * 3600 : 3600));
    }

    function logout() {
        setcookie("name", NULL, -1);
        setcookie("password", NULL, -1);
    }
}

?>