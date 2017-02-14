<?php
session_unset();
$_SESSION['status'] = 'logout';
header("location: /");
 ?>
