<?php
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "sav_crite_eva"){
    $IdRubrica = $_POST["IdRubrica"];
    $Criterio = $_POST["Criterio"];
    
    $insertar = $db->query("INSERT INTO tblc_rubrica_detalle (IdRubrica, Texto, Cal1, Cal2, Cal3, Cal4, Cal5) VALUES ('$IdRubrica','$Criterio', 10, 9, 8, 7, 6)");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "del_crite_eva"){
    $IdDetalle = $_POST["IdDetalle"];
    
    $insertar = $db->query("DELETE FROM tblc_rubrica_detalle WHERE tblc_rubrica_detalle.IdDetalle = '$IdDetalle' ");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "act_rubr_idx"){
    $IdRubrica = $_POST["IdRubrica"];
    
    $insertar = $db->query("UPDATE tblc_rubrica SET tblc_rubrica.IdEstatus = '8' WHERE tblc_rubrica.IdRubrica = '$IdRubrica' ");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "act_rubrica_actividad"){
    $IdActividadDoc = $_POST["IdActividadDoc"];
    $IdRubrica = $_POST["IdRubrica"];
    
    $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.IdRubrica = '$IdRubrica' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc' ");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "upd_puntps_eva"){
    $IdDetalle = $_POST["IdDetalle"];
    $Puntos = $_POST["Puntos"];
    $Valor = $_POST["Valor"];
    
    $insertar = $db->query("UPDATE tblc_rubrica_detalle SET tblc_rubrica_detalle.Cal$Valor = '$Puntos'  WHERE tblc_rubrica_detalle.IdDetalle = '$IdDetalle'");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "add_new_rubrica"){
    $Rubrica = $_POST["Rubrica"];
    $IdUsua = $_POST["IdUsua"];
    
    $insertar = $db->query("INSERT INTO tblc_rubrica (IdUsua, Nombre, IdEstatus) VALUES ('$IdUsua','$Rubrica','1')");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "regresar_edicion_acta"){
    $IdAsignacion = $_POST["IdAsignacion"];
    $Motivo = $_POST["Motivo"];
    $IdAdmin = $_POST["IdAdmin"];
    $Pagina = "Regresar el acta de calificación_".$IdAdmin."_".$IdAsignacion;
    $insertar = $db->query("INSERT INTO tblp_regresar_acta (IdAsignacion, IdAdmin, FecCap, Motivo) VALUES ('$IdAsignacion', '$IdAdmin', NOW(),'$Motivo')");
    $insertar = $db->query("INSERT INTO tblh_ingresos (IdUsua, Pagina, FecCap) VALUES ('$IdAdmin', '$Pagina', NOW())");

    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Fec_emi_bim1 = NULL, tblp_asignacion.Fec_emi_bim2 = NULL, tblp_asignacion.Fec_emi_bim3 = NULL, tblp_asignacion.Fecha_impresion = NULL WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");


    $db->close();
    echo $insertar;
  }

 ?>