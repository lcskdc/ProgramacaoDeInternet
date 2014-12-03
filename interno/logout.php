<?php
session_start();
if(isset($_SESSION['mol'])) {
  unset($_SESSION['mol']);
}
header("location:../");

