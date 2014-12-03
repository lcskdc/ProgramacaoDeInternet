<?php
ini_set("display_errors","on");
error_reporting(E_ALL);
require_once("login.php");
require_once("cabecalho.php");

$email = $apelido = "";

if(isset($_POST['email'])&&isset($_POST['senha'])&&isset($_POST['confirma_senha'])) {
  require_once("class/class.Conexao.php");
  $email = trim($_POST['email']);
  $apelido = trim($_POST['apelido']);
  $senha = md5(trim($_POST['senha']));
  $confirma_senha = md5(trim($_POST['confirma_senha']));
  
  $Conexao = new Conexao();
  $sql = "SELECT * FROM usuario u WHERE u.usuario = '$email'";
  $result = $Conexao->executa($sql);
  $r = array();
  
  $regexEmail = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
  
  if(strlen($apelido)<5) {
    $r[] = "O apelido deve contér no mínimo 5 caracteres";
  } elseif(!preg_match($regexEmail,$email)) {
    $r[] = "Informe um e-mail válido";
  } elseif(count($result)>0) {
    $r[] = "Usuário já cadastrado";
  } elseif(strlen($_POST['senha'])<6) {
    $r[] = "Informe uma senha válida de até 6 caracteres";
  } elseif($senha!=$confirma_senha) {
    $r[] = "A senha e a confirmação não são iguais";
  } else {
    $sql = "INSERT INTO usuario (apelido, usuario, senha, cadastro) VALUES ('$apelido','$email','$senha',NOW())";
    $Conexao->executa($sql);
    header("location:index.php");
  }
  unset($Conexao);
  
}
?>
<form name="cadastro" id="cadastro" method="post">
  <?php if(isset($r)) { ?>
  <p>
    <?php echo implode('<br />',$r); ?>
  </p>
  <?php } ?>
  <p>
    <label for="apelido">Apelido:</label>
    <input type="text" name="apelido" id="apelido" value="<?php echo $apelido?>" />
  </p>
  <p>
    <label for="email">Email:</label>
    <input type="text" name="email" id="email" value="<?php echo $email?>" />
  </p>
  <p>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" value="" />
  </p>
  <p>
    <label for="senha">Senha:</label>
    <input type="password" name="confirma_senha" id="confirma_senha" value="" />
  </p>  
  <p>
    <input type="submit" name="enviar" value="Cadastrar" />&nbsp;<a href="index.php">Voltar</a>
  </p>
</form>

<?php
require_once("rodape.php");