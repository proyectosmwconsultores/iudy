<?php
require('class.System.php');
include('../../hace.php');
$html = '';
$db = new Conexion();

$Tipo = $_POST['Tipo'];

if($Tipo == "get_lst_grupos_id_campus"){
  $IdCampus = $_POST['IdCampus'];
    $IdUsua = $_POST['IdUsua'];
    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT
tblp_coordinador.IdOferta,
tblp_grupo.CveGrupo,
tblp_grupo.Grado,
tblp_grupo.IdGrupo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblp_coordinador
Left Join tblp_grupo ON tblp_grupo.IdOferta = tblp_coordinador.IdOferta
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblp_coordinador.IdEstatus =  '8' AND
tblp_coordinador.IdUsua =  '$IdUsua' AND
tblp_grupo.IdEstatus =  '8'
ORDER BY
tblp_coordinador.IdOferta ASC,
tblp_grupo.Grado ASC
");
    while($x = $db->recorrer($sql)){
        $IdGrupo=$x["IdGrupo"];
        $Grupo=$x["Grado"].'° '.$x["CveGrupo"].' - '.$x["_Modalidad"].' ('.$x["_Dias"].')';
        $html .= '<option value="'.$IdGrupo.'" >'.$Grupo.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_lst_mat_activas"){
    $IdGrupo = $_POST['IdGrupo'];
    $html='<option value="">- Seleccione -</option>';
    // $sql = $db->query("SELECT tblp_calificacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdGrupo =  '$IdGrupo' GROUP BY tblp_calificacion.IdModulo ORDER BY tblp_modulo.CodeModulo ASC");
    $sql = $db->query("SELECT tblp_asignacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdCampus = '1' AND tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' ORDER BY tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
        $IdModulo=$x["IdModulo"];
        $NombreMod=$x["CodeModulo"].' - '.$x["NombreMod"];
        $html .= '<option value="'.$IdModulo.'" >'.$NombreMod.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_espacio_libre"){
    $IdDocente = $_POST['IdDocente'];
    $fecha = $_POST['Ini'];
    $Fin = $_POST['Fin'];


    function check_in_range($fecha_inicio, $fecha_fin, $fecha){

             $fecha_inicio = strtotime($fecha_inicio);
             $fecha_fin = strtotime($fecha_fin);
             $fecha = strtotime($fecha);

             if(($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin))
                 return true;
             else
                 return false;
         }





    // $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.FecIni, tblp_asignacion.FecFin, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdUsua =  '$IdDocente' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Estatus =  'Activo' ORDER BY tblp_asignacion.FecIni ASC");
    while($x = $db->recorrer($sql)){
        $FecIni=$x["FecIni"];
        $FecFin=$x["FecFin"];
        $NombreMod=$x["NombreMod"];

        if(check_in_range($FecIni, $FecFin, $fecha))
        {
            $_fx = "<i class='fa fa-fw fa-warning'></i> ".$NombreMod.' ('.fechaLetraMay($FecIni).' AL '.fechaLetraMay($FecFin).')<br>';
        }else{
            $_fx = "";

        }

        $html .= $_fx;
    }
    // if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html; //"hola como estan ";
}

if($Tipo == "cargar_grupo_reg"){
    $IdCiclo = $_POST['IdCiclo'];
    $IdUsua = $_POST['IdUsua'];
    $html='<option value="">- Seleccione -</option>';

    $sql = $db->query("SELECT
tblp_coordinador.IdOferta,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.IdGrupo
FROM
tblp_coordinador
Left Join tblp_grupo ON tblp_grupo.IdOferta = tblp_coordinador.IdOferta
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdGrupo = tblp_grupo.IdGrupo
WHERE
tblp_coordinador.IdEstatus =  '8' AND
tblp_coordinador.IdUsua =  '$IdUsua' AND
tblc_ciclogrupo.IdCiclo =  '$IdCiclo'
ORDER BY
tblp_coordinador.IdOferta ASC,
tblp_grupo.Grado ASC
");
    while($x = $db->recorrer($sql)){
        $IdGrupo=$x["Grado"].'_'.$x["IdGrupo"];
        $Grupo=$x["Grado"].'° '.$x["CveGrupo"];
        $html .= '<option value="'.$IdGrupo.'" >'.$Grupo.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "grpos_materias_asignadas"){
    $IdCiclo = $_POST['IdCiclo'];
    $IdUsua = $_POST['IdUsua'];
    $html='<option value="">- Seleccione -</option>';

    $sql = $db->query("SELECT
tblp_coordinador.IdOferta,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.IdGrupo,
tblc_campus.Campus,
tblc_campus._campus,
tblp_educativa.Abreviatura,
tblc_dias_clases._Dias
FROM
tblp_coordinador
Left Join tblp_grupo ON tblp_grupo.IdOferta = tblp_coordinador.IdOferta
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdGrupo = tblp_grupo.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblp_coordinador.IdEstatus =  '8' AND
tblp_coordinador.IdUsua =  '$IdUsua' AND
tblc_ciclogrupo.IdCiclo =  '$IdCiclo'
GROUP BY tblp_grupo.IdGrupo
ORDER BY
tblc_campus.IdCampus ASC,
tblp_coordinador.IdOferta ASC,
tblp_grupo.Grado ASC");
    while($x = $db->recorrer($sql)){
        $campux = $x["_campus"];
        $IdGrupo=$x["Grado"].'_'.$x["IdGrupo"];
        $Grupo=$campux.' - '.$x["Grado"].'° '.$x["CveGrupo"].' ('.$x["_Dias"].') - '.$x["Abreviatura"];
        $html .= '<option value="'.$IdGrupo.'" >'.$Grupo.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "cargar_grupo_reg_pos"){
    $IdCiclo = $_POST['IdCiclo'];
    $IdUsua = $_POST['IdUsua'];
    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT
tblp_coordinador.IdOferta,
tblp_grupo.CveGrupo,
tblp_grupo.Grado,
tblp_grupo.IdGrupo,
tblp_educativa.IdGrado
FROM
tblp_coordinador
Left Join tblp_grupo ON tblp_grupo.IdOferta = tblp_coordinador.IdOferta
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdGrupo = tblp_grupo.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta
WHERE
tblp_coordinador.IdEstatus =  '8' AND
tblp_coordinador.IdUsua =  '$IdUsua' AND
tblc_ciclogrupo.IdCiclo =  '$IdCiclo'
ORDER BY
tblp_coordinador.IdOferta ASC,
tblp_grupo.Grado ASC
");
    while($x = $db->recorrer($sql)){
        $gradx = $x["IdGrado"];
        if(($gradx == 1) || ($gradx == 2)){
        $IdGrupo=$x["Grado"].'_'.$x["IdGrupo"];
        $Grupo=$x["Grado"].'° '.$x["CveGrupo"];
        $html .= '<option value="'.$IdGrupo.'" >'.$Grupo.'</option>';
      }
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "cargar_mat_asignadas"){
    $IdCiclo = $_POST['IdCiclo'];
    $IdGrupo = $_POST['IdGrupo'];
    $porciones = explode("_", $IdGrupo);
    $grado = $porciones[0];
    $IdGrupo =  $porciones[1];
    $html='<option value="">- Seleccione -</option>';

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.IdGrupo =  '$IdGrupo'
ORDER BY
tblp_modulo.CodeModulo ASC

");
    while($x = $db->recorrer($sql)){
        $IdAsignacion = $x["IdAsignacion"];
        $Materia = $x["CodeModulo"].' - '.$x["NombreMod"];
        $html .= '<option value="'.$IdAsignacion.'" >'.$Materia.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "cargar_planes_est"){
    $IdCampus = $_POST['IdCampus'];
    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa ORDER BY tblp_educativa.IdGrado ASC");
    while($x = $db->recorrer($sql)){
        $IdOferta=$x["IdEducativa"];
        $Nombre=$x["Nombre"];
        $html .= '<option value="'.$IdOferta.'" >'.$Nombre.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "buscar_celular"){
    $Celular = $_POST['Celular'];
    $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Celular = '$Celular' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdUsua = $datos91["IdUsua"];
    if($IdUsua){
      echo 1;
    } else {
      echo 0;
    }
}

if($Tipo == "get_lst_periodo_grupo"){
    $IdGrupo = $_POST['IdGrupo'];
    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclogrupo.IdGrupo, tblc_ciclo.Ciclo, tblc_ciclogrupo.Grado FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo' ORDER BY tblc_ciclo.FInicio DESC ");
    while($x = $db->recorrer($sql)){
        $IdCiclo=$x["IdCiclo"];
        $Ciclo=$x["Ciclo"];
        $html .= '<option value="'.$IdCiclo.'" >'.$Ciclo.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_lst_materias_periodo"){
    $IdCampus = $_POST['IdCampus'];
    $IdGrupo = $_POST['IdGrupo'];
    $IdCiclo = $_POST['IdCiclo'];
    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdAsignacion FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdCampus =  '$IdCampus' AND tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo = '2' ORDER BY tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
        $IdModulo=$x["IdModulo"];
        $Modulo=$x["CodeModulo"].' - '.$x["NombreMod"];
        $html .= '<option value="'.$IdModulo.'" >'.$Modulo.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_estado_sel"){
  $IdEstado_ = $_POST['IdEstado'];

    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT * FROM tblc_estado");
    while($x = $db->recorrer($sql)){
        $Cve_estado = $x["Cve_estado"];
        $Estado = $x["Estado"];
        if($IdEstado_ == $Cve_estado){ $txSl = " selected='selected'"; } else { $txSl = ""; }
        $html .= '<option value="'.$Cve_estado.'" '.$txSl.' >'.$Estado.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_ciudad_sel"){
  $IdEstado_ = $_POST['IdEstado'];
  $IdMunicipio_ = $_POST['IdMunicipio'];
  $html='<option value="">- Seleccione -</option>';
  $sql = $db->query("SELECT * FROM tblc_municipio WHERE tblc_municipio.Cve_entidad = '$IdEstado_' ");
  while($x = $db->recorrer($sql)){
      $Cve_mun = $x["Cve_mun"];
      $Municipio = $x["Nom_municipio"];
      if($IdMunicipio_ == $Cve_mun){ $txSl = " selected='selected'"; } else { $txSl = ""; }
      $html .= '<option value="'.$Cve_mun.'" '.$txSl.' >'.$Municipio.'</option>';
  }
  if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
  echo $html;

}

if($Tipo == "get_ciudad_sel_practica"){
    $IdEstado_ = $_POST['IdEstado'];
    $IdMunicipio_ = $_POST['IdMunicipio'];

    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT * FROM tblc_municipio WHERE tblc_municipio.Cve_entidad = '$IdEstado_' ");
    while($x = $db->recorrer($sql)){
        $Cve_mun = $x["Cve_mun"];
        $Municipio = $x["Nom_municipio"];
        if($IdMunicipio_ == $Cve_mun){ $txSl = " selected='selected'"; } else { $txSl = ""; }
        $html .= '<option value="'.$Cve_mun.'" '.$txSl.' >'.$Municipio.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
  
  }


if($Tipo == "get_localidad_sel"){
  $IdEstado_ = $_POST['IdEstado'];
  $IdMunicipio_ = $_POST['IdMunicipio'];
  $IdLocalidad_ = $_POST['IdLocalidad'];

  $IdMunicipio_ = str_pad($IdMunicipio_,3,"0",STR_PAD_LEFT);

  $html='<option value="">- Seleccione -</option>';
  $sql = $db->query("SELECT * FROM tblc_localidad WHERE tblc_localidad.Cve_entidad = '$IdEstado_' AND tblc_localidad.Cve_mun = '$IdMunicipio_' ");
  while($x = $db->recorrer($sql)){
      $Cve_loc = $x["Cve_localidad"];
      $Localidad = $x["Nom_localidad"];
      if($IdLocalidad_ == $Cve_loc){ $txSl = " selected='selected'"; } else { $txSl = ""; }
      $html .= '<option value="'.$Cve_loc.'" '.$txSl.' >'.$Localidad.'</option>';
  }
  if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
  echo $html;


}

if($Tipo == "get_estados"){
    $IdEstado = $_POST['IdEstado'];
    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT * FROM tblc_municipio WHERE tblc_municipio.Cve_entidad = '$IdEstado' ORDER BY tblc_municipio.Nom_municipio ASC ");
    while($x = $db->recorrer($sql)){
        $Cve_mun=$x["Cve_mun"];
        $Nom_mun=$x["Nom_municipio"];
        $html .= '<option value="'.$Cve_mun.'" >'.$Nom_mun.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_estados_practica"){
    $IdEstado = $_POST['IdEstado'];

    $html='<option value="">- Seleccione -</option>';
    $sql = $db->query("SELECT * FROM tblc_municipio WHERE tblc_municipio.Cve_entidad = '$IdEstado' ORDER BY tblc_municipio.Nom_municipio ASC ");
    while($x = $db->recorrer($sql)){
        $Cve_mun=$x["Cve_mun"];
        $Nom_mun=$x["Nom_municipio"];
        $html .= '<option value="'.$Cve_mun.'" >'.$Nom_mun.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
}

if($Tipo == "get_municipios"){
   $IdEstado = $_POST['IdEstado'];
   $IdMunicipio = $_POST['IdMunicipio'];
   $html='<option value="">- Seleccione -</option>';
   $sql = $db->query("SELECT * FROM tblc_localidad WHERE tblc_localidad.Cve_entidad = '$IdEstado' AND tblc_localidad.Cve_mun = '$IdMunicipio' ORDER BY tblc_localidad.Nom_localidad ASC");
   while($x = $db->recorrer($sql)){
       $Cve_loc=$x["Cve_localidad"];
       $Nom_loc=$x["Nom_localidad"];
       $html .= '<option value="'.$Cve_loc.'" >'.$Nom_loc.'</option>';
   }
   if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
   echo $html;
}

if($Tipo == "validar_rfc"){
    $Codigo = $_POST['Codigo'];
    $IdCodigo = $_POST['IdCodigo'];
    
    $html='<option value="">- Seleccione -</option>';
    
    $sql = $db->query("SELECT * FROM tblc_postal WHERE tblc_postal.CP = '$Codigo'  ORDER BY tblc_postal.Colonia ASC");
    while($x = $db->recorrer($sql)){
        $IdPostal = $x["IdPostal"];
        if($IdPostal == $IdCodigo){ $txSl = " selected='selected'"; } else { $txSl = ""; }
        $Cve_loc=$x["IdPostal"];
        $Nom_loc=$x["Colonia"];
        $html .= '<option value="'.$Cve_loc.'" '.$txSl.'>'.$Nom_loc.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
 }

 if($Tipo == "get_oferta_campus"){
    $IdCampus = $_POST['IdCampus'];
    
    $html='<option value="">- Seleccione -</option>';
    
    $sql = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa ORDER BY tblp_educativa.IdGrado ASC");
    while($x = $db->recorrer($sql)){
        $IdEducativa = $x["IdEducativa"];
        $Nombre = $x["Nombre"];
        $html .= '<option value="'.$IdEducativa.'">'.$Nombre.'</option>';
    }
    if($html == '<option value="">- Seleccione -</option>') $html='<option value=""> - Seleccione -</option>';
    echo $html;
 }

?>
