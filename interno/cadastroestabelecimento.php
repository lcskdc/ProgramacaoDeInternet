<?php
require_once("controle.php");
$Conexao = new Conexao();
$endereco = $nome = $r = $msgok = "";

$sql = "SELECT * FROM secao ORDER BY descricao";
$secoes = $Conexao->executa($sql);

if(isset($_POST['enviar'])) {
  
  $nome = $_POST['nome'];
  $endereco = $_POST['endereco'];
  
  if(strlen($nome)<5) {
    $r .= "Você deve informar o nome<br />";
  }
  
  if(strlen($endereco)<5) {
    $r .= "Você deve informar o endereço.<br />";
  }
  
  $sql = "SELECT * FROM estabelecimento WHERE nome = '$nome'";
  $lista = $Conexao->executa($sql);
  
  if($lista) {
    $r = "Estabelecimeto já cadastrado.<br />";
  }
  
  if($r=="") {  
    $sql = "INSERT INTO estabelecimento (nome, endereco) VALUES ('$nome','$endereco')";
    $Conexao->executa($sql);
    $nome = $endereco = "";
    $msgok = "Estabelecimento cadastrado com sucesso.";
  }
  
}

?>
<form name="frmEstabelecimento" id="frmEstabelecimento" method="post">
  <?php if($r!="") { ?>
  <p class="msg_erro">
    <?php echo $r?>
  </p>
  <?php } ?>
  <p>
    <label for="nome">Nome: </label>
    <input type="text" name="nome" id="nome" value="<?php echo $nome?>" />
  </p>
  <p>
    <label for="endereco">Endereço: </label>
    <input type="text" name="endereco" id="endereco" value="<?php echo $endereco?>" />
  </p>
  <p>
    <input type="submit" name="enviar" value="Salvar" />
  </p>
</form>


<?php if($msgok!="") { ?>
<script language="javascript">
  alert('<?php echo $msgok?>');
</script>
<?php } ?>

<?php
unset($Conexao);
require_once("../rodape.php");