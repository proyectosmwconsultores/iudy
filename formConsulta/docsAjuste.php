<?php
include('../hace.php');
if(isset($_POST["Tipo"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $tipo = $_POST["Tipo"];
  if($tipo = "Estatus"){
    if($_POST["IdEstatus"] == 7){


      $sql9 = $db->query("SELECT Archivo FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '".$_POST["IdDocAlumno"]."'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $archivo = $datos91["Archivo"];

      $delDoc = "../assets/docs/Alumnos/$archivo";

    if(file_exists($delDoc)){
      unlink($delDoc);
    }

    $insertar = $db->query("DELETE FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '".$_POST["IdDocAlumno"]."'");

  } else {
  
      $insertar = $db->query("UPDATE tblc_docalumnos SET tblc_docalumnos.Estatus = '".$_POST["IdEstatus"]."' WHERE tblc_docalumnos.IdDocAlumno = '".$_POST["IdDocAlumno"]."'");

    }

  }


  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;
}
?>
