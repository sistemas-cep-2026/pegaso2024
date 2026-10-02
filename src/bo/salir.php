<?php
session_start();
session_destroy();
$retring=$_REQUEST["retring"];
if($retring=="2"){
	header ("Location: login.php");
}else{
	header ("Location: login.php?error=1");
}

?>
