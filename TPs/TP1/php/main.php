<?php
	global $_DB_CONNEXION; 	//* {any} connection status
	global $_USER_NAME;			//* {string} user name
	global $_USER_ID;				//* {int} user ID
	global $_USER_PASSWORD; //! might be not good to keep it here
	global $_USER_LOGGED;   //* {checkLogin()}

	include("./utils.php");

	/**
	 * Init connection with the SQLite database
	 */
	function getDatabase() {
		global $_DB_CONNEXION; 	//* {any} connection status

		$__SERVER = "localhost";
		$_USERNAME = "root"; // hmm
		$_PASSWORD = "root"; // hmmmmmmmmmm
		$_DBNAME = "index";

		$_DB_CONNEXION = new mysqli(
			$__SERVER,
			$_USERNAME,
			$_PASSWORD,
			$_DBNAME
		);

		if ($_DB_CONNEXION->connect_error) {
			die ("Connection failed: " . $_DB_CONNEXION->connect_error);
			$_DB_CONNEXION = null;
		};
	};

	/**
	 * Check if the user can be connected
	 */
	function checkLogin() {
		global $_DB_CONNEXION; 	//* {any} connection status
		global $_USER_NAME;			//* {string} user name
		global $_USER_ID;				//* {int} user ID
		global $_USER_PASSWORD; //! might be not good to keep it here

		$_ERR = null;
		$_RES = false;
		$_ATTEMPT = false;

		// data received with the form
		if (isset($_POST["username"]) && isset($_POST["password"])) {
			$_USER_NAME = stringify($_POST["username"]);
			$_USER_PASSWORD = md5($_POST["password"]);
			$_ATTEMPT = true;
		}

		// data received from cookie
		elseif (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
			$_USER_NAME = $_COOKIE["username"];
			$_USER_PASSWORD = $_COOKIE["password"];
			$_ATTEMPT = true;
		}

		if ($_ATTEMPT && !$_DB_CONNEXION) {
			$_DB_QUERY = "SELECT * FROM login WHERE username = '" . $_USER_NAME . "' AND password '" . $_USER_PASSWORD . "'";
			$_DB_RES = $_DB_CONNEXION->query($_DB_QUERY);

			if ($_DB_RES) {
				$_ROW = $_DB_RES->fetch_assoc();
				$_USER_ID = $_ROW["id"];
				$_RES = true;
				updateCookie($_USER_NAME, $_USER_PASSWORD);
			} 
			else $_ERR = "Username/Password are invalid or does not exist :/";
		}

		return array($_RES, $_ATTEMPT, $_ERR, $_USER_ID);
	};

	getDatabase();
	$_USER_LOGGED = checkLogin();

	// html parts
	include("./php/multipart/index.php");
?>