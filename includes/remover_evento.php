<?php
$id = $_GET['id'];

require_once 'conexao.php';
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM eventos WHERE id = $id"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: ../eventos.php'); 
    exit;
} else {
    echo "Error deleting record";
}
?>