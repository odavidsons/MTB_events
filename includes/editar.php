<?php
//conexao
require_once 'conexao.php';
//sessao
session_start();
//verificar
if (!isset($_SESSION['ligado'])):
  header('Location: editar.php');
endif;

$username= "";
$email= "";
$password= "";
$tipo= "";
$ativo= "";
if (isset($_GET['id'])){
  $id = $_GET['id'];
  $select= mysqli_query($conn,  "SELECT * FROM users WHERE id=$id");
  $data= mysqli_fetch_assoc($select);
  $username= $data['username'];
  $email= $data['email'];
  $password= $data['password'];
  $tipo= $data['tipo'];
  $ativo= $data['ativo'];
}

if (isset($_POST['btn_editar'])){
  $id = $_POST['update_id'];
  $username= $_POST['username'];
  $email= $_POST['email'];
  $password= $_POST['password'];
  $tipo= $_POST['tipo'];
  $ativo= $_POST['ativo'];

  $query= "UPDATE users SET username='$username',email='$email',password='$password', tipo='$tipo', ativo='$ativo' WHERE id='$id'";
  $query_run = mysqli_query($conn, $query);
  mysqli_query($conn, $query);
  if($query_run)
        {
            echo '<script> alert("Dados atualizados"); </script>';
            header("Location: ../utilizadores.php");
        }
        else
        {
            echo '<script> alert("Falha no processo"); </script>';
            header("Location: ../utilizadores.php");
        }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar utilizador</title>
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
      
        <div class="caixa_registo">
          <input type="text" value="<?php echo $username ?>" name="username" placeholder="" required />
        </div>
        <div class="caixa_registo">
        <input type="email" value="<?php echo $email ?>" name="email" placeholder="" required />
        </div>
        <div class="caixa_registo">
        <input type="password" value="<?php echo $password ?>" name="password" placeholder="" required />
        </div>
        <div class="caixa_registo">
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo">
          <option value="<?php if ($tipo==1){echo "0";}else{echo "1";} ?>"><?php if ($tipo==0){echo "Administrador";}else{echo "Normal";} ?></option>
          <option value="<?php echo$tipo?>" selected><?php if ($tipo==1){echo "Administrador";}else{echo "Normal";} ?></option>
        </select>
        </div>
        <div class="caixa_registo">
        <label for="ativo">Ativo:</label>
        <select name="ativo" id="ativo">
          <option value="<?php if ($ativo==1){echo "0";}else{echo "1";} ?>"><?php if ($ativo==0){echo "Sim";}else{echo "Não";} ?></option>
          <option value="<?php echo$ativo?>" selected><?php if ($ativo==1){echo "Sim";}else{echo "Não";} ?></option>
        </select>
        </div>
        <div class="caixa_registo">
          <button class="btn_registo" name="btn_editar" type="submit">Atualizar</button>
        </div>
      </form>
      
    </div>    
</div>

</body>

</html>