<?php
    include_once 'conexao.php';
    $username = $_POST['utilizador'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password');";
    mysqli_query($conn, $sql);
    header("Location: ../index.php?registado=sucesso");
?>
