<?php
class Conexao {
  
  private $conexao;
  private $host = 'localhost';
  private $user = 'root';
  private $password = 'usbw';
  private $database = 'mol';
  private $port = 3307;
  
  function __construct() {
    $this->connect();
  }
  
  function connect() {
    $this->conexao = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port) or die(mysql_error());    
    mysqli_set_charset($this->conexao,"utf8");
  }
  
  function executa($sql) {
    $query = mysqli_query($this->conexao, $sql) or die(mysqli_error($this->conexao).'<br /><Br />'.$sql);
    if(strpos(strtolower($sql), 'select')>-1){
      $retorno = array();
      while($rs = mysqli_fetch_assoc($query)) {
        array_push($retorno, $rs);
      }
    } elseif(strpos(strtolower($sql), 'insert')>-1) {
      $retorno = mysqli_insert_id($this->conexao);
    } else {
      return $query;
    }
    return $retorno;
  }
  
  function desconecta() {
    //mysqli_commit($this->conexao);
    mysqli_close($this->conexao);
  }
  
  function __destruct() {
    $this->desconecta();
  }
  
}