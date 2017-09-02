<?php
session_start();//세션 선언

unset($_SESSION['adminlogin']);
//session_destroy();//세션 초기화 시 사용

header("Location: content.php");
?>