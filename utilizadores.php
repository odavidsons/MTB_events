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
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Centro de administrador</title>
  <link rel="stylesheet" href="css/utilizadores.css">
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
      echo '<div class="exit"><a href="includes/logout.php">Sair</a></div>';
    } else {
      echo '<div class="exit"><a href="includes/logout.php">Sair</a></div>';
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
    <button type="button" class="collapsible">Criar utilizadores</button>
    <div class="content">
      <form class="criar_utilizador" action="includes/add_utilizador.php" method="POST">
        <div class="caixa_registo">
          <input type="text" name="nome" placeholder="Nome" required />
        </div>
        <div class="caixa_registo">
          <input type="email" name="email" placeholder="Email" required />
        </div>
        <div class="caixa_registo">
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <div class="caixa_registo">
          <button class="btn_registo" name="btn_registo" type="submit">Adicionar</button>
        </div>
      </form>
    </div>

    <button type="button" class="collapsible">Lista de utilizadores</button>
    <div class="content">
      <?php
      require_once 'includes/conexao.php';
      $conn = mysqli_connect('localhost', 'root', '') or die("Erro na ligação");
      mysqli_select_db($conn, 'dcweventos') or die("Erro na selecção");
      $consulta = "SELECT * FROM users";
      $resultado = mysqli_query($conn, $consulta) or die("Erro na consulta");
      $nregistos = mysqli_num_rows($resultado);
      echo "Numero de Utilizadores: $nregistos ";
      ?>

      <table class="table">
        <thead class="table-dark">
          <tr>
            <th>ID</td>
            <th>Nome</td>
            <th>Email</td>
            <th>Password</td>
            <th>Tipo</td>
            <th>Ativo</td>
            <th colspan="2">Ações</td>
          </tr>
        </thead>
        <?php
        for ($i = 0; $i < $nregistos; $i++) {
          $registo = mysqli_fetch_assoc($resultado);
          echo '<tbody>';
          echo '<tr>';
          echo '<th>' . $registo['id'] . '</td>';
          echo '<td>' . $registo['username'] . '</td>';
          echo '<td>' . $registo['email'] . '</td>';
          echo '<td>' . $registo['password'] . '</td>';
          if ($registo['tipo'] === '1') {
            echo '<td>Administrador</td>';
          } else {
            echo '<td>Normal</td>';
          }
          if ($registo['ativo'] === '1') {
            echo '<td>Sim</td>';
          } else {
            echo '<td>Não</td>';
          }
          echo "<td><a href='includes/remover.php?id=" . $registo['id'] . "'><button type='button' id='remover' class='btn btn-danger editbtn'> Remover </button></a></td>";
          echo "<td><a href='includes/editar.php?id=" . $registo['id'] . "'><button type='button'class='btn btn-primary editbtn'> Editar </button></a></td>";
          echo '</tr>';
          echo '</tbody>';
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