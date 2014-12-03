<?php
require_once("controle.php");
$descricao = $resenha = "";

$Conexao = new Conexao();
$sql = "SELECT p.id, p.descricao, p.resenha, s.descricao as secao, u.apelido FROM produto p "
    . " JOIN secao s ON s.id = p.idsecao "
    . " JOIN usuario u ON u.id = p.idusuario "
    . "ORDER BY idusuario = $idusuario ASC";
$lista = $Conexao->executa($sql);

if($lista) {
?>
<table border="1" cellspacing="0" cellpadding="4">
  <tr class="trCab">
    <td>Descrição</td>
    <td>Resenha</td>
    <td>Seção</td>
    <td>Apelido</td>
  </tr>
<?php foreach($lista as $key => $produto) { ?>
<tr class="trItem">
  <td><?php echo $produto['descricao']?></td>
  <td><?php echo $produto['resenha']?></td>
  <td><?php echo $produto['secao']?></td>
  <td><?php echo $produto['apelido']?></td>
</tr>
<?php } ?>
</table>
<?php
} else {
  echo '<p>Não há itens cadastrados</p>';
}

require_once("../rodape.php");