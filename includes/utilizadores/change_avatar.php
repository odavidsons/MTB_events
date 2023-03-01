<?php
include_once '../conexao.php';
$id = $_POST['update_id'];
$file = $_FILES['image'];

$filename = $_FILES['image']['name'];
$filetmpname = $_FILES['image']['tmp_name'];
$filesize = $_FILES['image']['size'];
$fileerror = $_FILES['image']['error'];
$filetype = $_FILES['image']['type'];

$fileext = explode('.', $filename);
$fileactualext = strtolower(end($fileext));

$allowed = array('jpg', 'jpeg', 'png');
if ($_FILES['image']['name'] != "") {
    if (in_array($fileactualext, $allowed)) {
        if ($fileerror === 0) {
            if ($filesize < 1000000) {
                $filenamenew = uniqid('', true) . "." . $fileactualext;
                $filedestination = '../../images/' . $filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
                $sql = "UPDATE users SET imagem='$filenamenew' WHERE id='$id'";
                mysqli_query($conn, $sql);
                header("Location: ../../perfil.php?atualizado=sucesso");

            } else {
                echo 'A imagem é demasiado grande.';
            }
        } else {
            echo 'Ocorreu um erro com o ficheiro.';
        }
    } else {
        echo 'Tipo de ficheiro não suportado.';
    }
} else {
    header("Location: ../../perfil.php?imagem_invalida");
}


?>