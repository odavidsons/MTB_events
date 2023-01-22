<?php
//conexao
require_once 'includes/conexao.php';
//sessao
session_start();
if (isset($_POST['btn_login'])):
  $erros = array();
  $email = mysqli_escape_string($conn, $_POST['email']);
  $password = mysqli_escape_string($conn, $_POST['password']);

  if (empty($email) or empty($password)):
    $erros[] = "<li> Precisa de introduzir o email e a password </li>";
  else:
    $sql = "SELECT email FROM users WHERE email = '$email' AND ativo = '1'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0):
      $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
      $resultado = mysqli_query($conn, $sql);
      if (mysqli_num_rows($resultado) == 1):
        $dados = mysqli_fetch_array($resultado);
        mysqli_close($conn);
        $admin = "SELECT tipo FROM users WHERE email = '$email' AND password = '$password'";
        $_SESSION['usertype'] = $dados['tipo'];
        $_SESSION['ligado'] = true;
        $_SESSION['id_utilizador'] = $dados['id'];
        $_SESSION['session_name'] = $dados['username'];
        header('Location: centro.php');

      else:
        $erros[] = "<li> Utilizador ou password errado!</li>";
      endif;
    else:
      $erros[] = "<li> Esse utilizador não existe ou está desativado!</li>";
    endif;
  endif;
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestor de eventos</title>
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <div id="bg"></div>

  <div>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <h1>Bem vindo</h2>
        <?php
        if (!empty($erros)):
          foreach ($erros as $erro):
            echo $erro;
          endforeach;
        endif;
        ?>
        <div class="caixa_login">
          <input type="email" name="email" placeholder="Email" required />
        </div>

        <div class="caixa_login">
          <input type="password" name="password" placeholder="Password" required />
        </div>

        <div class="caixa_login">
          <button class="btn_login" name="btn_login" type="submit">Entrar</button>
        </div>
        <p>Não tem conta? <a href="registar.php">Registar-se</a></p>
    </form>
  </div>
</body>

</html>
