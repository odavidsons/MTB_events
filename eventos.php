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
  <title>Centro de administrador</title>
  <link rel="stylesheet" href="css/eventos.css">
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
    <button type="button" class="collapsible">Criar Eventos</button>
    <div class="content">
      <form class="criar_utilizador" action="includes/add_eventos.php" method="POST" enctype="multipart/form-data">
        <div class="caixa_registo">
          <input type="text" name="nome" placeholder="Nome" required />
        </div>
        <div class="caixa_registo">
          <input type="text" name="local" placeholder="Localização" required />
        </div>
        <div class="caixa_registo">
          <input type="date" name="data" placeholder="Data" required />
        </div>
        <div class="caixa_registo">
          <input type="number" name="vagas" placeholder="Vagas" required />
        </div>
        Selecione uma imagem:
        <input type="file" name="image" accept=".jpeg,.jpg,.png" />
        <div class="caixa_registo">
          <button class="btn_registo" name="btn_registo" type="submit">Adicionar</button>
        </div>
      </form>
    </div>

    <button type="button" class="collapsible">Lista de Eventos</button>
    <div class="content">
      <?php
      require_once 'includes/conexao.php';
      $conn = mysqli_connect('localhost', 'username', 'password') or die("Erro na ligação");
      mysqli_select_db($conn, 'dcweventos') or die("Erro na selecção");
      $consulta = "SELECT * FROM eventos";
      $resultado = mysqli_query($conn, $consulta) or die("Erro na consulta");
      $nregistos = mysqli_num_rows($resultado);
      ?>

      <table class="table">
        <thead class="table-dark">
          <tr>
            <th>ID</td>
            <th>Nome</td>
            <th>Localização</td>
            <th>Data</td>
            <th>Vagas</td>
            <th>Ativo</td>
            <th>Participantes</td>
            <th colspan="3">Ações</td>

          </tr>
        </thead>
        <?php
        for ($i = 0; $i < $nregistos; $i++) {
          $registo = mysqli_fetch_assoc($resultado);
          echo '<tbody>';
          echo '<tr>';
          echo '<th>' . $registo['id'] . '</td>';
          echo '<td>' . $registo['nome'] . '</td>';
          echo '<td>' . $registo['local'] . '</td>';
          echo '<td>' . $registo['data'] . '</td>';
          echo '<td>' . $registo['vagas'] . '</td>';
          if ($registo['ativo'] === '1') {
            echo '<td>Sim</td>';
          } else {
            echo '<td>Não</td>';
          }
          echo '<th></td>';
          echo "<td><a href='includes/remover_evento.php?id=" . $registo['id'] . "'><button type='button'class='btn btn-danger editbtn'> Remover </button></a></td>";
          echo "<td><a href='includes/editar_evento.php?id=" . $registo['id'] . "'><button type='button'class='btn btn-primary editbtn'> Editar </button></a></td>";
          echo "<td><a href='includes/editar_evento_imagem.php?id=" . $registo['id'] . "'><button type='button'class='btn btn-secondary editbtn'>Mudar Imagem</button></a></td>";
          echo '</tr>';
          echo '</tbody>';
        }
        mysqli_close($conn);
        ?>
        </form>
      </table>
    </div>


        
  <button type="button" class="collapsible">Inscrições</button>
    <div class="content">
      <?php
      require_once 'includes/conexao.php';
      $conn = mysqli_connect('localhost', 'username', 'password') or die("Erro na ligação");
      mysqli_select_db($conn, 'dcweventos') or die("Erro na selecção");
      $consulta = "SELECT * FROM users_eventos";
      $resultado = mysqli_query($conn, $consulta) or die("Erro na consulta");
      $nregistos = mysqli_num_rows($resultado);
      ?>

      <table class="table">
        <thead class="table-dark">
          <tr>
            <th>ID de inscrição</td>
            <th>ID de Evento</td>
            <th>ID Utilizador</td>
            <th colspan="3">Ações</td>

          </tr>
        </thead>
        <?php
        for ($i = 0; $i < $nregistos; $i++) {
          $registo = mysqli_fetch_assoc($resultado);
          if ($registo['ativo'] ==1){
          echo '<tbody>';
          echo '<tr>';
          echo '<th>' . $registo['id'] . '</td>';
          echo '<td>' . $registo['id_evento'] . '</td>';
          echo '<td>' . $registo['id_user'] . '</td>';
          echo '<th></td>';
          echo "<td><a href='includes/remover_inscricao.php?id=" . $registo['id'] . "'><button type='button'class='btn btn-danger editbtn'> Remover </button></a></td>";
          echo '</tr>';
          echo '</tbody>';
          }
        }
        mysqli_close($conn);
        ?>
        </form>
      </table>
    </div>
  </div>

  <!--script para abrir caixas colapsáveis-->
  <script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }
  </script>

</body>

</html>
