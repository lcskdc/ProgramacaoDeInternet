<?php
require_once("controle.php");
$Conexao = new Conexao();
$descricao = $resenha = $r = $idsecao = "";

$sql = "SELECT * FROM estabelecimento ORDER BY nome";
$estabelecimentos = $Conexao->executa($sql);

$sql = "SELECT * FROM produto ORDER BY idusuario = '$idusuario', descricao ASC";
$produtos = $Conexao->executa($sql);

$prod_post = array();
$estabelecimento = $estab = $prds = 0;
$prods[] = array();

if (isset($_POST['enviar']) || isset($_POST['adicionar'])) {
  $estab = $_POST['estabelecimento'];
  
  foreach($_POST['produto'] as $key => $value) {
    $valor = $_POST['valor'][$key];
    
    if(!isset($_POST['adicionar'])) {
      if($value>0||$valor!="") {
      $prds++;
      
        if(!$value>0) {
          $msg_erro[$key][] = "Informe o produto.<br />";
        }

        if($value>0) {
          if(in_array($value, $prods)) {
            $msg_erro[$key][] = "Produto já existente nesta lista.<br />";
          }
        }

        if(!is_numeric(str_replace(',','.',str_replace('.','',$valor)))) {
          $msg_erro[$key][] = "Valor inválido.<br />";
        }
      }
      
      if(!$estab>0) {
        $msg_erro['estabelecimento'] = "Informe o estabelecimento";
      }
      if($prds==0) {
        $msg_erro['produto'] = "Informe pelo menos um produto";
      }
    }
    
    $prod_post[] = array('produto'=>$value,'valor'=>$_POST['valor'][$key]);
    $prods[] = $value;
    
  }
  
  if(isset($_POST['adicionar'])) {
    $prod_post[] = array('produto'=>0,'valor'=>'');
  }
  
  if(!isset($msg_erro)&&!isset($_POST['adicionar'])) {
    $sql = "INSERT INTO lista (data, usuario, estabelecimento) VALUES (NOW(),$idusuario,$estab)";
    $idlista = $Conexao->executa($sql);
    foreach($prod_post as $key => $value) {
      if($value['produto']>0) {
        $sql = "INSERT INTO itemlista (lista,produto) VALUES ('$idlista','$value[produto]')";
        $iditem = $Conexao->executa($sql);
        $valor = str_replace(',','.',str_replace('.','',$value['valor']));
        $sql = "INSERT INTO precolista (item,preco,usuario,data) VALUES ($iditem,'$valor',$idusuario,NOW())";
        $Conexao->executa($sql);
      }
    }
    header("location:listas.php");
  }

}

?>
<form name="frmLista" id="frmLista" method="post">
  <?php if ($r != "") { ?>
    <p class="msg_erro">
      <?php echo $r ?>
    </p>
  <?php } ?>
  <p>
    <label for="estabelecimento">Estabelecimento: </label>
    <select name="estabelecimento" id="estabelecimento">
      <option value="0">SELECIONE</option>
      <?php foreach ($estabelecimentos as $key => $estabelecimento) { ?>
        <option value="<?php echo $estabelecimento['id']?>"<?php echo $estabelecimento['id']==$estab?' selected':''?>><?php echo $estabelecimento['nome'] ?></option>
      <?php } ?>
    </select>
    <?php
    if(isset($msg_erro['estabelecimento'])) {
      echo $msg_erro['estabelecimento'];
    }
    ?>
  </p>
  <p>
  <?php if(isset($msg_erro['produto'])) {
    echo $msg_erro['produto'];
  }
  ?>
  <table border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td><label>Produto</label></td>
      <td><label>Preço</label></td>
      <td>&nbsp;</td>
    </tr>
    <?php if (count($prod_post) == 0) { ?>
      <tr>
        <td>
          <select name="produto[]" id="produto0">
            <option value="0">SELECIONE</option>
            <?php foreach ($produtos as $key => $produto) { ?>
              <option value="<?php echo $produto['id'] ?>"><?php echo $produto['descricao'] ?></option>
            <?php } ?>
          </select>
        </td>
        <td><input type="text" class="valor_produto" name="valor[]" id="valor0" /></td>
      </tr>
    <?php } else { ?>
      <?php foreach ($prod_post as $kp => $value) { ?>
      <tr>
        <td>
          <select name="produto[]" id="produto<?php echo $kp?>">
            <option value="0">SELECIONE</option>
            <?php foreach ($produtos as $key => $produto) { ?>
              <option value="<?php echo $produto['id'] ?>"<?php echo ($value['produto']==$produto['id'])?' selected':''?>><?php echo $produto['descricao'] ?></option>
            <?php } ?>
          </select>
        </td>
        <td><input type="text" class="valor_produto" name="valor[]" id="valor<?php echo $kp?>" value="<?php echo $value['valor']?>" /></td>
        <td>
          <?php
          if(isset($msg_erro[$kp])) {
            echo implode("",$msg_erro[$kp]);
          }
          ?>
        </td>
      </tr>
      <?php } ?>
    <?php } ?>
  </table>
</p>
<p>
  <input type="submit" name="adicionar" value="Adicionar produto" />
  <input type="submit" name="enviar" value="Salvar" />
</p>
</form>
<?php
unset($Conexao);
require_once("../rodape.php");
