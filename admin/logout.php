<?php 
// session_start()
include '../users/functions.php';
session_destroy();
// print_r($_SESSION);die;
header('location: ../index.php');

?>