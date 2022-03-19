<?php
	global $_DB_CONNEXION; 	//* {any} connection status
	global $_USER_NAME;			//* {string} user name
	global $_USER_ID;				//* {int} user ID
	global $_USER_PASSWORD; //! might be not good to keep it here
	global $_USER_LOGGED;   //* {checkLogin()}

	include("./php/utils.php");
  include("./php/database.php");

	getUsersDatabase();
	$_USER_LOGGED = checkLogin();

	// html parts
	include("./php/multipart/index.php");
?>