<?php
    include_once 'conexao.php';
    $nome = $_POST['nome'];
    $local = $_POST['local'];
    $data = $_POST['data'];
    $vagas = $_POST['vagas'];

    $file = $_FILES['image'];

    $filename = $_FILES['image']['name'];
    $filetmpname = $_FILES['image']['tmp_name'];
    $filesize = $_FILES['image']['size'];
    $fileerror = $_FILES['image']['error'];
    $filetype = $_FILES['image']['type'];

    $fileext = explode('.', $filename);
    $fileactualext = strtolower(end($fileext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileactualext, $allowed)) {
        if ($fileerror === 0){
            if ($filesize < 1000000){
                $filenamenew = uniqid('', true).".".$fileactualext;
                $filedestination = '../images/'.$filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
                
            }else{
                echo 'A imagem é demasiado grande.';
            }
        }else {
            echo 'Ocorreu um erro com o ficheiro.';
        }
    }else {
        echo 'Tipo de ficheiro não suportado.';
    }
    $filenamenew = uniqid('', true).".".$fileactualext;
    $filedestination = '../images/'.$filenamenew;
    move_uploaded_file($filetmpname, $filedestination);
    $sql = "INSERT INTO eventos ". "(nome,local, data, vagas,imagem) "."VALUES ". "('$nome','$local','$data', '$vagas', '$filenamenew')";
    mysqli_query($conn, $sql);
    header("Location: ../eventos.php?criado=sucesso");

    
?>
