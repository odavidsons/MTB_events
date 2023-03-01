<?php
include_once '../conexao.php';
session_start();
//verificar
if (!isset($_SESSION['ligado'])):
  header('Location: editar_evento_imagem.php');
endif;

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $select = "SELECT imagem FROM eventos WHERE id='$id'";
  $imagem = "";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar imagem</title>
  <link rel="stylesheet" href="../../css/utilizadores.css">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>

  <div class="sidebar">
    <h1>Menu</h1>
    <hr>
    <?php
    if ($_SESSION['usertype'] == 1) {
      echo '<a href="../../centro.php">Início</a>';
      echo '<a href="../../utilizadores.php">Utilizadores</a>';
      echo '<a href="../../eventos.php">Eventos</a>';
      echo '<div class="exit"><a href="../logout.php">Sair</a></div>';
    } else {
      echo '<div class="exit"><a href="../logout.php">Sair</a></div>';
    }
    ?>
  </div>

  <div class="main">
    <div class="content" id="editar">
      <form class="criar_utilizador" action="upload_imagem.php" method="POST" enctype="multipart/form-data">
        <div class="caixa_registo">
          <input type="hidden" value="<?php echo $id ?>" name="update_id" id="update_id">
        </div>
        <label for="file">Imagem atual:
          <?php echo $imagem ?>
        </label>
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