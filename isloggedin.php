<?php

function isloggedin(){
    return isset($_SESSION["user"]);
}

?>
