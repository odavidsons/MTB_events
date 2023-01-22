<?php
//conexao
require_once 'includes/conexao.php';

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

    <form action="includes/registar.php ?>" method="post">
      <h1>Criar conta</h2>
        <?php
        if (!empty($erros)):
          foreach ($erros as $erro):
            echo $erro;
          endforeach;
        endif;
        ?>
        <div class="caixa_login">
          <input type="text" name="utilizador" placeholder="Utilizador" required />
        </div>
        <div class="caixa_login">
          <input type="email" name="email" placeholder="Email" required />
        </div>

        <div class="caixa_login">
          <input type="password" name="password" placeholder="Password" required />
        </div>

        <div class="caixa_login">
          <button class="btn_login" name="btn_login" type="submit">Criar</button>
        </div>
        <p><a href="index.php">Voltar</a></p>
        
    </form>
  </div>
</body>

</html>
