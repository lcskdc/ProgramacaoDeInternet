<?php
$naoExibeMenu = true;
require_once("controle.php");
$idlista = $_GET['lista'];

$Conexao = new Conexao();
$sql = "SELECT
            produto.descricao as produto,
            produto.resenha,
            preco.preco,
            preco.data,
            secao.descricao as secao
        FROM itemlista item
            JOIN precolista preco ON preco.item = item.id AND preco.usuario = '$idusuario'
            JOIN produto ON produto.id = item.produto
            JOIN secao ON secao.id = produto.idsecao
            JOIN lista ON lista.id = item.lista
        WHERE lista.usuario = '$idusuario' AND item.lista = '$idlista' ORDER BY item.id";
$itens = $Conexao->executa($sql);

if($itens) {
?>
<table border="1" cellspacing="0" cellpadding="4" width="100%">
  <tr class="trCab">
    <td>produto</td>
    <td>resenha</td>
    <td>secao</td>
    <td>preço</td>
    <td>data</td>
  </tr>
<?php foreach($itens as $key => $item) {
  
  list($data,$lixo) = explode(' ',$item['data']);
  $d = explode('-',$data);
  $data = $d[2].'/'.$d[1].'/'.$d[0];
  
?>
<tr class="trItem">
  <td><?php echo $item['produto']?></td>
  <td title="<?php echo $item['resenha']?>"><?php echo substr($item['resenha'],0,20)?></td>
  <td><?php echo $item['secao']?></td>
  <td><?php echo number_format($item['preco'],2,',','.')?></td>
  <td><?php echo $data?></td>
</tr>
<?php } ?>
</table>
<p>
  <center><a href="#self" onclick="window.close();">Fechar</a></center>
</p>
<?php
} else {
  echo '<p>Não há itens cadastrados</p>';
}

require_once("../rodape.php");