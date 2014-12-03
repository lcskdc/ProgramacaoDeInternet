<?php
ini_set("display_errors","on");
error_reporting(E_ALL);
require_once("login.php");
require_once("cabecalho.php");
?>
<form name="cadastro" id="cadastro" method="post">
  <!--p>
    <label for="apelido">Apelido:</label>
    <input type="text" name="apelido" id="apelido" value="<?php echo $apelido?>" />
  </p-->
  <p>
    <label for="email">Email:</label>
    <input type="text" name="email" id="email" value="<?php echo $email?>" />
  </p>
  <p>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" value="" />
  </p>
  <p>
    <input type="submit" name="enviar" value="Login" />
    <a href="cadastro.php">Cadastrar-se</a>
  </p>
</form>

<?php
require_once("rodape.php");