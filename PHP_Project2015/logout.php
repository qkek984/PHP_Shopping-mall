<?php
session_start();//세션 선언

unset($_SESSION['login']);

header("Location: content.php");
?>