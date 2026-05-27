<?php
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "val_close_grupo"){
    $IdGrupo = $_POST["IdGrupo"];
    $IdUsua = $_POST["IdUsua"];

    $sql6 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.IdCicloIni, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);

    $grado = $datos61['IdGrado'];
    $idCicloIni = $datos61['IdCicloIni'];
    $cveGrupo = $datos61['CveGrupo'];

    $pass = 'iudy';
    $pass_php = Password::hash($pass);

    $sqly = $db->query("SELECT * FROM tblh_temporal WHERE tblh_temporal.IdEstatus = '8' AND tblh_temporal.IdUsua = '$IdUsua'");
    while($z = $db->recorrer($sqly)){
      $nombre = $z["Nombre"];
      $paterno = $z["APaterno"];
      $materno = $z["AMaterno"];
      $usuario = $z["Usuario"];
      $idoferta = $z["Oferta"];
      $idcampus = $z["Campus"];
      $folio = $z["Folio"];
      $curp = $z["Curp"];
      $cel = $z["Cel"];
      $sexo = $z["Sexo"];
      $correo = $z["Correo"];
      $correo_ins = $z["Correo_ins"];
      $_fol = time();

      $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Usuario, Pass_php, Permisos, FecCap, Foto, Code, IdGrupo, IdEstatus, IdOferta, IdCampus, Matricula, SemCua, Grado, Sexo, Correo, id_ciclo_ini, Celular, Correo_institucional, Folio, Curp) VALUES ('$nombre','$paterno','$materno','Alumno','$usuario','$pass_php','3',NOW(),'nuevo.png','iudy','$IdGrupo','8','$idoferta','$idcampus','$usuario','1','$grado','$sexo','$correo','$idCicloIni','$cel','$correo_ins','$folio','$curp')");


  }

  $insertar = $db->query("DELETE FROM tblh_temporal WHERE tblh_temporal.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblh_excel SET tblh_excel.IdEstatus = '4', tblh_excel.IdUsuaDel = '$IdUsua', tblh_excel.FecDel = NOW() WHERE tblh_excel.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdEstatus = '8', tblp_grupo.Tipo = 'Cerrado' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");

  $db->close();
  echo $insertar;
}

if($tipoGuardar == "sub_ex_cal_final"){
  $IdUsua = $_POST['IdUsua'];
  $Oferta = $_POST['Oferta'];
  $Modulo = $_POST['Modulo'];
  $IdCiclo = $_POST['IdCiclo'];
  $IdDocente = $_POST['IdDocente'];
  $Fecha = $_POST['Fecha'];
  $IdGrupo = $_POST['IdGrupo'];
  $IdCampus = $_POST['IdCampus'];

  $sqlx8 = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$Modulo'");
  $db->rows($sqlx8);
  $datx8 = $db->recorrer($sqlx8);
  $_idModulo = $datx8['IdModulo'];
  $_codeModulo = $datx8['CodeModulo'];

  $sqlx9 = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdModulo = '$Modulo' AND tblp_asignacion.IdEducativa = '$Oferta'");
  $db->rows($sqlx9);
  $datosx91 = $db->recorrer($sqlx9);
  $IdAsig = $datosx91['IdAsignacion'];
  if(!$IdAsig){
    $anio = date("Y");
    $mes = date("m");
    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 15;
    $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
    $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdUsua, IdEducativa, IdModulo, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Anio, Mes, Fondo, _texto, Fecha_impresion) VALUES ('$IdAsig','$IdDocente','$Oferta','$Modulo','Finalizado',NOW(),'2','$IdGrupo','$IdCiclo','26','$IdCampus','$anio','$mes','----','----','$Fecha')");
  }

  $sqly = $db->query("SELECT * FROM tblh_temcal WHERE tblh_temcal.IdEstatus = '8' AND tblh_temcal.IdUsua = '$IdUsua'");
  while($z = $db->recorrer($sqly)){
    $usuario = $z["Usuario"];
    $p1 = $z["P1"];
    $p2 = $z["P2"];
    $p3 = $z["P3"];
    $p4 = $z["P4"];
    $e1 = $z["Ex1"];
    $e2 = $z["Ex2"];
    $a = $z["A"];
    $f = $z["F"];
    $pro = $z["Promedio"];

    $sqlx8 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Usuario = '$usuario'");
    $db->rows($sqlx8);
    $datosx81 = $db->recorrer($sqlx8);
    $_idU = $datosx81['IdUsua'];

    $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.Usuario = '$usuario' AND tblp_calificacion.IdOferta = '$Oferta' AND tblp_calificacion.IdModulo = '$Modulo'");

    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, P1, P2, P3, P4, E1, E2, FecCap, Promedio, IdCiclo, IdGrupo, IdAsignacion, A, F, IdTipo, IdEstatus)VALUES('$_idU','$usuario','$Oferta','$Modulo','$p1','$p2','$p3','$p4','$e1','$e2',NOW(),'$pro','$IdCiclo','$IdGrupo','$IdAsig','$a','$f','2','8')");
  }

  $sql_c = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_c);
  $_cic = $db->recorrer($sql_c);
  $_idCic = $_cic['IdCicloGrupo'];
  if(!$_idCic){
    $sql_m = $db->query("SELECT tblp_modulo.Grado FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$Modulo'");
    $db->rows($sql_m);
    $_mod = $db->recorrer($sql_m);
    $_grado = $_mod['Grado'];
    $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado) VALUES('$IdCiclo','$IdGrupo',NOW(),'$_grado')");
  }

  $insertar = $db->query("DELETE FROM tblh_temcal WHERE tblh_temcal.IdUsua = '".$_POST["IdUsua"]."'");

  if ($insertar) {
  echo 1;
  } else {
    echo 0;
  }

}


class Password {
    const SALT = 'MwC%6gA6w1W#8s';
    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }
}
