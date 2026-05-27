<?php
include('../hace.php');
if (isset($_POST["Id"])) {
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '" . $_POST["Id"] . "'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwLink = $datos91["Link"];

  
  $sql_asig = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdAsignacion = '".$_POST["IdAsignacion"]."' AND  tblp_biblioteca.id = '" . $_POST["Id"] . "'");
  $db->rows($sql_asig);
  $_asig = $db->recorrer($sql_asig);
  if(isset($_asig['IdBiblioteca'])){
  echo 1;
  exit();
  }
  


  $insertar = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Link, IdTema,IdUsua,FecCap,Anio,Mes,Tipo,Principal,id,servidor)  VALUES('".$_POST["IdAsignacion"]."','" . $datos91['Nombre'] . "','" . $datos91['Link'] . "','" . $datos91['IdTema'] . "','" . $datos91['IdUsua'] . "',NOW(),'" . $datos91['Anio'] . "','" . $datos91['Mes'] . "','" . $datos91['Tipo'] . "','0','" . $_POST["Id"] . "','" . $datos91['servidor'] . "')");

  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;
}
