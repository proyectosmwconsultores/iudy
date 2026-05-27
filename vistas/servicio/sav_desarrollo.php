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

      
      $insertar = $db->query("INSERT INTO tbla_aviso_servicio (IdUsua, Titulo, IdCiclo, Inicio, Final, Texto, IdEstatus, FecCap, Pra_ini, Pra_fin)  VALUES ('$IdUsua','$Titulo','$IdCiclo','$Inicio','$Final','$Texto', 12, NOW(),'$Pra_ini','$Pra_fin')");

      $db->close();
      echo $insertar;
  }

  if($tipoGuardar == "updx_aviso_nuevo"){
    $Titulo = $_POST["Titulo"];
    $IdAviso = $_POST["IdAviso"];
    $Texto = $_POST["Texto"];
    $Inicio = $_POST["Inicio"];
    $Final = $_POST["Final"];
    
    $insertar = $db->query("UPDATE tbla_aviso_servicio SET tbla_aviso_servicio.Titulo = '$Titulo', tbla_aviso_servicio.Inicio = '$Inicio', tbla_aviso_servicio.Final = '$Final', tbla_aviso_servicio.Texto = '$Texto' WHERE tbla_aviso_servicio.IdAviso = '$IdAviso' ");

    $db->close();
    echo $insertar;
}


if($tipoGuardar == "del_aviso_idok"){
  $IdAviso = $_POST["IdAviso"];

  $insertar = $db->query("DELETE FROM tbla_aviso_servicio_detalle WHERE tbla_aviso_servicio_detalle.IdAviso = '$IdAviso'");
  $insertar = $db->query("DELETE FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdAviso = '$IdAviso'");

  $db->close();
  echo $insertar;
}

if($tipoGuardar == "del_documento_ss_id"){
  $IdAviso = $_POST["IdAviso"];
  $IdDocs = $_POST["IdDocs"];

  $insertar = $db->query("DELETE FROM tbla_aviso_docs WHERE tbla_aviso_docs.IdDocs = '$IdDocs'");

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
  $Persona = "X";
  $TelEnlace = 0;
  $Area = $_POST["Area"];
  $IdDetalle = $_POST["IdDetalle"];
  $IdServicio = $_POST["IdServicio"];
  $IdEstatus = $_POST["IdEstatus"];
  $Direccion = $_POST["Direccion"];
  $Estado = $_POST["Estado"];
  $Municipio = $_POST["Municipio"];
  $CPAlumno = $_POST["CPAlumno"];
  $Celular = $_POST["Celular"];
  $Cuatrimestre = $_POST["Cuatrimestre"];
  $Atencion = $_POST["Atencion"];
  $Ubicacion = $_POST["Ubicacion"];
  
  
  $sql_par3 = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdAviso = '$IdAviso'");
  $db->rows($sql_par3);
  $_par3 = $db->recorrer($sql_par3);
  $IdCiclo = $_par3["IdCiclo"];


  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '$Direccion', tblp_informacion.D_cp = '$CPAlumno', tblp_informacion.D_estado = '$Estado', tblp_informacion.D_municipio = '$Municipio' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '$Celular', tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Area_ubicacion = '$Ubicacion', tblp_servicio.Area_atencion = '$Atencion', tblp_servicio.Grado = '$Cuatrimestre', tblp_servicio.IdAviso = '$IdAviso', tblp_servicio.Empresa = '$Empresa', tblp_servicio.Grado_responsable = '$Grado', tblp_servicio.Nombre_responsable = '$Responsable', tblp_servicio.Cargo = '$Cargo', tblp_servicio.Domicilio = '$Domicilio', tblp_servicio.CP = '$Cp', tblp_servicio.Telefono = '$Telefono', tblp_servicio.Fecha_inicio = '$Fecha', tblp_servicio.Persona_enlace = '$Persona', tblp_servicio.Telefono_enlace = '$TelEnlace', tblp_servicio.Area_asignado = '$Area', tblp_servicio.FecCap = NOW(), tblp_servicio.IdEstatus = '$IdEstatus', tblp_servicio.IdCiclo = '$IdCiclo', tblp_servicio.IdDetalle = '$IdDetalle' WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  
  $db->close();
  echo $insertar;
}

if($tipoGuardar == "sav_inscripcion_alumno_activo"){
  
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
  $Persona = "X"; //$_POST["Persona"];
  $TelEnlace = 0; //$_POST["TelEnlace"];
  $Area = $_POST["Area"];
  $IdDetalle = $_POST["IdDetalle"];
  $IdServicio = $_POST["IdServicio"];
  $IdEstatus = $_POST["IdEstatus"];
  $Direccion = $_POST["Direccion"];
  $Estado = $_POST["Estado"];
  $Municipio = $_POST["Municipio"];
  $CPAlumno = $_POST["CPAlumno"];
  $Celular = $_POST["Celular"];
  $Cuatrimestre = $_POST["Cuatrimestre"];
  $Atencion = $_POST["Atencion"];
  $Ubicacion = $_POST["Ubicacion"];
  
  

  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '$Direccion', tblp_informacion.D_cp = '$CPAlumno', tblp_informacion.D_estado = '$Estado', tblp_informacion.D_municipio = '$Municipio' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '$Celular', tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Area_ubicacion = '$Ubicacion', tblp_servicio.Area_atencion = '$Atencion', tblp_servicio.Grado = '$Cuatrimestre', tblp_servicio.IdAviso = '$IdAviso', tblp_servicio.Empresa = '$Empresa', tblp_servicio.Grado_responsable = '$Grado', tblp_servicio.Nombre_responsable = '$Responsable', tblp_servicio.Cargo = '$Cargo', tblp_servicio.Domicilio = '$Domicilio', tblp_servicio.CP = '$Cp', tblp_servicio.Telefono = '$Telefono', tblp_servicio.Fecha_inicio = '$Fecha', tblp_servicio.Persona_enlace = '$Persona', tblp_servicio.Telefono_enlace = '$TelEnlace', tblp_servicio.Area_asignado = '$Area', tblp_servicio.IdDetalle = '$IdDetalle' WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  
  $db->close();
  echo $insertar;
}

if($tipoGuardar == "sav_cancelar_inscripcion_alumno"){
  $IdServicio = $_POST["IdServicio"];
  
  $insertar = $db->query("DELETE FROM tblp_servicio WHERE tblp_servicio.IdServicio = '$IdServicio'");
  
  $db->close();
  echo $insertar;
}

if($tipoGuardar == "sel_estatus_docs"){
  $IdExpediente = $_POST["IdExpediente"];
  $IdEstatus = $_POST["IdEstatus"];
  
  $insertar = $db->query("UPDATE tblp_servicio_expediente SET tblp_servicio_expediente.IdEstatus = '$IdEstatus' WHERE tblp_servicio_expediente.IdExpediente = '$IdExpediente'");
  
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
  $IdServicio = $_POST["IdServicio"];
  $IdEstatus = $_POST["IdEstatus"];
  $Emision = $_POST["Emision"];
  
  

  $Direccion = $_POST["Direccion"];
  $Estado = $_POST["Estado"];
  $Municipio = $_POST["Municipio"];
  $CPAlumno = $_POST["CPAlumno"];
  $Celular = $_POST["Celular"];
  $Atencion = $_POST["Atencion"];
  $Ubicacion = $_POST["Ubicacion"];
  
  
  $sql_par3 = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdAviso = '$IdAviso'");
  $db->rows($sql_par3);
  $_par3 = $db->recorrer($sql_par3);
  $IdCiclo = $_par3["IdCiclo"];

  $anio = date("Y");
  $sql_fol = $db->query("SELECT tblp_servicio.No FROM tblp_servicio WHERE tblp_servicio.IdEstatus =  '4' AND tblp_servicio.Anio =  '$anio' ORDER BY tblp_servicio.No DESC LIMIT 1  ");
  $db->rows($sql_fol);
  $_nos = $db->recorrer($sql_fol);
  $numero = isset($_nos["No"]);
  if($numero){
    $numero = $_nos["No"];
  } else {
    $numero = 1;
  }
  
  $numeroAdd = ($numero + 1);
  $cadenaNumero = str_pad($numeroAdd, 4, "0", STR_PAD_LEFT);

  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '$Direccion', tblp_informacion.D_cp = '$CPAlumno', tblp_informacion.D_estado = '$Estado', tblp_informacion.D_municipio = '$Municipio' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '$Celular', tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Area_ubicacion = '$Ubicacion', tblp_servicio.Area_atencion = '$Atencion', tblp_servicio._validado = '1', tblp_servicio.Anio = '$anio', tblp_servicio.Folio = '$cadenaNumero', tblp_servicio.No = '$numeroAdd', tblp_servicio.Fecha_impresion = '$Emision', tblp_servicio.IdAviso = '$IdAviso', tblp_servicio.Empresa = '$Empresa', tblp_servicio.Grado_responsable = '$Grado', tblp_servicio.Nombre_responsable = '$Responsable', tblp_servicio.Cargo = '$Cargo', tblp_servicio.Domicilio = '$Domicilio', tblp_servicio.CP = '$Cp', tblp_servicio.Telefono = '$Telefono', tblp_servicio.Fecha_inicio = '$Fecha', tblp_servicio.Persona_enlace = '$Persona', tblp_servicio.Telefono_enlace = '$TelEnlace', tblp_servicio.Area_asignado = '$Area', tblp_servicio.FecCap = NOW(), tblp_servicio.IdEstatus = '$IdEstatus', tblp_servicio.IdCiclo = '$IdCiclo', tblp_servicio.IdDetalle = '$IdDetalle' WHERE tblp_servicio.IdServicio = '$IdServicio' ");

  if($IdEstatus == 4){
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idss = '64' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }
  
  $db->close();
  echo $insertar;
}


if($tipoGuardar == "del_docs_practica"){
  $IdDocsServicio = $_POST['IdDocs'];

  $sql1 = $db->query("SELECT * FROM tblp_servicio_docs WHERE tblp_servicio_docs.IdDocsServicio = '$IdDocsServicio'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $link = $datos11["Ruta"];
  $link = '../../'.$link;
  
  if (file_exists($link)) {
    unlink($link); 
  }

  $insertar = $db->query("DELETE FROM tblp_servicio_docs WHERE tblp_servicio_docs.IdDocsServicio = '$IdDocsServicio' ");

  $db->close();

  echo $insertar;
}

if($tipoGuardar == "liberar_constancia_practica"){
  $IdServicio = $_POST['IdServicio'];
  $Fecha = $_POST['Fecha'];

  
  $anio = substr($Fecha, 0, 4);
  $sql_fol = $db->query("SELECT tblp_servicio._cer_no FROM tblp_servicio WHERE tblp_servicio._cer_fecha_liberacion IS NULL AND tblp_servicio.IdEstatus =  '4' AND tblp_servicio.Anio =  '$anio' ORDER BY tblp_servicio._cer_no DESC LIMIT 1  ");
  $db->rows($sql_fol);
  $_nos = $db->recorrer($sql_fol);
  $numero = $_nos["_cer_no"];
  
  $numeroAdd = ($numero + 1);
  $cadenaNumero = str_pad($numeroAdd, 4, "0", STR_PAD_LEFT);
  $cadenaNumero = 'IUDY/'.$anio.'/'.$cadenaNumero;


  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio._cer_registro = '$cadenaNumero', tblp_servicio._cer_anio = '$anio', tblp_servicio._cer_no = '$numeroAdd', tblp_servicio._cer_fecha_liberacion = '$Fecha' WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idss = '65' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $db->close();

  echo $insertar;
}


if($tipoGuardar == "sav_motivo_ins_alumno"){
  $IdServicio = $_POST["IdServicio"];
  $IdEstatus = $_POST["IdEstatus"];
  $Motivo = $_POST["Motivo"];

  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Motivo = '$Motivo',  tblp_servicio.IdEstatus = '$IdEstatus' WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  
  
  $db->close();
  echo $insertar;
}


if($tipoGuardar == "sav_expediente_id"){
  $IdExpediente = $_POST["IdExpediente"];
  $IdTipoEmpresa = $_POST["IdTipoEmpresa"];
  $IdGiro = $_POST["IdGiro"];
  $fecha = $_POST["Fecha"];
  $IdServicio = $_POST["IdServicio"];
  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Fecha_validado = '$fecha', tblp_servicio._validado = '2' WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  $insertar = $db->query("UPDATE tblp_servicio_expediente SET tblp_servicio_expediente.Giro = '$IdGiro',  tblp_servicio_expediente.TipoEmp = '$IdTipoEmpresa' WHERE tblp_servicio_expediente.IdExpediente = '$IdExpediente' ");
  
  
  $db->close();
  echo $insertar;
}


if($tipoGuardar == "cancelar_servicio_ss_id"){
  $IdServicio = $_POST["IdServicio"];
  $Motivo = $_POST["Motivo"];
  $IdUsua = $_POST["IdUsua"];
  $Fecha = $_POST["Fecha"];

  $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.IdEstatus = '11' WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  $insertar = $db->query("INSERT INTO tblp_servicio_cancelado(IdServicio, IdUsuaAdmin, Fecha, Motivo, FecCap) VALUES ('$IdServicio', '$IdUsua','$Fecha','$Motivo',NOW())");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idss = '63' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  
  $db->close();
  echo $insertar;
}
