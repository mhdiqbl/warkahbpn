<?php 
session_start();

session_destroy();
echo "<script>alert('ANDA TELAH LOGOUT');</script>";
echo "<script>location='../index.php';</script>";
 ?>