<?php

  echo $tipoGuardar = $_GET["TipoGuardar"];

  require('../php/clases/class.System.php');
  $db = new Conexion();

  $tipoGuardar = $_POST["TipoGuardar"];


  if($tipoGuardar == "showAsig"){
    echo "hola bb";
    // $IdOferta = $_POST["IdOferta"];
    // $IdUsua = $_POST["IdUsua"];
    // $Movimiento = $_POST["Movimiento"];
    // $IdCoo = $_POST["IdCoo"];
    // if($Movimiento == 1){
    //   $insertar = $db->query("INSERT INTO tblp_coordinador (IdOferta,IdUsua, FecCap,IdEstatus) VALUES('$IdOferta','$IdUsua', NOW(),'8')");
    // } else {
    //   $insertar = $db->query("DELETE FROM tblp_coordinador WHERE tblp_coordinador.IdCoordinador = '$IdCoo' AND tblp_coordinador.IdUsua = '$IdUsua'");
    // }
    // $db->close();
    // echo $insertar;
  }
