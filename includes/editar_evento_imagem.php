<?php
    include_once 'conexao.php';
    session_start();
    //verificar
    if (!isset($_SESSION['ligado'])):
      header('Location: editar_evento.php');
    endif;

    $nome= "";
    $local= "";
    $date= "";
    $vagas= "";
    $ativo= "";
    $imagem= "";


    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $select= mysqli_query($conn,  "SELECT * FROM eventos WHERE id=$id");
        $data= mysqli_fetch_assoc($select);
        $nome= $data['nome'];
        $local= $data['local'];
        $date= $data['data'];
        $vagas= $data['vagas'];
        $ativo= $data['ativo'];
        $imagem= $data['imagem'];
      }

      if (isset($_POST['btn_editar'])){

        if ($_FILES['image']['name'] !="")
        {
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
        $sql= "UPDATE eventos SET nome='$nome',local='$local',data='$date', vagas='$vagas', ativo='$ativo', imagem='$filenamenew' WHERE id='$id'";
        mysqli_query($conn, $sql);
        header("Location: ../eventos.php?mudado=sucesso");
        }else{
            header("Location: ../eventos.php?cancelado");
        }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar imagem</title>
  <link rel="stylesheet" href="../css/utilizadores.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>

  <div class="sidebar">
    <h1>Menu</h1>
    <hr>
    <?php
    if ($_SESSION['usertype'] == 1) {
      echo '<a href="../centro.php">Início</a>';
      echo '<a href="../utilizadores.php">Utilizadores</a>';
      echo '<a href="../eventos.php">Eventos</a>';
      echo '<div class="exit"><a href="logout.php">Sair</a></div>';
    } else {
      echo '<div class="exit"><a href="logout.php">Sair</a></div>';
    }
    ?>
  </div>

  <div class="main">
  <div class="content" id="editar">
      <form class="criar_utilizador" action="" method="POST">
      <div class="caixa_registo">
      <input type="hidden" value="<?php echo $id ?>" name="update_id" id="update_id">
        </div>
        <label for="file">Imagem atual: <?php echo $imagem ?></label>
        <img src="../images/<?php echo $imagem ?>" alt="" width="100"><br><br><br>

        <input type="file" name="image" accept=".jpeg,.jpg,.png" />

        <div class="caixa_registo">
          <button class="btn_registo" name="btn_editar" type="submit">Atualizar</button>
        </div>
      </form>

    </div>
</div>

</body>

</html>
