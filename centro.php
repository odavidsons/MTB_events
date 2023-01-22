<?php
//conexao
require_once 'includes/conexao.php';
//sessao
session_start();
//verificar
if (!isset($_SESSION['ligado'])):
   header('Location: centro.php');
endif;
//dados do utilizador
$id = $_SESSION['id_utilizador'];
$sql = "SELECT * FROM users WHERE id = '$id'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);
$_SESSION['session_name'] = $dados['username'];
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Centro de administração</title>
   <link rel="stylesheet" href="css/centro.css">
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
      <div class="welcome">
      <h1>Bem vindo ao centro de administração</h1>
      
      </div>
      <div class="eventos_ativos">
      <h3>Eventos ativos</h3>
         <?php
         require_once 'includes/conexao.php';
         $conn = mysqli_connect('localhost', 'root', '') or die("Erro na ligação");
         mysqli_select_db($conn, 'dcweventos') or die("Erro na selecção");
         $consulta = "SELECT * FROM eventos";
         $resultado = mysqli_query($conn, $consulta) or die("Erro na consulta");
         $nregistos = mysqli_num_rows($resultado);
         ?>
         <?php
         for ($i = 0; $i < $nregistos; $i++) {
            $registo = mysqli_fetch_assoc($resultado);
            if ($registo['ativo']==="1"){
            echo '<div class="card-deck">';
            echo '<div class="card text-center bg-dark mb-3 border-light mb-3" style="width: 18rem;">';
            echo '<div class="card-body">';
            echo '<img class="card-img-top" src="images/'.$registo['imagem'].'" alt="Card image cap">';
            echo '<h5 class="card-title">' . $registo['nome'] . '</h5>';
            echo '<p class="card-text">Localização: ' . $registo['local'] . '</p>';
            echo '<p class="card-text">Data: ' . $registo['data'] . '</p>';
            echo '<p class="card-text">Vagas: ' . $registo['vagas'] . '</p>';
            if ($registo['vagas']==0) {
               echo '<button type="button" class="btn btn-lg btn-secondary" disabled>Registar</button>';
            }
            else{
               $select= "SELECT * FROM users_eventos WHERE id_user = '$id'";
               $ifregistado = mysqli_query($conn, $select) or die("Erro na consulta");
               while($row = mysqli_fetch_assoc($ifregistado)){
                  if ($row['id_evento']==$registo['id'] && $row['ativo']==1){
                     $evento_registado = 1;
                  }
                  else{
                     $evento_registado = 0;
                  }
               }  
               if ($evento_registado==0){
                  echo '<a href="includes/registar_evento.php?id_evento=' . $registo["id"] .'><button type="button" class="btn btn-primary btn-lg">Registar</button></a>';
               }
               else{
                  echo '<button type="button" class="btn btn-lg btn-secondary" disabled>Registar</button>';
               }
            }
            echo '</div>';
            echo '<div class="card-footer">';
            echo '<small class="text-muted">Atualizado em '.$registo['last_update'].'</small>';
            echo '</div>';
            echo '</div>';
            }
         }
         echo '</div>';
         mysqli_close($conn);
         ?>
      
   </div>
   </div>
      <div class="eventos_passados">

      <h3>Eventos passados</h3>
      <?php
      require_once 'includes/conexao.php';
      $conn = mysqli_connect('localhost', 'root', '') or die("Erro na ligação");
      mysqli_select_db($conn, 'dcweventos') or die("Erro na selecção");
      $consulta = "SELECT * FROM eventos";
      $resultado = mysqli_query($conn, $consulta) or die("Erro na consulta");
      $nregistos = mysqli_num_rows($resultado);
      ?>
      <?php
      for ($i = 0; $i < $nregistos; $i++) {
         $registo = mysqli_fetch_assoc($resultado);
         if ($registo['ativo']==="0"){
         echo '<div class="card-deck">';
         echo '<div class="card text-center bg-dark mb-3 border-light mb-3" style="width: 18rem;">';
         echo '<div class="card-body">';
         echo '<img class="card-img-top" src="images/'.$registo['imagem'].'" alt="Card image cap">';
         echo '<h5 class="card-title">' . $registo['nome'] . '</h5>';
         echo '<p class="card-text">Localização: ' . $registo['local'] . '</p>';
         echo '<p class="card-text">Data: ' . $registo['data'] . '</p>';
         echo '<p class="card-text">Vagas: ' . $registo['vagas'] . '</p>';
         if ($registo['vagas']==0) {
            echo '<button type="button" class="btn btn-lg btn-secondary" disabled>Registar</button>';
         }
         else{
            echo '<a href="#"><button type="button" class="btn btn-secondary btn-lg">Large button</button></a>';

         }
         
         echo '</div>';
         echo '<div class="card-footer">';
         echo '<small class="text-muted">Atualizado em '.$registo['last_update'].'</small>';
         echo '</div>';
         echo '</div>';
         }
      }
      echo '</div>';
      mysqli_close($conn);
      ?>
      </div>
      <div class="eventos_inscritos">

      <h3>Eventos inscritos</h3>
      <?php
      require_once 'includes/conexao.php';
      $conn = mysqli_connect('localhost', 'root', '') or die("Erro na ligação");
      mysqli_select_db($conn, 'dcweventos') or die("Erro na selecção");
      
      ?>
      <?php
      
      $select= mysqli_query($conn, "SELECT * FROM users_eventos WHERE id_user = '$id'");
      $data= mysqli_fetch_assoc($select);
      $inscricoes = mysqli_num_rows($select);
      echo 'Esteve inscrito em '.$inscricoes. ' eventos';

         
         $consulta = "SELECT * FROM users_eventos LEFT JOIN eventos ON users_eventos.id_evento = eventos.id WHERE users_eventos.id_user='$id'";
         $resultado = mysqli_query($conn, $consulta) or die("Erro na consulta");

         while($row = mysqli_fetch_assoc($resultado)){
         
         echo '<div class="card-deck">';
         echo '<div class="card text-center bg-dark mb-3 border-light mb-3" style="width: 18rem;">';
         echo '<div class="card-body">';
         echo '<img class="card-img-top" src="images/'.$row['imagem'].'" alt="Card image cap">';
         echo '<h5 class="card-title">' . $row['nome'] . '</h5>';
         echo '<p class="card-text">Localização: ' . $row['local'] . '</p>';
         echo '<p class="card-text">Data: ' . $row['data'] . '</p>';
         echo '<p class="card-text">Vagas: ' . $row['vagas'] . '</p>';
         
         echo '</div>';
         echo '<div class="card-footer">';
         echo '<small class="text-muted">Atualizado em '.$row['last_update'].'</small>';
         echo '</div>';
         echo '</div>';
         }


      echo '</div>';
      mysqli_close($conn);
      ?>

</body>

</html>
