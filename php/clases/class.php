<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('America/Mexico_City');   //====================================================
//= Ultima actualización: 21/06/2019 11:32 a.m.      =
require('class.System.php');                        //= SF: MWComenius                                   =
ob_start();

function reloj()
{

  $FecNow = date("Y-m-d G-m-s");
  return $FecNow;
}

class Trabajo
{                                     //= (c) 2017 - 2019, Pedro González                  =
 

  public function add_registros($IdAdmin,$Comentario,$Accion,$Modulo,$Valor,$IdUsua,$IdMod)
  {
    $db = new Conexion();
    if ($IdUsua <> 1) {
      $insertar = $db->query("INSERT INTO tblh_ingresos (IdUsua, Pagina, FecCap, _accion, _modulo, _valor, _idUsua, _idActividad) VALUES ('$IdAdmin', '$Comentario',NOW(),'$Accion','$Modulo','$Valor','$IdUsua','$IdMod')");
      $db->close();
    }
  }


  public function alumnos_beca_alumnos()
  {
    $db = new Conexion();
    $get_all_ciclos_tipo = [];
    $sql = $db->query("SELECT
tblc_alumnos.IdUsua,
tblc_alumnos.IdCiclo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_alumnos.IdCiclo =  '54' AND
tblc_usuario.IdEstatus =  '8'
GROUP BY
tblc_alumnos.IdUsua
ORDER BY
tblc_usuario.IdCampus ASC,
tblc_usuario.IdOferta ASC
 ");
    while ($x = $db->recorrer($sql)) {
      $get_all_ciclos_tipo[] = $x;
    }
    return $get_all_ciclos_tipo;
  }
  
 public function get_datos_conpceot_id($IdUsua, $IdCiclo, $IdConcepto)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Monto,
tblp_beca.Porcentaje,
tblp_beca.Importe,
tblp_beca.Descuento,
tblp_beca.Total
FROM
tblp_pagos
Left Join tblp_beca ON tblp_beca.IdUsua = tblp_pagos.IdUsua AND tblp_beca.IdCiclo = tblp_pagos.IdCiclo
WHERE
tblp_pagos.IdUsua =  '$IdUsua' AND
tblp_pagos.IdCiclo =  '$IdCiclo' AND
tblp_pagos.IdConcepto =  '$IdConcepto' AND
tblp_beca.IdConcepto =  '$IdConcepto' AND
tblp_beca.IdCiclo =  '$IdCiclo'
GROUP BY
tblp_pagos.IdUsua
");
    while ($x = $db->recorrer($sql)) {
      $gtareasEditor[] = $x;
    }
    return $gtareasEditor;
  }
  

#INGRESANNDO DATOS GRAL
  public function validar_beca_alumnos()
  {
    $db = new Conexion();


die();
$idCiclo = 52;

       $sql_fol = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.Grado = '23' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo =  '54' GROUP BY tblp_beca.IdUsua ");
       while ($fol = $db->recorrer($sql_fol)) {    
            $fol['IdUsua'];
           
            $par = 0;
            $sql_reins = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdCiclo = '$idCiclo' AND tblp_beca.IdConcepto = '3'  ");
            $db->rows($sql_reins);
            $datos_rein= $db->recorrer($sql_reins);
            if(isset($datos_rein['IdBeca'])){
                $porcentaje_rein = $datos_rein['Porcentaje'];
                $importe_rein = $datos_mens['Importe'];
                $descuento_rein = $datos_mens['Descuento'];
                $total_rein = $datos_mens['Total'];  
                //$insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Total = '$importe_rein'  WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
               // $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe_rein', tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$descuento_rein', tblp_beca.Total = '$total_rein', tblp_beca.Porcentaje = '$porcentaje_rein', tblp_beca.Grado = '235' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
               $par = 1;
            } else {
               // echo "SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdCiclo = '$idCiclo' AND tblp_beca.IdConcepto = '1'  ";
                $sql_reins = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdCiclo = '$idCiclo' AND tblp_beca.IdConcepto = '1'  ");
                $db->rows($sql_reins);
                $datos_rein= $db->recorrer($sql_reins);
                if(isset($datos_rein['IdBeca'])){
                    $porcentaje_rein = $datos_rein['Porcentaje'];
                    $importe_rein = $datos_rein['Importe'];
                    $descuento_rein = $datos_rein['Descuento'];
                     $total_rein = $datos_rein['Total'];    
                    //$insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Total = '$importe_rein' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
                  //  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe_rein', tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$descuento_rein', tblp_beca.Total = '$total_rein', tblp_beca.Porcentaje = '$porcentaje_rein', tblp_beca.Grado = '235' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
                  $par = 3;
                }
            }
            
           // echo $total_rein; 
           //echo ;
            $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Total = '$total_rein' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
           //echo $par;
           
      
       }
       

   
    $idCiclo = 52;
       $sql_fol = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.Grado = '23' AND tblp_beca.IdCiclo =  '54' AND tblp_beca.IdConcepto = '3'  ");
       while ($fol = $db->recorrer($sql_fol)) {    
            $fol['IdUsua'];
             $fol['Total']; 
            $sql_men = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '".$fol['IdUsua']."' AND tblp_pagos.IdConcepto = '3' AND tblp_pagos.IdCiclo = '54' ");
            $db->rows($sql_men);
            $datos_mens = $db->recorrer($sql_men);
             $monto = $datos_mens['Monto'];
             $descuento = ($monto - $fol['Total']);
            
            $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$monto', tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$descuento', tblp_beca.Grado = '23' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
            
       }
       
   echo "holaa 2";
die();

     $idCiclo = 52;
       $sql_fol = $db->query("SELECT tblp_beca.IdBeca, tblp_beca.IdUsua FROM tblp_beca WHERE tblp_beca.Porcentaje = '100' AND tblp_beca.IdCiclo =  '54'  GROUP BY tblp_beca.IdUsua ");
       while ($fol = $db->recorrer($sql_fol)) {    
           echo $fol['IdUsua'];
           echo "<br>";
            
            $sql_men = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdCiclo = '$idCiclo' AND tblp_beca.IdConcepto = '2'  ");
            $db->rows($sql_men);
            $datos_mens = $db->recorrer($sql_men);
            if(isset($datos_mens['IdBeca'])){
                $porcentaje_men = $datos_mens['Porcentaje'];
                $importe_men = $datos_mens['Importe'];
                $descuento_men = $datos_mens['Descuento'];
                $total_men = $datos_mens['Total'];    
              //  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe_men', tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$descuento_men', tblp_beca.Total = '$total_men', tblp_beca.Porcentaje = '$porcentaje_men', tblp_beca.Grado = '235' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '2' AND tblp_beca.IdCiclo = '54' ");
            }
            
            
            
            $sql_reins = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdCiclo = '$idCiclo' AND tblp_beca.IdConcepto = '3'  ");
            $db->rows($sql_reins);
            $datos_rein= $db->recorrer($sql_reins);
            if(isset($datos_rein['IdBeca'])){
                $porcentaje_rein = $datos_rein['Porcentaje'];
                $importe_rein = $datos_mens['Importe'];
                $descuento_rein = $datos_mens['Descuento'];
                $total_rein = $datos_mens['Total'];  
                //$insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe_rein', tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$descuento_rein', tblp_beca.Total = '$total_rein', tblp_beca.Porcentaje = '$porcentaje_rein', tblp_beca.Grado = '235' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
            } else {
                $sql_reins = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdCiclo = '$idCiclo' AND tblp_beca.IdConcepto = '1'  ");
                $db->rows($sql_reins);
                $datos_rein= $db->recorrer($sql_reins);
                if(isset($datos_rein['IdBeca'])){
                    $porcentaje_rein = $datos_rein['Porcentaje'];
                    $importe_rein = $datos_mens['Importe'];
                    $descuento_rein = $datos_mens['Descuento'];
                    $total_rein = $datos_mens['Total'];    
                  //  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe_rein', tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$descuento_rein', tblp_beca.Total = '$total_rein', tblp_beca.Porcentaje = '$porcentaje_rein', tblp_beca.Grado = '235' WHERE tblp_beca.IdUsua = '".$fol['IdUsua']."' AND tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '54' ");
                }
            }
            
            
            
           
           
      
       }

      // $sql_beca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.Grado = 11");
      // while ($beca = $db->recorrer($sql_beca)) {
      //   $Importe = $beca['Importe'];
      //   $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Porcentaje = '0' WHERE tblp_beca.IdBeca = '".$beca['IdBeca']."' ");
      // }

   
  }
  
  
  
  #INGRESANNDO DATOS GRAL
  public function add_ingresos($IdUsua, $Pagina)
  {
    $db = new Conexion();


    $hoy = date("Y-m-d");
    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.IdEstatus = '8' WHERE tblx_evaluacion.FecIni = '$hoy' AND tblx_evaluacion.IdEstatus = '31'");


    $_anio = date("Y-m-d");

   

    if ($IdUsua <> 1) {
      $insertar = $db->query("INSERT INTO tblh_ingresos (IdUsua, Pagina, FecCap) VALUES ('$IdUsua', '$Pagina', NOW())");
      $db->close();
    }
  }

  public function get_addTreas()
  {
    $db = new Conexion();

    $texto = $_POST["Texto"];
    $IdEditor = $_POST["IdEditor"];

    $IdA = $_POST["IdActividadDoc"];
    $IdP = $_POST["IdParcialDoc"];

    $insertar = $db->query("UPDATE tblp_editor SET tblp_editor.Texto = '$texto', tblp_editor.IdEstatus = '12' WHERE tblp_editor.IdEditor = '$IdEditor'");
    $db->close();
    echo "<script type='text/javascript'>window.location='miEditor.php?toks=1572388956$IdA&tok=5868956937$IdP';</script>";
  }

  public function get_updEditorOb()
  {
    $db = new Conexion();
    $texto = $_POST["Texto"];
    $IdEditor = $_POST["IdEditor"];
    $Tipo = $_POST["Tipo"];

    $insertar = $db->query("UPDATE tblp_editor SET tblp_editor.Texto = '$texto' WHERE tblp_editor.IdEditor = '$IdEditor'");
    $db->close();
    echo "<script type='text/javascript'>window.location='doEditor.php?toks=1572459571$IdEditor&T=$Tipo';</script>";
  }

  public function get_datosEditor($IdUsua, $IdAsignacion, $IdParcialDoc, $IdActividadDoc)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_editor WHERE tblp_editor.IdAsignacion = '$IdAsignacion' AND tblp_editor.IdActividadesDocente = '$IdActividadDoc' AND tblp_editor.IdUsua = '$IdUsua' AND tblp_editor.IdParcialDocente = '$IdParcialDoc'");
    while ($x = $db->recorrer($sql)) {
      $gtareasEditor[] = $x;
    }
    return $gtareasEditor;
  }

  public function get_all_ciclos_tipo()
  {
    $db = new Conexion();
    $get_all_ciclos_tipo = [];
    $sql = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC ");
    while ($x = $db->recorrer($sql)) {
      $get_all_ciclos_tipo[] = $x;
    }
    return $get_all_ciclos_tipo;
  }

  
  public function get_actividades_id($IdAsignacion)
  {
    $db = new Conexion();
    $hoy = date("Y-m-d");
    $get_actividades_id = [];
    
    $sql = $db->query("SELECT
	tblp_actividadesdocente.IdActividadesDocente, 
	tblp_actividadesdocente.NomActividad, 
	tblp_actividadesdocente.FecIni, 
	tblp_actividadesdocente.FecFin, 
	tblp_actividadesdocente.Porcentaje, 
	tblc_tipoactividad.TipoActividad,
	tblp_actividadesdocente.IdParcialDocente, 
	tblp_actividadesdocente.IdSemanaDocente
FROM
	tblp_actividadesdocente
	LEFT JOIN
	tblc_tipoactividad
	ON 
		tblp_actividadesdocente.IdTipoActividad = tblc_tipoactividad.IdTipoActividad
WHERE tblp_actividadesdocente.IdEstatus = '8' AND
	tblp_actividadesdocente.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $get_actividades_id[] = $x;
    }
    return $get_actividades_id;
  }

  public function get_materia_id($IdAsignacion)
  {
    $db = new Conexion();
    $get_materia_id = [];
    $sql = $db->query("SELECT
	tblp_asignacion.IdAsignacion, 
	tblp_asignacion.IdUsua, 
	tblp_asignacion.FecIni, 
	tblp_asignacion.FecFin, 
	tblc_usuario.Nombre, 
	tblc_usuario.APaterno, 
	tblc_usuario.AMaterno, 
	tblc_usuario.Foto, 
	tblp_modulo.CodeModulo, 
	tblp_modulo.NombreMod, 
	tblp_educativa.Nombre AS Educativa
FROM
	tblp_asignacion
	LEFT JOIN
	tblc_usuario
	ON 
		tblp_asignacion.IdUsua = tblc_usuario.IdUsua
	LEFT JOIN
	tblp_modulo
	ON 
		tblp_asignacion.IdModulo = tblp_modulo.IdModulo
	LEFT JOIN
	tblp_educativa
	ON 
		tblp_asignacion.IdEducativa = tblp_educativa.IdEducativa
WHERE
	tblp_asignacion.IdAsignacion = '$IdAsignacion' AND
	tblp_asignacion.Tipo = 2");
    while ($x = $db->recorrer($sql)) {
      $get_materia_id[] = $x;
    }
    return $get_materia_id;
  }

  public function get_mis_contratos_pendientes($IdUsua)
  {
    $db = new Conexion();
    $get_mis_contratos_pendientes = [];
    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.IdUsua =  '$IdUsua' AND tblp_asignacion.contrato = '1' AND tblp_asignacion.aceptado = '0' ");
    while ($x = $db->recorrer($sql)) {
      $get_mis_contratos_pendientes[] = $x;
    }
    return $get_mis_contratos_pendientes;
  }


  public function get_obte_matr($IdGrupo, $IdCampus, $IdOferta, $IdSeriacion)
  {
    $db = new Conexion();

    $sql_g = $db->query("SELECT tblp_grupo.FechaIni FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    $db->rows($sql_g);
    $_grp = $db->recorrer($sql_g);
    $anio = substr($_grp["FechaIni"], 0, 4);
    $anioo = substr($_grp["FechaIni"], 2, 2);

    $sql5 = $db->query("SELECT * FROM tblc_seriacion WHERE  tblc_seriacion.IdSeriacion = '$IdSeriacion'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $Mat = $datos51["Matricula"];

    $sql6 = $db->query("SELECT tblc_matricula.IdMatricula, tblc_matricula.Numero FROM tblc_matricula WHERE tblc_matricula.Anio = '$anio' AND tblc_matricula.Tipo = '$Mat' ORDER BY tblc_matricula.Numero DESC LIMIT 1");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $Num = $datos61["Numero"] + 1;
    $code = str_pad($Num, 3, "0", STR_PAD_LEFT);

    $matCom = $Mat . $anioo . $code;

    $array = array("Mat" => $matCom);
    return $array;
  }

  public function get_editorId($IdEditor)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_editor WHERE tblp_editor.IdEditor = '$IdEditor'");
    while ($x = $db->recorrer($sql)) {
      $gEditorId[] = $x;
    }
    return $gEditorId;
  }

  public function get_saldoIni($IdCampus)
  {
    if ($IdCampus) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblp_saldo.IdSaldo, tblp_saldo.Monto, tblp_saldo.Descripcion, tblp_saldo.IdEstatus, tblp_saldo.Fecha, tblp_saldo.FecCap, tblp_saldo.Tipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_campus.Campus, tblp_educativa.Nombre AS Educativa FROM tblp_saldo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_saldo.IdUsua Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario.IdEstatus = '8'");
      while ($x = $db->recorrer($sql)) {
        $gSaldoINi[] = $x;
      }
      return $gSaldoINi;
    }
  }

  public function upd_salida($IdUsua, $codex, $inicio)
  {
    $ahora = time();
    $resultado = $ahora  - $inicio;
    $duracion = conversorSegundosHoras($resultado);
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblh_contador SET tblh_contador.FecSal = NOW(), tblh_contador.Duracion = '$duracion', tblh_contador.Final = '$ahora', tblh_contador.Total = '$resultado' WHERE tblh_contador.IdUsua = '$IdUsua' AND tblh_contador.Codex = '$codex'");
    $db->close();
  }

  public function get_all_ciclos_actual()
  {
    $db = new Conexion();
    $fecha = date("Y-m-d");
    $inicio = "2022-08-01";
    $final = date("Y-m-d", strtotime($fecha . "+ 8 month"));

    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.FInicio BETWEEN '$inicio' AND '$final' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC ");
    while ($x = $db->recorrer($sql)) {
      $get_all_ciclos_actual[] = $x;
    }
    return $get_all_ciclos_actual;
  }

  public function get_get_dias()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_dias_clases ");
    while ($x = $db->recorrer($sql)) {
      $get_get_dias[] = $x;
    }
    return $get_get_dias;
  }
  # CHECAR ESTATUS
  public function get_checarEstatus()
  {
    $FecAct = date("Y-m-d");
    $db = new Conexion();

    $sqlbc = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.Estatus =  'Finalizado' AND tblp_asignacion.IdEstatus =  '8'");
    while ($bc = $db->recorrer($sqlbc)) {
      $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '26'  WHERE tblp_asignacion.IdAsignacion='" . $bc["IdAsignacion"] . "'");
    }

    // $sqly = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdEstatus = '6'");
    // while ($z = $db->recorrer($sqly)) {
    //   if ($FecAct >= $z["FecIni"]) {
    //     $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.IdEstatus='8'  WHERE tblp_actividadesdocente.IdActividadesDocente='" . $z["IdActividadesDocente"] . "'");
    //   }
    // }

    $sqlx = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdEstatus = '8'");
    while ($x = $db->recorrer($sqlx)) {
      if ($x["FecFin"] < $FecAct) {
        $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.IdEstatus = '26'  WHERE tblp_actividadesdocente.IdActividadesDocente='" . $x["IdActividadesDocente"] . "'");
      }
    }

    $sql = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.Estatus = 'Activo' ORDER BY tblp_asignacion.FecFin ASC LIMIT 10");
    while ($x = $db->recorrer($sql)) {
      if ($x["FecFin"] < $FecAct) {
        $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Estatus='Finalizado', tblp_asignacion.IdEstatus = '26' WHERE tblp_asignacion.IdAsignacion='" . $x["IdAsignacion"] . "'");
        $insertar = $db->query("UPDATE tblp_moduloalumno SET Estatus='Finalizado'  WHERE tblp_moduloalumno.IdAsignacion='" . $x["IdAsignacion"] . "'");
      }
    }
  }

  public function get_checarPagos()
  {
    $FecAct = date("Y-m-d");
    $db = new Conexion();

  }

  public function get_checarGrad()
  {
    $db = new Conexion();

    // $sqly = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Grado, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.Grado IS NULL ");
    // while ($z = $db->recorrer($sqly)) {
    //   $IdUsua = $z["IdUsua"];
    //   $IdGrado = $z["IdGrado"];
    //   $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Grado='$IdGrado' WHERE tblc_usuario.IdUsua='$IdUsua'");
    // }
  }

  public function get_sexo()
  {

    $db = new Conexion();

    $sqly = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Sexo FROM tblc_usuario");
    while ($z = $db->recorrer($sqly)) {
      $IdUsua = $z["IdUsua"];
      $IdSx = $z["Sexo"];
      if ($IdSx == "FEMENINO") {
        $Sxx = "M";
      } elseif ($IdSx == "MUJER") {
        $Sxx = "M";
      } elseif ($IdSx == "MASCULIN") {
        $Sxx = "H";
      } elseif ($IdSx == "HOMBRE") {
        $Sxx = "H";
      } elseif ($IdSx == "H") {
        $Sxx = "H";
      } elseif ($IdSx == "M") {
        $Sxx = "M";
      }

      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Sexo='$Sxx' WHERE tblc_usuario.IdUsua='$IdUsua'");
    }
  }

  public function get_gRPSuSE()
  {

    $db = new Conexion();

    $sqly = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdGrupo FROM tblc_usuario  WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.Visto = '1' LIMIT 100");
    while ($z = $db->recorrer($sqly)) {
      $IdUsua = $z["IdUsua"];
      $IdGrupo = $z["IdGrupo"];
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Visto='0' WHERE tblc_usuario.IdUsua='$IdUsua'");
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdGrupo='$IdGrupo' WHERE tblp_pagos.IdUsua='$IdUsua'");
    }
  }

  # AGREGAR OFERTA EDUCATIVA
  public function add_OfertaE()
  {
    $tipoG = $_POST["txtTipo"];

    if ($tipoG == 1) {
      $tipo =  "Doctorado";
    } elseif ($tipoG == 2) {
      $tipo =  "Maestría";
    } elseif ($tipoG == 3) {
      $tipo =  "Licenciatura";
    } elseif ($tipoG == 8) {
      $tipo = "Curso";
    }
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_educativa (Clave, Tipo, Nombre, Estatus, FecCap, IdGrado, Color, Publicidad, id_usua)VALUES ('" . $_POST["txtClave"] . "','$tipo','" . $_POST["txtNombre"] . "','Activo', NOW(),'$tipoG','ffa101','default','" . $_POST["IdUsua"] . "')");
    $IdEdu = $db->insert_id;
    $insertar = $db->query("INSERT INTO tblc_rvoe (IdEducativa, Educativa, IdCampus)VALUES ('$IdEdu','" . $_POST["txtNombre"] . "','1')");

    
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
    $db->close();
  }

  public function add_cedula()
  {
    $IdUsua = substr($_POST["IdUsua"], 10, 10);
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion._Cual = '" . $_POST["txt_cual"] . "', tblp_informacion.correo_tutor = '" . $_POST["txt_correoT"] . "', tblp_informacion.Pos_estado = '" . $_POST["txt_pos_est"] . "', tblp_informacion.Pos_ini = '" . $_POST["txt_pos_ini"] . "', tblp_informacion.Pos_fin = '" . $_POST["txt_pos_fin"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.LNombre = '" . $_POST["txtLnom"] . "', tblp_informacion.LTelefono = '" . $_POST["txtLtel"] . "', tblp_informacion.LExtension = '" . $_POST["txtLext"] . "', tblp_informacion.LPuesto = '" . $_POST["txLPuesto"] . "', tblp_informacion.LDireccion = '" . $_POST["txtLdire"] . "', tblp_informacion.LCorreo = '" . $_POST["txtLcorreo"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.PNombre = '" . $_POST["txtPnombre"] . "', tblp_informacion.PUniversidad = '" . $_POST["txtPUni"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Fec_ini_carr = '" . $_POST["txt_fecini_carr"] . "', tblp_informacion.Fec_fin_carr = '" . $_POST["txt_fecfin_carr"] . "'  WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Sangre = '" . $_POST["txtSangre"] . "', tblp_informacion.Estado = '" . $_POST["txtEstadoN"] . "', tblp_informacion.Ciudad = '" . $_POST["txtMunicipioN"] . "', tblp_informacion.Localidad = '" . $_POST["txtLocalidadN"] . "', tblp_informacion.Domicilio = '" . $_POST["txtDireN"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.ENombre = '" . $_POST["txtNombrePa"] . "', tblp_informacion.ECelular = '" . $_POST["txtTel"] . "', tblp_informacion.EParentesco = '" . $_POST["txtParenteso"] . "', tblp_informacion.EDireccion = '" . $_POST["txtDirex"] . "', tblp_informacion.ETelefono = '" . $_POST["txtTelx"] . "', tblp_informacion.ETelTrabajo = '" . $_POST["txtTelT"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Curp = '" . $_POST["txtCurp"] . "', tblc_usuario.Usuario = '" . $_POST["txtControl"] . "', tblc_usuario.Nombre = '" . $_POST["txtNombre"] . "', tblc_usuario.APaterno = '" . $_POST["txtPaterno"] . "', tblc_usuario.AMaterno = '" . $_POST["txtMaterno"] . "', tblc_usuario.Sexo = '" . $_POST["txtSexo"] . "', tblc_usuario.FecNac = '" . $_POST["txtNac"] . "', tblc_usuario.Celular = '" . $_POST["txtCel"] . "', tblc_usuario.Telefono = '" . $_POST["txtTelefono"] . "', tblc_usuario.Correo = '" . $_POST["txtCorreo"] . "', tblc_usuario.Correo_institucional = '" . $_POST["txtInstitucional"] . "'  WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idtitulacion = '" . $_POST["txt_titulacion"] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Medio = '" . $_POST["txt_medx"] . "', tblp_informacion.P_civil = '" . $_POST["txtCivil"] . "', tblp_informacion.P_curp = '" . $_POST["txtCurp"] . "', tblp_informacion.P_depende = '" . $_POST["txtDepende"] . "', tblp_informacion.P_trabaja = '" . $_POST["txtTrabaja"] . "', tblp_informacion.C_tipo = '" . $_POST["txtTipIng"] . "', tblp_informacion.FecIns = '" . $_POST["txtFecIns"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.E_estudio = '" . $_POST["txt_carr"] . "', tblp_informacion.E_promedio = '" . $_POST["txt_prom"] . "', tblp_informacion.E_escuela_procedencia = '" . $_POST["txt_esc"] . "', tblp_informacion.E_estado_procedencia = '" . $_POST["txt_est"] . "', tblp_informacion.E_tipo = '" . $_POST["txt_tip"] . "', tblp_informacion.E_titulo = '" . $_POST["txt_tit"] . "', tblp_informacion.E_cedula = '" . $_POST["txt_ced"] . "', tblp_informacion.E_posgrado = '" . $_POST["txt_pos"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_estado = '" . $_POST["txtEstadoD"] . "', tblp_informacion.D_municipio = '" . $_POST["txtMunicipio"] . "', tblp_informacion.D_ciudad = '" . $_POST["txtCiudad"] . "', tblp_informacion.D_cp = '" . $_POST["txt_cp"] . "', tblp_informacion.D_direccion = '" . $_POST["txt_dir"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Otro = 'x' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
    $db->close();
  }

  public function get_alumno_id($IdUsua) {
    $db = new Conexion();
    $get_alumno_id = [];
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.Nombre AS NombreUser, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.Sexo, tblc_usuario.Foto, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.FecNac, tblp_grupo.Modalidad, tblp_grupo.Grupo, tblp_grupo.CveGrupo, tblp_educativa._impresion, tblp_educativa.IdGrado, tblp_educativa.Tipo, tblc_usuario.curp, tblc_usuario.Celular, tblc_modalidad._Modalidad FROM tblc_usuario LEFT JOIN tblp_educativa ON  tblp_educativa.IdEducativa = tblc_usuario.IdOferta LEFT JOIN tblp_grupo ON tblc_usuario.IdGrupo = tblp_grupo.IdGrupo LEFT JOIN tblc_modalidad ON tblp_grupo.Modalidad = tblc_modalidad.`Mod` WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $get_alumno_id[] = $x;
    }
    return $get_alumno_id;
  }

  public function add_cedula_id()
  {
    $IdUsua = $_POST["IdUsua"];
    $db = new Conexion();

    $sql2 = $db->query("SELECT tblp_informacion.IdInformacion FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdInformacion = $datos21["IdInformacion"];
    if (!$IdInformacion) {
      $insertar = $db->query("INSERT INTO tblp_informacion (IdUsua) VALUES ('$IdUsua')");
    }

    if ($_POST["txt_fecini"]) {
      $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Fec_ini = '" . $_POST["txt_fecini"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    }
    if ($_POST["txt_fecfin"]) {
      $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Fec_fin = '" . $_POST["txt_fecfin"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    }
    if ($_POST["txtNac"]) {
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.FecNac = '" . $_POST["txtNac"] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    }

    if(isset($_POST["txt_carr"])){
      $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.E_estudio = '" . $_POST["txt_carr"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    }

    if(isset($_POST["Pos_ini"])){
      $insertar = $db->query("UPDATE tblp_informacion SET  tblp_informacion.Pos_ini = '" . $_POST["txt_pos_ini"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    }

    if(isset($_POST["Pos_fin"])){
      $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Pos_fin = '" . $_POST["txt_pos_fin"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    }


    

    




    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion._Enfermedad = '" . $_POST["txtEnfermedad"] . "', tblp_informacion._Cual = '" . $_POST["txtCual"] . "', tblp_informacion._Medicamento = '" . $_POST["txtMedicamento"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.P_curp = '" . $_POST["txtCurp"] . "', tblp_informacion.Sangre = '" . $_POST["txtSangre"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Correo = '" . $_POST["txtCorreo"] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.P_civil = '" . $_POST["txtCivil"] . "', tblp_informacion.P_depende = '" . $_POST["txtDepende"] . "', tblp_informacion.P_trabaja = '" . $_POST["txtTrabaja"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.LNombre = '" . $_POST["txtLnom"] . "', tblp_informacion.LTelefono = '" . $_POST["txtLtel"] . "', tblp_informacion.LPuesto = '" . $_POST["txLPuesto"] . "', tblp_informacion.ENombre = '" . $_POST["txtNombrePa"] . "', tblp_informacion.ECelular = '" . $_POST["txtTel"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.E_promedio = '" . $_POST["txt_prom"] . "', tblp_informacion.E_escuela_procedencia = '" . $_POST["txt_esc"] . "', tblp_informacion.E_estado_procedencia = '" . $_POST["txt_est"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.E_tipo = '" . $_POST["txt_tip"] . "', tblp_informacion.E_titulo = '" . $_POST["txt_tit"] . "', tblp_informacion.E_cedula = '" . $_POST["txt_ced"] . "', tblp_informacion.E_posgrado = '" . $_POST["txt_pos"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.PNombre = '" . $_POST["txtPnombre"] . "', tblp_informacion.PUniversidad = '" . $_POST["txtPUni"] . "', tblp_informacion.Pos_estado = '" . $_POST["txt_pos_est"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

    if (isset($_POST["txtPaisD"])) {
      if ($_POST["txtPaisD"] == 120) {
        $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdPais_dom = '" . $_POST["txtPaisD"] . "', tblp_informacion.D_estado = '" . $_POST["txtEstadoD"] . "', tblp_informacion.D_municipio = '" . $_POST["txtMunicipio"] . "', tblp_informacion.D_ciudad = '" . $_POST["txtCiudad"] . "', tblp_informacion.D_cp = '" . $_POST["txt_cp"] . "', tblp_informacion.D_direccion = '" . $_POST["txt_dir"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
      } else {
        $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdPais_dom = '" . $_POST["txtPaisD"] . "', tblp_informacion.D_estado = NULL, tblp_informacion.D_municipio = NULL, tblp_informacion.D_ciudad = NULL, tblp_informacion.D_cp = NULL, tblp_informacion.D_direccion = '" . $_POST["txt_dir"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
      }
    }

    if (isset($_POST["txtPaisN"])) {
      if ($_POST["txtPaisN"] == 120) {
        $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdPais_nac = '" . $_POST["txtPaisN"] . "', tblp_informacion.Estado = '" . $_POST["txtEstadoN"] . "', tblp_informacion.Ciudad = '" . $_POST["txtMunicipioN"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
      } else {
        $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdPais_nac = '" . $_POST["txtPaisN"] . "', tblp_informacion.Estado = 'NO APLICA', tblp_informacion.Ciudad = 'NO APLICA' WHERE tblp_informacion.IdUsua = '$IdUsua'");
      }
    }

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Curp = '" . $_POST["txtCurp"] . "', tblc_usuario.Celular = '" . $_POST["txtCel"] . "', tblc_usuario.Telefono = '" . $_POST["txtTelefono"] . "', tblc_usuario.Sexo = '" . $_POST["txtSexo"] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Correo = '" . $_POST["txtCorreo"] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
    $db->close();
  }

  public function add_planProy()
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_plan (IdUsua, IdCampus, IdOferta, IdCiclo, Modalidad, Dia, Generacion, Objetivo, FecCap, IdEstatus) VALUES ('" . $_POST["IdUsua"] . "','" . $_POST["IdCampus"] . "','" . $_POST["txtOferta"] . "','" . $_POST["txtCiclo"] . "','" . $_POST["txtModalidad"] . "','" . $_POST["txtDias"] . "','" . $_POST["txtGeneracion"] . "','" . $_POST["txtObjetivo"] . "',NOW(),'31')");

    if ($insertar) {
      $_SESSION['Alerta'] = "1";
      return 1;
    } else {
      return 0;
    }
    $db->close();
  }

  # AGREGAR PAGOS
  public function add_generarPagos()
  {
    $db = new Conexion();
    $IdG = $_POST["txtOferta"];
    $anioHoy = date("Y");
    $anioActual = substr($anioHoy, 2, 2);
    $IdConceptoPlan = $_POST["txtConcepto"];
    $Grado = $_POST["txtOferta"];

    $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo) VALUES ('" . $_POST["txtOferta"] . "','" . $_POST["txtConcepto"] . "','" . $_POST["datepicker"] . "','" . $_POST["datepicker2"] . "','" . $_POST["datepicker3"] . "','" . $_POST["txtMonto"] . "','" . $_POST["IdUsua"] . "',NOW(),'32','" . $_POST["txtCicloEscolar"] . "')");
    
    if ($insertar) {
      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='ctrlGenerarPagos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='ctrlGenerarPagos.php';</script>";
    }
  }

  public function add_evaTodos()
  {
    $db = new Conexion();
    $Ciclo = $_POST["txtCicloEscolar"];
    $Oferta = $_POST["txtOferta"];
    $IdTipo = $_POST["txtEvaluacion"];

    $sqly = $db->query("SELECT tblp_evaluacion.IdEvaluacion FROM tblp_evaluacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_evaluacion.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_evaluacion.IdCiclo = '$Ciclo' AND tblp_grupo.IdOferta = '$Oferta' AND ((tblp_evaluacion.Valor_$IdTipo = '1') || (tblp_evaluacion.Valor_$IdTipo IS NULL))");
    while ($z = $db->recorrer($sqly)) {
      $IdEva = $z["IdEvaluacion"];

      $insertar = $db->query("UPDATE tblp_evaluacion SET tblp_evaluacion.Valor_$IdTipo = '2' WHERE tblp_evaluacion.IdEvaluacion = '$IdEva'");
    }

    echo "<script type='text/javascript'>window.location='ejecutarEvaluacion.php?IdC=$Ciclo&IdO=$Oferta&IdE=$IdTipo';</script>";
  }

  public function add_generarPagosGrp()
  {
    $db = new Conexion();
    $IdG = $_POST["txtOferta"];
    $anioHoy = date("Y");
    $anioActual = substr($anioHoy, 2, 2);
    $IdConceptoPlan = $_POST["txtConcepto"];
    $Grado = $_POST["txtOferta"];
    $IdGrupo = $_POST["txtGrupo"];

    $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdGrupo) VALUES ('" . $_POST["txtOferta"] . "','" . $_POST["txtConcepto"] . "','" . $_POST["datepicker"] . "','" . $_POST["datepicker2"] . "','" . $_POST["datepicker3"] . "','" . $_POST["txtMonto"] . "','" . $_POST["IdUsua"] . "',NOW(),'32','" . $_POST["txtCicloEscolar"] . "','" . $_POST["txtGrupo"] . "')");
    $IdCalendario = $db->insert_id;

    $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.IdCampus  FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
    while ($x = $db->recorrer($sqlx)) {
      $ref = $x["Usuario"];
      $IdOfe = $x["IdOferta"];
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo, IdGrupo,IdCampus)VALUES ('$IdCalendario','" . $x["IdUsua"] . "','" . $_POST["txtConcepto"] . "','" . $_POST["txtMonto"] . "','32',NOW(),'" . $_POST["datepicker"] . "','" . $_POST["datepicker2"] . "','" . $_POST["datepicker3"] . "','" . $_POST["datepicker"] . "','NO-F22','1','$anioHoy','$IdOfe','$ref','1','" . $_POST["txtCicloEscolar"] . "','$IdGrupo','" . $x["IdCampus"] . "')");
    }

    if ($insertar) {
      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='ctrlGenPagGrupo.php';</script>";
    } else {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='ctrlGenPagGrupo.php';</script>";
    }
  }


  public function add_ReenviarPass()
  {
    $IdUsua = $_POST["IdUsua"];
    $Fecha = date("Y-m-d");
    $db = new Conexion();
    $sql7 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblc_usuario.Foto, tblc_usuario.Sexo, tblc_usuario.IdCampus, tblc_usuario.Code FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $Nombre = $datos71["Nombre"] . ' ' . $datos71["APaterno"] . ' ' . $datos71["AMaterno"];
    $Cargo = $datos71["Cargo"];
    $Telefono = $datos71["Telefono"];
    $Correo = $datos71["Correo"];
    $usuarioX = $datos71["Usuario"];
    $Foto = $datos71["Foto"];
    $Code = $datos71["Code"];
    $idCam = $datos71["IdCampus"];

    $destinatario = $Correo;

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $Institucion = $_camp["Campus"];


    $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
    require('Mailin.php');
    $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'dXQZ0V6pyfM5B1tG');
    $data = array(
      "to" => array("$destinatario" => " $Nombre "),
      //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
      "from" => array("info@uni.edu.mx", " $Institucion"),
      "subject" => "Reestablecimiento de contraseña en la Plataforma - $Fecha",
      "text" => "Plataforma de Educación | $Institucion",

      "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
                 <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
            <tr>
                <td colspan='3' height='100' align='center'>
                <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                  <img src= '$linkLogo' >
                </b></td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color:#676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Restablecimiento de Contraseña en la <br> Plataforma de Educaci&oacute;n en L&iacute;nea
                </b></td>
            </tr>
            <tr>
            <td colspan='3' style='background: #f5f5f5; color: #676a8f;'>
              <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                <tr>
                  <td style=' text-align: right; padding: 10px;'>  Nombre: </td><td style='padding: 10px;'>  $Nombre </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px;'>  Usuario: </td><td style='padding: 10px; color: #676a8f;'> $usuarioX </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px;'>  Password: </td><td style='padding: 10px;'> $Code </td>
                </tr>
              </table>
            </td>
            <tr style='background: #f5f5f5; color: #676a8f;' colspan='3'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Para ingresar a su cuenta<br>
                <a href='$url'>
                  HAZ CLICK AQU&Iacute; PARA INGRESAR A SU CUENTA
                  </a>
                </b>
                </td>
            </tr>
            </tr>
          </table>",
      "attachment" => array(),
      "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
      "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
    );
    $mailin->send_email($data);
    if ($mailin) {
      echo "<script type='text/javascript'>window.location='adSelAllUsuarios.php';</script>";
    } else {
      echo "<script type='text/javascript'>window.location='adSelAllUsuarios.php';</script>";
    }
  }

  public function recuperar()
  {
    $correo = $_POST["txtCorreo"];
    $db = new Conexion();
    $sql7 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Correo =  '" . $_POST["txtCorreo"] . "' AND tblc_usuario.IdEstatus = '8' ");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdUsua = $datos71["IdUsua"];
    $CC = $datos71["Correo"];

    if (($IdUsua) && ($CC)) {
      $Fecha = date("Y-m-d");
      $sql8 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblc_usuario.Foto, tblc_usuario.IdCampus, tblc_usuario.Sexo, tblc_usuario.Code FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
      $db->rows($sql8);
      $datos81 = $db->recorrer($sql8);
      $Nombre = $datos81["Nombre"] . ' ' . $datos81["APaterno"] . ' ' . $datos81["AMaterno"];
      $Cargo = $datos81["Cargo"];
      $Telefono = $datos81["Telefono"];
      $Correo = $datos81["Correo"];
      $UsuarioX = $datos81["Usuario"];
      $Foto = $datos81["Foto"];
      $Code = $datos81["Code"];
      $idCam = $datos81["IdCampus"];
      $destinatario = $Correo;

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];


      $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'PCbhYnkfJR7Octpy');
      $data = array(
        "to" => array("$destinatario" => " $Nombre "),
        //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
        "from" => array("info@uni.edu.mx", " $Institucion"),
        "subject" => "Reestablecimiento de contraseña en la Plataforma - $Fecha",
        "text" => "Plataforma de Educación | $Institucion",

        "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
      					   <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
              <tr>
                  <td colspan='3' height='100' align='center'>
                  <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                    <img src= '$linkLogo' >
                  </b></td>
              </tr>
              <tr style='background: #f5f5f5; color: #676a8f;'>
                  <td colspan='3' height='100' align='center'>
                  <b style='color:#676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  Restablecimiento de Contraseña en la <br> Plataforma de Educaci&oacute;n en L&iacute;nea
                  </b></td>
              </tr>
      			  <tr>
              <td colspan='3' style='background: #f5f5f5; color: #676a8f;'>
                <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                  <tr>
                    <td style=' text-align: right; padding: 10px;'>  Nombre: </td><td style='padding: 10px;'>  $Nombre </td>
                  </tr>
                  <tr>
                    <td style=' text-align: right; padding: 10px;'>  Usuario: </td><td style='padding: 10px; color: #676a8f;'> $UsuarioX </td>
                  </tr>
                  <tr>
                    <td style=' text-align: right; padding: 10px;'>  Password: </td><td style='padding: 10px;'> $Code </td>
                  </tr>
                </table>
      				</td>
              </tr>
          	</table>",
        "attachment" => array(),
        "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
        "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
      );
      $mailin->send_email($data);
      if ($IdUsua) {
        echo "<script type='text/javascript'>window.location='iindex.php?x=xx';</script>";
      } else {
        echo "<script type='text/javascript'>window.location='iindex.php?x=x';</script>";
      }
    } else {
      echo "<script type='text/javascript'>window.location='iindex.php?x=x';</script>";
    }
  }

  # AGREGAR CLAVE DE GRUPO
  public function add_cveGrupo()
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT CveGrupo, Grupo FROM tblp_grupo WHERE tblp_grupo.CveGrupo =  '" . $_POST["txtClave"] . "'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $CveGrupo = $datos2["CveGrupo"];
    $total = strlen($_POST["txtClave"]); // 6
    if ($total == 10) {
      $oferta = substr($_POST["txtClave"], 0, 3);
      $modalidad = substr($_POST["txtClave"], 3, 1);
      $dia = substr($_POST["txtClave"], 4, 1);
      $tipociclo = substr($_POST["txtClave"], 5, 1);
      $turno = substr($_POST["txtClave"], 6, 1);
      $anio = substr($_POST["txtClave"], 7, 2);
      $grup = substr($_POST["txtClave"], 9, 1);

      if ($CveGrupo) {
        return 2;
      } else {
        $insertar = $db->query("INSERT INTO tblp_grupo (CveGrupo, Estatus, Turno, Oferta, Grupo, Modalidad, IdOferta,IdCampus, Anio, TipoCiclo, Dia, FecCap, Periodo,IdEstatus) VALUES ('" . $_POST["txtClave"] . "','Abierto', '$turno','$oferta','$grup','$modalidad','" . $_POST["txtOferta"] . "','" . $_POST["txtCampus"] . "','$anio','$tipociclo','$dia', NOW(),'" . $_POST["txtPeriodo"] . "','12')");
        if ($insertar) {
          return 1;
        } else {
          return 0;
        }
      }
    } else {
      return 3;
    }
  }

  public function add_addCveGprs()
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT CveGrupo, Grupo FROM tblp_grupo WHERE tblp_grupo.CveGrupo =  '" . $_POST["txtClave"] . "'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $CveGrupo = $datos2["CveGrupo"];
    if ($CveGrupo) {
      return 2;
    } else {
      $insertar = $db->query("INSERT INTO tblp_grupo (CveGrupo, Estatus, Tipo, IdOferta,IdCampus, FecCap, IdEstatus,id_usua) VALUES ('" . $_POST["txtClave"] . "','Activo', 'Abierto','" . $_POST["txtOferta"] . "','" . $_POST["txtCampus"] . "', NOW(),'8','" . $_POST["IdUsua"] . "')");
      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    }
  }

  public function add_CicloEscolar()
  {
    $Tipo = substr($_POST["txtTipo"], 0, 1);
    $MesIni = $_POST["datepicker1"];
    $MesFin = $_POST["datepicker2"];

    $anio = substr($MesIni, 0, 4);

    $MesI = substr($MesIni, 5, 2);
    $MesF = substr($MesFin, 5, 2);

    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblc_ciclo (Tipo, Anio, MesIni, MesFin, Ciclo, Estatus, FInicio, FFinal, FecCap, id_usua, IdEstatus, IdPeriodo) VALUES ('" . $_POST["txtTipo"] . "','$anio','$MesI','$MesF','" . $_POST["txtCiclo"] . "','Vigente','$MesIni','$MesFin',NOW(),'" . $_POST["IdUsua"] . "','8','" . $_POST["txtPeriodo"] . "')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_miEditor()
  {

    $IdEditor = $_POST["IdEditor"];
    $IdUsua = $_POST["IdUsua"];

    $db = new Conexion();
    $sql3 = $db->query("SELECT * FROM tblp_editor WHERE tblp_editor.IdEditor =  '$IdEditor'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdTarea = $datos31["IdTarea"];

    $insertar = $db->query("UPDATE tblp_editor SET tblp_editor.IdEstatus = '2' WHERE tblp_editor.IdEditor = '$IdEditor'");
    $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Editor = '1' WHERE tblp_tareas.IdTarea = '$IdTarea'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_Temas()
  {
    $db = new Conexion();
    $IdPlan = $_POST["IdPlan"];

    $insertar = $db->query("INSERT INTO tblp_plantemas (IdPlan, Tema, Cuatrimestre, FecCap, IdEstatus, Complejidad, IdOferta, Departamento) VALUES ('$IdPlan','" . $_POST["txtTemas"] . "','" . $_POST["txtCuatri"] . "',NOW(),'31','" . $_POST["txtComplejidad"] . "','" . $_POST["IdOferta"] . "','" . $_POST["txtDepartamento"] . "')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_miEditor()
  {

    $IdEditor = $_POST["IdEditor"];
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_editor SET tblp_editor.IdEstatus = '25' WHERE tblp_editor.IdEditor = '$IdEditor'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_CicloEscolar($IdCiclo, $FecIni, $FecFin, $Codigo)
  {
    $MesI = substr($FecIni, 5, 2);
    $MesF = substr($FecFin, 5, 2);
    $db = new Conexion();

    //$insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.FecFin = '$FecIni', tblp_asignacion.FecFin = '$FecFin'  WHERE tblp_asignacion.IdCiclo = '$IdCiclo' ");
    $insertar = $db->query("UPDATE tblc_ciclo SET tblc_ciclo.MesIni = '$MesI', tblc_ciclo.MesFin = '$MesF', tblc_ciclo.Ciclo = '$Codigo', tblc_ciclo.FInicio = '$FecIni', tblc_ciclo.FFinal = '$FecFin'  WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_subPeriodo($IdCiclo, $FecIni, $FecFin, $Codigo, $Sub)
  {
    $db = new Conexion();
    $sql2 = $db->query("SELECT SubPeriodo$Sub FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $rwSubPer = $datos21[0];
    if ($rwSubPer) {
      return 2;
      exit();
    }

    $insertar = $db->query("UPDATE tblc_ciclo SET tblc_ciclo.SubPeriodo$Sub = '$Codigo', tblc_ciclo.SubPerIni$Sub = '$FecIni', tblc_ciclo.SubPerFin$Sub = '$FecFin' WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_apertura($IdCiclo, $FecFin, $Tipo, $Parcial)
  {
    $db = new Conexion();
    $sql2 = $db->query("SELECT * FROM tblc_apertura WHERE tblc_apertura.IdCiclo = '$IdCiclo' AND tblc_apertura.NoParcial = '$Parcial' AND tblc_apertura.Tipo = '$Tipo'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $rwSubPer = $datos21["IdApertura"];
    if ($rwSubPer) {
      return 2;
      exit();
    }

    $insertar = $db->query("INSERT INTO tblc_apertura (IdCiclo, Tipo, NoParcial, Fecha, FecCap) VALUES ('$IdCiclo','$Tipo','$Parcial','$FecFin',NOW())");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_subPeriodo($IdCiclo, $Sub)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_ciclo SET tblc_ciclo.SubPeriodo$Sub = NULL, tblc_ciclo.SubPerIni$Sub = NULL, tblc_ciclo.SubPerFin$Sub = NULL WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_apertura($IdApertura)
  {
    $db = new Conexion();

    $insertar = $db->query("DELETE FROM tblc_apertura WHERE tblc_apertura.IdApertura = '$IdApertura' ");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_Tema($IdTema)
  {
    $db = new Conexion();

    $insertar = $db->query("DELETE FROM tblp_plantemas WHERE tblp_plantemas.IdTema = '$IdTema' AND tblp_plantemas.IdEstatus = '31'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savBanco($Nombre, $Banco, $Cuenta, $Clabe, $Convenio, $IdCampus)
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblc_bancos (Nombre, Banco, Convenio, NoCuenta, Clabe, IdEstatus, IdCampus) VALUES('$Nombre','$Banco','$Convenio','$Cuenta','$Clabe','8', '$IdCampus')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savParcial()
  {
    $db = new Conexion();
    $etiqueta = $_POST["txtEtiqueta"];
    if (isset($_POST["txtExtra"])) {
      $tipoP = "E";
    } else {
      $tipoP = "P";
    }

    $sql1 = $db->query("SELECT Count(tblp_parcialdocente.NoParcial) AS Total FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '" . $_POST["IdAsignacion"] . "'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwTotal = $datos2["Total"] + 1;


    $sql2 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '" . $_POST["IdAsignacion"] . "'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $rwIdGrupo = $datos21["IdGrupo"];
    $rwIdCiclo = $datos21["IdCiclo"];

    $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, Tema, Objetivo, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo, FecIni, FecFin)VALUES('" . $_POST["IdOferta"] . "','" . $_POST["IdModulo"] . "','$etiqueta','$rwTotal','" . $_POST["txtTema"] . "','" . $_POST["txtObjetivoP"] . "',NOW(),'" . $_POST["IdUsua"] . "','4','$rwIdGrupo','$rwIdCiclo','" . $_POST["IdAsignacion"] . "','$tipoP','" . $_POST["datepicker1Xp"] . "','" . $_POST["datepicker2Xp"] . "')");
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '8' WHERE tblp_asignacion.IdAsignacion = '" . $_POST["IdAsignacion"] . "'");
    $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.IdEstatus = '4', tblp_planeacion.FecAprobado = NOW() WHERE tblp_planeacion.IdAsignacion = '" . $_POST["IdAsignacion"] . "'");


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_updParcial()
  {
    $db = new Conexion();

    if (isset($_POST["txt_Extra"])) {
      $tipoP = "E";
    } else {
      $tipoP = "P";
    }


    $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.Tipo = '$tipoP', tblp_parcialdocente.Titulo = '" . $_POST["txt_Titulo"] . "', tblp_parcialdocente.Tema = '" . $_POST["txtTema"] . "', tblp_parcialdocente.Objetivo = '" . $_POST["txtObjetivoX"] . "',tblp_parcialdocente.FecIni = '" . $_POST["datepicker1XpU"] . "',tblp_parcialdocente.FecFin = '" . $_POST["datepicker2XpU"] . "', tblp_parcialdocente.IdUsua = '" . $_POST["IdUsua"] . "', tblp_parcialdocente.FecCap = NOW() WHERE tblp_parcialdocente.IdParcialDocente = '" . $_POST["IdParcialDoc"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_asignatura($CodeModulo, $Asignatura)
  {
    $db = new Conexion();
    $sql5 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.CodeModulo =  '$CodeModulo'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdModulo = $datos51["IdModulo"];

    if ($IdModulo) {
      return 2;
      exit();
    }


    $ClvOfer = substr($CodeModulo, 0, 4);
    $Code = substr($CodeModulo, 4, 3);
    $Campus = substr($CodeModulo, 7, 1);

    $sql3 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Clave =  '$ClvOfer'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdOferta = $datos31["IdEducativa"];
    if (!$IdOferta) {
      $insertar = $db->query("INSERT INTO tblp_educativa (Clave, Estatus, Publicidad, Color) VALUES ('$ClvOfer','Activo','default','ffa101')");
      $IdOferta = $db->insert_id;
    }

    $IdCampus = 1;

    $insertar = $db->query("INSERT INTO tblp_modulo (CodeModulo,NombreMod,Estatus,IdEducativa, Code,Oferta,IdCampus) VALUES ('$CodeModulo','$Asignatura','Activo','$IdOferta','$Code','$ClvOfer','$IdCampus')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_asigNew($Oferta, $Asignatura, $Campus)
  {
    $db = new Conexion();
    $sql5 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$Oferta' AND tblp_modulo.IdCampus =  '$Campus' AND tblp_modulo.NombreMod =  '$Asignatura'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdModulo = $datos51["IdModulo"];

    if ($IdModulo) {
      return 2;
      exit();
    }

    $insertar = $db->query("INSERT INTO tblp_modulo (NombreMod,Estatus,IdEducativa,IdCampus) VALUES ('$Asignatura','Activo','$Oferta','$Campus')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_updSemana()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_semanadocente SET tblp_semanadocente.Tematica = '" . $_POST["txt_temax"] . "', tblp_semanadocente.Etiqueta_semana = '" . $_POST["txt_Semana"] . "', tblp_semanadocente.Semana = '" . $_POST["txt_Tema"] . "', tblp_semanadocente.Temas = '" . $_POST["txtTemasXd"] . "', tblp_semanadocente.IdUsua = '" . $_POST["IdUsua"] . "', tblp_semanadocente.FecCap = NOW() WHERE tblp_semanadocente.IdSemanaDocente = '" . $_POST["IdSemanaDoc"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_Present()
  {
    $db = new Conexion();
    $IdSemana = $_POST["IdSemanaDoc"];

    $IdT = $_POST["txtTipox"];
    $Texto = $_POST["txtCodex"];

    if ($IdT == 'youtube') {
      $cadena_buscada   = 'https://www.youtube.com/embed/';
      $posicion_coincidencia = strpos($Texto, $cadena_buscada);
      if ($posicion_coincidencia === false) {
        return 2;
      } else {
        $text1 =  str_replace("960", "100%", $Texto);
        $Texto =  str_replace("560", "100%", $text1);
      }
    } elseif ($IdT == 'google') {
      $cadena_buscada   = 'https://docs.google.com/presentation';
      $posicion_coincidencia = strpos($Texto, $cadena_buscada);
      if ($posicion_coincidencia === false) {
        return 2;
      } else {
        $text1 =  str_replace("960", "100%", $Texto);
        $Texto =  str_replace("569", "400", $text1);
      }
    } elseif ($IdT == 'genially') {
      $cadena_buscada   = 'https://view.genial.ly';
      $posicion_coincidencia = strpos($Texto, $cadena_buscada);
      if ($posicion_coincidencia === false) {
        return 2;
      } else {
        $Texto = $_POST["txtCodex"];
      }
    } elseif ($IdT == 'canva') {
      $cadena_buscada   = 'www.canva.com';
      $posicion_coincidencia = strpos($Texto, $cadena_buscada);
      if ($posicion_coincidencia === false) {
        return 2;
      } else {
        $Texto = $_POST["txtCodex"];
      }
    }


    $insertar = $db->query("UPDATE tblp_semanadocente SET tblp_semanadocente.Tipo = '" . $_POST["txtTipox"] . "', tblp_semanadocente.Code = '$Texto', tblp_semanadocente.Nombre = '" . $_POST["txtNombrex"] . "' WHERE tblp_semanadocente.IdSemanaDocente = '" . $_POST["IdSemanaDoc"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_updFuente()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_fuentedocente SET tblp_fuentedocente.Fuente = '" . $_POST["txtFuenteA"] . "' WHERE tblp_fuentedocente.IdFuente = '" . $_POST["IdFuente"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_newCampus()
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblc_campus (Campus, Texto, IdEstatus) VALUES ('" . $_POST["txtCampus"] . "','" . $_POST["txtDireccion"] . "','8')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_newEvals()
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblc_tipoevaluacion (Evaluacion, IdPermiso, IdEstatus, Cve) VALUES ('" . $_POST["txtNombre"] . "','3','31','" . $_POST["txtPermiso"] . "')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_newPregunts()
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblx_pregunta (Tipo, Pregunta, IdEstatus, _Tipo, IdMod) VALUES ('" . $_POST["Tipo"] . "','" . $_POST["txtNombre"] . "','8','" . $_POST["txtTipoP"] . "','" . $_POST["txt_modx"] . "')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_updCampus()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_campus SET tblc_campus.IdEstatus = '" . $_POST["txtEstatus"] . "', tblc_campus.Campus = '" . $_POST["txCampus"] . "', tblc_campus.Texto = '" . $_POST["txDireccion"] . "' WHERE tblc_campus.IdCampus = '" . $_POST["IdCampus"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_updEvals()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_tipoevaluacion SET tblc_tipoevaluacion.Cve = '" . $_POST["txtPermiso"] . "', tblc_tipoevaluacion.IdEstatus = '" . $_POST["txtEstatus"] . "', tblc_tipoevaluacion.Evaluacion = '" . $_POST["txtTipo"] . "' WHERE tblc_tipoevaluacion.IdTipoEvaluacion = '" . $_POST["IdTipo"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_updPregs()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblx_pregunta SET tblx_pregunta.IdEstatus = '" . $_POST["txtEstatus"] . "', tblx_pregunta.Pregunta = '" . $_POST["txtPregunta"] . "' WHERE tblx_pregunta.IdPregunta = '" . $_POST["IdPregunta"] . "'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_respuestaEn($IdRespuesta, $Valor, $Respuesta, $Estatus)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblxx_respuesta SET tblxx_respuesta.IdEstatus = '$Estatus', tblxx_respuesta.Valor = '$Valor', tblxx_respuesta.Texto = '$Respuesta' WHERE tblxx_respuesta.IdResp = '$IdRespuesta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_respuesNew($IdPregunta, $Valor, $Respuesta)
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblxx_respuesta (Texto, IdPregunta, IdEstatus, Valor) VALUES ('$Respuesta','$IdPregunta','8','$Valor')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function addRespuexNew($IdRespuesta, $Valor, $Respuesta, $Estatus)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblxx_respuesta SET tblxx_respuesta.Valor = '$Valor', tblxx_respuesta.Texto = '$Respuesta', tblxx_respuesta.IdEstatus = '$Estatus' WHERE tblxx_respuesta.IdResp = '$IdRespuesta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_gen_constanci_ser($IdServicio, $Dep, $Pro, $Per, $Fec, $Regx)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Registro = '$Regx', tblp_servicio.NomPrograma = '$Pro', tblp_servicio.NomDependencia = '$Dep', tblp_servicio.Periodo = '$Per',tblp_servicio.FecImpresion = '$Fec', tblp_servicio.IdEstatus = '10' WHERE tblp_servicio.IdServicio = '$IdServicio'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_gen_constanci_ser_cart($IdServicio, $Dep, $Pro, $Per, $Fec, $No, $Gra, $Res)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.NomPrograma = '$Pro', tblp_servicio.NomDependencia = '$Dep', tblp_servicio.Periodo = '$Per',tblp_servicio.FecCarta = '$Fec', tblp_servicio.Folio_carta = '$No', tblp_servicio.Grado = '$Gra', tblp_servicio.Responsable = '$Res', tblp_servicio.IdEstatus = '10' WHERE tblp_servicio.IdServicio = '$IdServicio'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_changePass($IdUsua, $Anterior, $Nueva)
  {
    $db = new Conexion();
    $Nueva = trim($Nueva);
    if(!$IdUsua){
      return 0;
      die();
    }
    
    $pass_php = Password::hash($Nueva);
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Pass_php = '$pass_php', tblc_usuario.Code = '$Nueva' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }

  }

  public function add_savSemana()
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT Count(tblp_semanadocente.IdSemanaDocente) AS Total FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '" . $_POST["IdParcial"] . "' ");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwTotal = $datos2["Total"] + 1;

    $insertar = $db->query("INSERT INTO tblp_semanadocente (IdOferta, IdModulo, IdParcialDocente, Etiqueta_semana, NoSemana, Semana, Temas, FecCap, IdUsua, Tematica) VALUES ('" . $_POST["IdOferta"] . "','" . $_POST["IdModulo"] . "','" . $_POST["IdParcial"] . "','" . $_POST["txtSemana"] . "', '$rwTotal','" . $_POST["txtTema"] . "','" . $_POST["txtTemas"] . "',NOW(),'" . $_POST["IdUsua"] . "','" . $_POST["txtTematico_"] . "')");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savSemblanza($Semblanza, $IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Semblanza = '$Semblanza' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savGrados($Grado, $Nombre, $IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_gradodoc (Grado, Nombre, IdUsua, FecCap) VALUES ('$Grado','$Nombre','$IdUsua',NOW()) ");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_delGrados($IdGrado)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblp_gradodoc WHERE tblp_gradodoc.IdGrado = '$IdGrado'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_savActividad()
  {
    $db = new Conexion();

    $IdParcial = $_POST["IdParcial"];
    $_tipo = $_POST["txtTipoA"];
    if ($_tipo == 4) {
      $Porcentaje = 0;
    } else {
      $Porcentaje = $_POST["txtPorcentaje"];
    }
    $id_Tip = $_POST["tipo_act"];
    $Proyecto = $_POST["Proyecto"];
    $IdAsignacion = $_POST["IdAsignacion"];

    $_mod = $_POST["txtEntrega"];
    if ($_mod == 2) {
      $_mod = $_mod;
    } else {
      $_mod = 1;
    }
    $_txtA = '';
    if ($id_Tip == 1) {
      $_txtA = $_POST["txtDescripcion"];
    }
    if ($id_Tip == 2) {
      $_txtA = $_POST["txt_html"];
    }
    if ($id_Tip == 3) {
      $_txtA = '';
    }

    $sql9 = $db->query("SELECT Sum(tblp_actividadesdocente.Porcentaje) AS Avance FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdParcialDocente = '$IdParcial' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Avance = $datos91["Avance"];

    $sql_noS = $db->query("SELECT Count(tblp_actividadesdocente.IdActividadesDocente) AS Total FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion =  '$IdAsignacion' AND tblp_actividadesdocente.IdSemanaDocente =  '" . $_POST["IdSemana"] . "'");
    $db->rows($sql_noS);
    $datos_sum = $db->recorrer($sql_noS);
    $_sumSem = $datos_sum["Total"] + 1;

    $Avance = ($Avance + $Porcentaje);

    if ($Avance > 100) {
      return 2;
      exit();
    }

    if ($Proyecto == 1) {
      $pla = $_POST["IdPlan"];
      $tem = $_POST["IdTema"];
      $eta = $_POST["txtEtapa"];
      $val = ", IdPlan, IdTema, IdEtapa";
      $ins = ", '$pla', '$tem', '$eta'";
    } else {
      $val = "";
      $ins = "";
    }



    $insertar = $db->query("INSERT INTO tblp_actividadesdocente (IdOferta, IdModulo, IdParcialDocente, IdSemanaDocente, IdTipoActividad, NomActividad, DesActividad, FecCap, IdEstatus, IdUsua, IdAsignacion, FecIni, FecFin, Porcentaje, IdTipo, Estrategia, Tecnica, Herramienta, Modalidad $val) VALUES ('" . $_POST["IdOferta"] . "','" . $_POST["IdModulo"] . "','$IdParcial','" . $_POST["IdSemana"] . "','" . $_POST["txtTipoA"] . "','" . $_POST["txtActividad"] . "','" . $_POST["txtDescripcion"] . "',NOW(),'12','" . $_POST["IdUsua"] . "','" . $_POST["IdAsignacion"] . "','" . $_POST["datepicker1"] . "','" . $_POST["datepicker2"] . "','$Porcentaje','1','" . $_POST["txtEstrategias"] . "','" . $_POST["txtTecnica"] . "','" . $_POST["txtHerramienta"] . "','$_mod' $ins)");

    if ($insertar) {
      $insertarx = $db->query("UPDATE tblp_semanadocente SET tblp_semanadocente.NoLeccion = '$_sumSem' WHERE tblp_semanadocente.IdSemanaDocente = '" . $_POST["IdSemana"] . "' ");
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savClase()
  {
    $db = new Conexion();
    $IdUsuaD = $_POST['IdUsua'];
    $anio = date("Y");
    $mes = date("m");
    $anioo = substr($anio, 2, 2);
    $sql6 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdModulo =  '" . $_POST["txt_materia"] . "' AND tblp_asignacion.IdGrupo = '" . $_POST["txt_grupo"] . "' AND tblp_asignacion.IdCiclo = '" . $_POST["txt_ciclo"] . "' ");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $IdAsiX = $datos61["IdAsignacion"];

    if (!$IdAsiX) {

      $dir = 'assets/trabajos/' . $anio . '/' . $mes . '/';
      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 9;
      $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
      // $IdAsig = uniqid();
      $carpeta = $dir . $IdAsig;
      if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
      }

      $carpetaCrear2 = "assets/trabajos/$anio/$mes/$IdAsig/tareas";
      if (!file_exists($carpetaCrear2)) {
        mkdir($carpetaCrear2, 0777, true);
      }


      $Estatus = "Activo";

      $sql8 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '" . $_POST["txt_grupo"] . "'");
      $db->rows($sql8);
      $datos81 = $db->recorrer($sql8);
      $grupo = $datos81["CveGrupo"];

      $sql3 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '" . $_POST["txt_ciclo"] . "'");
      $db->rows($sql3);
      $datos31 = $db->recorrer($sql3);
      $Fini = $datos31["FInicio"];
      $Ffin = $datos31["FFinal"];

      $sql5 = $db->query("SELECT Max(tblp_planeacion.Folio) AS Folio FROM tblp_planeacion WHERE tblp_planeacion.IdUsua = '$IdUsuaD'");
      $db->rows($sql5);
      $datos51 = $db->recorrer($sql5);
      $FFolio = $datos51["Folio"] + 1;

      $sql23 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsuaD'");
      $db->rows($sql23);
      $datos231 = $db->recorrer($sql23);
      $nom = substr($datos231["Nombre"], 0, 1);
      $pat = substr($datos231["APaterno"], 0, 1);
      $codNomPat = $IdAsig;

      $sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo =  '" . $_POST["txt_materia"] . "'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdOferta = $datos91["IdEducativa"];
      $semcua = $datos91["Grado"];
      $codeMod = $datos91["CodeModulo"];
      $IdCamp = $datos91["IdCampus"];
      $cadFol = str_pad($FFolio, 3, "0", STR_PAD_LEFT);

      $codeMod = substr($codeMod, 8, 1);
      $cod = $codeMod . $codNomPat . $anioo . $cadFol;

      $insertar1 = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus,  IdCampus, Curso, Anio, Mes, Fondo) VALUES ('$IdAsig','$IdOferta','" . $_POST["txt_materia"] . "','$grupo','$IdUsuaD','$Fini','$Ffin','$Estatus',NOW(),'2','" . $_POST["txt_grupo"] . "','" . $_POST["txt_ciclo"] . "','8','$IdCamp','0','$anio','$mes','img_1.jpg')");
      $insertar = $db->query("INSERT INTO tblp_planeacion (IdAsignacion,IdUsua,FecAsignacion, Folio, Planeacion, IdEstatus, IdCampus) VALUES ('$IdAsig','" . $_POST["IdUsua"] . "',NOW(),'$FFolio','$cod','31','$IdCamp')");
      $sqly = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdOferta= '$IdOferta' AND tblc_usuario.IdGrupo= '" . $_POST["txt_grupo"] . "' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50'))");
      while ($z = $db->recorrer($sqly)) {
        $code = md5(rand() * time());
        $Id = $code;

        $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','" . $_POST["txt_materia"] . "','$grupo','" . $z["IdUsua"] . "','Activo',NOW(),'$IdAsig','" . $_POST["txt_grupo"] . "')");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$semcua'  WHERE tblc_usuario.IdUsua = '" . $z["IdUsua"] . "'");
      }
      for ($i = 1; $i < 8; $i++) {
        $insertar = $db->query("INSERT INTO tblp_horario (IdAsignacion, IdDia) VALUES ('$IdAsig','$i')");
      }

      $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdGrado = '$semcua'  WHERE tblp_grupo.IdGrupo = '" . $_POST["txt_grupo"] . "'");
      if ($insertar1) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 2;
    }
  }

  public function add_loadMtrss()
  {
    $db = new Conexion();


    $Grado = $_POST["txtGradoX"];
    $porciones = explode("-", $_POST["Cargar"]);
    $IdGrupo =  $porciones[0];
    $IdCiclo =  $porciones[1];

    $sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_modulo.IdModulo, tblp_modulo.IdEducativa, tblp_modulo.IdCampus, tblp_modulo.Grado FROM tblp_grupo Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.IdCampus WHERE tblp_grupo.IdGrupo =  '$IdGrupo' AND tblp_modulo.Grado = '$Grado' ");
    while ($x = $db->recorrer($sql)) {
      $IdCam = $x["IdCampus"];
      $IdOfe = $x["IdEducativa"];
      $IdMod = $x["IdModulo"];
      $insertar = $db->query("INSERT INTO tblk_materias (IdCampus, IdOferta, IdCiclo, IdModulo, Grado, FecCap, IdGrupo) VALUES('$IdCam','$IdOfe','$IdCiclo','$IdMod','$Grado',NOW(),'$IdGrupo')");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savBeca()
  {
    $db = new Conexion();
    $IdUsua = substr($_POST["IdUsua"], 10, 10);
    $IdUsuaCap = $_POST["IdUsuaCap"];
    $IdConcepto = $_POST["txtConcepto"];
    $Beca = $_POST["txtBeca"];


    $sql9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdConceptoPlan = '$IdConcepto' AND tblp_beca.IdEstatus = '8' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdBeca = $datos91["IdBeca"];

    if ($IdBeca) {
      return 2;
      exit();
    }

    $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConceptoPlan, Porcentaje, FecCap, IdUsuaCap, IdEstatus)VALUES('$IdUsua','$IdConcepto','$Beca',NOW(),'$IdUsuaCap','8')");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savFuente()
  {
    $db = new Conexion();



    $insertar = $db->query("INSERT INTO tblp_fuentedocente (IdOferta, IdModulo, IdParcialDocente, IdSemanaDocente, Fuente, FecCap, IdUsua, IdAsignacion)VALUES ('" . $_POST["IdOferta"] . "','" . $_POST["IdModulo"] . "','" . $_POST["IdParcial"] . "','" . $_POST["IdSemana"] . "','" . $_POST["txtDescripcion"] . "',NOW(),'" . $_POST["IdUsua"] . "','" . $_POST["IdAsignacion"] . "')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_fileAsignatura()
  {
    $db = new Conexion();
    $IdMod = time();
    $carpeta = "assets/docs/files/asignatura/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $tipo = $nombreImg[1];
    $archivo = md5(rand() * time()) . '-' . $archivo;
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adSubirFile.php-?IdModulo=1581624616'$IdMod;</script>";
      exit();
    }
    $IdMod = $_POST["IdModulo"];
    $nombre_fichero = $carpeta . $archivo;

    if (file_exists($nombre_fichero)) {

      $insertar = $db->query("INSERT INTO tblp_archivo (IdOferta, IdModulo, Nombre, Link, IdUsua, FecCap, Tipo)VALUES ('" . $_POST["IdOferta"] . "','" . $_POST["IdModulo"] . "','" . $_POST["txtNombre"] . "','$archivo','" . $_POST["IdUsua"] . "',NOW(),'" . $_POST["txtTipo"] . "')");
      echo "<script type='text/javascript'>window.location='adSubirFile.php?IdModulo=1581626015$IdMod';</script>";
    }
    echo "<script type='text/javascript'>window.location='adSubirFile.php?IdModulo=1581626015$IdMod';</script>";

  }

  public function add_fileDocs()
  {
    $db = new Conexion();
    $anio = date("Y");
    $mes = date("m");
    $carpeta = "assets/docs/files/$anio/$mes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archivo = time() . '_' . $archivo;
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adSubirDocs.php'</script>";
      exit();
    }

    $insertar = $db->query("INSERT INTO tblp_docs (IdGrado, Nombre, IdCiclo, Archivo, IdUsua, IdEstatus, FecCap, Anio, Mes) VALUES ('" . $_POST["txtGrado"] . "','" . $_POST["txtNombre"] . "','" . $_POST["txtCiclo"] . "','$archivo','" . $_POST["IdUsua"] . "','8',NOW(),'$anio','$mes')");
    $_SESSION['Alerta'] = "1";
    echo "<script type='text/javascript'>window.location='adSubirDocs.php';</script>";
  }

  public function add_fileDocsMx()
  {
    $db = new Conexion();
    $IdOferta = $_POST["txtOferta"];
    $IdModulo = $_POST["txtModulo"];

    $sql9 = $db->query("SELECT tblp_educativa.Clave, tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $clave = $datos91["Clave"];
    $IdGrado = $datos91["IdGrado"];

    $sql8 = $db->query("SELECT tblp_modulo.Grado, tblp_modulo.Code FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulo'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $codeModulo = $datos81["Code"];
    $grado = $datos81["Grado"];

    $carpeta = "assets/docs/libro/$clave/";
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }


    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archivo = md5(rand() * time()) . '-' . $archivo;
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adUpload.php?id=$IdOferta'</script>";
      exit();
    }
    $nombre_fichero = $carpeta . $archivo;
    if (file_exists($nombre_fichero)) {

      $insertar = $db->query("INSERT INTO tblp_libro (IdOferta, IdModulo, Nombre, Link, IdUsua, FecCap, Tipo, IdTema, Oferta,Code,Grado, IdGrado)VALUES ('$IdOferta','$IdModulo','" . $_POST["txtNombre"] . "','$archivo','" . $_POST["IdUsua"] . "',NOW(),'" . $_POST["txtModalidad"] . "','" . $_POST["txtTema"] . "','$clave','$codeModulo','$grado','$IdGrado')");
      echo "<script type='text/javascript'>window.location='adUpload.php?id=$IdOferta';</script>";
    }
    echo "<script type='text/javascript'>window.location='adUpload.php?id=$IdOferta';</script>";
  }

  public function add_upDocsMx()
  {
    $db = new Conexion();
    $oferta = $_POST["txtOferta"];
    $tema = $_POST["txtTema"];
    $moda = $_POST["txtModalidad"];

    if ($moda) {
      $carpeta = "./assets/images/modulo/$oferta/$tema/$moda/";
    } else {
      $carpeta = "./assets/images/modulo/$oferta/$tema/";
    }


    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='uploadImagen.php'</script>";
      exit();
    }
    echo "<script type='text/javascript'>window.location='uploadImagen.php?idO=$oferta&idT=$tema&idM=$moda';</script>";
  }

  public function add_fileAvisos()
  {
    $db = new Conexion();
    $carpeta = "assets/images/avisos/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archivo = md5(rand() * time()) . '-' . $archivo;
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adSubirAviso.php'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;

    if (file_exists($nombre_fichero)) {

      $insertar = $db->query("INSERT INTO tblc_aviso (Titulo, Aviso, Archivo, FecCap, Tipo, Permisos) VALUES ('" . $_POST["txtTitulo"] . "','" . $_POST["txtNombre"] . "','$archivo',NOW(),'" . $_POST["txtTipo"] . "','" . $_POST["txtUsuario"] . "')");
      echo "<script type='text/javascript'>window.location='adSubirAviso.php';</script>";
    }
    echo "<script type='text/javascript'>window.location='adSubirAviso.php';</script>";
  }

  public function add_updAvs()
  {
    $db = new Conexion();
    $carpeta = "assets/images/avisos/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archivo = time() . '-' . $archivo;
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adAvisos.php'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;

    if (file_exists($nombre_fichero)) {

      $insertar = $db->query("INSERT INTO tblc_aviso (Titulo, Archivo, FecCap, Tipo, Permisos,id_usua) VALUES ('" . $_POST["txtTitulo"] . "','$archivo',NOW(),'" . $_POST["txtTipo"] . "','3','" . $_POST["IdUsua"] . "')");
      echo "<script type='text/javascript'>window.location='adAvisos.php';</script>";
    }
    echo "<script type='text/javascript'>window.location='adAvisos.php';</script>";
  }

  public function upl_docsAlumno()
  {
    $db = new Conexion();

    $IdUsua = $_POST["IdUsua"];
    $anio = date("Y");
    $mes = date("m");

    $carpeta = "assets/docs/files/$anio/$mes/";
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }

    $carpeta = "assets/docs/files/$anio/$mes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archivo = time() . '_' . $archivo;
    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='docVerificar.php?IdUsua=1000215419$IdUsua'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;

    if (file_exists($nombre_fichero)) {
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Anio, Mes)VALUES ('$IdUsua','" . $_POST["txtTipo"] . "','$archivo','4',NOW(),'$anio','$mes')");
      // $insertar2 = $db->query("UPDATE tblp_documentos SET tblp_documentos.Si = '1' WHERE tblp_documentos.IdUsua = '$IdUsua' AND tblp_documentos.IdTipoDocumento = '" . $_POST["txtTipo"] . "'");
      echo "<script type='text/javascript'>window.location='docVerificar.php?IdUsua=1045102148$IdUsua';</script>";
    }
    echo "<script type='text/javascript'>window.location='docVerificar.php?IdUsua=8954125478$IdUsua';</script>";
  }


  public function add_updActividadDoc()
  {
    $db = new Conexion();
    $IdActividadDoc = $_POST["IdActividadDoc"];
    $IdAsig = $_POST["IdAsignacion"];
    $IdParD = $_POST["IdParcialDoc"];
    $proy = $_POST["Proyecto"];
    $_idTipo = $_POST["id_tipo"];
    $id_Tipx = $_POST["tipo_act"];
    $_txtAx = '';
    if ($id_Tipx == 1) {
      $_txtAx = $_POST["txtDescripcion1"];
    }
    if ($id_Tipx == 2) {
      $_txtAx = $_POST["txt_html2"];
    }
    if ($id_Tipx == 3) {
      $_txtAx = '';
    }

    if ($_idTipo == 1) {
      $Porcentaje = $_POST["txtPorcentajex"];
      $cond_upd = " , tblp_actividadesdocente.Porcentaje = '" . $_POST["txtPorcentajex"] . "' ";
    } elseif ($_idTipo == 2) {
      $Porcentaje = $_POST["txtPorcentajex"];
      $cond_upd = " , tblp_actividadesdocente.Porcentaje = '" . $_POST["txtPorcentajex"] . "' ";
    } elseif ($_idTipo == 3) {
      $Porcentaje = $_POST["txtPorcentajex"];
      $cond_upd = " , tblp_actividadesdocente.Porcentaje = '" . $_POST["txtPorcentajex"] . "', tblp_actividadesdocente.Modalidad = '" . $_POST["txtEntregaU"] . "' ";
    } elseif ($_idTipo == 4) {
      $Porcentaje = 0;
      $cond_upd = " ";
    }

    $sql9 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdAsig = $datos91["IdAsignacion"];
    $IdParD = $datos91["IdParcialDocente"];
    $Ava = $datos91["Porcentaje"];
    $IdEsta = $datos91["IdEstatus"];

    $sql8 = $db->query("SELECT Sum(tblp_actividadesdocente.Porcentaje) AS Avance FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsig' AND tblp_actividadesdocente.IdParcialDocente = '$IdParD' ");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $Avance = $datos81["Avance"];

    $Avance = ($Avance + $Porcentaje - $Ava);

    if ($Avance > 100) {
      return 2;
      exit();
    }

    //if ($IdEsta <> 8) {
    //  if ($IdEsta == 12) {
    //    $IdEstatus = 12;
    //  } else {
    //    $hoy = date("Y-m-d");
    //    $FecIni = $_POST["datepicker111"];
    //    $FecFin = $_POST["datepicker222"];

    //    if ($hoy < $FecIni) {
    //      $IdEstatus = 12;
    //    }
    //    if ($hoy >= $FecIni) {
    //      $IdEstatus = 8;
    //    }

    //    if ($FecFin <= $hoy) {
    //      $IdEstatus = 8;
    //    }
    //    if ($hoy > $FecFin) {
          //$IdEstatus = 26;
    //      return 3;
    //      exit();
    //    }
    //  }
    //} else {
    //  $IdEstatus = 8;
    //}
    
    $hoyTs    = strtotime(date("Y-m-d"));
    $fecIniTs = strtotime(str_replace('/', '-', $_POST["datepicker111"]));
    $fecFinTs = strtotime(str_replace('/', '-', $_POST["datepicker222"]));

    if ($hoyTs < $fecIniTs) {
        $IdEstatus = 12;
    } elseif ($hoyTs >= $fecIniTs && $hoyTs <= $fecFinTs) {
        $IdEstatus = 8;
    } else {
        $IdEstatus = 26;
    }


    if($datos91["IdEstatus"] == 12){
      $IdEstatus = 12;
    }




    $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Estrategia = '" . $_POST["txtEstrategiax"] . "', tblp_actividadesdocente.Tecnica = '" . $_POST["txtTecnicax"] . "', tblp_actividadesdocente.Herramienta = '" . $_POST["txtHerramientax"] . "', tblp_actividadesdocente.IdTipo = '$id_Tipx', tblp_actividadesdocente.IdTipoActividad = '" . $_POST["txtTipoAU"] . "', tblp_actividadesdocente.NomActividad = '" . $_POST["txtActividad1"] . "', tblp_actividadesdocente.DesActividad = '" . $_POST["txtDescripcion1"] . "', tblp_actividadesdocente.FecIni = '" . $_POST["datepicker111"] . "', tblp_actividadesdocente.FecFin = '" . $_POST["datepicker222"] . "', tblp_actividadesdocente.IdUsua = '" . $_POST["IdUsua"] . "',  tblp_actividadesdocente.IdEstatus = '$IdEstatus', tblp_actividadesdocente.FecCap = NOW() $cond_upd WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_daCrusorT()
  {
    $db = new Conexion();
    $IdModulo = $_POST["IdModulo"];
    $IdAsig = $_POST["IdAsignacion"];
    $IdUsuaXX = $_POST["IdUsuaXX"];


    $hoy = date("Y-m-d");
    $FecIni = $_POST["datepicker11"];
    $FecFin = $_POST["datepicker22"];

    $sql5 = $db->query("SELECT Max(tblp_planeacion.Folio) AS Folio FROM tblp_planeacion WHERE tblp_planeacion.IdUsua = '" . $_POST["txtUsua"] . "'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $FFolio = $datos51["Folio"] + 1;

    $cadFol = str_pad($FFolio, 3, "0", STR_PAD_LEFT);

    $sql23 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '" . $_POST["txtUsua"] . "'");
    $db->rows($sql23);
    $datos231 = $db->recorrer($sql23);
    $nom = substr($datos231["Nombre"], 0, 1);
    $pat = substr($datos231["APaterno"], 0, 1);
    $codNomPat = $nom . $pat;
    $anioo = date("Y");

    $sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo =  '$IdModulo'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdOferta = $datos91["IdEducativa"];
    $semcua = $datos91["Grado"];
    $IdCamp = $datos91["IdCampus"];
    $cadFol = str_pad($FFolio, 3, "0", STR_PAD_LEFT);

    $cod = 'X' . $codNomPat . $anioo . $cadFol;

    $insertar = $db->query("UPDATE tblp_asignacion SET  tblp_asignacion.Estatus = 'Activo', tblp_asignacion.IdUsua = '" . $_POST["txtUsua"] . "', tblp_asignacion.FecIni = '" . $_POST["datepicker11"] . "', tblp_asignacion.FecFin = '" . $_POST["datepicker22"] . "', tblp_asignacion.IdEstatus = '12' WHERE tblp_asignacion.IdAsignacion = '$IdAsig'");
    if (!$IdUsuaXX) {
      $insertar = $db->query("INSERT INTO tblp_planeacion (IdAsignacion,IdUsua,FecAsignacion, Folio, Planeacion, IdEstatus, IdCampus) VALUES ('$IdAsig','" . $_POST["txtUsua"] . "',NOW(),'$FFolio','$cod','31','$IdCamp')");
    }


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_envioRevision($IdUsua, $IdAsignacion, $IdPlaneacion)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.IdEstatus = '3' WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");
    $insertar = $db->query("UPDATE tblp_parcialdocente SET  tblp_parcialdocente.IdEstatus = '3' WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_updateBanco($IdBanco, $Nombre, $Banco, $Cuenta, $Clabe, $Convenio)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_bancos SET Convenio = '$Convenio', Nombre = '$Nombre', Banco = '$Banco', NoCuenta = '$Cuenta', Clabe = '$Clabe' WHERE tblc_bancos.IdBanco = '$IdBanco'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_copiParcial($IdParcial, $IdUsua, $IdAsignacion)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblp_parcial WHERE tblp_parcial.IdParcial = '$IdParcial'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $rwIdOferta = $datos11["IdOferta"];
    $rwIdModulo = $datos11["IdModulo"];
    $rwNoParcial = $datos11["NoParcial"];
    $rwTema = $datos11["Tema"];
    $rwObjetivo = $datos11["Objetivo"];

    $sql1 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdOferta = '$rwIdOferta' AND tblp_parcialdocente.IdModulo = '$rwIdModulo' AND tblp_parcialdocente.NoParcial = '$rwNoParcial'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $rwParDoc = $datos11["IdParcialDocente"];

    if ($rwParDoc) {
      return 2;
      exit();
    }
    $sql2 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $rwIdGrupo = $datos21["IdGrupo"];
    $rwIdCiclo = $datos21["IdCiclo"];

    $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdParcial, IdOferta, IdModulo, NoParcial, Tema, Objetivo, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion) VALUES('$IdParcial','$rwIdOferta','$rwIdModulo','$rwNoParcial','$rwTema','$rwObjetivo',NOW(),'$IdUsua','12','$rwIdGrupo','$rwIdCiclo','$IdAsignacion') ");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_copyExamen($IdParcial, $IdUsua, $IdAsignacion, $IdActividad, $IdActividadAnt)
  {
    $db = new Conexion();
    $sqly = $db->query("SELECT * FROM tblp_exampregunta WHERE tblp_exampregunta.IdActividadesDocente = '$IdActividadAnt'");
    while ($z = $db->recorrer($sqly)) {
      $tipo = $z["Tipo"];
      $insertar = $db->query("INSERT INTO tblp_exampregunta (IdAsignacion, IdActividadesDocente, IdParcialDocente, IdUsua, Pregunta, FecCap, Imagen, Tipo) VALUES ('$IdAsignacion','$IdActividad','$IdParcial','$IdUsua','" . $z["Pregunta"] . "',NOW(),'" . $z["Imagen"] . "','" . $z["Tipo"] . "')");
      $idPreg = $db->insert_id;
      if ($tipo == "O") {
        $idPregunta = $z["IdPregunta"];

        $sqlx = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta = '" . $z["IdPregunta"] . "'");
        while ($x = $db->recorrer($sqlx)) {
          $insertarx = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$idPreg','" . $x["Respuesta"] . "','" . $x["Valor"] . "')");
        }
      }
    }


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_copiPlaneacion($IdParcial, $IdUsua)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblp_semana WHERE tblp_semana.IdParcial = '$IdParcial'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $rwIdOferta = $datos11["IdOferta"];
    $rwIdModulo = $datos11["IdModulo"];
    $rwNoSemana = $datos11["NoSemana"];


    $sql1 = $db->query("SELECT * FROM tblp_semanadocente WHERE tblp_semanadocente.IdOferta = '$rwIdOferta' AND tblp_semanadocente.IdModulo = '$rwIdModulo' AND tblp_semanadocente.IdParcial = '$IdParcial'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $rwSemDoc = $datos11["IdSemanaDocente"];

    if ($rwSemDoc) {
      return 2;
      exit();
    }

    $sqly = $db->query("SELECT * FROM tblp_semana WHERE tblp_semana.IdParcial = '$IdParcial'");
    while ($z = $db->recorrer($sqly)) {
      $insertar = $db->query("INSERT INTO tblp_semanadocente (IdSemana, IdOferta, IdModulo, IdParcialDocente, NoSemana, Temas, FecCap, IdUsua) VALUES ('" . $z["IdSemana"] . "','$rwIdOferta','$rwIdModulo','$IdParcial','" . $z["NoSemana"] . "','" . $z["Temas"] . "',NOW(),'$IdUsua')");
    }

    $sqlm = $db->query("SELECT * FROM tblp_actividades WHERE tblp_actividades.IdParcial = '$IdParcial'");
    while ($x = $db->recorrer($sqlm)) {
      $insertar = $db->query("INSERT INTO tblp_actividadesdocente (IdActividades, IdOferta, IdModulo, IdParcialDocente, IdSemanaDocente, IdTipoActividad, NomActividad, DesActividad, FecCap, IdEstatus, IdUsua) VALUES ('" . $x["IdActividades"] . "','$rwIdOferta','$rwIdModulo','$IdParcial','" . $x["IdSemana"] . "','" . $x["IdTipoActividad"] . "','" . $x["NomActividad"] . "','" . $x["DesActividad"] . "',NOW(),'12','$IdUsua')");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_cambiosParcial($IdAsignacion, $IdUsua, $IdEstatus, $IdPlaneacion)
  {
    $db = new Conexion();
    if ($IdEstatus == 4) {
      $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '8' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
      $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.IdEstatus = '$IdEstatus' WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion'");
      $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.IdEstatus = '$IdEstatus', tblp_planeacion.FecAprobado = NOW(), tblp_planeacion.IdUsuaAprob = '$IdUsua' WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");

    } else {
      $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.IdEstatus = '$IdEstatus' WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion'");
      $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.IdEstatus = '$IdEstatus' WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function send_correoCorp($IdAsignacion)
  {
  }

  public function add_activarActividad($IdActividad, $IdParcial)
  {
    $db = new Conexion();
    $IdT = 0;

    $sql1 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwIdAsignacion = $datos2["IdAsignacion"];
    $rwIdGrupo = $datos2["IdGrupo"];
    $rwIdOferta = $datos2["IdOferta"];
    $rwIdAsignacion = $datos2["IdAsignacion"];
    $rwTipo = $datos2["Tipo"];
    $rwNoPar = $datos2["NoParcial"];
    $anio = date("Y");
    $mes = date("m");
    $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Mostrar = 'SI', tblp_actividadesdocente.IdEstatus = '8' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");

    $sql9 = $db->query("SELECT tblp_actividadesdocente.IdTipoActividad FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $rwIdTipo = $datos91["IdTipoActividad"];


    $sqlyx = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$rwIdAsignacion'");
    while ($zy = $db->recorrer($sqlyx)) {
      $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$rwIdAsignacion','" . $zy["IdUsua"] . "','$IdActividad','$IdParcial')");
      $IdTx = $db->insert_id;
      if ($rwIdTipo == 1) {
        $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus)VALUES('$IdTx','$rwIdAsignacion','$IdParcial','$IdActividad','" . $zy["IdUsua"] . "','12')");
      }
    }


    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '8' WHERE tblp_asignacion.IdAsignacion = '$rwIdAsignacion'");
    $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.IdEstatus = '4' WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial'");

    $sql33 = $db->query("SELECT tblp_grupo.IdEstatus FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$rwIdGrupo'");
    $db->rows($sql33);
    $datos331 = $db->recorrer($sql33);
    $rwIdEst = $datos331["IdEstatus"];
    if ($rwIdEst == 12) {
      $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdEstatus = '8' WHERE tblp_grupo.IdGrupo = '$rwIdGrupo'");
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdGrupo = '$rwIdGrupo'");
    }


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_activar_eva_id($IdActividad, $IdParcial)
  {
    $db = new Conexion();
    $IdT = 0;

    $sql1 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwIdAsignacion = $datos2["IdAsignacion"];
    $rwIdGrupo = $datos2["IdGrupo"];
    $rwIdOferta = $datos2["IdOferta"];
    $rwIdAsignacion = $datos2["IdAsignacion"];
    $rwTipo = $datos2["Tipo"];
    $rwNoPar = $datos2["NoParcial"];
    $anio = date("Y");
    $mes = date("m");
    $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Mostrar = 'SI', tblp_actividadesdocente.IdEstatus = '8' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");

    $sqlyx = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$rwIdAsignacion'");
    while ($zy = $db->recorrer($sqlyx)) {
      $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$rwIdAsignacion','" . $zy["IdUsua"] . "','$IdActividad','$IdParcial')");
      $IdTx = $db->insert_id;
      $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus, Valor)VALUES('$IdTx','$rwIdAsignacion','$IdParcial','$IdActividad','" . $zy["IdUsua"] . "','12','1')");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_estatusBanco($IdBanco, $Estatus)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblc_bancos SET IdEstatus = '$Estatus' WHERE tblc_bancos.IdBanco = '$IdBanco'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_configuracion($valorIngreso, $id)
  {
    $db = new Conexion();
    if ($id == 34) {
      $anio = substr($valorIngreso, 0, 4);
      $mes = substr($valorIngreso, 5, 2);
      $dia = substr($valorIngreso, 8, 2);
      $valorIngreso = $anio . '-' . $mes . '-' . $dia;
    }
    $insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Descripcion = '$valorIngreso' WHERE tblp_configuracion.IdConfig = '$id' ");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_precioCpt($valorIngreso, $campo, $IdConcepto)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblc_conceptos SET tblc_conceptos.$campo = '$valorIngreso' WHERE tblc_conceptos.IdConcepto = '$IdConcepto' ");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_concepto($IdConcepto)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT Count(tblp_pagos.IdPago) AS TotalConceptos, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdConcepto =  '$IdConcepto' GROUP BY tblp_pagos.IdConcepto");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwConceptos = $datos2["TotalConceptos"];

    if ($rwConceptos) {
      $insertar = 2;
    } else {
      $insertar = $db->query("DELETE FROM  tblc_conceptos WHERE tblc_conceptos.IdConcepto = '$IdConcepto' ");
    }


    if ($insertar) {
      return $insertar;
    } else {
      return $insertar;
    }
  }

  public function upd_newDocsIng($valorIngreso, $grado)
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblh_tipodocumento (Nombre,Grado, Valor, IdEstatus) VALUES ('$valorIngreso','$grado','1','8')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_newConcepto($valorIngreso)
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblc_conceptos (NomConcepto, Grado1, Grado2, Grado3, Grado4, Grado5, Solicitud) VALUES ('$valorIngreso','0','0','0','0','0','3')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_Enlazar()
  {
    $ciclo = $_POST["txtCiclo"];
    $grupo = $_POST["txtGrupo"];

    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCiclo =  '" . $_POST["txtCiclo"] . "' AND tblc_ciclogrupo.IdGrupo =  '" . $_POST["txtGrupo"] . "'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwCG = $datos2["IdCicloGrupo"];

    $sql2 = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdGrupo = '$grupo'");
    $db->rows($sql2);
    $datos2 = $db->recorrer($sql2);
    $IdCicg = $datos2["IdCiclo"];

    $sql_nivel = $db->query("SELECT Count(tblc_ciclogrupo.Grado) AS Total FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo =  '$grupo'");
    $db->rows($sql_nivel);
    $_nivel = $db->recorrer($sql_nivel);
    $_niv = $_nivel["Total"];
    $_niv = ($_niv + 1);

    if ($IdCicg == "") {
      $insertar = $db->query("UPDATE tblp_pagos SET IdCiclo = '$ciclo' WHERE tblp_pagos.IdGrupo = '$grupo'");
    }

    if ($rwCG) {
      return 2;
    } else {
      $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado) VALUES ('" . $_POST["txtCiclo"] . "','" . $_POST["txtGrupo"] . "',NOW(),'$_niv')");
      $insertar = $db->query("INSERT INTO tblp_evaluacion (IdCiclo, IdGrupo, Valor) VALUES ('" . $_POST["txtCiclo"] . "','" . $_POST["txtGrupo"] . "','1')");
      // $insertar = $db->query("INSERT INTO tbw_evaluacion (IdCiclo, IdGrupo, Valor) VALUES ('".$_POST["txtCiclo"]."','".$_POST["txtGrupo"]."','1')");

      $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$_niv' WHERE tblp_grupo.IdGrupo = '$grupo'");

      $sqlyx = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$grupo'");
      while ($zy = $db->recorrer($sqlyx)) {
        $IdUs = $zy['IdUsua'];

        $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','103','1','$ciclo','T')");
        $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','104','1','$ciclo','T')");
        $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','105','1','$ciclo','T')");
      }


      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    }
  }

  # AGREGAR OFERTA EDUCATIVA
  public function upd_OfertaE()
  {
    $tipo = $_POST["txtTipo"];

    if ($tipo == 1) {
      $nomTip = "Doctorado";
    } elseif ($tipo == 2) {
      $nomTip = "Maestria";
    } elseif ($tipo == 3) {
      $nomTip = "Licenciatura";
    } elseif ($tipo == 8) {
      $nomTip = "Curso";
    }

    $db = new Conexion();
    $cond = "";
    $carpeta = "assets/images/oferta/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtImagen"]['name']; //nombre del archivo
    if ($archivo) {
      $nomv = $_POST["ClaveO"];
      $tamaño = $_FILES["txtImagen"]['size']; //tamaño del archivo
      $_FILES["txtImagen"]['tmp_name'];
      $code = md5(rand() * time());
      $archivo = $nomv . '.png';
      if (!move_uploaded_file($_FILES["txtImagen"]['tmp_name'], $carpeta . $archivo)) {
        $_SESSION['Alerta'] = "0";
        echo "<script type='text/javascript'>window.location='adSelOferta.php';</script>";
        exit();
      }
      $cond = ", Imagen = '1'";
    }
    $insertar = $db->query("UPDATE tblp_educativa SET Tipo = '$nomTip', Numero = '" . $_POST["txtGrado"] . "', Nombre = '" . $_POST["txtNombre"] . "' $cond  WHERE tblp_educativa.IdEducativa = '" . $_POST["IdEducativa"] . "'");
    $o = $_POST["IdEducativa"];
    echo "<script type='text/javascript'>window.location='adUpdOferta.php?IdEducativa=1606421126$o';</script>";
    exit();
  }


  # ACTUALIZAR MODULO
  public function Upd_Modulo()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_modulo SET NombreMod = '" . $_POST["txtModulo"] . "' WHERE tblp_modulo.IdModulo = '" . $_POST["IdModulo"] . "'");


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  # AGREGAR DATOS MODULO
  public function add_ModuloDatos()
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_modulodatos (IdEducativa, IdModulo, Objetivo, Tema, Metodologia, Evaluacion, Bibliografia, FecCap) VALUES ('" . $_POST["txtOferta"] . "','" . $_POST["txtModulo"] . "','" . $_POST["txtObjetivo"] . "','" . $_POST["txtTema"] . "','" . $_POST["txtMetodologia"] . "','" . $_POST["txtEvaluacion"] . "','" . $_POST["txtBibliografia"] . "',NOW())");

    if ($insertar) {
      $_SESSION['Alerta'] = "GUARDAR";
      $_SESSION['Variable'] = "DATOS DE LA ASIGNATURA";
      echo "<script type='text/javascript'>window.location='adAddModDatos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL AGREGAR LOS DATOS DE LA ASIGNATURA";
      echo "<script type='text/javascript'>window.location='adAddModDatos.php';</script>";
    }
  }

  # AGREGAR DATOS MODULO
  public function get_addAviso()
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.NoModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdUsua = '" . $_POST["txtDocente"] . "' AND tblp_asignacion.IdEducativa = '" . $_POST["txtEducativa"] . "'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $IdEducativa = $datos2["IdEducativa"];
    $IdModulo = $datos2["IdModulo"];
    $insertar = $db->query("INSERT INTO tblp_aviso (IdOferta, IdModulo, Titulo, Mensaje, FecCap, IdAsignacion, IdDocente, IdUsua) VALUES ('$IdEducativa','$IdModulo','" . $_POST["txtTitulo"] . "','" . $_POST["txtMensaje"] . "',NOW(),'" . $_POST["txtModulo"] . "','" . $_POST["txtDocente"] . "','" . $_POST["IdUsua"] . "')");
    if ($insertar) {
      $_SESSION['Alerta'] = "GUARDAR";
      $_SESSION['Variable'] = " AVISO";
      echo "<script type='text/javascript'>window.location='acalstAviso.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " AVISO";
      echo "<script type='text/javascript'>window.location='acalstAviso.php';</script>";
    }
  }

  # SACAMOS LOS MESES
  public function get_listaAvisoss()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_aviso.IdAviso, tblp_aviso.IdOferta, tblp_aviso.IdModulo, tblp_aviso.Titulo, tblp_aviso.Mensaje, tblp_aviso.FecCap, tblp_aviso.IdUsua, tblp_aviso.Estatus, tblp_aviso.Tipo, tblp_aviso.IdAsignacion, tblp_aviso.IdDocente, tblp_educativa.Nombre, tblp_modulo.NoModulo, tblp_modulo.NombreMod FROM tblp_aviso Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_aviso.IdOferta Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_aviso.IdModulo");
    while ($x = $db->recorrer($sql)) {
      $gAvisosf[] = $x;
    }
    return $gAvisosf;
  }

  public function get_conceptosLst()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_conceptos");
    while ($x = $db->recorrer($sql)) {
      $gConceptosLSt[] = $x;
    }
    return $gConceptosLSt;
  }

  public function get_concepPlag($IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();

      $sql1 = $db->query("SELECT tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdOferta = $datos2["IdOferta"];
      $gConceptdosLStd = [];
      $sql = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_conceptosplanes.NomPlan FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta'");
      while ($x = $db->recorrer($sql)) {
        $gConceptdosLStd[] = $x;
      }
      return $gConceptdosLStd;
    }
  }
  public function get_planConcep()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_conceptos.IdConcepto, tblc_conceptos.Code, tblc_conceptos.IdGrado, tblc_conceptos.IdOferta, tblc_conceptos.NomConcepto, tblc_conceptos.Costo, tblp_educativa.Nombre FROM tblc_conceptos Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_conceptos.IdOferta");
    while ($x = $db->recorrer($sql)) {
      $gConceptosLSt[] = $x;
    }
    return $gConceptosLSt;
  }

  public function get_parcial_id($IdParcial)
  {
    $db = new Conexion();
    $get_parcial_id = [];
    $sql = $db->query("SELECT tblp_parcialdocente.IdEstatus FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial' ");
    while ($x = $db->recorrer($sql)) {
      $get_parcial_id[] = $x;
    }
    return $get_parcial_id;
  }


  # AGREGAR ASIGNACION MODULO A DOCENTES
  public function add_ModuloDocente()
  {
    $db = new Conexion();
    $anio = date("Y");
    $mes = date("m");
    $anioo = substr($anio, 2, 2);


    $sql6 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdModulo =  '" . $_POST["txtModulo"] . "' AND tblp_asignacion.IdGrupo = '" . $_POST["txtClaveGrp"] . "' AND tblp_asignacion.IdCiclo = '" . $_POST["txtCicloEscolar"] . "' ");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    
    if (!isset($datos61["IdAsignacion"])) {
      // $IdAsiX = $datos61["IdAsignacion"];
      $dir = 'assets/trabajos/' . $anio . '/' . $mes . '/';
      // $IdAsig = uniqid();
      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 15;
      $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
      $carpeta = $dir . $IdAsig;
      if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
      }

      $carpetaCrear2 = "assets/trabajos/$anio/$mes/$IdAsig/tareas";
      if (!file_exists($carpetaCrear2)) {
        mkdir($carpetaCrear2, 0777, true);
      }


      $Estatus = "Activo";
      $sql8 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '" . $_POST["txtClaveGrp"] . "'");
      $db->rows($sql8);
      $datos81 = $db->recorrer($sql8);
      $grupo = $datos81["Grupo"];
      $_dia = $datos81["Dia"];

      $sql3 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '" . $_POST["txtCicloEscolar"] . "'");
      $db->rows($sql3);
      $datos31 = $db->recorrer($sql3);
      $Fini = $datos31["FInicio"];
      $Ffin = $datos31["FFinal"];

      $sql5 = $db->query("SELECT Max(tblp_planeacion.Folio) AS Folio FROM tblp_planeacion WHERE tblp_planeacion.IdUsua = '" . $_POST["txtDocente"] . "'");
      $db->rows($sql5);
      $datos51 = $db->recorrer($sql5);
      $FFolio = $datos51["Folio"] + 1;

      $sql23 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '" . $_POST["txtDocente"] . "'");
      $db->rows($sql23);
      $datos231 = $db->recorrer($sql23);
      $idCam = $datos231["IdCampus"];
      $nom = substr($datos231["Nombre"], 0, 1);
      $pat = substr($datos231["APaterno"], 0, 1);
      $codNomPat = $nom . $pat;


      $sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo =  '" . $_POST["txtModulo"] . "'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdOferta = $datos91["IdEducativa"];
      $semcua = $datos91["Grado"];
      $codeMod = $datos91["CodeModulo"];
      $IdCamp = $datos91["IdCampus"];
      $NombreMod = $datos91["NombreMod"];
      $cadFol = str_pad($FFolio, 3, "0", STR_PAD_LEFT);

      $codeMod = substr($codeMod, 8, 1);
      $cod = $codeMod . $codNomPat . $anioo . $cadFol;

      $sql_n = $db->query("SELECT tblp_educativa.IdGrado, tblc_grado.Contenido FROM tblp_educativa Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql_n);
      $datos_n = $db->recorrer($sql_n);
      $_texto = $datos_n["Contenido"];
      $_idGrado = $datos_n["IdGrado"];
      $pxs = 0;

      $sql_pagx = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo =  '" . $_POST["txtClaveGrp"] . "' AND tblp_asignacion.Tipo =  '2' ");
      $db->rows($sql_pagx);
      $_pag = $db->recorrer($sql_pagx);
      $_idAigx = $_pag["IdAsignacion"];
      if (!$_idAigx) {
        $pxs = 0;
      }

      $anioHoy = date("Y");
      $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Curso, Anio, Mes, Fondo, _texto, _idEstatus, _estatus) VALUES ('$IdAsig','$IdOferta','" . $_POST["txtModulo"] . "','$grupo','" . $_POST["txtDocente"] . "','" . $_POST["datepicker"] . "','" . $_POST["datepicker2"] . "','$Estatus',NOW(),'2','" . $_POST["txtClaveGrp"] . "','" . $_POST["txtCicloEscolar"] . "','12','$IdCamp','0','$anio','$mes','img_1.jpg','$_texto','1','" . $_POST["txtAcepto"] . "')");
      $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Curso, Anio, Mes, Fondo, _texto, _idEstatus, _estatus) VALUES ('$IdAsig','$IdOferta','" . $_POST["txtModulo"] . "','$grupo','" . $_POST["txtTutor"] . "','" . $_POST["datepicker"] . "','" . $_POST["datepicker2"] . "','$Estatus',NOW(),'4','" . $_POST["txtClaveGrp"] . "','" . $_POST["txtCicloEscolar"] . "','12','$IdCamp','0','$anio','$mes','img_1.jpg','$_texto','1','" . $_POST["txtAcepto"] . "')");
      $insertar = $db->query("INSERT INTO tblp_planeacion (IdAsignacion,IdUsua,FecAsignacion, Folio, Planeacion, IdEstatus, IdCampus) VALUES ('$IdAsig','" . $_POST["txtDocente"] . "',NOW(),'$FFolio','$cod','31','$IdCamp')");

      if($_dia <> 'P'){
        // $sqly = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdOferta= '$IdOferta' AND tblc_usuario.IdGrupo= '" . $_POST["txtClaveGrp"] . "' AND ((tblc_usuario.IdEstatus = 8) || (tblc_usuario.IdEstatus = 50)) ");
        $sqly = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdCiclo= '" . $_POST["txtCicloEscolar"] . "' AND tblc_alumnos.IdGrupo= '" . $_POST["txtClaveGrp"] . "' AND tblc_alumnos.IdEstatus = 8 ");
        while ($z = $db->recorrer($sqly)) {
          $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','" . $_POST["txtModulo"] . "','$grupo','" . $z["IdUsua"] . "','Activo',NOW(),'$IdAsig','" . $_POST["txtClaveGrp"] . "')");
          // $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$semcua'  WHERE tblc_usuario.IdUsua = '" . $z["IdUsua"] . "'");
        }
      }
      


      $_v = 0;
      if ($_dia == 'S') {
        $_v = 6;
      }
      if ($_dia == 'D') {
        $_v = 7;
      }
      $cond_i = "";
      $cond_v = "";
      for ($i = 1; $i < 8; $i++) {
        if ($i == $_v) {
          $cond_i = " ,HraIni, MinIni, HraFin, MinFin, Total";
          $cond_v = ",'08','00','14','00','6'";
        } else {
          $cond_i = "";
          $cond_v = "";
        }
        $insertar = $db->query("INSERT INTO tblp_horario (IdAsignacion, IdDia $cond_i) VALUES ('$IdAsig','$i' $cond_v)");
      }

      $insertarx = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdGrado = '$semcua'  WHERE tblp_grupo.IdGrupo = '" . $_POST["txtClaveGrp"] . "'");


      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 2;
    }
  }


  public function add_mostrarExamen($IdAsignacion, $NoActividad)
  {
    $db = new Conexion();
    $sql8 = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.IdAsignacion =  '$IdAsignacion' AND tblp_actividad.NoActividad = '$NoActividad'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdActividad = $datos81["IdActividad"];
    $FecIni = $datos81["FecIni"];
    $FecFin = $datos81["FecFin"];

    $FecAct = date("Y-m-d");
    if (($FecAct >= $FecIni) && ($FecAct <= $FecFin)) {
      $Estatus = "Activo";
    } else {
      $Estatus = $datos81["Estatus"];
    }
    $insertar = $db->query("UPDATE tblp_actividad SET tblp_actividad.Estatus = '$Estatus', tblp_actividad.Valor = '1' WHERE tblp_actividad.IdActividad = '$IdActividad'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_activarExtra($IdParcialDoc, $IdPlaneacion)
  {
    $db = new Conexion();
    $sql8 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente =  '$IdParcialDoc'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $No = $datos81["NoParcial"];

    $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.Extra$No = '4' WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");
    $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.IdEstatus = '4' WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc'");
    if ($insertar) {

      return 1;
    } else {
      return 0;
    }
  }

  public function add_actExtraAlumno($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();

    $sql2 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo, tblp_asignacion.IdCampus FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdOferta = $datos21["IdEducativa"];
    $IdCiclo = $datos21["IdCiclo"];
    $IdGrupo = $datos21["IdGrupo"];
    $IdCampus = $datos21["IdCampus"];
    $IdModulo = $datos21["IdModulo"];

    $sql3 = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_conceptosplanes.Code, tblc_conceptosplanes.Costo FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdConcepto =  '6' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdContpD = $datos31["IdConceptoDetalle"];
    $Monto = $datos31["Costo"];
    $IdConceptoPlan = $datos31["IdConceptoPlan"];

    if ($IdContpD) {
      $sql4 = $db->query("SELECT tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
      $db->rows($sql4);
      $datos41 = $db->recorrer($sql4);
      $user = $datos41["Usuario"];

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Extra1 = '1' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");

      $anio = date('Y');
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,IdGrupo,Anio,Referencia,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, IdModulo, IdConcepto, TotalPagado, Recargos, Descuento) VALUES(0,'$IdUsua','$Monto','1','$IdOferta',NOW(),NOW(),NOW(),NOW(),NOW(),NOW(),'$IdCiclo','$IdGrupo','$anio','$user','$IdConceptoPlan','$IdCampus','NO-F23','1','$IdModulo','6',0,0,0)");

      if ($insertar) {

        return 1;
      } else {
        return 0;
      }
    } else {
      return 3;
    }
  }

  public function add_actLista($IdLista, $Dia, $TipoAsis)
  {
    $db = new Conexion();
    $dia = ($Dia * 1);
    $anioMes = date('Y-m');


    $insertar = $db->query("UPDATE tblp_lista SET tblp_lista.$dia = '$TipoAsis' WHERE tblp_lista.AnioMes = '$anioMes' AND tblp_lista.IdLista = '$IdLista'");
    if ($insertar) {

      return $TipoAsis;
    } else {
      return 0;
    }
  }

  public function add_pasarLista($IdAsistencia, $IdTipo)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_asistencia SET tblp_asistencia.IdTipo = $IdTipo, tblp_asistencia.FecCap = NOW() WHERE tblp_asistencia.IdAsistencia = '$IdAsistencia'");
    if ($insertar) {
      return $insertar;
    } else {
      return 0;
    }
  }

  public function add_actExtraAlumno2($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();

    $sql2 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo, tblp_asignacion.IdCampus FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdOferta = $datos21["IdEducativa"];
    $IdCiclo = $datos21["IdCiclo"];
    $IdGrupo = $datos21["IdGrupo"];
    $IdCampus = $datos21["IdCampus"];
    $IdModulo = $datos21["IdModulo"];

    $sql3 = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_conceptosplanes.Code, tblc_conceptosplanes.Costo FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdConcepto =  '9' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosplanes.Code =  'PPEXT2'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdContpD = $datos31["IdConceptoDetalle"];
    $Monto = $datos31["Costo"];
    $IdConceptoPlan = $datos31["IdConceptoPlan"];

    if ($IdContpD) {
      $sql4 = $db->query("SELECT tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
      $db->rows($sql4);
      $datos41 = $db->recorrer($sql4);
      $user = $datos41["Usuario"];

      $sql1 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdEstatus, tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente Left Join tblp_actividadesdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAsignacion' AND tblp_parcialdocente.NoParcial =  '1' AND tblp_parcialdocente.Tipo =  'E'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $IdActDoc = $datos11["IdActividadesDocente"];
      $IdEstatus = $datos11["IdEstatus"];
      $IdParDoc = $datos11["IdParcialDocente"];

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Extra2 = '1' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");

      $anio = date('Y');
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,IdGrupo,Anio,Referencia,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, IdModulo, TotalPagado, Recargos, Descuento) VALUES(0,'$IdUsua','$Monto','32','$IdOferta',NOW(),NOW(),NOW(),NOW(),NOW(),'$IdCiclo','$IdGrupo','$anio','$user','$IdConceptoPlan','$IdCampus','NO-F24','1','$IdModulo',0,0,0)");

      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 3;
    }
  }

  public function add_actExtraAlumno3($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();

    $sql2 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo, tblp_asignacion.IdCampus FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdOferta = $datos21["IdEducativa"];
    $IdCiclo = $datos21["IdCiclo"];
    $IdGrupo = $datos21["IdGrupo"];
    $IdCampus = $datos21["IdCampus"];
    $IdModulo = $datos21["IdModulo"];

    $sql3 = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_conceptosplanes.Code, tblc_conceptosplanes.Costo FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdConcepto =  '9' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosplanes.Code =  'PPEXT3'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdContpD = $datos31["IdConceptoDetalle"];
    $Monto = $datos31["Costo"];
    $IdConceptoPlan = $datos31["IdConceptoPlan"];

    if ($IdContpD) {
      $sql4 = $db->query("SELECT tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
      $db->rows($sql4);
      $datos41 = $db->recorrer($sql4);
      $user = $datos41["Usuario"];

      $sql1 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdEstatus, tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente Left Join tblp_actividadesdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAsignacion' AND tblp_parcialdocente.NoParcial =  '1' AND tblp_parcialdocente.Tipo =  'E'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $IdActDoc = $datos11["IdActividadesDocente"];
      $IdEstatus = $datos11["IdEstatus"];
      $IdParDoc = $datos11["IdParcialDocente"];

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Extra3 = '1' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");

      $anio = date('Y');
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,IdGrupo,Anio,Referencia,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, IdModulo) VALUES(0,'$IdUsua','$Monto','32','$IdOferta',NOW(),NOW(),NOW(),NOW(),NOW(),'$IdCiclo','$IdGrupo','$anio','$user','$IdConceptoPlan','$IdCampus','NO-F20','1','$IdModulo')");

      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 3;
    }
  }

  public function add_actRecursarAlum($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Recursar = '1' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");
    if ($insertar) {

      return 1;
    } else {
      return 0;
    }
  }

  # SUBIR CALIFICACION FINAL
  public function add_cveGrupoT($IdUsua, $IdGrupo)
  {
    $db = new Conexion();

    // $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdGrupo = '$IdGrupo' WHERE tblp_pagos.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_resEncuesta($IdRespuesta, $Valor)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblx_respuesta SET tblx_respuesta.Respuesta = '$Valor', tblx_respuesta.IdEstatus = '26' WHERE tblx_respuesta.IdRespuesta = '$IdRespuesta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_resEncuestaCal($IdRespuesta, $Valor)
  {
    $db = new Conexion();

    // $insertar = $db->query("UPDATE tblx_encuesta SET tblx_encuesta.Respuesta = '$Valor', tblx_encuesta.IdEstatus = '26' WHERE tblx_encuesta.IdEncuesta = '$IdRespuesta'");
    $insertar = $db->query("UPDATE tblx_respuesta SET tblx_respuesta.Respuesta = '$Valor', tblx_respuesta.IdEstatus = '26' WHERE tblx_respuesta.IdRespuesta = '$IdRespuesta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_resEncuestaOtro($IdRespuesta, $Texto)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblx_respuesta SET tblx_respuesta.Texto = '$Texto', tblx_respuesta.Respuesta = '6', tblx_respuesta.IdEstatus = '26' WHERE tblx_respuesta.IdRespuesta = '$IdRespuesta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_cerrarEncuesta($IdUsua, $IdAsignacion)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblc_encuesta.IdEncuesta, tblc_encuesta.Respuesta FROM tblc_encuesta WHERE tblc_encuesta.IdAsignacion='$IdAsignacion' AND tblc_encuesta.IdUsua = '$IdUsua' ORDER BY tblc_encuesta.Respuesta ASC");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $respuesta = $datos11["Respuesta"];
    if ($respuesta) {
      $insertar = $db->query("UPDATE tblc_encuesta SET tblc_encuesta.Estatus = '10' WHERE tblc_encuesta.IdAsignacion = '$IdAsignacion' AND tblc_encuesta.IdUsua = '$IdUsua'");
    }
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_delActividad($IdActividadDoc)
  {
    $db = new Conexion();

    $insertar = $db->query("DELETE FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_delBeca($IdBeca)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '24' WHERE tblp_beca.IdBeca = '$IdBeca'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_senPLan($IdPlan)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_plan SET tblp_plan.IdEstatus = '3' WHERE tblp_plan.IdPlan = '$IdPlan'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_addPlanPa($IdOferta, $IdConceptoPlan, $IdConcepto)
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblc_conceptosdetalle (IdConceptoPlan, IdOferta, IdConcepto)VALUES ('$IdConceptoPlan','$IdOferta','$IdConcepto')");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function del_delPlanPa($IdOferta, $IdConceptoPlan, $IdConcepto)
  {
    $db = new Conexion();

    $insertar = $db->query("DELETE FROM tblc_conceptosdetalle WHERE tblc_conceptosdetalle.IdConceptoPlan = '$IdConceptoPlan' AND tblc_conceptosdetalle.IdOferta = '$IdOferta' AND tblc_conceptosdetalle.IdConcepto = '$IdConcepto'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_enlaceGrupo($IdCicloGrupo, $IdGrupo, $IdCiclo)
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $iDaSIG = $datos11["IdAsignacion"];
    if ($iDaSIG) {
      return 2;
      exit();
    } else {
      $insertar = $db->query("DELETE FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCicloGrupo = '$IdCicloGrupo'");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_mstruics($IdOferta, $IdCampus, $Tipo, $Valor)
  {
    $db = new Conexion();

    if ($Valor == 0) {

      $sql1 = $db->query("SELECT * FROM tblc_seriacion WHERE tblc_seriacion.IdCampus = '$IdCampus' AND tblc_seriacion.IdOferta = '$IdOferta'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $iDaSIG = $datos11["IdSeriacion"];
      if ($iDaSIG) {
        return 2;
        exit();
      }

      $insertar = $db->query("INSERT INTO tblc_seriacion (Matricula, IdCampus, IdOferta)VALUES ('$Tipo','$IdCampus','$IdOferta')");
    } else {
      $insertar = $db->query("DELETE FROM tblc_seriacion WHERE tblc_seriacion.Matricula = '$Tipo' AND tblc_seriacion.IdCampus = '$IdCampus' AND tblc_seriacion.IdOferta = '$IdOferta' ");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_becagrp($IdGrupo, $IdCampus, $IdPlan, $Beca)
  {
    $db = new Conexion();


    $sqly = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdCampus = '$IdCampus'");
    while ($z = $db->recorrer($sqly)) {
      $IdUsua = $z["IdUsua"];

      //$insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdConceptoPlan = '$IdPlan'");
      //$insertar = $db->query("INSERT INTO tblp_beca (IdUsua, Porcentaje, FecCap, IdConceptoPlan, IdEstatus)VALUES ('$IdUsua','$Beca',NOW(),'$IdPlan','8')");
    }

    // if ($insertar) {
    //   return 1;
    // } else {
    //   return 0;
    // }
  }

  public function del_asignacion($IdAsignacion)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblp_horario WHERE tblp_horario.IdAsignacion = '$IdAsignacion'");
    $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    $insertar = $db->query("DELETE FROM tblp_planeacion WHERE tblp_planeacion.IdAsignacion = '$IdAsignacion'");
    
    $insertar = $db->query("DELETE FROM tblx_evaluacion WHERE tblx_evaluacion.IdAsignacion = '$IdAsignacion'");
    $insertar = $db->query("DELETE FROM tblx_respuesta WHERE tblx_respuesta.IdAsignacion = '$IdAsignacion'");
    
    $insertar = $db->query("DELETE FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");




    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savCurso($IdCurso, $txtCurso, $IdCampus)
  {
    $db = new Conexion();

    $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdCurso'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $cve = $datos21["Clave"];

    $sql1 = $db->query("SELECT Count(tblp_modulo.IdModulo) AS sumMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdCurso'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $sum = $datos11["sumMod"] + 1;
    $CodeModulo = "CURS" . $sum;

    $insertar = $db->query("INSERT INTO tblp_modulo (CodeModulo,NombreMod,Grado,Estatus,IdEducativa, Code,Oferta,IdCampus,FecCap) VALUES ('$CodeModulo','$txtCurso','5','Activo','$IdCurso','$CodeModulo','$cve','$IdCampus',NOW())");
    $IdModuloxX = $db->insert_id;

    $insertar = $db->query("INSERT INTO tblp_modulodatos (IdEducativa, IdModulo) VALUES ('$IdCurso','$IdModuloxX')");

    // $IdAsig = uniqid();
    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 9;
    $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

    $carpeta = 'assets/trabajos/' . $IdAsig;
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }
    $carpetaCrear2 = "assets/trabajos/$IdAsig/tareas";
    if (!file_exists($carpetaCrear2)) {
      mkdir($carpetaCrear2, 0777, true);
    }

    $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Curso) VALUES ('$IdAsig','$IdCurso','$IdModuloxX','X','En proceso',NOW(),'2','0','0','12','$IdCampus','1')");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_filtro($Filtro, $Tabla, $IdPago, $IdUsua, $IdRecargo)
  {
    $db = new Conexion();
    if ($Tabla == 1) {
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Filtro = '$Filtro' WHERE tblp_pagos.IdPago = '$IdPago' AND tblp_pagos.IdUsua = '$IdUsua'");
    } else {
      $insertar = $db->query("UPDATE tblp_recargos SET tblp_recargos.Filtro = '$Filtro' WHERE tblp_recargos.IdRecargo = '$IdRecargo' AND tblp_recargos.IdUsua = '$IdUsua'");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_recargo($IdPago, $IdUsua, $IdRecargo)
  {
    $db = new Conexion();

    $insertar = $db->query("DELETE FROM tblp_recargos WHERE tblp_recargos.IdRecargo = '$IdRecargo'");

    $sql8 = $db->query("SELECT Sum(tblp_recargos.Monto) AS Total FROM tblp_recargos WHERE tblp_recargos.IdPago =  '$IdPago' ");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $Total = $datos81["Total"];

     $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Recargos = '$Total'  WHERE tblp_pagos.IdPago = '$IdPago'");
    // $insertar = $db->query("UPDATE tblp_recargos SET tblp_recargos.IdUsuaE = '$IdUsua', tblp_recargos.FecCapE = NOW(), tblp_recargos.IdEstatus = '24' WHERE tblp_recargos.IdRecargo = '$IdRecargo'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_pagoAprobado($IdPago, $IdUsua, $IdFolio, $IdAdmin)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_foliospago SET tblp_foliospago.IdAdmin = '$IdAdmin', tblp_foliospago.IdEstatus = '11', tblp_foliospago.FecCancelado = NOW() WHERE tblp_foliospago.IdFolio = '$IdFolio'");

    $sql1 = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $TotalP = $datos11["TotalPagado"];
    $IdEst = $datos11["IdEstatus"];

    $sql2 = $db->query("SELECT * FROM tblp_foliospago WHERE tblp_foliospago.IdFolio = '$IdFolio'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $Monto = $datos21["Monto"];

    if ($IdEst == 4) {
      $IdEst = 32;
    } else {
      $IdEst = $IdEst;
    }

    $totalNew = ($TotalP - $Monto);

    $insertar = $db->query("INSERT INTO tblp_foliospagocancelado SELECT * FROM tblp_foliospago WHERE tblp_foliospago.IdFolio='$IdFolio'");
    $IdFolioNew = $db->insert_id;
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '$IdEst', tblp_pagos.TotalPagado = '$totalNew' WHERE tblp_pagos.IdPago = '$IdPago'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_hora($IdModulo, $Code, $Campo, $Horas)
  {
    $db = new Conexion();
    $code = substr($Code, 0, 3);
    $oferta = substr($Code, 3, 3);


    $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.$Campo = '$Horas' WHERE tblp_modulo.Code = '$oferta' AND tblp_modulo.Oferta = '$code'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_docSolicitado($IdDoc)
  {
    $carpeta = "assets/docs/Solicitudes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
    $_FILES["txtDocumento"]['tmp_name'];
    $code = md5(rand() * time());
    $archivo = $code . '-' . $archivo;
    if (!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adDocSolicitado.php';</script>";
      exit();
    }
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblc_docsolicitado SET tblc_docsolicitado.Archivo = '$archivo', tblc_docsolicitado.IdEstatus = '13', tblc_docsolicitado.FechaEntrega = NOW()  WHERE tblc_docsolicitado.IdDocSolicitado = '$IdDoc'");
    if ($insertar) {
      $sql1 = $db->query("SELECT tblc_docsolicitado.IdDocSolicitado, tblc_docsolicitado.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdCampus, tblc_usuario.Correo, tblc_docsolicitado.Archivo, tblc_conceptos.NomConcepto FROM tblc_docsolicitado Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_docsolicitado.IdUsua Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_docsolicitado.IdConcepto WHERE tblc_docsolicitado.IdDocSolicitado =  '$IdDoc'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $destinatario = $datos11["Correo"];
      $concepto = $datos11["NomConcepto"];
      $idCam = $datos11["IdCampus"];
      $Nombre = $datos11["Nombre"] . ' ' . $datos11["APaterno"] . ' ' . $datos11["AMaterno"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];


      $urldescargar =  $url . 'assets/docs/Solicitudes/' . $archivo;
      $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
      $linkClicImg = $url . 'assets/images/click.png';

      $sql34 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '13' ");
      $db->rows($sql34);
      $datos341 = $db->recorrer($sql34);
      $direccion = $datos341["Descripcion"];
      $porciones = explode("CP", $direccion);
      $pie1 = $porciones[0];
      $pie2 = 'CP' . $porciones[1];

      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'dXQZ0V6pyfM5B1tG');
      $data = array(
        "to" => array("$destinatario" => " $Nombre "),
        //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
        "from" => array("info@uni.edu.mx", " $Institucion"),
        "subject" => "Documento solicitado disponible para descargar",
        "text" => "Plataforma de Educación | $Institucion",

        "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
                     <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
                <tr>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                      <img src= '$linkLogo' >
                    </b></td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    Hola: $Nombre
                    </b></td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    El documento solicitado: <b> $concepto </b> <br><br>Ya se encuentra disponible para descargar.
                    </b></td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                      <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                      <a href='$urldescargar'>
                              <img src= '$linkClicImg' >
                              </a>
                    </b>
                    </td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:18px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    Tambi&eacute;n lo puede descargar desde la plataforma ubicado en:<br>
                      Mi espacio > Estatus financiero > Mis pagos aprobados
                    </b></td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    <hr>
                      <p style='font-size: 12px; color: black;'>Favor de no responder este correo, enviado automáticamente por la Plataforma Educativa. <br>

                      </p>
                      <br><br>
                    </b></td>
                </tr>
              </table>",
        "attachment" => array(),
        "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
        "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
      );
      $mailin->send_email($data);
      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='adDocSolicitado.php';</script>";
    } else {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='adDocSolicitado.php';</script>";
    }
  }

  public function add_facturasSol($IdPago)
  {
    $carpeta = "assets/docs/Facturas/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
    $_FILES["txtDocumento"]['tmp_name'];
    $archivo = time() . '_' . $archivo;
    if (!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adFacturas.php';</script>";
      exit();
    }
    $db = new Conexion();
    $fecha = $_POST['datepicker1'];
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.DocFactura = '$archivo', tblp_pagos.FacturaEstatus = '13', tblp_pagos.FecFactura = '$fecha' WHERE tblp_pagos.IdPago = '$IdPago'");
    if ($insertar) {
      $sql1 = $db->query("SELECT tblp_pagos.IdPago, tblc_usuario.Nombre, tblc_usuario.IdCampus, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_conceptos.NomConcepto FROM tblp_pagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdPago =  '$IdPago'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);

      $concepto = $datos11["NomConcepto"];
      $idCam = $datos11["IdCampus"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];
      $nom_plataforma = $_camp["Texto"];
      $url_logo =  $url . 'assets/images/campus/logo_inicio.png';

      $urldescargar =  $url . 'assets/docs/Facturas/' . $archivo;

      $destinatario = $datos11["Correo"];
      $asunto = 'Factura solicitada, disponible en la ' . $nom_plataforma;
      $nombre = htmlentities($datos11["Nombre"] . ' ' . $datos11["APaterno"] . ' ' . $datos11["AMaterno"]);

      $cuerpo = "<table id='x_bodyTable' style='border-collapse: collapse; height: 100%; margin: 0px; padding: 0px; width: 100%; transform: scale(0.87); transform-origin: left top 0px;' min-scale='0.87' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td id='x_bodyCell' style='height:100%; margin:0; padding:0; width:100%' valign='top' align='center'><table style='border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td id='x_templateHeader' style='background:#F7F7F7 none no-repeat center/cover; background-color:#F7F7F7; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0px; padding-bottom:0px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_headerContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'></td></tr></tbody></table></td></tr><tr><td id='x_templateBody' style='background:#FFFFFF none no-repeat center/cover; background-color:#FFFFFF; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:27px; padding-bottom:63px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_bodyContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; color:#828282; word-break:break-word; font-family:Helvetica; font-size:16px; line-height:150%; text-align:left' valign='top'></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnImageBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnImageBlockOuter'><tr><td class='x_mcnImageBlockInner' style='padding:9px' valign='top'><table class='x_mcnImageContentContainer' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnImageContent' style='padding-right:9px; padding-left:9px; padding-top:0; padding-bottom:0; text-align:center' valign='top'><img data-imagetype='External' src='$url_logo' width='250px' alt='' class='x_mcnImage' style='max-width:2400px; padding-bottom:0; display:inline!important; vertical-align:bottom; border:0; height:auto; outline:none; text-decoration:none' width='564' align='middle'> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; font-family:Lato,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; word-break:break-word; color:#757575; font-size:16px; line-height:150%; text-align:left' valign='top'><p style='text-align: center;'><strong>Factura disponible</strong></p><br><br>Estimado(a) alumno(a)<strong> $nombre, </strong> se le notifica que tiene disponible su factura para poder ser descargado.<br><br> <br><br></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnButtonBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnButtonBlockOuter'><tr><td class='x_mcnButtonBlockInner' style='padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px' valign='top' align='center'><table class='x_mcnButtonContentContainer' style='border-collapse:separate!important; border-radius:28px; background-color:#0047FF' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td class='x_mcnButtonContent' style='font-family:Arial; font-size:16px; padding:18px' valign='middle' align='center'><a href='$urldescargar' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' class='x_mcnButton' title='Ir a la Plataforma' style='font-weight:bold; letter-spacing:normal; line-height:100%; text-align:center; text-decoration:none; color:#FFFFFF; display:block'>Clic para descargar la factura</a> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnDividerBlock' style='min-width:100%; border-collapse:collapse; table-layout:fixed!important' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnDividerBlockOuter'><tr><td class='x_mcnDividerBlockInner' style='min-width:100%; padding:18px'><table class='x_mcnDividerContent' style='min-width:100%; border-top:2px solid #EAEAEA; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style=''><span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table> ";


      $headers = "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
      $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

      mail($destinatario, $asunto, $cuerpo, $headers);

      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='adFacturas.php?s=12';</script>";
    } else {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='adFacturas.php?s=12';</script>";
    }
  }

  public function add_sendNotificar($IdUsua)
  {
    $db = new Conexion();
    $comen = $_POST["txtComentario"];
    $IdPermiso = $_POST["IdPermiso"];
    $IdEncargado = $_POST["IdEncargado"];

    $insertar = $db->query("INSERT INTO tblh_notificar (IdUsua, Comentario, FecCap, IdPermiso, IdCaptura) VALUES ('$IdUsua','$comen', NOW(),'$IdPermiso','$IdEncargado') ");

    if ($insertar) {
      $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $destinatario = $datos11["Correo"];
      $folio = $datos11["Folio"];
      $idCam = $datos11["IdCampus"];
      $Nombre = $datos11["Nombre"] . ' ' . $datos11["APaterno"] . ' ' . $datos11["AMaterno"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];

      $urldescargar =  $url . 'continuar.php';
      $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
      $linkClicImg = $url . 'assets/images/click.png';

      $sql34 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '13' ");
      $db->rows($sql34);
      $datos341 = $db->recorrer($sql34);
      $direccion = $datos341["Descripcion"];
      $porciones = explode("CP", $direccion);
      $pie1 = $porciones[0];
      $pie2 = 'CP' . $porciones[1];
      $sqlLst = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua =  '$IdUsua' AND tblc_docalumnos.Estatus =  '5'");
      $docNoAprobados = "
          <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
            <tr>
              <th> Documentos no aprobados: </th>
            </tr>";
      while ($x = $db->recorrer($sqlLst)) {
        $nom = $x["NomDocumento"];
        $docNoAprobados .= "
              <tr> <td> >  $nom </td> </tr>
              ";
      }
      $docNoAprobados .= "
          </table>
        ";
      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'dXQZ0V6pyfM5B1tG');
      $data = array(
        "to" => array("$destinatario" => " $Nombre "),
        //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
        "from" => array("info@uni.edu.mx", " $Institucion"),
        "subject" => "Notificación de documentos NO APROBADOS",
        "text" => "Plataforma de Educación | $Institucion",

        "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
                     <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial;'>
                <tr>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                      <img src= '$linkLogo' >
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    HOLA: $Nombre
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='justify'>
                    <b style='color:#676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    El presente correo electrónico es para hacerle de su conocimiento que la documentación que usted envió, NO FUE APROBADA, siendo la siguiente:
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='justify'>
                    $docNoAprobados
                    </td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='justify'>
                    <b style='color:#676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    Por lo cual le requerimos, nos reenvié la documentación señalada para completar el proceso de inscripción.
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='justify'>
                    <b style='color:#676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    Mensaje: $comen
                    </b></td>
                </tr>


                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                      <b style=' color: rgb(105, 108, 110); font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                      Para continuar con el proceso de su inscripción le solicitamos
                      que envie los documentos pendientes: <br>
                      Folio: <b>$folio</b>
                      <br>
                      <a href='$urldescargar'>
                        <img src= '$linkClicImg' >
                      </a>
                    </b>
                    </td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                      <b style=' color: rgb(105, 108, 110); font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    <hr>
                    <p style='font-size: 12px; color: black;'>Favor de no responder este correo, enviado automáticamente por la Plataforma Educativa. <br>

                    </p>
                    <br><br>
                    </b>
                    </td>
                </tr>
              </table>",
        "attachment" => array(),
        "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
        "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
      );
      $mailin->send_email($data);
      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='ctrlProspectos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='ctrlProspectos.php';</script>";
    }
  }

  public function add_notificarP($IdEncargado, $txtMensaje, $IdUsua, $IdPermiso)
  {
    $db = new Conexion();
    $comen = $txtMensaje;
    $IdPermiso = $IdPermiso;
    $insertar = $db->query("INSERT INTO tblh_notificar (IdUsua, Comentario, FecCap, IdPermiso, IdCaptura) VALUES ('$IdUsua','$comen', NOW(),'$IdPermiso','$IdEncargado') ");


    if ($insertar) {
      $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $destinatario = $datos11["Correo"];
      $folio = $datos11["Folio"];
      $idCam = $datos11["IdCampus"];
      $Nombre = $datos11["Nombre"] . ' ' . $datos11["APaterno"] . ' ' . $datos11["AMaterno"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];

      $urldescargar =  $url . 'continuar.php';
      $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
      $linkClicImg = $url . 'assets/images/click.png';

      $sql34 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '13' ");
      $db->rows($sql34);
      $datos341 = $db->recorrer($sql34);
      $direccion = $datos341["Descripcion"];
      $porciones = explode("CP", $direccion);
      $pie1 = $porciones[0];
      $pie2 = 'CP' . $porciones[1];
      $sqlLst = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua =  '$IdUsua' AND tblc_docalumnos.Estatus =  '5'");

      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'dXQZ0V6pyfM5B1tG');
      $data = array(
        "to" => array("$destinatario" => " $Nombre "),
        //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
        "from" => array("info@uni.edu.mx", " $Institucion"),
        "subject" => "Notificación de seguimiento",
        "text" => "Plataforma de Educación | $Institucion",

        "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
                     <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial;'>
                <tr>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                      <img src= '$linkLogo' >
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    HOLA: $Nombre
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='justify'>
                    <b style='color:#676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    Mensaje: $comen
                    </b></td>
                </tr>
                <tr style=' color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                      <b style=' color: rgb(105, 108, 110); font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    <hr>
                    <p style='font-size: 12px; color: black;'>Favor de no responder este correo, enviado automáticamente por la Plataforma Educativa. <br>

                    </p>
                    <br><br>
                    </b>
                    </td>
                </tr>
              </table>",
        "attachment" => array(),
        "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
        "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
      );
      $mailin->send_email($data);
      return 1;
    } else {
      return 0;
    }
  }

  public function add_bajaUsuario($IdUsua)
  {
    $db = new Conexion();
    $Estatus = $_POST['txtEstatus'];
    $TipoBa = $_POST['Tipo'];
    $IdAdministrador = $_POST['IdAdministrador'];
    $Comentario = $_POST['txtComentario'];
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '$Estatus' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("INSERT INTO tblh_baja (IdUsua, IdEstatus, Comentario, FecCap, IdAdministrador, Tipo) VALUES('$IdUsua','$Estatus','$Comentario', NOW(), '$IdAdministrador','BAJA1') ");
    if ($TipoBa == "Sol") {
      $insertar = $db->query("UPDATE tblc_doctramite SET tblc_doctramite.Estatus = '4' WHERE tblc_doctramite.IdUsua = '$IdUsua' AND tblc_doctramite.Tipo = '45'");
    }

    if ($insertar) {
      $sql1 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdCampus, tblc_usuario.Cargo, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.IdUsua = '$IdUsua'");
      $db->rows($sql1);
      $datos11 = $db->recorrer($sql1);
      $IdUUUU = $datos11["IdUsua"];
      $destinatario = $datos11["Correo"];
      $estatusN = $datos11["Estatus"];
      $idCam = $datos11["IdCampus"];
      $Nombre = $datos11["Nombre"] . ' ' . $datos11["APaterno"] . ' ' . $datos11["AMaterno"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];

      $tiempo = time();
      $var = uniqid();
      $var2 = uniqid();
      $token = $tiempo . $var . $var2 . $tiempo . $IdUUUU;
      $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
      $linkClicImg = $url . 'assets/images/click.png';
      $urlDescargarPDF = $url . 'repositorio/pdf/docBaja.php?tokenId=' . $token;

      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'dXQZ0V6pyfM5B1tG');
      $data = array(
        "to" => array("$destinatario" => " $Nombre "),
        //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
        "from" => array("info@uni.edu.mx", " $Institucion"),
        "subject" => "Ajuste de estatus en la Plataforma",
        "text" => "Plataforma de Educación | $Institucion",

        "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
                     <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
                <tr>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                      <img src= '$linkLogo' >
                    </b></td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    Hola: $Nombre
                    </b></td>
                </tr>
                <tr style='background: #f5f5f5; color: #676a8f;'>
                    <td colspan='3' height='100' align='center'>
                    <b style='color:#676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                    La Institución le ha puesto un estatus:<br> <b>$estatusN</b>.  <br><br>
                    <b>Mensaje:</b><br> '$Comentario'

                    <br><br>
                    <hr>
                    <p style='font-size: 12px; color: black;'>Favor de no responder este correo, enviado automáticamente por la Plataforma Educativa. <br>

                    </p>
                    <br><br>
                    </b></td>
                </tr>
              </table>",
        "attachment" => array(),
        "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
        "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
      );
      $mailin->send_email($data);
      $_SESSION['Alerta'] = "1";
      if ($TipoBa == "Sol") {
        echo "<script type='text/javascript'>window.location='adSolBaja.php';</script>";
      } else {
        echo "<script type='text/javascript'>window.location='adSelAllUsuarios.php';</script>";
      }
    } else {
      $_SESSION['Alerta'] = "2";
      if ($TipoBa == "Sol") {
        echo "<script type='text/javascript'>window.location='adSolBaja.php';</script>";
      } else {
        echo "<script type='text/javascript'>window.location='adSelAllUsuarios.php';</script>";
      }
    }
  }

  public function add_cerrarEstatus($IdOferta, $IdUsua, $Inscripcion, $Colegiatura, $Fecha, $IdGrado)
  {
    $valor = 0;
    $db = new Conexion();
    $anioHoy = date("Y");
    $anioActual = substr($anioHoy, 2, 2);

    $sqly = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.Tipo ='1'");
    while ($z = $db->recorrer($sqly)) {
      $sql34 = $db->query("SELECT Max(tblp_pagos.Folio) AS Ultimo FROM tblp_pagos WHERE tblp_pagos.Anio = '$anioHoy'");
      $db->rows($sql34);
      $datos341 = $db->recorrer($sql34);
      $folio = $datos341["Ultimo"] + 1;
      $code = str_pad($folio, 5, "0", STR_PAD_LEFT);

      $referencia = $anioActual . $code;
      $id = $z["IdConcepto"];
      $pagar = "txtPrecio-" . $id;
      $precio = $z["Grado$IdGrado"];
      if ($valor == 0) {
        $pagar = $Inscripcion;
        $valor = 1;
      } else {
        $pagar = $Colegiatura;
      }
      if ($pagar == 0) {
        $pagado = "0";
        $IdEstatus = 4;
        $cont1 = ", IdTipoDescuento, IdDescuento ";
        $cont2 = ", '6', '6' ";
      } else {
        $pagado = "";
        $IdEstatus = 1;
        $cont1 = "";
        $cont2 = "";
      }
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua, IdConcepto, IdEstatus, IdOferta, FecCap, Monto, Pagar, TotalPagado, Facturar, TipoSolicitud, FecLimPago, Anio, Folio, EstatusDescuento, Referencia $cont1) VALUES('$IdUsua','$id','$IdEstatus','$IdOferta',NOW(),'$precio','$pagar','0','NO-F26','1','$Fecha','$anioHoy','$folio','23','$referencia' $cont2)");
    }


    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Documentos = 'SI', tblc_usuario.Estatus = 'Completo', tblc_usuario.IdEstatus = '8'  WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE IdUsua = '$IdUsua'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $code = $datos2["Code"];
    $fol = $datos2["Folio"];
    $correo = $datos2["Correo"];
    $IdEduca = $datos2["IdOferta"];
    $idCam = $datos2["IdCampus"];
    $destinatario = $datos2["Correo"];
    $Nombre = $datos2["Nombre"] . ' ' . $datos2["APaterno"] . ' ' . $datos2["AMaterno"];

    $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdEduca'");
    $db->rows($sql2);
    $datos3 = $db->recorrer($sql2);
    $OfertaEduca = $datos3["Nombre"];

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $Institucion = $_camp["Campus"];

    $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
    $linkClicImg = $url . 'assets/images/click.png';

    $sql34 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '13' ");
    $db->rows($sql34);
    $datos341 = $db->recorrer($sql34);
    $direccion = $datos341["Descripcion"];
    $porciones = explode("CP", $direccion);
    $pie1 = $porciones[0];
    $pie2 = 'CP' . $porciones[1];
    require('Mailin.php');
    $mailin = new Mailin('https://api.sendinblue.com/v2.0', 'dXQZ0V6pyfM5B1tG');
    $data = array(
      "to" => array("$destinatario" => " $Nombre "),
      "from" => array("info@uni.edu.mx", " $Institucion"),
      "subject" => "Felicidades, estas a un paso de formar parte de $Institucion",
      "text" => "Plataforma de Educación | $Institucion",

      "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"1\">
    					   <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
            <tr>
                <td colspan='3' height='100' align='center'>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <img src= '$linkLogo' >
                </b></td>
            </tr>

            <tr style='color: #676a8f;'>
                <td colspan='3' height='100' align='center'><br>
                <p style='color: #676a8f; font-size:14px; padding: 5px; text-align: justify; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Nuestro compromiso, es de estar siempre a la vanguardia y cumpliendo con nuestra filosof&iacute;a institucional <b>con sentido humano y visi&oacute;n global sustentable</b>, nos permiten ofrecerte esta Plataforma Tecnol&oacute;gica Educativa, para que contin&uacute;es con tus estudios profesionales y logres alcanzar todas tus metas.<br><br>
                </p></td>
            </tr>
    			  <tr>
            <td colspan='3' style='color: #676a8f;'>
              <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                <tr>
                  <td colspan='2' style=' text-align: center; font-size: 16px; color: red; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <b style='color: #676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  Favor de revisar su estatus financiero <br> Espacio > Estatus Financiero</b>
                  </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Alumno: </td><td style='padding: 10px;'> $Nombre </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Oferta educativa: </td><td style='padding: 10px;'> $OfertaEduca </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Usuario: </td><td style='padding: 10px;'> $correo </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Password: </td><td style='padding: 10px;'> $code </td>
                </tr>
              </table>
    				</td>
            </tr>
            <tr style='color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Para ingresar a la Plataforma de Educaci&oacute;n en L&iacute;nea<br>
                <a href='$url'>
                  HAZ CLICK AQU&Iacute;
                </a>
                </b><br>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                <a href='$url'>
                  <img src= '$linkClicImg' >
                </a>
                </b>
                </td>
            </tr>
            <tr style='color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <hr>
                  <p style='font-size: 12px; color: black;'>Favor de no responder este correo, enviado automáticamente por la Plataforma Educativa. <br>

                  </p>
                  <br><br>
                </b>
                </td>
            </tr>
        	</table>",

      "attachment" => array(),
      "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
      "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
    );
    $c =  var_dump($mailin->send_email($data));
    if ($insertar) {
      return $c;
    } else {
      return 0;
    }
  }

  public function add_closeServicio($NomPrograma, $NomDependencia, $Periodo, $Fecha, $IdUsua, $Registro)
  {
    $valor = 0;
    $db = new Conexion();
    $sql9 = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdServicio = $datos91["IdServicio"];
    if ($IdServicio) {
      $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.NomPrograma = '$NomPrograma', tblp_servicio.NomDependencia = '$NomDependencia', tblp_servicio.Periodo = '$Periodo',tblp_servicio.FecImpresion = '$Fecha', tblp_servicio.IdEstatus = '10',tblp_servicio.Registro = '$Registro' WHERE tblp_servicio.IdServicio = '$IdServicio'");
    } else {
      $insertar = $db->query("INSERT INTO tblp_servicio (IdUsua, NomPrograma,NomDependencia,Periodo,FecImpresion,IdEstatus,Registro) VALUES ('$IdUsua', '$NomPrograma','$NomDependencia','$Periodo','$Fecha','10','$Registro')");
    }


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_pagosTodos($Forma, $IdUsua, $Fecha, $IdUsuaCap, $division, $TPagar, $IdBanco, $Nota, $IdProcedencia, $IdAdmin, $Folio)
  {
    $db = new Conexion();
    $anio = date("Y");
    $anio_ok = date("Y");

    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 1;
    $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

    $_anio = substr($anio, 2, 2);
    
    $IdUsua = substr($IdUsua, 10, 10);
    $messs = substr($Fecha, 5, 2);
    $anio = substr($Fecha, 0, 4);
    $_anio = substr($anio, 2, 2);
    $_mes = date("m");
    $_dia = date("d");

    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_campus.Letra FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_us);
    $datos_u = $db->recorrer($sql_us);
    $_IdOferta = $datos_u["IdOferta"];
    $_IdCampus = $datos_u["IdCampus"];
    $idCam = $datos_u["Letra"];

    $_anioFol = substr($anio_ok, 2, 2);

    $folio = $db->query("SELECT tblp_foliospago.Folio FROM tblp_foliospago WHERE tblp_foliospago.Anio = '$anio_ok' ORDER BY tblp_foliospago.Folio DESC");
    $db->rows($folio);
    $_folx = $db->recorrer($folio);
    $_nofolx = $_folx['Folio'] + 1;
    $cadenaNumero = $_anioFol . str_pad($_nofolx, 5, "0", STR_PAD_LEFT);
    $cadenaNumero = $idCam.$cadenaNumero.$cod;

    $_sum = 0;
    $sqlP = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.Valor = '1' AND tblp_pagos.IdEstatus <> '4' ORDER BY tblp_pagos.Indicador ASC");
    while ($P = $db->recorrer($sqlP)) {
      $descInd = 0;
      $_ind = $P["Indicador"];
      $_IdCiclo = $P["IdCiclo"];
      $IdPag = $P["IdPago"];
      $IdConcepto = $P["IdConcepto"];
     
      $pagarAhora = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);

      $_abn = ($TPagar - $_sum);

      $_aniox = substr($Fecha, 0, 4);
      $_mesx = substr($Fecha, 5, 2);

      $anioM = $_aniox . '-' . $_mesx;
      $pagadoActual = $P["TotalPagado"];
      $_met = '';
      if ($_ind == 0) { 
        ## PAGO COMPLETO
        if($pagadoActual == 0){ $_met = 'PUE'; // VERIFICADO CUANDO ES UN PAGO COMPLETO
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = $P["Descuento"];
          $total = $pagarAhora;
          $recargo = $P["Recargos"];
        } else { $_met = 'PPD';
          //$importe = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);
          $total = $pagarAhora;
          $recargo = 0;
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = ($importe - $pagarAhora);
        }
        
        $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco, Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _importe, _descuento, _total, _tipo, _metodo, _recargo, _fac)  VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','4',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$pagarAhora','$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM', '$_IdCiclo','1','$importe','$descuento','$total','CAJA','$_met','$recargo','1')");
        $IdFolio = $db->insert_id;
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '0', tblp_pagos.FolioPago = '$cadenaNumero', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.IdEstatus = '4', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$pagarAhora', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
      } else { 
        ## PAGO CON ABONO
        $totalP = $P["TotalPagado"];
        $acdPag = ($_abn + $totalP);
        $idEstx = 1;
        if($pagadoActual == 0){
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = ($importe - $_abn);
          $total = $_abn;
          if($importe == $_abn){
            $_met = 'PUE';
            $idEstx = 4;
            $_importe = ($P["Monto"] + $P["Recargos"]);
            $descuento = ($_importe - $_abn);

          } else {
            $_importe = $_abn;
            $descuento = 0;
            $_met = 'PPD';
            $idEstx = 1;
          }
        } else {
          $importe = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);
          if($importe == $_abn){ 
            $_met = 'PUE';
            $descuento = 0;  
            $idEstx = 4;
            $_importe = ($P["Monto"] + $P["Recargos"]);
            $descuento = ($_importe - $_abn);
          } else {
            $_met = 'PPD';
            $_importe = $_abn;
            $descuento = 0;
          }
          $total = $_abn;
        }

        $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco,Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _importe, _descuento, _total, _tipo, _metodo, _fac) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','37',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$_abn', '$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM','$_IdCiclo','1','$_importe','$descuento','$total','CAJA','$_met','1')");
        $IdFolio = $db->insert_id;
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '$idEstx', tblp_pagos.Valor = '0', tblp_pagos.Indicador = '0', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$acdPag', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
        $insertar = $db->query("INSERT INTO tblp_abono_pago (IdPago, Folio, Monto, FecCap) VALUES('$IdPag','$_nofolx','$_abn',NOW())");
      }
      $_sum = ($_sum + $pagarAhora);

      if($IdConcepto == 12){
          
        $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 20;
        $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
        $mesdia= date("md");
        $hoy = date("YmdHms");
        $numero = $idCam.$_anio.$mesdia."|DLB|".$hoy.'|'.$_IdOferta.'|'.$IdPag.'|'.$cadenaNumero;
        $insertar = $db->query("INSERT INTO tblp_donacion (IdFolio, Folio, Numero, Monto, Code, FecCap, IdUsua) VALUES('$IdFolio','$cadenaNumero','$numero','$pagarAhora','$cod',NOW(),'$IdUsua')");
      }
    }
    
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_pagos_especiales_all($Forma, $IdUsua, $Fecha, $IdUsuaCap, $division, $TPagar, $IdBanco, $Nota, $IdProcedencia, $IdAdmin, $Folio, $IdTemporal)
  {   
    $db = new Conexion();

    $anio = date("Y");
    $anio_ok = date("Y");

    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 1;
    $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

    $_anio = substr($anio, 2, 2);
    
    $messs = substr($Fecha, 5, 2);
    $anio = substr($Fecha, 0, 4);
    $_anio = substr($anio, 2, 2);
    $_mes = date("m");
    $_dia = date("d");

    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_campus.Letra FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_us);
    $datos_u = $db->recorrer($sql_us);
    $_IdOferta = $datos_u["IdOferta"];
    $_IdCampus = $datos_u["IdCampus"];
    $idCam = $datos_u["Letra"];

    $_anioFol = substr($anio_ok, 2, 2);

    $folio = $db->query("SELECT tblp_foliospago.Folio FROM tblp_foliospago WHERE tblp_foliospago.Anio = '$anio_ok' ORDER BY tblp_foliospago.Folio DESC");
    $db->rows($folio);
    $_folx = $db->recorrer($folio);
    $_nofolx = $_folx['Folio'] + 1;
    $cadenaNumero = $_anioFol . str_pad($_nofolx, 5, "0", STR_PAD_LEFT);
    $cadenaNumero = $idCam.$cadenaNumero.$cod;


    $anio = date("Y");
    $_anio = substr($anio, 2, 2);
    // $folio = $db->query("SELECT tblp_foliospago.Folio FROM tblp_foliospago WHERE tblp_foliospago.Anio = '$anio' ORDER BY tblp_foliospago.Folio DESC");
    // $db->rows($folio);
    // $_folx = $db->recorrer($folio);
    // $_nofolx = $_folx['Folio'] + 1;
    // $cadenaNumero = $_anio . str_pad($_nofolx, 5, "0", STR_PAD_LEFT);

    $IdBanco = 3;
    $IdProcedencia = 3;
    $tenpox = $db->query("SELECT tblh_temporal_conciliar.autorizacion FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdTemporal = '$IdTemporal'");
    $db->rows($tenpox);
    $_tempx = $db->recorrer($tenpox);
    $_autor = $_tempx['autorizacion'];

    
    $messs = substr($Fecha, 5, 2);
    $anio = substr($Fecha, 0, 4);
    $_anio = substr($anio, 2, 2);
    $_mes = date("m");
    $_dia = date("d");

    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_us);
    $datos_u = $db->recorrer($sql_us);
    $_IdOferta = $datos_u["IdOferta"];
    $_IdCampus = $datos_u["IdCampus"];
    $idCam = $datos_u["IdCampus"];

    $_sum = 0;
    
    $sqlP = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.Valor = '1' AND tblp_pagos.IdEstatus <> '4' ORDER BY tblp_pagos.Indicador ASC");
    while ($P = $db->recorrer($sqlP)) {
      $descInd = 0;
      $_ind = $P["Indicador"];
      $_IdCiclo = $P["IdCiclo"];

      $IdPag = $P["IdPago"];
     
      $pagarAhora = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);

      $_abn = ($TPagar - $_sum);

      $_aniox = substr($Fecha, 0, 4);
      $_mesx = substr($Fecha, 5, 2);

      $anioM = $_aniox . '-' . $_mesx;
      $pagadoActual = $P["TotalPagado"];
      $_met = '';
      if ($_ind == 0) {
        ## PAGO COMPLETO
        if($pagadoActual == 0){ $_met = 'PUE';
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = $P["Descuento"];
          $total = $pagarAhora;
        } else { $_met = 'PPD';
          $importe = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);
          $descuento = 0;
          $total = $pagarAhora;
        }
        
        $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco, Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _importe, _descuento, _total, _tipo, _metodo, _idtemporal, _autorizacion) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','4',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$pagarAhora','$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM', '$_IdCiclo','1','$importe','$descuento','$total','CONCILIAR','$_met','$IdTemporal','$_autor')");
        $IdFolio = $db->insert_id;
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '0', tblp_pagos.FolioPago = '$cadenaNumero', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.IdEstatus = '4', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$pagarAhora', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
      } else { 
        ## PAGO CON ABONO
        $totalP = $P["TotalPagado"];
        $acdPag = ($_abn + $totalP);
        $idEstx = 1;
        if($pagadoActual == 0){ 
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = ($importe - $_abn);
          $total = $_abn;
          if($importe == $_abn){
            $_met = 'PUE';
            $idEstx = 4;
          } else {
            $_met = 'PPD';
            $idEstx = 1;
          }
        } else { 
          $importe = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);
          if($importe == $_abn){ $_met = 'PUE';
            $descuento = 0;  
            $idEstx = 4;
          } else { $_met = 'PPD';
            $descuento = ($importe - $_abn);  
          }
          $total = $_abn;
        }

        $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco,Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _importe, _descuento, _total, _tipo, _metodo, _idtemporal, _autorizacion) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','37',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$_abn', '$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM','$_IdCiclo','1','$importe','$descuento','$total','CONCILIAR','$_met','$IdTemporal','$_autor')");
        $IdFolio = $db->insert_id;
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '$idEstx', tblp_pagos.Valor = '0', tblp_pagos.Indicador = '0', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$acdPag', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
        $insertar = $db->query("INSERT INTO tblp_abono_pago (IdPago, Folio, Monto, FecCap) VALUES('$IdPag','$_nofolx','$_abn',NOW())");
      }
      $_sum = ($_sum + $pagarAhora);
    }
    
    if ($insertar) {
      $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar.idestatus = '10', tblh_temporal_conciliar._idestatus = '10' WHERE tblh_temporal_conciliar.IdTemporal = '$IdTemporal'");
      return 1;
    } else {
      return 0;
    }
  }

  public function add_pag_espex_all($IdUsua,$Division,$TPagar,$Nota,$IdAdmin,$IdTemporal)
  {
    $db = new Conexion();
    $anio = date("Y");
    $Fecha = date("Y-m-d");
    $_anio = substr($anio, 2, 2);
    $_aniox = date("Y");
    $Forma = '03';
    $IdBanco = '2';
    $IdProcedencia = '25';

    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 1;
    $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);


    $tenpox = $db->query("SELECT tblh_temporal_conciliar.autorizacion FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdTemporal = '$IdTemporal'");
    $db->rows($tenpox);
    $_tempx = $db->recorrer($tenpox);
    $_autor = $_tempx['autorizacion'];

    
    $messs = substr($Fecha, 5, 2);
    $anio = substr($Fecha, 0, 4);
    $_anio = substr($anio, 2, 2);
    $_mes = date("m");
    $_dia = date("d");

    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_campus.Letra FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_us);
    $datos_u = $db->recorrer($sql_us);
    $_IdOferta = $datos_u["IdOferta"];
    $_IdCampus = $datos_u["IdCampus"];
    $idCam = $datos_u["Letra"];

    $_anioFol = substr($_aniox, 2, 2);

    $folio = $db->query("SELECT tblp_foliospago.Folio FROM tblp_foliospago WHERE tblp_foliospago.Anio = '$anio' ORDER BY tblp_foliospago.Folio DESC");
    $db->rows($folio);
    $_folx = $db->recorrer($folio);
    $_nofolx = $_folx['Folio'] + 1;
    $cadenaNumero = $_anioFol . str_pad($_nofolx, 5, "0", STR_PAD_LEFT);
    $cadenaNumero = $idCam.$cadenaNumero.$cod;

    $_sum = 0;
    
    $sqlP = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.Valor = '1' AND tblp_pagos.IdEstatus <> '4' ORDER BY tblp_pagos.Indicador ASC");
    while ($P = $db->recorrer($sqlP)) {
      $descInd = 0;
      $_ind = $P["Indicador"];
      $_IdCiclo = $P["IdCiclo"];

      $IdPag = $P["IdPago"];
     
      $pagarAhora = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);

      $_abn = ($TPagar - $_sum);

      $_aniox = substr($Fecha, 0, 4);
      $_mesx = substr($Fecha, 5, 2);

      $anioM = $_aniox . '-' . $_mesx;
      $pagadoActual = $P["TotalPagado"];
      $_met = '';
      if ($_ind == 0) {
        ## PAGO COMPLETO
        if($pagadoActual == 0){ $_met = 'PUE';
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = $P["Descuento"];
          $total = $pagarAhora;
        } else { $_met = 'PPD';
          $importe = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);
          $descuento = 0;
          $total = $pagarAhora;
        }
        
        $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco, Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _importe, _descuento, _total, _tipo, _metodo, _idtemporal, _autorizacion) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','4',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$pagarAhora','$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM', '$_IdCiclo','1','$importe','$descuento','$total','CONCILIAR_ESP','$_met','$IdTemporal','$_autor')");
        $IdFolio = $db->insert_id;
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '0', tblp_pagos.FolioPago = '$cadenaNumero', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.IdEstatus = '4', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$pagarAhora', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
      } else { 
        ## PAGO CON ABONO
        $totalP = $P["TotalPagado"];
        $acdPag = ($_abn + $totalP);
        $idEstx = 1;
        if($pagadoActual == 0){ 
          $importe = ($P["Monto"] + $P["Recargos"]);
          $descuento = ($importe - $_abn);
          $total = $_abn;
          if($importe == $_abn){
            $_met = 'PUE';
            $idEstx = 4;
          } else {
            $_met = 'PPD';
            $idEstx = 1;
          }
        } else { 
          $importe = ($P["Monto"] + $P["Recargos"] - $P["Descuento"] - $P["TotalPagado"]);
          if($importe == $_abn){ $_met = 'PUE';
            $descuento = 0;  
            $idEstx = 4;
          } else { $_met = 'PPD';
            $descuento = ($importe - $_abn);  
          }
          $total = $_abn;
        }

        $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco,Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _importe, _descuento, _total, _tipo, _metodo, _idtemporal, _autorizacion) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','37',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$_abn', '$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM','$_IdCiclo','1','$importe','$descuento','$total','CONCILIAR_ESP','$_met','$IdTemporal','$_autor')");
        $IdFolio = $db->insert_id;
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '$idEstx', tblp_pagos.Valor = '0', tblp_pagos.Indicador = '0', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$acdPag', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
        $insertar = $db->query("INSERT INTO tblp_abono_pago (IdPago, Folio, Monto, FecCap) VALUES('$IdPag','$_nofolx','$_abn',NOW())");
      }
      $_sum = ($_sum + $pagarAhora);
    }
    
    if ($insertar) {
      $insertar = $db->query("UPDATE tblh_conciliar_pagos SET tblh_conciliar_pagos._idestatus = '10' WHERE tblh_conciliar_pagos.IdTemporal = '$IdTemporal'");
      return 1;
    } else {
      return 0;
    }
  }
  

  // public function add_pagos_especiales_all($Forma, $IdUsua, $Fecha, $IdUsuaCap, $division, $TPagar, $IdBanco, $Nota, $IdProcedencia, $IdAdmin, $Folio, $IdTemporal){
  //   $db = new Conexion();
  //   $IdProcedencia = 25;
  //   $IdBanco = 3;
  //   $anio = date("Y");
  //   $_anio = substr($anio, 2, 2);
  //   $folio = $db->query("SELECT tblp_foliospago.Folio FROM tblp_foliospago WHERE tblp_foliospago.Anio = '$anio' ORDER BY tblp_foliospago.Folio DESC");
  //   $db->rows($folio);
  //   $_folx = $db->recorrer($folio);
  //   $_nofolx = $_folx['Folio'] + 1;
  //   $cadenaNumero = $_anio . str_pad($_nofolx, 5, "0", STR_PAD_LEFT);

  //   $tenpox = $db->query("SELECT tblh_temporal_conciliar.autorizacion FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdTemporal = '$IdTemporal'");
  //   $db->rows($tenpox);
  //   $_tempx = $db->recorrer($tenpox);
  //   $_autor = $_tempx['autorizacion'];

  //   $messs = substr($Fecha, 5, 2);
  //   $anio = substr($Fecha, 0, 4);
  //   $_anio = substr($anio, 2, 2);
  //   $_mes = date("m");
  //   $_dia = date("d");

  //   $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  //   $db->rows($sql_us);
  //   $datos_u = $db->recorrer($sql_us);
  //   $_IdOferta = $datos_u["IdOferta"];
  //   $_IdCampus = $datos_u["IdCampus"];
  //   $idCam = $datos_u["IdCampus"];

  //   $_sum = 0;
    
  //   $sqlP = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.Valor = '1' AND tblp_pagos.IdEstatus <> '4'");
  //   while ($P = $db->recorrer($sqlP)) {
  //     $descInd = 0;
  //     $_ind = $P["Indicador"];
  //     $_IdCiclo = $P["IdCiclo"];

  //     $IdPag = $P["IdPago"];
  //     $sql8 = $db->query("SELECT Sum(tblp_recargos.Monto) AS Recargo FROM tblp_recargos WHERE tblp_recargos.IdUsua = '$IdUsua' AND tblp_recargos.IdPago = '$IdPag' AND tblp_recargos.IdEstatus = '8'");
  //     $db->rows($sql8);
  //     $datos81 = $db->recorrer($sql8);
  //     $recargo = $datos81["Recargo"];

  //     $totalG = ($P["Monto"] - $P["Descuento"] - $P["Descuento2"] - $descInd);

  //     $pagarAhora = ($P["Monto"] - $P["Descuento"] - $P["Descuento2"] - $descInd - $P["TotalPagado"]);
  //     $pagarAhora = ($pagarAhora + $recargo);

  //     $_abn = ($TPagar - $_sum);

  //     $_aniox = substr($Fecha, 0, 4);
  //     $_mesx = substr($Fecha, 5, 2);

  //     $anioM = $_aniox . '-' . $_mesx;
      
  //     $pagadoActual = $P["TotalPagado"];

  //     if ($_ind == 0) {
  //       if($pagadoActual == 0){
  //         $importe = $P["Monto"];
  //         $descuento = $P["Descuento"];
  //         $recargo = $P["Recargos"];
  //         $total = $pagarAhora; 
  //       } else {
  //         $importe = $pagarAhora;
  //         $descuento = 0;
  //         $recargo = 0;
  //         $total = $pagarAhora; 
  //       }

  //       $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco, Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _idtemporal, _autorizacion, _tipo, _importe, _descuento, _recargo, _total) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','4',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$pagarAhora','$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM', '$_IdCiclo','1','$IdTemporal','$_autor', 'CONCILIACION','$importe','$descuento','$recargo','$total')");
  //       $IdFolio = $db->insert_id;
  //       $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '0', tblp_pagos.FolioPago = '$cadenaNumero', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.IdEstatus = '4', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$pagarAhora', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
  //     } else {
  //       $sqlX = $db->query("SELECT tblp_pagos.TotalPagado FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPag'");
  //       $db->rows($sqlX);
  //       $datosx1 = $db->recorrer($sqlX);
  //       $totalP = $datosx1["TotalPagado"];
  //       $acdPag = ($_abn + $totalP);

        
  //       if($pagadoActual == 0){
  //         $importe = $P["Monto"];
  //         $descuento = $P["Descuento"];
  //         $recargo = $P["Recargos"];
  //         $total = $acdPag;
  //       } else {
  //         $importe = ($totalP + $P["Recargos"]);
  //         $descuento = $P["Descuento"];
  //         $recargo = $P["Recargos"];
  //         $total = $acdPag;
  //       }

  //       $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco,Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _idtemporal, _autorizacion, _tipo, _importe, _descuento, _recargo, _total) VALUES('$cadenaNumero','$anio','$_nofolx','$IdPag','37',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$_abn', '$_IdOferta','$_IdCampus','$messs','$IdBanco','$Nota','$IdProcedencia','$IdAdmin','$anioM','$_IdCiclo','1','$IdTemporal','$_autor','CONCILIACION','$importe','$descuento','$recargo','$total')");
  //       $IdFolio = $db->insert_id;
  //       $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Valor = '0', tblp_pagos.Indicador = '0', tblp_pagos.FechaPago = '$Fecha', tblp_pagos.Mes = '$messs', tblp_pagos.IdFormaPago = '$Forma', tblp_pagos.TotalPagado = '$acdPag', tblp_pagos.FacturaEstatus = '12', tblp_pagos.FecPago = '$Fecha', tblp_pagos.IdFolio = '$IdFolio' WHERE tblp_pagos.IdPago = '$IdPag'");
  //       $insertar = $db->query("INSERT INTO tblp_abono_pago (IdPago, Folio, Monto, FecCap) VALUES('$IdPag','$_nofolx','$_abn',NOW())");
  //     }
  //     $_sum = ($_sum + $pagarAhora);
  //   }
  //   if ($insertar) {
      
  //     $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar.idestatus = '4', tblh_temporal_conciliar._idestatus = '10', tblh_temporal_conciliar._IdUsua = '$IdUsua', tblh_temporal_conciliar._idUsuaAprobado = '$IdUsuaCap', tblh_temporal_conciliar._fecAprobado = NOW() WHERE tblh_temporal_conciliar.IdTemporal = '$IdTemporal'");

  //     return 1;
  //   } else {
  //     return 0;
  //   }
  // }

  public function add_newPago($IdUsua, $Plan, $Ciclo)
  {
    $db = new Conexion();
    $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdOferta = $datos81["IdOferta"];
    $IdCampus = $datos81["IdCampus"];
    $IdGrupo = $datos81["IdGrupo"];
    $user = $datos81["Usuario"];
    $anio = date("Y");

    $sql7 = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblp_calendario.Monto, tblc_conceptosplanes.IdConcepto, tblp_calendario.IdConceptosPlanes FROM tblp_calendario Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes WHERE tblp_calendario.IdCalendario =  '$Plan'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $Monto = $datos71["Monto"];
    $Fecha = $datos71["FecDescuento"];
    $IdConcepto = $datos71["IdConcepto"];
    $IdConceptosPlanes = $datos71["IdConceptosPlanes"];


    $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,IdGrupo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, _idEstatus, Recargos, TotalPagado,Descuento,IdConcepto) VALUES('$Plan','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fecha','$Fecha','$Fecha','$Fecha','$Ciclo','$IdGrupo','$anio','$IdConceptosPlanes','$IdCampus','NO-F27','1','32',0,0,0,'$IdConcepto')");


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function new_pago_posgrado($IdUsua, $IdConceptoPlan, $Ciclo, $Fecha, $IdAdmin)
  {
    $db = new Conexion();
    $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdOferta = $datos81["IdOferta"];
    $IdCampus = $datos81["IdCampus"];
    $IdGrupo = $datos81["IdGrupo"];
    $user = $datos81["Usuario"];
    $anio = date("Y");

    $sqle2 = $db->query("SELECT tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo, tblc_conceptosplanes.IdGrado FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdConceptoPlan'");
    $db->rows($sqle2);
    $datose21 = $db->recorrer($sqle2);
    $IdConcepto = $datose21['IdConcepto'];
    $Monto = $datose21['Costo'];
    $IdGrado = $datose21['IdGrado'];

    if($IdConcepto == 10){
      $IdPlan = $IdConceptoPlan;
      $IdCiclo = $Ciclo;

      $sql4 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdOferta, tblc_usuario._horario, tblc_usuario.Usuario, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
      $db->rows($sql4);
      $datos41 = $db->recorrer($sql4);
      $user = $datos41["Usuario"];
      $IdCampus = $datos41["IdCampus"];
      $IdOferta = $datos41["IdOferta"];
      $IdGrupo = $datos41["IdGrupo"];
      $horario = $datos41["_horario"];
      if($horario == 'P'){
          $Tipo = 'P';
        $Grado = 0;
      } else {
        $sql4 = $db->query("SELECT tblc_alumnos.Grado FROM tblc_alumnos WHERE tblc_alumnos.IdUsua =  '$IdUsua' AND tblc_alumnos.IdCiclo =  '$IdCiclo' ");
        $db->rows($sql4);
        $datos41 = $db->recorrer($sql4);
        $Grado = $datos41["Grado"];
        $Tipo = 'N';
      }


      $sql3 = $db->query("SELECT tblc_conceptosplanes.Code, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdPlan'");
      $db->rows($sql3);
      $datos31 = $db->recorrer($sql3);
      $Monto = $datos31["Costo"];

      $cadena_de_texto = $datos31["NomPlan"];
      $cadena_buscada   = 'SIMPLE';
      $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
      
      if ($posicion_coincidencia === false) {
      $Valor = 2;
      
      } else {
        $Valor = 1;
      }

      $anio = date('Y');
      $mes = date('m');
      
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,IdGrupo,Anio,Referencia,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, IdConcepto, _idEstatus, TotalPagado, Recargos, Descuento, Capturado) VALUES(0,'$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fecha','$IdCiclo','$IdGrupo','$anio','$user','$IdPlan','$IdCampus','NO-F28','1','10','32',0,0,0,5)");
      $id_pago = $db->insert_id;

      require 'assets/qrcode/qrlib.php';
      $dir = 'assets/images/qr/' . $anio . '/' . $mes . '/';

      if (!file_exists($dir))
        mkdir($dir);

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];

      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 20;
      $cad =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

      $insertar = $db->query("INSERT INTO tblp_docs_solicitados (IdPago,IdEstatus,IdCampus,IdUsua,IdOferta,IdCiclo,IdGrupo,FecCap,Anio,Mes, Fecha, IdConcepto, IdConceptoPlan, qrCode, IdVisto, Grado, Tipo) VALUES ('$id_pago','1','$IdCampus','$IdUsua','$IdOferta','$IdCiclo','$IdGrupo',NOW(),'$anio','$mes',NOW(),'10','$IdPlan','$cad','$Valor','$Grado','$Tipo')");
      $filename = $dir.$cad.'.png';

      $tamanio = 10;
      $level = 'M';
      $frameSize = 3;

      $contenido = $url . 'validar_constancia.php?tokenId=' . $cad;

      QRCode::png($contenido, $filename, $level, $tamanio, $frameSize);
  

      

    } else {
      $sql7 = $db->query("SELECT tblp_calendario.IdCalendario FROM tblp_calendario WHERE tblp_calendario.IdConceptosPlanes =  '$IdConceptoPlan'");
      $db->rows($sql7);
      $datos71 = $db->recorrer($sql7);
      $IdCalendario = $datos71["IdCalendario"];

      if (!$IdCalendario) {
        $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, Fecha, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus, IdCicloPago, IdGrupo) VALUES ('$IdGrado','$IdConceptoPlan','$Fecha','$Monto','$IdAdmin',NOW(),'32','$Ciclo','1','$Ciclo','$IdGrupo') ");
        $IdCalendario = $db->insert_id;
      }

      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,IdGrupo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, _idEstatus, Recargos, TotalPagado,Descuento,IdConcepto,Referencia) VALUES('$IdCalendario','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fecha','$Fecha','$Fecha','$Fecha','$Fecha','$Ciclo','$IdGrupo','$anio','$IdConceptoPlan','$IdCampus','NO-F29','1','32',0,0,0,'$IdConcepto','$user')");

    }

    
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_cerrarSalIni($IdPago, $Comentario, $Forma, $IdUsua, $Fecha, $IdBanco, $Pago, $IdEstatus, $IdProcedencia, $IdAdmin)
  {
    $db = new Conexion();
    $Pago2 = $Pago;
    $Pago = ($Pago * -1);
    if ($IdBanco == 0) {
      $IdBanco = 1;
      $IdProcedencia = 1;
    }


    $_anioX = substr($Fecha, 0, 4);
    $_anio = substr($Fecha, 2, 2);
    $_mes = substr($Fecha, 5, 2);
    $_aniomes = $_anioX . '-' . $_mes;


    //$messs = $anioHoy = date("m");

    $sql9 = $db->query("SELECT tblc_usuario.IdOferta, tblc_usuario.IdGrupo, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdOferta = $datos91["IdOferta"];
    $IdCampus = $datos91["IdCampus"];
    $IdGrupo = $datos91["IdGrupo"];

    $sqlx = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclo.FInicio FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo' ORDER BY tblc_ciclo.FInicio DESC");
    $db->rows($sqlx);
    $datx = $db->recorrer($sqlx);
    $IdCiclo = $datx["IdCiclo"];

    $folio = $db->query("SELECT tblp_foliospago.NoFolio FROM tblp_foliospago ORDER BY tblp_foliospago.Folio DESC");
    $db->rows($folio);
    $_folx = $db->recorrer($folio);
    $NoFolio = $_folx['NoFolio'] + 1;
    $cadenaNumero = $NoFolio;

    // $cadenaNumero = str_pad($NoFolio,5,"0",STR_PAD_LEFT);
    // $cadenaNumero = $_anio.$cadenaNumero;

    $insertar = $db->query("INSERT INTO tblp_saldo (IdUsua, Monto, Descripcion, IdEstatus, Fecha, FecCap, Tipo, IdOferta, IdCampus) VALUES ('$IdUsua','$Pago','$Comentario','$IdEstatus',NOW(),NOW(),'Ingreso','$IdOferta','$IdCampus')");
    $IdFolio = $db->insert_id;
    $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Folio, Estatus, FecCap, FecPago, Monto, IdUsua,IdEstatus, IdForma, Tipo, IdOferta, IdCampus, Anio, Mes, IdBanco, IdProcedencia, Nota, AnioMes, IdAdmin) VALUES('$cadenaNumero','$NoFolio','$IdEstatus',NOW(),'$Fecha','$Pago2','$IdUsua','4','$Forma','I','$IdOferta','$IdCampus','$_anioX','$_mes','$IdBanco','$IdProcedencia','$Comentario','$_aniomes','$IdAdmin')");
    $IdFx = $db->insert_id;
    $insertar = $db->query("UPDATE tblh_detallepagos SET tblh_detallepagos.Estatus =  '4' WHERE tblh_detallepagos.IdUsua = '$IdUsua' AND tblh_detallepagos.TipoPago = '2'");

    $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua, Monto, IdEstatus, IdOferta, FecCap, FecDesc, FecBase, FecLim, FecLimPago, TotalPagado, IdFormaPago, Facturar, IdCiclo, IdGrupo, FacturaEstatus, TipoSolicitud, Anio, FecPago, IdBanco, Mes, IdCalendario, IdConceptoPlan, IdConcepto, IdFolio, FechaPago, IdCampus, FolioPago, _idEstatus) VALUES ('$IdUsua','$Pago2','4','$IdOferta',NOW(),'$Fecha','$Fecha','$Fecha','$Fecha','$Pago2','$Forma','NO-F30','$IdCiclo','$IdGrupo','12','5','$_anioX','$Fecha','$IdBanco','$_mes','1','1','8','$IdFx','$Fecha','$IdCampus','$cadenaNumero','32')");
    $IdPag = $db->insert_id;
    $insertar = $db->query("UPDATE tblp_foliospago SET tblp_foliospago.IdPago = '$IdPag' WHERE tblp_foliospago.IdFolio = '$IdFx'");

    $IdFx = $db->insert_id;
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_newReincor($IdUsua, $IdGrupo, $IdCiclo)
  {
    $db = new Conexion();

    $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdG = $datos91["IdGrupo"];
    $Docs = $datos91["Documentos"];

    $doc = $Docs . " GrpAnte=" . $IdG;

    $insertar = $db->query("INSERT INTO tblp_reincorporacion (IdUsua, IdGrupo, IdGrupoAnterior, IdCiclo, FecCap) VALUES('$IdUsua','$IdGrupo','$IdG','$IdCiclo',NOW()) ");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.id_ciclo_reincorporacion = '$IdCiclo', tblc_usuario.Documentos = '$doc', tblc_usuario.IdGrupo = '$IdGrupo', tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_pagosUs($IdUsua, $IdPago)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '4' WHERE tblp_pagos.IdPago = '$IdPago'");
  }

  public function add_genDescuento($IdPago, $IdTipoDescuento, $Comentario, $Porcentaje, $FecLimite, $Descuento)
  {
    $db = new Conexion();
    $sql9 = $db->query("SELECT * FROM tblp_descuento WHERE tblp_descuento.IdPago =  '$IdPago' AND tblp_descuento.Estatus = '8'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdExiste = $datos91["IdDescuento"];
    if ($IdExiste) {
      $res = 2;
    } else {
      $insertar = $db->query("INSERT INTO tblp_descuento (IdPago, IdTipoDescuento, Porcentaje, Descuento, FecDescuento, FecCap, Estatus, Utilizado) VALUES('$IdPago','$IdTipoDescuento','$Porcentaje','$Descuento','$FecLimite',NOW(),'8','0')");
      $IdDesInser = $db->insert_id;
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.EstatusDescuento = '8', tblp_pagos.IdTipoDescuento = '$IdTipoDescuento', tblp_pagos.IdDescuento = '$IdDesInser', tblp_pagos.FacturaEstatus = '12' WHERE tblp_pagos.IdPago = '$IdPago'");
      $res = 1;
    }
    if ($res) {
      return $res;
    } else {
      return 0;
    }
  }

  public function add_PagoNvoIng($IdAlumno, $Porcentaje, $FecLimite, $IdConcepto, $Monto, $DesGenerado)
  {
    $apkKey = 'bTzZxWjN0hsYO5rG';
    $porciones = explode("-", $IdConcepto);
    $IdConcepto = $porciones[0]; // porción1
    $monTotal =  $porciones[1]; // porción2

    $db = new Conexion();

    $sql88 = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdAlumno' AND tblp_pagos.IdConcepto =  '$IdConcepto'");
    $db->rows($sql88);
    $datos881 = $db->recorrer($sql88);
    $IdPgExist = $datos881['IdPago'];

    if ($IdPgExist) {
      return 3;
      exit();
    }

    $sql5 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdAlumno'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdOferta = $datos51['IdOferta'];


    $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdGrado = $datos91['IdGrado'];

    $sql8 = $db->query("SELECT Grado$IdGrado, Solicitud FROM tblc_conceptos WHERE tblc_conceptos.IdConcepto =  '" . $_POST["txtConcepto"] . "'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $precio = $datos81[0];
    $solicitudN = $datos81[1];

    $anioHoy = date("Y");
    $anioActual = substr($anioHoy, 2, 2);


    $sql34 = $db->query("SELECT Max(tblp_pagos.Folio) AS Ultimo FROM tblp_pagos WHERE tblp_pagos.Anio = '$anioHoy'");
    $db->rows($sql34);
    $datos341 = $db->recorrer($sql34);
    $folio = $datos341["Ultimo"] + 1;
    $code = str_pad($folio, 5, "0", STR_PAD_LEFT);
    $referencia = $anioActual . $code;
    $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,IdConcepto,TotalPagado,Monto,Pagar,IdEstatus,IdOferta,FecCap,FecLimPago,Facturar,TipoSolicitud, Anio, Folio, Referencia, EstatusDescuento) VALUES ('$IdAlumno','$IdConcepto','0','$monTotal','$Monto','1','$IdOferta',NOW(),'$FecLimite','NO-F31','1','$anioHoy','$folio','$referencia','23')");
    $IdPagoInser = $db->insert_id;

    if ($Porcentaje) {
      $insertar = $db->query("INSERT INTO tblp_descuento (IdPago, IdTipoDescuento, Porcentaje, Descuento, FecDescuento, FecCap, Estatus, Utilizado) VALUES('$IdPagoInser','7','$Porcentaje','$DesGenerado','$FecLimite',NOW(),'8','0')");
      $IdDesGenerado = $db->insert_id;
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.EstatusDescuento = '8', tblp_pagos.IdTipoDescuento = '7', tblp_pagos.IdDescuento = '$IdDesGenerado', tblp_pagos.FacturaEstatus = '12' WHERE tblp_pagos.IdPago = '$IdPagoInser'");
    }

    $sql1 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Foto, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdCampus, tblc_usuario.Correo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdAlumno'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $IdUUUU = $datos11["IdUsua"];
    $destinatario = $datos11["Correo"];
    $foto = $datos11["Foto"];
    $idCam = $datos11["IdCampus"];
    $Nombre = $datos11["Nombre"] . ' ' . $datos11["APaterno"] . ' ' . $datos11["AMaterno"];

    $sql1m = $db->query("SELECT tblp_pagos.IdPago, tblc_conceptos.NomConcepto, tblp_pagos.FecLimPago, tblp_pagos.Pagar, tblp_descuento.Descuento, tblp_descuento.Porcentaje FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblp_descuento ON tblp_descuento.IdDescuento = tblp_pagos.IdDescuento AND tblp_descuento.IdPago = tblp_pagos.IdPago WHERE tblp_pagos.IdUsua = '$IdAlumno' AND tblp_pagos.IdPago = '$IdPagoInser' ");
    $db->rows($sql1m);
    $datos1m1 = $db->recorrer($sql1m);
    $pNomConcepto = $datos1m1["NomConcepto"];
    $pFecLimPago = $datos1m1["FecLimPago"];
    $pPagar = $datos1m1["Pagar"];
    $pDescuento = $datos1m1["Descuento"];


    if ($pDescuento) {
      $tPa = ($pPagar - $pDescuento);
      $txtPagar = "Descuento: $ " . number_format($pDescuento, 2, '.', ',') . " <br><b>Total a pagar: $ " . $tPa . "</b>";
    } else {
      $txtPagar = "$ " . number_format($pPagar, 2, '.', ',');
    }


    $var = uniqid();
    $var2 = uniqid();
    $var3 = uniqid();
    $var4 = uniqid();


    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $Institucion = $_camp["Campus"];
    $direccion = $_camp["Direccion"];

    $tiempo = time();
    $var = uniqid();
    $var2 = uniqid();
    $var1 = uniqid();

    $token = $tiempo . $var . $var2 . $tiempo . $IdUUUU;
    $linkLogo = $url . 'assets/images/campus/logo_inicio.png';
    $linkClicImg = $url . 'assets/images/click.png';
    $linkFoto = $url . 'assets/perfil/' . $foto;
    $urlDescargarPDF = $url . 'repositorio/pdf/docBaja.php?tokenId=' . $token;

    $urlDescargarPDF = $url . "repositorio/pdf/boucherId.php?tokenId=" . $var . $var2 . $var3 . $var4 . "&Id=" . $IdPagoInser . "&Per=" . $var3 . $var2 . $var1 . $var4;

    require('Mailin.php');
    $mailin = new Mailin("https://api.sendinblue.com/v2.0", "bTzZxWjN0hsYO5rG");
    $data = array(
      "to" => array("$destinatario" => " $Nombre "),
      //"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
      "from" => array("info@uni.edu.mx", " $Institucion"),
      "subject" => "Ficha de pago | " . $pNomConcepto,
      "text" => "Plataforma de Educación | $Institucion",

      "html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"0\">
          <div style='width:100%; padding:24px 0 16px 0; background-color:#f5f5f5; text-align:center'>
        		<div style='display:inline-block; width:90%; max-width:680px; min-width:280px; text-align:left; font-family:Roboto,Arial,Helvetica,sans-serif'>
        			<div dir='ltr' style='height:0px'></div>
        			<div style='display:block; padding:0 2px'>
        				<div style='display:block; background:#fff; height:2px'></div>
        			</div>
        			<div style='border-left:1px solid #f0f0f0; border-right:1px solid #f0f0f0'>
        				<div  style='padding:24px 32px 24px 32px; background:#fff; border-right:1px solid #eaeaea; border-left:1px solid #eaeaea'>
        					<div style='font-size:14px; line-height:18px; color:#444'>
        						<b>$Institucion</b>
        					</div>
        					<div style='height:10px'></div>
        					<div style='font-size:18px; display:table'>
        						<div style='display:table-row; border-bottom:4px solid #fff'>
        						<span style='display:table-cell'>
        							<div style='height:32px'><img data-imagetype='External' src='$linkFoto' aria-label='Foto perfil' style='vertical-align:middle; max-width:24px'></div>
        						</span>
        						<span style='display:table-cell; padding-left:12px; word-break:break-word'>
        							<a href='' rel='noopener noreferrer' data-auth='NotApplicable' style='color:#3367d6; text-decoration:none; vertical-align:middle'>$Nombre</a>
        						</span>
        						</div>
        					</div>
        					<div style='height:1px; background-color:#eee'></div> <br>
                  <p style='text-align: justify;'>Se le notifica que se le ha generado una <b>ficha de pago</b>, a continuaci&oacute;n se le mostrar&aacute; el desglose de la informaci&oacute;n:</p>

                  <table role='presentation' style='width:100%;'>
              			<tbody>
              				<tr style='background: #b6b6b6;'>
                        <td style='padding:5px'>Concepto</td>
              					<td style='padding:5px'>Total pagar</td>
                      </tr>
                      <tr>
                        <td style='padding:5px'>$pNomConcepto</td>
              					<td style='padding:5px'>$txtPagar  </td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
        					<b>Su fecha l&iacute;mite de pago es el: $pFecLimPago</b> <br>
        					<br>
                  En la Plataforma Educativa, favor de revisar su estatus financiero:<br><br>
                  <b>Espacio > Estatus Financiero</b>
        					<br><br>
                  <div><a href='$url' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='background-color:#505a69; border:1px solid #020305; border-radius:2px; color:white; display:inline-block; font-family:Roboto,Arial,Helvetica,sans-serif; font-size:11px; font-weight:bold; height:29px; line-height:29px; min-width:54px; outline:0px; padding:0 8px; text-align:center; text-decoration:none'>Ingresar a la Plataforma</a>
                  <a href='$urlDescargarPDF' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' style='background-color:#4d90fe; border:1px solid #3079ed; border-radius:2px; color:white; display:inline-block; font-family:Roboto,Arial,Helvetica,sans-serif; font-size:11px; font-weight:bold; height:29px; line-height:29px; min-width:54px; outline:0px; padding:0 8px; text-align:center; text-decoration:none'>Descargar ficha de pago</a></div>
        					<br>
        					</span>
        				</div>
        			</div>
        		</div>
        		<table role='presentation' style='width:100%; border-collapse:collapse'>
        			<tbody>
        				<tr>
        					<td style='padding:0px'>
        						<table role='presentation' style='border-collapse:collapse; width:3px'>
        							<tbody>
        								<tr height='1'>
        									<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        									<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        									<td style='padding:0px' width='1' bgcolor='#e5e5e5'></td>
        								</tr>
        								<tr height='1'>
        									<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        									<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        									<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        								</tr>
        								<tr height='1'>
        									<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        									<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        									<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        								</tr>
        							</tbody>
        						</table>
        					</td>
        				<td style='width:100%; padding:0px'>
        					<div style='height:1px; width:auto; border-top:1px solid #ddd; background:#eaeaea; border-bottom:1px solid #f0f0f0'></div>
        				</td>
        				<td style='padding:0px'>
        					<table role='presentation' style='border-collapse:collapse; width:3px'>
        						<tbody>
        							<tr height='1'>
        								<td style='padding:0px' width='1' bgcolor='#e5e5e5'></td>
        								<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        								<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        							</tr>
        							<tr height='1'>
        								<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        								<td style='padding:0px' width='1' bgcolor='#eaeaea'></td>
        								<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        							</tr>
        							<tr height='1'>
        								<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        								<td style='padding:0px' width='1' bgcolor='#f0f0f0'></td>
        								<td style='padding:0px' width='1' bgcolor='#f5f5f5'></td>
        							</tr>
        						</tbody>
        					</table>
        				</td>
        				</tr>
        			</tbody>
        		</table>
        		<table role='presentation'  style='padding:14px 10px 0 10px'>
        			<tbody>
        				<tr>
        				<td style='width:100%; font-size:11px; font-family:Roboto,Arial,Helvetica,sans-serif; color:#646464; line-height:20px; min-height:40px; vertical-align:middle'>
        					$direccion
        				</td>
        				<td style='padding-left:20px; vertical-align:middle'><a href='$url' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable'><img data-imagetype='External' src='$linkLogo' alt='Logo de la Institucion' width='96' border='0'></a></td>
        				</tr>
        			</tbody>
        		</table>
        	</div>

          ",
      "attachment" => array(),
      "headers" => array("Content-Type" => "text/html; charset=iso-8859-1", "X-param1" => "value1", "X-param2" => "value2", "X-Mailin-custom" => "my custom value", "X-Mailin-IP" => "102.102.1.2", "X-Mailin-Tag" => "My tag"),
      "inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data", 'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
    );
    $mailin->send_email($data);


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_closePagoNvo($IdAlumno)
  {
    $db = new Conexion();
    $sql9 = $db->query("SELECT Count(tblp_pagos.IdPago) AS cantPagos FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdAlumno'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $cantPagos = $datos91["cantPagos"];

    if ($cantPagos >= 2) {
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Valor = '2' WHERE tblc_usuario.IdUsua = '$IdAlumno'");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_modCalificacion($IdCalificacion, $IdUsua, $Calificacion, $Pass1, $Pass2)
  {
    $db = new Conexion();
    $datt = $Pass1 . '-' . $Pass2;
    $pass1 = Password::hash($Pass1);
    $pass2 = Password::hash($Pass2);

    $sql9 = $db->query("SELECT IdUsua FROM tblc_usuario WHERE tblc_usuario.Pass_php =  '$pass1' AND tblc_usuario.Estado = 'Activo' AND tblc_usuario.Permisos = '1' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdUsua1 = $datos91["IdUsua"];

    $sql8 = $db->query("SELECT IdUsua FROM tblc_usuario WHERE tblc_usuario.Pass_php =  '$pass2' AND tblc_usuario.Estado = 'Activo' AND tblc_usuario.Permisos = '5' ");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdUsua2 = $datos81["IdUsua"];

    if (($IdUsua1) && ($IdUsua2)) {
      $insertar = $db->query("INSERT INTO tblh_modificaciones (IdAdministrador, IdAcademico, IdAlumno, IdCalificacion, Calificacion, FecCap, Intento) VALUES ('$IdUsua1', '$IdUsua2','$IdUsua','$IdCalificacion','$Calificacion',NOW(),'1')");
    } else {
      $insertar = $db->query("INSERT INTO tblh_modificaciones (IdAlumno, IdCalificacion, Calificacion, FecCap, Intento) VALUES ('$IdUsua','$IdCalificacion','$Calificacion',NOW(),'$datt')");
      $insertar = 2;
    }
    if ($insertar) {
      return $insertar;
    } else {
      return 0;
    }
  }

  public function add_cerrarGrupoX($IdGrupo, $Oferta)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Tipo = 'Cerrado' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '31' AND tblc_usuario.IdGrupo = '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $IdUsa = $x["IdUsua"];
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUsa'");
    }
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_facPago($IdPago, $TipoValor, $IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.FacturaEstatus = '12', tblp_pagos.Facturar = '$TipoValor' WHERE tblp_pagos.IdPago = '$IdPago'");
    $sql8 = $db->query("SELECT IdDatosFacturacion FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdFact = $datos81["IdDatosFacturacion"];
    if ($IdFact) {
      $val = 3;
    } else {
      $val = 4;
    }
    if ($TipoValor == "NO") {
      $val = 3;
    }
    if ($insertar) {
      return $val;
    } else {
      return 0;
    }
  }

  public function upd_horario($IdAsignacion, $IdHorario, $HraIni, $MinIni, $HraFin, $MinFin, $Total)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_horario SET tblp_horario.HraIni = '$HraIni', tblp_horario.MinIni = '$MinIni', tblp_horario.HraFin = '$HraFin', tblp_horario.MinFin = '$MinFin', tblp_horario.Total = '$Total' WHERE tblp_horario.IdAsignacion = '$IdAsignacion' AND tblp_horario.IdHorario ='$IdHorario'");
    $sql9 = $db->query("SELECT Sum(tblp_horario.Total) AS sumHoras FROM tblp_horario WHERE tblp_horario.IdAsignacion = '$IdAsignacion' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $sumHoras = $datos91["sumHoras"];

    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.HraDia = '$Total', tblp_asignacion.HraSemana = '$sumHoras' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_fechaFinPar($IdParcialDoc, $Fecha)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.Fecha = '$Fecha' WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_horarioFos($IdAsignacion, $HraD, $HraI)
  {
    $db = new Conexion();

    $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdModulo = $datos91["IdModulo"];

    $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.HraDoc = '$HraD', tblp_modulo.HraInd = '$HraI' WHERE tblp_modulo.IdModulo = '$IdModulo'");

    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.HraDoc = '$HraD', tblp_asignacion.HraInd = '$HraI' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_rvoe($Rvoe, $Vigencia, $Turno, $Modalidad, $IdRvoe, $Escuela, $Localidad, $Clave_dgp, $Oferta, $Clave_rpe,$Ciclo,$Anio,$Duracion,$Cct,$Clave_estadistica)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_rvoe SET tblc_rvoe.clave_estadistica = '$Clave_estadistica', tblc_rvoe._cct = '$Cct', tblc_rvoe._duracion = '$Duracion', tblc_rvoe._anio = '$Anio', tblc_rvoe._ciclo = '$Ciclo', tblc_rvoe.Clave_rpe = '$Clave_rpe', tblc_rvoe.Educativa = '$Oferta', tblc_rvoe.Clave_dgp = '$Clave_dgp', tblc_rvoe.Rvoe = '$Rvoe', tblc_rvoe.Escuela= '$Escuela', tblc_rvoe.Localidad = '$Localidad', tblc_rvoe.Vigencia = '$Vigencia', tblc_rvoe.Turno = '$Turno', tblc_rvoe.Modalidad = '$Modalidad' WHERE tblc_rvoe.IdRvoe = '$IdRvoe'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_updGrupo($IdGrupo, $Estatus, $Periodo, $Disponible, $Inicio, $Final)
  {
    $db = new Conexion();
    $esT = "Abierto";

    if ($Estatus == 12) {
      $esT = "Abierto";
      $nomEst = "Activo";
      // $insertarx = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '31' WHERE tblc_usuario.IdGrupo = '$IdGrupo' ");
    }

    if ($Estatus == 55) {
      $esT = "Cerrado";
      $nomEst = "Finalizado";
      $sql = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.IdGrupo = '$IdGrupo' ");
      while ($x = $db->recorrer($sql)) {
        $IdUss = $x["IdUsua"];
        $insertarx = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '55' WHERE tblc_usuario.IdUsua = '$IdUss'");
      }
    }

    if ($Estatus == 8) {
      $esT = "Cerrado";
      $nomEst = "Activo";
      $sql = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' ");
      while ($x = $db->recorrer($sql)) {
        $IdUss = $x["IdUsua"];
        $insertarx = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUss'");        
      }
      $insertarx = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.Grado = '1' ");

      $sql9 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdCiclo = $datos91["IdCicloIni"];
      $Dia = $datos91["Dia"];
      if($Dia == 'P'){
        $_diax1 = ",Horario";
        $_diax2 = ",'P'";
      } else{
        $_diax1 = "";
        $_diax2 = "";
      }
      $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8' ");
      while ($x = $db->recorrer($sql)) {
        $IdUss = $x["IdUsua"];

        $sql_alum = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUss' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo' ");
        $db->rows($sql_alum);
        $_alumno = $db->recorrer($sql_alum);
        if(!isset($_alumno["IdActivo"])){
          $insertarx = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor $_diax1)  VALUES ('$IdGrupo','$IdCiclo','$IdUss',1,'R',8,NOW(),1 $_diax2)");  
        }
      }

    }

    $insertarx = $db->query("UPDATE tblp_grupo SET tblp_grupo.FechaIni = '$Inicio', tblp_grupo.FechaFin = '$Final', tblp_grupo.Disponible = '$Disponible', tblp_grupo.Periodo = '$Periodo', tblp_grupo.Tipo = '$esT', tblp_grupo.Estatus = '$nomEst', tblp_grupo.IdEstatus = '$Estatus' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    if ($insertarx) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_firmas($Rector, $Escolar, $Oficina, $Departamento, $IdCampus, $Elaboro, $Educacion, $Coordinadora, $Responsable, $Servicio)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_firmas SET tblc_firmas.Servicio = '$Servicio', tblc_firmas.Res_serv_esc_plantel = '$Responsable', tblc_firmas.Educacion_superior = '$Educacion', tblc_firmas.Coordinadora = '$Coordinadora', tblc_firmas.Elaboro = '$Elaboro', tblc_firmas.Rector = '$Rector', tblc_firmas.Escolares_sep_cotejo = '$Escolar', tblc_firmas.Oficina = '$Oficina', tblc_firmas.Departamento = '$Departamento' WHERE tblc_firmas.IdCampus = '$IdCampus'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function upd_datAsig($Modulo, $Texto, $IdTipo, $Oferta)
  {
    $db = new Conexion();

    if ($IdTipo == 1) {
      $varT = "Objetivo";
    } else {
      $varT = "Introduccion";
    }

    $insertar = $db->query("UPDATE tblp_modulodatos SET tblp_modulodatos.FecCap = NOW(), tblp_modulodatos.$varT = '$Texto' WHERE tblp_modulodatos.IdModulo = '$Modulo'");
    $insertar = $db->query("UPDATE tblp_modulo SET  tblp_modulo.Objetivo = '$Texto' WHERE tblp_modulo.IdModulo = '$Modulo'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function upd_conte_carta($Modulo, $Contenido, $Id_contenido)
  {
    $db = new Conexion();
    $Contenido = limpiar_cadena($Contenido);
    $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.Mod_$Id_contenido = '$Contenido' WHERE tblp_modulo.IdModulo = '$Modulo'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_examPreg($Pregunta, $IdActividadDoc, $IdParcialDoc, $IdUsua, $IdAsignacion)
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_exampregunta (IdAsignacion, IdActividadesDocente, IdParcialDocente, IdUsua, Pregunta, FecCap) VALUES ('$IdAsignacion','$IdActividadDoc','$IdParcialDoc','$IdUsua','$Pregunta',NOW())");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_examResp($Pregunta, $Respuesta, $A, $B, $C, $D, $E, $F)
  {
    $db = new Conexion();
    $valorA = 0;
    $valorB = 0;
    $valorC = 0;
    $valorD = 0;
    $valorE = 0;
    $valorF = 0;
    if ($A) {
      if ($Respuesta == 1) {
        $valorA = 1;
      }
      $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$Pregunta','$A','$valorA')");
    }
    if ($B) {
      if ($Respuesta == 2) {
        $valorB = 1;
      }
      $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$Pregunta','$B','$valorB')");
    }
    if ($C) {
      if ($Respuesta == 3) {
        $valorC = 1;
      }
      $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$Pregunta','$C','$valorC')");
    }
    if ($D) {
      if ($Respuesta == 4) {
        $valorD = 1;
      }
      $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$Pregunta','$D','$valorD')");
    }
    if ($E) {
      if ($Respuesta == 5) {
        $valorE = 1;
      }
      $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$Pregunta','$E','$valorE')");
    }
    if ($F) {
      if ($Respuesta == 6) {
        $valorF = 1;
      }
      $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$Pregunta','$F','$valorF')");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_respusEx($IdPregunta)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta = '$IdPregunta'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_preguntEx($IdPregunta)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblp_exampregunta WHERE tblp_exampregunta.IdPregunta = '$IdPregunta'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }
  public function upd_costoPlan($IdAsignacion, $Costo, $IdUsua)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.Costo = '$Costo', tblp_planeacion.IdUsuaCosto = '$IdUsua', tblp_planeacion.FecCosto = NOW() WHERE tblp_planeacion.IdAsignacion = '$IdAsignacion'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }
  public function add_costoPlan($IdCampus, $Nombre, $IdNivel, $IdUsua, $Concepto, $Costo, $Recargo, $Producto, $Unidad)
  {
    $db = new Conexion();

    if(($Concepto == 1) || ($Concepto == 2)){
      $dat1 = ", Code";
      $dat2 = ", 1";
    } else {
      $dat1 = "";
      $dat2 = "";
    }

    $insertar = $db->query("INSERT INTO tblc_conceptosplanes (IdCampus,NomPlan, IdGrado, IdUsua, FecCap, IdConcepto, Costo, Recargo, ClaveUnidad, ClaveProdServ $dat1) VALUES('$IdCampus','$Nombre','$IdNivel','$IdUsua',NOW(),'$Concepto','$Costo','$Recargo','$Unidad','$Producto' $dat2)");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function get_preguntExamn($IdAsignacion, $IdActividadDoc, $IdParcialDoc)
  {
    $db = new Conexion();
    $get_preguntExamn = [];
    $sql = $db->query("SELECT * FROM tblp_exampregunta WHERE tblp_exampregunta.IdAsignacion = '$IdAsignacion' AND tblp_exampregunta.IdParcialDocente = '$IdParcialDoc' AND tblp_exampregunta.IdActividadesDocente = '$IdActividadDoc'");
    while ($x = $db->recorrer($sql)) {
      $get_preguntExamn[] = $x;
    }
    return $get_preguntExamn;
  }

  public function get_pregunt_ex_id($IdActividadDoc)
  {
    $db = new Conexion();
    $get_pregunt_ex_id = [];
    $sql = $db->query("SELECT * FROM tblp_exampregunta WHERE tblp_exampregunta.IdActividadesDocente = '$IdActividadDoc'");
    while ($x = $db->recorrer($sql)) {
      $get_pregunt_ex_id[] = $x;
    }
    return $get_pregunt_ex_id;
  }
  
  public function get_donacion_id($IdUsua)
  {
    $db = new Conexion();
    $get_donacion_id = [];
    $sql = $db->query("SELECT * FROM tblp_donacion WHERE tblp_donacion.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_donacion_id[] = $x;
    }
    return $get_donacion_id;
  }
  
  public function get_donacion_no_generado($IdUsua)
  {
    $db = new Conexion();
    $get_donacion_no_generado = [];
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_foliospago.IdFolio FROM tblp_pagos LEFT JOIN tblp_foliospago ON tblp_pagos.IdPago = tblp_foliospago.IdPago WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdConcepto = '12' AND tblp_pagos.IdEstatus = '4'");
    while ($x = $db->recorrer($sql)) {
      $get_donacion_no_generado[] = $x;
    }
    return $get_donacion_no_generado;
  }



  public function add_solPago($Concepto, $IdUsua, $FechaLim)
  {
    $db = new Conexion();
    $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdGrupo, tblc_usuario.IdOferta, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $rwIdOferta = $datos91["IdOferta"];
    $rwIdGrado = $datos91["IdGrado"];
    $rwIdGrupo = $datos91["IdGrupo"];

    $sql8 = $db->query("SELECT tblc_conceptos.IdConcepto, tblc_conceptos.NomConcepto, tblc_conceptos.Grado$rwIdGrado FROM tblc_conceptos WHERE tblc_conceptos.Grado$rwIdGrado IS NOT NULL AND tblc_conceptos.Solicitud = '3'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $rwMonto = $datos81[2];

    $sql7 = $db->query("SELECT * FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo =  '$rwIdGrupo' ORDER BY tblc_ciclogrupo.IdCicloGrupo DESC");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $rwIdCiclo = $datos71["IdCiclo"];

    $anioHoy = date("Y");
    $anioActual = substr($anioHoy, 2, 2);
    $sql34 = $db->query("SELECT Max(tblp_pagos.Folio) AS Ultimo FROM tblp_pagos WHERE tblp_pagos.Anio = '$anioHoy'");
    $db->rows($sql34);
    $datos341 = $db->recorrer($sql34);
    $folio = $datos341["Ultimo"] + 1;

    $code = str_pad($folio, 5, "0", STR_PAD_LEFT);
    $referencia = $anioActual . $code;
    $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua, IdConcepto, Monto, Pagar, IdOferta, IdGrupo, IdEstatus, FecLimPago, FecCap, TipoSolicitud, IdCiclo, Capturado, Anio, Folio, Referencia, EstatusDescuento) VALUES ('$IdUsua','$Concepto','$rwMonto','$rwMonto','$rwIdOferta','$rwIdGrupo','1','$FechaLim',NOW(),'2','$rwIdCiclo','1','$anioHoy','$folio','$referencia','23')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_docComproban($Estatus, $IdDocumento, $Tipo, $Tramite)
  {
    $db = new Conexion();
    if ($Tipo == 2) {
      $insertar = $db->query("UPDATE tblc_docdocentes SET tblc_docdocentes.Estatus = '$Estatus' WHERE tblc_docdocentes.IdDocDocente = '$IdDocumento'");
    } elseif ($Tipo == 3) {
      if ($Tramite == "SS") {
        $tablaa = "tblc_doctramite";
        $tabId = "IdDocTramite";
      } else {
        $tablaa = "tblc_docalumnos";
        $tabId = "IdDocAlumno";
      }
      $insertar = $db->query("UPDATE $tablaa SET $tablaa.Estatus = '$Estatus' WHERE $tablaa.$tabId = '$IdDocumento'");
    }
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_delDocumentoD($IdDocumento)
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.Archivo FROM tblc_docdocentes WHERE tblc_docdocentes.IdDocDocente = '$IdDocumento'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $anio = $datos11["Anio"];
    $mes = $datos11["Mes"];
    $Archivo = $datos11["Archivo"];
    $link = "assets/docs/Docentes/$anio/$mes/$Archivo";

    if (file_exists($link)) {
      unlink($link);
    }


    $insertar = $db->query("DELETE FROM tblc_docdocentes WHERE tblc_docdocentes.IdDocDocente = '$IdDocumento'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_delContrato($IdContrato)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblc_contrato WHERE tblc_contrato.IdContrato = '$IdContrato'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_delDocAlumno($IdDocumento, $Tramite)
  {
    $db = new Conexion();
    if ($Tramite == "SS") {
      $insertar = $db->query("DELETE FROM tblc_doctramite WHERE tblc_doctramite.IdDocTramite = '$IdDocumento'");
    } else {
      $insertar = $db->query("DELETE FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocumento'");
    }
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_delDocAspirante($IdDocumento, $Tramite)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocumento'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_del_docs_tramite($IdDocumento)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblc_docalumnos.Archivo, tblc_docalumnos.Anio, tblc_docalumnos.Mes FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocumento'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $anio = $datos11["Anio"];
    $mes = $datos11["Mes"];
    $Archivo = $datos11["Archivo"];
    $link = "assets/docs/files/$anio/$mes/$Archivo";

    if (file_exists($link)) {
      unlink($link);
    }


    $insertar = $db->query("UPDATE tblc_docalumnos SET tblc_docalumnos.Archivo = '', tblc_docalumnos.Estatus = '1'  WHERE tblc_docalumnos.IdDocAlumno = '$IdDocumento'");
    if ($insertar) {

      return 1;
    } else {

      return 0;
    }
  }

  #AGREGAR COMENTARIOS TAREAS
  public function add_tareacomentario($IdTarea, $Mensaje, $IdUsua, $Tipo, $IdUsua_recibe, $IdActividadDoc)
  {
    $db = new Conexion();
    $porciones = explode("-", $IdTarea);
    $IdTar = $porciones[0];

    $insertar = $db->query("INSERT INTO tblp_tareascomentarios (IdTarea, Tipo, Comentario, IdUsua, FecCap, IdUsua_envia, IdUsua_recibe, Visto, IdActividad) VALUES ('$IdTar','$Tipo','$Mensaje','$IdUsua',NOW(),'$IdUsua','$IdUsua_recibe','1','$IdActividadDoc')");

    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua_recibe' ");
    $db->rows($sql_us);
    $_cons = $db->recorrer($sql_us);
    $destinatario = $_cons['Correo'];
    if ($destinatario) {
      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 5;
      $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

      $sql_de = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
      $db->rows($sql_de);
      $_dex = $db->recorrer($sql_de);

      $sql_act = $db->query("SELECT tblp_actividadesdocente.NomActividad, tblp_modulo.NombreMod FROM tblp_actividadesdocente Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_actividadesdocente.IdModulo WHERE tblp_actividadesdocente.IdActividadesDocente =  '$IdActividadDoc' ");
      $db->rows($sql_act);
      $_act = $db->recorrer($sql_act);
      $actividad = htmlentities($_act['NomActividad']);
      $nombre = htmlentities($_cons['Nombre'] . ' ' . $_cons['APaterno'] . ' ' . $_cons['AMaterno']);
      $_de = htmlentities($_dex['Nombre'] . ' ' . $_dex['APaterno'] . ' ' . $_dex['AMaterno']);

      $asunto = "Comentario en la actividad - " . $actividad . ' - ' . $cod;

      $_link = "https://seuninnova.com/";
      $materia = htmlentities($_act['NombreMod']);
      $Mensaje = htmlentities($Mensaje);

      $_sistema = "Universidad del Pais INNOVA";
      // $_sistema = htmlentities($_sistema);

      $cuerpo = "<table id='x_bodyTable' style='border-collapse: collapse; height: 100%; margin: 0px; padding: 0px; width: 100%; transform: scale(0.87); transform-origin: left top 0px;' min-scale='0.87' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td id='x_bodyCell' style='height:100%; margin:0; padding:0; width:100%' valign='top' align='center'><table style='border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td id='x_templateHeader' style='background:#F7F7F7 none no-repeat center/cover; background-color:#F7F7F7; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0px; padding-bottom:0px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_headerContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'></td></tr></tbody></table></td></tr><tr><td id='x_templateBody' style='background:#FFFFFF none no-repeat center/cover; background-color:#FFFFFF; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:27px; padding-bottom:63px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_bodyContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; color:#828282; word-break:break-word; font-family:Helvetica; font-size:16px; line-height:150%; text-align:left' valign='top'></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnImageBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnImageBlockOuter'><tr><td class='x_mcnImageBlockInner' style='padding:9px' valign='top'><table class='x_mcnImageContentContainer' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnImageContent' style='padding-right:9px; padding-left:9px; padding-top:0; padding-bottom:0; text-align:center' valign='top'> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; font-family:Lato,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; word-break:break-word; color:#757575; font-size:16px; line-height:150%; text-align:justify' valign='top'><p style='font-size: 17px; background: #5a284f; padding: 10px; text-align: center; color: yellow;'>Notificaci&oacute;n autom&aacute;tica $_sistema </p><br>Estimado(a) <strong> $nombre, </strong> se le notifica tiene un nuevo mensaje con los siguientes datos:<br><br><b>Materia:</b> $materia<br><b>Actividad:</b> $actividad<br><b>De:</b> $_de<br><b>Mensaje</b>: $Mensaje <br><br><br>  </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnButtonBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnButtonBlockOuter'><tr><td class='x_mcnButtonBlockInner' style='padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px' valign='top' align='center'><table class='x_mcnButtonContentContainer' style='border-collapse:separate!important; border-radius:28px; background-color:#0047FF' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td class='x_mcnButtonContent' style=' background: #971762; border-radius: 40px; font-family:Arial; font-size:16px; padding:18px' valign='middle' align='center'><a href='$_link' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' class='x_mcnButton' title='Ir a la Plataforma' style='font-weight:bold; letter-spacing:normal; line-height:100%; text-align:center; text-decoration:none; color:#FFFFFF; display:block'>Ingresar a la Plataforma</a> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnDividerBlock' style='min-width:100%; border-collapse:collapse; table-layout:fixed!important' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnDividerBlockOuter'><tr><td class='x_mcnDividerBlockInner' style='min-width:100%; padding:18px'><table class='x_mcnDividerContent' style='min-width:100%; border-top:2px solid #EAEAEA; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style=''><span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table> ";

      $headers = "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $headers .= "From: $_sistema <info@procesosus.com>\r\n";
      $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

      mail($destinatario, $asunto, $cuerpo, $headers);
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_chatPlaneacion($Tipo, $IdAsignacion, $IdUsua, $Chat, $IdPlaneacion)
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblh_chatplaneacion (IdUsua, Tipo, Chat, FecCap, IdAsignacion, Visto, IdPlaneacion) VALUES ('$IdUsua','$Tipo','$Chat',NOW(),'$IdAsignacion','1','$IdPlaneacion')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }



  # ACTUALIZAR ASIGNACION MODULO A DOCENTES
  public function upd_ModuloDocente()
  {
    $IdUsuaIni = $_POST["IdDocente"];
    $IdUsuaFin = $_POST["txtDocente"];
    $IdUsuaSS = $_POST["IdUsua"];
    $hoy = date("Y-m-d");

    $db = new Conexion();

    $sql5 = $db->query("SELECT tblp_asignacion.Estatus, tblp_asignacion.IdEstatus FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '" . $_POST["IdAsignacion"] . "' ");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $_estatus = $datos51['Estatus'];
    $_idEstatus = $datos51['IdEstatus'];

    $ini = $_POST["datepicker"];
    $fin = $_POST["datepicker2"];

    if (($hoy >= $ini) && ($hoy <= $fin)) {
      $_estatus = 'Activo';
      $_idEstatus = 8;
    }

    $insertar = $db->query("UPDATE tblp_asignacion SET IdEstatus = '$_idEstatus', Estatus = '$_estatus', FecIni = '" . $_POST["datepicker"] . "', FecFin = '" . $_POST["datepicker2"] . "', IdUsua = '" . $_POST["txtDocente"] . "', NoParcial = '" . $_POST["txt_parcial"] . "'  WHERE tblp_asignacion.IdAsignacion = '" . $_POST["IdAsignacion"] . "' AND tblp_asignacion.Tipo = '2'");
    $insertar = $db->query("UPDATE tblp_asignacion SET IdEstatus = '$_idEstatus', Estatus = '$_estatus', FecIni = '" . $_POST["datepicker"] . "', FecFin = '" . $_POST["datepicker2"] . "', IdUsua = '" . $_POST["txtTutor"] . "', NoParcial = '" . $_POST["txt_parcial"] . "' WHERE tblp_asignacion.IdAsignacion = '" . $_POST["IdAsignacion"] . "' AND tblp_asignacion.Tipo = '4'");
    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Estatus = '$_estatus' WHERE tblp_moduloalumno.IdAsignacion = '" . $_POST["IdAsignacion"] . "' ");

    
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_Matricula()
  {
    $anio = date("Y");
    $annio = substr($anio, 2, 2);
    $IdOferta = $_POST["txtOferta"];
    $IdGrupo = $_POST["txtGrupo"];
    $Tipo = $_POST["txtTipo"];
    $db = new Conexion();

    $sql5 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdGrado = $datos51['IdGrado'];

    // $sql9 = $db->query("SELECT Count(tblc_matricula.Numero) AS numTotal FROM tblc_matricula WHERE tblc_matricula.IdOferta =  '$IdOferta'  AND tblc_matricula.Anio =  '$anio' AND tblc_matricula.IdGrado = '$IdGrado'");
    $sql9 = $db->query("SELECT Count(tblc_matricula.Numero) AS numTotal FROM tblc_matricula WHERE tblc_matricula.Anio =  '$anio' AND tblc_matricula.IdGrado = '$IdGrado'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $numero = $datos91["numTotal"];

    $sql8 = $db->query("SELECT tblc_usuario.Matricula FROM tblc_usuario WHERE tblc_usuario.Tipo =  '3' AND tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.IdGrupo =  '$IdGrupo' ORDER BY tblc_usuario.Matricula DESC");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $Matrxx = $datos81["Matricula"];

    if ($Matrxx) {
      $valor = 2;
    } else {
      $sqly = $db->query("SELECT tblc_usuario.Matricula, tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Tipo =  '3' AND tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.IdGrupo =  '$IdGrupo' AND tblc_usuario.IdEstatus = '8'  ORDER BY tblc_usuario.APaterno ASC");
      while ($z = $db->recorrer($sqly)) {
        $IdUsua = $z["IdUsua"];
        $numero = $numero + 1;
        $mat = str_pad($numero, 4, "0", STR_PAD_LEFT);
        $matricula = $Tipo . $annio . $mat;
        $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdGrado, IdOferta, IdGrupo ) VALUES ('$anio','$numero','$matricula','$IdUsua','$IdGrado','$IdOferta','$IdGrupo')");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Matricula = '$matricula' WHERE tblc_usuario.IdUsua = '$IdUsua'");
        $valor = 1;
      }
    }
    if ($valor) {
      return $valor;
    } else {
      return 0;
    }
  }

  # ACTUALIZAR ACTIVIDAD DEL DOCENTE
  public function upd_ActividadesDoc()
  {
    $tipo = $_POST["txtTipoActividad"];
    $FecAct = date("Y-m-d");
    $id = $_POST["IdE"];
    $FecIni = $_POST["datepicker1"];
    $FecFin = $_POST["datepicker2"];

    if ($FecAct < $FecIni) {
      $Estatus = "Inicializado";
    }
    if ($FecAct >= $FecIni) {
      $Estatus = "Activo";
    }

    if ($FecFin <= $FecAct) {
      $Estatus = "Activo";
    }
    if ($FecAct > $FecFin) {
      $Estatus = "Finalizado";
    }

    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_actividad SET FecIni = '" . $_POST["datepicker1"] . "', FecFin = '" . $_POST["datepicker2"] . "', Modalidad = '" . $_POST["txtModalidad"] . "', TituloActividad = '" . $_POST["txtTitulo"] . "', Descripcion = '" . $_POST["txtDescripcion"] . "', Porcentaje = '" . $_POST["txtPorcentaje"] . "', Estatus = '$Estatus' WHERE tblp_actividad.IdActividad = '" . $_POST["IdActividad"] . "' AND tblp_actividad.IdAsignacion = '" . $_POST["Id"] . "'");
    $insertar = $db->query("INSERT INTO tblh_historial (IdUsua, Tipo, Modulo, Titulo, Descripcion, FecCap, IdAsignacion) VALUES ('" . $_SESSION['IdUsua'] . "','Modifico','" . $_POST["txtTipoActividad"] . "','" . $_POST["txtTitulo"] . "','" . $_POST["txtDescripcion"] . "',NOW(),'" . $_SESSION['IdAsignacion'] . "')");
    if ($insertar) {
      $_SESSION['Alerta'] = "ACTUALIZAR";
      $_SESSION['Variable'] = "ACTIVIDAD DE LA ASIGNATURA";
      echo "<script type='text/javascript'>window.location='doAddActividades.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL AGREGAR ACTIVIDAD DE LA ASIGNATURA";
      echo "<script type='text/javascript'>window.location='doAddActividades.php';</script>";
    }
  }

  # INSRTA EL EXAMEN
  public function get_insertarExamen($IdAsignacion, $NoActividad, $IdUsua)
  {
    $db = new Conexion();
    $sqly = $db->query("SELECT * FROM tblp_examen WHERE tblp_examen.IdAsignacion = '$IdAsignacion' AND tblp_examen.NoActividad = '$NoActividad'");
    while ($z = $db->recorrer($sqly)) {
      $insertar = $db->query("INSERT INTO tblp_resultadoexamen (IdUsua,IdAsignacion,NoActividad,NoPregunta,FecCap,IdExamen) VALUES ('$IdUsua','$IdAsignacion','$NoActividad','" . $z["NoPregunta"] . "',NOW(),'" . $z["IdExamen"] . "')");
    }
  }

  # AGREGAR USUARIO
  public function add_Usuario()
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE  Correo = '" . $_POST["txtCorreo"] . "' AND  Permisos = '" . $_POST["txtTipo"] . "'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $code = $datos2["Code"];

    if ($code) {
      return 2;
      exit();
    }

    $sql5 = $db->query("SELECT * FROM tblc_permiso WHERE  tblc_permiso.IdPermiso = '" . $_POST["txtTipo"] . "'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $tipo = $datos51["Permiso"];
    $permisos = $_POST["txtTipo"];
    $cc = $_POST["txtCorreo"];


    $pass = $_POST["txtPass"];
    $codeok = $_POST["txtPass"];
    $code = $pass;

    if ($permisos == 3) {
      $IdO = $_POST["txtOferta"];

      $campO = ", IdOferta";
      $datoO = ", '$IdO'";
    } else {
      $campO = "";
      $datoO = "";
    }

    $tSexo = "nuevo.png";

    $pass_php = Password::hash($pass);

    if ($permisos == 2) {
      $IdCampus = $_POST["txtCampus"];
      $anio = date("Y");
      $mes = date("m");
      $mes = ($mes * 1);

      $_anio = substr($anio, 2, 2);
      if (($mes == 1) || ($mes == 2) || ($mes == 3) || ($mes == 4)) {
        $_mes = "01";
      }
      if (($mes == 5) || ($mes == 6) || ($mes == 7) || ($mes == 8)) {
        $_mes = "02";
      }
      if (($mes == 9) || ($mes == 10) || ($mes == 11) || ($mes == 12)) {
        $_mes = "03";
      }
      $_campus = "0" . $IdCampus;

      $sql1 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.Permisos =  '2' ORDER BY tblc_usuario.FecCap DESC LIMIT 1");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $Usuario = $datos2["Usuario"];

      $r_anio = substr($Usuario, 0, 2);
      $r_consecutivo = substr($Usuario, 6, 3);

      if ($_anio = $r_anio) {
        $r_consecutivo = ($r_consecutivo + 1);
      } else {
        $r_consecutivo = 1;
      }
      $code = str_pad($r_consecutivo, 3, "0", STR_PAD_LEFT);
      $user = $_anio . $_mes . $_campus . $code;
    } else {
      $user = $_POST["txtUser"];
    }



    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Telefono, Correo, Usuario, Pass_php, Permisos, FecCap, Foto, Sexo,Code,IdCampus, Matricula, IdEstatus $campO)VALUES ('" . $_POST["txtNombre"] . "','" . $_POST["txtAPaterno"] . "','" . $_POST["txtAMaterno"] . "','$tipo','" . $_POST["txtTelefono"] . "','" . $_POST["txtCorreo"] . "','$user','$pass_php','" . $_POST["txtTipo"] . "',NOW(),'$tSexo','" . $_POST["txtSexo"] . "','$codeok','" . $_POST["txtCampus"] . "','$user','8' $datoO)");
    $IdUser = $db->insert_id;

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_alumno()
  {
    $db = new Conexion();
    $anio = date("Y");
    $anioo = substr($anio, 2, 2);

    $IdSeriacion = $_POST["IdSeriacion"];

    $sql5 = $db->query("SELECT * FROM tblc_seriacion WHERE  tblc_seriacion.IdSeriacion = '$IdSeriacion'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $Mat = $datos51["Matricula"];
    $IdCampus = $datos51["IdCampus"];
    $IdOferta = $datos51["IdOferta"];


    $sql6 = $db->query("SELECT tblc_matricula.IdMatricula, tblc_matricula.Numero FROM tblc_matricula WHERE tblc_matricula.Anio = '$anio' AND tblc_matricula.Tipo = '$Mat' ORDER BY tblc_matricula.Numero DESC LIMIT 1");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $Num = $datos61["Numero"] + 1;
    $code = str_pad($Num, 3, "0", STR_PAD_LEFT);
    $matCom = $Mat . $anioo . $code;


    $permisos = 3;
    $tipo = "Alumno";
    $cc = $_POST["txtCorreo"];

    $pass = "universidad";
    $code = $pass;

    $pass_php = Password::hash($pass);

    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Telefono, Correo, Pass_php, Permisos, FecCap, Foto, Code,IdCampus, IdEstatus, IdOferta, IdGrupo, Usuario, Matricula, Sexo, SemCua) VALUES ('" . $_POST["txtNombre"] . "','" . $_POST["txtAPaterno"] . "','" . $_POST["txtAMaterno"] . "','$tipo','" . $_POST["txtTelefono"] . "','" . $_POST["txtCorreo"] . "','$pass_php','$permisos',NOW(),'nuevo.png','$code','" . $_POST["txtCampus"] . "','31','" . $_POST["txtOferta"] . "','" . $_POST["txtGrupo"] . "','$matCom','$matCom','" . $_POST["txtSexo"] . "','1')");
    $IdUsua = $db->insert_id;

    $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdOferta, IdGrupo, Tipo, FecCap)VALUES ('$anio','$Num','$matCom','$IdUsua','" . $_POST["txtOferta"] . "','" . $_POST["txtGrupo"] . "','$Mat',NOW())");

    $sql4 = $db->query("SELECT * FROM tblp_grupo WHERE  tblp_grupo.IdGrupo = '" . $_POST["txtGrupo"] . "'");
    $db->rows($sql4);
    $datos41 = $db->recorrer($sql4);
    $IdEs = $datos41["IdEstatus"];

    if ($IdEs == 12) {
      $cx = 0;
      $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdGrupo =  '" . $_POST["txtGrupo"] . "' AND tblp_moduloalumno.Estatus =  'Activo' GROUP BY tblp_moduloalumno.IdAsignacion");
      while ($x = $db->recorrer($sql)) {
        $cx = 1;
        $IdMod = $x["IdModulo"];
        $IdAsig = $x["IdAsignacion"];
        $Grp = $x["Grupo"];
        $code = md5(rand() * time());
        $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('" . $_POST["txtOferta"] . "','$IdMod','$Grp',$IdUsua,'Activo',NOW(),'$IdAsig','" . $_POST["txtGrupo"] . "')");
      }

      if ($cx == 0) {

        $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_asignacion.Grupo FROM tblp_asignacion WHERE  tblp_asignacion.IdGrupo = '" . $_POST["txtGrupo"] . "' AND tblp_asignacion.Tipo = '2'");
        while ($x = $db->recorrer($sql)) {
          $IdMod = $x["IdModulo"];
          $IdAsig = $x["IdAsignacion"];
          $Grp = $x["Grupo"];
          $code = md5(rand() * time());
          $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('" . $_POST["txtOferta"] . "','$IdMod','$Grp',$IdUsua,'Activo',NOW(),'$IdAsig','" . $_POST["txtGrupo"] . "')");
        }
      }

      $sql2 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_tareas.IdTarea, tblp_tareas.IdParcialDocente, tblp_tareas.IdActividadesDocente FROM tblp_asignacion Left Join tblp_tareas ON tblp_tareas.IdAsignacion = tblp_asignacion.IdAsignacion WHERE tblp_asignacion.IdGrupo = '" . $_POST["txtGrupo"] . "' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_tareas.IdActividadesDocente");
      while ($x = $db->recorrer($sql2)) {
        $IdAsignacion = $x["IdAsignacion"];
        $IdParcialDocente = $x["IdParcialDocente"];
        $IdActividadesDocente = $x["IdActividadesDocente"];
        $code = md5(rand() * time());
        $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','$IdActividadesDocente','$IdParcialDocente')");
      }



      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    }


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_alumno_ex()
  {
    $db = new Conexion();
    $anio = date("Y");
    $anioo = substr($anio, 2, 2);

    $IdSeriacion = $_POST["IdSeriacion"];

    $sql5 = $db->query("SELECT * FROM tblc_seriacion WHERE  tblc_seriacion.IdSeriacion = '$IdSeriacion'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $Mat = $datos51["Matricula"];
    $IdCampus = $datos51["IdCampus"];
    $IdOferta = $datos51["IdOferta"];


    $sql6 = $db->query("SELECT tblc_matricula.IdMatricula, tblc_matricula.Numero FROM tblc_matricula WHERE tblc_matricula.Anio = '$anio' AND tblc_matricula.Tipo = '$Mat' ORDER BY tblc_matricula.Numero DESC LIMIT 1");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $Num = $datos61["Numero"] + 1;
    $code = str_pad($Num, 3, "0", STR_PAD_LEFT);
    $matCom = $Mat . $anioo . $code;


    $permisos = 10;
    $tipo = "Usuario externo";
    $cc = $_POST["txtCorreo"];

    $pass = "universidad";
    $code = $pass;

    $pass_php = Password::hash($pass);

    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Tipo, Cargo, Celular, Correo, Pass_php, Permisos, FecCap, Foto, Code,IdCampus, IdEstatus, IdOferta, IdGrupo, Usuario, Matricula, Sexo, SemCua) VALUES ('" . $_POST["txtNombre"] . "','" . $_POST["txtAPaterno"] . "','" . $_POST["txtAMaterno"] . "','" . $_POST["txtTipo"] . "','$tipo','" . $_POST["txtTelefono"] . "','" . $_POST["txtCorreo"] . "','$pass_php','$permisos',NOW(),'nuevo.png','$code','$IdCampus','8','$IdOferta','" . $_POST["txtGrupo"] . "','$matCom','$matCom','" . $_POST["txtSexo"] . "','1')");
    $IdUsua = $db->insert_id;

    $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdOferta, IdGrupo, Tipo, FecCap)VALUES ('$anio','$Num','$matCom','$IdUsua','$IdOferta','" . $_POST["txtGrupo"] . "','$Mat',NOW())");

    $sql9 = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdCalendario = '" . $_POST["txtPlan"] . "' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Monto = $datos91["Monto"];
    $Fec = $datos91["FecDescuento"];
    $IdCiclo = $datos91["IdCiclo"];
    $IdPlan = $datos91["IdConceptosPlanes"];
    $anio = date("Y");

    $sql8 = $db->query("SELECT tblc_conceptosplanes.IdConcepto FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan' ");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdConcepto = $datos81["IdConcepto"];

    $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('" . $_POST["txtPlan"] . "','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fec','$Fec','$Fec','$Fec','$IdCiclo','$anio','$IdPlan','1','NO-F32','2','1','32','$IdConcepto',0,0,'" . $_POST["txtDescuento"] . "','" . $_POST["txtGrupo"] . "')");


    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_prospectoNew($IdUsua)
  {
    $db = new Conexion();
    $sql6 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $insertar = $db->query("INSERT INTO tblh_prospectos (IdUsua, Nombre, APaterno, AMaterno, Cargo, Tipo, Telefono, Correo, Usuario, Pass_php, FecAlta, Permisos, FecCap, Estado, Estatus, Foto, IdOferta, Sexo, FecNac, Code, IdGrupo, Matricula, Visto, Documentos, GPago, NoDoc) VALUES ('" . $datos61[0] . "','" . $datos61[1] . "','" . $datos61[2] . "','" . $datos61[3] . "','" . $datos61[4] . "','" . $datos61[5] . "','" . $datos61[6] . "','" . $datos61[7] . "','" . $datos61[8] . "','" . $datos61[9] . "','" . $datos61[10] . "','" . $datos61[11] . "','" . $datos61[12] . "','" . $datos61[13] . "','" . $datos61[14] . "','" . $datos61[15] . "','" . $datos61[16] . "','" . $datos61[17] . "','" . $datos61[18] . "','" . $datos61[19] . "','" . $datos61[21] . "','" . $datos61[22] . "','" . $datos61[23] . "','" . $datos61[24] . "','" . $datos61[25] . "','" . $datos61[26] . "')");

    $insertar = $db->query("DELETE FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_excel($IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblh_temporal WHERE tblh_temporal.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblh_excel SET tblh_excel.IdEstatus = '24', tblh_excel.IdUsuaDel = '$IdUsua', tblh_excel.FecDel = NOW() WHERE tblh_excel.IdUsua = '$IdUsua'");
    if ($insertar) {
      $_SESSION['Alerta'] = "3";
      return 1;
    } else {
      return 0;
    }
  }

  public function del_usersExcel($IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblh_temusers WHERE tblh_temusers.IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_claveSer($clave)
  {
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblc_serie (Serie) VALUES ('$clave')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_catMod($IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblh_catmodulotem");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_Saldo($IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblh_saldo WHERE tblh_saldo.IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_closeGrupo($IdUsua, $IdGrupo)
  {
    $db = new Conexion();

    $sql6 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.IdCicloIni, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);

    $grado = $datos61['IdGrado'];
    $idCicloIni = $datos61['IdCicloIni'];
    $cveGrupo = $datos61['CveGrupo'];

    $pass = 'universidad';
    $pass_php = Password::hash($pass);


    $sqly = $db->query("SELECT * FROM tblh_temporal WHERE tblh_temporal.IdEstatus = '8' AND tblh_temporal.IdUsua = '$IdUsua'");
    while ($z = $db->recorrer($sqly)) {
      $nombre = $z["Nombre"];
      $paterno = $z["APaterno"];
      $materno = $z["AMaterno"];
      $usuario = $z["Usuario"];
      $idoferta = $z["Oferta"];
      $idcampus = $z["Campus"];
      $cel = $z["Cel"];
      $nac = $z["Nac"];
      $sexo = $z["Sexo"];
      $correo = $z["Correo"];
      $correo_ins = $z["Correo_ins"];
      $_fol = time();

      $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Usuario, Pass_php, Permisos, FecCap, Foto, Code, IdGrupo, IdEstatus, IdOferta, IdCampus, Matricula, SemCua, Grado, Sexo, Correo, Folio, id_ciclo_ini, Celular, FecNac, Correo_institucional) VALUES ('$nombre','$paterno','$materno','Alumno','$usuario','$pass_php','3',NOW(),'nuevo.png','universidad','$IdGrupo','8','$idoferta','$idcampus','$usuario','1','$grado','$sexo','$correo','$_fol','$idCicloIni','$cel','$nac','$correo_ins')");
    }

    $insertar = $db->query("DELETE FROM tblh_temporal WHERE tblh_temporal.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblh_excel SET tblh_excel.IdEstatus = '4', tblh_excel.IdUsuaDel = '$IdUsua', tblh_excel.FecDel = NOW() WHERE tblh_excel.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdEstatus = '8', tblp_grupo.Tipo = 'Cerrado' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savUsers($IdUsua)
  {
    $db = new Conexion();
    $sqly = $db->query("SELECT * FROM tblh_temusers WHERE tblh_temusers.IdUsua = '$IdUsua'");
    while ($z = $db->recorrer($sqly)) {
      $IdPermiso = $z["Permisos"];
      $sql3 = $db->query("SELECT * FROM tblc_permiso WHERE tblc_permiso.IdPermiso =  '$IdPermiso'");
      $db->rows($sql3);
      $datos31 = $db->recorrer($sql3);
      $cargo = $datos31["Permiso"];

      $nombre = $z["Nombre"];
      $paterno = $z["APaterno"];
      $materno = $z["AMaterno"];

      $campus = $z["Campus"];

      $sexo = $z["Sexo"];
      $correo = $z["Correo"];
      $fecnac = $z["FecNac"];
      $celular = $z["Celular"];

      $user = $z["Usuario"];
      $pass = $z["Pass"];
      $code = $pass;
      $pass_php = Password::hash($pass);

      $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Usuario, Pass_php, Permisos, FecCap, Foto, Sexo, Code, IdEstatus, IdCampus, Correo, FecNac, Celular) VALUES('$nombre','$paterno','$materno','$cargo','$user','$pass_php','$IdPermiso',NOW(),'nuevo.png','$sexo','$code','8','$campus','$correo','$fecnac','$celular')");
    }

    $insertar = $db->query("DELETE FROM tblh_temusers WHERE tblh_temusers.IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_addAsignaturasTb($IdUsua)
  {
    $db = new Conexion();

    $sqly = $db->query("SELECT * FROM tblh_catmodulotem WHERE tblh_catmodulotem.IdUsua = '$IdUsua' AND tblh_catmodulotem.IdEstatus = '8'");
    while ($z = $db->recorrer($sqly)) {
      $CodeModulo = $z["IdAsignatura"];
      $Modulo = $z["Asignatura"];
      $Modulo = $z["Asignatura"];
      $credito = $z["Grupo"];
      $IdOferta = $z["IdOferta"];
      $IdCampus = $z["IdCampus"];
      $HraDoc = $z["HraDoc"];
      $HraInd = $z["HraInd"];

      $ClvOfer = substr($CodeModulo, 0, 3);
      // $Code = substr($CodeModulo, 3 , 3);
      $Code = intval(preg_replace('/[^0-9]+/', '', $CodeModulo), 10);

      $grad = ($Code * 1);
      if ($grad >= 1000) {
        $gradn = substr($grad, 1, 1);
      } else {
        $gradn = substr($grad, 0, 1);
      }


      $insertar = $db->query("INSERT INTO tblp_modulo (CodeModulo,NombreMod,Grado,Estatus,IdEducativa, Code,Oferta,IdCampus,FecCap, Creditos, HraDoc, HraInd) VALUES ('$CodeModulo','$Modulo','$gradn','Activo','$IdOferta','$Code','$ClvOfer','$IdCampus',NOW(),'$credito','$HraDoc','$HraInd')");
      //$IdModuloxX = $db->insert_id;
      //$insertar = $db->query("INSERT INTO tblp_modulodatos (IdEducativa, IdModulo) VALUES ('$IdOferta','$IdModuloxX')");
    }

    $insertar = $db->query("DELETE FROM tblh_catmodulotem WHERE tblh_catmodulotem.IdUsua = '$IdUsua'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_addSaldoIni($IdUsuaX)
  {
    $db = new Conexion();

    $sqly = $db->query("SELECT * FROM tblh_saldo WHERE tblh_saldo.IdUsua = '$IdUsuaX' AND tblh_saldo.IdEstatus = '8'");
    while ($z = $db->recorrer($sqly)) {
      $IdUsua = $z["IdAlumno"];
      $Monto = $z["Deuda"];
      $Fecha = $z["Fecha"];
      $Descripcion = $z["Descripcion"];
      $Comentario = $z["Comentario"];
      $IdOferta = $z["IdOferta"];
      $IdCampus = $z["IdCampus"];

      $insertar = $db->query("INSERT INTO tblp_saldo (IdUsua, IdOferta, IdCampus, Monto, Descripcion, Comentario, IdEstatus, Fecha, FecCap, Tipo) VALUES ('$IdUsua','$IdOferta','$IdCampus','$Monto','$Descripcion','$Comentario','8','$Fecha',NOW(),'Egreso')");
    }
    $insertar = $db->query("DELETE FROM tblh_saldo WHERE tblh_saldo.IdUsua = '$IdUsuaX'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  # ACTUALIZAR USUARIO
  public function upd_Usuario()
  {
    $user = $_POST["txtUsuario"];

    $pass = $_POST["txtPass"];
    if ($pass) {
      $code = $pass;
      $pass_php = Password::hash($pass);
      $condx = ", Pass_php = '$pass_php', Code = '$code'";
    } else {
      $condx = "";
    }

    $db = new Conexion();
    $sql5 = $db->query("SELECT * FROM tblc_permiso WHERE  tblc_permiso.IdPermiso = '" . $_POST["txtTipo"] . "'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $tipo = $datos51["Permiso"];

    $insertar = $db->query("UPDATE tblc_usuario SET Cargo = '$tipo', Permisos = '" . $_POST["txtTipo"] . "', Nombre = '" . $_POST["txtNombre"] . "', APaterno = '" . $_POST["txtAPaterno"] . "', AMaterno = '" . $_POST["txtAMaterno"] . "', Telefono = '" . $_POST["txtTelefono"] . "', Correo = '" . $_POST["txtCorreo"] . "', Usuario = '$user', Matricula = '$user', Sexo = '" . $_POST["txtSexo"] . "' $condx WHERE tblc_usuario.IdUsua = '" . $_POST["IdUsua"] . "'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  # AGREGAR ALUMNO A GRUPO
  public function add_GrupoAlumno($IdAsignacion, $Equipo, $IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_moduloalumno SET Equipo= '$Equipo' WHERE IdAsignacion = '$IdAsignacion' AND IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_delUsua($IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("DELETE FROM tblc_matricula WHERE tblc_matricula.IdUsua = '$IdUsua'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  # AGREGAR CALIFICACIONES
  public function add_Calificaciones($IdAsignacion, $IdAlumno, $Calificacion, $IdTarea, $IdUsua, $TipoCalificar, $equipo, $MaxCalificacion, $IdActividadDoc)
  {
    $db = new Conexion();

    if ($Calificacion <= $MaxCalificacion) {
      if ($TipoCalificar == 2) {
        $sqly = $db->query("SELECT IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.Equipo = '$equipo'");
        while ($z = $db->recorrer($sqly)) {
          $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Calificacion= '$Calificacion', tblp_tareas.Porcentaje = '$Calificacion' WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdAlumno = '" . $z["IdUsua"] . "' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc' ");
          $this->add_registros($IdUsua, "Ha actualizado la calificación de la actividad: $Calificacion",'Update','Calificación actividad', $IdAsignacion, $IdAlumno,$IdActividadDoc);
        }
      } else {
        $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Calificacion= '$Calificacion', tblp_tareas.Porcentaje = '$Calificacion' WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdTarea = '$IdTarea' AND tblp_tareas.IdAlumno = '$IdAlumno' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc'");
        $this->add_registros($IdUsua, "Ha actualizado la calificación de la actividad: $Calificacion",'Update','Calificación actividad', $IdAsignacion, $IdAlumno,$IdActividadDoc);
      }
      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 3;
    }
  }

  # AGREGAR FORO RESPUESTAS
  public function add_ForoRespuestas($IdActividad, $Mensaje, $IdUsua, $IdAsignacion)
  {
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_foro (IdActividad, Mensaje,IdUsua,FecCap,IdAsignacion) VALUES ('$IdActividad','$Mensaje','$IdUsua',NOW(),'$IdAsignacion')");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }
  public function get_datosrespuestas1X($idAsignacion, $IdActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '$IdActividad' AND tblp_foro.IdAsignacion = '$idAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 10,20");
    while ($x = $db->recorrer($sql)) {
      $gRespuestasId[] = $x;
    }
    return $gRespuestasId;
  }



  # AGREGAR RESPUESTA EXAMEN ALUMNOS
  public function add_respuestaAlumno($IdRespuesta, $NoPregunta, $IdUsua, $IdAsignacion, $NoActividad)
  {
    $db = new Conexion();
    $sqlf = $db->query("SELECT Valor FROM tblp_respuestaexamen WHERE tblp_respuestaexamen.IdRespuesta = '$IdRespuesta'");
    $db->rows($sqlf);
    $datos2f = $db->recorrer($sqlf);
    $valorE = $datos2f["Valor"];
    $insertar = $db->query("UPDATE tblp_resultadoexamen SET Calificacion = '$valorE', IdRespuesta= '$IdRespuesta' WHERE tblp_resultadoexamen.IdUsua ='$IdUsua' AND tblp_resultadoexamen.IdAsignacion = '$IdAsignacion' AND tblp_resultadoexamen.NoActividad = '$NoActividad' AND tblp_resultadoexamen.NoPregunta = '$NoPregunta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function add_resExamen($IdResultado, $IdPregunta, $IdRespuesta)
  {
    $db = new Conexion();
    $sqlf = $db->query("SELECT Valor FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdRespuesta = '$IdRespuesta' ");
    $db->rows($sqlf);
    $datos2f = $db->recorrer($sqlf);
    $valorE = $datos2f["Valor"];

    $insertar = $db->query("UPDATE tblp_examresultado SET tblp_examresultado.IdRespuesta = '$IdRespuesta', tblp_examresultado.Valor = '$valorE', tblp_examresultado.FecCap = NOW() WHERE tblp_examresultado.IdResultado ='$IdResultado'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  # ELIMINAR RESPUESTA
  public function del_respuesta($IdRespuesta)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblp_respuestaexamen WHERE tblp_respuestaexamen.IdRespuesta = '$IdRespuesta'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  # ELIMINAR PREGUNTAS
  public function del_preguntas($IdExamen)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblp_respuestaexamen WHERE tblp_respuestaexamen.IdExamen = '$IdExamen'");
    $insertar = $db->query("DELETE FROM tblp_examen WHERE tblp_examen.IdExamen = '$IdExamen'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_userCurso($IdUsua, $IdAsignacion, $IdEducativa, $Modulo)
  {
    $db = new Conexion();

    $code = md5(rand() * time());
    $Id = $code;

    $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdEducativa','$Modulo','0','$IdUsua','Activo',NOW(),'$IdAsignacion','0')");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function del_userCurso($IdUsua, $IdAsignacion, $IdEducativa, $Modulo)
  {
    $db = new Conexion();

    $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdEducativa = '$IdEducativa'AND tblp_moduloalumno.IdModulo = '$Modulo' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  # ACTUALIZAR DATOS MODULO
  public function act_ModuloDatos()
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_modulodatos SET Objetivo = '" . $_POST["txtObjetivo"] . "', Tema = '" . $_POST["txtTema"] . "', Metodologia = '" . $_POST["txtMetodologia"] . "', Evaluacion = '" . $_POST["txtEvaluacion"] . "', Bibliografia = '" . $_POST["txtBibliografia"] . "' WHERE IdDatosM = '" . $_POST["IdDatosM"] . "'");
    if ($insertar) {
      $_SESSION['Alerta'] = "ACTUALIZAR";
      $_SESSION['Variable'] = "DATOS DE LA ASIGNATURA";
      echo "<script type='text/javascript'>window.location='adAddModDatos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL ACTUALIZAR LOS DATOS DE LA ASIGNATURA";
      echo "<script type='text/javascript'>window.location='adAddModDatos.php';</script>";
    }
  }

  # ACTUALIZAR DATOS MODULO DOCENTE
  public function act_ModuloDatosDoc()
  {
    $id = $_POST["IdE"];
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_modulodatos SET Objetivo = '" . $_POST["txtObjetivo"] . "', Introduccion = '" . $_POST["txtIntro"] . "' WHERE IdDatosM = '" . $_POST["IdDatosM"] . "'");
    if ($id) {
      if ($insertar) {
        $_SESSION['Alerta'] = "ACTUALIZAR";
        $_SESSION['Variable'] = "Datos de la asignatura";
        echo "<script type='text/javascript'>window.location='doSelDatosM.php';</script>";
      } else {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL ACTUALIZAR LOS DATOS DE LA ASIGNATURA";
        echo "<script type='text/javascript'>window.location='doSelDatosM.php';</script>";
      }
    } else {
      if ($insertar) {
        $_SESSION['Alerta'] = "ACTUALIZAR";
        $_SESSION['Variable'] = "Datos de la asignatura";
        echo "<script type='text/javascript'>window.location='adAddModDatos.php';</script>";
      } else {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL ACTUALIZAR LOS DATOS DE LA ASIGNATURA";
        echo "<script type='text/javascript'>window.location='adAddModDatos.php';</script>";
      }
    }
  }

  # AGREGAR RECURSOS DE APOYO
  public function add_RecusosA()
  {
    $db = new Conexion();
    $Tipo = $_POST["Tipo"];
    $idAsignacion = $_POST["Id"];
    if ($Tipo == 0) {
      $anio = date("Y");
      $mes = date("m");

      $carpeta = "assets/biblioteca/$anio/$mes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)

      $archivo = $_FILES['archivo']['name']; //nombre del archivo
      $tamaño = $_FILES['archivo']['size']; //tamaño del archivo
      $info = new SplFileInfo($_FILES["archivo"]['name']);
      $tipox =  $info->getExtension();

      $archivo = time() . '.' . $tipox;

      if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $carpeta . $archivo)) {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
        echo "<script type='text/javascript'>window.location='doAddRecurso.php?idToks=$idAsignacion';</script>";
        exit();
      }


      $nombre_fichero = $carpeta . $archivo;

      if (file_exists($nombre_fichero)) {

        $insertar = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Link, IdTema,IdUsua,FecCap,Anio,Mes,Tipo,IdActividadesDocente) VALUES('$idAsignacion','" . $_POST["txtNombre"] . "','$archivo','" . $_POST["txtTipoDoc"] . "','" . $_POST["IdUsua"] . "',NOW(),'$anio','$mes','$tipox','" . $_POST["txtIdActividad"] . "')");
        echo "<script type='text/javascript'>window.location='doAddRecurso.php?idToks=$idAsignacion';</script>";
      } else {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
        echo "<script type='text/javascript'>window.location='doAddRecurso.php?idToks=$idAsignacion';</script>";
      }
    } else {
      $archivo = $_POST["txtVideo"];


      $resultado1 = str_replace("560", "100%", $archivo);
      $resultado2 =  str_replace("960", "100%", $resultado1);
      $resultado3 =  str_replace("560", "100%", $resultado2);
      $resultado4 =  str_replace("960", "100%", $resultado3);
      $resultado5 =  str_replace("569", "400", $resultado4);

      $insertar = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Link, IdTema,IdUsua,FecCap,Tipo,IdActividadesDocente) VALUES('$idAsignacion','" . $_POST["txtNombre"] . "','$resultado5','" . $_POST["txtTipoDoc"] . "','" . $_POST["IdUsua"] . "',NOW(),'youtube','" . $_POST["txtIdActividad"] . "')");
    }

    if ($insertar) {
      $_SESSION['Alerta'] = "GUARDAR";
      $_SESSION['Variable'] = "RECURSO DE APOYO";
      echo "<script type='text/javascript'>window.location='doAddRecurso.php?idToks=$idAsignacion';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
      echo "<script type='text/javascript'>window.location='doAddRecurso.php?idToks=$idAsignacion';</script>";
    }
  }

  public function lst_actividad($IdAsignacion)
  {
    $db = new Conexion();
    $lst_actividad = [];
    $sql = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.NomActividad, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' ORDER BY tblp_actividadesdocente.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $lst_actividad[] = $x;
    }
    return $lst_actividad;
  }

  # AGREGAR RECURSOS DE APOYO
  public function add_Bliblioteca()
  {
    $carpeta = "assets/biblioteca/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES['archivo']['name']; //nombre del archivo
    $tamaño = $_FILES['archivo']['size']; //tamaño del archivo
    $idAsignacion = 'x';
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $code = md5(rand() * time());
    $archivo = $code . '-' . $archivo; // ".$nombreImg[1]"; // Generamos un nombre de archivo Aleatorio para evitar conflictos entre los nombres.
    if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
      echo "<script type='text/javascript'>window.location='addBilbioteca.php';</script>";
      exit();
    }
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Descripcion, Autor, Link, IdTema,IdUsua,FecCap) VALUES('$idAsignacion','" . $_POST["txtNombre"] . "','" . $_POST["txtDescripcion"] . "', '" . $_POST["txtAutor"] . "','$archivo','" . $_POST["txtTipoDoc"] . "','" . $_POST["IdUsua"] . "',NOW())");
    if ($insertar) {
      $_SESSION['Alerta'] = "GUARDAR";
      $_SESSION['Variable'] = "RECURSO DE APOYO";
      echo "<script type='text/javascript'>window.location='addBilbioteca.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
      echo "<script type='text/javascript'>window.location='addBilbioteca.php';</script>";
    }
  }

  public function get_link($idAsignacion, $noActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdAsignacion ='$idAsignacion' AND tblp_tareas.NoActividad = '$noActividad' AND tblp_tareas.IdAlumno= '" . $_SESSION['IdUsua'] . "'");
    while ($x = $db->recorrer($sql)) {
      $gLInks[] = $x;
    }
    return $gLInks;
  }

  # AGREGAR TAREAS
  public function add_Tareas()
  {
    $noActividad = $_POST["NoActividad"];
    $idAsignacion = $_POST["IdAsignacion"];
    $NoArchivo = $_POST["NoArchivo"];
    $db = new Conexion();

    $sql1 = $db->query("SELECT $NoArchivo, Comentario, IdTarea FROM tblp_tareas WHERE tblp_tareas.IdAsignacion ='$idAsignacion' AND tblp_tareas.NoActividad = '$noActividad' AND tblp_tareas.IdAlumno= '" . $_SESSION['IdUsua'] . "'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $link = $datos11["0"];
    $Comentario = $datos11["Comentario"];

    if ($link) {
      $linkD = "assets/trabajos/$idAsignacion/tareas/$link";
      unlink($linkD);
    }
    $carpeta = "assets/trabajos/$idAsignacion/tareas/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES['archivo']['name']; //nombre del archivo
    $tamaño = $_FILES['archivo']['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $code = md5(rand() * time());
    $archivo = $code . '-' . $archivo;
    if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL SUBIR TAREA, NO SE PUEDE SUBIR ARCHIVO";
      echo "<script type='text/javascript'>window.location='alSelResponder.php?Id=z';</script>";
      exit();
    }
    if ($Comentario) {
      $condx1 = " ";
    } else {
      $com = $_POST["txtComentario"];
      $condx1 = " Comentario = '$com', ";
    }
    $insertar = $db->query("UPDATE tblp_tareas SET $NoArchivo = '$archivo', $condx1 FecCap = NOW() WHERE tblp_tareas.IdAsignacion ='$idAsignacion' AND tblp_tareas.NoActividad = '$noActividad' AND tblp_tareas.IdAlumno= '" . $_SESSION['IdUsua'] . "'");
    $mensaje = $_POST["txtComentario"];

    $sql2 = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.NoActividad = '$noActividad'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $logo = $datos21["Descripcion"];
    $tipoActividad = $datos21["TipoActividad"];

    $sql3 = $db->query("SELECT Correo, Nombre, APaterno, AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '" . $_SESSION['IdUsua'] . "'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $correo3 = $datos31["Correo"];
    $alumno = $datos31["Nombre"] . ' ' . $datos31["APaterno"] . ' ' . $datos31["AMaterno"];

    $sql4 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre, tblp_modulo.NoModulo, tblp_modulo.NombreMod, tblc_usuario.Nombre AS NombreDoc, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_asignacion.IdGrupo, tblc_usuario.Correo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Inner Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdAsignacion =  '$idAsignacion'");
    $db->rows($sql4);
    $datos41 = $db->recorrer($sql4);
    $oferta = $datos41["Nombre"];
    $modulo = $datos41["NoModulo"] . ' ' . $datos41["NombreMod"];
    $correoDocente = $datos41["Correo"];
    $alumno = $datos31["Nombre"] . ' ' . $datos31["APaterno"] . ' ' . $datos31["AMaterno"];
    $destinatario = $correo3;
    $folio = $datos11["IdTarea"];
    $asunto = "$tipoActividad respondida - Folio $folio";
    if ($Comentario) {
      $insertar = $db->query("INSERT INTO tblp_tareascomentarios (IdTarea, Tipo, Comentario, IdUsua, FecCap) VALUES ('$folio','A','" . $_POST["txtComentario"] . "','" . $_SESSION['IdUsua'] . "', NOW())");
    }

    if ($insertar) {
      $_SESSION['SaveFile'] = "1";
      $_SESSION['Alerta'] = "GUARDAR";
      $_SESSION['Variable'] = "TAREA";
      echo "<script type='text/javascript'>window.location='alSelResponder.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL SUBIR TAREA";
      echo "<script type='text/javascript'>window.location='alSelResponder.php';</script>";
    }
  }

  # actualizar dtos del docente
  public function upd_datosDocente()
  {
    $db = new Conexion();
    $cond = "";
    $tamaño = $_FILES['foto']['size']; //tamaño del archivo
    if ($tamaño) {
      $carpeta = "assets/perfil/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /
      $archivo = $_FILES['foto']['name']; //nombre del archivo
      $tamaño = $_FILES['foto']['size']; //tamaño del archivo
      $nombreImg = explode(".", $archivo);
      $nombreImg[1]; // Extención de la imagen

      $code = md5(rand() * time());
      $archivo = $code . '-' . $archivo;
      if (!move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta . $archivo)) {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL ACTUALIDAR DATOS";
        echo "<script type='text/javascript'>window.location='miEspacio.php';</script>";
        exit();
      }
      $cond = "Foto = '$archivo', ";
      $_SESSION['Foto'] = $archivo;

      $sql1 = $db->query("SELECT Foto FROM tblc_usuario WHERE tblc_usuario.IdUsua = '" . $_SESSION['IdUsua'] . "'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $link = $datos2["Foto"];
      if (($link == "mujer.png") || ($link == "hombre.png")) {
        //NO DEBE DE ELIMINAR
      } else {
        if ($link) {
          $linkD = "assets/perfil/$link";
          unlink($linkD);
        }
      }
    }
    $insertar = $db->query("UPDATE tblc_usuario SET $cond  Nombre = '" . $_POST["txtNombre"] . "',  APaterno = '" . $_POST["txtAPaterno"] . "',  AMaterno = '" . $_POST["txtAMaterno"] . "',  Telefono = '" . $_POST["txtTelefono"] . "',  Correo = '" . $_POST["txtCorreo"] . "' WHERE tblc_usuario.IdUsua= '" . $_SESSION['IdUsua'] . "' ");
    $insertar = $db->query("UPDATE tblp_docente SET Nombre = '" . $_POST["txtNombre"] . "',  APaterno = '" . $_POST["txtAPaterno"] . "',  AMaterno = '" . $_POST["txtAMaterno"] . "',  Semblanza = '" . $_POST["txtSemblanza"] . "' WHERE tblp_docente.IdUsua= '" . $_SESSION['IdUsua'] . "'");
    if ($insertar) {
      $_SESSION['Alerta'] = "ACTUALIZAR";
      $_SESSION['Variable'] = "DATOS";
      echo "<script type='text/javascript'>window.location='miEspacio.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL ACTUALIDAR DATOS";
      echo "<script type='text/javascript'>window.location='miEspacio.php';</script>";
    }
  }

  # actualizar dtos del docente
  public function upd_datosAlumno()
  {
    $db = new Conexion();
    $cond = "";
    
    $cor = $_POST["txtCorreo"];
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Celular = '" . $_POST["txtCelular"] . "',  tblc_usuario.Correo = '" . $_POST["txtCorreo"] . "' WHERE tblc_usuario.IdUsua= '" . $_SESSION['IdUsua'] . "'");
    if ($insertar) {
      if ($cor) {
        $_SESSION["Correo"] = $cor;
      }
      $_SESSION['Alerta'] = "ACTUALIZAR";
      $_SESSION['Variable'] = "DATOS";
      echo "<script type='text/javascript'>window.location='miEspacio.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL ACTUALIDAR DATOS";
      echo "<script type='text/javascript'>window.location='miEspacio.php';</script>";
    }
  }


  public function upd_datos_gral()
  {
    $db = new Conexion();
    $cond = "";
    $cond_fir = "";
    $tamaño = $_FILES['foto']['size']; //tamaño del archivo
    if ($tamaño) {
      $carpeta = "assets/perfil/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)

      $info = new SplFileInfo($_FILES["foto"]['name']);
      $tipox =  $info->getExtension();
      $archivo = time() . '.' . $tipox;

      if (!move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta . $archivo)) {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL ACTUALIZAR DATOS";
        echo "<script type='text/javascript'>window.location='actualizar_datos.php';</script>";
        exit();
      }
      $cond = "tblc_usuario.Foto = '$archivo', ";

      $_SESSION['Foto'] = $archivo;
    }

    $tam = $_FILES['firma']['size']; //tamaño del archivo
    if ($tam) {
      $carpeta = "assets/firma/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
      $info = new SplFileInfo($_FILES["firma"]['name']);
      $tipox =  $info->getExtension();
      $archivox = time() . '.' . $tipox;

      if (!move_uploaded_file($_FILES['firma']['tmp_name'], $carpeta . $archivox)) {
      }
      $cond_fir = ", tblc_usuario.id_paquete = '$archivox' ";
    }

    $cor = $_POST["txtCorreo"];

    $insertar = $db->query("UPDATE tblc_usuario SET $cond tblc_usuario.Celular = '" . $_POST["txtCelular"] . "',  tblc_usuario.Correo_institucional = '" . $_POST["txtCorreoIns"] . "', tblc_usuario.Correo = '" . $_POST["txtCorreo"] . "', tblc_usuario.Sexo = '" . $_POST["txtSexo"] . "', tblc_usuario.FecNac = '" . $_POST["txtFecNac"] . "', tblc_usuario.FecAlta = '" . $_POST["txtIngreso"] . "' $cond_fir WHERE tblc_usuario.IdUsua= '" . $_SESSION['IdUsua'] . "'");
    if ($insertar) {
      if ($cor) {
        $_SESSION["Correo"] = $cor;
      }
      $_SESSION['Alerta'] = "ACTUALIZAR";
      $_SESSION['Variable'] = "DATOS";
      echo "<script type='text/javascript'>window.location='actualizar_datos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL ACTUALIDAR DATOS";
      echo "<script type='text/javascript'>window.location='actualizar_datos.php';</script>";
    }
  }


  public function upd_datos_gral_admin()
  {
    $db = new Conexion();
    $cond = "";
    $cond_fir = "";
    $tamaño = $_FILES['foto']['size']; //tamaño del archivo
    if ($tamaño) {
      $carpeta = "assets/perfil/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)

      $info = new SplFileInfo($_FILES["foto"]['name']);
      $tipox =  $info->getExtension();
      $archivo = time() . '.' . $tipox;

      if (!move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta . $archivo)) {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL ACTUALIZAR DATOS";
        echo "<script type='text/javascript'>window.location='actualizar_admin.php';</script>";
        exit();
      }
      $cond = "tblc_usuario.Foto = '$archivo', ";

      $_SESSION['Foto'] = $archivo;
    }



    $cor = $_POST["txtCorreo"];

    $insertar = $db->query("UPDATE tblc_usuario SET $cond tblc_usuario.Celular = '" . $_POST["txtCelular"] . "',  tblc_usuario.Correo_institucional = '" . $_POST["txtCorreoIns"] . "', tblc_usuario.Correo = '" . $_POST["txtCorreo"] . "', tblc_usuario.Sexo = '" . $_POST["txtSexo"] . "', tblc_usuario.FecNac = '" . $_POST["txtFecNac"] . "', tblc_usuario.FecAlta = '" . $_POST["txtIngreso"] . "' $cond_fir WHERE tblc_usuario.IdUsua= '" . $_SESSION['IdUsua'] . "'");
    if ($insertar) {
      if ($cor) {
        $_SESSION["Correo"] = $cor;
      }
      $_SESSION['Alerta'] = "ACTUALIZAR";
      $_SESSION['Variable'] = "DATOS";
      echo "<script type='text/javascript'>window.location='actualizar_admin.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL ACTUALIDAR DATOS";
      echo "<script type='text/javascript'>window.location='actualizar_admin.php';</script>";
    }
  }


  public function del_firma()
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.id_paquete = null WHERE tblc_usuario.IdUsua= '" . $_SESSION['IdUsua'] . "'");
    if ($insertar) {
      $_SESSION['Alerta'] = "DEL_FIRMA";
      echo "<script type='text/javascript'>window.location='actualizar_datos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      echo "<script type='text/javascript'>window.location='actualizar_datos.php';</script>";
    }
  }

  public function add_datosFactura()
  {
    $db = new Conexion();
    $Id = $_POST["IdDatosFacturacion"];
    $Regimen = $_POST["txtRegimen"];
    if ($Id) {
      $insertar = $db->query("UPDATE tblc_datosfactura SET IdEstatus = '8', RFC = '" . $_POST["txtRFC"] . "',  Razon = '" . $_POST["txtRazon"] . "', Domicilio = '" . $_POST["txtDomicilio"] . "',NoExterior = '" . $_POST["txtNoExterior"] . "', NoInterior = '" . $_POST["txtNoInterior"] . "', CP = '" . $_POST["txtCP"] . "', Colonia = '" . $_POST["txtColonia"] . "', Municipio = '" . $_POST["txtMunicipio"] . "', Ciudad = '" . $_POST["txtCiudad"] . "', Estado = '" . $_POST["txtEstado"] . "', CURP = '" . $_POST["txtCURP"] . "', IdUso = '" . $_POST["txtUso"] . "', IdRegimen = '" . $_POST["txtRegimen"] . "' WHERE tblc_datosfactura.IdUsua =  '" . $_POST["IdUsua"] . "'");
      $_SESSION['Alerta'] = "ACTUALIZAR";
    } else {
      $insertar = $db->query("INSERT tblc_datosfactura (IdUsua, RFC , Razon, Domicilio, NoExterior, NoInterior, CP, Colonia, Municipio, Ciudad, Estado, IdUso, IdRegimen) VALUES('" . $_POST["IdUsua"] . "','" . $_POST["txtRFC"] . "','" . $_POST["txtRazon"] . "','" . $_POST["txtDomicilio"] . "','" . $_POST["txtNoExterior"] . "','" . $_POST["txtNoInterior"] . "','" . $_POST["txtCP"] . "','" . $_POST["txtColonia"] . "','" . $_POST["txtMunicipio"] . "','" . $_POST["txtCiudad"] . "','" . $_POST["txtEstado"] . "','" . $_POST["txtUso"] . "','" . $_POST["txtRegimen"] . "')");
      $_SESSION['Alerta'] = "GUARDAR";
    }

    if (!$Regimen) {
      $_SESSION['ERROR2'] = "ERROR";
      echo "<script type='text/javascript'>window.location='misdatosFact.php';</script>";
    }

    if ($insertar) {
      echo "<script type='text/javascript'>window.location='misdatosFact.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      echo "<script type='text/javascript'>window.location='misdatosFact.php';</script>";
    }
  }

  public function add_datos_no_factura()
  {
    $db = new Conexion();
    $Id = $_POST["IdDatosFacturacion"];

    if ($Id) {
      $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.IdEstatus = '9' WHERE tblc_datosfactura.IdUsua =  '" . $_POST["IdUsua"] . "'");
      $_SESSION['Alerta'] = "ACTUALIZAR";
    } else {
      $insertar = $db->query("INSERT tblc_datosfactura (IdUsua, IdEstatus) VALUES('" . $_POST["IdUsua"] . "','9')");
      $_SESSION['Alerta'] = "GUARDAR";
    }

    if ($insertar) {
      echo "<script type='text/javascript'>window.location='misdatosFact.php';</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      echo "<script type='text/javascript'>window.location='misdatosFact.php';</script>";
    }
  }

  public function up_logo()
  {
    $db = new Conexion();

    $carpeta = "assets/images/logos/";
    $archivo = $_FILES["txtLogo"]['name']; //nombre del archivo
    $tipo = $_FILES["txtLogo"]['type']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $tipo = $nombreImg[1];
    $archivo = time() . '.' . $tipo; // Generamos un nombre de archivo Aleatorio para evitar conflictos entre los nombres.
    if (!move_uploaded_file($_FILES["txtLogo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = 0;
      echo "<script type='text/javascript'>window.location='adAltas.php';</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;

    if (file_exists($nombre_fichero)) {
      $_SESSION['Alerta'] = 1;
      $id_Cam = $_POST["id_Cam"];
      $insertar2 = $db->query("UPDATE tblc_campus SET tblc_campus.Logo = '$archivo' WHERE tblc_campus.IdCampus = '$id_Cam' ");
      echo "<script type='text/javascript'>window.location='adAltas.php';</script>";
    }
  }

  # AGREGAR RESPUESTA PREGUNTA EXAMEN
  public function add_respuestaspreguntaExamen($IdExamen, $txtRespuesta1, $txtRespuesta2, $txtRespuesta3, $txtValor)
  {
    $db = new Conexion();
    if ($txtValor == 1) {
      $va1 = 1;
    } else {
      $va1 = 0;
    }
    if ($txtValor == 2) {
      $va2 = 1;
    } else {
      $va2 = 0;
    }
    if ($txtValor == 3) {
      $va3 = 1;
    } else {
      $va3 = 0;
    }
    $insertar = $db->query("INSERT INTO tblp_respuestaexamen (IdExamen, Respuesta, Valor) VALUES ('$IdExamen','$txtRespuesta1','$va1')");
    $insertar = $db->query("INSERT INTO tblp_respuestaexamen (IdExamen, Respuesta, Valor) VALUES ('$IdExamen','$txtRespuesta2','$va2')");
    if ($txtRespuesta3) {
      $insertar = $db->query("INSERT INTO tblp_respuestaexamen (IdExamen, Respuesta, Valor) VALUES ('$IdExamen','$txtRespuesta3','$va3')");
    }
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function get_configuracion()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_configuracion");
    while ($x = $db->recorrer($sql)) {
      $gConfigt[] = $x;
    }
    return $gConfigt;
  }

  public function get_datosFacturar($IdUsua)
  {
    $db = new Conexion();


    $sql = $db->query("SELECT tblc_datosfactura.IdDatosFacturacion, tblc_datosfactura.IdUsua, tblc_datosfactura.RFC, tblc_datosfactura.Razon, tblc_datosfactura.Domicilio, tblc_datosfactura.NoExterior, tblc_datosfactura.NoInterior, tblc_datosfactura.CP, tblc_datosfactura.Colonia, tblc_datosfactura.Municipio, tblc_datosfactura.Ciudad, tblc_datosfactura.Estado, tblc_datosfactura.Correo, tblc_datosfactura.CURP, tblc_datosfactura.FecCap, tblc_usocfdi.Clave, tblc_usocfdi.Descripcion FROM tblc_datosfactura Left Join tblc_usocfdi ON tblc_usocfdi.IdUso = tblc_datosfactura.IdUso  WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gdatFac[] = $x;
    }
    return $gdatFac;
  }

  public function get_usoCFDI()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usocfdi");
    while ($x = $db->recorrer($sql)) {
      $gusoCFDI[] = $x;
    }
    return $gusoCFDI;
  }

  public function get_regimenFiscal()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_regimen_fiscal");
    while ($x = $db->recorrer($sql)) {
      $get_regimenFiscal[] = $x;
    }
    return $get_regimenFiscal;
  }

  # OBTENER OFERTA EDUCATIVA (ACTIVA)
  public function get_OfertaE($IdPermiso, $IdOferta, $IdCampus)
  {
    $db = new Conexion();

    if ($IdCampus) {
      $conC = " AND tblp_educativa.IdCampus = '$IdCampus'";
    } else {
      $conC = "";
    }
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Estatus='Activo' $conC ORDER BY tblp_educativa.IdGrado ASC");
    while ($x = $db->recorrer($sql)) {
      $gOfertaE[] = $x;
    }
    return $gOfertaE;
  }

  public function get_calendarioId($IdCalendario)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_pagos.IdUsua, tblp_pagos.Monto, tblc_usuario.Nombre, tblc_usuario.Usuario, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_educativa.Nombre AS Educativa, tblc_conceptosplanes.NomPlan FROM tblp_pagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_pagos.IdCalendario = '$IdCalendario'");
    while ($x = $db->recorrer($sql)) {
      $gOCaledE[] = $x;
    }
    return $gOCaledE;
  }

  public function get_OfertaCoordinador($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_coordinador.IdCoordinador, tblp_educativa.IdEducativa, tblp_educativa.Clave, tblp_educativa.Tipo, tblp_educativa.Nombre, tblp_educativa.Modalidad, tblp_educativa.Duracion, tblp_educativa.Ciclo, tblp_educativa.Rvoe FROM tblp_coordinador Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta WHERE tblp_coordinador.IdEstatus =  '8' AND tblp_coordinador.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gOfertaCoord[] = $x;
    }
    return $gOfertaCoord;
  }

  public function get_planProy($IdPermiso, $IdUsua, $IdEstatus, $IdCampus)
  {
    if ($IdPermiso == 9) {
      $condf = " AND tblp_plan.IdUsua = '$IdUsua'";
    } else {
      $condf = " AND tblp_plan.IdCampus = '$IdCampus'";
    }
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_plan.IdPlan, tblp_plan.IdOferta, tblp_plan.Modalidad, tblp_plan.Dia, tblp_plan.IdEstatus, tblp_plan.FecAprob, tblp_educativa.Clave, tblp_educativa.Nombre, tblc_estatus.Estatus, tblc_campus.Campus, tblp_plan.Generacion, tblp_plan.FecCap, tblc_ciclo.Ciclo FROM tblp_plan Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_plan.IdOferta Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_plan.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_plan.IdEstatus Left Join tblc_campus ON tblc_campus.IdCampus = tblp_plan.IdCampus WHERE tblp_plan.IdEstatus = '$IdEstatus' $condf");
    while ($x = $db->recorrer($sql)) {
      $gPlanProy[] = $x;
    }
    return $gPlanProy;
  }

  public function get_planTemas($IdPlan)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_plantemas WHERE tblp_plantemas.IdPlan = '$IdPlan' ORDER BY tblp_plantemas.Cuatrimestre DESC");
    while ($x = $db->recorrer($sql)) {
      $gPlanProy[] = $x;
    }
    return $gPlanProy;
  }

  public function get_periodoEsc()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdEstatus = '8'");
    while ($x = $db->recorrer($sql)) {
      $gCicloEsc[] = $x;
    }
    return $gCicloEsc;
  }

  public function get_periodoTodos()
  {
    $db = new Conexion();
    $gCicloEsc = [];
    $sql = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.FInicio DESC ");
    while ($x = $db->recorrer($sql)) {
      $gCicloEsc[] = $x;
    }
    return $gCicloEsc;
  }

  public function get_periodo_materias_activas($IdUsua)
  {
    $db = new Conexion();
    $get_periodo_materias_activas = [];
    $sql = $db->query("SELECT
    tblp_asignacion.IdAsignacion,
    tblc_ciclo.Ciclo,
    tblp_asignacion.IdCiclo
    FROM
    tblp_asignacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    WHERE
    tblp_asignacion.IdUsua =  '$IdUsua' AND
    tblp_asignacion.Tipo =  '2' AND
    tblp_asignacion._alum IS NOT NULL 
    GROUP BY
    tblp_asignacion.IdCiclo
    ORDER BY
    tblc_ciclo.FInicio ASC
     ");
    while ($x = $db->recorrer($sql)) {
      $get_periodo_materias_activas[] = $x;
    }
    return $get_periodo_materias_activas;
  }

  public function get_cic_x_user($usuario)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblc_usuario.IdUsua, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.Usuario =  '$usuario'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $_t = $datos2["TipoCiclo"];

    if ($_t == 'C') {
      $Tipo = "Cuatrimestre";
    } else {
      $Tipo = "Semestre";
    }

    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo' ORDER BY tblc_ciclo.FInicio DESC");
    while ($x = $db->recorrer($sql)) {
      $get_cic_x_user[] = $x;
    }
    return $get_cic_x_user;
  }

  public function get_all_ciclos()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC ");
    while ($x = $db->recorrer($sql)) {
      $get_all_ciclos[] = $x;
    }
    return $get_all_ciclos;
  }

  public function get_all_ciclos_activos_2023()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '2023' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_all_ciclos_activos_2023[] = $x;
    }
    return $get_all_ciclos_activos_2023;
  }

  public function get_plan_estudios_all()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdGrado <= '5' ORDER BY tblp_educativa.IdGrado ASC");
    while ($x = $db->recorrer($sql)) {
      $get_plan_estudios_all[] = $x;
    }
    return $get_plan_estudios_all;
  }

  public function get_plan_estudios_lic()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdGrado = '3' ORDER BY tblp_educativa.Nombre ASC");
    while ($x = $db->recorrer($sql)) {
      $get_plan_estudios_lic[] = $x;
    }
    return $get_plan_estudios_lic;
  }

  public function get_alumnos_cal_prom() {
    $db = new Conexion();
    $get_alumnos_cal_prom = [];
    // $sqlx = $db->query("SELECT * FROM tblh_promedio");
    // while($x = $db->recorrer($sqlx)){
    //   $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Usuario = '".$x['Usuario']."'");
    //   $db->rows($sql9);
    //   $datos91 = $db->recorrer($sql9);
    //   $IdUser = $datos91["IdUsua"];
    //   if($IdUser){
    //     $insertar = $db->query("UPDATE tblh_promedio SET tblh_promedio.IdUsua = '$IdUser' WHERE tblh_promedio.Usuario = '".$x['Usuario']."'");
    //   }
    // }

    $sql = $db->query("SELECT
    tblh_promedio.IdProm,
    tblh_promedio.IdUsua,
    tblh_promedio.Nombre AS Alumno,
    tblh_promedio.Gral,
    tblh_promedio.Usuario,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno
    FROM
    tblh_promedio
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_promedio.IdUsua
    GROUP BY
    tblh_promedio.IdUsua
    ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_cal_prom[] = $x;
    }
    return $get_alumnos_cal_prom;
  }

  public function add_subir_cal_excel(){
    $carpeta = "assets/docs/Excel/Calificacion/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code.'.'.$ext;

    if(!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="2";
      echo "<script type='text/javascript'>window.location='subir_calificacion_excel.php';</script>";
      exit();
    }

    $link = $carpeta.$archivo;
    $db = new Conexion();

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';

     $IdCiclo = $_POST['txtCiclo'];
     $IdUsua = 0;
     $gi = 0; $gf = 0;

    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 1; $row <= $highestRow; $row++){
        $Promedio = $sheet->getCell("B".$row)->getValue(); 

        if($row == 1){
          $usuario = $sheet->getCell("B".$row)->getValue();
          $sql_us = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdCampus, tblc_usuario._idCampus, tblc_usuario._idOferta FROM tblc_usuario WHERE tblc_usuario.Usuario = '$usuario' ");
          $db->rows($sql_us);
          $_user = $db->recorrer($sql_us);
          $IdOferta = $_user['_idOferta'];
          $IdCampus = $_user['_idCampus'];
          $IdUsua = $_user['IdUsua'];
          if($IdCampus == 5){
                $IdCampus = $_user['IdCampus'];
            }

        } else {
        
        if(($IdUsua) && ($IdCampus)){
        if($Promedio){ $vx = 0; 
          $CodModulo = $sheet->getCell("A".$row)->getValue();
          $Promedio = $sheet->getCell("B".$row)->getValue();
          
            $sql_us = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Numero FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
            $db->rows($sql_us);
            $_user = $db->recorrer($sql_us);
            $_idCiclo = $_user['IdCiclo'];
            $_numero = $_user['Numero'];
            
            

            $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdCampus = '$IdCampus' AND tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.CodeModulo = '$CodModulo'");
            $db->rows($sql);
            $_mod = $db->recorrer($sql);
            $cod = $_mod['CodeModulo'];
            $idMod = $_mod['IdModulo'];
            $nombre = $_mod['NombreMod'];
            $gi = $_mod['Grado'];

            
            if($gi <> $gf){
              if($gf == 0){
                $_idCiclo = $_user['IdCiclo'];
                $IdCiclo = $_user['IdCiclo'];
              } else {
                $sql_us = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Tipo, tblc_ciclo.Numero FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$_idCiclo' ");
                $db->rows($sql_us);
                $_user = $db->recorrer($sql_us);
                $_idCiclo = $_user['IdCiclo'];
                $_numero = $_user['Numero'];
                $_tipo = $_user['Tipo'];

                $_numero = ($_numero + 1);

                $sql_usx = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Numero FROM tblc_ciclo WHERE tblc_ciclo.Numero = '$_numero' AND tblc_ciclo.Tipo = '$_tipo' ");
                $db->rows($sql_usx);
                $_user = $db->recorrer($sql_usx);
                $_idCiclo = $_user['IdCiclo'];
                $_numero = $_user['Numero'];

                $IdCiclo = $_user['IdCiclo'];
              }
            }
            
            $insertar = $db->query("INSERT INTO tblh_promedio (Usuario, IdModulo, CodeModulo, Promedio, Nombre, IdPeriodo, IdUsua)  VALUES ('$usuario','$idMod','$cod','$Promedio','$nombre','$IdCiclo','$IdUsua')");
            $gf = $_mod['Grado'];
        }
      }
      $Promedio ="";
    }
        
    }


    if ($insertar) {
      $_SESSION['Alerta']="5";
      echo "<script type='text/javascript'>window.location='subir_calificacion_excel.php';</script>";
    } else {
      $_SESSION['Alerta']="8";
      echo "<script type='text/javascript'>window.location='subir_calificacion_excel.php';</script>";
    }
  }


  public function get_all_practicas_prof()
  {
    $db = new Conexion();
    $get_all_practicas_prof = [];
    $sql = $db->query("SELECT * FROM tblc_periodo_ps WHERE tblc_periodo_ps.Tipo = 'P' ");
    while ($x = $db->recorrer($sql)) {
      $get_all_practicas_prof[] = $x;
    }
    return $get_all_practicas_prof;
  }

  public function get_all_servicio()
  {
    $db = new Conexion();
    $get_all_servicio = [];
    $sql = $db->query("SELECT * FROM tblc_periodo_ps WHERE tblc_periodo_ps.Tipo = 'S' ");
    while ($x = $db->recorrer($sql)) {
      $get_all_servicio[] = $x;
    }
    return $get_all_servicio;
  }

  public function get_lst_doc()
  {
    $db = new Conexion();
    $get_lst_doc = [];
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.Permisos = '2' ORDER BY tblc_usuario.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_doc[] = $x;
    }
    return $get_lst_doc;
  }

  public function get_user_grp_all($IdCampus, $IdCiclo)
  {
    $db = new Conexion();
    $get_user_grp_all = [];
    $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblp_educativa.Nombre FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblp_grupo.IdCicloIni =  '$IdCiclo' GROUP BY tblc_usuario.IdOferta ");
    while ($x = $db->recorrer($sql)) {
      $get_user_grp_all[] = $x;
    }
    return $get_user_grp_all;
  }

  public function get_catModulos($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblh_catmodulotem WHERE tblh_catmodulotem.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $code = $x["IdAsignatura"];
      $campus = $x["IdCampus"];
      // $porciones = explode("-", $IdAsig);
      // $code = $porciones[0]; // porción1
      // $campus = $porciones[1]; // porción1

      $code2 =  strlen($code);
      //$code = strlen($x["IdAsignatura"]);
      $IdTemp = $x["IdTemporal"];
      // if($code2 != 6){
      //   $insertar = $db->query("UPDATE tblh_catmodulotem SET tblh_catmodulotem.IdEstatus = '29' WHERE tblh_catmodulotem.IdTemporal = '$IdTemp' ");
      // }
      $insertar = $db->query("UPDATE tblh_catmodulotem SET tblh_catmodulotem.IdGrupo = '$campus' WHERE tblh_catmodulotem.IdTemporal = '$IdTemp' ");
    }

    $sql2 = $db->query("SELECT * FROM tblh_catmodulotem WHERE tblh_catmodulotem.IdEstatus =  '8' AND tblh_catmodulotem.IdUsua = '$IdUsua' GROUP BY tblh_catmodulotem.IdAsignatura");
    while ($m = $db->recorrer($sql2)) {
      $i = 0;
      //REPETIDO EN LISTA
      $codeG1 = $m["IdAsignatura"];
      $sql3 = $db->query("SELECT * FROM tblh_catmodulotem WHERE tblh_catmodulotem.IdAsignatura =  '$codeG1'");
      while ($n = $db->recorrer($sql3)) {
        $i = $i + 1;
        if ($i > 1) {
          $IdTempH6 = $n["IdTemporal"];

          $insertar = $db->query("UPDATE tblh_catmodulotem SET tblh_catmodulotem.IdEstatus = '28' WHERE tblh_catmodulotem.IdTemporal = '$IdTempH6' ");
        }
      }
    }

    $gCatModTx = [];
    $sql = $db->query("SELECT tblh_catmodulotem.IdTemporal, tblh_catmodulotem.Grupo, tblh_catmodulotem.IdAsignatura, tblh_catmodulotem.Asignatura, tblh_catmodulotem.IdEstatus, tblh_catmodulotem.IdCampus, tblh_catmodulotem.IdOferta, tblh_catmodulotem.HraDoc, tblh_catmodulotem.HraInd, tblc_estatus.Estatus, tblc_campus.Campus, tblp_educativa.Nombre FROM tblh_catmodulotem Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_catmodulotem.IdEstatus Left Join tblc_campus ON tblc_campus.IdCampus = tblh_catmodulotem.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblh_catmodulotem.IdOferta WHERE tblh_catmodulotem.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gCatModTx[] = $x;
    }
    return $gCatModTx;
  }

  public function get_catSaldo($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblh_saldo WHERE tblh_saldo.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $usuario = $x["Matricula"];
      $IdTemp = $x["IdSaldo"];

      $sql1 = $db->query("SELECT tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblc_usuario.IdUsua, tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.Usuario = '$usuario'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
       $IdUser = $datos2["IdUsua"];
      $User = $datos2["Usuario"];
      $IdOferta = $datos2["IdOferta"];
      $IdCampus = $datos2["IdCampus"];

      if ($IdUser) {
        $insertar = $db->query("UPDATE tblh_saldo SET tblh_saldo.IdCampus = '$IdCampus', tblh_saldo.IdOferta = '$IdOferta', tblh_saldo.IdAlumno = '$IdUser' WHERE tblh_saldo.IdSaldo = '$IdTemp' ");
      } else {
        $insertar = $db->query("UPDATE tblh_saldo SET tblh_saldo.IdEstatus = '29' WHERE tblh_saldo.IdSaldo = '$IdTemp' ");
      }
    }

    $get_catSaldo = [];
    
    $sql = $db->query("SELECT tblh_saldo.IdSaldo, tblh_saldo.Matricula, tblh_saldo.Deuda, tblh_saldo.Fecha, tblh_saldo.Descripcion, tblh_saldo.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_campus.Campus, tblc_estatus.Estatus, tblp_educativa.Nombre AS NomEducativa FROM tblh_saldo Left Join tblc_usuario ON tblc_usuario.Usuario = tblh_saldo.Matricula Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_saldo.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblh_saldo.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_catSaldo[] = $x;
    }
    return $get_catSaldo;
  }

  public function get_catBusMod($CodeModulo)
  {
    $db = new Conexion();
    $get_catBusMod = [];

    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.CodeModulo = '$CodeModulo' ");
    while ($x = $db->recorrer($sql)) {
      $get_catBusMod[] = $x;
    }
    return $get_catBusMod;
  }

  public function get_catBusModAsig($IdModulo, $IdEducativa, $IdGrupo)
  {
    $db = new Conexion();
    $get_catBusModAsig = [];
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEstatus FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdEducativa = '$IdEducativa' AND tblp_asignacion.IdModulo = '$IdModulo' AND tblp_asignacion.IdGrupo = '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $get_catBusModAsig[] = $x;
    }
    return $get_catBusModAsig;
  }

  public function get_busActOfer($IdGrupo, $IdUsua, $IdCampus)
  {
    $db = new Conexion();

    $sql7 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdOferta = $datos71["IdOferta"];
    
    $sql = $db->query("SELECT * FROM tblp_coordinador WHERE tblp_coordinador.IdUsua = '$IdUsua' AND tblp_coordinador.IdOferta ='$IdOferta' AND tblp_coordinador.IdCampus ='$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $gOfertUX[] = $x;
    }
    return $gOfertUX;
  }

  public function get_updcatBusModId($IdTemporal, $IdEstatus)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblh_catmodulotem SET tblh_catmodulotem.IdEstatus = '$IdEstatus' WHERE tblh_catmodulotem.IdTemporal = '$IdTemporal' ");
  }

  public function get_revisarParcial($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_coordinador.IdOferta, tblp_parcialdocente.IdAsignacion, tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.NoParcial, tblp_educativa.Nombre, tblp_modulo.IdModulo, tblp_modulo.NombreMod, tblc_usuario.Nombre AS Asesor, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdUsua FROM tblp_coordinador Right Join tblp_parcialdocente ON tblp_parcialdocente.IdOferta = tblp_coordinador.IdOferta Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_parcialdocente.IdOferta Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_parcialdocente.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_parcialdocente.IdUsua WHERE tblp_coordinador.IdUsua =  '$IdUsua' AND tblp_parcialdocente.NoParcial =  '1' AND tblp_coordinador.IdEstatus =  '8' AND tblp_parcialdocente.IdEstatus <>  '4' ");
    while ($x = $db->recorrer($sql)) {
      $gRevParcial[] = $x;
    }
    return $gRevParcial;
  }

  public function get_revParcial($IdCiclo, $IdOferta)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_asignacion.IdEstatus, tblp_asignacion.Plantel, tblp_asignacion.Salon, tblp_asignacion.HraDia, tblp_asignacion.HraSemana, tblp_asignacion.HraDoc, tblp_asignacion.HraInd, tblc_estatus.Estatus, tblp_asignacion.IdEducativa, tblp_grupo.CveGrupo, tblp_grupo.Grupo, tblp_educativa.Nombre AS NomEducativa, tblp_educativa.Rvoe, tblp_modulo.NombreMod, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_asignacion Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdEducativa = '$IdOferta' AND tblp_asignacion.IdCiclo = '$IdCiclo'");
    while ($x = $db->recorrer($sql)) {
      $gtParcial[] = $x;
    }
    return $gtParcial;
  }

  public function get_revModulo($IdCiclo, $IdGrupo)
  {
    if (($IdCiclo) && ($IdGrupo)) {
      $db = new Conexion();
      $get_revModulo = [];
      $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_asignacion.IdEstatus, tblp_asignacion.IdEducativa, tblp_grupo.CveGrupo, tblp_modulo.NombreMod, tblp_modulo.CodeModulo, tblp_planeacion.IdPlaneacion, tblp_planeacion.IdUsua, tblp_planeacion.Planeacion, tblp_planeacion.FecAprobado, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tabAsesor.Nombre AS AsNombre, tabAsesor.APaterno AS AsPaterno, tabAsesor.AMaterno AS AsMaterno,  tblp_planeacion.IdEstatus AS IdEstatusPlan FROM tblp_asignacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_planeacion ON tblp_planeacion.IdAsignacion = tblp_asignacion.IdAsignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_planeacion.IdUsuaAprob Left Join tblc_usuario AS tabAsesor ON tabAsesor.IdUsua = tblp_planeacion.IdUsua WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' ");
      while ($x = $db->recorrer($sql)) {
        $get_revModulo[] = $x;
      }
      return $get_revModulo;
    }
  }

  public function get_encuestaDR($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();
    $gEncuestaR = [];
    $sql = $db->query("SELECT tblc_encuesta.IdEncuesta, tblc_encuesta.IdAsignacion, tblc_encuesta.IdUsua, tblc_encuesta.IdPregunta, tblc_encuesta.Respuesta, tblc_encuesta.Estatus FROM tblc_encuesta WHERE tblc_encuesta.IdAsignacion =  '$IdAsignacion' AND tblc_encuesta.IdUsua =  '$IdUsua' GROUP BY tblc_encuesta.Estatus");
    while ($x = $db->recorrer($sql)) {
      $gEncuestaR[] = $x;
    }
    return $gEncuestaR;
  }

  # OBTENER LA CLAVE DEL GRUPO
  public function get_claveGrupo()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Estatus ='Activo'");
    while ($x = $db->recorrer($sql)) {
      $gClaveGrupo[] = $x;
    }
    return $gClaveGrupo;
  }

  # OBTENER LA CLAVE DEL GRUPO DADO DE ALTA EN EL GRUPO
  public function get_claveGrupoXA($IdCiclo)
  {
    $db = new Conexion();
    $gClaveGrupoA = [];


    $sql = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, tblc_ciclogrupo.IdCiclo, tblc_ciclogrupo.IdGrupo, tblc_ciclogrupo.Grado, tblp_grupo.CveGrupo,  tblp_grupo.Nivel, tblp_grupo.IdCampus, tblp_grupo.Grupo, tblc_dias_clases._Dias, tblc_campus._campus, tblc_campus.Campus, tblp_educativa.Abreviatura FROM tblc_ciclogrupo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblp_grupo.IdEstatus = '8' ORDER BY tblc_campus.IdCampus ASC, tblp_grupo.Grado ASC");
    while ($x = $db->recorrer($sql)) {
      $gClaveGrupoA[] = $x;
    }
    return $gClaveGrupoA;
  }

  public function get_gradoHo($IdGrupo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_modulo.Grado FROM tblp_grupo Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.IdCampus WHERE tblp_grupo.IdGrupo =  '$IdGrupo' GROUP BY tblp_modulo.Grado ");
    while ($x = $db->recorrer($sql)) {
      $gGstA[] = $x;
    }
    return $gGstA;
  }

  public function get_gradoHorario($IdGrupo, $IdCiclo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblk_materias.IdMateria, tblk_materias.Grado, tblk_materias.IdCampus, tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblk_materias Left Join tblp_modulo ON tblp_modulo.IdModulo = tblk_materias.IdModulo WHERE tblk_materias.IdCiclo =  '$IdCiclo' AND tblk_materias.IdGrupo =  '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $gGstAHG[] = $x;
    }
    return $gGstAHG;
  }

  public function get_CicloEscolar()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Estatus = 'Vigente'");
    while ($x = $db->recorrer($sql)) {
      $gCicloEs[] = $x;
    }
    return $gCicloEs;
  }

  public function get_ofertaCic($IdCiclo)
  {
    $db = new Conexion();
    $gCicloEsDWS = [];
    $sql = $db->query("SELECT tblp_educativa.Nombre, tblp_evaluacion.IdEvaluacion, tblp_educativa.IdEducativa FROM tblp_evaluacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_evaluacion.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_evaluacion.IdCiclo = '$IdCiclo' GROUP BY tblp_grupo.IdOferta ORDER BY tblp_educativa.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $gCicloEsDWS[] = $x;
    }
    return $gCicloEsDWS;
  }

  public function get_campusCic($IdCiclo, $IdOferta)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_grupo.IdCampus, tblc_campus.Campus FROM tblp_evaluacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_evaluacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus WHERE tblp_evaluacion.IdCiclo =  '$IdCiclo' AND tblp_grupo.IdOferta =  '$IdOferta' GROUP BY tblp_grupo.IdCampus");
    while ($x = $db->recorrer($sql)) {
      $gCapsWS[] = $x;
    }
    return $gCapsWS;
  }

  public function get_grpCic($IdCiclo, $IdOferta)
  {
    $db = new Conexion();
    $gDRPEsDWS = [];
    $sql = $db->query("SELECT tblp_evaluacion.IdEvaluacion, tblp_evaluacion.IdCiclo, tblp_evaluacion.IdGrupo, tblp_evaluacion.Valor, tblp_evaluacion.FecIni, tblp_evaluacion.FecFin, tblp_grupo.CveGrupo, tblc_campus.Campus, tblp_educativa.Nombre FROM tblp_evaluacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_evaluacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_evaluacion.IdCiclo = '$IdCiclo' AND tblp_grupo.IdOferta = '$IdOferta' ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.CveGrupo ASC ");
    while ($x = $db->recorrer($sql)) {
      $gDRPEsDWS[] = $x;
    }
    return $gDRPEsDWS;
  }

  public function get_grpCicId($IdCiclo, $IdOferta, $IdTipoEvaluacion)
  {
    $db = new Conexion();
    if ($IdTipoEvaluacion) {
      $get_grpCicId = [];

      $sql = $db->query("SELECT
  tblp_evaluacion.IdEvaluacion,
  tblp_evaluacion.IdCiclo,
  tblp_evaluacion.IdGrupo,
  tblp_evaluacion.Valor,
  tblp_evaluacion.FecIni,
  tblp_evaluacion.FecFin,
  tblp_evaluacion.Valor_1,
  tblp_evaluacion.FecIni_1,
  tblp_evaluacion.FecFin_1,
  tblp_evaluacion.Valor_2,
  tblp_evaluacion.FecIni_2,
  tblp_evaluacion.FecFin_2,
  tblp_evaluacion.Valor_3,
  tblp_evaluacion.FecIni_3,
  tblp_evaluacion.FecFin_3,
  tblp_evaluacion.Valor_4,
  tblp_evaluacion.FecIni_4,
  tblp_evaluacion.FecFin_4,
  tblp_evaluacion.Valor_5, tblp_evaluacion.FecIni_5, tblp_evaluacion.FecFin_5, tblp_evaluacion.Valor_6, tblp_evaluacion.FecIni_6, tblp_evaluacion.FecFin_6, tblp_grupo.CveGrupo, tblc_campus.Campus, tblp_educativa.Nombre FROM tblp_evaluacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_evaluacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_evaluacion.IdCiclo = '$IdCiclo' AND tblp_grupo.IdOferta = '$IdOferta' ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.CveGrupo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_grpCicId[] = $x;
      }
      return $get_grpCicId;
    }
  }

  public function get_grplstDocs($IdCiclo, $IdOferta, $IdCampus)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdUsua, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_asignacion.IdGrupo, tblp_grupo.CveGrupo FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdEducativa =  '$IdOferta' AND tblp_asignacion.IdCampus =  '$IdCampus' AND tblp_asignacion.Tipo =  '2' ORDER BY tblp_modulo.CodeModulo ");
    while ($x = $db->recorrer($sql)) {
      $gDRPEdssDWS[] = $x;
    }
    return $gDRPEdssDWS;
  }

  public function get_allCiclos($IdOferta)
  {
    $db = new Conexion();
    $sql7 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $Tipo = $datos71["Ciclo"];
    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo'");
    while ($x = $db->recorrer($sql)) {
      $gCicloEsAll[] = $x;
    }
    return $gCicloEsAll;
  }

  public function get_claveGrupoA()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Tipo = 'Cerrado' AND tblp_grupo.Estatus ='Activo'");
    while ($x = $db->recorrer($sql)) {
      $gClaveGrupodA[] = $x;
    }
    return $gClaveGrupodA;
  }

  public function get_claveGCa($IdCampus)
  {
    $db = new Conexion();
    $get_claveGCa = [];
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $get_claveGCa[] = $x;
    }
    return $get_claveGCa;
  }

  public function get_clvGrupS($IdCampus)
  {
    $db = new Conexion();
    $get_clvGrupS = [];
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Tipo = 'Cerrado' AND tblp_grupo.Estatus ='Activo' AND tblp_grupo.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $get_clvGrupS[] = $x;
    }
    return $get_clvGrupS;
  }

  public function get_clvGrupSTodos($IdCampus)
  {
    $db = new Conexion();
    $get_clvGrupSTodos = [];
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' ORDER BY tblp_grupo.Grado ASC");
    while ($x = $db->recorrer($sql)) {
      $get_clvGrupSTodos[] = $x;
    }
    return $get_clvGrupSTodos;
  }

  # OBTENER OFERTA EDUCATIVA (TODOS)
  public function get_OfertaETodos($IdPermiso, $IdOferta, $IdCampus)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Estatus = 'Activo' ORDER BY tblp_educativa.IdGrado ASC");
    while ($x = $db->recorrer($sql)) {
      $gOfertaET[] = $x;
    }
    return $gOfertaET;
  }

  public function get_misOfertas()
  {
    $db = new Conexion();
    $get_misOfertas = [];
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Estatus = 'Activo' ORDER BY tblp_educativa.IdGrado ASC");
    while ($x = $db->recorrer($sql)) {
      $get_misOfertas[] = $x;
    }
    return $get_misOfertas;
  }

  public function get_mis_ofertas_per($IdCampus, $IdUsua)
  {
    $db = new Conexion();
    $get_mis_ofertas_per = [];
    $sql = $db->query("SELECT tblp_coordinador.IdCampus, tblp_coordinador.IdOferta, tblp_educativa.IdEducativa, tblp_educativa.Nombre, tblp_educativa.Clave FROM tblp_coordinador Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta WHERE tblp_coordinador.IdUsua =  '$IdUsua' AND tblp_coordinador.IdCampus =  '$IdCampus' GROUP BY tblp_coordinador.IdOferta ");
    while ($x = $db->recorrer($sql)) {
      $get_mis_ofertas_per[] = $x;
    }
    return $get_mis_ofertas_per;
  }

  public function get_ofertNb($IdPermiso, $IdUsua)
  {
    $db = new Conexion();
    $get_ofertNb = [];

    $sql = $db->query("SELECT tblp_coordinador.IdCampus, tblp_coordinador.IdOferta, tblc_campus.Campus, tblp_educativa.IdEducativa, tblp_educativa.Nombre, tblc_grado.Descripcion, tblp_educativa.Clave FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCoordinador ");
    while ($x = $db->recorrer($sql)) {
      $get_ofertNb[] = $x;
    }
    return $get_ofertNb;
  }

  public function get_lstAsign($IdCampus, $IdOferta)
  {
    $db = new Conexion();
    $get_lstAsign = [];

    $sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdCampus = '$IdCampus' AND tblp_modulo.IdEducativa = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $get_lstAsign[] = $x;
    }
    return $get_lstAsign;
  }

  public function get_cursosLts()
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Estatus = 'Activo' AND tblp_educativa.IdGrado = '5'");
    while ($x = $db->recorrer($sql)) {
      $gOfertaET[] = $x;
    }
    return $gOfertaET;
  }

  public function get_gradoEs()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_grado");
    while ($x = $db->recorrer($sql)) {
      $gGradosET[] = $x;
    }
    return $gGradosET;
  }

  public function get_lstCoord()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '9' AND tblc_usuario.IdEstatus = '8'");
    while ($x = $db->recorrer($sql)) {
      $gLstCoord[] = $x;
    }
    return $gLstCoord;
  }

  public function get_lstOferta($IdCampus)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_educativa.IdEducativa, tblp_educativa.Tipo, tblp_educativa.Nombre, tblp_educativa.Modalidad, tblp_educativa.Ciclo, tblp_educativa.Duracion, tblp_educativa.Rvoe, tblc_campus.Campus FROM tblp_educativa Left Join tblc_campus ON tblc_campus.IdCampus = tblp_educativa.IdCampus WHERE tblp_educativa.Estatus = 'Activo' ");
    while ($x = $db->recorrer($sql)) {
      $gLstOfertC[] = $x;
    }
    return $gLstOfertC;
  }

  public function get_lstOfSer($IdCampus)
  {
    $db = new Conexion();
    $gLstOfertCd = [];
    $sql = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa ORDER BY tblp_educativa.Nombre ASC");
    while ($x = $db->recorrer($sql)) {
      $gLstOfertCd[] = $x;
    }
    return $gLstOfertCd;
  }

  public function get_verificar($IdEducativa, $IdCampus, $Matricula)
  {
    $db = new Conexion();
    $gserf = [];
    $sql = $db->query("SELECT * FROM tblc_seriacion WHERE tblc_seriacion.Matricula = '$Matricula' AND tblc_seriacion.IdCampus = '$IdCampus' AND tblc_seriacion.IdOferta = '$IdEducativa'");
    while ($x = $db->recorrer($sql)) {
      $gserf[] = $x;
    }
    return $gserf;
  }


  public function get_lstOTodos()
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Estatus = 'Activo' ORDER BY tblp_educativa.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $gLstOfertC[] = $x;
    }
    return $gLstOfertC;
  }

  public function get_lstPfertaLs($IdCampus)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa ORDER BY tblp_educativa.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $gLstOfertC[] = $x;
    }
    return $gLstOfertC;
  }

  public function get_lstoFERTACampus($IdCampus)
  {
    $db = new Conexion();
    $get_lstoFERTACampus = [];
    $sql = $db->query("SELECT tblp_modulo.IdEducativa, tblp_modulo.IdModulo, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus = '$IdCampus' GROUP BY tblp_modulo.IdEducativa");
    while ($x = $db->recorrer($sql)) {
      $get_lstoFERTACampus[] = $x;
    }
    return $get_lstoFERTACampus;
  }

  public function get_mis_ofertas($IdUsua)
  {
    $db = new Conexion();
    $get_mis_ofertas = [];
    $sql = $db->query("SELECT tblp_coordinador.IdCoordinador, tblp_educativa.Nombre, tblp_coordinador.IdOferta FROM tblp_coordinador Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta WHERE tblp_coordinador.IdUsua =  '$IdUsua' ORDER BY tblp_educativa.IdGrado ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_mis_ofertas[] = $x;
    }
    return $get_mis_ofertas;
  }

  public function get_lstoFEst4s($IdCampus, $IdUsua)
  {
    $db = new Conexion();
    $get_lstoFEst4s = [];
    $sql = $db->query("SELECT tblp_coordinador.IdOferta, tblp_educativa.Nombre FROM tblp_coordinador Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta WHERE tblp_coordinador.IdUsua =  '$IdUsua' AND tblp_coordinador.IdCampus = '$IdCampus' ORDER BY tblp_educativa.IdGrado DESC, tblp_educativa.Nombre ASC");
    while ($x = $db->recorrer($sql)) {
      $get_lstoFEst4s[] = $x;
    }
    return $get_lstoFEst4s;
  }



  public function get_lstalumnosPro($IdCampus, $IdOferta, $IdGrupo)
  {
    $db = new Conexion();
    if (($IdCampus) && ($IdOferta)) {
      if ($IdOferta) {
        $cond = " AND tblc_usuario.IdOferta = '$IdOferta'";
      } else {
        $cond = "";
      }
      if ($IdGrupo) {
        $conG = " AND tblc_usuario.IdGrupo = '$IdGrupo'";
      } else {
        $conG = "";
      }
      $gLsstCs = [];
      $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_campus.Campus,
tblp_educativa.Nombre AS Oferta,
tblc_usuario.Usuario,
tblp_grupo.CveGrupo
FROM
tblc_usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE tblc_usuario.IdCampus = '$IdCampus' $cond $conG");
      while ($x = $db->recorrer($sql)) {
        $gLsstCs[] = $x;
      }
      return $gLsstCs;
    }
  }

  public function get_lstProspectos($IdUsua, $IdPermiso, $IdOferta)
  {
    $db = new Conexion();

    if ($IdOferta == 100) {
      $_oferta = "";
    } else {
      $_oferta = " tblc_usuario.IdOferta =  '$IdOferta' AND ";
    }


    $get_lstProspectos = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdCampus,
tblc_usuario.Folio,
tblc_usuario.id_ciclo_ini,
tblc_usuario.FecAlta,
tblc_usuario.NoDoc,
tblc_usuario.id_paquete,
tblc_usuario.IdOferta,
tblp_educativa.IdGrado,
tblp_educativa.Nombre AS Educativa,
tblc_usuario.Semblanza,
tblc_campus.Campus,
tblc_usuario.FecCap,
tblp_informacion.Asesor,
tblc_ciclo.Ciclo
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_usuario.id_ciclo_ini
WHERE $_oferta
tblc_usuario.IdEstatus =  '12' ");
    while ($x = $db->recorrer($sql)) {
      $get_lstProspectos[] = $x;
    }
    return $get_lstProspectos;
  }

  public function get_lstUsers($IdPermiso)
  {
    $db = new Conexion();

    // $sql_asig = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.Tipo= '2' AND tblp_asignacion.Curso= '0' ");
    // while($asig = $db->recorrer($sql_asig)){
    //   $sqly = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdOferta= '".$asig['IdEducativa']."' AND tblc_usuario.IdGrupo= '".$asig['IdGrupo']."' ");
    //
    //   while($z = $db->recorrer($sqly)){
    //     $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('".$asig['IdEducativa']."','".$asig['IdModulo']."','".$asig['Grupo']."','".$z["IdUsua"]."','".$asig['Estatus']."',NOW(),'".$asig['IdAsignacion']."','".$asig['IdGrupo']."')");
    //     // $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$semcua'  WHERE tblc_usuario.IdUsua = '".$z["IdUsua"]."'");
    //   }
    //
    // }

    $get_lstUsers = [];
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '$IdPermiso' AND tblc_usuario.IdEstatus = '8' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");
    while ($x = $db->recorrer($sql)) {
      $get_lstUsers[] = $x;
    }
    return $get_lstUsers;
  }

  public function get_lstCampusAc()
  {
    $db = new Conexion();
    $gCampusLst = [];
    $sql = $db->query("SELECT * FROM tblc_campus");
    while ($x = $db->recorrer($sql)) {
      $gCampusLst[] = $x;
    }
    return $gCampusLst;
  }
  public function get_ingresos_anio($Anio, $IdCampus)
  {
    $db = new Conexion();
    $get_ingresos_anio = [];
    $sql = $db->query("SELECT Sum(tblp_foliospago.Monto) AS ingresosMes, tblc_mes.IdMes, tblc_mes.Mes FROM tblp_foliospago Left Join tblc_mes ON tblc_mes.IdMes = tblp_foliospago.Mes WHERE tblp_foliospago.Anio = '$Anio' AND tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.IdCampus = '$IdCampus' GROUP BY tblp_foliospago.Mes ");
    while ($x = $db->recorrer($sql)) {
      $get_ingresos_anio[] = $x;
    }
    return $get_ingresos_anio;
  }

  public function get_ingresos_oferta($Anio, $IdCampus, $IdMes)
  {
    $db = new Conexion();
    $get_ingresos_oferta = [];

    $sql = $db->query("SELECT tblp_foliospago.IdOferta, Sum(tblp_foliospago.Monto) AS Total, tblp_educativa.Nombre FROM tblp_foliospago Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_foliospago.IdOferta WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.IdCampus =  '$IdCampus' AND tblp_foliospago.Anio =  '$Anio' AND tblp_foliospago.Mes =  '$IdMes' GROUP BY tblp_foliospago.IdOferta ");
    while ($x = $db->recorrer($sql)) {
      $get_ingresos_oferta[] = $x;
    }
    return $get_ingresos_oferta;
  }

  public function get_ingresos_forma($Anio, $IdCampus, $IdMes)
  {
    $db = new Conexion();
    $get_ingresos_forma = [];
    $sql = $db->query("SELECT Sum(tblp_foliospago.Monto) AS sumTotal, tblc_formapago.Descripcion FROM tblp_foliospago Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.IdCampus =  '$IdCampus' AND tblp_foliospago.Anio =  '$Anio' AND tblp_foliospago.Mes =  '$IdMes' GROUP BY tblc_formapago.Descripcion ");
    while ($x = $db->recorrer($sql)) {
      $get_ingresos_forma[] = $x;
    }
    return $get_ingresos_forma;
  }

  public function get_ingresos_dias($Anio, $IdCampus, $IdMes)
  {
    $db = new Conexion();
    $get_ingresos_dias = [];
    $sql = $db->query("SELECT
Sum(tblp_foliospago.Monto) AS totalDia,
tblp_foliospago.FecPago
FROM
tblp_foliospago
WHERE
tblp_foliospago.IdEstatus = '4' AND
tblp_foliospago.IdCampus =  '$IdCampus' AND
tblp_foliospago.Anio =  '$Anio' AND
tblp_foliospago.Mes =  '$IdMes'
GROUP BY
tblp_foliospago.FecPago
 ");
    while ($x = $db->recorrer($sql)) {
      $get_ingresos_dias[] = $x;
    }
    return $get_ingresos_dias;
  }

  public function get_lstCampusAc2($IdPermiso, $IdUsua)
  {
    $db = new Conexion();
    $gCampusLst = [];

    $sql = $db->query("SELECT tblp_coordinador.IdCampus, tblc_campus.IdEstatus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus ");
    while ($x = $db->recorrer($sql)) {
      $gCampusLst[] = $x;
    }
    return $gCampusLst;
  }

  public function get_userDoc($IdCampus, $IdUsua)
  {
    $db = new Conexion();
    $get_userDoc = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.Correo,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa,
tblc_estatus.Estatus
FROM
tblc_usuario
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.id_usua = '$IdUsua' AND tblc_usuario.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $get_userDoc[] = $x;
    }
    return $get_userDoc;
  }

  public function get_lstCampusN()
  {
    $db = new Conexion();
    $gCampusLst = [];
    
   #VALIDAMOS QUE EXISTA EL PAGO DE REINSCRICPION
    //$sql_all = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdCiclo =  '61' GROUP BY tblp_pagos.IdUsua ");
    //while($all = $db->recorrer($sql_all)){
      
            
        #Verificamos si existe el concepto
      //  $pag_vaca = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdCiclo =  '61' AND tblp_pagos.IdUsua = '".$all['IdUsua']."' AND ((tblp_pagos.IdConcepto = 1) || (tblp_pagos.IdConcepto = 3)) ");
    //    $db->rows($pag_vaca);
     //   $pago_vaca = $db->recorrer($pag_vaca);    
      //  if(!isset($pago_vaca['IdPago'])){
         // echo "-".$all['IdUsua'];
          //echo "UPDATE tblp_beca SET tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$Descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$Porcentaje',  tblp_beca.Grado = '25' WHERE tblp_beca.IdBeca = '".$all['IdBeca']."' "; die();
          //$insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$Descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$Porcentaje',  tblp_beca.Grado = '25' WHERE tblp_beca.IdBeca = '".$all['IdBeca']."' ");
        //}
    //}
    
    
    #VALIDAMOS LA BECA DEL PERIODO ANTERIOR
    //$sql_all = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdCiclo = '61' AND tblp_beca.Porcentaje = '0' ");
    //while($all = $db->recorrer($sql_all)){
      //$IdUsua = $all['IdUsua'];
      //$IdConcepto = $all['IdConcepto'];
            
        #Verificamos la beca anterior
        //$pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$IdConcepto' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '54' ");
        //$db->rows($pag_vaca);
        //$pago_vaca = $db->recorrer($pag_vaca);    
        //if(isset($pago_vaca['Porcentaje'])){
         // $Total = $pago_vaca['Total'];
        //  $Descuento = $pago_vaca['Descuento'];
       //   $Porcentaje = $pago_vaca['Porcentaje'];
          //echo "UPDATE tblp_beca SET tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$Descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$Porcentaje',  tblp_beca.Grado = '25' WHERE tblp_beca.IdBeca = '".$all['IdBeca']."' "; die();
          //$insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '8', tblp_beca.Descuento = '$Descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$Porcentaje',  tblp_beca.Grado = '25' WHERE tblp_beca.IdBeca = '".$all['IdBeca']."' ");
     //   }
   // }
    
    
//     echo "SELECT tblc_alumnos.IdActivo, tblc_alumnos.Grado, tblc_usuario.Sexo, tblc_alumnos.IdUsua FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_alumnos.IdCiclo =  '51' AND tblc_alumnos.Grado =  '2' AND tblp_educativa.IdGrado =  '3' ";
// die();
//     $sql = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Grado, tblc_usuario.Sexo, tblc_alumnos.IdUsua FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_alumnos.IdCiclo =  '51' AND tblc_alumnos.Grado =  '2' AND tblp_educativa.IdGrado =  '3' ");
//     while($x = $db->recorrer($sql)){
//         $sql_monto = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '".$x['IdUsua']."' AND tblp_pagos.IdCiclo = '16' AND tblp_pagos.IdConcepto = '1' ");
//         $db->rows($sql_monto);
//         $datos_monto = $db->recorrer($sql_monto);
//         $_pagado = $datos_monto["TotalPagado"];
//         if($_pagado >= 1000){
//           $descuento = $datos_monto["Descuento"];

//           $pago_actual = $datos_monto['Monto'];
          
//           $_porx = $_pagado / $pago_actual;
//           $_col = ($_porx * 100);
//           $cal1 = (100 - $_col);
//           $porcentaje = intval($cal1);

//           $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$_pagado', tblp_beca.Porcentaje = '$porcentaje' AND  tblp_beca.Grado = '2' WHERE tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '51' AND tblp_beca.IdUsua = '".$x['IdUsua']."' ");
//         }       
//     }



//     $sql = $db->query("SELECT
//     tblc_alumnos.IdActivo,
//     tblc_alumnos.Grado,
//     tblc_usuario.Sexo,
//     tblc_alumnos.IdUsua
//     FROM
//     tblc_alumnos
//     Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
//     Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
//     WHERE
//     tblc_alumnos.IdCiclo =  '51' AND
//     tblc_alumnos.Grado =  '2' AND
//     tblp_educativa.IdGrado =  '3'
//     ");
    
//     while($x = $db->recorrer($sql)){
      
        
//         $sql_monto = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '".$x['IdUsua']."' AND tblp_pagos.IdCiclo = '16' AND tblp_pagos.IdConcepto = '1' ");
//         $db->rows($sql_monto);
//         $datos_monto = $db->recorrer($sql_monto);
//         $_pagado = $datos_monto["TotalPagado"];
//         if($_pagado >= 1000){
//           $descuento = $datos_monto["Descuento"];

//           $pago_actual = $datos_monto['Monto'];
          
//           $_porx = $_pagado / $pago_actual;
//           $_col = ($_porx * 100);
//           $cal1 = (100 - $_col);
//           $porcentaje = intval($cal1);
// echo "UPDATE tblp_beca SET tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$_pagado', tblp_beca.Porcentaje = '$porcentaje' AND  tblp_beca.Grado = '2' WHERE tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '51' AND tblp_beca.IdUsua = '".$x['IdUsua']."' "; 
// die();
//           $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$_pagado', tblp_beca.Porcentaje = '$porcentaje' AND  tblp_beca.Grado = '2' WHERE tblp_beca.IdConcepto = '3' AND tblp_beca.IdCiclo = '51' AND tblp_beca.IdUsua = '".$x['IdUsua']."' ");
//           die('stop');
//         }       
//     }
//  die('aqui');


$v = 0;

     $sql_pag = $db->query("SELECT
 tblp_pagos.IdPago,
 tblp_pagos.IdUsua,
 tblp_pagos.IdCiclo,
 tblc_usuario.IdEstatus,
 tblc_usuario._horario,
 tblc_usuario.IdGrupo,
 tblp_grupo.Dia,
 tblc_ciclogrupo.Grado
 FROM
 tblp_pagos
 Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
 Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
 Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_pagos.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_pagos.IdGrupo
 WHERE
 tblp_pagos.IdCiclo =  '700'
 GROUP BY
 tblp_pagos.IdUsua
 ORDER BY
 tblc_usuario.IdEstatus ASC
 ");
     while ($x = $db->recorrer($sql_pag)) {
         if($x['IdEstatus'] <> 12){
        
             $sql_us = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '".$x['IdUsua']."' AND tblc_alumnos.IdGrupo = '".$x['IdGrupo']."' AND tblc_alumnos.IdCiclo = '".$x['IdCiclo']."' ");
             $db->rows($sql_us);
             $user = $db->recorrer($sql_us);
             
             if(!isset($user['IdActivo'])){
                echo $v++.'->'.$x['IdUsua'];
                echo "<br>";
                $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario) VALUES('".$x['IdGrupo']."','".$x['IdCiclo']."','".$x['IdUsua']."','".$x['Grado']."','R','".$x['IdEstatus']."',NOW(),1,'".$x['_horario']."')"); 
             }    
         }
     }

 


    $sql = $db->query("SELECT * FROM tblc_campus");
    while ($x = $db->recorrer($sql)) {
      $gCampusLst[] = $x;
    }
    return $gCampusLst;
  }

  public function get_lst_calendario_esc()
  {
    $db = new Conexion();
    $get_lst_calendario_esc = [];
    $sql = $db->query("SELECT tble_calendario.IdCalendario, tble_calendario.IdCiclo, tble_calendario.Nombre, tblc_ciclo.Ciclo, tblc_modalidad._Modalidad FROM tble_calendario Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tble_calendario.IdCiclo Left Join tblc_modalidad ON tblc_modalidad.Mod = tble_calendario.Modalidad ORDER BY tblc_ciclo.FInicio ASC");
    while ($x = $db->recorrer($sql)) {
      $get_lst_calendario_esc[] = $x;
    }
    return $get_lst_calendario_esc;
  }


  public function get_sincornizacion()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblc_usuario.Nombre, tblc_estatus.Estatus, tblc_usuario.IdEstatus FROM tblp_pagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblp_pagos.IdEstatus =  '1' AND ((tblc_usuario.IdEstatus =  '14') || (tblc_usuario.IdEstatus =  '15')) GROUP BY tblp_pagos.IdUsua ");
    while ($x = $db->recorrer($sql)) {
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '58' WHERE tblp_pagos.IdEstatus = '1' AND tblp_pagos.IdUsua = '".$x['IdUsua']."' ");    
    }    
  }



  public function get_lst_prorroga()
  {
    $db = new Conexion();
    $get_lst_prorroga = [];
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_educativa.Nombre AS Educativa, tblc_estatus.Estatus FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Folio =  '7684'");
    while ($x = $db->recorrer($sql)) {
      $get_lst_prorroga[] = $x;
    }
    return $get_lst_prorroga;
  }

  public function get_tipoEvaluacion()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT
tblc_tipoevaluacion.IdTipoEvaluacion,
tblc_tipoevaluacion.Evaluacion,
tblc_tipoevaluacion.IdEstatus,
tblc_estatus.Estatus,
tblc_permiso.Permiso
FROM
tblc_tipoevaluacion
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_tipoevaluacion.IdEstatus
Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblc_tipoevaluacion.IdPermiso
");
    while ($x = $db->recorrer($sql)) {
      $get_tipoEvaluacion[] = $x;
    }
    return $get_tipoEvaluacion;
  }

  public function get_tipoEvaluacionTipo()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdPermiso = '3'");
    while ($x = $db->recorrer($sql)) {
      $get_tipoEvaluacionTipo[] = $x;
    }
    return $get_tipoEvaluacionTipo;
  }

  public function get_tipoEvaluacionId($IdTipo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion = '$IdTipo'");
    while ($x = $db->recorrer($sql)) {
      $get_tipoEvaluacionId[] = $x;
    }
    return $get_tipoEvaluacionId;
  }

  public function get_lstPreguntas($IdTipo)
  {
    $db = new Conexion();

    $get_lstPreguntas = [];
    $sql = $db->query("SELECT
tblx_pregunta.IdPregunta,
tblx_pregunta.Tipo,
tblx_pregunta.Pregunta,
tblx_pregunta.IdEstatus,
tblx_pregunta._Tipo,
tblc_estatus.Estatus,
tblx_modulo.Nombre_mod,
tblx_bloque.Bloque,
tblx_pregunta.IdMod,
tblx_pregunta.IdBloque
FROM
tblx_pregunta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_pregunta.IdEstatus
Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod
Left Join tblx_bloque ON tblx_bloque.IdBloque = tblx_pregunta.IdBloque
WHERE tblx_pregunta.Tipo = '$IdTipo'
ORDER BY
tblx_pregunta.IdMod ASC,
tblx_pregunta.IdBloque ASC");
    while ($x = $db->recorrer($sql)) {
      $get_lstPreguntas[] = $x;
    }
    return $get_lstPreguntas;
  }

  public function get_lstListaFinal($IdCampus, $IdCiclo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_estatus.Estatus
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblp_asignacion.IdCampus =  '$IdCampus' AND
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion.IdCiclo =  '$IdCiclo'
GROUP BY
tblp_asignacion.IdUsua
ORDER BY
tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $gEvaLst[] = $x;
    }
    return $gEvaLst;
  }

  public function get_lstCam($IdCampus)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $gCamaLst[] = $x;
    }
    return $gCamaLst;
  }

  public function get_lstTipoE($IdTipo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_tipoevaluacion.Evaluacion FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion = '$IdTipo'");
    while ($x = $db->recorrer($sql)) {
      $get_lstTipoE[] = $x;
    }
    return $get_lstTipoE;
  }

  public function get_lstCic($IdCiclo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    while ($x = $db->recorrer($sql)) {
      $gCicLst[] = $x;
    }
    return $gCicLst;
  }

  public function get_lstLiFinal($IdCampus, $IdCiclo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_evaluaciondocente.Promedio FROM tblc_usuario Left Join tblp_evaluaciondocente ON tblp_evaluaciondocente.IdUsua = tblc_usuario.IdUsua WHERE tblc_usuario.Permisos = '2' AND tblp_evaluaciondocente.IdCampus = '$IdCampus' AND tblp_evaluaciondocente.IdCiclo = '$IdCiclo' ORDER BY tblc_usuario.APaterno ASC");
    while ($x = $db->recorrer($sql)) {
      $gEvaLst[] = $x;
    }
    return $gEvaLst;
  }

  public function get_lstSugerencia($IdCampus, $IdCiclo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblx_respuesta.Texto FROM tblx_respuesta WHERE tblx_respuesta.IdCampus = '$IdCampus' AND tblx_respuesta.IdCiclo = '$IdCiclo' AND tblx_respuesta.IdEstatus = '26' AND tblx_respuesta.Texto IS NOT NULL ");
    while ($x = $db->recorrer($sql)) {
      $gEvaLst[] = $x;
    }
    return $gEvaLst;
  }

  public function get_lstOfertCam($IdCampus)
  {
    $db = new Conexion();
    $get_lstOfertCam = [];
    
    $sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.IdCampus, tblp_educativa.Nombre, tblp_grupo.IdOferta AS IdEducativa FROM tblp_grupo LEFT JOIN tblp_educativa ON tblp_grupo.IdOferta = tblp_educativa.IdEducativa WHERE tblp_grupo.IdCampus = '$IdCampus' GROUP BY tblp_grupo.IdOferta ORDER BY tblp_educativa.IdGrado ASC, tblp_grupo.IdOferta ASC ");
    // $sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.IdEducativa, tblp_modulo.Grado, tblp_modulo.NombreMod, tblp_modulo.Estatus, tblp_modulo.Code, tblp_modulo.Oferta, tblp_modulo.IdCampus, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa ");
    while ($x = $db->recorrer($sql)) {
      $get_lstOfertCam[] = $x;
    }
    return $get_lstOfertCam;
  }

  public function get_permiActiId($IdEducativa, $IdUsua, $IdCampus)
  {
    $db = new Conexion();
    $get_permiActiId = [];
    $sql = $db->query("SELECT * FROM tblp_coordinador WHERE tblp_coordinador.IdUsua = '$IdUsua' AND tblp_coordinador.IdOferta =  '$IdEducativa' AND tblp_coordinador.IdEstatus = '8' AND tblp_coordinador.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $get_permiActiId[] = $x;
    }
    return $get_permiActiId;
  }

  public function get_docsGrado($IdGrado)
  {
    if ($IdGrado) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblc_tipodocumento.IdTipoDocumento, tblc_tipodocumento.NomDocumento, tblc_tipodocumento.Grado$IdGrado FROM tblc_tipodocumento WHERE tblc_tipodocumento.Gral = '1'");
      while ($x = $db->recorrer($sql)) {
        $gGrFRadosET[] = $x;
      }
      return $gGrFRadosET;
    }
  }

  public function get_misdocsGrado($IdGrado)
  {
    if ($IdGrado) {
      $db = new Conexion();
      $get_misdocsGrado = [];
      $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGrado'");
      while ($x = $db->recorrer($sql)) {
        $get_misdocsGrado[] = $x;
      }
      return $get_misdocsGrado;
    }
  }

  public function get_ofertSelecc($IdOferta, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_coordinador WHERE tblp_coordinador.IdUsua = '$IdUsua' AND tblp_coordinador.IdOferta = '$IdOferta' AND tblp_coordinador.IdEstatus = '8' ");
    while ($x = $db->recorrer($sql)) {
      $gSelOferta[] = $x;
    }
    return $gSelOferta;
  }

  public function get_conceptoId($IdConcepto)
  {
    if ($IdConcepto) {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.IdConcepto = '$IdConcepto' ");
      while ($x = $db->recorrer($sql)) {
        $gConceptoId[] = $x;
      }
      return $gConceptoId;
    }
  }

  public function get_chkConcepto($IdConcepto)
  {
    if ($IdConcepto) {
      $db = new Conexion();
      $sql = $db->query("SELECT Count(tblp_pagos.IdPago) AS TotalConceptos, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdConcepto =  '$IdConcepto' GROUP BY tblp_pagos.IdConcepto");
      while ($x = $db->recorrer($sql)) {
        $gChkConcepto[] = $x;
      }
      return $gChkConcepto;
    }
  }

  public function get_tipoOftz($Tipo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.Nombre = '$Tipo'");
    while ($x = $db->recorrer($sql)) {
      $gcongta[] = $x;
    }
    return $gcongta;
  }

  # OBTENER TODOS LOS DOCENTES
  public function get_docentesT()
  {
    $db = new Conexion();
    $get_docentesT = [];
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Sexo, tblc_estatus.Estatus, tblc_campus.Campus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.Permisos = '2' ORDER BY tblc_usuario.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_docentesT[] = $x;
    }
    return $get_docentesT;
  }

  public function get_docentesTId($IdCampus)
  {
    $db = new Conexion();
    $get_docentesTId = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Sexo,
tblc_estatus.Estatus,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.Permisos = '2' AND tblc_usuario.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $get_docentesTId[] = $x;
    }
    return $get_docentesTId;
  }


  public function get_facturas($estatus)
  {
    $db = new Conexion();
    if ($estatus) {
      $get_facturas = [];
      $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.FacturaEstatus, tblp_pagos.DocFactura, tblp_pagos.FecFactura, tblp_educativa.Nombre AS nomEducativa, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_conceptosplanes.NomPlan, tblp_pagos.FecDesc FROM tblp_pagos Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan  WHERE tblp_pagos.Facturar = 'SI' AND tblp_pagos.FacturaEstatus = '$estatus' ");
      while ($x = $db->recorrer($sql)) {
        $get_facturas[] = $x;
      }
      return $get_facturas;
    }
  }

  public function get_bajasPro($estatus)
  {
    $db = new Conexion();
    $gBjasL = [];
    if ($estatus) {
      if ($estatus == 2) {
        $sql = $db->query("SELECT tblc_doctramite.IdDocTramite, tblc_doctramite.IdUsua, tblc_doctramite.Estatus, tblc_doctramite.FecCap, tblc_doctramite.Visto, tblc_doctramite.Tipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblp_educativa.Nombre AS NomEducativa, tblc_usuario.Matricula FROM tblc_doctramite Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_doctramite.IdUsua Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_doctramite.Tipo =  '45' AND tblc_doctramite.Estatus =  '$estatus' GROUP BY tblc_doctramite.IdUsua");
      } else {
        $sql = $db->query("SELECT tblh_baja.IdBaja, tblh_baja.IdUsua, tblh_baja.IdEstatus, tblh_baja.Comentario, tblh_baja.FecCap, tblh_baja.Tipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_estatus.Estatus, tblp_educativa.Nombre AS NomEducativa, tblc_usuario.Matricula FROM tblh_baja Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_baja.IdUsua Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_baja.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta");
      }
      while ($x = $db->recorrer($sql)) {
        $gBjasL[] = $x;
      }
      return $gBjasL;
    }
  }

  public function get_educativaBus($IdDocente)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_educativa.Nombre FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa WHERE tblp_asignacion.IdUsua = '$IdDocente' GROUP BY tblp_asignacion.IdEducativa");
    while ($x = $db->recorrer($sql)) {
      $geducativaBus[] = $x;
    }
    return $geducativaBus;
  }

  public function get_tUsuario($Tipo)
  {
    if ($Tipo) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.Permisos = '$Tipo'");
      while ($x = $db->recorrer($sql)) {
        $gTUsuario[] = $x;
      }
      return $gTUsuario;
    }
  }

  public function get_lstIngresos($fecha1, $fecha2, $IdUsua)
  {
    if ($IdUsua && $fecha1 && $fecha2) {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblh_ingresos WHERE tblh_ingresos.IdUsua = '$IdUsua' AND tblh_ingresos.FecCap BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' ORDER BY tblh_ingresos.FecCap ASC");
      while ($x = $db->recorrer($sql)) {
        $gLstUsuario[] = $x;
      }
      return $gLstUsuario;
    }
  }

  public function get_lstContador($fecha1, $fecha2, $IdUsua)
  {
    if ($IdUsua && $fecha1 && $fecha2) {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblh_contador WHERE tblh_contador.IdUsua = '$IdUsua' AND tblh_contador.FecIng  BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' ORDER BY tblh_contador.FecIng ASC");
      while ($x = $db->recorrer($sql)) {
        $gIngresos[] = $x;
      }
      return $gIngresos;
    }
  }

  public function get_lstIngCount($fecha1, $fecha2, $IdUsua)
  {
    if ($IdUsua && $fecha1 && $fecha2) {
      $db = new Conexion();
      $sql = $db->query("SELECT Count(tblh_ingresos.IdIngreso) AS Ingresos FROM tblh_ingresos WHERE tblh_ingresos.IdUsua =  '$IdUsua' AND tblh_ingresos.FecCap BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' AND tblh_ingresos.Pagina =  'Ha Iniciado sesion en la Plataforma MWComenius'");
      while ($x = $db->recorrer($sql)) {
        $gLstCount[] = $x;
      }
      return $gLstCount;
    }
  }

  public function get_moduloBus($IdCiclo, $IdGrupo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = 2");
    while ($x = $db->recorrer($sql)) {
      $geducativaBusd[] = $x;
    }
    return $geducativaBusd;
  }

  # OBTENER TODOS LOS ALUMNOS
  public function get_alumnosT($IdGrupo)
  {
    $db = new Conexion();
    $get_alumnosT = [];

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.Folio, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Matricula, tblc_usuario.Sexo, tblp_educativa.IdGrado, tblc_usuario.Celular, tblc_usuario.IdOferta, tblp_educativa.Nombre AS NomEducativa, tblp_grupo.CveGrupo, tblc_estatus.Estatus, tblp_informacion.P_curp FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua WHERE  tblc_usuario.IdGrupo = '$IdGrupo' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50') || (tblc_usuario.IdEstatus = '55'))");
    while ($x = $db->recorrer($sql)) {
      $get_alumnosT[] = $x;
    }
    return $get_alumnosT;
  }

  public function get_alumBloqueado()
  {
    $db = new Conexion();
    $get_alumBloqueado = [];

    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Matricula,
tblp_educativa.Nombre AS NomEducativa,
tblp_grupo.CveGrupo,
tblc_estatus.Estatus,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE  tblc_usuario.IdEstatus = '50'
 ");
    while ($x = $db->recorrer($sql)) {
      $get_alumBloqueado[] = $x;
    }
    return $get_alumBloqueado;
  }

  public function get_alumnosBeca($IdGrupo, $IdCampus, $IdPlan)
  {
    $db = new Conexion();

    // echo "SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Matricula, tblc_usuario.Sexo, tblp_educativa.Clave, tblp_educativa.Nombre AS NomEducativa, tblp_grupo.CveGrupo FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE  tblc_usuario.IdGrupo = '$IdGrupo'";

    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Clave,
tblp_educativa.Nombre AS NomEducativa,
tblc_usuario.IdOferta,
tblp_beca.Porcentaje,
tblc_conceptosplanes.NomPlan,
tblc_conceptosplanes.IdConceptoPlanes,
tblc_usuario.Usuario
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_beca ON tblp_beca.IdUsua = tblc_usuario.IdUsua
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_beca.IdConceptoPlan
WHERE
tblc_usuario.IdGrupo =  '$IdGrupo' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan' ");
    while ($x = $db->recorrer($sql)) {
      $gAlumosTB[] = $x;
    }
    return $gAlumosTB;
  }

  public function get_docSolicitadosLst($IdOferta, $IdEstatus, $IdConcepto)
  {
    if ($IdOferta) {
      $db = new Conexion();
      if ($IdEstatus == 14) {
        $cond = " ";
      } else {
        $cond = " AND tblc_docsolicitado.IdEstatus = '$IdEstatus' ";
      }
      if ($IdConcepto) {
        $cond3 = "  AND tblc_docsolicitado.IdConcepto = '$IdConcepto'";
      } else {
        $cond3 = " ";
      }
      $sql = $db->query("SELECT tblc_docsolicitado.IdDocSolicitado, tblc_docsolicitado.IdPago, tblc_docsolicitado.IdEstatus, tblc_docsolicitado.Archivo, tblc_docsolicitado.Fecha, tblc_docsolicitado.FecCap, tblc_docsolicitado.FechaEntrega, tblc_usuario.IdUsua, tblc_usuario.Matricula, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_educativa.Nombre AS NomOferta, tblc_conceptos.IdConcepto, tblc_conceptos.NomConcepto, tblc_estatus.Estatus FROM tblc_docsolicitado Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_docsolicitado.IdUsua Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_docsolicitado.IdConcepto Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docsolicitado.IdEstatus WHERE tblc_usuario.IdOferta = '$IdOferta' $cond $cond3");
      while ($x = $db->recorrer($sql)) {
        $gPagosE[] = $x;
      }
      return $gPagosE;
    }
  }

  public function get_alumnosLibre()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Estado, tblc_usuario.Sexo, tblp_educativa.Nombre AS NomEducativa FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.Tipo =  '3' AND tblc_usuario.Code IS NOT NULL  AND tblc_usuario.IdGrupo IS NULL");
    while ($x = $db->recorrer($sql)) {
      $gAlumosTx[] = $x;
    }
    return $gAlumosTx;
  }

  # OBTENER TODOS LOS ALUMNOS
  public function get_alumnosTodos()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Tipo = '3' ORDER BY tblc_usuario.Nombre ASC, tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");
    while ($x = $db->recorrer($sql)) {
      $gAlumosTD[] = $x;
    }
    return $gAlumosTD;
  }

  # OBTENER MODULOS ASIGANDOS A LOS DOCENTES
  public function get_modulosAsigandos($IdCiclo, $IdGrupo)
  {
    if ($IdCiclo) {
      $gmodulosAsig = [];
      $db = new Conexion();
      $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.IdUsua,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.IdCiclo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Oferta,
tblc_ciclo.Tipo,
tblp_modulo.Grado,
tblc_abreviatura.Abreviatura,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_estatus.IdEstatus,
tblc_estatus.Estatus
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo ='$IdGrupo' ");
      while ($x = $db->recorrer($sql)) {
        $gmodulosAsig[] = $x;
      }
      return $gmodulosAsig;
    }
  }

  public function get_lst_mat_grp($IdGrupo)
  {
    if ($IdGrupo) {
      $get_lst_mat_grp = [];
      $db = new Conexion();
      $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_educativa.Nombre AS Educativa,
tblp_educativa.IdEducativa,
tblp_modulo.CodeModulo,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblc_ciclo.Ciclo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdGrupo ='$IdGrupo' ORDER BY tblp_modulo.CodeModulo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_lst_mat_grp[] = $x;
      }
      return $get_lst_mat_grp;
    }
  }

  # OBTENER UNA OFERTA EDUCATIVA EN ESPECIFICO
  public function get_OfertaEId($idE)
  {
    $db = new Conexion();
    $gOfertaEId = [];
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE IdEducativa='$idE'");
    while ($x = $db->recorrer($sql)) {
      $gOfertaEId[] = $x;
    }
    return $gOfertaEId;
  }

  public function get_docAsig()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Estatus =  'Finalizado' GROUP BY tblp_asignacion.IdUsua");
    while ($x = $db->recorrer($sql)) {
      $gdocAsign[] = $x;
    }
    return $gdocAsign;
  }

  public function get_eduEncs($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_educativa.Nombre, tblp_educativa.Ciclo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa WHERE tblp_asignacion.IdUsua =  '$IdUsua' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_asignacion.IdEducativa");
    while ($x = $db->recorrer($sql)) {
      $geduEnsc[] = $x;
    }
    return $geduEnsc;
  }

  public function get_asintEncs($IdUsua, $IdEducativa)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_modulo.NombreMod, tblp_modulo.Grado, tblc_ciclo.Ciclo, tblp_grupo.CveGrupo, tblc_abreviatura.Abreviatura FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo AND tblp_modulo.IdEducativa = tblp_asignacion.IdEducativa Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado WHERE tblp_asignacion.IdEducativa =  '$IdEducativa' AND tblp_asignacion.IdUsua =  '$IdUsua' AND tblp_asignacion.Estatus =  'Finalizado'");
    while ($x = $db->recorrer($sql)) {
      $gasignsEnsc[] = $x;
    }
    return $gasignsEnsc;
  }

  public function get_docEncuesta()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_encuesta.IdUsuaDocente, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_encuesta Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_encuesta.IdUsuaDocente WHERE tblc_encuesta.Estatus =  '10' GROUP BY tblc_encuesta.IdUsuaDocente");
    while ($x = $db->recorrer($sql)) {
      $gdocEncsn[] = $x;
    }
    return $gdocEncsn;
  }

  public function get_noAlumnosEncs($IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_encuesta.IdEncuesta, tblc_encuesta.IdAsignacion FROM tblc_encuesta WHERE tblc_encuesta.IdAsignacion =  '$IdAsignacion' AND tblc_encuesta.Respuesta IS NOT NULL  GROUP BY tblc_encuesta.IdUsua");
    while ($x = $db->recorrer($sql)) {
      $garesuDics[] = $x;
    }
    return $garesuDics;
  }

  public function get_noAlumnosDocX($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_encuesta.IdEncuesta FROM tblc_encuesta WHERE tblc_encuesta.IdUsuaDocente =  '$IdUsua' AND tblc_encuesta.IdPregunta =  '1'");
    while ($x = $db->recorrer($sql)) {
      $garstDoc[] = $x;
    }
    return $garstDoc;
  }

  public function get_noAlumnGrtal()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_encuesta.IdEncuesta FROM tblc_encuesta WHERE tblc_encuesta.IdPregunta =  '1'");
    while ($x = $db->recorrer($sql)) {
      $garDocGral[] = $x;
    }
    return $garDocGral;
  }

  public function get_lstAlummosK($IdGrupo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdOferta, tblp_educativa.Ciclo, tblp_educativa.Duracion, tblc_usuario.SemCua FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdGrupo = '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $gAlumnosK[] = $x;
    }
    return $gAlumnosK;
  }


  # OBTENER UN MODULO EN ESPECIFICO
  public function get_moduloIdE($IdModulo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo='$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $gmoduloId[] = $x;
    }
    return $gmoduloId;
  }

  public function get_archivosIdE($IdModulo, $IdOferta)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_archivo WHERE tblp_archivo.IdModulo='$IdModulo' AND tblp_archivo.IdOferta = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $gmFILKESId[] = $x;
    }
    return $gmFILKESId;
  }

  public function get_campusId()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_campus");
    while ($x = $db->recorrer($sql)) {
      $gCampusId[] = $x;
    }
    return $gCampusId;
  }

  public function get_idAsig($IdModulo)
  {
    $db = new Conexion();
    $IdModulo = substr($IdModulo, 10, 10);

    $sql = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $gCursoId[] = $x;
    }
    return $gCursoId;
  }

  public function get_usersLstC($IdModulo, $IdAsignacion)
  {
    $db = new Conexion();
    $IdModulo = substr($IdModulo, 10, 10);

    $sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblc_campus.Campus,
tblp_moduloalumno.IdModulo
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $gCursoId[] = $x;
    }
    return $gCursoId;
  }

  public function get_usersLst($IdTipo, $IdCampus)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '$IdTipo' AND tblc_usuario.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $gUsersdId[] = $x;
    }
    return $gUsersdId;
  }

  # OBTENER LOS DATOS ASIGADOS AL DOCENTE
  public function get_datostosAsig($IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while ($x = $db->recorrer($sql)) {
      $gmoduloAsig[] = $x;
    }
    return $gmoduloAsig;
  }

  # OBTENER TODOS LOS USUARIOS
  public function get_usuariosTipo($Tipo, $IdCampus)
  {


    if (($Tipo) && ($IdCampus)) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblc_usuario.IdEstatus, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Permisos = '$Tipo' AND tblc_usuario.IdCampus = '$IdCampus' ");
      while ($x = $db->recorrer($sql)) {
        $gusuariosT[] = $x;
      }
      return $gusuariosT;
    }
  }

  public function get_usuariosExt($IdCampus)
  {
    if ($IdCampus) {
      $db = new Conexion();
      $get_usuariosExt = [];
      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_estatus.Estatus, tblc_estatus.Estatus, tblp_educativa.Nombre AS NomEducativa FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdCampus = '$IdCampus' AND ((tblc_usuario.IdEstatus = '14') || (tblc_usuario.IdEstatus = '15')) ");
      while ($x = $db->recorrer($sql)) {
        $get_usuariosExt[] = $x;
      }
      return $get_usuariosExt;
    }
  }

  public function get_grupoTipo($IdCampus)
  {


    if ($IdCampus) {
      $db = new Conexion();
      $sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Estatus,
tblp_grupo.Tipo,
tblp_grupo.Turno,
tblp_grupo.Oferta,
tblp_grupo.Grupo,
tblp_grupo.Modalidad,
tblp_grupo.IdCampus,
tblp_grupo.IdGrado,
tblp_grupo.IdOferta,
tblp_grupo.IdPlan,
tblp_grupo.Nivel,
tblp_grupo.Periodo,
tblp_educativa.Nombre,
tblc_dias.Dias
FROM
tblp_grupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE tblp_grupo.IdCampus = '$IdCampus'");
      while ($x = $db->recorrer($sql)) {
        $gGrupoT[] = $x;
      }
      return $gGrupoT;
    }
  }
  public function get_usuariosAlm()
  {
    $db = new Conexion();
    $get_usuariosAlm = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Matricula,
tblp_educativa.Nombre AS NomEducativa,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdEstatus =  '8' AND tblc_usuario.IdGrupo IS NULL ");
    while ($x = $db->recorrer($sql)) {
      $get_usuariosAlm[] = $x;
    }
    return $get_usuariosAlm;
  }

  public function get_alumnosRep($Tipo)
  {
    $db = new Conexion();
    if ($Tipo == 1) {
      $cond  = " AND tblp_moduloalumno.Recursar = '1' AND tblp_moduloalumno.Activo IS NULL";
    } else {
      $cond  = " AND tblp_moduloalumno.Activo ='1'";
    }
    $get_alumnosRep = [];
    $sql = $db->query("SELECT
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdModulo,
tblp_moduloalumno.IdUsua,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_educativa.Nombre AS NombreOfe,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_campus.Campus
FROM
tblp_moduloalumno
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Inner Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
Inner Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE
tblp_moduloalumno.Recursar =  '1' $cond
");
    while ($x = $db->recorrer($sql)) {
      $get_alumnosRep[] = $x;
    }
    return $get_alumnosRep;
  }

  public function get_pagosPendientes($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Pagar FROM tblp_pagos WHERE tblp_pagos.IdEstatus <> '4' AND tblp_pagos.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $getPagPend[] = $x;
    }
    return $getPagPend;
  }

  public function get_pagosPenGrupo($IdGrupo, $IdEstatus)
  {
    $db = new Conexion();
    $hoy = date("Y-m-d");
    if (($IdEstatus) && ($IdGrupo)) {
      if ($IdEstatus == 8) {
        $condsx = " AND ((tblc_usuario.IdEstatus =  '8') || (tblc_usuario.IdEstatus =  '50'))";
      } else {
        $condsx = " AND tblc_usuario.IdEstatus =  '$IdEstatus' ";
      }

      $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_estatus.Estatus,
tblp_pagos.IdPago,
tblp_pagos.Monto,
tblp_pagos.FecDesc,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblp_pagos.Descuento,
tblp_educativa.Nombre AS Educativa,
tblc_conceptosplanes.NomPlan,
tblc_ciclo.Ciclo
FROM
tblc_usuario
Left Join tblp_pagos ON tblp_pagos.IdUsua = tblc_usuario.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
WHERE
tblc_usuario.IdGrupo =  '$IdGrupo'
AND tblp_pagos.IdEstatus <>  '4' AND tblp_pagos.FecDesc < '$hoy' $condsx ");
      while ($x = $db->recorrer($sql)) {
        $getPagPend[] = $x;
      }
      return $getPagPend;
    }
  }

  public function get_pagosPenOferta($IdCampus, $IdEstatus)
  {
    $db = new Conexion();
    $hoy = date("Y-m-d");
    $get_pagosPenOferta = [];
    if (($IdEstatus) && ($IdCampus)) {
      if ($IdEstatus == 8) {
        $condsx = " AND ((tblc_usuario.IdEstatus =  '8') || (tblc_usuario.IdEstatus =  '50'))";
      } else {
        $condsx = " AND tblc_usuario.IdEstatus =  '$IdEstatus' ";
      }

      $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_estatus.Estatus,
tblp_pagos.IdPago,
tblp_pagos.Monto,
tblp_pagos.FecDesc,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblp_pagos.Descuento,
tblp_educativa.Nombre AS Educativa,
tblc_conceptosplanes.NomPlan,
tblc_ciclo.Ciclo,
tblp_grupo.CveGrupo
FROM
tblc_usuario
Left Join tblp_pagos ON tblp_pagos.IdUsua = tblc_usuario.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
WHERE
tblc_usuario.IdCampus =  '$IdCampus'
AND tblp_pagos.IdEstatus <>  '4' AND tblp_pagos.FecDesc < '$hoy' $condsx ");
      while ($x = $db->recorrer($sql)) {
        $get_pagosPenOferta[] = $x;
      }
      return $get_pagosPenOferta;
    }
  }

  public function get_grp_total($IdCampus, $IdOferta)
  {
    $db = new Conexion();
    $hoy = date("Y-m-d");
    $get_grp_total = [];
    if (($IdCampus) && ($IdOferta)) {

      if ($IdOferta == 'x') {
        $cond = "";
      } else {
        $cond = " AND tblc_usuario.IdOferta =  '$IdOferta' ";
      }

      $sql = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total,
tblc_usuario.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Turno,
tblp_grupo.Modalidad,
tblp_grupo.Dia,
tblp_grupo.TipoCiclo,
tblp_grupo.IdGrado,
tblc_estatus.Estatus,
tblp_educativa.Nombre
FROM
tblc_usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_grupo.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdCampus =  '$IdCampus' AND
tblc_usuario.IdEstatus =  '8' $cond
GROUP BY
tblc_usuario.IdGrupo
 ");
      while ($x = $db->recorrer($sql)) {
        $get_grp_total[] = $x;
      }
      return $get_grp_total;
    }
  }

  public function get_usuariosSinM()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Matricula, tblp_educativa.Nombre AS NomEducativa FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Tipo = '3' AND tblc_usuario.IdEstatus =  '8' AND (tblc_usuario.Matricula IS NULL OR tblc_usuario.Matricula = '') AND tblc_usuario.IdGrupo IS NOT NULL");
    while ($x = $db->recorrer($sql)) {
      $gusuariosTas[] = $x;
    }
    return $gusuariosTas;
  }

  public function get_estatusUser()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_estatus WHERE tblc_estatus.Fase1 = '4'");
    while ($x = $db->recorrer($sql)) {
      $gEstatus[] = $x;
    }
    return $gEstatus;
  }

  public function get_docsBaja($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_doctramite WHERE tblc_doctramite.IdUsua = '$IdUsua' AND tblc_doctramite.Tipo = '45'");
    while ($x = $db->recorrer($sql)) {
      $gDocsBaja[] = $x;
    }
    return $gDocsBaja;
  }

  # OBTENER LA LISTA DE MODULO SEGUN LA OFERTA EDUCTIVA
  public function get_ModuloId($IdOferta, $IdCampus)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' ORDER BY tblp_modulo.CodeModulo ASC");
    while ($x = $db->recorrer($sql)) {
      $gusuariosT[] = $x;
    }
    return $gusuariosT;
  }

  public function get_ModuloIdCur($IdOferta, $IdCampus)
  {
    $db = new Conexion();
    $gusuariosT = [];
    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $gusuariosT[] = $x;
    }
    return $gusuariosT;
  }

  public function get_oferDispo($IdCampus, $IdOferta, $IdModulo, $IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblk_disponible WHERE tblk_disponible.IdCampus = '$IdCampus' AND tblk_disponible.IdOferta = '$IdOferta' AND tblk_disponible.IdModulo = '$IdModulo' AND tblk_disponible.IdUsua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $gKdispo[] = $x;
    }
    return $gKdispo;
  }

  public function chk_parcial_doc($IdAsignacion, $IdCiclo, $IdGrupo, $Tipo)
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2' ");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $_idE = $datos2['IdEducativa'];
    $_idM = $datos2['IdModulo'];
    $_idU = $datos2['IdUsua'];
    $_idG = $datos2['IdGrupo'];

    if ($Tipo == "E") {
      $sql = $db->query("SELECT tble_calendario_grupo.IdDisponible, tble_calendario_grupo.IdCalendario, tble_fecha.Parcial, tble_fecha.FechaIni, tble_fecha.FechaFin FROM tble_calendario_grupo Left Join tble_fecha ON tble_fecha.IdCalendario = tble_calendario_grupo.IdCalendario WHERE tble_calendario_grupo.IdCiclo =  '$IdCiclo' AND tble_calendario_grupo.IdGrupo =  '$IdGrupo' ORDER BY tble_fecha.Parcial ASC ");
      while ($x = $db->recorrer($sql)) {
        $noPar = $x['Parcial'];

        $sql_par = $db->query("SELECT tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '$noPar' ");
        $db->rows($sql_par);
        $_par = $db->recorrer($sql_par);
        $_idPar = $_par["IdParcialDocente"];

        if (!$_idPar) {
          $etiqueta = "Parcial " . $noPar;
          $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo, FecIni, FecFin) VALUES('" . $datos2['IdEducativa'] . "','" . $datos2['IdModulo'] . "','$etiqueta','$noPar',NOW(),'" . $datos2['IdUsua'] . "','4','" . $datos2['IdGrupo'] . "','" . $datos2['IdCiclo'] . "','$IdAsignacion','P','" . $x['FechaIni'] . "','" . $x['FechaFin'] . "')");
        }
      }
    } else {
      $sql_par = $db->query("SELECT tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '1' ");
      $db->rows($sql_par);
      $_par = $db->recorrer($sql_par);
      $_idPar = $_par["IdParcialDocente"];
      if (!$_idPar) {
        $etiqueta1 = 'Parcial 1';
        $etiqueta2 = 'Parcial 2';
        $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo)VALUES('$_idE','$_idM','$etiqueta1','1',NOW(),'$_idU','4','$_idG','$IdCiclo','$IdAsignacion','P')");
        $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo)VALUES('$_idE','$_idM','$etiqueta2','2',NOW(),'$_idU','4','$_idG','$IdCiclo','$IdAsignacion','P')");
      }
    }
  }

  public function chk_parcial_mod($IdAsignacion, $IdCiclo, $IdGrupo, $Tipo)
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2' ");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $idOferta = $datos2['IdEducativa'];

    if(($idOferta == 33) || ($idOferta == 47)){
      $sql_par1 = $db->query("SELECT tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '1' ");
      $db->rows($sql_par1);
      $_par1 = $db->recorrer($sql_par1);
      $_idPar1 = $_par1["IdParcialDocente"];

      if (!$_idPar1) {
        $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo, FecIni, FecFin) VALUES('" . $datos2['IdEducativa'] . "','" . $datos2['IdModulo'] . "','Parcial 1','1',NOW(),'" . $datos2['IdUsua'] . "','4','" . $datos2['IdGrupo'] . "','" . $datos2['IdCiclo'] . "','$IdAsignacion','P','" . $datos2['FecIni'] . "','" . $datos2['FecFin'] . "')");
      }

      $sql_par2 = $db->query("SELECT tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '2' ");
      $db->rows($sql_par2);
      $_par2 = $db->recorrer($sql_par2);
      $_idPar2 = $_par2["IdParcialDocente"];

      if (!$_idPar2) {
        $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo, FecIni, FecFin) VALUES('" . $datos2['IdEducativa'] . "','" . $datos2['IdModulo'] . "','Parcial 2','2',NOW(),'" . $datos2['IdUsua'] . "','4','" . $datos2['IdGrupo'] . "','" . $datos2['IdCiclo'] . "','$IdAsignacion','P','" . $datos2['FecIni'] . "','" . $datos2['FecFin'] . "')");
      }

      $sql_par3 = $db->query("SELECT tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '3' ");
      $db->rows($sql_par3);
      $_par3 = $db->recorrer($sql_par3);
      $_idPar3 = $_par3["IdParcialDocente"];

      if (!$_idPar3) {
        $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo, FecIni, FecFin) VALUES('" . $datos2['IdEducativa'] . "','" . $datos2['IdModulo'] . "','Evaluación final','3',NOW(),'" . $datos2['IdUsua'] . "','4','" . $datos2['IdGrupo'] . "','" . $datos2['IdCiclo'] . "','$IdAsignacion','P','" . $datos2['FecIni'] . "','" . $datos2['FecFin'] . "')");
      }
    } else {
      $sql_par = $db->query("SELECT tblp_parcialdocente.IdParcialDocente FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '1' ");
      $db->rows($sql_par);
      $_par = $db->recorrer($sql_par);
      $_idPar = $_par["IdParcialDocente"];

      if (!$_idPar) {
        $insertar = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, IdModulo, Titulo, NoParcial, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo, FecIni, FecFin) VALUES('" . $datos2['IdEducativa'] . "','" . $datos2['IdModulo'] . "','Parcial 1','1',NOW(),'" . $datos2['IdUsua'] . "','4','" . $datos2['IdGrupo'] . "','" . $datos2['IdCiclo'] . "','$IdAsignacion','P','" . $datos2['FecIni'] . "','" . $datos2['FecFin'] . "')");
      }
    }

    
  }

  public function get_ModuloIdCurT($IdOferta)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT
      tblp_modulo.Grado,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Creditos,
tblp_modulo.HraDoc,
tblp_modulo.HraInd,
tblp_asignacion.IdAsignacion,
tblp_planeacion.IdPlaneacion,
tblp_asignacion.IdModulo,
tblp_asignacion.IdEstatus
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_planeacion ON tblp_planeacion.IdAsignacion = tblp_asignacion.IdAsignacion WHERE tblp_asignacion.IdEducativa = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $gusuariosT[] = $x;
    }
    return $gusuariosT;
  }

  public function get_ModuloIdAsig($IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();
      
      
      $sql1 = $db->query("SELECT tblc_rvoe.Educativa, tblc_rvoe.IdEducativa, tblc_rvoe.IdCampus, tblp_grupo.IdGrupo, tblc_rvoe.Rvoe FROM tblp_grupo Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblp_grupo.id_rvoe WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdCampus = $datos2["IdCampus"];
      $IdEducativa = $datos2["IdEducativa"];
      $gusuariosT = [];

      if($IdEducativa == 32){
        $sql1 = $db->query("SELECT tblp_grupo.IdCampus FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdCampus = $datos2["IdCampus"];
      }

      if($IdEducativa == 38){
        $sql1 = $db->query("SELECT tblp_grupo.IdCampus FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdCampus = $datos2["IdCampus"];
      }
      
      $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdEducativa' AND tblp_modulo.IdCampus = '$IdCampus' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.Code ASC ");
      while ($x = $db->recorrer($sql)) {
        $gusuariosT[] = $x;
      }
      return $gusuariosT;
    }
  }

  public function get_rvoe_id($IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();      
      $sql = $db->query("SELECT tblc_rvoe.Educativa, tblc_rvoe.IdEducativa, tblc_rvoe.IdCampus, tblp_grupo.IdGrupo, tblc_rvoe.Rvoe FROM tblp_grupo Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblp_grupo.id_rvoe WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      while ($x = $db->recorrer($sql)) {
        $get_rvoe_id[] = $x;
      }
      return $get_rvoe_id;
    }
  }

  public function get_asignaturaId($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
    tblp_asignacion.FecIni,
    tblp_asignacion.FecFin,
    tblp_asignacion.Plantel,
    tblp_asignacion.Salon,
    tblp_asignacion.HraDia,
    tblp_asignacion.HraSemana,
    tblp_asignacion.IdEstatus,
    tblp_asignacion.Curso,
    tblp_asignacion.IdUsua,
    tblp_asignacion.contrato,
    tblp_modulo.Grado,
    tblp_modulo.NombreMod,
    tblp_modulo.Oferta,
    tblc_ciclo.Ciclo AS Periodo,
    tblc_estatus.Estatus,
    tblp_asignacion.IdAsignacion,
    tblc_ciclo.MesIni,
    tblc_ciclo.MesFin,
    tblc_ciclo.FFinal,
    tblp_grupo.IdGrupo,
    tblp_grupo.CveGrupo,
    tblp_grupo.Turno,
    tblp_grupo.Grupo,
    tblp_grupo.Modalidad,
    tblp_grupo.IdCampus,
    tblp_asignacion.IdEducativa,
    tblp_asignacion.IdModulo,
    tblc_ciclo.Tipo,
    tblp_educativa.Nombre,
    tblc_grado._Grado,
    tblc_usuario.Nombre AS NomDocente,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno
    FROM
    tblp_asignacion
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
    Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'
");
    while ($x = $db->recorrer($sql)) {
      $gAsigId[] = $x;
    }
    return $gAsigId;
  }

  public function get_validar_mat_doc($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();

    $sql1 = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.IdUsua =  '$IdUsua' ");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $IdModx = $datos2["IdAsignacion"];
    if (!$IdModx) {
      header("Location:miPortal.php?toks=9");
    }
  }



  public function get_datosId($IdAsignacion)
  {
    $db = new Conexion();
    $sql_usc = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.IdEstatus FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' AND tblc_usuario.IdEstatus =  '24' ");
    while ($usy = $db->recorrer($sql_usc)) {
      $_idUs = $usy['IdUsua'];
      $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$_idUs'");
      $insertar = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdUsua = '$_idUs' ");
      $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$_idUs' ");
      $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$_idUs' AND tblp_pagos.IdEstatus <> '4'");
    }

    $sql = $db->query("SELECT
      tblp_asignacion.IdAsignacion,
      tblp_asignacion._texto,
      tblp_asignacion.IdCiclo,
      tblp_asignacion.IdGrupo,
tblp_asignacion.NoParcial,
tblc_campus.Campus,
tblp_educativa.Nombre,
tblp_educativa.IdGrado,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Objetivo,
tblp_modulo.Contenido,
tblp_modulo.Mod_3,
tblp_modulo.Mod_4,
tblp_modulo.Mod_5,
tblp_modulo.Mod_6,
tblp_modulo.Mod_7,
tblp_asignacion.Fondo
FROM
tblp_asignacion
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo = '2'
  ");
    while ($x = $db->recorrer($sql)) {
      $get_datosId[] = $x;
    }
    return $get_datosId;
  }

  public function get_asignaturaIdRev($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.Plantel,
tblp_asignacion.Salon,
tblp_asignacion.HraDia,
tblp_asignacion.HraSemana,
tblp_asignacion.IdEstatus,
tblp_asignacion.Curso,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblp_modulo.Oferta,
tblc_abreviatura.Abreviatura,
tblc_ciclo.Ciclo AS Periodo,
tblc_estatus.Estatus,
tblp_asignacion.IdAsignacion,
tblc_ciclo.MesIni,
tblc_ciclo.MesFin,
tblc_ciclo.FFinal,
tblp_modulodatos.Objetivo,
tblp_modulodatos.Introduccion,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Turno,
tblp_grupo.Grupo,
tblp_grupo.Modalidad,
tblp_grupo.IdCampus,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_modulodatos.IdDatosM,
tblc_ciclo.Tipo,
tblp_educativa.Nombre
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
Left Join tblp_modulodatos ON tblp_modulodatos.IdEducativa = tblp_asignacion.IdEducativa AND tblp_modulodatos.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'
");
    while ($x = $db->recorrer($sql)) {
      $gAsigId[] = $x;
    }
    return $gAsigId;
  }

  public function get_parciales($IdOferta, $IdModulo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_parcial WHERE tblp_parcial.IdOferta = '$IdOferta' AND tblp_parcial.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $getParciales[] = $x;
    }
    return $getParciales;
  }

  public function get_costoPlane($IdPlaneacion)
  {
    $db = new Conexion();
    $get_costoPlane = [];
    $sql = $db->query("SELECT
tblp_planeacion.IdPlaneacion,
tblp_planeacion.IdAsignacion,
tblp_planeacion.IdUsua,
tblp_planeacion.Folio,
tblp_planeacion.Planeacion,
tblp_planeacion.FecAsignacion,
tblp_planeacion.FecAprobado,
tblp_planeacion.IdUsuaAprob,
tblp_planeacion.Costo,
tblp_planeacion.IdUsuaCosto,
tblp_planeacion.IdEstatus,
tblp_planeacion.FecCosto,
tblp_planeacion.Extra1,
tblp_planeacion.Extra2,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_planeacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_planeacion.IdUsuaAprob
 WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");
    while ($x = $db->recorrer($sql)) {
      $get_costoPlane[] = $x;
    }
    return $get_costoPlane;
  }

  public function get_costoPlaneDoc($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();
    $get_costoPlaneDoc = [];
    $sql = $db->query("SELECT
tblp_planeacion.IdPlaneacion,
tblp_planeacion.IdAsignacion,
tblp_planeacion.IdUsua,
tblp_planeacion.Folio,
tblp_planeacion.Planeacion,
tblp_planeacion.FecAsignacion,
tblp_planeacion.FecAprobado,
tblp_planeacion.IdUsuaAprob,
tblp_planeacion.Costo,
tblp_planeacion.IdUsuaCosto,
tblp_planeacion.FecCosto,
tblp_planeacion.IdEstatus,
tblp_planeacion.Intentos,
tblp_planeacion.Extra1,
tblp_planeacion.Extra2,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_planeacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_planeacion.IdUsuaAprob
 WHERE tblp_planeacion.IdAsignacion = '$IdAsignacion' AND tblp_planeacion.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_costoPlaneDoc[] = $x;
    }
    return $get_costoPlaneDoc;
  }


  public function get_temasPlan($IdPlan)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_plantemas WHERE tblp_plantemas.IdPlan = '$IdPlan'");
    while ($x = $db->recorrer($sql)) {
      $getPlanCtemas[] = $x;
    }
    return $getPlanCtemas;
  }

  public function get_panGral($IdPlan)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_plan.Modalidad,
tblp_plan.Dia,
tblp_plan.Generacion,
tblp_plan.Objetivo,
tblc_ciclo.Ciclo,
tblc_ciclo.Tipo
FROM
tblp_plan
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_plan.IdCiclo WHERE tblp_plan.IdPlan = '$IdPlan'");
    while ($x = $db->recorrer($sql)) {
      $getPlanCtemsaDs[] = $x;
    }
    return $getPlanCtemsaDs;
  }

  public function get_lstSum1($IdUsua)
  {
    $db = new Conexion();
    $get_lstSum1 = [];
    $sql = $db->query("SELECT Count(tblc_campus.IdCampus) AS Total FROM tblc_campus WHERE tblc_campus.id_usua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_lstSum1[] = $x;
    }
    return $get_lstSum1;
  }

  public function get_lstSum2($IdUsua)
  {
    $db = new Conexion();
    $get_lstSum2 = [];
    $sql = $db->query("SELECT Count(tblp_educativa.IdEducativa) AS Total FROM tblp_educativa Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_educativa.IdEducativa WHERE tblp_educativa.id_usua =  '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_lstSum2[] = $x;
    }
    return $get_lstSum2;
  }

  public function get_lstSum4($IdUsua)
  {
    $db = new Conexion();
    $get_lstSum4 = [];
    $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.id_usua =  '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_lstSum4[] = $x;
    }
    return $get_lstSum4;
  }

  public function get_lstSum5($IdUsua)
  {
    $db = new Conexion();
    $get_lstSum5 = [];
    $sql = $db->query("SELECT Count(tblc_ciclo.IdCiclo) AS Total FROM tblc_ciclo WHERE tblc_ciclo.id_usua =  '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_lstSum5[] = $x;
    }
    return $get_lstSum5;
  }

  public function get_lst_Use($IdUsua, $IdEstatus)
  {
    $db = new Conexion();
    $get_lst_Use = [];
    $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.id_usua =  '$IdUsua' AND tblc_usuario.IdEstatus = '$IdEstatus' ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_Use[] = $x;
    }
    return $get_lst_Use;
  }

  public function get_lst_MatA($IdUsua, $IdEstatus)
  {
    $db = new Conexion();
    $get_lst_MatA = [];
    $sql = $db->query("SELECT Count(tblp_asignacion.IdAsignacion) AS Total FROM tblp_asignacion WHERE tblp_asignacion.IdUsua =  '$IdUsua' AND tblp_asignacion.IdEstatus = '$IdEstatus' ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_MatA[] = $x;
    }
    return $get_lst_MatA;
  }

  public function get_asignaPlan($IdTema)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_planasignatura.IdAsignatura
FROM
tblp_planasignatura
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_planasignatura.IdModulo
WHERE tblp_planasignatura.IdTema = '$IdTema'");
    while ($x = $db->recorrer($sql)) {
      $getTemasS[] = $x;
    }
    return $getTemasS;
  }

  public function get_etapaPlan($IdTema)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_planetapa WHERE tblp_planetapa.IdTema = '$IdTema' ORDER BY tblp_planetapa.Etapa ASC");
    while ($x = $db->recorrer($sql)) {
      $getTemasES[] = $x;
    }
    return $getTemasES;
  }



  public function get_chatId($IdPlaneacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT Count(tblh_chatplaneacion.IdChatPlaneacion) AS sumChat FROM tblh_chatplaneacion WHERE tblh_chatplaneacion.IdPlaneacion = '$IdPlaneacion'");
    while ($x = $db->recorrer($sql)) {
      $getPlanChat[] = $x;
    }
    return $getPlanChat;
  }

  public function get_horario($IdAsignacion)
  {
    $db = new Conexion();
    $getHorario = [];
    
    $sql = $db->query("SELECT
tblp_horario.IdHorario,
tblp_horario.HraIni,
tblp_horario.MinIni,
tblp_horario.HraFin,
tblp_horario.MinFin,
tblp_horario.Total,
tblc_dia.Dia
FROM
tblp_horario
Inner Join tblc_dia ON tblc_dia.IdDia = tblp_horario.IdDia
WHERE
tblp_horario.IdAsignacion =  '$IdAsignacion' AND
tblp_horario.HraIni IS NOT NULL
");
    while ($x = $db->recorrer($sql)) {
      $getHorario[] = $x;
    }
    return $getHorario;
  }


  public function get_parcialDocente($IdOferta, $IdModulo, $IdAsignacion)
  {
    $db = new Conexion();

    $getParcialDoc = [];
    $sql = $db->query("SELECT
tblp_parcialdocente.IdParcialDocente,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Titulo,
tblp_parcialdocente.Tema,
tblp_parcialdocente.Objetivo,
tblp_parcialdocente.FecCap,
tblp_parcialdocente.IdUsua,
tblp_parcialdocente.IdEstatus,
tblp_parcialdocente.Bimestre,
tblp_parcialdocente.IdGrupo,
tblp_parcialdocente.IdCiclo,
tblp_parcialdocente.IdAsignacion,
tblp_parcialdocente.Tipo,
tblp_parcialdocente.FecIni,
tblp_parcialdocente.FecFin,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo
FROM
tblp_parcialdocente
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_parcialdocente.IdUsua WHERE tblp_parcialdocente.IdOferta = '$IdOferta' AND tblp_parcialdocente.IdModulo = '$IdModulo' AND tblp_parcialdocente.IdAsignacion = '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC");
    while ($x = $db->recorrer($sql)) {
      $getParcialDoc[] = $x;
    }
    return $getParcialDoc;
  }

  public function get_semanadocente($IdParcial, $IdModulo)
  {
    $db = new Conexion();
    $getSemanaDoc = [];
    $sql = $db->query("SELECT
tblp_semanadocente.IdSemanaDocente,
tblp_semanadocente.IdOferta,
tblp_semanadocente.IdModulo,
tblp_semanadocente.IdParcialDocente,
tblp_semanadocente.Etiqueta_semana,
tblp_semanadocente.NoSemana,
tblp_semanadocente.Temas,
tblp_semanadocente.FecCap,
tblp_semanadocente.IdUsua,
tblp_semanadocente.Semana,
tblp_semanadocente.Tematica,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo
FROM
tblp_semanadocente
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_semanadocente.IdUsua
WHERE tblp_semanadocente.IdParcialDocente = '$IdParcial' AND tblp_semanadocente.IdModulo = '$IdModulo' ORDER BY tblp_semanadocente.NoSemana ASC");
    while ($x = $db->recorrer($sql)) {
      $getSemanaDoc[] = $x;
    }
    return $getSemanaDoc;
  }

  public function get_fuenteSemana($IdSemanaDoc)
  {
    $db = new Conexion();
    $getSemanaDocF = [];
    $sql = $db->query("SELECT * FROM tblp_fuentedocente WHERE tblp_fuentedocente.IdSemanaDocente = '$IdSemanaDoc'");
    while ($x = $db->recorrer($sql)) {
      $getSemanaDocF[] = $x;
    }
    return $getSemanaDocF;
  }


  public function get_fuentedocente($IdParcial, $IdSemanaDoc)
  {
    $db = new Conexion();
    $getFuenteDoc = [];
    $sql = $db->query("SELECT
tblp_fuentedocente.IdFuente,
tblp_fuentedocente.IdOferta,
tblp_fuentedocente.IdModulo,
tblp_fuentedocente.IdParcialDocente,
tblp_fuentedocente.IdSemanaDocente,
tblp_fuentedocente.Fuente,
tblp_fuentedocente.FecCap,
tblp_fuentedocente.IdUsua,
tblp_fuentedocente.IdAsignacion,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo
FROM
tblp_fuentedocente
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_fuentedocente.IdUsua WHERE tblp_fuentedocente.IdParcialDocente = '$IdParcial' AND tblp_fuentedocente.IdSemanaDocente = '$IdSemanaDoc'");
    while ($x = $db->recorrer($sql)) {
      $getFuenteDoc[] = $x;
    }
    return $getFuenteDoc;
  }

  public function get_avanceParcial($IdAsignacion, $IdParcial)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblp_actividadesdocente.Porcentaje) AS Avance FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdParcialDocente = '$IdParcial' ");
    while ($x = $db->recorrer($sql)) {
      $getAvanceP[] = $x;
    }
    return $getAvanceP;
  }

  public function get_actividadSemDoc($IdParcial, $IdSemana)
  {
    $db = new Conexion();
    $getActividadesSemD = [];

    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.IdEstatus,
tblp_actividadesdocente.IdPlan,
tblp_actividadesdocente.IdTema,
tblp_actividadesdocente.IdEtapa,
tblp_actividadesdocente.Modalidad,
tblp_actividadesdocente.Mostrar,
tblp_actividadesdocente.Estrategia,
tblp_actividadesdocente.Tecnica,
tblp_actividadesdocente.Herramienta,
tblc_tipoactividad.IdTipoActividad,
tblc_tipoactividad.TipoActividad,
tblc_estatus.Estatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblp_actividadesdocente.FecCap
FROM
tblp_actividadesdocente
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_actividadesdocente.IdUsua WHERE tblp_actividadesdocente.IdParcialDocente = '$IdParcial' AND tblp_actividadesdocente.IdSemanaDocente = '$IdSemana' ORDER BY tblp_actividadesdocente.FecIni ASC");

    while ($x = $db->recorrer($sql)) {
      $getActividadesSemD[] = $x;
    }
    return $getActividadesSemD;
  }

  public function get_etapTemas($IdPlan, $IdTema, $IdEtapa)
  {
    $db = new Conexion();


    $sql = $db->query("SELECT
tblp_plantemas.Tema,
tblp_plantemas.Complejidad,
tblp_planetapa.Etapa,
tblp_planetapa.IdEtapa
FROM
tblp_planetapa
Left Join tblp_plantemas ON tblp_plantemas.IdTema = tblp_planetapa.IdTema AND tblp_plantemas.IdPlan = tblp_planetapa.IdPlan
WHERE tblp_planetapa.IdEtapa = '$IdEtapa' AND tblp_planetapa.IdTema = '$IdTema' AND tblp_planetapa.IdPlan = '$IdPlan'");

    while ($x = $db->recorrer($sql)) {
      $getPlanEt[] = $x;
    }
    return $getPlanEt;
  }


  public function get_actividadSemAlum($IdParcial, $IdSemana)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdActividades, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.DesActividad, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Modalidad, tblp_actividadesdocente.Porcentaje, tblp_actividadesdocente.Mostrar, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin, tblc_tipoactividad.IdTipoActividad, tblc_tipoactividad.TipoActividad, tblc_estatus.IdEstatus,tblc_estatus.Estatus FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus WHERE tblp_actividadesdocente.IdParcialDocente = '$IdParcial' AND tblp_actividadesdocente.IdSemanaDocente = '$IdSemana' AND tblp_actividadesdocente.IdEstatus <> '12'");
    while ($x = $db->recorrer($sql)) {
      $getActividadesSemD[] = $x;
    }
    return $getActividadesSemD;
  }

  public function get_parcialActivo($IdAsignacion)
  {
    $db = new Conexion();
    $get_parcialActivo = [];
    $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo = 'P' ORDER BY tblp_parcialdocente.NoParcial ASC");
    while ($x = $db->recorrer($sql)) {
      $get_parcialActivo[] = $x;
    }
    return $get_parcialActivo;
  }

  public function get_parcial_cal($IdAsignacion)
  {
    $db = new Conexion();
    $get_parcialActivo = [];
    $sql = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.Titulo FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo = 'P' ORDER BY tblp_parcialdocente.NoParcial ASC");
    while ($x = $db->recorrer($sql)) {
      $get_parcialActivo[] = $x;
    }
    return $get_parcialActivo;
  }

  public function get_activo_extra($IdAsignacion, $NoParcial)
  {
    $db = new Conexion();

    $get_activoExtra1 = [];
    $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdEstatus = '4' AND tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo = 'E' AND tblp_parcialdocente.NoParcial = '$NoParcial' ORDER BY tblp_parcialdocente.NoParcial ASC");
    while ($x = $db->recorrer($sql)) {
      $get_activoExtra1[] = $x;
    }
    return $get_activoExtra1;
  }



  public function get_calendarioPag($IdGrado, $IdCiclo, $IdConceptoPlan)
  {
    $db = new Conexion();
    $get_calendarioPag = [];

    $sql = $db->query("SELECT
tblp_calendario.IdCalendario,
tblp_calendario.IdGrado,
tblp_calendario.IdConceptosPlanes,
tblp_calendario.FecDescuento,
tblp_calendario.FecBase,
tblp_calendario.Monto,
tblc_conceptosplanes.NomPlan,
tblc_conceptosplanes.Recargo,
tblp_calendario.FecLimite,
tblp_calendario.IdCampus,
tblc_campus.Campus
FROM
tblp_calendario
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes Left Join tblc_campus ON tblc_campus.IdCampus = tblp_calendario.IdCampus
WHERE
tblp_calendario.IdGrado =  '$IdGrado' AND
tblp_calendario.IdCiclo =  '$IdCiclo' AND
tblp_calendario.IdConceptosPlanes =  '$IdConceptoPlan' ");
    while ($x = $db->recorrer($sql)) {
      $get_calendarioPag[] = $x;
    }
    return $get_calendarioPag;
  }

  public function get_extraActivo($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $getExtracAct[] = $x;
    }
    return $getExtracAct;
  }

  public function get_extraAct1($IdAsignacion, $IdEducativa, $IdModulo, $NoParcial)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.IdOferta = '$IdEducativa' AND tblp_parcialdocente.IdModulo = '$IdModulo' AND tblp_parcialdocente.Tipo = 'E' AND tblp_parcialdocente.NoParcial = '$NoParcial'");
    while ($x = $db->recorrer($sql)) {
      $getExtracAct1[] = $x;
    }
    return $getExtracAct1;
  }

  # OBTENER LA LISTA DE MODULO SEGUN LA OFERTA EDUCTIVA
  // public function get_prospectosEduc($Oferta,$fecha1,$fecha2) {
  public function get_prospectosEduc($Oferta, $tipoBusqueda)
  {
    if ($Oferta) {
      $db = new Conexion();
      if ($tipoBusqueda == "SI") {
        $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$Oferta'");
        $db->rows($sql9);
        $datos91 = $db->recorrer($sql9);
        $IdGrado = $datos91['IdGrado'];

        $sql8 = $db->query("SELECT Sum(tblc_tipodocumento.Grado$IdGrado) FROM tblc_tipodocumento WHERE tblc_tipodocumento.Grado$IdGrado = '1'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $noDocs = $datos81[0] - 1;
        $condBusqueda = " AND tblc_usuario.NoDoc >= '$noDocs' ";
      } else {
        $condBusqueda = "";
      }

      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.FecCap, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Visto FROM tblc_usuario WHERE tblc_usuario.IdOferta = '$Oferta' AND tblc_usuario.Tipo =  '3' AND tblc_usuario.Code IS NOT NULL  AND tblc_usuario.IdGrupo IS NULL AND tblc_usuario.Documentos = 'NO' $condBusqueda ");
      while ($x = $db->recorrer($sql)) {
        $gprospectoId[] = $x;
      }
      return $gprospectoId;
    }
  }

  public function get_prospectosMod($Oferta, $fecha1, $fecha2)
  {
    $db = new Conexion();
    if ($Oferta == 9999) {
      $condOf = "";
    } else {
      $condOf = " tblc_usuario.IdOferta =  '$Oferta' AND ";
    }
    if ($fecha1 && $fecha2) {
      $condF = " AND tblc_usuario.FecCap BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59'";
    }
    if ($Oferta) {
      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.FecCap, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Visto, tblc_usuario.NoDoc, tblp_educativa.IdEducativa, tblp_educativa.Nombre AS NomEducativa FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE  $condOf tblc_usuario.Tipo =  '3' AND tblc_usuario.Documentos =  'NO' $condF");
      while ($x = $db->recorrer($sql)) {
        $gpropestNew[] = $x;
      }
      return $gpropestNew;
    }
  }

  public function get_listNoDoc($IdOferta)
  {
    if ($IdOferta) {
      $db = new Conexion();
      $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdGrado = $datos91['IdGrado'];

      $sql = $db->query("SELECT Sum(tblc_tipodocumento.Grado$IdGrado) FROM tblc_tipodocumento WHERE tblc_tipodocumento.Grado3 IS NOT NULL ");
      while ($x = $db->recorrer($sql)) {
        $gNoDocs[] = $x;
      }
      return $gNoDocs;
    }
  }

  public function get_estatusDocs($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gEstatusDCs[] = $x;
    }
    return $gEstatusDCs;
  }

  public function get_listaDocs($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.IdUsua, tblc_docalumnos.IdTipoDocumento, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua =  '$IdUsua' GROUP BY tblc_docalumnos.IdTipoDocumento ORDER BY tblc_tipodocumento.NomDocumento ASC");
    while ($x = $db->recorrer($sql)) {
      $gListaDCs[] = $x;
    }
    return $gListaDCs;
  }

  public function get_addVisto($Oferta, $IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblc_usuario  SET tblc_usuario.Visto = '0' WHERE tblc_usuario.IdOferta = '$Oferta' AND tblc_usuario.IdUsua = '$IdUsua'");
    $db->close();
  }

  # OBTENER LA LISTA DE MODULO SEGUN LA OFERTA EDUCTIVA
  public function get_verificarPagos($Oferta, $IdConcepto, $IdCiclo, $IdGrupo)
  {
    $db = new Conexion();
    if ($IdConcepto) {
      $condC = " AND tblp_pagos.IdConcepto = '$IdConcepto' ";
    } else {
      $condC = "";
    }
    if ($IdCiclo) {
      $condCE = " AND tblp_pagos.IdCiclo = '$IdCiclo' ";
    } else {
      $condCE = "";
    }
    if ($IdGrupo) {
      $condG = " AND tblp_pagos.IdGrupo = '$IdGrupo' ";
    } else {
      $condG = "";
    }
    if ($Oferta) {
      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblp_pagos.IdPago, tblp_pagos.Pagar, tblp_pagos.Referencia,  tblp_pagos.FecLimPago, tblp_pagos.IdEstatus, tblp_pagos.Recargos, tblc_conceptos.NomConcepto, tblh_detallepagos.Archivo, tblh_detallepagos.FecCap, tblh_detallepagos.Estatus AS DetEstatus, tblh_detallepagos.Visto, tblp_pagos.FecCap AS FecCapP, tblc_estatus.Estatus, tblp_pagos.IdTipoDescuento, tblp_pagos.IdDescuento FROM tblc_usuario Left Join tblp_pagos ON tblp_pagos.IdUsua = tblc_usuario.IdUsua Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblh_detallepagos ON tblh_detallepagos.IdUsua = tblp_pagos.IdUsua AND tblh_detallepagos.IdPago = tblp_pagos.IdPago Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus WHERE tblc_usuario.IdOferta =  '$Oferta' AND tblp_pagos.IdEstatus <> 4 $condCE $condG  $condC");
      while ($x = $db->recorrer($sql)) {
        $gPagosId[] = $x;
      }
      return $gPagosId;
    }
  }

  public function get_reportPagos($IdCampus, $IdOferta, $IdCiclo, $IdConcepto)
  {
    $db = new Conexion();
    if (($IdCampus) && ($IdOferta) && ($IdCiclo) && ($IdConcepto)) {
      // if($IdConcepto){ $condC = " AND tblp_pagos.IdConcepto = '$IdConcepto' "; } else { $condC = ""; }
      // if($IdCiclo){ $condCE = " AND tblp_pagos.IdCiclo = '$IdCiclo' "; } else { $condCE = ""; }
      // if($IdGrupo){ $condG = " AND tblp_pagos.IdGrupo = '$IdGrupo' "; } else { $condG = ""; }
      // if($Oferta){
      $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.IdPago,
tblp_foliospago.Estatus,
tblp_foliospago.FecCap,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblp_foliospago.Folio,
tblp_foliospago.IdUsua,
tblp_foliospago.IdEstatus,
tblp_foliospago.IdForma,
tblp_pagos.IdCiclo,
tblp_pagos.IdOferta,
tblc_formapago.Descripcion,
tblp_pagos.IdConceptoPlan,
tblp_pagos._img,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
WHERE tblp_foliospago.IdEstatus = '4' AND tblp_pagos.IdCiclo = '$IdCiclo' AND tblp_pagos.IdOferta = '$IdOferta' AND tblp_pagos.IdConceptoPlan = '$IdConcepto' AND tblp_pagos.IdCampus = '$IdCampus'");
      while ($x = $db->recorrer($sql)) {
        $gPagosId[] = $x;
      }
      return $gPagosId;
    }
  }



  public function get_reportPagosB($IdBanco, $Oferta, $IdConcepto, $IdCiclo, $IdGrupo)
  {
    $db = new Conexion();
    if ($IdConcepto) {
      $condC = " AND tblp_pagos.IdConcepto = '$IdConcepto' ";
    } else {
      $condC = "";
    }
    if ($IdCiclo) {
      $condCE = " AND tblp_pagos.IdCiclo = '$IdCiclo' ";
    } else {
      $condCE = "";
    }
    if ($IdGrupo) {
      $condG = " AND tblp_pagos.IdGrupo = '$IdGrupo' ";
    } else {
      $condG = "";
    }
    if ($Oferta) {
      $condO = " AND tblp_pagos.IdOferta = '$Oferta' ";
    } else {
      $condO = "";
    }
    if ($IdBanco) {

      $sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.TotalPagado,
tblp_pagos.FecPago,
tblc_bancos.Banco,
tblc_conceptos.NomConcepto,
tblp_educativa.Nombre AS NomEducativa,
tblp_pagos.Referencia,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_formapago.Descripcion,
tblc_ciclo.Ciclo
FROM
tblp_pagos
Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_pagos.IdBanco
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_pagos.IdFormaPago
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
WHERE
tblp_pagos.IdEstatus =  '4' AND tblp_pagos.IdBanco = '$IdBanco' $condCE $condC $condG $condO
");
      while ($x = $db->recorrer($sql)) {
        $gPagosId[] = $x;
      }
      return $gPagosId;
    }
  }

  public function get_descuentoXa($IdDescuento)
  {
    if ($IdDescuento) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblp_descuento.IdDescuento, tblp_descuento.IdPago, tblp_descuento.IdTipoDescuento, tblp_descuento.Porcentaje, tblp_descuento.TotalPagar, tblp_descuento.Descuento, tblp_descuento.FecDescuento, tblp_descuento.FecCap, tblp_descuento.Estatus, tblc_tipodescuento.NomDescuento FROM tblp_descuento Inner Join tblc_tipodescuento ON tblc_tipodescuento.IdTipoDescuento = tblp_descuento.IdTipoDescuento WHERE tblp_descuento.IdDescuento = '$IdDescuento' AND tblp_descuento.Estatus = '8'");
      while ($x = $db->recorrer($sql)) {
        $gDescuentoId[] = $x;
      }
      return $gDescuentoId;
    }
  }

  public function get_verificarPagosId($IdUsua)
  {
    $db = new Conexion();

    //$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblp_pagos.IdPago, tblp_pagos.Pagar,  tblp_pagos.FecLimPago, tblp_pagos.IdEstatus, tblp_pagos.FecPago, tblp_pagos.Recargos,tblp_pagos.IdDescuento, tblc_conceptos.NomConcepto, tblh_detallepagos.Archivo, tblh_detallepagos.FecCap, tblh_detallepagos.Estatus AS DetEstatus, tblp_pagos.FecCap AS FecCapP, tblc_estatus.Estatus, tblp_pagos.IdTipoDescuento,  tblp_pagos.TotalPagado FROM tblc_usuario Left Join tblp_pagos ON tblp_pagos.IdUsua = tblc_usuario.IdUsua Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblh_detallepagos ON tblh_detallepagos.IdUsua = tblp_pagos.IdUsua AND tblh_detallepagos.IdPago = tblp_pagos.IdPago Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus WHERE tblc_usuario.IdOferta =  '$Oferta' AND tblp_pagos.IdUsua =  '$IdUsua'");
    $sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Pagar,
tblp_pagos.IdEstatus,
tblp_pagos.FecPago,
tblp_pagos.Recargos,
tblp_pagos.IdDescuento,
tblc_conceptos.NomConcepto,
tblc_estatus.Estatus,
tblp_pagos.IdTipoDescuento,
tblp_pagos.TotalPagado,
tblc_bancos.Banco
FROM
tblp_pagos
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Inner Join tblc_bancos ON tblc_bancos.IdBanco = tblp_pagos.IdBanco
WHERE tblp_pagos.IdUsua =  '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gPagosIdX[] = $x;
    }
    return $gPagosIdX;
  }

  public function get_descuento($IdDescuento)
  {
    if ($IdDescuento) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblp_descuento.IdDescuento, tblp_descuento.IdPago, tblp_descuento.IdTipoDescuento, tblp_descuento.Porcentaje, tblp_descuento.TotalPagar, tblp_descuento.Descuento, tblp_descuento.FecDescuento, tblp_descuento.FecCap, tblp_descuento.Estatus, tblc_tipodescuento.NomDescuento FROM tblp_descuento Left Join tblc_tipodescuento ON tblc_tipodescuento.IdTipoDescuento = tblp_descuento.IdTipoDescuento WHERE tblp_descuento.IdDescuento = '$IdDescuento' AND tblp_descuento.Estatus='8'");
      while ($x = $db->recorrer($sql)) {
        $gDescuentoId[] = $x;
      }
      return $gDescuentoId;
    }
  }

  # OBTENER LA LISTA DE MODULO SEGUN LA OFERTA EDUCTIVA
  public function get_grupoCreado($IdPermiso)
  {
    if ($IdPermiso == 1) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Grupo FROM tblp_grupo WHERE tblp_grupo.Estatus =  'Activo' AND tblp_grupo.Tipo =  'Abierto'");
      while ($x = $db->recorrer($sql)) {
        $gCrearGrupo[] = $x;
      }
      return $gCrearGrupo;
    }
  }

  public function get_lstCanlendario($Grado)
  {
    if ($Grado) {
      $db = new Conexion();


      $sql = $db->query("SELECT
tblp_calendario.IdCalendario,
tblp_calendario.FecDescuento,
tblp_calendario.FecBase,
tblp_calendario.FecLimite,
tblp_calendario.Monto,
tblp_calendario.FecCap,
tblc_conceptosplanes.NomPlan,
tblc_estatus.Estatus
FROM
tblp_calendario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_calendario.IdEstatus
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes
WHERE tblp_calendario.IdGrado = '$Grado'");
      while ($x = $db->recorrer($sql)) {
        $gCalendari[] = $x;
      }
      return $gCalendari;
    }
  }
  public function get_lstCanlendarioGrp($Grado, $IdCiclo, $IdGrupo)
  {
    if (($Grado) && ($IdCiclo) && ($IdGrupo)) {
      $db = new Conexion();
      $sql = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblp_calendario.FecBase, tblp_calendario.FecLimite, tblp_calendario.Monto, tblp_calendario.FecCap, tblc_conceptosplanes.NomPlan, tblc_estatus.Estatus
FROM
tblp_calendario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_calendario.IdEstatus
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes
WHERE tblp_calendario.IdGrado = '$Grado' AND tblp_calendario.IdCiclo = '$IdCiclo' AND tblp_calendario.IdGrupo = '$IdGrupo' ");
      while ($x = $db->recorrer($sql)) {
        $gCalendarigRP[] = $x;
      }
      return $gCalendarigRP;
    }
  }


  public function get_grupoCreadoCoord($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_coordinador.IdCoordinador, tblp_grupo.CveGrupo, tblp_grupo.Grupo, tblp_grupo.IdGrupo FROM tblp_coordinador Left Join tblp_grupo ON tblp_grupo.IdOferta = tblp_coordinador.IdOferta WHERE tblp_coordinador.IdUsua =  '$IdUsua' AND tblp_coordinador.IdEstatus =  '8' AND tblp_grupo.Estatus =  'Activo' AND tblp_grupo.Tipo =  'Abierto'");
    while ($x = $db->recorrer($sql)) {
      $gCrearGrupo[] = $x;
    }
    return $gCrearGrupo;
  }

  public function get_grupoNuevo($IdOferta, $IdCampus)
  {
    $db = new Conexion();
    $get_grupoNuevo = [];

    $sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Estatus,
tblp_grupo.Tipo,
tblp_grupo.Turno,
tblp_grupo.Oferta,
tblp_grupo.Grupo,
tblp_grupo.Modalidad,
tblp_grupo.IdCampus,
tblp_grupo.IdGrado,
tblp_grupo.IdOferta,
tblp_grupo.Dia,
tblp_grupo.IdPlan,
tblp_grupo.Anio,
tblp_grupo.TipoCiclo,
tblp_grupo.Nivel,
tblp_grupo.FecCap,
tblp_grupo.Periodo,
tblp_grupo.IdEstatus,
tblp_grupo.IdCicloIni,
tblp_grupo.Disponible,
tblp_grupo.FechaIni,
tblp_grupo.FechaFin,
tblp_grupo.Grado,
tblc_ciclo.Ciclo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblp_grupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_grupo.IdCicloIni Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia WHERE tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCampus= '$IdCampus' AND tblp_grupo.IdEstatus = '12'");
    while ($x = $db->recorrer($sql)) {
      $get_grupoNuevo[] = $x;
    }
    return $get_grupoNuevo;
  }



  public function get_alumnosProcess($IdUsua)
  {
    $db = new Conexion();



    $gAlumProcss = [];
    //echo "SELECT tblh_temporal.IdTemporal, tblh_temporal.Nombre, tblh_temporal.APaterno, tblh_temporal.AMaterno, tblh_temporal.Oferta, tblh_temporal.IdExcel, tblh_temporal.Usuario, tblh_temporal.IdEstatus, tblh_temporal.Pass, tblh_temporal.Sexo, tblc_campus.IdCampus, tblc_campus.Campus, tblc_campus.Letra FROM tblh_temporal Left Join tblc_campus ON tblc_campus.IdCampus = tblh_temporal.Campus WHERE tblh_temporal.IdUsua = '$IdUsua'";
    $sql = $db->query("SELECT
tblh_temporal.IdTemporal,
tblh_temporal.Nombre,
tblh_temporal.APaterno,
tblh_temporal.AMaterno,
tblh_temporal.Usuario,
tblh_temporal.IdEstatus,
tblh_temporal.Oferta,
tblh_temporal.Sexo,
tblh_temporal.Correo,
tblh_temporal.Correo_ins,
tblh_temporal.Cel,
tblh_temporal.Nac,
tblc_campus.IdCampus,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa
FROM
tblh_temporal
Left Join tblc_campus ON tblc_campus.IdCampus = tblh_temporal.Campus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblh_temporal.Oferta WHERE tblh_temporal.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gAlumProcss[] = $x;
    }
    return $gAlumProcss;
  }

  public function get_pagos_process($IdUsua)
  {
    $db = new Conexion();
    $get_pagos_process = [];
    $sql = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_pagos_process[] = $x;
    }
    return $get_pagos_process;
  }

  public function get_usersProcess($IdUsua)
  {
    $db = new Conexion();
    $get_usersProcess = [];



    $sql = $db->query("SELECT
tblh_temusers.IdTemporal,
tblh_temusers.Nombre,
tblh_temusers.APaterno,
tblh_temusers.AMaterno,
tblh_temusers.Usuario,
tblh_temusers.Pass,
tblh_temusers.Sexo,
tblh_temusers.Correo,
tblh_temusers.Celular,
tblh_temusers.FecNac,
tblc_campus.Campus,
tblc_permiso.Permiso
FROM
tblh_temusers
Left Join tblc_campus ON tblc_campus.IdCampus = tblh_temusers.Campus
Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblh_temusers.Permisos WHERE tblh_temusers.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_usersProcess[] = $x;
    }
    return $get_usersProcess;
  }

  public function get_userslstDoc($IdUsua, $disponible)
  {
    $db = new Conexion();

    $num = 0;

    $sql = $db->query("SELECT tblh_temusers.IdTemporal, tblh_temusers.IdEstatus FROM tblh_temusers WHERE tblh_temusers.IdUsua = '$IdUsua' AND tblh_temusers.IdEstatus = '8'");
    while ($x = $db->recorrer($sql)) {
      $num = ($num + 1);
      if ($num > $disponible) {
        $IdT = $x['IdTemporal'];
        $insertar = $db->query("UPDATE tblh_temusers SET tblh_temusers.IdEstatus = '56' WHERE tblh_temusers.IdTemporal = '$IdT'");
      }
    }

    $get_userslstDoc = [];
    $sql = $db->query("SELECT
tblh_temusers.IdTemporal,
tblh_temusers.Nombre,
tblh_temusers.APaterno,
tblh_temusers.AMaterno,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa,
tblh_temusers.IdEstatus,
tblc_estatus.Estatus
FROM
tblh_temusers
Left Join tblc_campus ON tblc_campus.IdCampus = tblh_temusers.Campus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblh_temusers.Permisos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_temusers.IdEstatus
WHERE tblh_temusers.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_userslstDoc[] = $x;
    }
    return $get_userslstDoc;
  }

  public function get_lstCampus()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_campus");
    while ($x = $db->recorrer($sql)) {
      $gUSERSProcsds[] = $x;
    }
    return $gUSERSProcsds;
  }

  public function get_lstSerie()
  {
    $db = new Conexion();
    $gSerie = [];
    $sql = $db->query("SELECT * FROM tblc_serie");
    while ($x = $db->recorrer($sql)) {
      $gSerie[] = $x;
    }
    return $gSerie;
  }

  public function get_crearGrupo()
  {

    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.FecCap, tblc_usuario.Revalidar, tblp_grupo.CveGrupo, tblp_grupo.Grupo, tblp_grupo.Tipo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE  tblc_usuario.Tipo =  '3'  AND tblc_usuario.Documentos =  'SI'");
    while ($x = $db->recorrer($sql)) {
      $gprospectoId[] = $x;
    }
    return $gprospectoId;
  }

  # OBTENER UN SOLO USUARIO ADMINISTRADOR
  public function get_usuarioId($Id)
  {
    $db = new Conexion();
    $get_usuarioId = [];
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$Id'");
    while ($x = $db->recorrer($sql)) {
      $get_usuarioId[] = $x;
    }
    return $get_usuarioId;
  }

  public function get_userGprId($Id)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_grupo.CveGrupo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$Id'");
    while ($x = $db->recorrer($sql)) {
      $gUsuarsId[] = $x;
    }
    return $gUsuarsId;
  }

  public function get_menu($IdPermisos)
  {
    if ($IdPermisos == 1) {
      $cond = "";
    } else {
      $cond = "AND tblc_menu.Permisos = '0'";
    }
    $db = new Conexion();
    $gMenu = [];
    $sql = $db->query("SELECT * FROM tblc_menu WHERE tblc_menu.IdEstatus = '8' $cond ORDER BY tblc_menu.Tipo ASC");
    while ($x = $db->recorrer($sql)) {
      $gMenu[] = $x;
    }
    return $gMenu;
  }

  public function get_menuId($IdMenu, $IdUsua)
  {
    $db = new Conexion();
    $get_menuId = [];
    $sql = $db->query("SELECT * FROM tblc_menuusuario WHERE tblc_menuusuario.IdMenu = '$IdMenu' AND tblc_menuusuario.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_menuId[] = $x;
    }
    return $get_menuId;
  }

  # OBTENER UN SOLO USUARIO ALUMNO
  public function get_usuarioA($Id)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM  tblc_usuario WHERE tblc_usuario.IdUsua = '$Id'");
    while ($x = $db->recorrer($sql)) {
      $gUsuarioIds[] = $x;
    }
    return $gUsuarioIds;
  }

  # OBTENER LA LISTA DE DOCENTES ACTIVOS
  public function get_Docentes()
  {
    $db = new Conexion();
    $gDocentes = [];
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '2' AND tblc_usuario.IdEstatus= '8' ORDER BY tblc_usuario.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $gDocentes[] = $x;
    }
    return $gDocentes;
  }

  # OBTENER LA LISTA DE TUTORES ACTIVOS
  public function get_Tutores($IdModulo)
  {

    $db = new Conexion();

    $get_Tutores = [];
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdEstatus= '8' AND ((tblc_usuario.Permisos = '9') || (tblc_usuario.Permisos = '5')) ORDER BY tblc_usuario.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_Tutores[] = $x;
    }
    return $get_Tutores;
  }

  # OBTENER LA LISTA MODULOS ASIGANDOS A LOS DOCENTES
  public function get_ModuloAsig($idU)
  {
    $db = new Conexion();
    $get_ModuloAsig = [];
    $sql = $db->query("SELECT
        tblp_asignacion.IdAsignacion,
        tblp_asignacion.IdEducativa,
        tblp_asignacion.IdModulo,
        tblp_asignacion.IdUsua,
        tblp_asignacion.FecIni,
        tblp_asignacion.FecFin,
        tblp_asignacion.Estatus,
        tblp_modulo.CodeModulo,
        tblp_modulo.NombreMod,
        tblp_modulo.NoModulo,
        tblp_modulo.Grado,
        tblp_asignacion.Grupo,
        tblc_abreviatura.Abreviatura,
        tblp_modulo.Oferta,
        tblp_educativa.Color,
        tblp_educativa.Texto,
        tblp_educativa.Nombre AS NomEducativa,
        tblp_grupo.CveGrupo
        FROM
        tblp_asignacion
        Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
        Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
        Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
        Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE IdUsua='$idU' AND ((tblp_asignacion.IdEstatus = '8') || (tblp_asignacion.IdEstatus = '12')) ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_ModuloAsig[] = $x;
    }
    return $get_ModuloAsig;
  }

  public function get_misClases($IdUsua)
  {
    $db = new Conexion();
    $get_misClases = [];

    $sql = $db->query("SELECT
        tblp_asignacion.IdAsignacion,
        tblp_asignacion.IdEducativa,
        tblp_asignacion.IdModulo,
        tblp_asignacion.IdUsua,
        tblp_asignacion.FecIni,
        tblp_asignacion.FecFin,
        tblp_asignacion.contrato,
        tblp_asignacion.aceptado,
        tblp_asignacion.Fondo,
        tblp_modulo.NombreMod,
        tblp_educativa.Nombre AS NomEducativa,
        tblp_grupo.CveGrupo,
        tblc_campus.Campus,
        tblc_usuario.Nombre,
        tblc_usuario.APaterno,
        tblc_usuario.AMaterno,
        tblc_usuario.Foto
        FROM
        tblp_asignacion
        Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
        Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
        Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
         Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.IdUsua='$IdUsua' AND ((tblp_asignacion.IdEstatus = '8') || (tblp_asignacion.IdEstatus = '12')) ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_misClases[] = $x;
    }
    return $get_misClases;
  }

  public function get_mis_clases($IdUsua)
  {
    $db = new Conexion();
    $get_mis_clases = [];

    $sql = $db->query("SELECT
tblp_moduloalumno.IdAsignacion,
tblp_asignacion.Fondo,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_educativa.Nombre AS NomEducativa,
tblp_modulo.NombreMod,
tblc_campus.Campus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblp_grupo.CveGrupo
FROM
tblp_moduloalumno
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' AND tblp_asignacion.IdEstatus = '8' AND tblp_asignacion.Tipo = '2'
 ORDER BY tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_mis_clases[] = $x;
    }
    return $get_mis_clases;
  }


  public function get_modFinalizDoc($idU)
  {
    $db = new Conexion();
    $get_modFinalizDoc = [];
    $sql = $db->query("SELECT
        tblp_asignacion.IdAsignacion,
        tblp_asignacion.IdEducativa,
        tblp_asignacion.IdModulo,
        tblp_asignacion.IdUsua,
        tblp_asignacion.FecIni,
        tblp_asignacion.FecFin,
        tblp_asignacion.Estatus,
        tblp_modulo.CodeModulo,
        tblp_modulo.NombreMod,
        tblp_modulo.NoModulo,
        tblp_modulo.Grado,
        tblp_asignacion.Grupo,
        tblc_abreviatura.Abreviatura,
        tblp_modulo.Oferta,
        tblp_educativa.Color,
        tblp_educativa.Texto,
        tblp_educativa.Nombre AS NomEducativa,
        tblp_grupo.CveGrupo
        FROM
        tblp_asignacion
        Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
        Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
        Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
        Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE IdUsua='$idU' AND tblp_asignacion.IdEstatus = '26' ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_modFinalizDoc[] = $x;
    }
    return $get_modFinalizDoc;
  }

  public function get_matFinDoc($idU)
  {
    $db = new Conexion();
    $get_modFinalizDoc = [];

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.FecFin,
tblp_modulo.NombreMod,
tblp_educativa.Nombre AS NomEducativa,
tblp_grupo.CveGrupo,
tblc_campus.Campus,
tblc_ciclo.Ciclo,
tblp_asignacion.FecIni
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo WHERE tblp_asignacion.IdUsua='$idU' AND tblp_asignacion.IdEstatus = '26' ORDER BY tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_modFinalizDoc[] = $x;
    }
    return $get_modFinalizDoc;
  }

  public function get_ModuloAsigC($idU)
  {
    $db = new Conexion();


    // $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdUsua, tblp_asignacion.FecIni, tblp_asignacion.FecFin, tblp_asignacion.Estatus, tblp_modulo.NombreMod, tblp_educativa.Nombre, tblp_modulo.NoModulo, tblp_modulo.Grado, tblp_educativa.Ciclo, tblp_asignacion.Grupo, tblc_abreviatura.Abreviatura FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado WHERE IdUsua='$idU' ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");

    $sql = $db->query("SELECT
        tblp_asignacion.IdAsignacion,
        tblp_asignacion.IdEducativa,
        tblp_asignacion.IdModulo,
        tblp_asignacion.IdUsua,
        tblp_asignacion.FecIni,
        tblp_asignacion.FecFin,
        tblp_asignacion.Estatus,
        tblp_modulo.NombreMod,
        tblp_modulo.NoModulo,
        tblp_modulo.Grado,
        tblp_asignacion.Grupo,
        tblc_abreviatura.Abreviatura,
        tblp_modulo.Oferta,
        tblp_educativa.Color
        FROM
        tblp_asignacion
        Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
        Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
        Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa  WHERE IdUsua='$idU' AND tblp_asignacion.Curso = '1' ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $gModuloAsig[] = $x;
    }
    return $gModuloAsig;
  }

  # OBTENER deocnte
  public function get_docenteInfo($idU)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT IdUsua FROM tblp_asignacion WHERE IdAsignacion='$idU'");
    while ($x = $db->recorrer($sql)) {
      $gModuloAsigt[] = $x;
    }
    return $gModuloAsigt;
  }

  public function get_userAgregado($IdUsua, $IdModulo, $IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $gAdCurs[] = $x;
    }
    return $gAdCurs;
  }

  # OBTENER LA LISTA MODULOS ASIGANDOS A LOS ALUMNOS
  public function get_ModuloAsigAlum($idU)
  {
    $db = new Conexion();
    $gModuloAsigAlum = [];
    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdModulo,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Grupo,
tblp_moduloalumno.Estatus,
tblp_modulo.NombreMod,
tblp_moduloalumno.IdAsignacion,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.IdEstatus,
tblp_modulo.Grado,
tblc_abreviatura.Abreviatura,
tblp_modulo.CodeModulo,
tblp_modulo.Oferta,
tblc_ciclo.Tipo,
tblp_educativa.Color
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa WHERE tblp_moduloalumno.IdUsua =  '$idU' AND tblp_asignacion.Tipo = '2' AND tblp_asignacion.Curso = '0' AND ((tblp_asignacion.IdEstatus = '8') || (tblp_asignacion.IdEstatus = '12')) ORDER BY tblp_modulo.NombreMod ASC");
    // Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa WHERE tblp_moduloalumno.IdUsua =  '$idU' AND tblp_asignacion.Tipo = '2' AND tblp_asignacion.Curso = '0' AND ((tblp_asignacion.IdEstatus = '8') || (tblp_asignacion.IdEstatus = '12')) ORDER BY tblp_modulo.NombreMod ASC");
    while ($x = $db->recorrer($sql)) {
      $gModuloAsigAlum[] = $x;
    }
    return $gModuloAsigAlum;
  }

  public function get_modFinaAlum($idU)
  {
    $db = new Conexion();
    $get_modFinaAlum = [];
    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdModulo,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Grupo,
tblp_moduloalumno.Estatus,
tblp_modulo.NombreMod,
tblp_moduloalumno.IdAsignacion,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.IdEstatus,
tblp_modulo.Grado,
tblc_abreviatura.Abreviatura,
tblp_modulo.CodeModulo,
tblp_modulo.Oferta,
tblc_ciclo.Tipo,
tblp_educativa.Color
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa WHERE tblp_moduloalumno.IdUsua =  '$idU' AND tblp_asignacion.Tipo = '2' AND tblp_asignacion.IdEstatus = '26' ORDER BY tblp_modulo.Code ASC");
    while ($x = $db->recorrer($sql)) {
      $get_modFinaAlum[] = $x;
    }
    return $get_modFinaAlum;
  }



  public function get_ModuloAsigAlumC($idU)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdModulo,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Grupo,
tblp_moduloalumno.Estatus,
tblp_modulo.NombreMod,
tblp_moduloalumno.IdAsignacion,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.IdEstatus,
tblp_modulo.Grado,
tblp_modulo.Oferta,
tblp_educativa.Nombre
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa WHERE tblp_moduloalumno.IdUsua =  '$idU' AND tblp_asignacion.Tipo = '2' AND tblp_asignacion.Curso = '1' ORDER BY tblp_modulo.Grado ASC");
    while ($x = $db->recorrer($sql)) {
      $gModuloAsigAlum[] = $x;
    }
    return $gModuloAsigAlum;
  }

  # OBTENER TOTAL DE MODULOS ACTIVOS DEL DOCENTE
  public function get_ModuloAsigTot($idU)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_asignacion.IdAsignacion) AS TotalMod, tblp_asignacion.IdUsua FROM tblp_asignacion WHERE tblp_asignacion.IdUsua = '$idU' AND tblp_asignacion.Estatus =  'Activo' AND tblp_asignacion.Curso = '0' GROUP BY tblp_asignacion.IdUsua");
    while ($x = $db->recorrer($sql)) {
      $gModuloTot[] = $x;
    }
    return $gModuloTot;
  }

  # OBTENER TOTAL DE MODULOS ACTIVOS DEL ALUMNO
  public function get_ModuloAsigTotAlum($idU)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_moduloalumno.IdModuloAlumno) AS TotalMod FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua =  '$idU' AND tblp_moduloalumno.Estatus =  'Activo'");
    while ($x = $db->recorrer($sql)) {
      $gModuloTotaLUM[] = $x;
    }
    return $gModuloTotaLUM;
  }

  public function get_listaEnsta($IdUsua)
  {
    $db = new Conexion();
    $get_listaEnsta = [];
    $sql = $db->query("SELECT tblc_encuesta.IdEncuesta, tblc_encuesta.Respuesta, tblc_encuesta.Estatus FROM tblc_encuesta WHERE tblc_encuesta.IdUsua =  '$IdUsua' AND tblc_encuesta.Estatus =  '8' GROUP BY tblc_encuesta.Estatus");
    while ($x = $db->recorrer($sql)) {
      $get_listaEnsta[] = $x;
    }
    return $get_listaEnsta;
  }

  # OBTENER LA LISTA DE ALUMNOS SEGUN LA OFERTA EDUCATIVA
  public function get_datosModulo($oferta, $modulo)
  {
    if ($oferta && $modulo) {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblp_modulodatos WHERE IdEducativa='$oferta' AND IdModulo='$modulo'");
      while ($x = $db->recorrer($sql)) {
        $gdatosM[] = $x;
      }
      return $gdatosM;
    }
  }
  # OBTENER UN SOLO USUARIO
  public function get_datosAlumno($idUser)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Foto, tblp_educativa.Nombre as Maestria FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE IdUsua='$idUser'");
    while ($x = $db->recorrer($sql)) {
      $gdatosU[] = $x;
    }
    return $gdatosU;
  }

  # OBTENER EL NOMBRE LA MAESTRIA
  public function get_datosOferta($IdOferta)
  {
    $db = new Conexion();
    $gdatosUHDt = [];
    $sql = $db->query("SELECT Tipo, Nombre FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $gdatosUHDt[] = $x;
    }
    return $gdatosUHDt;
  }

  public function get_OfertaModulo()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.NoModulo, tblp_modulo.Grado, tblp_modulo.NombreMod, tblp_modulo.Creditos, tblp_educativa.Nombre, tblp_educativa.Modalidad, tblp_educativa.Rvoe, tblp_educativa.IdEducativa, tblp_educativa.Ciclo FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa ORDER BY tblp_modulo.IdEducativa ASC, tblp_modulo.NoModulo ASC");
    while ($x = $db->recorrer($sql)) {
      $gOfertaModulo[] = $x;
    }
    return $gOfertaModulo;
  }

  # OBTENER DATOS DE MODULO POR DOCENTEget_datosModuloD
  public function get_datosModuloD($IdAsignacion)
  {
    $db = new Conexion();
    $get_datosModuloD = [];
    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.IdGrupo,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.Anio,
tblp_asignacion.Mes,
tblp_asignacion.IdEstatus,
tblp_asignacion.Estatus,
tblp_asignacion.IdUsua,
tblp_asignacion.Grupo,
tblp_asignacion.Fecha_impresion,
tblp_asignacion.Fec_emi_bim1,
tblp_asignacion.Fec_emi_bim2,
tblp_asignacion.Fec_emi_bim3,
tblp_asignacion.Curso,
tblp_asignacion._texto,
tblp_modulo.NombreMod,
tblp_modulo.CodeModulo,
tblp_educativa.IdGrado
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
tblp_asignacion.Tipo =  '2'
");
    while ($x = $db->recorrer($sql)) {
      $get_datosModuloD[] = $x;
    }
    return $get_datosModuloD;
  }

  public function get_semIni($IdParcial)
  {
    $db = new Conexion();
    $get_semIni = [];

    $sql = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.NoSemana FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ORDER BY tblp_semanadocente.NoSemana ASC LIMIT 1 ");
    while ($x = $db->recorrer($sql)) {
      $get_semIni[] = $x;
    }
    return $get_semIni;
  }

  public function get_lst_sem_par($IdParcial)
  {
    $db = new Conexion();
    $get_lst_sem_par = [];

    $sql = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.Etiqueta_semana, tblp_semanadocente.Semana, tblp_semanadocente.IdParcialDocente, tblp_semanadocente.NoSemana, tblp_semanadocente.Temas, tblp_semanadocente.Code, tblp_parcialdocente.Titulo, tblp_parcialdocente.NoParcial FROM tblp_semanadocente Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_semanadocente.IdParcialDocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ORDER BY tblp_semanadocente.NoSemana ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_sem_par[] = $x;
    }
    return $get_lst_sem_par;
  }


  public function get_lstForo($IdAsignacion)
  {
    $db = new Conexion();
    $get_lstForo = [];
    $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdAsignacion =  '$IdAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 5");
    while ($x = $db->recorrer($sql)) {
      $get_lstForo[] = $x;
    }
    return $get_lstForo;
  }

  public function get_nomModulo($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_modulo.NombreMod
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion='$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gdatosDoc[] = $x;
    }
    return $gdatosDoc;
  }

  public function get_actividadesPar($IdAsignacion)
  {
    $db = new Conexion();
    $gdatosDocAct = [];
    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.IdParcialDocente,
tblp_actividadesdocente.IdSemanaDocente,
tblp_actividadesdocente.IdTipoActividad,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.Modalidad,
tblc_tipoactividad.TipoActividad,
tblp_semanadocente.NoSemana,
tblp_semanadocente.Temas
FROM
tblp_actividadesdocente
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente
WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdEstatus = '8'
ORDER BY
tblp_semanadocente.NoSemana ASC
");
    while ($x = $db->recorrer($sql)) {
      $gdatosDocAct[] = $x;
    }
    return $gdatosDocAct;
  }

  public function get_parcialDatos($IdAsignacion, $IdParcialDoc)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc' AND tblp_parcialdocente.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gdatoParcD[] = $x;
    }
    return $gdatoParcD;
  }

  public function get_extraAlumno($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gdatoExtr[] = $x;
    }
    return $gdatoExtr;
  }

  # OBTENER UN SOLO MUDUlo
  public function get_datosModuloId($IdAsignacion, $IdEducativa, $IdModulo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_educativa.Nombre, tblp_modulo.NoModulo, tblp_modulo.CodeModulo, tblp_modulo.Oferta, tblp_modulo.NombreMod, tblp_asignacion.FecIni, tblp_asignacion.FecFin FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Inner Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.IdEducativa = '$IdEducativa' AND tblp_asignacion.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $gdatosModId[] = $x;
    }
    return $gdatosModId;
  }

  public function get_datDocnts($IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Foto, tblc_usuario.Correo FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gdatosModId[] = $x;
    }
    return $gdatosModId;
  }

  public function get_datVideos($IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_videos.IdVideo, tblp_videos.Titulo, tblp_videos.Link, tblp_videos.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo FROM tblp_videos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_videos.IdUsua WHERE tblp_videos.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gvideos[] = $x;
    }
    return $gvideos;
  }

  # OBTENER DATOS DEL EXAMEN
  public function get_datosExamen($IdAsignacion, $NoActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$IdAsignacion' AND tblp_actividad.NoActividad = '$NoActividad'");
    while ($x = $db->recorrer($sql)) {
      $gdatosExa[] = $x;
    }
    return $gdatosExa;
  }

  # OBTENER LA LISTA DE PREGUNTAS DEL EXAMEN
  public function get_preguntasExamenM($IdAsignacion, $NoActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_examen WHERE tblp_examen.IdAsignacion = '$IdAsignacion' AND tblp_examen.NoActividad = '$NoActividad'");
    while ($x = $db->recorrer($sql)) {
      $gdatosExaM[] = $x;
    }
    return $gdatosExaM;
  }

  # VERRIFICA SI YA EXISTE EXAMEN
  public function get_verificaExamen($IdAsignacion, $NoActividad, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT IdUsua FROM tblp_resultadoexamen WHERE tblp_resultadoexamen.IdAsignacion = '$IdAsignacion' AND tblp_resultadoexamen.NoActividad = '$NoActividad' AND tblp_resultadoexamen.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gdatosExaD[] = $x;
    }
    return $gdatosExaD;
  }

  # SELECCIONAMOS LAS PREGUNTAS DEL EXAMEN
  public function get_seleccionaPreguntas($IdAsignacion, $NoActividad, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_resultadoexamen.IdRespuestaAlumno, tblp_resultadoexamen.NoActividad, tblp_resultadoexamen.NoPregunta, tblp_examen.Pregunta, tblp_resultadoexamen.IdExamen FROM tblp_resultadoexamen Left Join tblp_examen ON tblp_examen.IdExamen = tblp_resultadoexamen.IdExamen WHERE tblp_resultadoexamen.IdAsignacion =  '$IdAsignacion' AND tblp_resultadoexamen.IdUsua =  '$IdUsua' AND tblp_resultadoexamen.NoActividad = '$NoActividad' AND tblp_resultadoexamen.Calificacion IS NULL GROUP BY tblp_resultadoexamen.NoPregunta LIMIT 1");
    while ($x = $db->recorrer($sql)) {
      $gdselcPre[] = $x;
    }
    return $gdselcPre;
  }

  # OBTENEMOS LAS RESPUESTAS DE LAS PREGUNTAS
  public function get_mostrarRespuestas($IdExamen)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_respuestaexamen WHERE tblp_respuestaexamen.IdExamen = '$IdExamen'");
    while ($x = $db->recorrer($sql)) {
      $grespuesPre[] = $x;
    }
    return $grespuesPre;
  }

  # OBTENER DATOS DE MODULO POR DOCENTE
  public function get_totalAlumnos($mod, $IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_moduloalumno.IdModuloAlumno) AS Total FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModulo = '$mod' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $galumnosT[] = $x;
    }
    return $galumnosT;
  }

  public function get_alumnos_mat($IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_moduloalumno.IdAsignacion =  '$IdAsignacion'
ORDER BY
tblc_usuario.Usuario ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_alumnos_mat[] = $x;
    }
    return $get_alumnos_mat;
  }

  public function get_list_tar_mat($IdAsignacion, $IdParcial)
  {
    $db = new Conexion();
    $get_list_tar_mat = [];
    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin
FROM
tblp_actividadesdocente
WHERE
tblp_actividadesdocente.IdAsignacion =  '$IdAsignacion' AND
tblp_actividadesdocente.IdParcialDocente =  '$IdParcial'

");
    while ($x = $db->recorrer($sql)) {
      $get_list_tar_mat[] = $x;
    }
    return $get_list_tar_mat;
  }

  public function get_tarea_id($IdAsignacion, $IdActividad, $IdUsua)
  {
    $db = new Conexion();

    $get_tarea_id = [];
    $sql = $db->query("SELECT
tblp_tareas.IdTarea,
tblp_tareas.Link,
tblp_tareas.Link2,
tblp_tareas.Link3,
tblp_tareas.Calificacion
FROM
tblp_tareas
WHERE
tblp_tareas.IdAsignacion =  '$IdAsignacion' AND
tblp_tareas.IdActividadesDocente =  '$IdActividad' AND
tblp_tareas.IdAlumno =  '$IdUsua'

");
    while ($x = $db->recorrer($sql)) {
      $get_tarea_id[] = $x;
    }
    return $get_tarea_id;
  }

  # OBTENER TAREAS - ACTIVIADAES ASIGANDAS
  public function get_obtenerActividades($idAsignacion, $tipo)
  {
    $db = new Conexion();
    $galumnosTx = [];

    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.Modalidad,
tblp_actividadesdocente.IdTipoActividad,
tblp_actividadesdocente.IdRubrica,
tblc_estatus.Estatus,
tblc_tipoactividad.TipoActividad,
tblp_parcialdocente.Titulo,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Tipo,
tblp_semanadocente.Etiqueta_semana,
tblp_semanadocente.NoSemana
FROM
tblp_actividadesdocente
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente
WHERE tblp_actividadesdocente.IdAsignacion = '$idAsignacion' AND tblp_actividadesdocente.IdTipoActividad <> '4'
ORDER BY
tblp_parcialdocente.NoParcial ASC,
tblp_semanadocente.NoSemana ASC,
tblp_actividadesdocente.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $galumnosTx[] = $x;
    }
    return $galumnosTx;
  }

  # OBTENER TAREAS - ACTIVIADAES ASIGANDAS
  public function get_obtenerActividadId($idAsignacion, $IdActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.IdActividad = '$IdActividad'");
    while ($x = $db->recorrer($sql)) {
      $gObtActId[] = $x;
    }
    return $gObtActId;
  }

  # OBTENER DATOS DEL FORO
  public function get_datosForo($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.TipoActividad = 'Foro' ORDER BY tblp_actividad.IdActividad DESC");
    while ($x = $db->recorrer($sql)) {
      $gForoD[] = $x;
    }
    return $gForoD;
  }

  # OBTENER DATOS DEL actividades
  public function get_datosActividades($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_actividad.IdActividad, tblp_actividad.TipoActividad, tblp_actividad.FecIni, tblp_actividad.FecFin, tblp_actividad.Modalidad, tblp_actividad.TituloActividad, tblp_actividad.Estatus, tblp_actividad.FecCap, tblp_actividad.NoActividad, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_actividad Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_actividad.IdUsua WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.TipoActividad <> 'Foro' ORDER BY tblp_actividad.IdActividad DESC");
    while ($x = $db->recorrer($sql)) {
      $gActiviadades[] = $x;
    }
    return $gActiviadades;
  }

  public function get_datosAc($IdActividadDoc)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Tiempo, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin, tblp_actividadesdocente.IdEstatus, tblp_actividadesdocente.Mostrar FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
    while ($x = $db->recorrer($sql)) {
      $gdatoaCTsDoc[] = $x;
    }
    return $gdatoaCTsDoc;
  }

  public function get_examIni($IdAsig, $IdParcialDoc, $IdActividadDoc, $IdUsua, $IdTarea)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_examusuario WHERE tblp_examusuario.IdAsignacion = '$IdAsig' AND tblp_examusuario.IdParcialDocente = '$IdParcialDoc' AND tblp_examusuario.IdActividadesDocente = '$IdActividadDoc' AND tblp_examusuario.IdUsua = '$IdUsua' AND tblp_examusuario.IdTarea = '$IdTarea'");
    while ($x = $db->recorrer($sql)) {
      $gdaExInic[] = $x;
    }
    return $gdaExInic;
  }

  public function get_addPregunEx($IdAsig, $IdParcialDoc, $IdActividadDoc, $IdExamU, $IdUsua, $IdTarea)
  {
    $db = new Conexion();
    $sql9 = $db->query("SELECT tblp_actividadesdocente.Tiempo FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente =  '$IdActividadDoc'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Tiempo = $datos91['Tiempo'];
    if ($Tiempo) {

      $sql7 = $db->query("SELECT tblp_exampregunta.IdPregunta FROM tblp_exampregunta WHERE tblp_exampregunta.IdAsignacion = '$IdAsig' AND tblp_exampregunta.IdActividadesDocente = '$IdActividadDoc' AND tblp_exampregunta.IdParcialDocente = '$IdParcialDoc'");
      while ($x = $db->recorrer($sql7)) {
        $IdPreg = $x["IdPregunta"];
        $insertar = $db->query("INSERT INTO tblp_examresultado (IdUsua, IdAsignacion, IdExamenUsuario, IdParcialDocente, IdActividadesDocente, IdPregunta)VALUES('$IdUsua','$IdAsig','$IdExamU','$IdParcialDoc','$IdActividadDoc','$IdPreg')");
      }
      $min = date("i-s");
      $anio = date("Y");
      $mes = date("m");
      $dia = date("d");
      $hora = date("G") + $Tiempo;
      if ($hora > 24) {
        $dia = $dia + 1;
        $hora =  ($hora - 24);
      }

      $ini = date("Y-m-d G-i-s");
      $fin = date("Y-m-$dia $hora-i-s");

      $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.IdEstatus = '8',  tblp_examusuario.FecIni = '$ini', tblp_examusuario.FecFin = '$fin' WHERE tblp_examusuario.IdExamenUsua = '$IdExamU'");
      echo "<script type='text/javascript'>window.location='viewEvaYseC.php?Id=2345643246$IdActividadDoc&IdP=8294625347$IdParcialDoc&IdT=4672345324$IdTarea';</script>";
      exit();
    } else {
      echo "<script type='text/javascript'>window.location='inicio.php';</script>";
      exit();
    }
  }

  public function get_pregunExa($IdExamU, $IdAsig, $IdActividadDoc)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_examresultado.IdResultado, tblp_examresultado.IdPregunta, tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo, tblp_exampregunta.Imagen  FROM tblp_examresultado Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' AND tblp_examresultado.Valor IS NULL LIMIT 1 ");
    // $sql = $db->query("SELECT tblp_examresultado.IdResultado, tblp_examresultado.IdPregunta, tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo, tblp_exampregunta.Imagen  FROM tblp_examresultado Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' AND tblp_examresultado.Valor IS NULL order BY RAND() LIMIT 1 ");
    while ($x = $db->recorrer($sql)) {
      $gdaExIniTSc[] = $x;
    }
    return $gdaExIniTSc;
  }

  public function get_pregList($IdExamU, $IdAsig, $IdActividadDoc)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Preguntas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc'  ");
    while ($x = $db->recorrer($sql)) {
      $gdalisTprec[] = $x;
    }
    return $gdalisTprec;
  }

  public function get_RespLusa($IdExamU, $IdAsig, $IdActividadDoc)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Contestadas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario =  '$IdExamU' AND tblp_examresultado.IdAsignacion =  '$IdAsig' AND tblp_examresultado.IdActividadesDocente =  '$IdActividadDoc' AND tblp_examresultado.Valor IS NOT NULL");
    while ($x = $db->recorrer($sql)) {
      $gdalConstc[] = $x;
    }
    return $gdalConstc;
  }

  public function get_respuestaE($IdPregunta)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta ='$IdPregunta' ");
    while ($x = $db->recorrer($sql)) {
      $gdaRegt[] = $x;
    }
    return $gdaRegt;
  }

  public function add_savresExav($IdResultado, $Respuesta)
  {
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblp_examresultado SET tblp_examresultado.Valor = '0', tblp_examresultado.Respuesta = '$Respuesta', tblp_examresultado.FecCap = NOW() WHERE tblp_examresultado.IdResultado = '$IdResultado'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savPerUs($IdUsuaX, $Fecha, $Chk)
  {
    $db = new Conexion();
    $IdUsua = substr($IdUsuaX, 10, 10);

    if ($Chk == 0) {
      $FecAct = date("Y-m-d");
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.FecLimite = '$Fecha' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      // if($Fecha < $FecAct){
      //   $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '50'  WHERE tblc_usuario.IdUsua='$IdUsua'");
      // }
    } else {
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '8', tblc_usuario.FecLimite = NULL WHERE tblc_usuario.IdUsua = '$IdUsua'");
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function add_savProrro($IdUsua,$IdAdmin,$Fecha,$Comentario){
    $db = new Conexion();

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Folio = '7684' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("INSERT INTO tblp_prorroga (IdUsua, IdAdmin, Fecha, FecCap, IdEstatus, Comentario) VALUES ('$IdUsua', '$IdAdmin', '$Fecha', NOW(), '8', '$Comentario')");

    if($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function cancel_prorroga_id($IdUsua,$Id){
    $db = new Conexion();
    
    $sql = $db->query("UPDATE tblc_usuario SET tblc_usuario.Folio = NULL WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    $sql = $db->query("UPDATE tblp_prorroga SET tblp_prorroga.IdEstatus = '22' WHERE tblp_prorroga.IdProrroga = '$Id' ");
  
    return 1;
  }

  public function add_preguntaExamen()
  {
    $db = new Conexion();
    $archivoX = $_FILES['txtImagen']['size']; //nombre del archivo


    if ($archivoX) {
      $carpeta = "assets/images/examen/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
      $archivo = $_FILES['txtImagen']['name']; //nombre del archivo
      $tamaño = $_FILES['txtImagen']['size']; //tamaño del archivo
      $nombreImg = explode(".", $archivo);
      $tipo = $nombreImg[1];
      $code = md5(rand() * time());
      $archivo = $code . '.' . $tipo; // ".$nombreImg[1]"; // Generamos un nombre de archivo Aleatorio para evitar conflictos entre los nombres.
      if (!move_uploaded_file($_FILES['txtImagen']['tmp_name'], $carpeta . $archivo)) {
        $_SESSION['Alerta'] = "ERROR";
        $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
        echo "<script type='text/javascript'>window.location='doMiPlaneacion.php';</script>";
        exit();
      }

      $nombre_fichero = $carpeta . $archivo;
      if (file_exists($nombre_fichero)) {
        $insertar = $db->query("INSERT INTO tblp_exampregunta (IdAsignacion, IdActividadesDocente, IdParcialDocente, IdUsua, Pregunta, FecCap, Tipo, Imagen) VALUES ('" . $_POST["IdAsignacion"] . "','" . $_POST["IdActividadDoc"] . "','" . $_POST["IdParcialDoc"] . "','" . $_POST["IdUsua"] . "','" . $_POST["txtPregunta"] . "',NOW(),'" . $_POST["txtTipo"] . "','$archivo')");
      } else {
        echo "<script type='text/javascript'>window.location='doAddRecurso.php';</script>";
      }
    } else {
      $archivo = "";
      $insertar = $db->query("INSERT INTO tblp_exampregunta (IdAsignacion, IdActividadesDocente, IdParcialDocente, IdUsua, Pregunta, FecCap, Tipo) VALUES ('" . $_POST["IdAsignacion"] . "','" . $_POST["IdActividadDoc"] . "','" . $_POST["IdParcialDoc"] . "','" . $_POST["IdUsua"] . "','" . $_POST["txtPregunta"] . "',NOW(),'" . $_POST["txtTipo"] . "')");
    }

    if ($insertar) {
      $IdAs = $_POST["IdAsignacion"];

      $link = "doAddConfigExamen.php?idToks=$IdAs&tok=1573436374" . $_POST["IdActividadDoc"] . "&p=" . $_POST["IdParcialDoc"];

      echo "<script type='text/javascript'>window.location='$link'</script>";
    } else {
      $_SESSION['Alerta'] = "ERROR";
      $_SESSION['Variable'] = " ERROR AL AGREGAR RECURSO DE APOYO";
      echo "<script type='text/javascript'>window.location='doAddRecurso.php';</script>";
    }
  }


  public function add_mostrarEcav($IdActividad, $IdParcial)
  {
    $db = new Conexion();
    $sql3 = $db->query("SELECT tblp_actividadesdocente.Tiempo FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");
    $db->rows($sql3);
    $datos3 = $db->recorrer($sql3);
    $rwTiem = $datos3["Tiempo"];

    if (!$rwTiem) {
      return 3;
      exit();
    }

    $sql1 = $db->query("SELECT * FROM tblp_exampregunta WHERE tblp_exampregunta.IdParcialDocente = '$IdParcial' AND tblp_exampregunta.IdActividadesDocente = '$IdActividad'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwPreg = $datos2["IdPregunta"];
    if ($rwPreg) {
      $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Mostrar = 'SI' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");
      if ($insertar) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 2;
    }
  }

  # OBTENER TOTAL NOTIFICACION
  public function get_datosForoNot($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_actividad.IdActividad) AS TotalNot FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.TipoActividad='Foro' AND tblp_actividad.Estatus <> ''");
    while ($x = $db->recorrer($sql)) {
      $gForoN[] = $x;
    }
    return $gForoN;
  }

  # OBTENER TOTAL ACTIVIDADES
  public function get_datosActividadesT($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_actividad.IdActividad) AS TotalAct FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.TipoActividad <> 'Foro' AND tblp_actividad.Estatus <> ''");
    while ($x = $db->recorrer($sql)) {
      $gForoNd[] = $x;
    }
    return $gForoNd;
  }

  # OBTENER TOTAL ACTIVIDADES
  public function get_datosavisos($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_aviso.IdAviso) AS sumAvisos FROM tblp_aviso WHERE tblp_aviso.IdAsignacion = '$idAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gForoNs[] = $x;
    }
    return $gForoNs;
  }

  # OBTENER ASIGANACION DATOS
  public function get_tioDatosG($idUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdUsua = '$idUsua' AND tblp_asignacion.Estatus = 'Activo'");
    while ($x = $db->recorrer($sql)) {
      $gForoD[] = $x;
    }
    return $gForoD;
  }

  # OBTENER datos grpo
  public function get_tioDatosGrupo($idUsua, $IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.IdUsua = '$idUsua'");
    while ($x = $db->recorrer($sql)) {
      $gForoDs[] = $x;
    }
    return $gForoDs;
  }

  public function get_dias_clases($IdAsignacion, $Tiempo)
  {
    $db = new Conexion();
    if ($Tiempo == 0) {
      $cond = "";
    } else {
      $cond = " AND tblp_asistencia.AnioMes = '$Tiempo'";
    }
    $get_dias_clases = [];
    $sql = $db->query("SELECT tblp_asistencia.IdAsistencia, tblp_asistencia.Fecha FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' $cond GROUP BY tblp_asistencia.Fecha ORDER BY tblp_asistencia.Fecha ASC");
    while ($x = $db->recorrer($sql)) {
      $get_dias_clases[] = $x;
    }
    return $get_dias_clases;
  }

  public function get_meses_lista($IdAsignacion)
  {
    $db = new Conexion();
    $get_meses_lista = [];
    $sql = $db->query("SELECT tblp_asistencia.AnioMes FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_asistencia.AnioMes ORDER BY tblp_asistencia.AnioMes ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_meses_lista[] = $x;
    }
    return $get_meses_lista;
  }

  public function get_total_dias($IdAsignacion)
  {
    $db = new Conexion();
    $get_total_dias = [];
    $sql = $db->query("SELECT tblp_asignacion.FecIni, tblp_asignacion.NoDias FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' ");
    while ($x = $db->recorrer($sql)) {
      $get_total_dias[] = $x;
    }
    return $get_total_dias;
  }

  public function get_lst_mat_asig($IdCampus, $IdGrupo)
  {
    $db = new Conexion();
    $get_lst_mat_asig = [];

    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.FecIni, tblp_asignacion.FecFin,  tblp_asignacion.IdCiclo, tblc_ciclo.Ciclo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.NoDias IS NOT NULL ORDER BY tblc_ciclo.FInicio ASC, tblp_asignacion.FecIni ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_mat_asig[] = $x;
    }
    return $get_lst_mat_asig;
  }

  public function get_lst_mat_asig_id($IdCampus, $IdGrupo,$IdAsignacion)
  {
    $db = new Conexion();
    $get_lst_mat_asig_id = [];
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdCiclo, tblc_ciclo.Ciclo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdAsignacion = '$IdAsignacion' ORDER BY tblc_ciclo.FInicio ASC, tblp_asignacion.FecIni ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_mat_asig_id[] = $x;
    }
    return $get_lst_mat_asig_id;
  }

  public function get_lst_alumx($IdGrupo)
  {
    $db = new Conexion();
    $get_lst_alumx = [];

    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_estatus.Estatus
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE tblc_usuario.IdGrupo = '$IdGrupo'
ORDER BY
tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_lst_alumx[] = $x;
    }
    return $get_lst_alumx;
  }

  public function get_lst_enc_grp($IdCampus, $IdGrupo)
  {
    $db = new Conexion();
    $get_lst_enc_grp = [];

    $sql = $db->query("SELECT
tblx_evaluacion.IdEvaluacionX,
tblx_evaluacion.IdCiclo,
tblc_ciclo.Ciclo,
tblc_tipoevaluacion.Evaluacion,
tblx_evaluacion.IdTipo,
tblx_evaluacion.IdAsignacion,
tblp_modulo.NombreMod,
tblc_tipoevaluacion.Cve,
tblp_asignacion.IdUsua AS IdDocente,
tblx_evaluacion.FecIni,
tblx_evaluacion.FecFin
FROM tblx_evaluacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblx_evaluacion.IdCiclo Left Join tblc_tipoevaluacion ON tblc_tipoevaluacion.IdTipoEvaluacion = tblx_evaluacion.IdTipo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_evaluacion.IdModulo Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblx_evaluacion.IdAsignacion
WHERE
tblx_evaluacion.IdCampus =  '$IdCampus' AND
tblx_evaluacion.IdGrupo =  '$IdGrupo'
GROUP BY
tblx_evaluacion.IdAsignacion
ORDER BY
tblc_ciclo.MesIni ASC,
tblx_evaluacion.Ini ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_lst_enc_grp[] = $x;
    }
    return $get_lst_enc_grp;
  }

  public function get_lst_enc_gral($IdCampus, $IdCiclo)
  {
    $db = new Conexion();
    $get_lst_enc_gral = [];

    $sql = $db->query("SELECT
tblx_grafica_prom_materia.IdGrafica_prom,
tblx_grafica_prom_materia.Promedio,
tblp_asignacion.IdEducativa,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblx_grafica_prom_materia
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblx_grafica_prom_materia.IdAsignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_grafica_prom_materia.IdDocente
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblx_grafica_prom_materia.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdCampus = '$IdCampus' AND tblp_asignacion.Tipo =  '2'
ORDER BY
tblp_educativa.IdGrado ASC,
tblp_grupo.IdOferta ASC,
tblp_grupo.CveGrupo ASC,
tblp_modulo.CodeModulo ASC

");
    while ($x = $db->recorrer($sql)) {
      $get_lst_enc_gral[] = $x;
    }
    return $get_lst_enc_gral;
  }

  public function get_lst_enc_xgrp($IdCampus, $IdCiclo)
  {
    $db = new Conexion();
    $get_lst_enc_xgrp = [];

    $sql = $db->query("SELECT
tblx_grafica_prom_materia.IdGrafica_prom,
Avg(tblx_grafica_prom_materia.Promedio) AS Promedio,
tblp_asignacion.IdEducativa,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.CveGrupo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblx_grafica_prom_materia
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblx_grafica_prom_materia.IdAsignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblx_grafica_prom_materia.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2'
GROUP BY
tblp_asignacion.IdGrupo
ORDER BY
tblp_educativa.IdGrado ASC,
tblp_grupo.IdOferta ASC,
tblp_grupo.CveGrupo ASC

");
    while ($x = $db->recorrer($sql)) {
      $get_lst_enc_xgrp[] = $x;
    }
    return $get_lst_enc_xgrp;
  }

  public function get_lst_enc_plan($IdCampus, $IdCiclo)
  {
    $db = new Conexion();
    $get_lst_enc_plan = [];

    $sql = $db->query("SELECT
tblx_grafica_prom_materia.IdGrafica_prom,
Avg(tblx_grafica_prom_materia.Promedio) AS Promedio,
tblp_asignacion.IdEducativa,
tblp_educativa.Nombre AS Educativa,
tblc_grado._Grado,
tblp_educativa.IdGrado
FROM
tblx_grafica_prom_materia
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblx_grafica_prom_materia.IdAsignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
WHERE
tblx_grafica_prom_materia.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2'
GROUP BY
tblp_asignacion.IdEducativa
ORDER BY
tblp_educativa.IdGrado ASC

");
    while ($x = $db->recorrer($sql)) {
      $get_lst_enc_plan[] = $x;
    }
    return $get_lst_enc_plan;
  }

  public function get_lst_enc_nivel($IdCampus, $IdCiclo)
  {
    $db = new Conexion();
    $get_lst_enc_nivel = [];

    $sql = $db->query("SELECT
tblx_grafica_prom_materia.IdGrafica_prom,
Avg(tblx_grafica_prom_materia.Promedio) AS Promedio,
tblp_asignacion.IdEducativa,
tblp_educativa.Nombre AS Educativa,
tblc_grado._Grado,
tblp_educativa.IdGrado
FROM
tblx_grafica_prom_materia
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblx_grafica_prom_materia.IdAsignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
WHERE
tblx_grafica_prom_materia.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2'
GROUP BY
tblp_educativa.IdGrado
");
    while ($x = $db->recorrer($sql)) {
      $get_lst_enc_nivel[] = $x;
    }
    return $get_lst_enc_nivel;
  }


  public function get_sum_banc($Inicio, $Final)
  {
    $db = new Conexion();
    $get_sum_banc = [];

    $sql = $db->query("SELECT tblc_bancos.Banco, Sum(tblp_gastos.Importe) AS Suma, tblp_gastos.IdBanco FROM tblp_gastos Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_gastos.IdBanco WHERE tblp_gastos.Fecha BETWEEN '$Inicio' AND '$Final' GROUP BY tblp_gastos.IdBanco ORDER BY Suma ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_sum_banc[] = $x;
    }
    return $get_sum_banc;
  }



  public function get_egresos($AnioMes)
  {
    $db = new Conexion();
    $get_egresos = [];

    $sql = $db->query("SELECT
tblp_gastos.IdGasto,
Sum(tblp_gastos.Importe) AS Suma,
tblc_concepto_gasto.Nombre_gasto AS Gasto
FROM
tblp_gastos
Left Join tblc_concepto_gasto ON tblc_concepto_gasto.IdConcepto = tblp_gastos.IdConcepto
WHERE tblp_gastos.AnioMes = '$AnioMes'
GROUP BY
tblp_gastos.IdConcepto");
    while ($x = $db->recorrer($sql)) {
      $get_egresos[] = $x;
    }
    return $get_egresos;
  }

  public function get_ingreso($AnioMes)
  {
    $db = new Conexion();
    $get_ingreso = [];

    $sql = $db->query("SELECT
tblp_foliospago.IdPago,
Sum(tblp_foliospago.Monto) AS Total,
tblc_conceptos.NomConcepto
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
WHERE
tblp_foliospago.IdEstatus = '4' AND
tblp_foliospago.AnioMes =  '$AnioMes'
GROUP BY
tblp_pagos.IdConcepto ORDER BY Total ASC
 ");
    while ($x = $db->recorrer($sql)) {
      $get_ingreso[] = $x;
    }
    return $get_ingreso;
  }



  public function get_lst_tray_asig($IdGrupo)
  {
    $db = new Conexion();
    $get_lst_tray_asig = [];
    $sql = $db->query("SELECT tblp_asignacion.IdCiclo, tblc_ciclo.Ciclo FROM tblp_asignacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_asignacion.IdCiclo ORDER BY tblc_ciclo.MesIni DESC");
    while ($x = $db->recorrer($sql)) {
      $get_lst_tray_asig[] = $x;
    }
    return $get_lst_tray_asig;
  }

  public function get_correos_envi($IdGrupo)
  {
    $db = new Conexion();
    $get_correos_envi = [];
    $sql = $db->query("SELECT
Count(tblp_correos_enviados.IdCorreo) AS Total,
tblp_correos_enviados.Asunto,
tblp_correos_enviados.Contenido,
tblp_correos_enviados.IdUsua_envia,
tblp_correos_enviados.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_correos_enviados
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_correos_enviados.IdUsua_envia
WHERE tblp_correos_enviados.IdGrupo = '$IdGrupo'
GROUP BY
tblp_correos_enviados.FecCap
");
    while ($x = $db->recorrer($sql)) {
      $get_correos_envi[] = $x;
    }
    return $get_correos_envi;
  }

  public function get_lst_user($IdGrupo)
  {
    $db = new Conexion();
    $get_lst_user = [];

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdCampus, tblc_usuario.IdOferta FROM tblc_usuario WHERE tblc_usuario.IdGrupo =  '$IdGrupo' AND tblc_usuario.IdEstatus =  '8' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_user[] = $x;
    }
    return $get_lst_user;
  }

  public function get_calen_mat_asg($IdCampus, $IdCiclo,$Dias)
  {
    $db = new Conexion();
    $get_calen_mat_asg = [];
    if($Dias == 'T'){
      $cond = "";
    } else {
      $cond = " AND tblp_grupo.Dia =  '$Dias' ";
    }

    $sql = $db->query("SELECT tblp_educativa.IdEducativa,tblp_educativa.Nombre AS Educativa, tblp_modulo.NombreMod, tblc_usuario.id_paquete, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_asignacion.FecIni, tblp_asignacion.IdAsignacion, tblp_asignacion.Fecha_impresion, tblp_asignacion.Anio, tblp_asignacion.Plantel, tblp_asignacion.FecFin, tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblc_modalidad._Modalidad, tblp_modulo.Grado, tblc_dias_clases._Dias, tblc_estatus.Estatus, tblp_modulo.CodeModulo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.Tipo =  '2' AND tblp_grupo.IdCampus =  '$IdCampus' $cond ORDER BY tblp_educativa.IdGrado ASC, tblp_modulo.Grado ASC, tblp_asignacion.IdGrupo ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_calen_mat_asg[] = $x;
    }
    return $get_calen_mat_asg;
  }

  public function get_rep_mat_asg()
  {
    $db = new Conexion();
    $get_rep_mat_asg = [];

    $sql = $db->query("SELECT
tblp_educativa.IdEducativa,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.NombreMod,
tblc_usuario.id_paquete,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_asignacion.FecIni,
tblp_asignacion.IdAsignacion,
tblp_asignacion.Fecha_impresion,
tblp_asignacion.Anio,
tblp_asignacion.Plantel,
tblp_asignacion.FecFin,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblc_modalidad._Modalidad,
tblp_modulo.Grado,
tblc_dias_clases._Dias,
tblp_modulo.CodeModulo,
tblp_asignacion._fecEnvio,
tblc_campus.Campus
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
WHERE
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion._fecEnvio IS NOT NULL
ORDER BY
tblp_asignacion._fecEnvio DESC LIMIT 50
");
    while ($x = $db->recorrer($sql)) {
      $get_rep_mat_asg[] = $x;
    }
    return $get_rep_mat_asg;
  }

  public function get_foto_perfil()
  {
    $db = new Conexion();
    $get_foto_perfil = [];

    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblc_usuario.Estado,
tblc_usuario.Foto
FROM
tblc_usuario WHERE tblc_usuario.Estado IS NOT NULL
ORDER BY
tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_foto_perfil[] = $x;
    }
    return $get_foto_perfil;
  }

  public function get_lista_us($IdAsignacion)
  {
    $db = new Conexion();
    $get_lista_us = [];

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_moduloalumno.ParcialF1,
tblp_moduloalumno.ParcialF2,
tblp_moduloalumno.ParcialF3,
tblp_moduloalumno.Promedio_final,
tblp_moduloalumno.Promedio
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_moduloalumno.IdAsignacion =  '$IdAsignacion'
ORDER BY
tblc_usuario.Usuario ASC

");
    while ($x = $db->recorrer($sql)) {
      $get_lista_us[] = $x;
    }
    return $get_lista_us;
  }

  public function get_fech_emis($IdAsignacion)
  {
    $db = new Conexion();
    $get_fech_emis = [];

    $sql = $db->query("SELECT tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.Fec_emi_bim1, tblp_asignacion.Fec_emi_bim2, tblp_asignacion.Fec_emi_bim3, tblp_asignacion.Fecha_impresion FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while ($x = $db->recorrer($sql)) {
      $get_fech_emis[] = $x;
    }
    return $get_fech_emis;
  }


  public function get_lst_alumnos_act($IdUsua)
  {
    $db = new Conexion();
    $get_lst_alumnos_act = [];


    $sql = $db->query("SELECT
tblp_coordinador.IdOferta,
tblc_usuario.IdGrupo,
Count(tblc_usuario.IdUsua) AS Total,
tblp_grupo.CveGrupo,
tblp_grupo.Grado,
tblp_educativa.IdGrado,
tblp_educativa.Nombre,
tblc_estatus.Estatus,
tblp_educativa.IdGrado,
tblc_grado._Grado
FROM
tblp_coordinador
Left Join tblc_usuario ON tblc_usuario.IdOferta = tblp_coordinador.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta AND tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_grupo.IdEstatus
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
WHERE
tblp_coordinador.IdEstatus =  '8' AND
tblp_coordinador.IdUsua =  '$IdUsua' AND
tblc_usuario.Permisos =  '3'
GROUP BY
tblc_usuario.IdGrupo,
tblp_coordinador.IdOferta
ORDER BY
tblp_grupo.IdOferta ASC,
tblp_grupo.Grado ASC
 ");
    while ($x = $db->recorrer($sql)) {
      $get_lst_alumnos_act[] = $x;
    }
    return $get_lst_alumnos_act;
  }

  public function get_calen_pagos($Inicio, $Final)
  {
    $db = new Conexion();
    $get_calen_pagos = [];
    $sql = $db->query("SELECT
tblp_educativa.IdEducativa,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.NombreMod,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblc_modalidad._Modalidad,
tblp_modulo.Grado,
tblc_dias_clases._Dias,
tblp_asignacion.Monto,
tblp_asignacion.Fec_pago,
tblp_asignacion._idEstatus,
tblp_asignacion._fecPago,
tblp_asignacion._monto,
tblc_estatus.Estatus
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion._idEstatus
WHERE  tblp_asignacion.Tipo = '2' AND tblp_asignacion.Fec_pago BETWEEN '$Inicio' AND '$Final'
ORDER BY
tblp_asignacion.Fec_pago ASC");
    while ($x = $db->recorrer($sql)) {
      $get_calen_pagos[] = $x;
    }
    return $get_calen_pagos;
  }

  public function get_calen_suspx($Anio)
  {
    $db = new Conexion();
    $get_calen_suspx = [];

    $sql = $db->query("SELECT
tblp_suspension.IdSuspension,
tblp_suspension.Fecha,
tblp_suspension.Motivo,
tblp_suspension.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_suspension
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_suspension.IdUsua
WHERE tblp_suspension.Anio = '$Anio' ORDER BY tblp_suspension.Fecha ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_calen_suspx[] = $x;
    }
    return $get_calen_suspx;
  }

  public function get_lst_grp($IdGrupo)
  {
    $db = new Conexion();
    $get_lst_grp = [];

    $sql = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.Grado, tblp_grupo.Modalidad, tblp_grupo.CveGrupo, tblc_dias_clases._Dias, tblc_modalidad._Modalidad, tblp_educativa.IdGrado, tblp_educativa.Nombre FROM tblp_grupo Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $get_lst_grp[] = $x;
    }
    return $get_lst_grp;
  }

  public function get_lst_cic($IdGrupo, $Tipo)
  {
    $db = new Conexion();
    $get_lst_cic = [];
    if ($Tipo == 'A') {
      $_tipo = 'A';
    } elseif ($Tipo == 'F') {
      $_tipo = 'F';
    } else {
      $_tipo = 'R';
    }


    if ($Tipo == 'A') {
      $_tipo = 'A';
    }

    $sql = $db->query("SELECT
Sum(tblp_calificacion.$_tipo) AS Total,
tblp_modulo.NombreMod,
tblp_modulo.CodeModulo
FROM
tblp_calificacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
WHERE
tblp_calificacion.IdGrupo =  '$IdGrupo'
GROUP BY
tblp_calificacion.IdModulo
ORDER BY
tblp_modulo.CodeModulo ASC

");
    while ($x = $db->recorrer($sql)) {
      $get_lst_cic[] = $x;
    }
    return $get_lst_cic;
  }

  public function get_lst_prom($IdGrupo)
  {
    $db = new Conexion();
    $get_lst_prom = [];

    $sql = $db->query("SELECT
tblp_calificacion.IdUsua,
Avg(tblp_calificacion.Promedio) AS Promedio,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblp_calificacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua
WHERE
tblp_calificacion.IdGrupo =  '$IdGrupo'
GROUP BY
tblp_calificacion.IdUsua
ORDER BY
Promedio DESC
");
    while ($x = $db->recorrer($sql)) {
      $get_lst_prom[] = $x;
    }
    return $get_lst_prom;
  }

  public function get_docs_alum($IdUsua, $IdTipo)
  {
    $db = new Conexion();
    $get_docs_alum = [];
    $sql = $db->query("SELECT
tblp_alumnos_docs.Fecha
FROM
tblp_alumnos_docs
WHERE
tblp_alumnos_docs.IdUsua =  '$IdUsua' AND
tblp_alumnos_docs.IdDocumento =  '$IdTipo'");
    while ($x = $db->recorrer($sql)) {
      $get_docs_alum[] = $x;
    }
    return $get_docs_alum;
  }

  public function get_user_lista($IdAsignacion)
  {
    $db = new Conexion();
    $get_user_lista = [];
    $sql = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno, tblp_moduloalumno.IdUsua, tblc_usuario.Foto, tblc_usuario.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");
    while ($x = $db->recorrer($sql)) {
      $get_user_lista[] = $x;
    }
    return $get_user_lista;
  }

  public function get_us_list_enc($IdCampus, $IdCiclo, $IdGrupo, $IdTipo, $IdAsignacion)
  {
    $db = new Conexion();
    $get_us_list_enc = [];
    $sql = $db->query("SELECT
tblx_evaluacion.IdEvaluacionX,
tblx_evaluacion.IdUsua,
tblx_evaluacion.IdEstatus,
tblx_evaluacion.FecIni,
tblx_evaluacion.FecFin,
tblx_evaluacion.Ini,
tblx_evaluacion.Fin,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_estatus.Estatus
FROM
tblx_evaluacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_evaluacion.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_evaluacion.IdEstatus
WHERE
tblx_evaluacion.IdCampus =  '$IdCampus' AND
tblx_evaluacion.IdGrupo =  '$IdGrupo' AND
tblx_evaluacion.IdCiclo =  '$IdCiclo' AND
tblx_evaluacion.IdAsignacion =  '$IdAsignacion' AND
tblx_evaluacion.IdTipo =  '$IdTipo' ORDER BY tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_us_list_enc[] = $x;
    }
    return $get_us_list_enc;
  }

  public function get_user_lista_tra($IdGrupo, $IdCiclo)
  {
    $db = new Conexion();
    $get_user_lista_tra = [];
    $sql = $db->query("SELECT
tblp_calificacion.IdCalificacion,
tblp_calificacion.IdUsua,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_calificacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua
WHERE
tblp_calificacion.IdGrupo =  '$IdGrupo' AND
tblp_calificacion.IdCiclo =  '$IdCiclo'
GROUP BY
tblp_calificacion.IdUsua
ORDER BY
tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_user_lista_tra[] = $x;
    }
    return $get_user_lista_tra;
  }

  public function get_no_mat_tralst($IdGrupo, $IdCiclo)
  {
    $db = new Conexion();
    $get_no_mat_tralst = [];
    $sql = $db->query("SELECT
      tblp_asignacion.IdModulo,
tblp_asignacion.FecIni,
tblp_modulo.Grado,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.IdGrupo =  '$IdGrupo' AND
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2'
ORDER BY
tblp_modulo.CodeModulo ASC


");
    while ($x = $db->recorrer($sql)) {
      $get_no_mat_tralst[] = $x;
    }
    return $get_no_mat_tralst;
  }

  public function get_user_valor_tra($IdUsua, $IdModulo, $IdCiclo, $Tipo)
  {
    $db = new Conexion();
    $get_user_valor_tra = [];
    $sql = $db->query("SELECT tblp_calificacion.$Tipo FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$IdModulo' AND tblp_calificacion.IdCiclo = '$IdCiclo' ");
    while ($x = $db->recorrer($sql)) {
      $get_user_valor_tra[] = $x;
    }
    return $get_user_valor_tra;
  }

  public function get_user_prom_tra($IdUsua, $IdModulo, $IdCiclo)
  {
    $db = new Conexion();
    $get_user_prom_tra = [];
    $sql = $db->query("SELECT tblp_calificacion.Promedio FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$IdModulo' AND tblp_calificacion.IdCiclo = '$IdCiclo' ");
    while ($x = $db->recorrer($sql)) {
      $get_user_prom_tra[] = $x;
    }
    return $get_user_prom_tra;
  }

  public function get_no_mat_tra($IdGrupo, $IdCiclo)
  {
    $db = new Conexion();
    $get_no_mat_tra = [];

    $sql = $db->query("SELECT
Count(tblp_asignacion.IdModulo) AS Total
FROM
tblp_asignacion
WHERE
tblp_asignacion.IdGrupo =  '$IdGrupo' AND
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.Tipo =  '2'
");
    while ($x = $db->recorrer($sql)) {
      $get_no_mat_tra[] = $x;
    }
    return $get_no_mat_tra;
  }

  public function ins_asistencia($IdModuloAlumno, $IdUsua, $Tipo, $Valor, $IdAsignacion)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.$Tipo = '$Valor' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdAsignacion = '$IdAsignacion'");
    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.$Tipo = '$Valor' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
  }



  public function insx_asistencia_gral($IdAsignacion, $Tipo, $Total)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.$Tipo = '$Total' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  }

  public function get_valos_asis($IdAsignacion, $IdUsua, $Fecha)
  {
    $db = new Conexion();
    $get_valos_asis = [];

    $sql = $db->query("SELECT
tblp_asistencia.IdAsistencia,
tblc_tipo_asistencia.Icono,
tblc_tipo_asistencia.Letra,
tblc_tipo_asistencia.IdTipo,
tblp_asistencia.Observaciones
FROM
tblp_asistencia
Left Join tblc_tipo_asistencia ON tblc_tipo_asistencia.IdTipo = tblp_asistencia.IdTipo
WHERE tblp_asistencia.IdAsignacion = '$IdAsignacion' AND tblp_asistencia.IdUsua = '$IdUsua' AND tblp_asistencia.Fecha = '$Fecha'");
    while ($x = $db->recorrer($sql)) {
      $get_valos_asis[] = $x;
    }
    return $get_valos_asis;
  }

  public function get_ejecPaseLista($IdAsignacion)
  {
    $db = new Conexion();
    $sql_a = $db->query("SELECT tblp_asistencia.IdAsistencia FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' ");
    $db->rows($sql_a);
    $_asis = $db->recorrer($sql_a);
    $IdAs = $_asis['IdAsistencia'];
    if (!$IdAs) {
      $hc = 0;
      $_d1 = 0;
      $_d2 = 0;
      $_d3 = 0;
      $_d4 = 0;

      $sql = $db->query("SELECT tblp_horario.IdHorario, tblp_horario.IdDia FROM tblp_horario WHERE tblp_horario.IdAsignacion =  '$IdAsignacion' AND tblp_horario.Total > 0 ");
      while ($x = $db->recorrer($sql)) {
        $hc = ($hc + 1);
        if ($hc == 1) {
          $_d1 = $x['IdDia'];
        }
        if ($hc == 2) {
          $_d2 = $x['IdDia'];
        }
        if ($hc == 3) {
          $_d3 = $x['IdDia'];
        }
        if ($hc == 4) {
          $_d4 = $x['IdDia'];
        }
        if ($hc == 5) {
          $_d5 = $x['IdDia'];
        }
      }

      $sql1 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.FecIni, tblp_asignacion.FecFin FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);

      $dia = substr($datos2["FecFin"], 8, 2) + 1;
      if ($dia < 10) {
        $dia = "0" . $dia;
      }
      if ($dia == 32) {
        $dia = 31;
      }

      $_ini = substr($datos2["FecIni"], 8, 2) . '-' . substr($datos2["FecIni"], 5, 2) . '-' . substr($datos2["FecIni"], 0, 4);
      $_fin = $dia . '-' . substr($datos2["FecFin"], 5, 2) . '-' . substr($datos2["FecFin"], 0, 4);


      $fechaInicio = strtotime($_ini);
      $fechaFin = strtotime($_fin);
      $dx = 0;

      for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
        $dia = dias_semana(date("Y-m-d", $i));


        if (($dia == $_d1) || ($dia == $_d2) || ($dia == $_d3) || ($dia == $_d4)) {
          $fec = date("Y-m-d", $i);
          $dx = ($dx + 1);

          $sql_us = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
          while ($u = $db->recorrer($sql_us)) {
            $IdUsua = $u["IdUsua"];
            $anioM = substr($fec, 0, 7);

            $insertar = $db->query("INSERT INTO tblp_asistencia(IdUsua, IdAsignacion, Fecha, IdTipo, AnioMes) VALUES ('$IdUsua','$IdAsignacion','$fec','1','$anioM')");
          }
        }
      }

      $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.NoDias = '$dx' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
    }
  }

  public function get_listaAsistenciaMes($IdAsignacion, $AnioMes)
  {
    $db = new Conexion();
    $get_listaAsistenciaMes = [];

    $sql = $db->query("SELECT
      tblp_lista.IdLista,
      tblp_lista.1,
      tblp_lista.2,
      tblp_lista.3,
      tblp_lista.4,
      tblp_lista.5,
      tblp_lista.6,
      tblp_lista.7,
      tblp_lista.8,
      tblp_lista.9,
      tblp_lista.10,
      tblp_lista.11,
      tblp_lista.12,
      tblp_lista.13,
      tblp_lista.14,
      tblp_lista.15,
      tblp_lista.16,
      tblp_lista.17,
      tblp_lista.18,
      tblp_lista.19,
      tblp_lista.20,
      tblp_lista.21,
      tblp_lista.22,
      tblp_lista.23,
      tblp_lista.24,
      tblp_lista.25,
      tblp_lista.26,
      tblp_lista.27,
      tblp_lista.28,
      tblp_lista.29,
      tblp_lista.30,
      tblp_lista.31,
  tblp_lista.IdAsignacion,
  tblp_lista.IdUsua,
  tblp_lista.AnioMes,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno,
  tblc_usuario.Foto
  FROM
  tblp_lista
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_lista.IdUsua
  WHERE tblp_lista.IdAsignacion = '$IdAsignacion' AND tblp_lista.AnioMes = '$AnioMes'
  ORDER BY
  tblc_usuario.AMaterno ASC,
  tblc_usuario.AMaterno ASC,
  tblc_usuario.Nombre ASC
  ");
    while ($x = $db->recorrer($sql)) {
      $get_listaAsistenciaMes[] = $x;
    }
    return $get_listaAsistenciaMes;
  }
  public function get_listaAsistencia($IdAsignacion, $AnioMes, $Dia)
  {
    $db = new Conexion();
    $anio = date("Y");
    $mes = date("m");

    $get_listaAsistencia = [];
    $Dia = ($Dia * 1);
    $sql = $db->query("SELECT
tblp_lista.IdLista,
tblp_lista.IdAsignacion,
tblp_lista.IdUsua,
tblp_lista.AnioMes,
tblp_lista.$Dia,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_lista
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_lista.IdUsua
WHERE tblp_lista.IdAsignacion = '$IdAsignacion' AND tblp_lista.AnioMes = '$AnioMes'
ORDER BY
tblc_usuario.AMaterno ASC,
tblc_usuario.AMaterno ASC,
tblc_usuario.Nombre ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_listaAsistencia[] = $x;
    }
    return $get_listaAsistencia;
  }

  public function get_datosPasarLista($IdAsignacion)
  {
    $db = new Conexion();
    $get_datosPasarLista = [];
    $sql = $db->query("SELECT * FROM tblp_horario WHERE tblp_horario.IdAsignacion = '$IdAsignacion' AND Total IS NOT NULL");
    while ($x = $db->recorrer($sql)) {
      $get_datosPasarLista[] = $x;
    }
    return $get_datosPasarLista;
  }

  public function get_listaMeses($IdAsignacion)
  {
    $db = new Conexion();
    $get_listaMeses = [];
    $sql = $db->query("SELECT tblp_lista.IdLista, tblp_lista.IdAsignacion, tblp_lista.AnioMes FROM tblp_lista WHERE tblp_lista.IdAsignacion = '$IdAsignacion' GROUP BY tblp_lista.AnioMes");
    while ($x = $db->recorrer($sql)) {
      $get_listaMeses[] = $x;
    }
    return $get_listaMeses;
  }

  # OBTENER GRUPO ACTIVO
  public function get_grupoActivo($idEduca, $idMod, $grupo, $idAsignacion)
  {
    $db = new Conexion();
    $get_grupoActivo = [];
    $sql = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno, tblp_moduloalumno.IdUsua, tblp_moduloalumno.Equipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Matricula, tblc_estatus.Estatus FROM tblp_moduloalumno LEFT JOIN tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua LEFT JOIN tblc_estatus ON tblc_usuario.IdEstatus = tblc_estatus.IdEstatus WHERE tblp_moduloalumno.IdAsignacion = '$idAsignacion' ORDER BY tblp_moduloalumno.Equipo, tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC	");
    while ($x = $db->recorrer($sql)) {
      $get_grupoActivo[] = $x;
    }
    return $get_grupoActivo;
  }


  public function get_lstGrupoA()
  {
    $db = new Conexion();
    $get_lstGrupoA = [];
    $sql = $db->query("SELECT * FROM tblp_grupo");
    while ($x = $db->recorrer($sql)) {
      $get_lstGrupoA[] = $x;
    }
    return $get_lstGrupoA;
  }

  public function get_lstGrpMatr($IdOferta)
  {
    $db = new Conexion();
    $get_lstGrpMatr = [];
    $sql = $db->query("SELECT tblc_usuario.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Grupo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.Tipo =  '3' AND tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.IdGrupo IS NOT NULL GROUP BY tblc_usuario.IdGrupo");
    while ($x = $db->recorrer($sql)) {
      $get_lstGrpMatr[] = $x;
    }
    return $get_lstGrpMatr;
  }

  public function get_lstAlumnsMx($IdOferta, $IdGrupo)
  {
    $db = new Conexion();
    $get_lstAlumnsMx = [];
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.Matricula FROM tblc_usuario WHERE tblc_usuario.Tipo =  '3' AND tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.IdGrupo =  '$IdGrupo' ORDER BY tblc_usuario.APaterno ASC");
    while ($x = $db->recorrer($sql)) {
      $get_lstAlumnsMx[] = $x;
    }
    return $get_lstAlumnsMx;
  }

  # OBTENER DATOS EL USUARIO
  public function get_datosUser($idUser)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblc_usuario.FecNac FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$idUser'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $fecNa = $datos2['FecNac'];
    if ($fecNa == '0000-00-00') {
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.FecNac = NULL WHERE tblc_usuario.IdUsua = '$idUser'");
    }

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.id_paquete, tblc_usuario.fecha_firma, tblc_usuario.Nombre AS NombreUser, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Permisos, tblc_usuario.Estatus, tblc_usuario.Sexo, tblc_usuario.Foto, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblp_educativa.Nombre AS NombreOfe, tblp_educativa.Tipo, tblp_docente.Semblanza, tblc_usuario.Matricula FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblp_docente ON tblp_docente.IdUsua = tblc_usuario.IdUsua WHERE tblc_usuario.IdUsua = '$idUser'");
    while ($x = $db->recorrer($sql)) {
      $get_datosUser[] = $x;
    }
    return $get_datosUser;
  }

  public function get_docente_id($IdUsua)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblc_usuario.FecNac FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $fecNa = $datos2['FecNac'];
    if ($fecNa == '0000-00-00') {
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.FecNac = NULL WHERE tblc_usuario.IdUsua = '$IdUsua'");
    }

    $sql = $db->query("SELECT
	tblc_usuario.IdUsua, 
	tblc_usuario.Nombre AS NombreUser, 
	tblc_usuario.Nombre, 
	tblc_usuario.APaterno, 
	tblc_usuario.AMaterno, 
	tblc_usuario.Cargo, 
	tblc_usuario.Telefono, 
	tblc_usuario.Celular, 
	tblc_usuario.FecNac, 
	tblc_usuario.Estado, 
	tblc_usuario.FecAlta, 
	tblc_usuario.id_paquete, 
	tblc_usuario.Correo, 
	tblc_usuario.Correo_institucional, 
	tblc_usuario.Sexo, 
	tblc_usuario.Foto, 
	tblc_usuario.Usuario, 
	tblp_docente.Semblanza, 
	tblc_campus.Campus
FROM
	tblc_usuario
	LEFT JOIN
	tblp_docente
	ON 
		tblp_docente.IdUsua = tblc_usuario.IdUsua
	LEFT JOIN
	tblc_campus
	ON 
		tblc_usuario.IdCampus = tblc_campus.IdCampus
WHERE
	tblc_usuario.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_docente_id[] = $x;
    }
    return $get_docente_id;
  }

  public function get_lstOfertauds()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_educativa.IdEducativa, tblp_educativa.Clave, tblp_educativa.Nombre FROM tblp_educativa WHERE tblp_educativa.Imagen = '1' ORDER BY tblp_educativa.IdGrado ASC ");
    while ($x = $db->recorrer($sql)) {
      $gdaser[] = $x;
    }
    return $gdaser;
  }

  public function get_gradosEst($IdUsua)
  {
    $db = new Conexion();
    $gGradoUser = [];
    $sql = $db->query("SELECT
tblp_gradodoc.IdGrado,
tblp_gradodoc.Nombre,
tblc_grado.Descripcion
FROM
tblp_gradodoc
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_gradodoc.Grado
 WHERE tblp_gradodoc.IdUsua = '$IdUsua'
ORDER BY
tblc_grado.IdGrado ASC");
    while ($x = $db->recorrer($sql)) {
      $gGradoUser[] = $x;
    }
    return $gGradoUser;
  }

  public function get_datInformacion($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblp_educativa.IdEducativa,
tblp_educativa.Clave,
tblp_educativa.IdGrado,
tblp_educativa.Nombre AS NomEducativa,
tblc_usuario.Matricula,
tblc_usuario.Semblanza,
tblp_grupo.CveGrupo,
tblp_grupo.Grupo,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Correo_institucional,
tblc_usuario.SemCua,
tblc_usuario.Celular,
tblc_usuario.FecNac,
tblp_grupo.IdGrupo,
tblp_grupo.Estatus,
tblp_grupo.Tipo,
tblp_grupo.Turno,
tblp_grupo.Oferta,
tblp_grupo.Modalidad,
tblp_grupo.IdCampus,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gdatosUserd[] = $x;
    }
    return $gdatosUserd;
  }

  public function get_chk_beca_alumno_id($IdUsua)
  {
    $db = new Conexion();
    // $Hoy = date("Y-m-d");
    // $anioMes = date("Y-m");
    // $mto = 0; 
    
    // $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    // $db->rows($sql1);
    // $datos2 = $db->recorrer($sql1);
    
    // $grado =  $datos2['Grado'];
    

    $sql_beca = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Fecha, tblp_pagos.IdCiclo, tblp_pagos.Monto, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '1' ");
    while ($_bec = $db->recorrer($sql_beca)) {
      $IdPago = $_bec["IdPago"];
      $IdPlan = $_bec["IdConcepto"];
      $Monto = $_bec["Monto"];
      $IdCiclo = $_bec["IdCiclo"];

      $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdCiclo = '$IdCiclo' AND  tblp_beca.IdConcepto = '$IdPlan' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' ");
      $db->rows($sqlx9);
      $datosx91 = $db->recorrer($sqlx9);
      if (isset($datosx91['Descuento'])) {
        $IdBeca = $datosx91['IdBeca'];
        $Descuento = $datosx91['Descuento'];
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '$Descuento', tblp_pagos.IdBeca = '$IdBeca' WHERE tblp_pagos.IdPago= '$IdPago' ");
      } else {
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '0' WHERE tblp_pagos.IdPago= '$IdPago' ");
      }
    }
  }


  public function get_chkPago($IdUsua)
  {
    $db = new Conexion();
    $Hoy = date("Y-m-d");
    $anioMes = date("Y-m");
    $mto = 0; 

    // $sql_beca_cal = $db->query("SELECT tblp_beca.IdBeca, tblp_beca.Descuento, tblp_beca.Porcentaje, tblp_pagos.Monto FROM tblp_beca Left Join tblp_pagos ON tblp_pagos.IdUsua = tblp_beca.IdUsua AND tblp_pagos.IdConcepto = tblp_beca.IdConcepto AND tblp_pagos.IdCiclo = tblp_beca.IdCiclo WHERE tblp_beca.IdUsua =  '$IdUsua' GROUP BY tblp_beca.IdConcepto     "); 
    // while ($_becx = $db->recorrer($sql_beca_cal)) {
    //   $Monto = $_becx["Monto"];
    //   $Porcentaje = $_becx["Porcentaje"];
    //   $Descuento = $_becx["Descuento"];
    //   if(!$Descuento){
    //     $importe = $_becx["Monto"];
    //     $desc = ($_becx["Monto"] / 100 );
    //     $descuento = ($desc * $_becx["Porcentaje"] );
    //     $total = ($importe - $descuento);
    //     //$insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$importe', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$total' WHERE tblp_beca.IdBeca= '".$_becx['IdBeca']."' ");
    //   }
    // }

    // $sql_beca = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Fecha, tblp_pagos.IdCiclo, tblp_pagos.Monto, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '1' ");
    // while ($_bec = $db->recorrer($sql_beca)) {
    //   $IdPago = $_bec["IdPago"];
    //   $IdPlan = $_bec["IdConcepto"];
    //   $Monto = $_bec["Monto"];
    //   $IdCiclo = $_bec["IdCiclo"];

    //   $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdCiclo = '$IdCiclo' AND  tblp_beca.IdConcepto = '$IdPlan' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' ");
    //   $db->rows($sqlx9);
    //   $datosx91 = $db->recorrer($sqlx9);
    //   $IdBeca = $datosx91['IdBeca'];
    //   $Descuento = $datosx91['Descuento'];
    //   if ($Descuento) {
    //     $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '$Descuento', tblp_pagos.IdBeca = '$IdBeca' WHERE tblp_pagos.IdPago= '$IdPago' ");
    //   } else {
    //     $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '0' WHERE tblp_pagos.IdPago= '$IdPago' ");
    //   }
    // }

    $sql = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus <> '4' AND tblp_pagos.Fecha < '$Hoy'");
    while ($x = $db->recorrer($sql)) {
      $_fecha = $x["Fecha"];
      
      $_mesRecargoAplicado = $x["MesRecargo"];
      if ($_mesRecargoAplicado <> $anioMes) {
        $IdPago = $x["IdPago"];
        $IdConPlan = $x["IdConceptoPlan"];
        $descuento = $x["Descuento"];
        $monto = $x["Monto"];
        $pagar = $monto - $descuento;
        $_recargo = $x["Recargos"];

        $sql8 = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdConPlan'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $Recar = $datos81["Recargo"];

        $montoRecargo = ($monto / 100);
        $montoRecargo = ($montoRecargo * $Recar);
        $_recargo = ($_recargo + $montoRecargo);

        $insertar = $db->query("INSERT INTO tblp_recargos (IdPago, IdUsua, AnioMes, Monto, IdEstatus, FecCap, Filtro) VALUES ('$IdPago','$IdUsua','$anioMes','$_recargo','8',NOW(),'1')");
        $Mses = date("m");
        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Recargos = '$_recargo', tblp_pagos.MesRecargo = '$anioMes' WHERE tblp_pagos.IdPago = '$IdPago'");
      }
    }
  }

  public function get_chkDeuda($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_saldo.IdSaldo, Sum(tblp_saldo.Monto) AS Saldo FROM tblp_saldo WHERE tblp_saldo.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gdatoSald[] = $x;
    }
    return $gdatoSald;
  }

  public function get_datKardex($IdUsua, $IdEducativa)
  {
    $db = new Conexion();
    $get_datKardex = [];

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.IdAsignacion,
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdModulo,
tblp_moduloalumno.Cal,
tblp_moduloalumno.Estatus,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Grado,
tblc_abreviatura.Abreviatura,
tblp_moduloalumno.ParcialF1,
tblp_moduloalumno.ParcialF2,
tblp_moduloalumno.ParcialF3,
tblp_moduloalumno.ParcialF4,
tblp_moduloalumno.Promedio,
tblp_moduloalumno.E1,
tblp_moduloalumno.E2,
tblp_grupo.CveGrupo,
tblp_asignacion.NoParcial,
tblp_asignacion._texto
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' AND
tblp_moduloalumno.IdEducativa =  '$IdEducativa' AND
tblp_asignacion.Tipo =  '2' ");
    while ($x = $db->recorrer($sql)) {
      $get_datKardex[] = $x;
    }
    return $get_datKardex;
  }

  public function get_materias_asig_id($IdUsua)
  {
    $db = new Conexion();
    $get_datKardex = [];

    $sql = $db->query("SELECT
    tblp_moduloalumno.IdModuloAlumno,
    tblp_moduloalumno.IdUsua,
    tblp_moduloalumno.IdAsignacion,
    tblp_moduloalumno.IdEducativa,
    tblp_moduloalumno.IdModulo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Grado,
    tblc_ciclo.Ciclo,
    tblp_asignacion.IdCiclo,
    RMateria.CodeModulo AS RCode,
    RMateria.NombreMod AS RNombre,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno
    FROM
    tblp_moduloalumno
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
    Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    Left Join tblp_modulo AS RMateria ON RMateria.IdModulo = tblp_moduloalumno._idModulo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
    WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' AND tblp_asignacion.Tipo = '2' ORDER BY
tblc_ciclo.FInicio ASC,
tblp_modulo.CodeModulo ASC
     ");
    while ($x = $db->recorrer($sql)) {
      $get_datKardex[] = $x;
    }
    return $get_datKardex;
  }

  public function get_datKardexId($IdUsua)
  {
    $db = new Conexion();
    $get_datKardexId = [];


    $sql = $db->query("SELECT
    tblp_moduloalumno.IdModuloAlumno,
    tblp_moduloalumno.IdUsua,
    tblp_moduloalumno.IdAsignacion,
    tblp_moduloalumno.IdEducativa,
    tblp_moduloalumno.IdModulo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Grado,
    tblc_ciclo.Ciclo,
    tblp_asignacion.IdCiclo,
    RMateria.CodeModulo AS RCode,
    RMateria.NombreMod AS RNombre,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno
    FROM
    tblp_moduloalumno
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
    Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    Left Join tblp_modulo AS RMateria ON RMateria.IdModulo = tblp_moduloalumno._idModulo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
    WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' ORDER BY
tblp_moduloalumno.IdEducativa DESC,
tblp_moduloalumno.FecCap DESC");
    while ($x = $db->recorrer($sql)) {
      $get_datKardexId[] = $x;
    }
    return $get_datKardexId;
  }

  public function get_mi_practica_id($IdUsua) {
    $db = new Conexion();

    $get_mi_practica_id = [];
    $sql = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdEstatus = '4'");
    while($x = $db->recorrer($sql)){
      $get_mi_practica_id[] = $x;
    }
    return $get_mi_practica_id;
  }

  public function get_mi_servicio_id($IdUsua) {
    $db = new Conexion();

    $get_mi_servicio_id = [];
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua' AND tblp_servicio.IdEstatus = '4'");
    while($x = $db->recorrer($sql)){
      $get_mi_servicio_id[] = $x;
    }
    return $get_mi_servicio_id;
  }

  public function get_aviso_id($IdAviso) {
    $db = new Conexion();

    $get_aviso_id = [];
    $sql = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdAviso = '$IdAviso' ");
    while($x = $db->recorrer($sql)){
      $get_aviso_id[] = $x;
    }
    return $get_aviso_id;
  }

  public function get_constancias_estudio_id($IdUsua) {
    $db = new Conexion();

    $get_constancias_estudio_id = [];
    $sql = $db->query("SELECT
    tblp_docs_solicitados.IdDocumento,
    tblp_docs_solicitados.IdPago,
    tblp_docs_solicitados.IdEstatus,
    tblc_ciclo.Ciclo,
    tblp_docs_solicitados.FecAprobado,
    tblc_conceptosplanes.NomPlan,
    tblp_docs_solicitados.qrCode
    FROM
    tblp_docs_solicitados
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo
    Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_docs_solicitados.IdConceptoPlan
    WHERE
    tblp_docs_solicitados.IdUsua =  '$IdUsua' AND
    tblp_docs_solicitados.IdEstatus =  '4'
    ORDER BY
    tblp_docs_solicitados.FecAprobado DESC
     ");
    while($x = $db->recorrer($sql)){
      $get_constancias_estudio_id[] = $x;
    }
    return $get_constancias_estudio_id;
  }


  public function get_validar_docs($IdPractica,$IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_practica_docs WHERE tblp_practica_docs.IdUsua = '$IdUsua' ");
    while($x = $db->recorrer($sql)){
      if (!isset($x['IdPractica'])) {
        $insertar = $db->query("UPDATE tblp_practica_docs SET tblp_practica_docs.IdPractica = '$IdPractica' WHERE tblp_practica_docs.IdDocsPractica = '".$x['IdDocsPractica']."'  ");
      }
    }
  }


  # OBTENER DATOS DEL DOCENTE
  public function get_datoDocente($idUser)
  {
    $db = new Conexion();

    $sql_plan = $db->query("SELECT tblc_usuario.IdUsua, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$idUser' ");
    $db->rows($sql_plan);
    $_gradx = $db->recorrer($sql_plan);
    if(isset($_gradx['IdGrado'])){
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Grado = '".$_gradx['IdGrado']."' WHERE tblc_usuario.IdUsua = '$idUser' ");
    }

    $sql7 = $db->query("SELECT tblc_datosfactura.IdUsua FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$idUser'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    
    if (!isset($datos71["IdUsua"])) {
      $_idUs = $datos71["IdUsua"];
      $insertar = $db->query("INSERT INTO tblc_datosfactura (IdUsua) VALUES('$idUser')");
    }

    $get_datoDocente = [];

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario._horario, tblc_usuario.id_paquete, tblc_usuario.Grado, tblc_usuario.Estado, tblc_usuario.IdOferta, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.FecNac, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Sexo, tblc_usuario.Correo_institucional, tblc_usuario.FecAlta, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Foto, tblc_usuario.Celular, tblc_usuario.Permisos, tblc_usuario._tipo, tblc_usuario.IdGrupo, tblc_usuario.NoDoc FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$idUser'");
    while ($x = $db->recorrer($sql)) {
      $get_datoDocente[] = $x;
    }
    return $get_datoDocente;
  }

  public function get_docsSubir($IdGrado)
  {
    $db = new Conexion();
    $get_docsSubir = [];
    $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGrado'");
    while ($x = $db->recorrer($sql)) {
      $get_docsSubir[] = $x;
    }
    return $get_docsSubir;
  }

  public function get_lstdocsSubir($IdUsua)
  {
    $db = new Conexion();
    $gdDoxcxsx = [];
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.Archivo, tblc_docalumnos.Estatus, tblc_docalumnos.FecCap, tblh_tipodocumento.Nombre, tblc_docalumnos.Anio, tblc_docalumnos.Mes FROM tblc_docalumnos Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblc_docalumnos.IdTipoDocumento WHERE tblc_docalumnos.IdUsua = '$IdUsua' AND tblc_docalumnos.IdTipoDocumento < 100");
    while ($x = $db->recorrer($sql)) {
      $gdDoxcxsx[] = $x;
    }
    return $gdDoxcxsx;
  }



  public function get_datosFactura($IdUsua)
  {
    $db = new Conexion();
    $sql7 = $db->query("SELECT tblc_datosfactura.IdUsua FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $_idUs = $datos71["IdUsua"];
    if (!$_idUs) {
      $insertar = $db->query("INSERT INTO tblc_datosfactura (IdUsua) VALUES('$IdUsua')");
    }

    $get_datosFactura = [];
    $sql = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_datosFactura[] = $x;
    }
    return $get_datosFactura;
  }

  # OBTENER RECURSOS DE APOYO
  public function get_recursosApoyo($idAsignacion)
  {
    $db = new Conexion();
    $get_recursosApoyo = [];

    $sql = $db->query("SELECT
tblp_biblioteca.IdBiblioteca,
tblp_biblioteca.Nombre,
tblp_biblioteca.Tipo,
tblp_biblioteca.IdTema,
tblp_parcialdocente.Titulo,
tblp_parcialdocente.NoParcial,
tblp_semanadocente.NoSemana,
tblp_semanadocente.Etiqueta_semana,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.IdTipoActividad,
tblp_temas.Descripcion
FROM
tblp_biblioteca
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_biblioteca.IdActividadesDocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente
Left Join tblp_temas ON tblp_temas.IdTema = tblp_biblioteca.IdTema
WHERE
tblp_biblioteca.IdAsignacion =  '$idAsignacion'
ORDER BY
tblp_parcialdocente.NoParcial ASC,
tblp_semanadocente.NoSemana ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_recursosApoyo[] = $x;
    }
    return $get_recursosApoyo;
  }
  public function get_archivos($IdOferta, $Nombre, $IdAsignacion)
  {
    $db = new Conexion();


    $sql9 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdGrupo, tblp_grupo.CveGrupo FROM tblp_asignacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Cve = substr($datos91["CveGrupo"], 5, 1);
    if ($Cve == "E") {
      $kst = "Escolar";
    } else {
      $kst = "No escolar";
    }



    $gfilesaA = [];
    $sql = $db->query("SELECT
tblp_archivo.IdArchivo,
tblp_archivo.IdOferta,
tblp_archivo.IdModulo,
tblp_archivo.Nombre,
tblp_archivo.Link,
tblp_archivo.IdUsua,
tblp_archivo.FecCap,
tblp_archivo.Tipo,
tblp_modulo.NombreMod
FROM
tblp_archivo
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_archivo.IdModulo
WHERE tblp_archivo.IdOferta = '$IdOferta' AND tblp_modulo.NombreMod = '$Nombre' AND tblp_archivo.Tipo = '$kst'");
    while ($x = $db->recorrer($sql)) {
      $gfilesaA[] = $x;
    }
    return $gfilesaA;
  }

  # OBTENER RECURSOS DE APOYO
  public function get_gruposTotal($IdCampus, $IdOferta)
  {
    if ($IdOferta) {
      $get_gruposTotal = [];
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' ORDER BY tblp_grupo.Anio ASC, tblp_grupo.Grupo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_gruposTotal[] = $x;
      }
      return $get_gruposTotal;
    }
  }

  public function get_gruposTotalC($IdOferta, $IdCampus)
  {
    if ($IdOferta) {

      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' ORDER BY tblp_grupo.CveGrupo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_gruposTotalC[] = $x;
      }
      return $get_gruposTotalC;
    }
  }

  public function get_gruposCampus($IdCampus)
  {
    if ($IdCampus) {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' ORDER BY tblp_grupo.CveGrupo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_gruposCampus[] = $x;
      }
      return $get_gruposCampus;
    }
  }

  public function get_gruposLib($IdCampus, $IdOferta)
  {
    if ($IdOferta) {
      $get_gruposLib = [];
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' AND (tblp_grupo.Tipo = 'Abierto' OR tblp_grupo.IdEstatus = '12') ORDER BY tblp_grupo.CveGrupo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_gruposLib[] = $x;
      }
      return $get_gruposLib;
    }
  }

  public function get_grupos_cuc()
  {
    $get_grupos_cuc = [];
    $db = new Conexion();
    $sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_educativa.Nombre,
tblc_ciclo.Ciclo
FROM
tblp_grupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_grupo.IdCicloIni
WHERE
tblp_grupo.IdEstatus =  '12' AND
tblp_educativa.IdGrado =  '8'
ORDER BY
tblc_ciclo.FInicio DESC
");
    while ($x = $db->recorrer($sql)) {
      $get_grupos_cuc[] = $x;
    }
    return $get_grupos_cuc;
  }

  public function get_matrLib($IdCampus, $IdOferta)
  {
    if ($IdOferta) {
      $get_matrLib = [];
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblc_seriacion WHERE tblc_seriacion.IdCampus = '$IdCampus' AND tblc_seriacion.IdOferta = '$IdOferta'");
      while ($x = $db->recorrer($sql)) {
        $get_matrLib[] = $x;
      }
      return $get_matrLib;
    }
  }

  public function get_matr_cur($IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();
      $sql7 = $db->query("SELECT tblp_grupo.IdCampus, tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql7);
      $datos71 = $db->recorrer($sql7);
      $IdCampus = $datos71["IdCampus"];
      $IdOferta = $datos71["IdOferta"];

      $get_matr_cur = [];

      $sql = $db->query("SELECT * FROM tblc_seriacion WHERE tblc_seriacion.IdCampus = '$IdCampus' AND tblc_seriacion.IdOferta = '$IdOferta'");
      while ($x = $db->recorrer($sql)) {
        $get_matr_cur[] = $x;
      }
      return $get_matr_cur;
    }
  }

  public function get_plan_pag($IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();
      $sql7 = $db->query("SELECT tblp_grupo.IdCicloIni FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql7);
      $datos71 = $db->recorrer($sql7);
      $IdCiclo = $datos71["IdCicloIni"];


      $get_plan_pag = [];

      $sql = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.Monto, tblc_conceptosplanes.NomPlan FROM tblp_calendario Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes WHERE tblp_calendario.IdGrado =  '8' AND tblp_calendario.IdCiclo =  '$IdCiclo'");
      while ($x = $db->recorrer($sql)) {
        $get_plan_pag[] = $x;
      }
      return $get_plan_pag;
    }
  }

  # OBTENER FORO ACTIVIDAD
  public function get_datosForoAlumno($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_actividad.IdActividad, tblp_actividad.IdAsignacion, tblp_actividad.TipoActividad, tblp_actividad.FecIni, tblp_actividad.FecFin, tblp_actividad.Modalidad, tblp_actividad.TituloActividad, tblp_actividad.Descripcion, tblp_actividad.Estatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_actividad.FecCap FROM tblp_actividad Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_actividad.IdUsua WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.TipoActividad='Foro' ORDER BY tblp_actividad.IdActividad DESC");
    while ($x = $db->recorrer($sql)) {
      $gRecursosA[] = $x;
    }
    return $gRecursosA;
  }

  # OBTENER FORO ACTIVIDAD
  public function get_viewAvisos($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_aviso.IdAviso, tblp_aviso.Titulo, tblp_aviso.Mensaje, tblp_aviso.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.Cargo FROM tblp_aviso Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_aviso.IdUsua WHERE tblp_aviso.IdAsignacion = '$idAsignacion' ORDER BY tblp_aviso.IdAviso DESC");
    while ($x = $db->recorrer($sql)) {
      $gRecursosAs[] = $x;
    }
    return $gRecursosAs;
  }

  # OBTENER FORO ACTIVIDAD
  public function get_datosForoAlumnoId($idAsignacion, $IdActividad)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.IdEstatus,
tblp_parcialdocente.IdParcialDocente,
tblp_parcialdocente.NoParcial,
tblp_semanadocente.NoSemana
FROM
tblp_actividadesdocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente
 WHERE tblp_actividadesdocente.IdAsignacion = '$idAsignacion' AND tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");
    while ($x = $db->recorrer($sql)) {
      $gRecursosAId[] = $x;
    }
    return $gRecursosAId;
  }

  public function get_verificarTarea($IdAsignacion, $IdActividad, $IdParcial, $IdUsua)
  {
    $db = new Conexion();
    $sql8 = $db->query("SELECT tblp_tareas.IdTarea FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividad' AND tblp_tareas.IdAlumno= '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdTarea = $datos81["IdTarea"];
    if (!$IdTarea) {
      $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcial')");
    }
  }

  # OBTENER FORO ACTIVIDAD
  public function get_datosrespuestas($idAsignacion, $IdActividad)
  {
    $db = new Conexion();
    $get_datosrespuestas = [];
    $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.Total, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '$IdActividad' AND tblp_foro.IdAsignacion = '$idAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 10");
    while ($x = $db->recorrer($sql)) {
      $get_datosrespuestas[] = $x;
    }
    return $get_datosrespuestas;
  }

  public function get_datosrespuestas2X($idAsignacion, $IdActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '$IdActividad' AND tblp_foro.IdAsignacion = '$idAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 30,20");
    while ($x = $db->recorrer($sql)) {
      $gRespuestasId[] = $x;
    }
    return $gRespuestasId;
  }

  public function get_datosrespuestas3X($idAsignacion, $IdActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '$IdActividad' AND tblp_foro.IdAsignacion = '$idAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 50,20");
    while ($x = $db->recorrer($sql)) {
      $gRespuestasId[] = $x;
    }
    return $gRespuestasId;
  }

  public function get_datosrespuestas4X($idAsignacion, $IdActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '$IdActividad' AND tblp_foro.IdAsignacion = '$idAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 70,150");
    while ($x = $db->recorrer($sql)) {
      $gRespuestasId[] = $x;
    }
    return $gRespuestasId;
  }
  # OBTENER FORO ACTIVIDAD
  public function get_datosrespuestasId($IdForo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_detalleforo.IdDetalle, tblp_detalleforo.IdForo, tblp_detalleforo.Mensaje, tblp_detalleforo.IdUsua, tblp_detalleforo.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_detalleforo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_detalleforo.IdUsua WHERE tblp_detalleforo.IdForo = '$IdForo'");
    while ($x = $db->recorrer($sql)) {
      $gRespuestasIdF[] = $x;
    }
    return $gRespuestasIdF;
  }

  # OBTENER FORO ACTIVIDAD
  public function get_foroRespuestas($IdActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_detalleforo.IdDetalle) AS Suma FROM tblp_detalleforo WHERE tblp_detalleforo.IdActividad =  '$IdActividad'");
    while ($x = $db->recorrer($sql)) {
      $gRespueasIdF[] = $x;
    }
    return $gRespueasIdF;
  }

  # OBTENER TOTAL COMENTARIO
  public function get_datosForoTotComent($idActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_foro.IdForo) AS TotalComent FROM tblp_foro WHERE tblp_foro.IdActividad = '$idActividad'");
    while ($x = $db->recorrer($sql)) {
      $gForoC[] = $x;
    }
    return $gForoC;
  }
  # OBTENER FORO ACTIVIDAD
  public function get_datosActividadesAlumno($idAsignacion)
  {
    $db = new Conexion();
    $gRecursosAc = [];
    $sql = $db->query("SELECT tblp_actividad.IdActividad, tblp_actividad.IdAsignacion, tblp_actividad.TipoActividad, tblp_actividad.FecIni, tblp_actividad.FecFin, tblp_actividad.Modalidad, tblp_actividad.TituloActividad, tblp_actividad.Descripcion, tblp_actividad.Estatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_actividad.FecCap, tblp_actividad.NoActividad FROM tblp_actividad Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_actividad.IdUsua WHERE tblp_actividad.IdAsignacion = '$idAsignacion' AND tblp_actividad.Estatus <>  '' AND tblp_actividad.TipoActividad <> 'Foro' ORDER BY tblp_actividad.IdActividad DESC");
    while ($x = $db->recorrer($sql)) {
      $gRecursosAc[] = $x;
    }
    return $gRecursosAc;
  }

  # OBTENER FORO ACTIVIDAD
  public function get_lstAvisos($idAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_aviso WHERE tblp_aviso.IdAsignacion = '$idAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gRecosAc[] = $x;
    }
    return $gRecosAc;
  }

  # OBTENER FORO ACTIVIDAD
  public function get_respuestaAlumnos($IdActividadDoc, $idAsignacion)
  {
    $db = new Conexion();
    $gtareasE = [];
    $sql = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$idAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc' AND tblp_tareas.IdAlumno = '" . $_SESSION['IdUsua'] . "'");
    while ($x = $db->recorrer($sql)) {
      $gtareasE[] = $x;
    }
    return $gtareasE;
  }

  # OBTENER RESPUESTAS CONTESTADAS DEL ALUMNO DEL EXAMEN
  public function get_mostrarRespuestasContest($idAsignacion, $NoActividad, $IdExamen)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_resultadoexamen.NoPregunta, tblp_resultadoexamen.IdExamen, tblp_resultadoexamen.IdRespuesta AS Respondio, tblp_respuestaexamen.IdRespuesta, tblp_respuestaexamen.Respuesta, tblp_respuestaexamen.Valor FROM tblp_resultadoexamen Left Join tblp_respuestaexamen ON tblp_respuestaexamen.IdExamen = tblp_resultadoexamen.IdExamen WHERE tblp_resultadoexamen.IdExamen =  '$IdExamen' AND tblp_resultadoexamen.IdUsua =  '" . $_SESSION['IdUsua'] . "' AND tblp_resultadoexamen.IdAsignacion =  '$idAsignacion' AND tblp_resultadoexamen.NoActividad =  '$NoActividad'");
    while ($x = $db->recorrer($sql)) {
      $gtareasEd[] = $x;
    }
    return $gtareasEd;
  }

  # OBTENER LAS AXCTIVIDADES
  public function get_actividad($idActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.NoActividad = '$idActividad'");
    while ($x = $db->recorrer($sql)) {
      $gactividad[] = $x;
    }
    return $gactividad;
  }

  # OBTENER LAS AXCTIVIDADES
  public function get_actividadNo($asignacion, $IdActividadDoc)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$asignacion' AND tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
    while ($x = $db->recorrer($sql)) {
      $gactividadNo[] = $x;
    }
    return $gactividadNo;
  }
  
  public function get_actividad_user_id($IdAsignacion, $IdActividad, $IdGrupo,$IdParcial)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
       $IdUsua = $x['IdUsua'];
     
        $sql8 = $db->query("SELECT tblp_tareas.IdTarea FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividad' AND tblp_tareas.IdAlumno= '$IdUsua'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $IdTarea = $datos81["IdTarea"];
        if (!isset($IdTarea)) { //echo 'hola';
         $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcial')");
        }
    }
  }

  # OBTENER LAS AXCTIVIDADES
  public function get_listarespuesta($asignacion, $IdActividadDoc, $tipo)
  {
    $db = new Conexion();

    $get_listarespuesta = [];
    $sql = $db->query("SELECT
	tblp_tareas.IdTarea, 
	tblp_tareas.IdAlumno, 
	tblp_tareas.Link, 
	tblp_tareas.Link2, 
	tblp_tareas.Link3, 
	tblp_tareas.Calificacion, 
	tblp_tareas.Porcentaje, 
	tblp_tareas.NoActividad, 
	tblc_usuario.IdUsua, 
	tblc_usuario.Nombre, 
	tblc_usuario.APaterno, 
	tblc_usuario.AMaterno, 
	tblc_estatus.Estatus, 
	tblp_tareas.ExtensionArchivo, 
	tblp_tareas.PesoArchivo
FROM
	tblp_tareas
	LEFT JOIN
	tblc_usuario
	ON 
		tblc_usuario.IdUsua = tblp_tareas.IdAlumno
	LEFT JOIN
	tblc_estatus
	ON 
		tblc_usuario.IdEstatus = tblc_estatus.IdEstatus
WHERE tblp_tareas.IdAsignacion =  '$asignacion' AND tblp_tareas.IdActividadesDocente =  '$IdActividadDoc' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC");

    while ($x = $db->recorrer($sql)) {
      $get_listarespuesta[] = $x;
    }
    return $get_listarespuesta;
  }

  public function get_datParc($IdParcialDoc)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc'");
    while ($x = $db->recorrer($sql)) {
      $gaPareciao[] = $x;
    }
    return $gaPareciao;
  }

  # OBTENER LAS AXCTIVIDADES
  public function get_listaPreguntas($asignacion, $noActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_examen WHERE tblp_examen.IdAsignacion = '$asignacion' AND tblp_examen.NoActividad = '$noActividad'");
    while ($x = $db->recorrer($sql)) {
      $glistaPreguntas[] = $x;
    }
    return $glistaPreguntas;
  }

  public function get_equipoo($IdAsignacion, $IdUsua, $IdOferta, $IdModulo)
  {
    $db = new Conexion();
    $get_equipoo = [];
    $sql = $db->query("SELECT tblp_moduloalumno.Equipo FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdEducativa = '$IdOferta' AND tblp_moduloalumno.IdModulo = '$IdModulo' ");
    while ($x = $db->recorrer($sql)) {
      $get_equipoo[] = $x;
    }
    return $get_equipoo;
  }

  # CHECAR EL TOTAL DE DOCENTES
  public function get_checarUser($tipo)
  {
    if ($tipo == 3) {
      $cond = " AND tblc_usuario.IdGrupo IS NOT NULL";
    } else {
      $cond = "";
    }
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.Tipo='$tipo' AND tblc_usuario.Estado='Activo' $cond");
    while ($x = $db->recorrer($sql)) {
      $gTotalEst[] = $x;
    }
    return $gTotalEst;
  }

  # OBTENER MI NUMERO DE QUIPO
  public function get_miEquipo($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Equipo FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua ='$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gMiEquipo[] = $x;
    }
    return $gMiEquipo;
  }

  # OBTENER EQUIPO LISTA
  public function get_miEquipoDet($IdAsignacion, $Equipo)
  {
    $db = new Conexion();
    $gMiEquipoDet = [];
    $sql = $db->query("SELECT tblp_moduloalumno.Equipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_moduloalumno.IdAsignacion FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.Equipo = '$Equipo'");
    while ($x = $db->recorrer($sql)) {
      $gMiEquipoDet[] = $x;
    }
    return $gMiEquipoDet;
  }

  public function get_calObtenida($IdAsignacion, $IdUsua, $IdParcialDoc)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT Sum(tblp_tareas.Calificacion) AS sumCal FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdParcialDocente =  '$IdParcialDoc' AND tblp_tareas.IdAlumno =  '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gMiEquipoDet[] = $x;
    }
    return $gMiEquipoDet;
  }

  public function get_calUpdate($IdAsignacion, $IdUsua, $calFinal)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Cal = '$calFinal' WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    $db->close();
  }

  public function get_calUpdateEx1($IdAsignacion, $IdUsua, $calFinal)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.CalExtra1 = '$calFinal' WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    $db->close();
  }

  public function get_calUpdateEx2($IdAsignacion, $IdUsua, $calFinal)
  {
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.CalExtra2 = '$calFinal' WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    $db->close();
  }

  public function get_calObtextra1($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();


    $sql7 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo = 'E' AND tblp_parcialdocente.NoParcial = '1' ");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdParcialDoc = $datos71["IdParcialDocente"];

    $sql = $db->query("SELECT Sum(tblp_tareas.Calificacion) AS sumCal FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdParcialDocente =  '$IdParcialDoc' AND tblp_tareas.IdAlumno =  '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gMiEquipoDetEx1[] = $x;
    }
    return $gMiEquipoDetEx1;
  }

  public function get_calObtextra2($IdAsignacion, $IdUsua)
  {
    $db = new Conexion();


    $sql7 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo = 'E' AND tblp_parcialdocente.NoParcial = '2' ");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdParcialDoc = $datos71["IdParcialDocente"];

    $sql = $db->query("SELECT Sum(tblp_tareas.Calificacion) AS sumCal FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdParcialDocente =  '$IdParcialDoc' AND tblp_tareas.IdAlumno =  '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gMiEquipoDetEx1[] = $x;
    }
    return $gMiEquipoDetEx1;
  }

  public function get_parcialesCal($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo = 'P'");
    while ($x = $db->recorrer($sql)) {
      $gtParciald[] = $x;
    }
    return $gtParciald;
  }

  # OBTENER ACTA DE CALIFICACION
  public function get_actaCalificacion($IdAsignacion)
  {
    $db = new Conexion();

    // $sql = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno, tblp_moduloalumno.IdUsua, tblc_usuario.IdUsua AS IdUsua2 FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ORDER BY tblc_usuario.Usuario ASC");
    // while ($y = $db->recorrer($sql)) {
    //   $IdU1 = $y['IdUsua'];
    //   $IdU2 = $y['IdUsua2'];
    //   $IdM = $y['IdModuloAlumno'];
    //   if ($IdU1 <> $IdU2) {
    //     $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdM'");
    //   }
    // }

    $gActaCalDS = [];

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.Extra1,
tblp_moduloalumno.Extra2,
tblp_moduloalumno.Parcial1,
tblp_moduloalumno.ParcialF1,
tblp_moduloalumno.Parcial2,
tblp_moduloalumno.ParcialF2,
tblp_moduloalumno.Parcial3,
tblp_moduloalumno.ParcialF3,
tblp_moduloalumno.Parcial4,
tblp_moduloalumno.ParcialF4,
tblp_moduloalumno.Promedio,
tblp_moduloalumno.Promedio_final,
tblc_usuario.IdEstatus,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC");
    while ($x = $db->recorrer($sql)) {
      $gActaCalDS[] = $x;
    }
    return $gActaCalDS;
  }

  public function get_fec_emi($IdAsignacion)
  {
    $db = new Conexion();
    $get_fec_emi = [];

    $sql = $db->query("SELECT tblp_asignacion.Fecha_impresion, tblp_asignacion.Fec_emi_bim1, tblp_asignacion.Fec_emi_bim2, tblp_asignacion.Fec_emi_bim3, tblp_asignacion.Fec_extra, tblp_grupo.Modalidad FROM tblp_asignacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while ($x = $db->recorrer($sql)) {
      $get_fec_emi[] = $x;
    }
    return $get_fec_emi;
  }







  public function get_acta_datExtra($IdAsignacion, $NoExtra)
  {
    $db = new Conexion();

    $get_acta_datExtra = [];
    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Extra1,
tblp_moduloalumno.Extra2,
tblp_moduloalumno.Extra3,
tblp_moduloalumno.E1,
tblp_moduloalumno.E2,
tblp_moduloalumno.E3,
tblp_moduloalumno.CalExtra1,
tblp_moduloalumno.CalExtra2,
tblp_moduloalumno.CalExtra3,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.Extra$NoExtra = '1'");
    while ($x = $db->recorrer($sql)) {
      $get_acta_datExtra[] = $x;
    }
    return $get_acta_datExtra;
  }

  public function get_actaCExtra1($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Extra1,
tblp_moduloalumno.Extra2,
tblp_moduloalumno.E1,
tblp_moduloalumno.E2,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.Extra1 = '1'");
    while ($x = $db->recorrer($sql)) {
      $gActaCalExtr1[] = $x;
    }
    return $gActaCalExtr1;
  }

  public function get_actaExtra2($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Extra1,
tblp_moduloalumno.Extra2,
tblp_moduloalumno.Recursar,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.Extra2 = '1'");
    while ($x = $db->recorrer($sql)) {
      $gActaCalExtr2[] = $x;
    }
    return $gActaCalExtr2;
  }

  # OBTENER ACTA DE CALIFICACION
  public function get_existeArchivo($IdAsignacion, $NoActividad, $IdAlumno)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdAlumno = '$IdAlumno' AND tblp_tareas.NoActividad = '$NoActividad'");
    while ($x = $db->recorrer($sql)) {
      $gExiste[] = $x;
    }
    return $gExiste;
  }

  public function get_datosModBus($IdDocente, $IdEducativa)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.NoModulo, tblp_modulo.NombreMod, tblp_educativa.Nombre FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdUsua = '$IdDocente' AND tblp_asignacion.IdEducativa = '$IdEducativa'");
    while ($x = $db->recorrer($sql)) {
      $geducaBuss[] = $x;
    }
    return $geducaBuss;
  }


  # PORCENTAJE DE ACTIVIDADES
  public function get_valorActividad($IdAsignacion, $NoActividad)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.IdAsignacion = '$IdAsignacion' AND tblp_actividad.NoActividad = '$NoActividad'");
    while ($x = $db->recorrer($sql)) {
      $gPorcentaje[] = $x;
    }
    return $gPorcentaje;
  }

  public function getId_usuarioId($IdUsua)
  {
    $db = new Conexion();

    $sql7 = $db->query("SELECT tblp_informacion.IdUsua FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdUsuaIn = $datos71["IdUsua"];

    $sql2 = $db->query("SELECT tblc_usuario.IdUsua, tblp_educativa.IdGrado, tblc_usuario.IdOferta FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdGra = $datos21["IdGrado"];
    $IdOfe = $datos21["IdOferta"];

    if ($IdOfe == 9) {
      $valor = 2;
    } else {
      $valor = 1;
    }

    if (!isset($datos71["IdUsua"])) {
      $insertar = $db->query("INSERT INTO tblp_informacion (IdUsua) VALUES ('$IdUsua')");

      $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGra' AND tblh_tipodocumento.Valor = '$valor'");
      while ($x = $db->recorrer($sql)) {
        $IdTDc = $x["IdTipoDoc"];
        $insertar = $db->query("INSERT INTO tblp_documentos (IdUsua, IdTipoDocumento, FecCap)VALUES ('$IdUsua','$IdTDc',NOW())");
      }
    }


    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Celular,
tblc_usuario.Correo_institucional,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Usuario,
tblc_usuario.Sexo,
tblc_usuario.FecNac,
tblc_usuario.IdCampus,
tblc_usuario.Educacion,
tblc_usuario.IdOferta,
tblp_grupo.CveGrupo,
tblp_educativa.IdGrado,
tblp_educativa.Nombre AS Educativa,
tblc_grado._Grado,
tblc_ciclo.Ciclo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias,
tblc_turno.Turno
FROM
tblc_usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_usuario.id_ciclo_ini
Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_turno ON tblc_turno.Tur = tblp_grupo.Turno WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $gUsuaId[] = $x;
    }
    return $gUsuaId;
  }

  public function getId_usuarioInfo($IdUsua)
  {
    $db = new Conexion();
    $gInfoId = [];
    $sql = $db->query("SELECT * FROM tblp_informacion WHERE tblp_informacion.IdUsua =  '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $gInfoId[] = $x;
    }
    return $gInfoId;
  }

  public function get_estados()
  {
    $db = new Conexion();
    $get_estados = [];
    $sql = $db->query("SELECT * FROM tblc_estado ");
    while ($x = $db->recorrer($sql)) {
      $get_estados[] = $x;
    }
    return $get_estados;
  }

  public function get_pais()
  {
    $db = new Conexion();
    $get_pais = [];
    $sql = $db->query("SELECT * FROM tblc_pais ");
    while ($x = $db->recorrer($sql)) {
      $get_pais[] = $x;
    }
    return $get_pais;
  }

  public function get_tipo_titulacion($IdGrado)
  {
    $db = new Conexion();
    $get_tipo_titulacion = [];
    $sql = $db->query("SELECT * FROM tblc_tipo_titulacion WHERE tblc_tipo_titulacion.IdGrado = '$IdGrado' ");
    while ($x = $db->recorrer($sql)) {
      $get_tipo_titulacion[] = $x;
    }
    return $get_tipo_titulacion;
  }

  # PORCENTAJE DE ACTIVIDADES
  public function get_ofertaId($IdEducativa)
  {
    $db = new Conexion();
    $gofertaId = [];
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdEducativa'");
    while ($x = $db->recorrer($sql)) {
      $gofertaId[] = $x;
    }
    return $gofertaId;
  }

  # CONSULTA POR PARTE DEL USUARIO ACADEMICO
  # PORCENTAJE DE ACTIVIDADES
  public function get_ingresos($anio, $mes)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblr_ingresomes WHERE tblr_ingresomes.Anio =  '$anio' AND tblr_ingresomes.Mes =  '$mes' ORDER BY tblr_ingresomes.Dia ASC");
    while ($x = $db->recorrer($sql)) {
      $gIngresosT[] = $x;
    }
    return $gIngresosT;
  }

  # REGISTRO DE INGRESOS POR TIPO DE USUARIOS
  public function get_tipoIngresos($inicio, $final)
  {

    $db = new Conexion();

    $sql = $db->query("SELECT Count(tblh_log.IdLog) AS Total, tblc_usuario.Permisos,tblh_log.Fecha,tblc_usuario.Cargo FROM tblh_log Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_log.IdUsua WHERE tblh_log.Fecha BETWEEN  '$inicio' AND '$final' GROUP BY tblc_usuario.Permisos");
    while ($x = $db->recorrer($sql)) {
      $gIngresosTP[] = $x;
    }
    return $gIngresosTP;
  }

  public function get_tipo_total_user($inicio, $final)
  {

    $db = new Conexion();

    $sql = $db->query("SELECT
    tblh_log.IdUsua,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Usuario,
    tblh_log.FecIng
    FROM
    tblh_log
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_log.IdUsua
    WHERE
    tblh_log.Fecha BETWEEN  '$inicio' AND '$final' AND
    tblc_usuario.Permisos =  '3'
    GROUP BY
    tblh_log.IdUsua
    ORDER BY
    tblc_usuario.Nombre ASC,
    tblc_usuario.AMaterno ASC,
    tblc_usuario.AMaterno ASC,
    tblh_log.FecIng DESC");
    while ($x = $db->recorrer($sql)) {
      $get_tipo_total_user[] = $x;
    }
    return $get_tipo_total_user;
  }


  # REGISTRO DE ACTIVIADADES CREADAS PÓR EL DOCENTE
  public function get_activiadescreadasDoc($IdAsignacion)
  {

    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.IdParcialDocente,
tblp_actividadesdocente.IdSemanaDocente,
tblp_actividadesdocente.IdTipoActividad,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_actividadesdocente.IdEstatus,
tblp_actividadesdocente.IdUsua,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.Modalidad,
tblp_actividadesdocente.IdAsignacion,
tblc_tipoactividad.TipoActividad,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Tipo,
tblp_semanadocente.NoSemana
FROM
tblp_actividadesdocente
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gTotaActs[] = $x;
    }
    return $gTotaActs;
  }

  # SACAMOS las calificacion
  public function get_calificaciones($IdAsignacion, $IdActividadDoc)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_tareas.IdTarea) AS Total, tblp_tareas.IdAsignacion FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc' AND tblp_tareas.Calificacion IS NOT NULL GROUP BY tblp_tareas.IdAsignacion");
    while ($x = $db->recorrer($sql)) {
      $gcalifi[] = $x;
    }
    return $gcalifi;
  }



  # SACAMOS los alu,nos quie contestarosn
  public function alumnoscontestaron($IdAsignacion, $IdActividadDoc)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_tareas.IdTarea) AS Total, tblp_tareas.IdAsignacion FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdActividadesDocente =  '$IdActividadDoc' AND tblp_tareas.Link IS NOT NULL GROUP BY tblp_tareas.IdAsignacion");
    while ($x = $db->recorrer($sql)) {
      $gcalifialum[] = $x;
    }
    return $gcalifialum;
  }

  # INGRESOS EN TIEMPO REAL
  public function get_ingresosTReal()
  {
    $db = new Conexion();
    $ginrtesosTR = [];
    //$sql = $db->query("SELECT tblh_ingresos.IdIngreso, tblh_ingresos.IdUsua, tblh_ingresos.Pagina, tblh_ingresos.Descripcion, tblh_ingresos.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.Cargo FROM tblh_ingresos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_ingresos.IdUsua ORDER BY tblh_ingresos.FecCap DESC LIMIT 100");
    //while ($x = $db->recorrer($sql)) {
    //  $ginrtesosTR[] = $x;
    //}
    return $ginrtesosTR;
  }

  # INGRESOS EN TIEMPO REAL
  public function get_ingresosTRealId($IdUsua)
  {
    $db = new Conexion();
    $ginrtesosTRi = [];
    //$sql = $db->query("SELECT tblh_ingresos.IdIngreso, tblh_ingresos.IdUsua, tblh_ingresos.Pagina, tblh_ingresos.Descripcion, tblh_ingresos.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_usuario.Cargo FROM tblh_ingresos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_ingresos.IdUsua WHERE tblh_ingresos.IdUsua = '$IdUsua' ORDER BY tblh_ingresos.FecCap DESC LIMIT 100");
    //while ($x = $db->recorrer($sql)) {
    //  $ginrtesosTRi[] = $x;
    //}
    return $ginrtesosTRi;
  }

  # SACAMOS LOS AÑOS
  public function get_anios()
  {
    $db = new Conexion();
    $get_anios = [];
    $sql = $db->query("SELECT * FROM tblh_anio");
    while ($x = $db->recorrer($sql)) {
      $get_anios[] = $x;
    }
    return $get_anios;
  }

  public function get_lstCiclo($Tipo)
  {
    if ($Tipo) {
      $db = new Conexion();
      $get_lstCiclo = [];
      $sql = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Tipo, tblc_ciclo.Anio, tblc_ciclo.Ciclo, tblc_ciclo.Estatus, tblc_ciclo.FInicio, tblc_ciclo.FFinal, tblc_periodo.Periodo FROM tblc_ciclo Left Join tblc_periodo ON tblc_periodo.IdPeriodo = tblc_ciclo.IdPeriodo WHERE tblc_ciclo.Tipo ='$Tipo' ORDER BY tblc_ciclo.FecCap DESC");
      while ($x = $db->recorrer($sql)) {
        $get_lstCiclo[] = $x;
      }
      return $get_lstCiclo;
    }
  }

  public function get_cEscolarLst()
  {
    $db = new Conexion();
    $hoy = date("Y-m-d");
    $inicio = date("Y-m-d", strtotime($hoy . "- 9 month"));
    $final = date("Y-m-d", strtotime($hoy . "+ 8 month"));

    $get_cEscolarLst = [];
    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdEstatus = '8' AND tblc_ciclo.FInicio BETWEEN '$inicio' AND  '$final' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC");
    while ($x = $db->recorrer($sql)) {
      $get_cEscolarLst[] = $x;
    }
    return $get_cEscolarLst;
  }

  public function get_escolar_todos()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.FInicio DESC");
    while ($x = $db->recorrer($sql)) {
      $get_escolar_todos[] = $x;
    }
    return $get_escolar_todos;
  }

  public function get_gGrupoLst()
  {
    $db = new Conexion();
    $get_gGrupoLst = [];
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE ((tblp_grupo.IdEstatus = '8') || (tblp_grupo.IdEstatus = '12'))");
    while ($x = $db->recorrer($sql)) {
      $get_gGrupoLst[] = $x;
    }
    return $get_gGrupoLst;
  }

  public function get_lst_grupoo($IdCiclo)
  {
    $db = new Conexion();
    $sql2 = $db->query("SELECT tblc_ciclo.Tipo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $Tipo = $datos21["Tipo"];

    $tipo_ciclo = substr($Tipo, 0, 1);
    $get_lst_grupoo = [];

    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCicloIni <> '$IdCiclo' AND tblp_grupo.TipoCiclo = '$tipo_ciclo' AND ((tblp_grupo.IdEstatus = '8') || (tblp_grupo.IdEstatus = '12')) ORDER BY tblp_grupo.Grado ASC");
    while ($x = $db->recorrer($sql)) {
      $get_lst_grupoo[] = $x;
    }
    return $get_lst_grupoo;
  }

  public function get_lstCicloGrupo($IdCiclo)
  {
    $db = new Conexion();
    $get_lstCicloGrupo = [];
    $sql = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, tblc_ciclogrupo.Grado, tblc_ciclo.Tipo, tblc_ciclo.Ciclo, tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Nivel, tblp_grupo.Grupo FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo'");
    while ($x = $db->recorrer($sql)) {
      $get_lstCicloGrupo[] = $x;
    }
    return $get_lstCicloGrupo;
  }

  # SACAMOS LOS MESES
  public function get_meses()
  {
    $db = new Conexion();
    $get_meses = [];
    $sql = $db->query("SELECT * FROM tblh_meses");
    while ($x = $db->recorrer($sql)) {
      $get_meses[] = $x;
    }
    return $get_meses;
  }

  public function get_periodo()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_periodo");
    while ($x = $db->recorrer($sql)) {
      $get_periodo[] = $x;
    }
    return $get_periodo;
  }

  public function get_valorTotal($estatus, $IdOferta)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Pagar, tblp_pagos.Recargos, tblp_pagos.IdEstatus FROM tblp_pagos WHERE tblp_pagos.IdEstatus =  '$estatus' AND tblp_pagos.IdOferta =  '$IdOferta' ");
    while ($x = $db->recorrer($sql)) {
      $gTotalEnv[] = $x;
    }
    return $gTotalEnv;
  }

  public function lst_biblioteca_all($IdUsua,$IdAsignacion)
  {
    $db = new Conexion();
    $lst_biblioteca_all = [];
    $sql = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdUsua = '$IdUsua' AND  tblp_biblioteca.IdAsignacion <> '$IdAsignacion' ");
    while ($x = $db->recorrer($sql)) {
      $lst_biblioteca_all[] = $x;
    }
    return $lst_biblioteca_all;
  }

  public function get_recursosId()
  {
    $db = new Conexion();
    $get_recursosId = [];
    $sql = $db->query("SELECT * FROM tblp_temas WHERE tblp_temas.Valor = '1'");
    while ($x = $db->recorrer($sql)) {
      $get_recursosId[] = $x;
    }
    return $get_recursosId;
  }
  #GRUPO ABIERTO
  public function get_grupoAbierto($IdCampus, $IdOferta)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Tipo = 'Abierto' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCampus = '$IdCampus'");
    while ($x = $db->recorrer($sql)) {
      $gGrupoOpen[] = $x;
    }
    return $gGrupoOpen;
  }

  public function get_grupoCerrado($IdOferta)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Tipo = 'Cerrado' AND tblp_grupo.IdOferta = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $gGrupoClose[] = $x;
    }
    return $gGrupoClose;
  }

  public function get_conceptos($IdOferta)
  {
    if ($IdOferta) {
      $db = new Conexion();
      $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdGrado = $datos91["IdGrado"];
      $insertar = $db->query("UPDATE tblc_usuario SET GPago='1' WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdOferta = '$IdOferta'");
      $sql = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.Grado$IdGrado  <> 0");
      while ($x = $db->recorrer($sql)) {
        $gConceptos[] = $x;
      }
      return $gConceptos;
    }
  }

  public function get_conceptosTipo($Grado)
  {
    if ($Grado) {
      $db = new Conexion();

      $sql = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.$Grado  <> 0");
      while ($x = $db->recorrer($sql)) {
        $gConceptos[] = $x;
      }
      return $gConceptos;
    }
  }

  public function get_conceptosPlan($IdGrado, $IdCampus)
  {
    if ($IdGrado) {
      $db = new Conexion();
      $gConceptosP = [];
      $sql = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdGrado = '$IdGrado' AND tblc_conceptosplanes.IdCampus = '$IdCampus' AND ((tblc_conceptosplanes.IdConcepto = 1) || (tblc_conceptosplanes.IdConcepto = 2) || (tblc_conceptosplanes.IdConcepto = 3) || (tblc_conceptosplanes.IdConcepto = 4))");
      while ($x = $db->recorrer($sql)) {
        $gConceptosP[] = $x;
      }
      return $gConceptosP;
    }
  }

  public function get_grupoPend($IdGrado, $IdCampus)
  {
    if (($IdGrado) && ($IdCampus)) {
      $db = new Conexion();

      $sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_educativa.IdGrado
FROM
tblp_grupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE
tblp_grupo.IdCampus =  '$IdCampus' AND
tblp_educativa.IdGrado =  '$IdGrado'
");
      while ($x = $db->recorrer($sql)) {
        $gGrpxP[] = $x;
      }
      return $gGrpxP;
    }
  }

  public function get_ofertaPend($IdGrado, $IdCampus)
  {
    if (($IdGrado) && ($IdCampus)) {
      $db = new Conexion();

      $sql = $db->query("SELECT
tblp_modulo.IdEducativa,
tblp_educativa.Nombre
FROM
tblp_modulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa
WHERE
tblp_modulo.IdCampus =  '$IdCampus' AND
tblp_educativa.IdGrado =  '$IdGrado'
GROUP BY
tblp_modulo.IdEducativa
ORDER BY
tblp_educativa.Nombre ASC
");
      while ($x = $db->recorrer($sql)) {
        $get_ofertaPend[] = $x;
      }
      return $get_ofertaPend;
    }
  }
  public function get_calen($IdGrado, $IdCiclo, $IdPlan)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdGrado = '$IdGrado' AND tblp_calendario.IdCiclo = '$IdCiclo' AND tblp_calendario.IdConceptosPlanes = '$IdPlan'");
    while ($x = $db->recorrer($sql)) {
      $gConcetrosP[] = $x;
    }
    return $gConcetrosP;
  }

  public function get_lstAlumnos($IdOferta, $IdGrupo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Matricula, tblc_usuario.GPago FROM tblc_usuario WHERE tblc_usuario.Estado =  'Activo' AND tblc_usuario.Tipo =  '3' AND tblc_usuario.IdOferta = '$IdOferta' AND tblc_usuario.IdGrupo = '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $gAlumnosGr[] = $x;
    }
    return $gAlumnosGr;
  }

  public function get_lstNvoIngreso()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblp_educativa.Nombre AS NomEducativa FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.Valor =  '1' AND tblc_usuario.Documentos = 'SI'");
    while ($x = $db->recorrer($sql)) {
      $gAlumnosGNv[] = $x;
    }
    return $gAlumnosGNv;
  }

  public function get_conceptosSol($IdOferta)
  {
    if ($IdOferta) {
      $db = new Conexion();
      $sql9 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $rwIdGrado = $datos91["IdGrado"];
      $sql = $db->query("SELECT tblc_conceptos.IdConcepto, tblc_conceptos.NomConcepto, tblc_conceptos.Grado$rwIdGrado FROM tblc_conceptos WHERE tblc_conceptos.Grado$rwIdGrado IS NOT NULL AND tblc_conceptos.Solicitud = '3'");
      while ($x = $db->recorrer($sql)) {
        $gConcpts[] = $x;
      }
      return $gConcpts;
    }
  }



  public function get_temas()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_temas WHERE tblp_temas.Tipo = '1' AND tblp_temas.Valor = '1'");
    while ($x = $db->recorrer($sql)) {
      $gTemas[] = $x;
    }
    return $gTemas;
  }

  // public function get_expAnalitica($IdOferta, $IdEstatus) {
  //   $db = new Conexion();
  //   if($IdEstatus == 1){
  //     $cond = " tblp_pagos.IdEstatus = '1' AND tblp_pagos.Recargos IS NULL ";
  //     $titl = "pagos por realizarse en tiempo";
  //   } elseif ($IdEstatus == 2) {
  //     $cond = " tblp_pagos.IdEstatus = '2'";
  //     $titl = "pagos enviados a Control Escolar";
  //   } elseif ($IdEstatus == 3) {
  //     $cond = " tblp_pagos.IdEstatus = '3'";
  //     $titl = "pagos en proceso de revisión por Control Escolar";
  //   } elseif ($IdEstatus == 4) {
  //     $cond = " tblp_pagos.IdEstatus = '1' AND tblp_pagos.Recargos IS NOT NULL ";
  //     $titl = "pagos con recargos";
  //   }
  //   $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdDescuento, tblp_pagos.Pagar, tblp_pagos.Recargos, tblp_pagos.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_pagos.FecLimPago, tblc_usuario.Foto,tblc_conceptos.NomConcepto FROM tblp_pagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdOferta =  '$IdOferta' AND $cond");
  //   while($x = $db->recorrer($sql)){
  //     $gLista[] = $x;
  //   }
  //   return $gLista;
  // }

  public function get_estatuS()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_estatus WHERE tblc_estatus.Fase1 = '4'");
    while ($x = $db->recorrer($sql)) {
      $gEstatusx[] = $x;
    }
    return $gEstatusx;
  }

  public function get_usuariosT($IdEstatus)
  {
    if ($IdEstatus == 99) {
      $cond = "";
    } else {
      $cond = " WHERE tblc_usuario.IdEstatus = '$IdEstatus' ";
    }
    $db = new Conexion();
    $get_usuariosT = [];
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.FecCap, tblc_usuario.Matricula, tblp_educativa.Nombre AS NomEducativa, tblc_usuario.IdEstatus, tblc_estatus.Estatus FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus $cond ORDER BY tblc_usuario.Tipo ASC, tblc_usuario.APaterno ASC, tblc_usuario.Nombre ASC");
    while ($x = $db->recorrer($sql)) {
      $get_usuariosT[] = $x;
    }
    return $get_usuariosT;
  }

  public function get_lstBiblioteca($IdTema)
  {
    $db = new Conexion();
    $gTemasLst = [];
    $sql = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdTema = '$IdTema'");
    while ($x = $db->recorrer($sql)) {
      $gTemasLst[] = $x;
    }
    return $gTemasLst;
  }

  public function get_lstCkrRg($IdUsua, $IdAsignacion, $IdModulo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModulo = '$IdModulo' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
      $gTsdt[] = $x;
    }
    return $gTsdt;
  }

  public function get_mesesLst($anio, $mes, $IdBanco)
  {
    $db = new Conexion();
    $aniooo = $_POST["Anio"];
    $_SESSION["AnioGra"] = $aniooo;
    $sql = $db->query("SELECT
Sum(tblp_pagos.TotalPagado) AS Ingreso,
tblp_pagos.IdFormaPago,
tblp_pagos.Anio,
tblp_pagos.IdBanco,
tblp_pagos.Mes
FROM
tblp_pagos
WHERE
tblp_pagos.IdEstatus =  '4' AND
tblp_pagos.Anio =  '$aniooo' AND
tblp_pagos.Mes =  '$mes' AND
tblp_pagos.IdBanco =  '$IdBanco'
GROUP BY
tblp_pagos.IdBanco
ORDER BY
tblp_pagos.TotalPagado DESC
");

    while ($x = $db->recorrer($sql)) {
      $gMesesLts[] = $x;
    }
    return $gMesesLts;
  }

  public function get_mesLst($anio, $mes, $IdBanco)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
Sum(tblp_pagos.TotalPagado) AS Ingreso,
tblp_pagos.IdFormaPago,
tblp_pagos.Anio,
tblp_pagos.IdBanco,
tblp_pagos.Mes
FROM
tblp_pagos
WHERE
tblp_pagos.IdEstatus =  '4' AND
tblp_pagos.Anio =  '$anio' AND
tblp_pagos.Mes =  '$mes' AND
tblp_pagos.IdBanco =  '$IdBanco'
GROUP BY
tblp_pagos.IdBanco
ORDER BY
tblp_pagos.TotalPagado DESC
");

    while ($x = $db->recorrer($sql)) {
      $gMesesLts[] = $x;
    }
    return $gMesesLts;
  }

  public function get_lstAsigados($IdGrupo)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT
    tblp_moduloalumno.IdModuloAlumno,
    tblp_moduloalumno.IdEducativa,
    tblp_moduloalumno.IdModulo,
    tblp_moduloalumno.IdAsignacion,
    tblp_moduloalumno.CalExtra1,
    tblp_moduloalumno.CalExtra2,
    tblp_moduloalumno.Recursar,
    tblp_moduloalumno.Activo,
    tblp_asignacion.FecIni,
    tblp_asignacion.Estatus,
    tblp_asignacion.IdCampus,
    tblp_asignacion.FecFin,
    tblp_asignacion.Id,
    tblp_asignacion.IdEstatus,
    tblp_grupo.CveGrupo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_educativa.IdGrado,
    tblp_educativa.Nombre AS NomEducativa,
    tblc_ciclo.Ciclo
    FROM
    tblp_moduloalumno
    Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_moduloalumno.IdEducativa
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    WHERE
    tblp_moduloalumno.IdGrupo =  '$IdGrupo' AND
    tblp_asignacion.Tipo =  '2' AND
    tblp_asignacion.Curso =  '0' GROUP BY tblp_moduloalumno.IdModulo");
    // $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.Grupo, tblp_asignacion.FecIni, tblp_asignacion.FecFin, tblp_asignacion.Estatus, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo, tblp_educativa.Nombre AS NomEducativa, tblp_modulo.CodeModulo, tblp_modulo.NombreMod AS NomModulo, tblc_ciclo.Ciclo, tblp_asignacion.Id FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2'");
    while ($x = $db->recorrer($sql)) {
      $gGrpuLst[] = $x;
    }
    return $gGrpuLst;
  }

  public function get_datAlumno($IdUsua)
  {
    $db = new Conexion();

    $hoy = date("Y-m-d");
    $sqlx = $db->query("SELECT * FROM tblp_prorroga WHERE tblp_prorroga.IdUsua = '$IdUsua' AND tblp_prorroga.IdEstatus = '8' AND tblp_prorroga.Fecha < '$hoy'");
    while($u = $db->recorrer($sqlx)){
      $sql = $db->query("UPDATE tblc_usuario SET tblc_usuario.Folio = NULL WHERE tblc_usuario.IdUsua = '".$u['IdUsua']."' ");
      $sql = $db->query("UPDATE tblp_prorroga SET tblp_prorroga.IdEstatus = '22' WHERE tblp_prorroga.IdProrroga = '".$u['IdProrroga']."' ");
      
    }
    
    $get_datAlumno = [];

    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Foto,
tblc_usuario.IdCampus,
tblc_usuario.Usuario,
tblc_usuario.Matricula,
tblc_usuario.Code,
tblc_usuario.IdEstatus,
tblc_usuario.Celular,
tblc_usuario._alfanumerica,
tblc_usuario._numerica,
tblc_estatus.Estatus,
tblp_educativa.Nombre AS NomEducativa,
tblc_usuario.SemCua,
tblp_educativa.IdEducativa,
tblc_abreviatura.Abreviatura,
tblp_educativa.Clave,
tblp_educativa.Publicidad,
tblp_educativa.Color,
tblp_grupo.CveGrupo,
tblp_grupo.Tipo,
tblp_grupo.Turno,
tblp_grupo.TipoCiclo,
tblp_grupo.Dia,
tblc_campus.Campus,
tblc_dias_clases._Dias,
tblc_modalidad._Modalidad
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblc_usuario.SemCua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_datAlumno[] = $x;
    }
    return $get_datAlumno;
  }

  public function get_alumnId($IdUsua)
  {
    $db = new Conexion();
    $get_alumnId = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Foto,
tblc_usuario.Usuario,
tblc_usuario.Code,
tblc_usuario.id_usua,
tblc_estatus.Estatus,
tblp_educativa.Nombre AS NomEducativa,
tblp_educativa.IdEducativa,
tblp_grupo.CveGrupo,
tblc_campus.Campus,
tblc_usuario.IdEstatus
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_alumnId[] = $x;
    }
    return $get_alumnId;
  }

  public function get_docentId($IdUsua)
  {
    $db = new Conexion();
    $get_docentId = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_docentId[] = $x;
    }
    return $get_docentId;
  }


  public function get_datBeca($IdUsua)
  {
    $db = new Conexion();
    $get_datBeca = [];


    $sql = $db->query("SELECT
    tblp_beca.IdBeca,
    tblp_beca.Porcentaje,
    tblp_beca.FecCap,
    tblp_beca.IdCiclo,
    tblc_conceptos.NomConcepto,
    tblp_beca.Crm,
    tblp_beca.Nota,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_estatus.Estatus,
    tblc_ciclo.Ciclo
    FROM
    tblp_beca
    Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_beca.IdConcepto
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_beca.IdUsuaCap
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_beca.IdEstatus
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_beca.IdCiclo
    WHERE tblp_beca.IdUsua = '$IdUsua'
    ORDER BY
    tblc_ciclo.FInicio ASC
     ");
    while ($x = $db->recorrer($sql)) {
      $get_datBeca[] = $x;
    }
    return $get_datBeca;
  }

  public function get_configurar_beca($IdUsua)
  {
    // $db = new Conexion();
    
    // $sql = $db->query("SELECT tblp_pagos.IdPago, tblc_conceptos.NomConcepto, tblp_pagos.Monto, tblp_pagos.IdConcepto, tblp_pagos.IdCiclo FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdUsua =  '$IdUsua' AND  tblp_pagos.IdConcepto < 4 GROUP BY tblp_pagos.IdConcepto ");
    // while ($x = $db->recorrer($sql)) {
    //   $sql9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua =  '$IdUsua' AND tblp_beca.IdCiclo =  '".$x['IdCiclo']."' AND tblp_beca.IdConcepto =  '".$x['IdConcepto']."' ");
    //   $db->rows($sql9);
    //   $datos91 = $db->recorrer($sql9);
    //   $IdBeca = $datos91["IdBeca"];
    //   if($IdBeca){
    //     $insertar1 = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '".$x['Monto']."' WHERE tblp_beca.IdBeca = '$IdBeca'");
    //   } else {
    //     $insertar2 = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Importe) VALUES('$IdUsua','".$x['IdConcepto']."','0',NOW(),'1','8','1000','".$x['IdCiclo']."','".$x['Monto']."')");
    //   }
    // }
  }

  public function get_pagPendientes($IdUsua)
  {
    $db = new Conexion();
    $get_pagPendientes = [];

    $sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.Fecha,
tblp_pagos.IdBeca,
tblp_pagos.TotalPagado,
tblp_pagos.Descuento,
tblp_pagos.Descuento2,
tblp_pagos.Referencia,
tblp_pagos.IdEstatus,
tblp_pagos._img,
tblp_pagos.IdModulo,
tblc_estatus.Estatus,
tblc_conceptosplanes.NomPlan
FROM
tblp_pagos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE
tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus = '1' ORDER BY tblp_pagos.Fecha ASC");
    while ($x = $db->recorrer($sql)) {
      $get_pagPendientes[] = $x;
    }
    return $get_pagPendientes;
  }

  public function get_factura_id($uuid) {
    $db = new Conexion();

    $sql = $db->query("SELECT
    tblg_factura.IdFactura,
    tblg_factura.Fecha,
    tblg_datos_factura.R_Rfc,
    tblg_datos_factura.R_Nombre,
    tblg_datos_factura.R_RegimenFiscalReceptor,
    tblg_datos_factura.R_UsoCFDI,
    tblg_datos_factura.SubTotal,
    tblg_datos_factura.Descuento,
    tblg_datos_factura.Total,
    tblg_folio.Folio,
    tblg_folio.Serie,
    tblg_folio.IdEstatus,
    tblc_estatus.Estatus,
    tblg_conceptos_factura.Descripcion,
    tblc_regimen_fiscal.Descripcion AS Regimen,
    tblc_usocfdi.Descripcion AS Uso
    FROM
    tblg_factura
    Left Join tblg_datos_factura ON tblg_datos_factura._codigoFactura = tblg_factura._codigoFactura
    Left Join tblg_folio ON tblg_folio._codeFactura = tblg_factura._codigoFactura
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblg_folio.IdEstatus
    Left Join tblg_conceptos_factura ON tblg_conceptos_factura._codigoFactura = tblg_factura._codigoFactura
    Left Join tblc_regimen_fiscal ON tblc_regimen_fiscal.Clave = tblg_datos_factura.R_RegimenFiscalReceptor
    Left Join tblc_usocfdi ON tblc_usocfdi.Clave = tblg_datos_factura.R_UsoCFDI
     WHERE tblg_factura.uuid = '$uuid'");
    while($x = $db->recorrer($sql)){
      $get_factura_id[] = $x;
    }
    return $get_factura_id;
  }

  public function get_pagAprobados($IdUsua)
  {
    $db = new Conexion();

    $get_pagAprobados = [];
    $sql = $db->query("SELECT
tblp_foliospago.NoFolio,
tblp_foliospago.FecCap,
tblp_foliospago.FecPago,
tblp_foliospago.IdPago,
tblp_foliospago.IdEstatus,
tblp_foliospago.Factura,
tblp_foliospago._facturado,
tblp_foliospago._codigoFactura,
Sum(tblp_foliospago.Monto) AS Monto,
tblp_foliospago.IdForma,
tblc_formapago.Descripcion,
tblc_estatus.Estatus,
tblp_pagos.DocFactura,
tblg_factura._folio,
tblg_factura._tipo,
tblg_factura.IdUsua,
tblg_factura.Fecha,
tblg_factura.uuid
FROM
tblp_foliospago
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_foliospago.IdEstatus
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblg_factura ON tblg_factura._codigoFactura = tblp_foliospago._codigoFactura
WHERE
tblp_foliospago.IdUsua =  '$IdUsua'
GROUP BY
tblp_foliospago.NoFolio
ORDER BY tblp_foliospago.FecCap DESC
 ");
    while ($x = $db->recorrer($sql)) {
      $get_pagAprobados[] = $x;
    }
    return $get_pagAprobados;
  }

  public function get_factura_pend_id($IdUsua)
  {
    $anio = date("Y-m");
    $db = new Conexion();

    $sql9 = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdEstatus = '8' AND tblc_datosfactura.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $get_factura_pend_id = [];

    if(isset($datos91["IdDatosFacturacion"])){
    $sql = $db->query("SELECT
      tblp_foliospago.NoFolio,
      tblp_foliospago.FecCap,
      tblp_foliospago.FecPago,
      tblp_foliospago.IdPago,
      tblp_foliospago.IdEstatus,
      tblp_foliospago.Factura,
      tblp_foliospago.IdUsua,
      Sum(tblp_foliospago.Monto) AS Monto,
      tblp_foliospago.IdForma,
      tblc_formapago.Descripcion,
      tblc_formapago.c_FormaPago,
      tblp_pagos.DocFactura
      FROM
      tblp_foliospago
      Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
      Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
      WHERE
      tblp_foliospago.IdUsua =  '$IdUsua' AND tblp_foliospago.Factura = '1' AND tblp_foliospago.AnioMes = '$anio'
      GROUP BY
      tblp_foliospago.NoFolio
      ");
    while ($x = $db->recorrer($sql)) {
      $get_factura_pend_id[] = $x;
    }
    
  } 
  return $get_factura_pend_id;

  }

  public function get_genPag($IdUsua, $IdGrupo)
  {
    $db = new Conexion();

    $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo =  '$IdGrupo' ORDER BY tblc_usuario.IdUsua ASC");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $rwIdUsua = $datos91["IdUsua"];
    $rwIdCamp = $datos91["IdCampus"];

    $sql8 = $db->query("SELECT Count(tblp_pagos.IdPago) AS Total FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $rwTotal = $datos81["Total"];

    if ($rwTotal == 0) {
      $sql = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$rwIdUsua'");
      while ($x = $db->recorrer($sql)) {
        $IdCal = $x["IdCalendario"];
        $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus)VALUES('" . $x["IdCalendario"] . "','$IdUsua','" . $x["IdConceptoPlan"] . "','" . $x["Monto"] . "','32',NOW(),'" . $x["FecDesc"] . "','" . $x["FecBase"] . "','" . $x["FecLim"] . "','" . $x["FecLimPago"] . "','NO-F33','1','" . $x["Anio"] . "','" . $x["IdOferta"] . "','0','1','" . $x["IdCiclo"] . "','$rwIdCamp')");
      }
    }
  }



  public function get_genPagBecXX($IdUsua, $IdOferta, $IdCampus)
  {
    $db = new Conexion();
    $sql8 = $db->query("SELECT Count(tblp_pagos.IdPago) AS Total FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $rwTotal = $datos81["Total"];

    if ($rwTotal == 0) {
      $sql7 = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql7);
      $datos71 = $db->recorrer($sql7);
      $rwIdGrado = $datos71["IdGrado"];

      $sql9 = $db->query("SELECT tblp_beca.IdConceptoPlan FROM tblp_beca WHERE tblp_beca.IdUsua =  '$IdUsua'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $rwIdConP = $datos91["IdConceptoPlan"];

      $anio = date("Y");

      $sql = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdGrado = '$rwIdGrado' AND tblp_calendario.IdConceptosPlanes = '$rwIdConP'");
      while ($x = $db->recorrer($sql)) {
        $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus) VALUES('" . $x["IdCalendario"] . "','$IdUsua','$rwIdConP','" . $x["Monto"] . "','32',NOW(),'" . $x["FecDescuento"] . "','" . $x["FecBase"] . "','" . $x["FecLimite"] . "','" . $x["FecLimite"] . "','NO-F34','1','$anio','$IdOferta','0','1','" . $x["IdCiclo"] . "','$IdCampus')");
      }
    }
  }


  public function get_genPagBecXX2($IdUsua, $IdOferta, $IdCampus)
  {
    $db = new Conexion();

    $sql7 = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $rwIdGrado = $datos71["IdGrado"];
    $anio = date("Y");

    $sql2 = $db->query("SELECT tblp_beca.IdConceptoPlan FROM tblp_beca WHERE tblp_beca.IdUsua =  '$IdUsua'");
    while ($y = $db->recorrer($sql2)) {
      $rwIdConP = $y["IdConceptoPlan"];


      $sql = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdGrado = '$rwIdGrado' AND tblp_calendario.IdConceptosPlanes = '$rwIdConP'");
      while ($x = $db->recorrer($sql)) {
        $IdCal = $x["IdCalendario"];

        $sql8 = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdOferta = '$IdOferta' AND tblp_pagos.IdConceptoPlan = '$rwIdConP' AND tblp_pagos.IdCalendario = '$IdCal'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $rwIdPag = $datos81["IdPago"];
        if (!$rwIdPag) {


          $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus) VALUES('$IdCal','$IdUsua','$rwIdConP','" . $x["Monto"] . "','32',NOW(),'" . $x["FecDescuento"] . "','" . $x["FecBase"] . "','" . $x["FecLimite"] . "','" . $x["FecLimite"] . "','NO-F35','1','$anio','$IdOferta','0','1','" . $x["IdCiclo"] . "','$IdCampus')");
        }
      }
    }
    // header("Location:perfil.php?token=1592417487$IdUsua");
  }

  public function load_padosPen($IdUsuaX)
  {
    $db = new Conexion();
    $IdUsua = substr($IdUsuaX, 10, 10);

    $sql9 = $db->query("SELECT tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdOferta = $datos91["IdOferta"];
    $IdCampus = $datos91["IdCampus"];

    $sql7 = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $rwIdGrado = $datos71["IdGrado"];
    $anio = date("Y");

    $sql2 = $db->query("SELECT tblp_beca.IdConceptoPlan FROM tblp_beca WHERE tblp_beca.IdUsua =  '$IdUsua'");
    while ($y = $db->recorrer($sql2)) {
      $rwIdConP = $y["IdConceptoPlan"];


      $sql = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdGrado = '$rwIdGrado' AND tblp_calendario.IdConceptosPlanes = '$rwIdConP'");
      while ($x = $db->recorrer($sql)) {
        $IdCal = $x["IdCalendario"];

        $sql8 = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdOferta = '$IdOferta' AND tblp_pagos.IdConceptoPlan = '$rwIdConP' AND tblp_pagos.IdCalendario = '$IdCal'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $rwIdPag = $datos81["IdPago"];
        if (!$rwIdPag) {
          $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus) VALUES('$IdCal','$IdUsua','$rwIdConP','" . $x["Monto"] . "','32',NOW(),'" . $x["FecDescuento"] . "','" . $x["FecBase"] . "','" . $x["FecLimite"] . "','" . $x["FecLimite"] . "','NO-F36','1','$anio','$IdOferta','0','1','" . $x["IdCiclo"] . "','$IdCampus')");
        }
      }
    }

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }


  public function get_genPagBec($IdUsua, $IdOferta, $IdCampus)
  {
    $db = new Conexion();

    $sql8 = $db->query("SELECT Count(tblp_pagos.IdPago) AS Total FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $rwTotal = $datos81["Total"];

    if ($rwTotal == 0) {
      $sql9 = $db->query("SELECT tblp_beca.IdConceptoPlan FROM tblp_beca WHERE tblp_beca.IdUsua =  '$IdUsua'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $rwIdConP = $datos91["IdConceptoPlan"];

      $sql9 = $db->query("SELECT tblp_pagos.IdUsua FROM tblp_pagos WHERE tblp_pagos.IdCampus = '$IdCampus' AND tblp_pagos.IdOferta = '$IdOferta' AND tblp_pagos.IdConceptoPlan = '$rwIdConP' LIMIT 1");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $rwIdUsua = $datos91["IdUsua"];


      $sql = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$rwIdUsua'");
      while ($x = $db->recorrer($sql)) {
        $IdCal = $x["IdCalendario"];
        $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus)VALUES('" . $x["IdCalendario"] . "','$IdUsua','$rwIdConP','" . $x["Monto"] . "','32',NOW(),'" . $x["FecDesc"] . "','" . $x["FecBase"] . "','" . $x["FecLim"] . "','" . $x["FecLim"] . "','NO-F37','1','" . $x["Anio"] . "','$IdOferta','0','1','" . $x["IdCiclo"] . "','$IdCampus')");
      }
    }
  }

  public function get_recargo($IdUsua, $IdPago)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT Sum(tblp_recargos.Monto) AS Recargo FROM tblp_recargos WHERE tblp_recargos.IdUsua = '$IdUsua' AND tblp_recargos.IdPago = '$IdPago' AND tblp_recargos.IdEstatus = '8'");
    while ($x = $db->recorrer($sql)) {
      $gRecarId[] = $x;
    }
    return $gRecarId;
  }

  public function get_abonos($IdUsua, $IdPago)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT Sum(tblp_foliospago.Monto) AS Abono FROM tblp_foliospago WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.IdPago = '$IdPago' AND tblp_foliospago.Tipo = 'P'");
    while ($x = $db->recorrer($sql)) {
      $gAbondId[] = $x;
    }
    return $gAbondId;
  }

  public function get_datAsesor($IdUsua)
  {
    $db = new Conexion();
    $gUserXId = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Code,
tblc_usuario.Foto,
tblc_usuario.Usuario,
tblc_usuario.IdCampus,
tblc_estatus.Estatus,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
 WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $gUserXId[] = $x;
    }
    return $gUserXId;
  }

  public function get_datAsignaturas($IdUsua)
  {
    $db = new Conexion();
    $gUserXIdAs = [];

    $sql = $db->query("SELECT
      tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.Fec_emi_bim1,
tblp_asignacion.Fecha_impresion,
tblp_educativa.Nombre,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Oferta,
tblp_grupo.CveGrupo,
tblc_estatus.Estatus,
tblp_asignacion.IdEstatus,
tblp_asignacion.pro_alum,
tblp_asignacion.pro_coo,
tblp_asignacion._alum,
tblp_asignacion._promedio,
tblc_ciclo.Ciclo
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo

  WHERE
  tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdUsua = '$IdUsua' ORDER BY tblp_modulo.CodeModulo ");
    while ($x = $db->recorrer($sql)) {
      $gUserXIdAs[] = $x;
    }
    return $gUserXIdAs;
  }

  public function get_materias_finalizas_eva($IdUsua)
  {
    $db = new Conexion();
    $get_materias_finalizas_eva = [];


    $sql = $db->query("SELECT
      tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.Fec_emi_bim1,
tblp_asignacion.Fecha_impresion,
tblp_educativa.Nombre,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Oferta,
tblp_grupo.CveGrupo,
tblc_estatus.Estatus,
tblp_asignacion.IdEstatus,
tblp_asignacion.pro_alum,
tblp_asignacion.pro_coo,
tblp_asignacion._alum,
tblp_asignacion._promedio,
tblc_ciclo.Ciclo
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
  WHERE
  tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdUsua = '$IdUsua' AND tblp_asignacion.pro_alum IS NOT NULL AND tblp_asignacion.pro_alum IS NOT NULL  ORDER BY tblp_modulo.CodeModulo ");
    while ($x = $db->recorrer($sql)) {
      $get_materias_finalizas_eva[] = $x;
    }
    return $get_materias_finalizas_eva;
  }

  public function get_datPlaneacion($IdPlaneacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_planeacion WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");
    while ($x = $db->recorrer($sql)) {
      $gUserXPlan[] = $x;
    }
    return $gUserXPlan;
  }

  public function get_infoPlan($IdAsignacion)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_educativa.Clave,
tblp_educativa.Nombre,
tblp_educativa.Publicidad,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_grupo.CveGrupo,
tblc_ciclo.Ciclo,
tblc_campus.Campus,
tblp_grupo.Turno,
tblp_grupo.Modalidad,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdUsua
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
WHERE
tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdAsignacion = '$IdAsignacion'
");
    while ($x = $db->recorrer($sql)) {
      $gUserXPlanAsi[] = $x;
    }
    return $gUserXPlanAsi;
  }

  public function get_datFinanciero($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Pagar,
tblp_pagos.FecLimPago,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblp_pagos.Facturar,
tblp_pagos.Referencia,
tblp_pagos.FecPago,
tblp_pagos.IdBanco,
tblc_conceptos.NomConcepto,
tblc_estatus.Estatus AS estatusPago,
tabDescuento.Estatus AS estatusDescuento,
tblc_bancos.Banco,
tblc_ciclo.Ciclo
FROM
tblp_pagos
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Left Join tblc_estatus AS tabDescuento ON tabDescuento.IdEstatus = tblp_pagos.EstatusDescuento
Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_pagos.IdBanco
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
WHERE tblp_pagos.IdUsua = '$IdUsua' ORDER BY
tblp_pagos.FecLimPago ASC");
    while ($x = $db->recorrer($sql)) {
      $gUserIdFinan[] = $x;
    }
    return $gUserIdFinan;
  }

  public function get_bancos()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_bancos ORDER BY tblc_bancos.IdEstatus DESC");
    while ($x = $db->recorrer($sql)) {
      $gBancosLst[] = $x;
    }
    return $gBancosLst;
  }

  public function get_bancos_campus($IdCampus)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_bancos WHERE tblc_bancos.IdCampus = '$IdCampus' ORDER BY tblc_bancos.IdEstatus DESC");
    while ($x = $db->recorrer($sql)) {
      $gBancosLst[] = $x;
    }
    return $gBancosLst;
  }



  public function get_ofertasxCampus($IdCampus)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT
tblp_modulo.IdEducativa,
tblp_educativa.Clave,
tblp_educativa.Nombre
FROM
tblp_modulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa
WHERE
tblp_modulo.IdCampus =  '$IdCampus'
GROUP BY
tblp_modulo.IdEducativa
");
    while ($x = $db->recorrer($sql)) {
      $gOrtsLst[] = $x;
    }
    return $gOrtsLst;
  }


  public function get_beca($IdUsua, $IdPago)
  {
    $db = new Conexion();

    
  }

  public function get_pagosPend($IdCampus, $IdCiclo, $IdPlan, $IdCal)
  {
    if ($IdCampus && $IdCiclo && $IdPlan) {
      $db = new Conexion();

      if ($IdCal) {
        $cond = " tblp_pagos.IdCalendario = '$IdCal' AND ";
      } else {
        $cond = " ";
      }
      $sql = $db->query("SELECT
      tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.FecCap,
tblp_pagos.FecDesc,
tblp_pagos.Descuento,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblc_estatus.Estatus,
tblc_conceptosplanes.NomPlan,
tblp_educativa.Nombre AS Educativa,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_pagos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
WHERE tblc_usuario.IdEstatus = '8' AND tblp_pagos.IdCampus = '$IdCampus' AND tblp_pagos.IdCiclo = '$IdCiclo' AND tblp_pagos.IdConceptoPlan = '$IdPlan' AND $cond
tblp_pagos.IdEstatus <>  '4'
ORDER BY
tblp_pagos.EstatusDescuento ASC


");
      while ($x = $db->recorrer($sql)) {
        $gPagosPend[] = $x;
      }
      return $gPagosPend;
    }
  }


  public function get_pagosPaTodos($IdGrado, $IdCampus, $IdPlan)
  {
    if ($IdGrado && $IdCampus) {
      $db = new Conexion();
      $hoy = date("Y-m-d");

      $sql = $db->query("SELECT
      tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.FecCap,
tblp_pagos.FecDesc,
tblp_pagos.Descuento,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblc_estatus.Estatus,
tblc_conceptosplanes.NomPlan,
tblp_educativa.Nombre AS Educativa,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_pagos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
WHERE tblc_usuario.IdEstatus = '8' AND tblp_pagos.IdCampus = '$IdCampus' AND tblp_pagos.IdEstatus <>  '4' AND tblp_pagos.FecDesc < '$hoy' AND tblp_pagos.IdConceptoPlan = '$IdPlan'
ORDER BY
tblp_pagos.EstatusDescuento ASC");
      while ($x = $db->recorrer($sql)) {
        $gPagosPend[] = $x;
      }
      return $gPagosPend;
    }
  }

  public function get_calPlata($IdModAlum, $Cal)
  {
    $db = new Conexion();

    // $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.CalFinal = '$Cal' WHERE tblp_moduloalumno.IdModAlumno = '$IdModAlum'");
    $db->close();
  }

  public function get_ingresoMes($Mes, $Anio)
  {
    if ($Mes < 10) {
      $mess = "0" . $Mes;
    } else {
      $mess = $Mes;
    }
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblp_pagos.TotalPagado) AS sumIngreso, tblp_pagos.IdBanco, tblc_bancos.Banco FROM tblp_pagos Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_pagos.IdBanco WHERE tblp_pagos.IdEstatus =  '4' AND tblp_pagos.Anio =  '$Anio' AND tblp_pagos.Mes =  '$mess' GROUP BY tblp_pagos.IdBanco");
    while ($x = $db->recorrer($sql)) {
      $gIngresMes[] = $x;
    }
    return $gIngresMes;
  }

  public function get_tareasCalendar($IdAsignacion)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' ORDER BY tblp_actividadesdocente.FecIni ASC ");
    while ($x = $db->recorrer($sql)) {
      $gTareasCal[] = $x;
    }
    return $gTareasCal;
  }
  public function get_tareasCalendarS($IdAsignacion)
  {
    $db = new Conexion();
    $get_tareasCalendarS = [];
    $sql = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdTipoActividad <> 2 AND tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' ORDER BY tblp_actividadesdocente.FecIni ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_tareasCalendarS[] = $x;
    }
    return $get_tareasCalendarS;
  }

  public function get_reciente($IdAsignacion)
  {
    $db = new Conexion();
    $get_reciente = [];
    $sql = $db->query("SELECT
tblp_foro.IdForo,
tblp_foro.IdActividad,
tblp_foro.Mensaje,
tblp_foro.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblc_usuario.Foto,
tblp_actividad.TituloActividad
FROM
tblp_foro
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua
Left Join tblp_actividad ON tblp_actividad.IdActividad = tblp_foro.IdActividad WHERE tblp_foro.IdAsignacion = '$IdAsignacion'
 ORDER BY tblp_foro.FecCap DESC Limit 5 ");
    while ($x = $db->recorrer($sql)) {
      $get_reciente[] = $x;
    }
    return $get_reciente;
  }

  public function get_historialDoc($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT
  tblp_asignacion.IdAsignacion,
  tblp_asignacion.IdUsua,
  tblp_asignacion.FecIni,
  tblp_asignacion.FecFin,
  tblp_asignacion.Estatus,
  tblp_asignacion.FecCap,
  tblp_educativa.IdEducativa,
  tblp_educativa.Nombre AS NomEducativa,
  tblp_modulo.NombreMod,
  tblp_modulo.NoModulo,
  tblp_grupo.CveGrupo,
  tblp_grupo.Grupo,
  tblc_ciclo.Ciclo
  FROM
  tblp_asignacion
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo AND tblp_modulo.IdEducativa = tblp_asignacion.IdEducativa
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
  Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
  WHERE
  tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gHisotrlc[] = $x;
    }
    return $gHisotrlc;
  }


  public function add_excelGrupo()
  {
    $carpeta = "assets/docs/Excel/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='addCrearGrupo.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();
    // $sql9 = $db->query("SELECT * FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago = '$Id'");
    // $db->rows($sql9);
    // $datos91 = $db->recorrer($sql9);
    // $IdDetallePag = $datos91["IdDetallePagos"];

    $insertar = $db->query("INSERT INTO tblh_excel (Link, FecCap, IdUsua, IdEstatus)VALUES('$archivo',NOW(),'" . $_POST["IdUsua"] . "','8')");
    $IdExcel = $db->insert_id;
    $IdOferta = $_POST['txtOferta'];
    // $IdCampus = $_POST['txtCampus'];

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';


    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 2; $row <= $highestRow; $row++) {
      $usuario = $sheet->getCell("A" . $row)->getValue();
      $nombre = $sheet->getCell("B" . $row)->getValue();
      $paterno = $sheet->getCell("C" . $row)->getValue();
      $materno = $sheet->getCell("D" . $row)->getValue();
      $sexo = $sheet->getCell("E" . $row)->getValue();
      $correo = $sheet->getCell("F" . $row)->getValue();
      $correo_ins = $sheet->getCell("G" . $row)->getValue();
      $cel = $sheet->getCell("H" . $row)->getValue();
      $nac = $sheet->getCell("I" . $row)->getValue();
      $IdCampus = $sheet->getCell("J" . $row)->getValue();
      $Folio = $sheet->getCell("K" . $row)->getValue();
      $Curp = $sheet->getCell("L" . $row)->getValue();
      if ($usuario) {
        //if($nac){ echo $nac; die();
        //  $anio = substr($nac, 6, 4);
        //  $mes = substr($nac, 3, 2);
        //  $dia = substr($nac, 0, 2);
        //  $nac = $anio.'-'.$mes.'-'.$dia;
        //  $cox1 = ", Nac"; $cox2 = ", '$nac'"; } else { $cox1 = ""; $cox2 = ""; }
        //  echo "INSERT INTO tblh_temporal (Nombre, APaterno, AMaterno, IdExcel, Usuario, IdUsua, FecCap, IdEstatus, Oferta, Campus, Sexo, Correo, Cel, Correo_ins, $cox1) VALUES ('$nombre','$paterno','$materno','$IdExcel','$usuario','".$_POST["IdUsua"]."',NOW(),'8','$IdOferta','$IdCampus','$sexo', '$correo','$cel', '$correo_ins', $cox2)"; die();
        $insertar = $db->query("INSERT INTO tblh_temporal (Nombre, APaterno, AMaterno, IdExcel, Usuario, IdUsua, FecCap, IdEstatus, Oferta, Campus, Sexo, Correo, Cel, Correo_ins, Folio, Curp) VALUES ('$nombre','$paterno','$materno','$IdExcel','$usuario','" . $_POST["IdUsua"] . "',NOW(),'8','$IdOferta','$IdCampus','$sexo', '$correo','$cel', '$correo_ins', '$Folio','$Curp')");
      }
      $usuario = "";
    }


    if ($insertar) {
      $_SESSION['Alerta'] = "5";
      echo "<script type='text/javascript'>window.location='addCrearGrupo.php';</script>";
    } else {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='addCrearGrupo.php';</script>";
    }
  }


  public function add_excel_conciliar_banco()
  {
    $carpeta = "assets/docs/Excel/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='finanzas_conciliar_pagos.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';
    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    for ($row = 2; $row <= $highestRow; $row++) {
      $fecha = $sheet->getCell("A" . $row)->getValue();
      $desc = $sheet->getCell("B" . $row)->getValue();
      $importe = $sheet->getCell("C" . $row)->getValue();
      if (is_numeric($importe)) {
        $tac = ($fecha - 25568) * 86400;
        $_fecha = date("Y-m-d", $tac);

        $pieces = explode(": ", $desc);
        $suc = $pieces[0];
        $ref = $pieces[1];
        $alfa = $pieces[2];
        $auto = $pieces[3];
        $orde = $pieces[4];
        $orde1 = $pieces[5];
        $banco = $pieces[6];

        $suc = intval(preg_replace('/[^0-9]+/', '', $ref), 10);
        $ref = intval(preg_replace('/[^0-9]+/', '', $alfa), 10);
        $piecesx = explode(" Autorización", $auto);
        $alfa = $piecesx[0];

        $piecesy = explode(" Ordenante", $orde);
        $auto = $piecesy[0];

        $piecesz = explode(" Banco Emisor", $orde1);
        $orde1 = $piecesz[0];

      //if($fecha){
      
        if ($importe > 0) {

          $insertar = $db->query("INSERT INTO tblh_temporal_conciliar (Fecha, Descripcion, Importe, IdUsua, sucursal, referencia, alfanumerica, autorizacion, ordenante, banco, idestatus, _idestatus, idbanco, _IdUsua) VALUES ('$_fecha','$desc','$importe','" . $_POST['IdUsua'] . "','$suc','$ref','$alfa','$auto','$orde1','$banco',1, 1, 3, 0)");
        }
      }
      //}
    }


    $sql_ba = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdUsua = '" . $_POST['IdUsua'] . "'");
    while ($ban = $db->recorrer($sql_ba)) {
      $sqlx9 = $db->query("SELECT tblc_banco_procedencia.IdProcedencia FROM tblc_banco_procedencia WHERE tblc_banco_procedencia.Banco = '" . $ban['banco'] . "' ");
      $db->rows($sqlx9);
      $datosx91 = $db->recorrer($sqlx9);
      $IdProcedencia = $datosx91['IdProcedencia'];
      if ($IdProcedencia) {
        $IdProcedencia = $datosx91['IdProcedencia'];
      } else {
        $IdProcedencia = 25;
      }
      $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar.idprocedencia = '$IdProcedencia' WHERE tblh_temporal_conciliar.IdTemporal = '" . $ban['IdTemporal'] . "' ");
    }


    if ($insertar) {
      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='finanzas_conciliar_pagos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "8";
      echo "<script type='text/javascript'>window.location='finanzas_conciliar_pagos.php';</script>";
    }
  }

  public function add_excel_conciliar_pagx()
  {
    $carpeta = "assets/docs/Excel/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='finanzas_conciliar_pagos.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';
    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    for ($row = 2; $row <= $highestRow; $row++) {
      $mat = $sheet->getCell("A" . $row)->getValue();
      $mon = $sheet->getCell("B" . $row)->getValue();
      $des = $sheet->getCell("C" . $row)->getValue();
      
      $insertar = $db->query("INSERT INTO tblh_conciliar_pagos (Matricula, Descripcion, Importe, IdUsua, _idestatus)  VALUES ('$mat','$des','$mon','" . $_POST['IdUsua'] . "', 1)");
    }

    $sql_ba = $db->query("SELECT * FROM tblh_conciliar_pagos WHERE tblh_conciliar_pagos.IdUsua = '" . $_POST['IdUsua'] . "'");
    while ($ban = $db->recorrer($sql_ba)) {
      $sqlx9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Usuario = '" . $ban['Matricula'] . "' ");
      $db->rows($sqlx9);
      $datosx91 = $db->recorrer($sqlx9);
      $IdUsuax = $datosx91['IdUsua'];
      if ($IdUsuax) {
        $insertar = $db->query("UPDATE tblh_conciliar_pagos SET tblh_conciliar_pagos._idestatus = '8', tblh_conciliar_pagos._idUsua = '$IdUsuax' WHERE tblh_conciliar_pagos.IdTemporal = '" . $ban['IdTemporal'] . "' ");
      }       
    }


    if ($insertar) {
      $_SESSION['Alerta'] = "1";
      echo "<script type='text/javascript'>window.location='conciliar_pagos.php';</script>";
    } else {
      $_SESSION['Alerta'] = "8";
      echo "<script type='text/javascript'>window.location='conciliar_pagos.php';</script>";
    }
  }

  public function get_alumnosCal($IdUsua)
  {
    $db = new Conexion();
    $gAlumProcXss = [];
    $sql = $db->query("SELECT tblh_temcal.IdCal, tblh_temcal.Usuario, tblh_temcal.P1, tblh_temcal.P2, tblh_temcal.P3, tblh_temcal.P4, tblh_temcal.Ex1, tblh_temcal.Ex2, tblh_temcal.Promedio, tblh_temcal.A, tblh_temcal.F, tblh_temcal.IdEstatus, tblh_temcal.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblc_usuario.IdGrupo, tblp_grupo.CveGrupo FROM tblh_temcal Left Join tblc_usuario ON tblc_usuario.Usuario = tblh_temcal.Usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblh_temcal.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gAlumProcXss[] = $x;
    }
    return $gAlumProcXss;
  }

  public function get_concepPlagT($IdGrado)
  {
    $db = new Conexion();
    $get_concepPlagT = [];

    $sql = $db->query("SELECT
tblc_conceptosplanes.IdConceptoPlanes,
tblc_conceptosplanes.Code,
tblc_conceptosplanes.NomPlan,
tblc_conceptosplanes.Costo,
tblc_conceptosplanes.IdGrado,
tblc_conceptosplanes.IdUsua,
tblc_conceptosplanes.FecCap,
tblc_conceptosplanes.IdConcepto,
tblc_conceptosplanes.Recargo,
tblc_conceptosplanes.IdCampus,
tblc_conceptos.NomConcepto,
tblc_grado.Descripcion,
tblc_grado._Grado
FROM
tblc_conceptosplanes
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosplanes.IdConcepto
Left Join tblc_grado ON tblc_grado.IdGrado = tblc_conceptosplanes.IdGrado
WHERE tblc_conceptosplanes.IdGrado = '$IdGrado'
");
    while ($x = $db->recorrer($sql)) {
      $get_concepPlagT[] = $x;
    }
    return $get_concepPlagT;
  }


  public function add_calAlumnos()
  {
    $carpeta = "assets/docs/Excel/Calificacion/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='addSubirCal.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';


    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 2; $row <= $highestRow; $row++) {
      $usuario = $sheet->getCell("A" . $row)->getValue();
      $pa1 = $sheet->getCell("B" . $row)->getValue();
      $pa2 = $sheet->getCell("C" . $row)->getValue();
      $pa3 = $sheet->getCell("D" . $row)->getValue();
      $pa4 = $sheet->getCell("E" . $row)->getValue();
      $ex1 = $sheet->getCell("F" . $row)->getValue();
      $ex2 = $sheet->getCell("G" . $row)->getValue();
      $pro = $sheet->getCell("H" . $row)->getValue();
      $a = $sheet->getCell("I" . $row)->getValue();
      $f = $sheet->getCell("J" . $row)->getValue();
      if ($usuario) {

        $insertar = $db->query("INSERT INTO tblh_temcal (Usuario, P1, P2, P3, P4, Ex1, Ex2, IdUsua, IdEstatus, Promedio, A, F)  VALUES ('$usuario','$pa1','$pa2','$pa3','$pa4','$ex1','$ex2','" . $_POST["IdUsua"] . "','8','$pro','$a','$f')");
      }
      $usuario = "";
    }


    if ($insertar) {
      $_SESSION['Alerta'] = "5";
      echo "<script type='text/javascript'>window.location='addSubirCal.php';</script>";
    } else {
      $_SESSION['Alerta'] = "8";
      echo "<script type='text/javascript'>window.location='addSubirCal.php';</script>";
    }
  }

  public function del_calExcel($IdUsua)
  {
    $db = new Conexion();
    $insertar = $db->query("DELETE FROM tblh_temcal WHERE tblh_temcal.IdUsua = '$IdUsua'");

    if ($insertar) {
      $_SESSION['Alerta'] = "3";
      return 1;
    } else {
      return 0;
    }
  }

  public function get_alumnosCalLst($Oferta, $Modulo, $Grupo)
  {
    if (($Oferta) && ($Modulo) && ($Grupo)) {
      $db = new Conexion();
      //     echo "SELECT
      // tblc_usuario.IdUsua,
      // tblc_usuario.Nombre,
      // tblc_usuario.APaterno,
      // tblc_usuario.AMaterno,
      // tblc_usuario.Usuario,
      // tblp_calificacion.P1,
      // tblp_calificacion.P2,
      // tblp_calificacion.P3,
      // tblp_calificacion.P4,
      // tblp_calificacion.E1,
      // tblp_calificacion.E2
      // FROM
      // tblc_usuario
      // Left Join tblp_calificacion ON tblp_calificacion.Usuario = tblc_usuario.Matricula
      // WHERE tblc_usuario.Permisos = '3' AND tblp_calificacion.IdOferta = '$Oferta' AND tblp_calificacion.IdModulo = '$Modulo' AND tblc_usuario.IdGrupo = '$Grupo' ";

      $sql = $db->query("SELECT
  tblc_usuario.IdUsua,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno,
  tblc_usuario.Usuario,
  tblp_calificacion.P1,
  tblp_calificacion.P2,
  tblp_calificacion.P3,
  tblp_calificacion.P4,
  tblp_calificacion.E1,
  tblp_calificacion.E2
  FROM
  tblc_usuario
  Left Join tblp_calificacion ON tblp_calificacion.Usuario = tblc_usuario.Matricula
  WHERE tblc_usuario.Permisos = '3' AND tblp_calificacion.IdOferta = '$Oferta' AND tblp_calificacion.IdModulo = '$Modulo' AND tblc_usuario.IdGrupo = '$Grupo' ");
      while ($x = $db->recorrer($sql)) {
        $gAlGtss[] = $x;
      }
      return $gAlGtss;
    }
  }


  public function get_asignatyraU($IdOferta, $IdGrupo)
  {
    $db = new Conexion();

    $sqlx9 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    $db->rows($sqlx9);
    $datosx91 = $db->recorrer($sqlx9);
    $IdCampus = $datosx91['IdCampus'];


    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' ORDER BY tblp_modulo.CodeModulo ASC");
    while ($x = $db->recorrer($sql)) {
      $get_asignatyraU[] = $x;
    }
    return $get_asignatyraU;
  }

  public function get_asignatyraUD($IdCampus, $IdOferta)
  {
    $db = new Conexion();


    $get_asignatyraUD = [];
    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' ORDER BY tblp_modulo.CodeModulo ASC");
    while ($x = $db->recorrer($sql)) {
      $get_asignatyraUD[] = $x;
    }
    return $get_asignatyraUD;
  }

  public function get_gtiposraU($IdOferta, $IdModulo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdOferta = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $gOgrrtaETT[] = $x;
    }
    return $gOgrrtaETT;
  }

  public function add_savCali($IdUsua, $Oferta, $Modulo, $IdCiclo, $IdDocente, $Fecha, $IdGrupo, $IdCampus)
  {
    $db = new Conexion();

    $sqlx8 = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$Modulo'");
    $db->rows($sqlx8);
    $datx8 = $db->recorrer($sqlx8);
    $_idModulo = $datx8['IdModulo'];
    $_codeModulo = $datx8['CodeModulo'];

    $sqlx9 = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdModulo = '$Modulo' AND tblp_asignacion.IdEducativa = '$Oferta'");
    $db->rows($sqlx9);
    $datosx91 = $db->recorrer($sqlx9);
    $IdAsig = $datosx91['IdAsignacion'];
    if (!$IdAsig) {
      $anio = date("Y");
      $mes = date("m");
      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 15;
      $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
      $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdUsua, IdEducativa, IdModulo, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Anio, Mes, Fondo, _texto, Fecha_impresion) VALUES ('$IdAsig','$IdDocente','$Oferta','$Modulo','Finalizado',NOW(),'2','$IdGrupo','$IdCiclo','26','$IdCampus','$anio','$mes','----','----','$Fecha')");
    }

    $sqly = $db->query("SELECT * FROM tblh_temcal WHERE tblh_temcal.IdEstatus = '8' AND tblh_temcal.IdUsua = '$IdUsua'");
    while ($z = $db->recorrer($sqly)) {
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
    if (!$_idCic) {
      $sql_m = $db->query("SELECT tblp_modulo.Grado FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$Modulo'");
      $db->rows($sql_m);
      $_mod = $db->recorrer($sql_m);
      $_grado = $_mod['Grado'];
      $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado) VALUES('$IdCiclo','$IdGrupo',NOW(),'$_grado')");
    }

    $insertar = $db->query("DELETE FROM tblh_temcal WHERE tblh_temcal.IdUsua = '" . $_POST["IdUsua"] . "'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }
  public function get_nomGrupo($IdAsignacion)
  {

    $db = new Conexion();
    $sql = $db->query("SELECT
tblp_grupo.CveGrupo
FROM
tblp_asignacion
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
tblp_asignacion.Tipo =  '2'");
    while ($x = $db->recorrer($sql)) {
      $galumnosGrtT[] = $x;
    }
    return $galumnosGrtT;
  }

  public function get_lstGrupos($IdCiclo, $IdConPlan)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_grupo.CveGrupo, tblp_grupo.IdGrupo, tblc_conceptosdetalle.IdOferta FROM tblc_conceptosplanes Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblc_conceptosplanes.IdConceptoPlanes Left Join tblp_grupo ON tblp_grupo.IdOferta = tblc_conceptosdetalle.IdOferta WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdConPlan' AND tblp_grupo.IdGrupo IS NOT NULL ORDER BY tblp_grupo.CveGrupo ASC");
    while ($x = $db->recorrer($sql)) {
      $gcISrtT[] = $x;
    }
    return $gcISrtT;
  }

  public function add_excelUsuario()
  {
    $IdCampus = $_POST['txtCampusx'];
    $carpeta = "assets/docs/Excel/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='adAddUsuario.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();



    require_once 'assets/PHPExcel/Classes/PHPExcel.php';


    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 2; $row <= $highestRow; $row++) {
      $nombre = $sheet->getCell("A" . $row)->getValue();
      $paterno = $sheet->getCell("B" . $row)->getValue();
      $materno = $sheet->getCell("C" . $row)->getValue();
      $permisos = $sheet->getCell("D" . $row)->getValue();
      $usuario = $sheet->getCell("E" . $row)->getValue();
      $pass = $sheet->getCell("F" . $row)->getValue();
      $sexo = $sheet->getCell("G" . $row)->getValue();
      $correo = $sheet->getCell("H" . $row)->getValue();
      $celular = $sheet->getCell("I" . $row)->getValue();
      $fecnac = $sheet->getCell("J" . $row)->getValue();
      $anio = $sheet->getCell("K" . $row)->getValue();
      $idcampus = $sheet->getCell("L" . $row)->getValue();
      $conse = $sheet->getCell("M" . $row)->getValue();
      if ($nombre) {
        $usuario = $anio . $idcampus . $conse;
        $_idcampus = intval($idcampus);
        $insertar = $db->query("INSERT INTO tblh_temusers (Nombre, APaterno, AMaterno, Permisos, Campus, Usuario, Pass, IdUsua, FecCap, Sexo, IdEstatus, Correo, FecNac, Celular) VALUES('$nombre','$paterno','$materno','$permisos','$_idcampus','$usuario','$pass','" . $_POST["IdUsua"] . "',NOW(),'$sexo','8','$correo','$fecnac','$celular')");
      }
      $nombre = "";
    }


    if ($insertar) {
      echo "<script type='text/javascript'>window.location='adAddUsuario.php?tok=1';</script>";
    } else {
      echo "<script type='text/javascript'>window.location='adAddUsuario.php';</script>";
    }
  }

  public function add_excelUser()
  {
    $IdCampus = $_POST['txtCampus_'];

    $IdOferta = $_POST['txtOferta_'];
    $carpeta = "assets/docs/Excel/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = time();
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='adUsuario.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';


    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 2; $row <= $highestRow; $row++) {
      $nombre = $sheet->getCell("A" . $row)->getValue();
      $paterno = $sheet->getCell("B" . $row)->getValue();
      $materno = $sheet->getCell("C" . $row)->getValue();
      $correo = $sheet->getCell("D" . $row)->getValue();
      if ($nombre) {
        $sql8 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Correo = '$correo' AND tblc_usuario.IdEstatus = '8'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $IdS = $datos81["IdUsua"];
        if ($IdS) {
          $idEs = '28';
        } else {
          $idEs = '8';
        }

        $insertar = $db->query("INSERT INTO tblh_temusers (Nombre, APaterno, AMaterno, Permisos, Campus, IdUsua, FecCap, IdEstatus, Correo) VALUES('$nombre','$paterno','$materno','$IdOferta','$IdCampus','" . $_POST["IdUsua"] . "',NOW(),'$idEs','$correo')");
      }
      $nombre = "";
    }


    if ($insertar) {
      echo "<script type='text/javascript'>window.location='adUsuario.php?tok=1';</script>";
    } else {
      echo "<script type='text/javascript'>window.location='adUsuario.php';</script>";
    }
  }


  public function add_excelModulo()
  {
    //$tok = time().$_POST["txtIdGrupo"];
    $carpeta = "assets/docs/Excel/catModulo/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='adAddModulo.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();
    $idOfe = $_POST["txtOferta"];
    $idCam = $_POST["txtCampus"];

    $insertar = $db->query("INSERT INTO tblh_catmodulo (Link, FecCap, IdUsua, IdEstatus)VALUES('$archivo',NOW(),'" . $_POST["IdUsua"] . "','8')");
    $IdCatModulo = $db->insert_id;

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';
    // $archivoLec = "assets/docs/Excel/catModulo/".$archivo;
    //mkdir($archivoLec, 0777, true);
    //$archivoLec = "libro1.xlsx";

    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 2; $row <= $highestRow; $row++) {
      $a = $sheet->getCell("A" . $row)->getValue();
      $b = $sheet->getCell("B" . $row)->getValue();
      $c = $sheet->getCell("C" . $row)->getValue();
      $d = $sheet->getCell("D" . $row)->getValue();
      $e = $sheet->getCell("E" . $row)->getValue();
      //$d = 0; $e  = 0;
      if ($a) {
        $insertar = $db->query("INSERT INTO tblh_catmodulotem (IdAsignatura, Asignatura, IdGrupo, Grupo, IdCatModulo, IdEstatus, FecCap, IdUsua, IdCampus,IdOferta, HraDoc, HraInd) VALUES('$a','$b','$c','$c','$IdCatModulo','8',NOW(),'" . $_POST["IdUsua"] . "','$idCam','$idOfe','$d','$e')");
      }
    }

    if ($insertar) {
      $_SESSION['Alerta'] = "5";
      echo "<script type='text/javascript'>window.location='adAddModulo.php';</script>";
    } else {
      $_SESSION['Alerta'] = "8";
      echo "<script type='text/javascript'>window.location='adAddModulo.php';</script>";
    }
  }

  public function add_excelSaldo()
  {
    $carpeta = "assets/docs/Excel/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $archExcel = $_FILES["txtArchivo"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtArchivo"]['size']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $ext = $nombreImg[1];
    $code = md5(rand() * time());
    $archivo = $code . '.' . $ext;

    if (!move_uploaded_file($_FILES["txtArchivo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "2";
      echo "<script type='text/javascript'>window.location='adAddSaldo.php';</script>";
      exit();
    }

    $link = $carpeta . $archivo;
    $db = new Conexion();

    require_once 'assets/PHPExcel/Classes/PHPExcel.php';
    $inputFileType = PHPExcel_IOFactory::identify($link);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($link);
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    for ($row = 2; $row <= $highestRow; $row++) {
      $a = $sheet->getCell("A" . $row)->getValue();
      $b = $sheet->getCell("B" . $row)->getValue();
      $c = $sheet->getCell("C" . $row)->getValue();
      $d = $sheet->getCell("D" . $row)->getValue();

      if ($a) {
        // echo $b; die();
        $insertar = $db->query("INSERT INTO tblh_saldo (Matricula, Deuda, Fecha, Descripcion, IdUsua, IdEstatus)
          VALUES('$a','$b','$c','$d','" . $_POST["IdUsua"] . "','8')");
      }
    }

    if ($insertar) {
      $_SESSION['Alerta'] = "5";
      echo "<script type='text/javascript'>window.location='adAddSaldo.php';</script>";
    } else {
      $_SESSION['Alerta'] = "8";
      echo "<script type='text/javascript'>window.location='adAddSaldo.php';</script>";
    }
  }


  public function get_buscar_alumno($Buscar)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Nombre IS NOT NULL AND ((tblc_usuario.Permisos = '3') || (tblc_usuario.Permisos = '10')) HAVING CONCAT(tblc_usuario.Nombre,' ', tblc_usuario.APaterno ,' ', tblc_usuario.AMaterno) like '%" . $Buscar . "%' OR tblc_usuario.Usuario like '%" . $Buscar . "%' LIMIT 10");
    echo "<table class='table table-striped'><tbody>";
    while ($x = $db->recorrer($sql)) {
      $var = time();
      if ($x["IdEstatus"] == 8) {
        $ico = "<i style='color: blue;' class='fa fa-fw fa-check-circle'></i>";
      } elseif ($x["IdEstatus"] == 55) {
        $ico = "<i style='color: green;' class='fa fa-fw fa-graduation-cap'></i>";
      } elseif ($x["IdEstatus"] == 12) {
        $ico = "<i style='color: purple;' class='fa fa-fw fa-odnoklassniki'></i>";
      } else {
        $ico = "<i style='color: red;' class='fa fa-fw fa-warning'></i>";
      }


      $Id = $x["IdUsua"];
      $Foto = $x["Foto"];
      $Matricula = $x["Matricula"];
      $tok = $var . $Id;
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      echo "<tr><td style='cursor: pointer;' onClick='val_id_cobrar_us($tok)'> <img width='25px' src='assets/perfil/$Foto'> $ico $Matricula |  $Nombre </td></tr>";
    }
    echo "</tbody></table>";
  }


  public function get_buscar_alumno_conciliar($Buscar,$IdTemporal)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Nombre IS NOT NULL AND ((tblc_usuario.Permisos = '3') || (tblc_usuario.Permisos = '10')) HAVING CONCAT(tblc_usuario.Nombre,' ', tblc_usuario.APaterno ,' ', tblc_usuario.AMaterno) like '%" . $Buscar . "%' OR tblc_usuario.Usuario like '%" . $Buscar . "%' LIMIT 10");
    echo "<table class='table table-striped'><tbody>";
    while ($x = $db->recorrer($sql)) {
      $var = time();
      if ($x["IdEstatus"] == 8) {
        $ico = "<i style='color: blue;' class='fa fa-fw fa-check-circle'></i>";
      } elseif ($x["IdEstatus"] == 55) {
        $ico = "<i style='color: green;' class='fa fa-fw fa-graduation-cap'></i>";
      } elseif ($x["IdEstatus"] == 12) {
        $ico = "<i style='color: purple;' class='fa fa-fw fa-odnoklassniki'></i>";
      } else {
        $ico = "<i style='color: red;' class='fa fa-fw fa-warning'></i>";
      }


      $Id = $x["IdUsua"];
      $Foto = $x["Foto"];
      $Matricula = $x["Matricula"];
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      echo "<tr><td style='cursor: pointer;' onClick='usuario_seleccionado_id($IdTemporal,$Id)'> <img width='25px' src='assets/perfil/$Foto'> $ico $Matricula |  $Nombre </td></tr>";
    }
    echo "</tbody></table>";
  }

  public function get_buscarAlumno($Buscar, $IdUsua, $Estatus)
  {
    $db = new Conexion();
    
    if($Estatus == "true"){
      $condEstatus = " tblc_usuario.IdEstatus = '8' AND ";
    } else {
      $condEstatus = " ";
    }
    
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE $condEstatus tblc_usuario.Permisos = '3' HAVING CONCAT(tblc_usuario.Nombre,' ', tblc_usuario.APaterno ,' ', tblc_usuario.AMaterno) like '%" . $Buscar . "%' OR tblc_usuario.Usuario like '%" . $Buscar . "%' LIMIT 15");
    echo "<table class='table table-striped'><tbody>";
    while ($x = $db->recorrer($sql)) {
      $var = time();

      if ($x["IdEstatus"] == 8) {
        $ico = "<i style='color: blue;' class='fa fa-fw fa-check-circle'></i>";
      } elseif ($x["IdEstatus"] == 55) {
        $ico = "<i style='color: green;' class='fa fa-fw fa-graduation-cap'></i>";
      } elseif ($x["IdEstatus"] == 12) {
        $ico = "<i style='color: purple;' class='fa fa-fw fa-odnoklassniki'></i>";
      } else {
        $ico = "<i style='color: red;' class='fa fa-fw fa-warning'></i>";
      }

      $Id = $x["IdUsua"];
      $Foto = $x["Foto"];
      $Matricula = $x["Usuario"];
      $tok = $var . $Id;
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      echo "<tr><td style='cursor: pointer;' onClick='val_idEnviado($tok)'> <img width='25px' src='assets/perfil/$Foto'> $ico $Matricula |  $Nombre </td></tr>";
    }
    echo "</tbody></table>";
  }

  public function get_buscar_users($Buscar)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Nombre IS NOT NULL HAVING CONCAT(tblc_usuario.Nombre,'', tblc_usuario.APaterno ,'', tblc_usuario.AMaterno) like '%" . $Buscar . "%' OR tblc_usuario.Usuario like '%" . $Buscar . "%' LIMIT 7");
    echo "<table class='table table-striped'><tbody>";
    while ($x = $db->recorrer($sql)) {
      $var = time();

      $Id = $x["IdUsua"];
      $Foto = $x["Foto"];
      $Matricula = $x["Cargo"];
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      echo "<tr><td style='cursor: pointer;' onClick='recibe_user_id($Id)'> <img width='25px' src='assets/perfil/$Foto'> $Nombre ($Matricula) </td></tr>";
    }
    echo "</tbody></table>";
  }

  public function get_bus_mod_user($Buscar, $IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_menuusuario.IdMenuUsua, tblc_menuusuario.IdMenu, tblc_menuusuario.IdUsua, tblc_menuusuario.FecCap, tblc_menu.Code, tblc_menu.Color, tblc_menu.Nombre, tblc_menu.Tipo, tblc_menu.Permisos, tblc_menu.Link, tblc_menu.Icono FROM tblc_menuusuario Left Join tblc_menu ON tblc_menu.IdMenu = tblc_menuusuario.IdMenu WHERE tblc_menuusuario.IdUsua = '$IdUsua' HAVING CONCAT(tblc_menu.Code,'', tblc_menu.Nombre) like '%" . $Buscar . "%' ORDER BY tblc_menu.Code ASC");
    echo "<h4 style='margin-left: 15px; color: blue;' class='page-header'><i class='fa fa-fw fa-rss'></i> Resultado de la búsqueda:</h4>";
    while ($x = $db->recorrer($sql)) {
      $code = $x["Code"];
      $nombre = $x["Nombre"];
      $icono = $x["Icono"];
      $color = $x["Color"];
      $link = $x["IdMenu"];
      echo "<div class='col-lg-3 col-xs-6' onClick='val_ing_modulo($link)' style='cursor: pointer;'>
          <div class='small-box bg-$color'>
            <div class='inner'>
              <h3>$code</h3>
              <p>$nombre</p>
            </div>
            <div class='icon'>
              <i class='$icono'></i>
            </div>
            <a class='small-box-footer'>Ver más <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>";
    }
  }

  public function get_buscarAsesor($Buscar, $IdCampus)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '2' HAVING CONCAT(tblc_usuario.Nombre,' ', tblc_usuario.APaterno ,' ', tblc_usuario.AMaterno) like '%" . $Buscar . "%' LIMIT 17");
    echo "<table class='table table-striped'><tbody>";
    while ($x = $db->recorrer($sql)) {
      $var = time();

      $Id = $x["IdUsua"];
      $Foto = $x["Foto"];
      $tok = $var . $Id;
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      echo "<tr><td style='cursor: pointer;' onClick='val_idEnviadoAsesor($tok)'> <img width='25px' src='assets/perfil/$Foto'> $Nombre </td></tr>";
    }
    echo "</tbody></table>";
  }

  public function get_buscarUsers($Buscar, $IdCampus, $IdUsua, $IdPermiso)
  {
    $db = new Conexion();
    $cond = "";
    if ($IdPermiso == 3) {
      $cond = " AND tblc_usuario.Permisos <> '3'  ";
    }

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.Cargo, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_campus.Campus FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE  ((tblc_usuario.IdEstatus = '50') || (tblc_usuario.IdEstatus = '8')) $cond  HAVING CONCAT(tblc_usuario.Nombre,'', tblc_usuario.APaterno ,'', tblc_usuario.AMaterno ,'', tblc_usuario.Cargo) like '%" . $Buscar . "%' LIMIT 5");
    echo "<ul class='products-list product-list-in-box'>";
    while ($x = $db->recorrer($sql)) {
      $var = time();

      $Id = $x["IdUsua"];
      $Foto = $x["Foto"];
      $tok = $var . $Id;
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      $Cargo = $x["Cargo"];
      $Campus = $x["Campus"];
      echo "<li class='item' onClick='generarConsulta($Id)' style='cursor: pointer; background: #d9d9d9;'>
        <div class='product-img'>
          <img style='width: 50px; height: 50px;' src='assets/perfil/$Foto'>
        </div>
        <div class='product-info'>
          <span class='product-description'>$Nombre</span>
          <a href='javascript:void(0)' class='product-title'>$Cargo</a>
          <span class='product-description'>$Campus</span>
        </div>
      </li>";
    }
    echo "</ul>";



    // $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.Cargo, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' HAVING CONCAT(tblc_usuario.Nombre,'', tblc_usuario.APaterno ,'', tblc_usuario.AMaterno ,'', tblc_usuario.Cargo) like '%".$Buscar."%' LIMIT 10");
    // echo "<table class='table table-striped' style='font-size: 12px;'><tbody>";
    // while($x = $db->recorrer($sql)){
    //   $var = time();
    //
    //   $Id= $x["IdUsua"];
    //   $Foto= $x["Foto"];
    //   $tok = $var.$Id;
    //   $Nombre= $x["Cargo"].' - '.$x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"];
    //   echo "<tr><td style='cursor: pointer;' onClick='generarConsulta($Id)'> <img width='25px' src='assets/perfil/$Foto'> $Nombre </td></tr>";
    // }
    // echo "</tbody></table>";
  }

  public function get_campusPermiso($IdUsua)
  {
    $db = new Conexion();
    $gCampusIdPer = [];
    $sql = $db->query("SELECT tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus");
    while ($x = $db->recorrer($sql)) {
      $gCampusIdPer[] = $x;
    }
    return $gCampusIdPer;
  }

  public function get_lista_planes_activas()
  {
    $db = new Conexion();
    $get_lista_planes_activas = [];
    $sql = $db->query("SELECT tblp_educativa.IdEducativa, tblp_educativa.Nombre FROM tblp_educativa WHERE tblp_educativa.IdGrado <=  '4' ORDER BY tblp_educativa.IdGrado ASC, tblp_educativa.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_lista_planes_activas[] = $x;
    }
    return $get_lista_planes_activas;
  }

  public function get_all_grupo($IdUsua)
  {
    $db = new Conexion();
    $get_all_grupo = [];
    $sql = $db->query("SELECT
tblp_coordinador.IdOferta,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Grado
FROM
tblp_coordinador
Left Join tblp_grupo ON tblp_grupo.IdOferta = tblp_coordinador.IdOferta
WHERE
tblp_coordinador.IdUsua =  '$IdUsua' AND
tblp_grupo.IdEstatus =  '8'
 ");
    while ($x = $db->recorrer($sql)) {
      $get_all_grupo[] = $x;
    }
    return $get_all_grupo;
  }

  public function get_doc_list()
  {
    $db = new Conexion();
    $get_doc_list = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_campus.Campus,
tblc_usuario.IdCampus,
tblc_usuario.Sexo,
tblc_usuario.FecNac
FROM
tblc_usuario
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE
tblc_usuario.Permisos =  '2'
ORDER BY
tblc_usuario.IdCampus ASC,
tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_doc_list[] = $x;
    }
    return $get_doc_list;
  }

  public function get_ciclo_activo()
  {
    $db = new Conexion();
    $get_ciclo_activo = [];
    $sql = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC ");
    //$sql = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclo.Tipo,  tblc_ciclo.Ciclo FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo GROUP BY tblc_ciclogrupo.IdCiclo ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC ");
    while ($x = $db->recorrer($sql)) {
      $get_ciclo_activo[] = $x;
    }
    return $get_ciclo_activo;
  }

  public function get_meses_disponibles()
  {
    $db = new Conexion();
    $get_meses_disponibles = [];
    $sql = $db->query("SELECT tblp_gastos.AnioMes FROM tblp_gastos GROUP BY tblp_gastos.AnioMes ORDER BY tblp_gastos.AnioMes ASC");
    while ($x = $db->recorrer($sql)) {
      $get_meses_disponibles[] = $x;
    }
    return $get_meses_disponibles;
  }

  public function get_buscarPlaneacion($Buscar, $IdCampus)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_planeacion.IdPlaneacion,
tblp_planeacion.IdAsignacion,
tblp_planeacion.Planeacion,
tblp_planeacion.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM tblp_planeacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_planeacion.IdUsua
 WHERE tblp_planeacion.IdCampus = '$IdCampus' HAVING tblp_planeacion.Planeacion like '%" . $Buscar . "%' OR tblc_usuario.Nombre like '%" . $Buscar . "%' LIMIT 7");
    echo "<table class='table table-striped'><tbody>";
    while ($x = $db->recorrer($sql)) {
      $var = time();
      $IdP = $x["IdPlaneacion"];
      $planeacion = $x["Planeacion"];
      $tok = $var . $IdP;
      $Nombre = $x["Nombre"] . ' ' . $x["APaterno"] . ' ' . $x["AMaterno"];
      echo "<tr><td style='cursor: pointer;' onClick='val_idEnviadoPlaneacion($tok)'> $planeacion -  $Nombre </td></tr>";
    }
    echo "</tbody></table>";
  }

  public function get_buscarAsignatura($IdTema)
  {
    $db = new Conexion();

    $sql8 = $db->query("SELECT * FROM tblp_plantemas WHERE tblp_plantemas.IdTema = '$IdTema'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdPlan = $datos81["IdPlan"];
    $IdOferta = $datos81["IdOferta"];
    $Grado = $datos81["Cuatrimestre"];

    $IdCampus = $_SESSION["IdCampus"];
    $sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_modulo.Grado FROM tblp_modulo   WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.Grado = '$Grado' AND tblp_modulo.IdCampus = '$IdCampus'");
    echo "<table class='table table-striped'><tbody><tr>";
    echo "<tr><td colspan='2'><b>Etapas de la metodolog&iacute;a ABP:</b></td><td> ";
    for ($i = 1; $i < 10; $i++) {
      $sql4 = $db->query("SELECT * FROM tblp_planetapa WHERE tblp_planetapa.IdTema = '$IdTema' AND tblp_planetapa.IdPlan = '$IdPlan' AND tblp_planetapa.Etapa = '$i'");
      $db->rows($sql4);
      $datos41 = $db->recorrer($sql4);
      $IdEtapa = $datos41["IdEtapa"];
      if ($IdEtapa) {
        echo "<button onClick='del_etapa($IdTema,$IdEtapa)' type='button' class='btn btn-success'>$i</button>";
      } else {
        echo "<button onClick='add_etapa($IdPlan,$IdTema,$i)' type='button' class='btn btn-default'>$i</button>";
      }
    }
    echo "</td></tr>";
    echo "<tr>";

    while ($x = $db->recorrer($sql)) {
      $IdM = $x["IdModulo"];
      $sql5 = $db->query("SELECT * FROM tblp_planasignatura WHERE tblp_planasignatura.IdTema = '$IdTema' AND tblp_planasignatura.IdModulo = '$IdM'");
      $db->rows($sql5);
      $datos51 = $db->recorrer($sql5);
      $IdAsig = $datos51["IdAsignatura"];


      $code = $x["CodeModulo"];
      $asignatura = $x["NombreMod"];
      if ($IdAsig) {
        echo "<td><button onClick='del_addAsignat($IdTema,$IdAsig)' type='button' class='btn btn-block btn-success btn-xs'><i class='fa fa-fw fa-check-circle'></i></button></td>";
      } else {
        echo "<td><button onClick='val_addAsignat($IdPlan,$IdTema,$IdM)' type='button' class='btn btn-block btn-default btn-xs'><i class='fa fa-fw fa-times-circle'></i></button></td>";
      }

      echo "<td> $code </td><td>$asignatura</td></tr>";
    }
    echo "</tbody></table>";
  }



  public function get_balanzaGral($IdOferta, $fecha1, $fecha2)
  {
    if ($IdOferta == "TODAS") {
      $cond = "";
    } else {
      $cond = " AND tblp_pagos.IdOferta = '$IdOferta' ";
    }
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago,
tblp_pagos.TotalPagado,
tblp_pagos.FecPago,
tblc_conceptos.NomConcepto,
tblp_educativa.Nombre AS nomEducativa,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_grupo.Grupo,
tblp_grupo.CveGrupo,
tblc_bancos.Banco FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_pagos.IdBanco
 WHERE tblp_pagos.IdEstatus =  '4' $cond AND tblp_pagos.FecPago BETWEEN  '$fecha1' AND '$fecha2'");
    while ($x = $db->recorrer($sql)) {
      $gBalanza[] = $x;
    }
    return $gBalanza;
  }

  public function get_listarespuestaDupl($asignacion, $IdActividadDoc)
  {
    $db = new Conexion();
    $sqlDuplicados = $db->query("SELECT IdAlumno, COUNT(*) AS total FROM tblp_tareas WHERE IdAsignacion = '$asignacion' AND IdActividadesDocente = '$IdActividadDoc' GROUP BY IdAlumno HAVING COUNT(*) > 1");
    while ($dup = $db->recorrer($sqlDuplicados)) {
        $IdAlumno = $dup['IdAlumno'];
        $sqlTareas = $db->query("SELECT * FROM tblp_tareas WHERE IdAsignacion = '$asignacion' AND IdActividadesDocente = '$IdActividadDoc' AND IdAlumno = '$IdAlumno' ORDER BY CASE WHEN (Link IS NOT NULL AND Link <> '') OR (Link2 IS NOT NULL AND Link2 <> '') OR (Link3 IS NOT NULL AND Link3 <> '') THEN 1 ELSE 0 END DESC, CASE WHEN Calificacion IS NOT NULL AND Calificacion <> '' THEN 1 ELSE 0 END DESC,IdTarea ASC");
        $tareas = [];
        while ($t = $db->recorrer($sqlTareas)) {
            $tareas[] = $t;
        }
        if (count($tareas) <= 1) {
            continue;
        }

        for ($i = 1; $i < count($tareas); $i++) {
            $IdTareaEliminar = $tareas[$i]['IdTarea'];
            $db->query("DELETE FROM tblp_examusuario WHERE IdTarea = '$IdTareaEliminar'");
            $db->query("DELETE FROM tblp_editor WHERE IdTarea = '$IdTareaEliminar'");
            $db->query("DELETE FROM tblp_tareas WHERE IdTarea = '$IdTareaEliminar'");
        }
    }

    return true;
  }

  // public function get_listarespuestaDupl($asignacion, $IdActividadDoc, $tipo)
  // {
  //   $db = new Conexion();
  //   $insertar = $db->query("DELETE FROM tblp_tareas WHERE tblp_tareas.IdAlumno = 0 ");

  //   $IdNuevo = "";
  //   $IdSig = "";
  //   $sql = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$asignacion' AND tblp_tareas.IdActividadesDocente =  '$IdActividadDoc' ORDER BY tblp_tareas.IdAlumno ASC, tblp_tareas.Link DESC");
  //   while ($x = $db->recorrer($sql)) {
  //     $IdNuevo = $x["IdAlumno"];
  //     if ($IdNuevo == $IdSig) {
  //       $IdTarea = $x["IdTarea"];
  //       $insertar = $db->query("DELETE FROM tblp_tareas WHERE tblp_tareas.IdTarea = '$IdTarea'");
  //       $insertar = $db->query("DELETE FROM tblp_examusuario WHERE tblp_examusuario.IdTarea = '$IdTarea'");
  //       $insertar = $db->query("DELETE FROM tblp_editor WHERE tblp_editor.IdTarea = '$IdTarea'");
  //     }
  //     $IdSig = $x["IdAlumno"];
  //   }
  // }

  public function get_addCampusLst()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblc_usuario.IdCampus AS Campus, tblp_pagos.IdCampus FROM tblp_pagos Inner Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua WHERE tblp_pagos.IdCampus IS NULL LIMIT 100");
    while ($x = $db->recorrer($sql)) {
      $IdCampus = $x["Campus"];
      $IdPago = $x["IdPago"];
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdCampus = '$IdCampus' WHERE tblp_pagos.IdPago = '$IdPago'");
    }
  }

  public function get_addDatFol()
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_foliospago.IdFolio, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblp_foliospago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua WHERE tblp_foliospago.Tipo IS NULL AND tblp_foliospago.IdCampus IS NULL LIMIT 50");
    while ($x = $db->recorrer($sql)) {
      $IdCampus = $x["IdCampus"];
      $IdOferta = $x["IdOferta"];
      $IdFolio = $x["IdFolio"];
      $insertar = $db->query("UPDATE tblp_foliospago SET tblp_foliospago.IdCampus = '$IdCampus', tblp_foliospago.IdOferta = '$IdOferta' WHERE tblp_foliospago.IdFolio = '$IdFolio'");
    }
  }

  public function del_delParcial($IdParcial)
  {
    $db = new Conexion();
    // $insertar = $db->query("DELETE FROM tblp_fuentedocente WHERE tblp_fuentedocente.IdParcialDocente = '$IdParcial'");
    $insertar = $db->query("DELETE FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdParcialDocente = '$IdParcial'");
    $insertar = $db->query("DELETE FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente = '$IdParcial'");
    $insertar = $db->query("DELETE FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial'");
    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function get_conceptospAG($IdOferta, $IdCampus)
  {
    if ($IdOferta) {
      $db = new Conexion();
      // $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      // $db->rows($sql9);
      // $datos91 = $db->recorrer($sql9);
      // $IdGrado = $datos91["IdGrado"];
      // $insertar = $db->query("UPDATE tblc_usuario SET GPago='1' WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdOferta = '$IdOferta' AND tblc_usuario.IdCampus = '$IdCampus'");

      $sql = $db->query("SELECT
tblc_conceptosplanes.NomPlan,
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_conceptosplanes.IdConceptoPlanes
FROM
tblc_conceptosdetalle
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta = '$IdOferta'");
      while ($x = $db->recorrer($sql)) {
        $gConceptos[] = $x;
      }
      return $gConceptos;
    }
  }

  public function get_karUser($IdUsua)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Sexo, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_usuario.Sexo, tblc_usuario.IdGrupo, tblc_usuario.SemCua, tblc_usuario.Folio, tblp_grupo.Modalidad, tblp_grupo.TipoCiclo, tblp_grupo.Tipo, tblp_grupo.CveGrupo, tblp_grupo.Periodo, tblp_educativa.Nombre AS Educativa, tblp_educativa.IdGrado, tblp_educativa.Rvoe, tblp_educativa.Vigencia, tblc_usuario.Usuario FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gDatUss[] = $x;
    }
    return $gDatUss;
  }

  public function get_chkDocs($Modalidad, $IdGrado, $Grupo, $IdCampus)
  {
    $db = new Conexion();
    $get_chkDocs = [];
    $semcua = substr($Grupo, 7, 1);
    if ($IdGrado == 2) {
      if ($Modalidad == "L") {
        $mod = "L";
      } else {
        $mod = "P";
      }
    } else {
      if ($Modalidad == "E") {
        $mod = "E";
      } else {
        $mod = "N";
      }
      if ($Modalidad == "E") {
        $mod = "E";
      } else {
        $mod = "N";
      }
    }



    $sql = $db->query("SELECT
tblp_docs.Tipo,
tblp_docs.Nombre,
tblp_docs.Archivo,
tblc_ciclo.Ciclo
FROM
tblp_docs
Left Join tblp_docscampus ON tblp_docscampus.IdDocs = tblp_docs.IdDocs
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs.IdCiclo
WHERE
tblp_docs.Grado =  '$IdGrado' AND
tblp_docscampus.IdCampus =  '$IdCampus' AND
tblp_docs.Modalidad = '$mod' AND

tblp_docs.Permisos = '3' AND
tblc_ciclo.Estatus =  'Vigente'");
    //tblp_docs.SemCua = '$semcua' AND
    // $sql = $db->query("SELECT tblp_docs.IdDocs, tblp_docs.Modalidad, tblp_docs.Tipo, tblp_docs.Nombre, tblp_docs.Archivo, tblp_docs.FecCap, tblc_grado.Descripcion, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblp_docs Left Join tblc_grado ON tblc_grado.IdGrado = tblp_docs.Grado Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_docs.IdEstatus WHERE tblp_docs.Modalidad = '$mod' AND tblp_docs.Grado = '$IdGrado'");
    while ($x = $db->recorrer($sql)) {
      $get_chkDocs[] = $x;
    }
    return $get_chkDocs;
  }

  public function get_chkDocsDoc($IdCampus)
  {
    $db = new Conexion();

    $get_chkDocsDoc = [];
    $sql = $db->query("SELECT
tblp_docs.IdDocs,
tblp_docs.Grado,
tblp_docs.Modalidad,
tblp_docs.Tipo,
tblp_docs.Nombre,
tblp_docs.IdCiclo,
tblp_docs.Archivo,
tblp_docs.IdUsua,
tblp_docs.IdEstatus,
tblp_docs.FecCap,
tblp_docs.SemCua,
tblp_docs.Permisos,
tblp_docscampus.IdCampus,
tblc_ciclo.Ciclo
FROM
tblp_docs
Left Join tblp_docscampus ON tblp_docscampus.IdDocs = tblp_docs.IdDocs
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs.IdCiclo
WHERE
tblp_docscampus.IdCampus =  '$IdCampus' AND
tblp_docs.Permisos =  '2' AND
tblc_ciclo.Estatus =  'Vigente'
");

    // $sql = $db->query("SELECT tblp_docs.IdDocs, tblp_docs.Modalidad, tblp_docs.Tipo, tblp_docs.Nombre, tblp_docs.Archivo, tblp_docs.FecCap, tblc_grado.Descripcion, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblp_docs Left Join tblc_grado ON tblc_grado.IdGrado = tblp_docs.Grado Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_docs.IdEstatus WHERE tblp_docs.Modalidad = '$mod' AND tblp_docs.Grado = '$IdGrado'");
    while ($x = $db->recorrer($sql)) {
      $get_chkDocsDoc[] = $x;
    }
    return $get_chkDocsDoc;
  }

  public function get_chkHorario($IdUsua)
  {
    $db = new Conexion();
    $get_chkHorario = [];
    $sql = $db->query("SELECT tblp_moduloalumno.IdAsignacion, tblp_modulo.NombreMod FROM tblp_moduloalumno Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.Estatus = 'Activo' ");
    while ($x = $db->recorrer($sql)) {
      $get_chkHorario[] = $x;
    }
    return $get_chkHorario;
  }

public function get_chkHorarioDoc($IdUsua)
  {
    $db = new Conexion();
    $get_chkHorarioDoc = [];


    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_modulo.NombreMod,
tblc_ciclogrupo.Grado,
tblp_grupo.Grupo,
tblp_educativa.Nombre,
tblc_grado._Grado
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
WHERE tblp_asignacion.IdUsua = '$IdUsua' AND tblp_asignacion.Estatus = 'Activo' AND tblp_asignacion.Tipo = '2'ORDER BY
tblp_educativa.IdGrado DESC,
tblp_educativa.IdEducativa ASC,
tblc_ciclogrupo.Grado ASC,
tblp_grupo.Grupo ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_chkHorarioDoc[] = $x;
    }
    return $get_chkHorarioDoc;
  }

 public function get_chkHor($IdAsignacion)
{
    $db = new Conexion();

    // 1) Traer lo que sí existe
    $sql = $db->query(" SELECT  IdHorario, IdAsignacion, IdDia, HraIni, MinIni, HraFin, MinFin, Total FROM tblp_horario WHERE IdAsignacion = '" . $db->real_escape_string($IdAsignacion) . "' ");

    // 2) Indexar por IdDia para acceso rápido
    $byDia = [];
    while ($x = $db->recorrer($sql)) {
        $byDia[(int)$x['IdDia']] = $x;
    }

    // 3) Construir arreglo final con 1..7
    $result = [];
    for ($dia = 1; $dia <= 7; $dia++) {
        if (isset($byDia[$dia])) {
            $result[] = $byDia[$dia];
        } else {
            // Registro "vacío" cuando no existe en BD
            $result[] = [
                'IdHorario'    => null,
                'IdAsignacion' => $IdAsignacion,
                'IdDia'        => $dia,
                'HraIni'       => null,
                'MinIni'       => null,
                'HraFin'       => null,
                'MinFin'       => null,
                'Total'        => 0,   // o null, como tú prefieras
            ];
        }
    }

    return $result;
}

    public function get_chkHor_activa($IdAsignacion,$Dia)
  {
    $db = new Conexion();
    $get_chkHor_activa = [];
    $sql = $db->query("SELECT tblp_horario.IdHorario, tblp_horario.IdAsignacion, tblp_horario.IdDia, tblp_horario.HraIni, tblp_horario.MinIni, tblp_horario.HraFin, tblp_horario.MinFin, tblp_horario.Total FROM tblp_horario WHERE tblp_horario.IdAsignacion =  '$IdAsignacion' AND tblp_horario.IdDia =  '$Dia'");
    while ($x = $db->recorrer($sql)) {
      $get_chkHor_activa[] = $x;
    }
    return $get_chkHor_activa;
  }

  public function get_rvoe_list()
  {
    $db = new Conexion();
    $get_rvoe_list = [];
    $sql = $db->query("SELECT tblc_rvoe.IdRvoe, tblc_rvoe.IdEducativa, tblc_rvoe.Educativa, tblc_rvoe.IdCampus, tblc_rvoe.Rvoe, tblc_rvoe.Vigencia, tblc_rvoe.Turno, tblc_rvoe.Modalidad, tblc_rvoe.Escuela, tblc_rvoe.Localidad, tblc_rvoe.Clave, tblc_campus.Campus FROM tblc_rvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus");
    while ($x = $db->recorrer($sql)) {
      $get_rvoe_list[] = $x;
    }
    return $get_rvoe_list;
  }

  public function get_menDatos($IdGrupo)
  {
    $db = new Conexion();

    $sql6 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $IdCampus = $datos61["IdCampus"];
    $IdOferta = $datos61["IdOferta"];
    $get_menDatos = [];

    $sql = $db->query("SELECT tblp_rvoe.IdRvoe, tblp_rvoe.Clave, tblp_rvoe.IdEducativa, tblp_rvoe.IdCampus, tblp_rvoe.Rvoe, tblp_rvoe.Vigencia, tblp_rvoe.Turno, tblp_rvoe.Modalidad, tblp_educativa.Nombre, tblp_educativa.IdGrado, tblc_campus.Campus FROM tblp_rvoe Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_rvoe.IdEducativa Left Join tblc_campus ON tblc_campus.IdCampus = tblp_rvoe.IdCampus WHERE tblp_rvoe.IdCampus =  '$IdCampus' AND tblp_rvoe.IdEducativa = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $get_menDatos[] = $x;
    }
    return $get_menDatos;
  }

  public function get_ckeProm($User)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.Promedio FROM tblp_calificacion WHERE tblp_calificacion.Usuario =  '$User'");
    while ($x = $db->recorrer($sql)) {
      $porciones = explode(".", $x["Promedio"]);
      $prom = $porciones[0];
      $IdCal = $x["IdCalificacion"];
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$prom' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
    }
  }

  public function get_chkRep($Usuario, $IdOferta)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion FROM tblp_calificacion WHERE tblp_calificacion.Usuario =  '$Usuario' AND tblp_calificacion.IdOferta <>  '$IdOferta' ");
    while ($x = $db->recorrer($sql)) {
      $IdCal = $x["IdCalificacion"];

      $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
    }

    $IdModIni = 0;
    $IdModFin = 0;

    $sql2 = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdModulo FROM tblp_calificacion WHERE tblp_calificacion.Usuario =  '$Usuario' AND tblp_calificacion.IdOferta =  '$IdOferta' ORDER BY tblp_calificacion.IdModulo ASC");
    while ($y = $db->recorrer($sql2)) {
      $IdCal2 = $y["IdCalificacion"];
      $IdModIni = $y["IdModulo"];
      if ($IdModIni == $IdModFin) {
        $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal2'");
      }
      $IdModFin = $y["IdModulo"];
    }
  }

  public function get_calificacion($IdUsua, $Grado)
  {
    $db = new Conexion();
    $get_calificacion = [];

    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.P1,tblp_calificacion.P2, tblp_calificacion.P3, tblp_calificacion.P4, tblp_calificacion.Observacion, tblp_calificacion.Promedio, tblp_calificacion.E1, tblp_calificacion._obs, tblp_calificacion.E2, tblp_modulo.NombreMod, tblp_modulo.Grado, tblp_modulo.CodeModulo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_modulo.Grado =  '$Grado' ORDER BY tblp_modulo.NombreMod ASC");
    while ($x = $db->recorrer($sql)) {
      $get_calificacion[] = $x;
    }
    return $get_calificacion;
  }

  public function get_calificacion_alumno($IdUsua)
  {
    $db = new Conexion();
    $get_calificacion_alumno = [];

    $sql = $db->query("SELECT
    tblp_calificacion.IdUsua,
    tblp_calificacion.Usuario,
    tblp_calificacion.Promedio,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblc_ciclo.Ciclo,
    tblp_calificacion.IdCiclo
    FROM
    tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua'
    ORDER BY
    tblc_ciclo.FInicio ASC,
    tblp_modulo.CodeModulo ASC");
    while ($x = $db->recorrer($sql)) {
      $get_calificacion_alumno[] = $x;
    }
    return $get_calificacion_alumno;
  }


  public function get_lstAdfrRg($IdAsignacion, $IdModulo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.FecIni,
tblp_asignacion.Id,
tblp_asignacion.FecFin,
tblc_ciclo.Ciclo
FROM
tblp_asignacion
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
 WHERE tblp_asignacion.IdModulo = '$IdModulo' AND tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while ($x = $db->recorrer($sql)) {
      $gTsdFDt[] = $x;
    }
    return $gTsdFDt;
  }

  public function get_lstRecursar($IdEducativa, $IdCampus, $IdGrupo)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
  tblp_moduloalumno.IdModuloAlumno,
  tblp_moduloalumno.IdEducativa,
  tblp_moduloalumno.IdModulo,
  tblp_moduloalumno.IdAsignacion,
  tblp_modulo.NombreMod,
  tblp_modulo.CodeModulo,
  tblp_grupo.CveGrupo,
  tblp_grupo.Nivel,
  tblp_moduloalumno.IdGrupo
  FROM
  tblp_moduloalumno
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
  WHERE
  tblp_moduloalumno.IdEducativa =  '$IdEducativa' AND
  tblp_moduloalumno.Estatus =  'Activo' AND
  tblp_modulo.IdCampus =  '$IdCampus' AND
  tblp_moduloalumno.IdGrupo =  '$IdGrupo'
  GROUP BY
  tblp_moduloalumno.IdModulo");
    while ($x = $db->recorrer($sql)) {
      $gGrpuLst[] = $x;
    }
    return $gGrpuLst;
  }

  public function get_gruposDispods($IdOferta, $IdCampus, $IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();


      $sql = $db->query("SELECT
  tblp_moduloalumno.IdGrupo,
  tblp_grupo.CveGrupo,
  tblp_grupo.Nivel
  FROM
  tblp_moduloalumno
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
  Inner Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
  WHERE
  tblp_moduloalumno.IdEducativa =  '$IdOferta' AND
  tblp_moduloalumno.Estatus =  'Activo' AND
  tblp_moduloalumno.IdGrupo <>  '$IdGrupo' AND
  tblp_modulo.IdCampus =  '$IdCampus'
  GROUP BY
  tblp_moduloalumno.IdGrupo");
      while ($x = $db->recorrer($sql)) {
        $get_gruposDispods[] = $x;
      }
      return $get_gruposDispods;
    }
  }

  public function get_gruposTotalCV($IdOferta)
  {
    if ($IdOferta) {
      $db = new Conexion();

      $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdOferta = '$IdOferta' ORDER BY tblp_grupo.CveGrupo ASC");
      while ($x = $db->recorrer($sql)) {
        $get_gruposTotalCV[] = $x;
      }
      return $get_gruposTotalCV;
    }
  }

  public function get_bajaUser($IdCampus, $IdCiclo)
  {
    $db = new Conexion();
    if (($IdCampus) && ($IdCiclo)) {
      $get_bajaUser = [];
      $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblp_educativa.Nombre AS Educativa
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdCampus
WHERE
tblc_usuario.Permisos =  '3' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario.id_ciclo_fin = '$IdCiclo'");
      while ($x = $db->recorrer($sql)) {
        $get_bajaUser[] = $x;
      }
      return $get_bajaUser;
    }
  }

  public function get_calProceso($IdUsua, $IdOferta, $Grado)
  {
    $db = new Conexion();
    $get_calProceso = [];
    

    $sql = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_moduloalumno.ParcialF1,
tblp_moduloalumno.ParcialF2,
tblp_moduloalumno.ParcialF3,
tblp_moduloalumno.ParcialF4,
tblp_moduloalumno.Promedio,
tblp_moduloalumno.Promedio_final,
tblp_modulo.NombreMod
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
WHERE
tblp_moduloalumno.Estatus =  'Activo' AND
tblp_moduloalumno.IdUsua =  '$IdUsua' AND
tblp_moduloalumno.IdEducativa =  '$IdOferta' AND
tblp_modulo.Grado =  '$Grado'
");
    while ($x = $db->recorrer($sql)) {
      $get_calProceso[] = $x;
    }
    return $get_calProceso;
  }

  public function get_grupoId($IdGrupo)
  {
    $db = new Conexion();
    $gGrDadf = [];
    $sql = $db->query("SELECT tblp_grupo.CveGrupo FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $gGrDadf[] = $x;
    }
    return $gGrDadf;
  }

  public function get_docsSubidsX($IdOferta)
  {
    $db = new Conexion();

    $sql = $db->query("SELECT
tblp_libro.IdLibro,
tblp_libro.FecCap,
tblp_libro.Nombre,
tblp_libro.Link,
tblp_libro.Tipo,
tblp_libro.Oferta,
tblp_libro.Code,
tblp_temas.Descripcion,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod
FROM
tblp_libro
Left Join tblp_temas ON tblp_temas.IdTema = tblp_libro.IdTema
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_libro.IdOferta
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_libro.IdModulo WHERE tblp_libro.IdOferta = '$IdOferta'");
    while ($x = $db->recorrer($sql)) {
      $gDocsL[] = $x;
    }
    return $gDocsL;
  }

  public function get_docsAvisos()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_aviso");
    while ($x = $db->recorrer($sql)) {
      $gDocsAcsL[] = $x;
    }
    return $gDocsAcsL;
  }
  public function get_docsAvisosUs($IdUsua)
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_aviso WHERE tblc_aviso.id_usua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $gDocsAcsL[] = $x;
    }
    return $gDocsAcsL;
  }

  public function get_aperturaId($NoParcial, $IdCiclo, $Tipo)
  {
    $db = new Conexion();
    if ($Tipo == "E") {
      $Tipo = "E";
    } else {
      $Tipo = "N";
    }
    $get_aperturaId = [];
    $sql = $db->query("SELECT * FROM tblc_apertura WHERE tblc_apertura.IdCiclo = '$IdCiclo' AND tblc_apertura.NoParcial = '$NoParcial' AND tblc_apertura.Tipo = '$Tipo'");
    while ($x = $db->recorrer($sql)) {
      $get_aperturaId[] = $x;
    }
    return $get_aperturaId;
  }

  public function get_parIndiv($IdParcial)
  {
    $db = new Conexion();
    $get_parIndiv = [];
    $sql = $db->query("SELECT tblp_parcialdocente.Fecha FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcial' ");
    while ($x = $db->recorrer($sql)) {
      $get_parIndiv[] = $x;
    }
    return $get_parIndiv;
  }

  public function get_docsLine()
  {
    $db = new Conexion();
    $get_docsLine = [];

    $sql = $db->query("SELECT tblp_docs.IdDocs, tblp_docs.Anio, tblp_docs.Mes, tblp_docs.Nombre, tblp_docs.Archivo, tblp_docs.FecCap, tblc_grado._Grado, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblp_docs Left Join tblc_grado ON tblc_grado.IdGrado = tblp_docs.IdGrado Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_docs.IdEstatus ");
    while ($x = $db->recorrer($sql)) {
      $get_docsLine[] = $x;
    }
    return $get_docsLine;
  }

  public function get_campA()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus");
    while ($x = $db->recorrer($sql)) {
      $gCampT[] = $x;
    }
    return $gCampT;
  }

  public function add_uploadPubl()
  {
    $db = new Conexion();
    $Id = $_POST["publicidad"];
    $carpeta = "assets/images/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtPublicidad"]['name']; //nombre del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $tipo = $nombreImg[1];
    $archivo = 'portada.' . $tipo;

    if (!move_uploaded_file($_FILES["txtPublicidad"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adPlataforma.php'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;
    if (file_exists($nombre_fichero)) {
      $insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Descripcion = '$archivo' WHERE tblp_configuracion.IdConfig = '$Id'");
      echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
    }
    echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
  }

  public function add_uploadLogo()
  {
    $db = new Conexion();
    $Id = $_POST["logo"];
    $carpeta = "assets/images/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtLogo"]['name']; //nombre del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $tipo = $nombreImg[1];
    $archivo = 'logo.' . $tipo;
    if (!move_uploaded_file($_FILES["txtLogo"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adPlataforma.php'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;
    if (file_exists($nombre_fichero)) {
      $insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Descripcion = '$archivo' WHERE tblp_configuracion.IdConfig = '$Id'");
      echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
    }
    echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
  }

  public function add_uploadIcono()
  {
    $db = new Conexion();
    $Id = $_POST["icono"];
    $carpeta = "assets/images/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtIcono"]['name']; //nombre del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $tipo = $nombreImg[1];
    $archivo = 'icono.' . $tipo;
    if (!move_uploaded_file($_FILES["txtIcono"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adPlataforma.php'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;
    if (file_exists($nombre_fichero)) {
      $insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Descripcion = '$archivo' WHERE tblp_configuracion.IdConfig = '$Id'");
      echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
    }
    echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
  }
  public function add_uploadMateria()
  {
    $db = new Conexion();
    $Id = $_POST["materia"];
    $carpeta = "assets/images/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtMateria"]['name']; //nombre del archivo
    $archivo = time() . '-' . $archivo;
    if (!move_uploaded_file($_FILES["txtMateria"]['tmp_name'], $carpeta . $archivo)) {
      $_SESSION['Alerta'] = "0";
      echo "<script type='text/javascript'>window.location='adPlataforma.php'</script>";
      exit();
    }

    $nombre_fichero = $carpeta . $archivo;
    if (file_exists($nombre_fichero)) {
      $insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Descripcion = '$archivo' WHERE tblp_configuracion.IdConfig = '$Id'");
      echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
    }
    echo "<script type='text/javascript'>window.location='adPlataforma.php';</script>";
  }

  public function get_usuariosGrup($IdEstatus, $IdCampus, $IdPermiso)
  {
    if ($IdEstatus) {
      if ($IdEstatus == 99) {
        $cond = "";
      } else {
        $cond = " AND tblc_usuario.IdEstatus = '$IdEstatus' ";
      }
      $get_usuariosGrup = [];
      $db = new Conexion();
      $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.Permisos = '$IdPermiso' AND tblc_usuario.IdCampus = '$IdCampus' $cond GROUP BY tblc_usuario.Permisos ");
      while ($x = $db->recorrer($sql)) {
        $get_usuariosGrup[] = $x;
      }
      return $get_usuariosGrup;
    }
  }

  public function get_chkDup($Usuario, $IdOferta, $IdCampus)
  {
    $db = new Conexion();

    $IdModIni = "";
    $IdModFin = "";

    $sql2 = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.IdCampus, tblp_modulo.NombreMod FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.Usuario = '$Usuario' AND tblp_calificacion.IdOferta = '$IdOferta' ORDER BY tblp_modulo.CodeModulo ASC");
    while ($y = $db->recorrer($sql2)) {
      $IdCal2 = $y["IdCalificacion"];
      $IdModIni = substr($y["CodeModulo"], 0, 6);
      if ($IdModIni == $IdModFin) {

        $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal2'");
      }
      $IdModFin = substr($y["CodeModulo"], 0, 6);
    }
  }


  public function upd_matAvance()
  {
    $db = new Conexion();
    $IdModulo = $_POST["IdModulo"];
    $IdGrado = $_POST["txtIdGrado"];
    $Code = $_POST["txtCode"];
    $insertar = $db->query("UPDATE tblp_modulo SET tblp_modulo.Grado = '$IdGrado',tblp_modulo.CodeModulo = '$Code' WHERE tblp_modulo.IdModulo = '$IdModulo'");

    if ($insertar) {
      return 1;
    } else {
      return 0;
    }
  }

  public function get_misDocsDispo($Usuario)
  {
    $db = new Conexion();
    $get_misDocsDispo = [];

    $sql = $db->query("SELECT tblp_docs_solicitados.FecLimite, tblp_docs_solicitados.IdDocumento, tblc_conceptos.NomConcepto, tblc_conceptosplanes.Code, tblc_conceptosplanes.NomPlan, tblc_ciclo.Ciclo FROM tblp_docs_solicitados Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_docs_solicitados.IdConcepto Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_docs_solicitados.IdConceptoPlan Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo WHERE tblp_docs_solicitados.IdUsua = '$Usuario' AND tblp_docs_solicitados.IdEstatus = '4' ");
    while ($x = $db->recorrer($sql)) {
      $get_misDocsDispo[] = $x;
    }
    return $get_misDocsDispo;
  }

  public function get_vermisDocsDispo($Usuario)
  {
    $db = new Conexion();
    $get_vermisDocsDispo = [];
    $sql = $db->query("SELECT tblp_docs_solicitados.IdDocumento, tblp_docs_solicitados.IdPago, tblp_docs_solicitados.IdEstatus AS estSolicitados, tblp_pagos.IdEstatus AS estPago FROM tblp_docs_solicitados Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_docs_solicitados.IdPago WHERE tblp_docs_solicitados.IdUsua = '$Usuario' AND tblp_docs_solicitados.IdEstatus = '1'");
    while ($x = $db->recorrer($sql)) {
      $IdEstPag = $x['estPago'];
      $IdDocs = $x['IdDocumento'];
      if ($IdEstPag == 4) {
        $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdEstatus = '4' WHERE tblp_docs_solicitados.IdDocumento = '$IdDocs'");
      }
    }
  }

  public function get_datos_const($IdDocs)
  {
    $db = new Conexion();
    $get_datos_const = [];

    $sql = $db->query("SELECT
  tblp_docs_solicitados.IdDocumento,
  tblp_docs_solicitados.Fecha,
  tblp_rvoe.Modalidad,
  tblp_rvoe.Escuela,
  tblp_rvoe.Clave,
  tblc_usuario.Nombre,
  tblc_usuario.Sexo,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno,
  tblc_usuario.IdOferta,
  tblc_usuario.Usuario,
  tblc_ciclo.Ciclo,
  tblc_usuario.SemCua,
  tblp_educativa.Nombre AS Educativa,
  tblc_conceptosplanes.IdConceptoPlanes,
  tblc_conceptosplanes.NomPlan,
  tblp_grupo.CveGrupo,
  tblp_grupo.TipoCiclo
  FROM
  tblp_docs_solicitados
  Left Join tblp_rvoe ON tblp_rvoe.IdEducativa = tblp_docs_solicitados.IdOferta AND tblp_rvoe.IdCampus = tblp_docs_solicitados.IdCampus
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua
  Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_docs_solicitados.IdOferta
  Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_docs_solicitados.IdConceptoPlan
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_docs_solicitados.IdGrupo
  WHERE tblp_docs_solicitados.IdDocumento =  '$IdDocs'");
    while ($x = $db->recorrer($sql)) {
      $get_datos_const[] = $x;
    }
    return $get_datos_const;
  }

  public function get_modulo_espe()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_modulo");
    while ($x = $db->recorrer($sql)) {
      $get_modulo_espe[] = $x;
    }
    return $get_modulo_espe;
  }

  public function get_modulo_id($IdMenu, $IdUsua)
  {
    $db = new Conexion();
    $get_modulo_id = [];
    $sql = $db->query("SELECT * FROM tblc_modulousuario WHERE tblc_modulousuario.IdModulo = '$IdMenu' AND tblc_modulousuario.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_modulo_id[] = $x;
    }
    return $get_modulo_id;
  }

  public function get_mod_lista($IdUsua, $Tipo)
  {
    $db = new Conexion();
    $get_mod_lista = [];
    $sql = $db->query("SELECT tblc_modulousuario.IdModUsua, tblc_modulo.IdModulo, tblc_modulo.Modulo, tblc_modulo.Nombre, tblc_modulo.Link, tblc_modulo.Tipo, tblc_modulo.Icono, tblc_modulo.Lista FROM tblc_modulousuario Left Join tblc_modulo ON tblc_modulo.IdModulo = tblc_modulousuario.IdModulo WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulo.Lista = '$Tipo'");
    while ($x = $db->recorrer($sql)) {
      $get_mod_lista[] = $x;
    }
    return $get_mod_lista;
  }

  public function get_cal_all_us($IdUsua){
		$db = new Conexion();
  $get_cal_all_us = [];
  
    $sql = $db->query("SELECT
    tblp_calificacion.IdCalificacion,
    tblp_calificacion.Promedio,
    tblp_modulo.NombreMod,
    tblp_modulo.Grado,
    tblp_modulo.Creditos,
    tblp_calificacion.E1,
    tblp_calificacion.E2,
    tblp_calificacion.Observacion,
    tblc_ciclo.Ciclo,
    tblp_calificacion.IdCiclo
    FROM
    tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua' AND
    tblp_calificacion.IdEstatus =  '8'
    ORDER BY
    tblc_ciclo.FInicio ASC,
    tblp_modulo.CodeModulo ASC
    
");
    while($x = $db->recorrer($sql)){
      $get_cal_all_us[] = $x;
    }
    return $get_cal_all_us;
  }

  public function get_mod_lista_id($IdUsua, $IdModulo)
  {
    $db = new Conexion();
    $get_mod_lista_id = [];
    $sql = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $get_mod_lista_id[] = $x;
    }
    return $get_mod_lista_id;
  }

  public function get_lstDineroDia($fecha1, $fecha2)
  {
    $db = new Conexion();
    $get_lstDineroDia = [];
    $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.IdPago,
tblp_foliospago.Estatus,
tblp_foliospago.FecCap,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblp_foliospago.Folio,
tblp_foliospago.IdUsua,
tblp_foliospago.IdEstatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_pagos.FecDesc,
tblc_conceptosplanes.NomPlan
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE
tblp_foliospago.IdEstatus = '4' AND
tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59'
");
    while ($x = $db->recorrer($sql)) {
      $get_lstDineroDia[] = $x;
    }
    return $get_lstDineroDia;
  }

  public function get_lst_conceptos()
  {
    $db = new Conexion();
    $get_lst_conceptos = [];
    $sql = $db->query("SELECT * FROM tblc_conceptosplanes");
    while ($x = $db->recorrer($sql)) {
      $get_lst_conceptos[] = $x;
    }
    return $get_lst_conceptos;
  }

  public function get_ciclo_esc_fin()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdEstatus = '9'");
    while ($x = $db->recorrer($sql)) {
      $get_ciclo_esc_fin[] = $x;
    }
    return $get_ciclo_esc_fin;
  }

  public function get_lst_esc($IdCiclo)
  {
    $db = new Conexion();
    $get_lst_esc = [];
    $sql = $db->query("SELECT
tblp_constancia_lista.IdConstancia,
tblp_constancia_lista.Usuario,
tblp_constancia_lista.Lugar,
tblp_constancia_lista.Promedio,
tblp_constancia_lista.Suma,
tblp_constancia_lista.Materias,
tblp_constancia_lista.IdOferta,
tblp_constancia_lista.Grado,
tblp_constancia_lista.IdEstatus,
tblp_constancia_lista.IdCampus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_grupo.CveGrupo,
tblp_educativa.Nombre AS Educativa,
tblc_campus.IdCampus,
tblc_campus.Campus,
tblc_estatus.Estatus
FROM
tblp_constancia_lista
Left Join tblc_usuario ON tblc_usuario.Usuario = tblp_constancia_lista.Usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_constancia_lista.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_constancia_lista.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_constancia_lista.IdEstatus
WHERE tblp_constancia_lista.IdCiclo = '$IdCiclo'
ORDER BY
tblc_campus.IdCampus ASC,
tblp_educativa.IdGrado ASC,
tblp_grupo.CveGrupo ASC,
tblp_constancia_lista.Lugar ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_lst_esc[] = $x;
    }
    return $get_lst_esc;
  }

  public function get_xcic_grpx($IdGrupo)
  {
    $db = new Conexion();
    $sql1 = $db->query("SELECT tblp_grupo.TipoCiclo FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $tipo = $datos2["TipoCiclo"];
    if ($tipo == 'C') {
      $_tip = "Cuatrimestre";
    } elseif ($tipo == 'S') {
      $_tip = "Semestre";
    } else {
      $_tip = "Anual";
    }

    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$_tip' ORDER BY tblc_ciclo.FInicio DESC");
    while ($x = $db->recorrer($sql)) {
      $get_xcic_grpx[] = $x;
    }
    return $get_xcic_grpx;
  }

  public function get_mat_lista($IdCampus, $IdCiclo, $IdGrupo)
  {
    $db = new Conexion();
    $get_mat_lista = [];
    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_calificacion Left Join tblc_usuario ON tblc_usuario.Usuario = tblp_calificacion.Usuario Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdGrupo =  '$IdGrupo' GROUP BY tblp_calificacion.IdModulo ");
    while ($x = $db->recorrer($sql)) {
      $get_mat_lista[] = $x;
    }
    return $get_mat_lista;
  }

  public function get_lst_cal_us($IdCampus, $IdCiclo, $IdGrupo, $IdModulo)
  {
    $db = new Conexion();
    $get_mat_lista = [];
    $sql = $db->query("SELECT
tblp_calificacion.IdCalificacion,
tblp_calificacion.Usuario,
tblp_calificacion.Promedio,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_calificacion
Left Join tblc_usuario ON tblc_usuario.Usuario = tblp_calificacion.Usuario
WHERE
tblp_calificacion.IdCiclo =  '$IdCiclo' AND
tblc_usuario.IdCampus =  '$IdCampus' AND
tblc_usuario.IdGrupo =  '$IdGrupo' AND
tblp_calificacion.IdModulo =  '$IdModulo'
ORDER BY tblc_usuario.APaterno ASC
");
    while ($x = $db->recorrer($sql)) {
      $get_mat_lista[] = $x;
    }
    return $get_mat_lista;
  }

  public function get_mis_reco_id($Usuario)
  {
    $db = new Conexion();
    $get_mis_reco_id = [];
    $sql = $db->query("SELECT tblp_constancia_lista.IdConstancia, tblp_constancia_lista.IdCiclo, tblp_constancia_lista.Lugar, tblp_constancia_lista.Grado, tblp_constancia_lista.Fecha, tblc_ciclo.Ciclo FROM tblp_constancia_lista Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_constancia_lista.IdCiclo WHERE tblp_constancia_lista.Usuario =  '$Usuario' AND tblp_constancia_lista.IdEstatus =  '4' ORDER BY tblp_constancia_lista.Fecha ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_mis_reco_id[] = $x;
    }
    return $get_mis_reco_id;
  }

  public function get_lst_biblioteca($IdTema)
  {
    $db = new Conexion();
    $get_lst_biblioteca = [];

    $sql = $db->query("SELECT tblp_biblioteca.IdBiblioteca, tblp_biblioteca.IdAsignacion, tblp_biblioteca.Nombre, tblp_biblioteca.Tipo, tblp_biblioteca.Descripcion, tblp_biblioteca.Link, tblp_biblioteca.Code, tblp_biblioteca.Anio, tblp_biblioteca.Mes, tblp_biblioteca.IdTema, tblp_temas.Descripcion AS Tema FROM tblp_biblioteca Left Join tblp_temas ON tblp_temas.IdTema = tblp_biblioteca.IdTema WHERE tblp_biblioteca.IdTema = '$IdTema'");
    while ($x = $db->recorrer($sql)) {
      $get_lst_biblioteca[] = $x;
    }
    return $get_lst_biblioteca;
  }
}

function convert($size)
{
  $unit = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB');
  return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

class Password
{
  const SALT = 'MwC%6gA6w1W#8s';
  public static function hash($password)
  {
    return hash('sha512', self::SALT . $password);
  }
  public static function verify($password, $hash)
  {
    return ($hash == self::hash($password));
  }
}

function conversorSegundosHoras($tiempo_en_segundos)
{
  $horas = floor($tiempo_en_segundos / 3600);
  $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
  $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

  if ($horas < 10) {
    $horas = '0' . $horas;
  } else {
    $horas = $horas;
  }
  if ($minutos < 10) {
    $minutos = '0' . $minutos;
  } else {
    $minutos = $minutos;
  }
  if ($segundos < 10) {
    $segundos = '0' . $segundos;
  } else {
    $segundos = $segundos;
  }

  return $horas . ':' . $minutos . ":" . $segundos;
}


function conocerDiaXXX($fecha)
{
  $dias = array('7', '1', '2', '3', '4', '5', '6');
  $dia = $dias[date('w', strtotime($fecha))];
  return $dia;
}

function dias_restantes($fecha_final)
{
  $db = new Conexion();
  $fecha_actual = date("Y-m-d");
  $s = strtotime($fecha_final) - strtotime($fecha_actual);
  $d = intval($s / 86400);
  $diferencia = $d;
  return $diferencia;
}

function calculaedad($fecha)
{
  $fecha_nacimiento = new DateTime($fecha);
  $hoy = new DateTime();
  $edad = $hoy->diff($fecha_nacimiento);
  $_anio = $edad->y;

  return $_anio . ' años';
}

function limpiar_cadena($cadena)
{
  $cadena = trim($cadena);
  $cadena = stripslashes($cadena);
  $cadena = str_ireplace("<script>", "", $cadena);
  $cadena = str_ireplace("</script>", "", $cadena);
  $cadena = str_ireplace("<script src", "", $cadena);
  $cadena = str_ireplace("<script type=", "", $cadena);
  $cadena = str_ireplace("SELECT * FROM", "", $cadena);
  $cadena = str_ireplace("DELETE FROM", "", $cadena);
  $cadena = str_ireplace("INSERT INTO", "", $cadena);
  $cadena = str_ireplace("DROP TABLE", "", $cadena);
  $cadena = str_ireplace("DROP DATABASE", "", $cadena);
  $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
  $cadena = str_ireplace("SHOW TABLES", "", $cadena);
  $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
  $cadena = str_ireplace("<?php", "", $cadena);
  $cadena = str_ireplace("?>", "", $cadena);
  $cadena = str_ireplace("--", "", $cadena);
  $cadena = str_ireplace("^", "", $cadena);
  $cadena = str_ireplace("==", "", $cadena);
  $cadena = str_ireplace("'", "´", $cadena);
  $cadena = str_ireplace("::", "", $cadena);
  $cadena = str_ireplace("  ", "", $cadena);
  $cadena = stripslashes($cadena);
  $cadena = trim($cadena);
  return $cadena;
}

function limpiar_cadena_acento($cadena){
  $cadena=trim($cadena);
  $cadena=stripslashes($cadena);
  $cadena=str_ireplace("á","a",$cadena);
  $cadena=str_ireplace("é","e",$cadena);
  $cadena=str_ireplace("í","i",$cadena);
  $cadena=str_ireplace("ó","o",$cadena);
  $cadena=str_ireplace("ú","u",$cadena);
  $cadena=str_ireplace("Á","A",$cadena);
  $cadena=str_ireplace("É","E",$cadena);
  $cadena=str_ireplace("Í","I",$cadena);
  $cadena=str_ireplace("Ó","O",$cadena);
  $cadena=str_ireplace("Ú","U",$cadena);
  $cadena=str_ireplace("  "," ",$cadena);
  
  $cadena=stripslashes($cadena);
  $cadena=trim($cadena);
  return $cadena;
}

 #17506 684.84 KB complete