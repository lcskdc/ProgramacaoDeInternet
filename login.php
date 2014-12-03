<?php
$email = '';
 
if(isset($_POST['enviar'])){
  require_once("class/class.Conexao.php");
  $email = $_POST['email'];
  $senha = md5($_POST['senha']);
  
  $Conexao = new Conexao();
  $sql = "SELECT * FROM usuario WHERE usuario = '$email' AND senha = '$senha'";
  $retorno = $Conexao->executa($sql);
  if($retorno) {
    session_start();
    $_SESSION['mol']['id'] = $retorno[0]['id'];
    $_SESSION['mol']['usuario'] = $email;
    $_SESSION['mol']['acesso'] = mktime();
    header('location:/interno/');
  } else {
    $r = "Usuário e/ou senha inválidos.";
  }
  unset($Conexao);
  
}