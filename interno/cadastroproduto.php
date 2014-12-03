<?php
require_once("controle.php");
$Conexao = new Conexao();
$descricao = $resenha = $r = $idsecao = "";

$sql = "SELECT * FROM secao ORDER BY descricao";
$secoes = $Conexao->executa($sql);

if(isset($_POST['enviar'])) {
  
  $descricao = $_POST['descricao'];
  $resenha = $_POST['resenha'];
  $idsecao = $_POST['secao'];
  
  
  if(strlen($descricao)<5) {
    $r .= "Você deve informar a descrição<br />";
  }
  
  if($idsecao==0) {
    $r .= "Você deve informar a seção.<br />";
  }
  
  $sql = "SELECT * FROM produto WHERE descricao = '$descricao'";
  $lista = $Conexao->executa($sql);
  if($lista) {
    $r .= "Já existe um produto cadastrado com este nome<br />";
  }
  
  
  if($r=="") {  
    $sql = "INSERT INTO produto (descricao, resenha, idusuario, idsecao) VALUES ('$descricao','$resenha','$idusuario','$idsecao')";
    $Conexao->executa($sql);
    header("location:listaproduto.php");
  }
  
}

?>
<form name="frmProduto" id="frmProduto" method="post">
  <?php if($r!="") { ?>
  <p class="msg_erro">
    <?php echo $r?>
  </p>
  <?php } ?>
  <p>
    <label for="descricao">Descrição: </label>
    <input type="text" name="descricao" id="descricao" value="<?php echo $descricao?>" />
  </p>
  <p>
    <label for="resenha">Resenha: </label>
    <textarea name="resenha" id="resenha"><?php echo $resenha?></textarea>
  </p>
  <p>
    <label for="secao">Seção: </label>
    <select name="secao" id="secao">
      <option value="0">Selecione</option>
      <?php foreach($secoes as $key => $secao) { ?>
        <option value="<?php echo $secao['id']?>"<?php echo $idsecao==$secao['id']?' selected':''?>><?php echo $secao['descricao']?></option>
      <?php } ?>
    </select>
  </p>
  <p>
    <input type="submit" name="enviar" value="Salvar" />
  </p>
</form>
<?php
unset($Conexao);
require_once("../rodape.php");