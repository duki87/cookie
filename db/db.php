<?php
  $host = 'localhost';
  $database = 'cookie';
  $user = 'root';
  $pass = '';
  try {
      $connect = new PDO("mysql:host={$host};dbname={$database};charset=utf8", $user, $pass);
  } catch (Exception $e) {
      echo $e->getMessage();
  }
?>
