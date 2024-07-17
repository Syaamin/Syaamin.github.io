<?php

session_start();
unset($_SESSION["user_id"]);// where $_SESSION["name"] is your own variable. 
//if you do not have one use only this as follow *session_unset();*
session_destroy();
header("Location: index.php");

?>