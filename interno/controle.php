<?php
session_start();
if(!isset($_SESSION['mol'])) {
  header("location:../");
  exit;
}
$idusuario = $_SESSION['mol']['id'];
include("../class/class.Conexao.php");
require_once("../cabecalho.php");
if(!isset($naoExibeMenu)) {
  include("menu.php");
}

