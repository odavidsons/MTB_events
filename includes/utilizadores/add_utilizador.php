<?php
require_once '../conexao.php';
$nome = $_POST['nome'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO users (username,email, password) VALUES ('$nome','$email','$password')";
mysqli_query($conn, $sql);
header("Location: ../../utilizadores.php?criado=sucesso");
?>