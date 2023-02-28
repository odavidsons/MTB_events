<?php
//conexao
require_once 'includes/conexao.php';
//sessao
session_start();
//verificar
if (!isset($_SESSION['ligado'])):
   header('Location: perfil.php');
endif;
//dados do utilizador
$id = $_SESSION['id_utilizador'];
$sql = "SELECT * FROM users WHERE id = '$id'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);


$username= "";
$email= "";
$password= "";
$tipo= "";
$ativo= "";

if (isset($_POST['btn_editar'])){
   $username= $_POST['utilizador'];
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
             header("Location: perfil.php");
         }
         else
         {
             echo '<script> alert("Falha no processo"); </script>';
             header("Location: perfil.php");
         }
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Perfil</title>
   <link rel="stylesheet" href="css/perfil.css">
   <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

   <div class="sidebar">
      <h1>Menu</h1>
      <hr>
      <?php
      if ($_SESSION['usertype'] == 1) {
         echo '<a href="centro.php">Início</a>';
         echo '<a href="utilizadores.php">Utilizadores</a>';
         echo '<a href="eventos.php">Eventos</a>';
         echo '<div class="perfil"><a href="perfil.php">Perfil</a></div>';
         echo '<div class="exit"><a href="includes/logout.php">Sair</a></div>';
      } else {
        echo '<a href="centro.php">Início</a>';
        echo '<div class="perfil"><a href="perfil.php">Perfil</a></div>';
         echo '<a class="exit" href="includes/logout.php">Sair</a>';
      }
      ?>
   </div>

   <div class="topbar">
         <p>Está em modo de
            <?php
            if ($_SESSION['usertype'] == 1) {
               echo 'administrador';
            } else {
               echo 'acesso normal';
            }
            ?>
         </p>
         <p>Utilizador: <?php echo $_SESSION['session_name']?></p>
   </div>
   <div class="main">
     <div class="form">
     <form class="editar_perfil" action="" method="POST">
       <div class="avatar">
         <a href="includes/change_avatar.php?id=<?php echo $id ?>"><img src="images/avatar.png" id="avatar" alt=""></a>
       </div>
       <label for="fullName">Nome</label>
       <input type="text" class="form-control" id="fullName" name="utilizador" value="<?php echo $dados['username'] ?>">
       <label for="fullName">Email</label>
       <input type="text" class="form-control" id="fullName" name="email" value="<?php echo $dados['email'] ?>">
       <label for="fullName">Password</label>
       <input type="password" class="form-control" id="fullName" name="password" value="<?php echo $dados['password'] ?>">
       <input type="hidden" value="<?php echo $dados['tipo'] ?>" name="tipo" id="tipo">
       <input type="hidden" value="<?php echo $dados['ativo'] ?>" name="ativo" id="ativo">
       <label for="fullName">Data de registo</label>
       <p><?php echo $dados['registration_date'] ?></p>
       <div class="caixa_registo">
         <button class="btn_registo" name="btn_editar" type="submit">Atualizar</button>
       </div>
         </form>
     </div>


   </div>

</body>

</html>
