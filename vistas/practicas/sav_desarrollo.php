<?php
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "sav_aviso_nuevo"){
      $IdUsua = $_POST["IdUsua"];
      $Titulo = $_POST["Titulo"];
      $IdCiclo = $_POST["IdCiclo"];
      $Texto = $_POST["Texto"];
      $Inicio = $_POST["Inicio"];
      $Final = $_POST["Final"];

      $sql_par3 = $db->query("SELECT * FROM tblc_periodo_ps WHERE tblc_periodo_ps.IdPeriodo = '$IdCiclo'");
      $db->rows($sql_par3);
      $_par3 = $db->recorrer($sql_par3);
      $Pra_ini = $_par3["Inicia"];
      $Pra_fin = $_par3["Finaliza"];

      
      $insertar = $db->query("INSERT INTO tbla_aviso_practicas (IdUsua, Titulo, IdCiclo, Inicio, Final, Texto, IdEstatus, FecCap, Pra_ini, Pra_fin)  VALUES ('$IdUsua','$Titulo','$IdCiclo','$Inicio','$Final','$Texto', 12, NOW(),'$Pra_ini','$Pra_fin')");

      $db->close();
      echo $insertar;
  }

  if($tipoGuardar == "updx_aviso_nuevo"){
    $Titulo = $_POST["Titulo"];
    $IdAviso = $_POST["IdAviso"];
    $Texto = $_POST["Texto"];
    $Inicio = $_POST["Inicio"];
    $Final = $_POST["Final"];
    
    $insertar = $db->query("UPDATE tbla_aviso_practicas SET tbla_aviso_practicas.Titulo = '$Titulo', tbla_aviso_practicas.Inicio = '$Inicio', tbla_aviso_practicas.Final = '$Final', tbla_aviso_practicas.Texto = '$Texto' WHERE tbla_aviso_practicas.IdAviso = '$IdAviso' ");

    $db->close();
    echo $insertar;
}


if($tipoGuardar == "del_aviso_idok"){
  $IdAviso = $_POST["IdAviso"];

  $insertar = $db->query("DELETE FROM tbla_aviso_practicas_detalle WHERE tbla_aviso_practicas_detalle.IdAviso = '$IdAviso'");
  $insertar = $db->query("DELETE FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdAviso = '$IdAviso'");

  $db->close();
  echo $insertar;
}


if($tipoGuardar == "sel_grp_actvar"){
  $IdAviso = $_POST["IdAviso"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Tipo = $_POST["Tipo"];
  if($Tipo == 1){
    $sql = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
    while($x = $db->recorrer($sql)){
      $insertar = $db->query("INSERT INTO tbla_aviso_practicas_detalle (IdAviso, IdUsua, IdEstatus, IdGrupo)  VALUES ('$IdAviso','".$x['IdUsua']."','1','$IdGrupo')");
    }
  } else {
    $insertar = $db->query("DELETE FROM tbla_aviso_practicas_detalle WHERE tbla_aviso_practicas_detalle.IdAviso = '$IdAviso' AND tbla_aviso_practicas_detalle.IdGrupo = '$IdGrupo'");
  }
  
  $db->close();
  echo $insertar;
}


if($tipoGuardar == "sav_inscripcion_alumno"){
  $_idUsua = $_POST["_idUsua"];
  $IdUsua = $_POST["IdUsua"];
  $IdAviso = $_POST["IdAviso"];
  $Curp = $_POST["Curp"];
  $Empresa = $_POST["Empresa"];
  $Grado = $_POST["Grado"];
  $Responsable = $_POST["Responsable"];
  $Cargo = $_POST["Cargo"];
  $Domicilio = $_POST["Domicilio"];
  $Cp = $_POST["Cp"];
  $Telefono = $_POST["Telefono"];
  $Fecha = $_POST["Fecha"];
  $Persona = $_POST["Persona"];
  $TelEnlace = $_POST["TelEnlace"];
  $Area = $_POST["Area"];
  $IdDetalle = $_POST["IdDetalle"];
  $IdPractica = $_POST["IdPractica"];
  $IdEstatus = $_POST["IdEstatus"];
  $Direccion = $_POST["Direccion"];
  $Estado = $_POST["Estado"];
  $Municipio = $_POST["Municipio"];
  $CPAlumno = $_POST["CPAlumno"];
  $Celular = $_POST["Celular"];
  $Cuatrimestre = $_POST["Cuatrimestre"];
  
  $sql_par3 = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdAviso = '$IdAviso'");
  $db->rows($sql_par3);
  $_par3 = $db->recorrer($sql_par3);
  $IdCiclo = $_par3["IdCiclo"];

  if($IdEstatus == 3){
    $xond1 = ", tblp_practicas._idCoor = '$_idUsua', tblp_practicas._fecCoor = NOW() ";
    
  } else {
    $xond1 = " ";
  }

  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '$Direccion', tblp_informacion.D_cp = '$CPAlumno', tblp_informacion.D_estado = '$Estado', tblp_informacion.D_municipio = '$Municipio' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '$Celular', tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblp_practicas SET tblp_practicas.Grado = '$Cuatrimestre', tblp_practicas.IdAviso = '$IdAviso', tblp_practicas.Empresa = '$Empresa', tblp_practicas.Grado_responsable = '$Grado', tblp_practicas.Nombre_responsable = '$Responsable', tblp_practicas.Cargo = '$Cargo', tblp_practicas.Domicilio = '$Domicilio', tblp_practicas.CP = '$Cp', tblp_practicas.Telefono = '$Telefono', tblp_practicas.Fecha_inicio = '$Fecha', tblp_practicas.Persona_enlace = '$Persona', tblp_practicas.Telefono_enlace = '$TelEnlace', tblp_practicas.Area_asignado = '$Area', tblp_practicas.FecCap = NOW(), tblp_practicas.IdEstatus = '$IdEstatus', tblp_practicas.IdCiclo = '$IdCiclo', tblp_practicas.IdDetalle = '$IdDetalle' $xond1 WHERE tblp_practicas.IdPractica = '$IdPractica' ");
  
  $db->close();
  echo $insertar;
}

if($tipoGuardar == "sav_inscripcion_alumno_activo"){
  $IdGestion = $_POST["IdGestion"];
  $_idUsua = $_POST["_idUsua"];
  $IdUsua = $_POST["IdUsua"];
  $IdAviso = $_POST["IdAviso"];
  $Curp = $_POST["Curp"];
  $Empresa = $_POST["Empresa"];
  $Grado = $_POST["Grado"];
  $Responsable = $_POST["Responsable"];
  $Cargo = $_POST["Cargo"];
  $Domicilio = $_POST["Domicilio"];
  $Cp = $_POST["Cp"];
  $Telefono = $_POST["Telefono"];
  $Fecha = $_POST["Fecha"];
  $Persona = $_POST["Persona"];
  $TelEnlace = $_POST["TelEnlace"];
  $Area = $_POST["Area"];
  $IdDetalle = $_POST["IdDetalle"];
  $IdPractica = $_POST["IdPractica"];
  $IdEstatus = $_POST["IdEstatus"];
  $Direccion = $_POST["Direccion"];
  $Estado = $_POST["Estado"];
  $Municipio = $_POST["Municipio"];
  $CPAlumno = $_POST["CPAlumno"];
  $Celular = $_POST["Celular"];
  $Cuatrimestre = $_POST["Cuatrimestre"];
  

  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '$Direccion', tblp_informacion.D_cp = '$CPAlumno', tblp_informacion.D_estado = '$Estado', tblp_informacion.D_municipio = '$Municipio' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '$Celular', tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblp_practicas SET  tblp_practicas.IdGestion = '$IdGestion', tblp_practicas.Grado = '$Cuatrimestre', tblp_practicas.IdAviso = '$IdAviso', tblp_practicas.Empresa = '$Empresa', tblp_practicas.Grado_responsable = '$Grado', tblp_practicas.Nombre_responsable = '$Responsable', tblp_practicas.Cargo = '$Cargo', tblp_practicas.Domicilio = '$Domicilio', tblp_practicas.CP = '$Cp', tblp_practicas.Telefono = '$Telefono', tblp_practicas.Fecha_inicio = '$Fecha', tblp_practicas.Persona_enlace = '$Persona', tblp_practicas.Telefono_enlace = '$TelEnlace', tblp_practicas.Area_asignado = '$Area', tblp_practicas.IdDetalle = '$IdDetalle' WHERE tblp_practicas.IdPractica = '$IdPractica' ");
  
  $db->close();
  echo $insertar;
}

if($tipoGuardar == "sav_cancelar_inscripcion_alumno"){
  $IdPractica = $_POST["IdPractica"];
  
  $insertar = $db->query("DELETE FROM tblp_practicas WHERE tblp_practicas.IdPractica = '$IdPractica'");
  
  $db->close();
  echo $insertar;
}


if($tipoGuardar == "sav_inscripcion_alumno_gestion"){
  
  $IdUsua = $_POST["IdUsua"];
  $IdAviso = $_POST["IdAviso"];
  $Curp = $_POST["Curp"];
  $Empresa = $_POST["Empresa"];
  $Grado = $_POST["Grado"];
  $Responsable = $_POST["Responsable"];
  $Cargo = $_POST["Cargo"];
  $Domicilio = $_POST["Domicilio"];
  $Cp = $_POST["Cp"];
  $Telefono = $_POST["Telefono"];
  $Fecha = $_POST["Fecha"];
  $Persona = $_POST["Persona"];
  $TelEnlace = $_POST["TelEnlace"];
  $Area = $_POST["Area"];
  $IdDetalle = $_POST["IdDetalle"];
  $IdPractica = $_POST["IdPractica"];
  $IdEstatus = $_POST["IdEstatus"];
  $Emision = $_POST["Emision"];
  $IdGestion = $_POST["IdGestion"];

  $Direccion = $_POST["Direccion"];
  $Estado = $_POST["Estado"];
  $Municipio = $_POST["Municipio"];
  $CPAlumno = $_POST["CPAlumno"];
  $Celular = $_POST["Celular"];

  
  $sql_par3 = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdAviso = '$IdAviso'");
  $db->rows($sql_par3);
  $_par3 = $db->recorrer($sql_par3);
  $IdCiclo = $_par3["IdCiclo"];

  $anio = date("Y");
  $sql_fol = $db->query("SELECT tblp_practicas.No FROM tblp_practicas WHERE tblp_practicas.IdEstatus =  '4' AND tblp_practicas.Anio =  '$anio' ORDER BY tblp_practicas.No DESC LIMIT 1  ");
  $db->rows($sql_fol);
  $_nos = $db->recorrer($sql_fol);
  $numero = $_nos["No"];
  
  $numeroAdd = ($numero + 1);
  $cadenaNumero = str_pad($numeroAdd, 4, "0", STR_PAD_LEFT);

  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '$Direccion', tblp_informacion.D_cp = '$CPAlumno', tblp_informacion.D_estado = '$Estado', tblp_informacion.D_municipio = '$Municipio' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '$Celular', tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblp_practicas SET tblp_practicas.Anio = '$anio', tblp_practicas.Folio = '$cadenaNumero', tblp_practicas.No = '$numeroAdd', tblp_practicas.IdGestion = '$IdGestion', tblp_practicas.Fecha_impresion = '$Emision', tblp_practicas.IdAviso = '$IdAviso', tblp_practicas.Empresa = '$Empresa', tblp_practicas.Grado_responsable = '$Grado', tblp_practicas.Nombre_responsable = '$Responsable', tblp_practicas.Cargo = '$Cargo', tblp_practicas.Domicilio = '$Domicilio', tblp_practicas.CP = '$Cp', tblp_practicas.Telefono = '$Telefono', tblp_practicas.Fecha_inicio = '$Fecha', tblp_practicas.Persona_enlace = '$Persona', tblp_practicas.Telefono_enlace = '$TelEnlace', tblp_practicas.Area_asignado = '$Area', tblp_practicas.FecCap = NOW(), tblp_practicas.IdEstatus = '$IdEstatus', tblp_practicas.IdCiclo = '$IdCiclo', tblp_practicas.IdDetalle = '$IdDetalle' WHERE tblp_practicas.IdPractica = '$IdPractica' ");
  if($IdEstatus == 4){
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idpp = '64' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }
  
  $db->close();
  echo $insertar;
}


if($tipoGuardar == "del_docs_practica"){
  $IdDocsPractica = $_POST['IdDocs'];

  $sql1 = $db->query("SELECT * FROM tblp_practica_docs WHERE tblp_practica_docs.IdDocsPractica = '$IdDocsPractica'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $link = $datos11["Ruta"];
  $link = '../../'.$link;
  
  if (file_exists($link)) {
    unlink($link); 
  }

  $insertar = $db->query("DELETE FROM tblp_practica_docs WHERE tblp_practica_docs.IdDocsPractica = '$IdDocsPractica' ");

  $db->close();

  echo $insertar;
}

if($tipoGuardar == "liberar_constancia_practica"){
  $IdPractica = $_POST['IdPractica'];
  $IdUsua = $_POST['IdUsua'];
  $Fecha = $_POST['Fecha'];
  
  $anio = substr($Fecha, 0, 4);
  $sql_fol = $db->query("SELECT tblp_practicas.IdUsua, tblp_practicas._cer_no FROM tblp_practicas WHERE tblp_practicas.IdEstatus =  '4' AND tblp_practicas.Anio =  '$anio' ORDER BY tblp_practicas._cer_no DESC LIMIT 1 ");
  $db->rows($sql_fol);
  $_nos = $db->recorrer($sql_fol);
  $numero = $_nos["_cer_no"];
  
  
  $numeroAdd = ($numero + 1);
  $cadenaNumero = str_pad($numeroAdd, 4, "0", STR_PAD_LEFT);
  $cadenaNumero = 'IUDY/'.$anio.'/'.$cadenaNumero;


  //echo "UPDATE tblp_practicas SET tblp_practicas._cer_registro = '$cadenaNumero', tblp_practicas._cer_anio = '$anio', tblp_practicas._cer_no = '$numero', tblp_practicas._cer_fecha_liberacion = '$Fecha' WHERE tblp_practicas.IdPractica = '$IdPractica' ";

  $insertar = $db->query("UPDATE tblp_practicas SET tblp_practicas._cer_registro = '$cadenaNumero', tblp_practicas._cer_anio = '$anio', tblp_practicas._cer_no = '$numeroAdd', tblp_practicas._cer_fecha_liberacion = '$Fecha' WHERE tblp_practicas.IdPractica = '$IdPractica' ");

  $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','21','$Fecha',NOW(),'8','Proceso automático, por haber terminado las prácticas profesionales en la plataforma IUDY.') ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idpp = '65' WHERE tblc_usuario.IdUsua = '$IdUsua'");


  $db->close();

  echo $insertar;
}


if($tipoGuardar == "sav_motivo_ins_alumno"){
  $IdPractica = $_POST["IdPractica"];
  $IdEstatus = $_POST["IdEstatus"];
  $Motivo = $_POST["Motivo"];

  $insertar = $db->query("UPDATE tblp_practicas SET tblp_practicas.Motivo = '$Motivo',  tblp_practicas.IdEstatus = '$IdEstatus' WHERE tblp_practicas.IdPractica = '$IdPractica' ");
  
  
  $db->close();
  echo $insertar;
}



if($tipoGuardar == "cancelar_practica_id"){
  $IdPractica = $_POST["IdPractica"];
  $Motivo = $_POST["Motivo"];
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $Fecha = $_POST["Fecha"];

  $insertar = $db->query("UPDATE tblp_practicas SET tblp_practicas.IdEstatus = '11' WHERE tblp_practicas.IdPractica = '$IdPractica' ");
  $insertar = $db->query("INSERT INTO tblp_practicas_cancelado(IdPractica, IdUsuaAdmin, Fecha, Motivo, FecCap) VALUES ('$IdPractica', '$IdAdmin','$Fecha','$Motivo',NOW())");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idpp = '63' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  
  $db->close();
  echo $insertar;
}
