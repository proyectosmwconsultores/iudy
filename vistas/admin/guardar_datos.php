<?php
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "act_rvoe_campus"){
    $IdRvoe = $_POST["IdRvoe"];
    $IdCampus = $_POST["IdCampus"];
    $IdEducativa = $_POST["IdEducativa"];

    $insertar = $db->query("INSERT INTO tblc_rvoe_campus (IdRvoe, IdCampus, IdEducativa) VALUES ('$IdRvoe','$IdCampus', '$IdEducativa')");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "quitar_rvoe_campus"){
    $IdRvoe = $_POST["IdRvoe"];
    $IdCampus = $_POST["IdCampus"];
    $IdEducativa = $_POST["IdEducativa"];

    $insertar = $db->query("DELETE FROM tblc_rvoe_campus WHERE tblc_rvoe_campus.IdRvoe = '$IdRvoe' AND tblc_rvoe_campus.IdCampus = '$IdCampus' AND tblc_rvoe_campus.IdEducativa = '$IdEducativa'");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "sav_estatus_alumno"){
    $IdUsua = $_POST["IdUsua"];
    
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '55' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "eliminar_pagos_anteriores"){
    $IdUsua = $_POST["IdUsua"];

    $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdEstatus = '1' AND tblp_pagos.IdUsua = '$IdUsua'");

    $db->close();
    echo $insertar;
  }


  
  if($tipoGuardar == "update_datos_materia"){
    $IdModulo = $_POST["IdModulo"];
    $IdGrado = $_POST["IdGrado"];
    $Code = $_POST["Code"];
    $Nombre = $_POST["Nombre"];
    $IdSeriada = $_POST["IdSeriada"];
    
    $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.Grado = '$IdGrado', tblp_modulo.NombreMod = '$Nombre', tblp_modulo.CodeModulo = '$Code' WHERE tblp_modulo.IdModulo = '$IdModulo'");
    
    if($IdSeriada){
      $sql_par3 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulo'");
      $db->rows($sql_par3);
      $_par3 = $db->recorrer($sql_par3);
      $code = $_par3['CodeModulo'];
      $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.code_serie = '$code', tblp_modulo.IdSeriada = '$IdSeriada' WHERE tblp_modulo.IdModulo = '$IdModulo'");
    }
    

    $db->close();
    echo $insertar;
  }


  if($tipoGuardar == "marcar_materia_seriada"){
    $IdModulo = $_POST["IdModulo"];
    $Valor = $_POST["Valor"];

    if($Valor == 1){
      $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.Seriada = '1' WHERE tblp_modulo.IdModulo = '$IdModulo'");
    } else {
      $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.Seriada = NULL, tblp_modulo.code_serie = NULL, tblp_modulo.IdSeriada = NULL  WHERE tblp_modulo.IdModulo = '$IdModulo'");
    }
    

    $db->close();
    echo $insertar;
  }



  if($tipoGuardar == "del_aviso_idok"){
    $IdAviso = $_POST["IdAviso"];

    $insertar = $db->query("DELETE FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso'");
    $insertar = $db->query("DELETE FROM tbla_aviso WHERE tbla_aviso.IdAviso = '$IdAviso'");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "sel_grp_actvar"){
    $IdAviso = $_POST["IdAviso"];
    $IdCiclo = $_POST["IdCiclo"];
    $IdGrupo = $_POST["IdGrupo"];
    $Tipo = $_POST["Tipo"];

    $sql_par3 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    $db->rows($sql_par3);
    $_par3 = $db->recorrer($sql_par3);

    if($_par3['Ingles'] == 'SI'){
      if($Tipo == 1){
        $sql = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdGrupo = '$IdGrupo' ");
        while($x = $db->recorrer($sql)){
          $_IdUsua = $x['IdUsua'];
          $sql_pseg = $db->query("SELECT tbla_aviso_detalle.IdDetalle FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso' AND tbla_aviso_detalle.IdUsua = '$_IdUsua'");
          $db->rows($sql_pseg);
          $_par3 = $db->recorrer($sql_pseg);
          if(!$_par3['IdDetalle']){
            $insertar = $db->query("INSERT INTO tbla_aviso_detalle (IdAviso, IdUsua, IdEstatus, IdGrupo)  VALUES ('$IdAviso','".$x['IdUsua']."','1','$IdGrupo')");
          }
          
        }
      } else {
        $insertar = $db->query("DELETE FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso' AND tbla_aviso_detalle.IdGrupo = '$IdGrupo'");
      }
    } else {
      if($Tipo == 1){
        $sql = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
        while($x = $db->recorrer($sql)){
          $insertar = $db->query("INSERT INTO tbla_aviso_detalle (IdAviso, IdUsua, IdEstatus, IdGrupo)  VALUES ('$IdAviso','".$x['IdUsua']."','1','$IdGrupo')");
        }
      } else {
        $insertar = $db->query("DELETE FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso' AND tbla_aviso_detalle.IdGrupo = '$IdGrupo'");
      }
    }




    
    $IdCiclo = $_par3["IdCiclo"];


    
    $db->close();
    echo $insertar;
  }
