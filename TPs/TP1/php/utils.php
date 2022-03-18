<?php

/**
 * Validate strings for SQLite calls
 */
function stringify(String $_STR) {
  $_STR = trim($_STR);
  $_STR = stripslashes($_STR);
  $_STR = addslashes($_STR);
  return htmlspecialchars($_STR);
}

/**
 * Update user cookie with the given values
 */
function updateCookie(String $_USER_NAME, String $_USER_PASSWORD, Int $_TIME = time() * 24 * 3600) {
  setcookie("username", $_USER_NAME, $_TIME);
  setcookie("password", $_USER_PASSWORD, $_TIME);
}

?>