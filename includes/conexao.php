<?php
$servername = "localhost";
$username = "username";
$password = "password";
$db = "dcweventos";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (mysqli_connect_error()):
  echo "Falha de conexão: " . mysqli_connect_error();
endif;

?>