<?php
include_once '../conexao.php';
session_start();
//verificar
if (!isset($_SESSION['ligado'])):
    header('Location: registar_evento.php');
endif;

$id = $_SESSION['id_utilizador'];
$username = $_SESSION['session_name'];
$id_evento = $_GET['id_evento'];
$select = mysqli_query($conn, "SELECT vagas FROM eventos WHERE id='$id_evento'");
$data = mysqli_fetch_assoc($select);
if ($data['vagas'] > 0) {
    $vagas = $data['vagas'] - 1;
} else {
    $vagas = $data['vagas'];
}


$query = "INSERT INTO users_eventos (id_user, id_evento) VALUES ('$id', '$id_evento')";
$query_run = mysqli_query($conn, $query);

if ($query_run) {

    echo '<script> alert("Registado com sucesso"); </script>';
    $query = "UPDATE eventos SET vagas='$vagas' WHERE id='$id_evento'";
    $query_run = mysqli_query($conn, $query);
    header("Location: ../../centro.php?registado com sucesso");
} else {
    echo '<script> alert("Falha no registo"); </script>';
    header("Location: ../../centro.php?erro de registo");
}
?>