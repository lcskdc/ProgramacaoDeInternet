<?php
require_once("controle.php");
$descricao = $resenha = "";

$Conexao = new Conexao();
$sql = "SELECT
            count(item.id) as itens,
            lista.id,
            lista.data,
            estab.nome
        FROM lista
            JOIN estabelecimento estab ON estab.id = lista.estabelecimento
            JOIN itemlista item ON item.lista = lista.id
        WHERE lista.usuario = '$idusuario'";
$lista = $Conexao->executa($sql);

if($lista) {
?>
<table border="1" cellpadding="4">
  <tr class="trCab">
    <td>id</td>
    <td>Data</td>
    <td>Estabelecimento</td>
    <td>Itens</td>
  </tr>
<?php foreach($lista as $key => $produto) { ?>
<tr class="trItem">
  <td><?php echo $produto['id']?></td>
  <td><?php echo $produto['data']?></td>
  <td><?php echo $produto['nome']?></td>
  <td><a class="itens" href="#self" rel="<?php echo $produto['id']?>"><?php echo $produto['itens']?></a></td>
</tr>
<?php } ?>
</table>
<script language="javascript">
  $('.itens').click(function(){
    var jnl = window.open('itens.php?lista='+$(this).attr('rel'),'jnl','width=550,height=300');
    if(jnl) jnl.focus();
  });
</script>
<?php
} else {
  echo '<p>Não há listas cadastradas</p>';
}

require_once("../rodape.php");