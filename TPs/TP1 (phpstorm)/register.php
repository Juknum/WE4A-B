<?php
    require("db.php");
    $accStatus = $SQLconn->newAccount();

if ($accStatus[1]){
    echo '<h3 class="successMessage">New account successfully created!</h3>';
}
elseif ($accStatus[0]){
    echo '<h3 class="errorMessage">'.$accStatus[2].'</h3>';
}
?>
