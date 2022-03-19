<?php

	/**
	 * Init connection with the SQLite database
	 */
	function getUsersDatabase() {
		global $_DB_CONNEXION; 	//* {any} connection status

		$_DB_CONNEXION = new mysqli(
			"localhost",
			"root",
			"root",
			"users",
			3306
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
		$_DB_RES = null;

		// data received with POST request
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

		if ($_ATTEMPT && $_DB_CONNEXION) {
			// register attempted
			if (isset($_POST["register"]) == "on") {

				// detect if the username is already taken
				if ($_DB_CONNEXION->query("SELECT * FROM `user` WHERE username = '$_USER_NAME'")) {
					$_ERR = "This is username is already taken!";
				}

				// create the entry otherwise
				else {
					if (strlen($_POST["username"]) < 3) $_ERR = "Username must be at least 3 characters longs.";
					else {
						$_DB_CONNEXION->query("INSERT INTO `user` VALUES (NULL, '$_USER_NAME', '$_USER_PASSWORD', '', 0, '')");									// create user data
						$_DB_RES = $_DB_CONNEXION->query("SELECT * FROM `user` WHERE username = '$_USER_NAME' AND password '$_USER_PASSWORD'");	// request the created data
					}
				}
			}

			// login attempted
			else {
				$_DB_RES = $_DB_CONNEXION->query("SELECT * FROM `user` WHERE username = '$_USER_NAME' AND password '$_USER_PASSWORD'");			// request the data
			}

			if ($_DB_RES) {
				/* fetch associative array */
				$_ROW = $_DB_RES->fetch_assoc(); // todo: find why it returns NULL and not the result from MySQL

				$_USER_ID = $_ROW["id"]; // generate errors (see above todo)
				$_RES = true;
				if (isset($_POST["remember"]) == "on") updateCookie($_USER_NAME, $_USER_PASSWORD, null);
			}
			else $_ERR = "Username/Password are invalid or does not exist :/";
		}

		return array($_RES, $_ATTEMPT, $_ERR, $_USER_ID);
	};
?>