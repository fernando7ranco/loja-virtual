<?php
session_start();
session_destroy();
setcookie("undefined",$_COOKIE['undefined'], time()-60*60*24*100, "/");
unset($_COOKIE["undefined"]);
header('location:inicio');
?>