<?php

date_default_timezone_set('America/Mexico_City');   //====================================================
                                                    //= Ultima actualización: 21/06/2019 11:32 a.m.      =
require('class.System.php');                        //= SF: MWComenius                                   =
ob_start();

class Consultas {
  public function get_ultimo_gastos() {
    $db = new Conexion();
    $get_ultimo_gastos = [];

    $sql = $db->query("SELECT
tblp_gastos.IdGasto,
tblp_gastos.IdConcepto,
tblp_gastos.IdGasto2,
tblp_gastos.Fecha,
tblp_gastos.FecCap,
tblp_gastos.Factura,
tblp_gastos.Importe,
tblp_gastos.Beneficiario,
tblp_gastos.Cheque,
tblp_gastos.Partida,
tblp_gastos.Valor,
tblp_gastos.IdEstatus,
tblp_gastos.Descripcion,
tblc_concepto_gasto.Nombre_gasto,
tblc_concepto_gasto2.Nombre_gasto2
FROM
tblp_gastos
Left Join tblc_concepto_gasto ON tblc_concepto_gasto.IdConcepto = tblp_gastos.IdConcepto
Left Join tblc_concepto_gasto2 ON tblc_concepto_gasto2.IdGasto2 = tblp_gastos.IdGasto2
ORDER BY tblp_gastos.FecCap DESC LIMIT 400
 ");
    while($x = $db->recorrer($sql)){
      $get_ultimo_gastos[] = $x;
    }
    return $get_ultimo_gastos;
	}

  public function get_sum_area($Inicio,$Final) {
    $db = new Conexion();
    $get_sum_area = [];
    $sql = $db->query("SELECT Sum(tblp_gastos.Importe) AS Suma, tblc_permiso._Permiso FROM tblp_gastos Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblp_gastos.IdPermiso WHERE tblp_gastos.Fecha BETWEEN '$Inicio' AND '$Final' GROUP BY tblp_gastos.IdPermiso ORDER BY Suma ASC ");
    while($x = $db->recorrer($sql)){
      $get_sum_area[] = $x;
    }
    return $get_sum_area;
	}

  public function get_trayectoria_id($IdUsua) {
    $db = new Conexion();
    $get_trayectoria_id = [];
    $sql = $db->query("SELECT
    tblp_trayectoria_alumno.IdTrayectoria,
    tblp_trayectoria_alumno.Fecha,
    tblp_trayectoria_alumno.Archivo,
    tblp_trayectoria_alumno.Nota,
    tblp_trayectoria_alumno.FecCap,
    tblp_trayectoria_alumno.IdEstatus,
    tblc_trayectoria.Trayectoria,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_trayectoria_alumno.IdUsua,
    tblp_trayectoria_alumno.Anio,
    tblp_trayectoria_alumno.Mes
    FROM
    tblp_trayectoria_alumno
    Left Join tblc_trayectoria ON tblc_trayectoria.IdTipoTrayectoria = tblp_trayectoria_alumno.IdTipo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_trayectoria_alumno.IdUsua
    WHERE
    tblp_trayectoria_alumno.IdUsua =  '$IdUsua'
    ORDER BY
    tblp_trayectoria_alumno.IdTipo DESC
    ");
    while($x = $db->recorrer($sql)){
      $get_trayectoria_id[] = $x;
    }
    return $get_trayectoria_id;
  }

public function get_avisos_capturados() {
    $db = new Conexion();
    $get_avisos_capturados = [];
    $sql = $db->query("SELECT
    tbla_aviso.IdAviso,
    tbla_aviso.Mensaje,
    tbla_aviso.FecCap,
    tbla_aviso.Tipo,
    tbla_aviso.IdCiclo,
    tblc_ciclo.Ciclo
    FROM
    tbla_aviso
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tbla_aviso.IdCiclo
    ORDER BY
    tblc_ciclo.FInicio ASC,
    tbla_aviso.FecCap ASC
    ");
    while($x = $db->recorrer($sql)){
      $get_avisos_capturados[] = $x;
    }
    return $get_avisos_capturados;
  }
  
  public function get_lst_pag($NoFolio) {
    $db = new Conexion();
    $get_lst_pag = [];
    $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.Monto,
tblc_conceptosplanes.Unidad,
tblc_conceptosplanes.ClaveUnidad,
tblc_conceptosplanes.ClaveProdServ,
tblc_conceptosplanes.NomPlan,
tblp_modulo.NombreMod,
tblp_pagos.FecDesc,
tblp_educativa.IdGrado
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_pagos.IdModulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta WHERE tblp_foliospago.NoFolio = '$NoFolio'");
    while($x = $db->recorrer($sql)){
      $get_lst_pag[] = $x;
    }
    return $get_lst_pag;
	}

  public function get_sum_concep($Anio) {
    $db = new Conexion();
    $get_sum_concep = [];
    $sql = $db->query("SELECT Sum(tblp_gastos.Importe) AS Suma, tblc_concepto_gasto.Nombre_gasto FROM tblp_gastos Left Join tblc_concepto_gasto ON tblc_concepto_gasto.IdConcepto = tblp_gastos.IdConcepto WHERE tblp_gastos.Anio = '$Anio' GROUP BY tblp_gastos.IdConcepto ORDER BY Suma ASC");
    while($x = $db->recorrer($sql)){
      $get_sum_concep[] = $x;
    }
    return $get_sum_concep;
  }
  
  public function get_pago_generado_id($IdUsua) {
    $db = new Conexion();
    $get_pago_generado_id = [];
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.IdEstatus, tblp_pagos.IdConcepto, tblp_pagos.Monto FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdConcepto =  '5'");
    while($x = $db->recorrer($sql)){
      $get_pago_generado_id[] = $x;
    }
    return $get_pago_generado_id;
  }

  public function get_sum_oferta($Anio) {
    $db = new Conexion();
    $get_sum_oferta = [];
    $sql = $db->query("SELECT
tblp_gastos_detalle.IdDetalle_g,
tblp_gastos_detalle.IdOferta,
Sum(tblp_gastos_detalle.Monto) AS Total,
tblp_educativa.Nombre
FROM
tblp_gastos
Left Join tblp_gastos_detalle ON tblp_gastos_detalle.IdGasto = tblp_gastos.IdGasto
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_gastos_detalle.IdOferta
WHERE
tblp_gastos.Anio = '$Anio' AND
tblp_gastos_detalle.IdOferta IS NOT NULL
GROUP BY
tblp_gastos_detalle.IdOferta
");
    while($x = $db->recorrer($sql)){
      $get_sum_oferta[] = $x;
    }
    return $get_sum_oferta;
	}

  public function get_sum_partida($Anio) {
    $db = new Conexion();
    $get_sum_partida = [];

    $sql = $db->query("SELECT Sum(tblp_gastos.Importe) AS Total, tblp_gastos.Partida, tblc_partida.Descripcion FROM tblp_gastos Left Join tblc_partida ON tblc_partida.Partida = tblp_gastos.Partida WHERE tblp_gastos.Anio = '$Anio' GROUP BY tblp_gastos.Partida ");
    while($x = $db->recorrer($sql)){
      $get_sum_partida[] = $x;
    }
    return $get_sum_partida;
	}

  public function get_lst_ofertas() {
    $db = new Conexion();
    $get_lst_ofertas = [];
    $sql = $db->query("SELECT * FROM tblp_educativa ORDER BY tblp_educativa.IdEducativa ASC");
    while($x = $db->recorrer($sql)){
      $get_lst_ofertas[] = $x;
    }
    return $get_lst_ofertas;
	}

  public function get_gastos_lst($Anio) {
    $db = new Conexion();
    $get_gastos_lst = [];

    $sql = $db->query("SELECT
tblp_gastos.IdGasto,
tblp_gastos.Cheque,
tblp_gastos.Partida,
tblp_gastos.Beneficiario,
tblp_gastos.Descripcion,
tblp_gastos.Factura,
tblp_gastos.Importe,
tblp_gastos.FecCap,
tblp_gastos.AnioMes,
tblp_gastos.Fecha,
tblp_gastos.Valor,
tblp_gastos.IdEstatus,
tblc_concepto_gasto2.Nombre_gasto2
FROM
tblp_gastos
Left Join tblc_concepto_gasto2 ON tblc_concepto_gasto2.IdGasto2 = tblp_gastos.IdGasto2
WHERE tblp_gastos.Anio = '$Anio' ORDER BY tblp_gastos.Fecha ASC ");
    while($x = $db->recorrer($sql)){
      $get_gastos_lst[] = $x;
    }
    return $get_gastos_lst;
	}

  public function get_dos_sol_all() {
    $db = new Conexion();
    $get_dos_sol_all = [];

    $sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_docs_solicitados.IdDocumento,
tblc_ciclo.Ciclo,
tblp_docs_solicitados.FecCap,
tblp_docs_solicitados.Anio,
tblp_docs_solicitados.Mes,
tblp_docs_solicitados.Fecha,
tblp_docs_solicitados.qrCode,
tblp_docs_solicitados.FecLimite
FROM
tblp_docs_solicitados
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo
 ORDER BY tblp_docs_solicitados.FecCap ASC ");
    while($x = $db->recorrer($sql)){
      $get_dos_sol_all[] = $x;
    }
    return $get_dos_sol_all;
	}

  public function get_dos_sol_all_id($qrCode) {
    $db = new Conexion();
    $get_dos_sol_all_id = [];

    $sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_docs_solicitados.IdDocumento,
tblc_ciclo.Ciclo,
tblp_docs_solicitados.FecCap,
tblp_docs_solicitados.Anio,
tblp_docs_solicitados.Mes,
tblp_docs_solicitados.Fecha,
tblp_docs_solicitados.FecAprobado,
tblp_docs_solicitados.qrCode,
tblp_docs_solicitados.FecLimite,
tblp_educativa.Nombre AS Educativa,
tblc_modalidad.Modalidad,
tblc_ciclogrupo.Grado
FROM
tblp_docs_solicitados
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_docs_solicitados.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_docs_solicitados.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_docs_solicitados.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_docs_solicitados.IdGrupo
 WHERE tblp_docs_solicitados.qrCode = '$qrCode' ");
    while($x = $db->recorrer($sql)){
      $get_dos_sol_all_id[] = $x;
    }
    return $get_dos_sol_all_id;
	}

  public function get_sum_gas_nivel($IdGasto,$Grado) {
    $db = new Conexion();
    $get_sum_gas_nivel = [];

    $sql = $db->query("SELECT Sum(tblp_gastos_detalle.Monto) AS Total FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto =  '$IdGasto' AND tblp_gastos_detalle.IdGrado =  '$Grado' ");
    while($x = $db->recorrer($sql)){
      $get_sum_gas_nivel[] = $x;
    }
    return $get_sum_gas_nivel;
	}

  public function get_sum_alumnos() {
    $db = new Conexion();
    $get_sum_alumnos = [];
    $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Grado, tblc_grado.Descripcion FROM tblc_usuario Left Join tblc_grado ON tblc_grado.IdGrado = tblc_usuario.Grado WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdEstatus =  '8' GROUP BY tblc_usuario.Grado ORDER BY tblc_usuario.Grado ASC ");
    while($x = $db->recorrer($sql)){
      $get_sum_alumnos[] = $x;
    }
    return $get_sum_alumnos;
	}


  public function get_alumnos_por_rvoe($IdCampus, $IdCiclo) {
    $db = new Conexion();
    $get_alumnos_por_rvoe = [];    
    
    $sql = $db->query("SELECT tblc_alumnos.IdActivo, tblc_usuario.IdEstatus, tblc_rvoe.Educativa, tblc_rvoe.Rvoe, tblc_campus.Campus, tblc_rvoe.IdRvoe, Count(tblc_usuario._idRvoe) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' GROUP BY tblc_usuario._idRvoe ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_por_rvoe[] = $x;
    }
    return $get_alumnos_por_rvoe;
	}


  public function get_alumnos_titulacion($IdUsua) {
    $db = new Conexion();
    $get_alumnos_titulacion = [];    
    
    $sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdEstatus,
tblp_pagos.Fecha,
Sum(tblp_foliospago.Monto) AS Total,
tblp_pagos.Monto,
tblp_pagos.Descuento,
tblp_pagos.Descuento2
FROM
tblp_pagos
Left Join tblp_foliospago ON tblp_foliospago.IdPago = tblp_pagos.IdPago
WHERE
tblp_pagos.IdUsua =  '$IdUsua' AND
tblp_pagos.IdConcepto =  '5'
GROUP BY
tblp_pagos.IdPago
 ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_titulacion[] = $x;
    }
    return $get_alumnos_titulacion;
	}


  public function get_alumnos_all_ins($IdCampus) {
    $db = new Conexion();
    $get_alumnos_all_ins = [];    
    
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_estatus.Estatus,
tblp_educativa.Nombre AS Educativa
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.Permisos =  '3' AND
tblp_educativa.IdGrado <=  '3' AND
tblc_usuario.IdCampus =  '$IdCampus' AND ((tblc_usuario.IdEstatus =  '61') || (tblc_usuario.IdEstatus =  '62') || (tblc_usuario.IdEstatus =  '55'))
ORDER BY
tblc_usuario.IdEstatus ASC,
tblp_educativa.IdGrado ASC
 ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_all_ins[] = $x;
    }
    return $get_alumnos_all_ins;
	}

  public function get_alumnos_por_campus_id($IdCampus) {
    $db = new Conexion();
    $get_alumnos_por_campus_id = [];    
    
    $sql = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total,
tblc_usuario.IdOferta,
tblp_educativa.Nombre
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdCampus =  '$IdCampus' AND
tblp_educativa.IdGrado <= '3' AND ((tblc_usuario.IdEstatus = 61) || (tblc_usuario.IdEstatus = 62) || (tblc_usuario.IdEstatus = 55))
GROUP BY
tblc_usuario.IdOferta
ORDER BY
tblp_educativa.IdGrado ASC
");
    while($x = $db->recorrer($sql)){
      $get_alumnos_por_campus_id[] = $x;
    }
    return $get_alumnos_por_campus_id;
	}

    public function get_alumnos_mejores_promedios_periodo($Periodo) {
    $db = new Conexion();
    $get_alumnos_mejores_promedios_periodo = [];    
   
    $sql = $db->query("SELECT
	tblc_alumnos.IdUsua, 
	Avg(tblp_calificacion.Promedio) AS Promedio, 
	tblc_usuario.Usuario, 
	tblc_usuario.Nombre, 
	tblc_usuario.APaterno, 
	tblc_usuario.AMaterno, 
	tblc_usuario.porcentaje, 
	tblc_alumnos.Grado, 
	tblc_usuario.IdCampus, 
	tblc_campus.Campus, 
	tblp_educativa.Nombre AS Educativa, 
	tblc_usuario.IdOferta
FROM
	tblc_alumnos
	LEFT JOIN
	tblc_usuario
	ON 
		tblc_usuario.IdUsua = tblc_alumnos.IdUsua
	LEFT JOIN
	tblp_calificacion
	ON 
		tblp_calificacion.IdUsua = tblc_alumnos.IdUsua
	LEFT JOIN
	tblc_campus
	ON 
		tblc_usuario.IdCampus = tblc_campus.IdCampus
	LEFT JOIN
	tblp_educativa
	ON 
		tblc_usuario.IdOferta = tblp_educativa.IdEducativa
WHERE
tblp_educativa.IdGrado <= '3' AND
	tblc_alumnos.IdCiclo = '$Periodo' AND
	tblp_calificacion.IdEstatus = '10' AND
	(
		(
			(
		((tblc_usuario.IdEstatus = '61') || (tblc_usuario.IdEstatus = '62') || (tblc_usuario.IdEstatus = '55'))
	)
		)
	)
GROUP BY
	tblc_alumnos.IdUsua
ORDER BY
tblc_usuario.IdCampus ASC, tblp_educativa.IdGrado ASC, tblc_usuario.IdOferta ASC,
	Promedio DESC
");
    while($x = $db->recorrer($sql)){
      $get_alumnos_mejores_promedios_periodo[] = $x;
    }
    return $get_alumnos_mejores_promedios_periodo;
	}


  public function get_alumnos_mejores_promedios($IdOferta,$Periodo) {
    $db = new Conexion();
    $get_alumnos_mejores_promedios = [];    
    
    $sql = $db->query("SELECT
tblc_alumnos.IdUsua,
Avg(tblp_calificacion.Promedio) AS Promedio,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.porcentaje,
tblc_alumnos.Grado
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblp_calificacion ON tblp_calificacion.IdUsua = tblc_alumnos.IdUsua
WHERE
tblc_alumnos.IdCiclo =  '$Periodo' AND
tblc_usuario.IdOferta =  '$IdOferta' AND 
tblp_calificacion.IdEstatus =  '10'
GROUP BY
tblc_alumnos.IdUsua
ORDER BY Promedio DESC
LIMIT 20
");
    while($x = $db->recorrer($sql)){
      $get_alumnos_mejores_promedios[] = $x;
    }
    return $get_alumnos_mejores_promedios;
	}
	
	public function get_lista_alumnos_graduados($IdCampus, $IdGrado) {
        $db = new Conexion();
        $get_lista_alumnos_graduados = [];    
        
        $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_estatus.Estatus,
tblp_educativa.Nombre AS Educativa
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdCampus =  '$IdCampus' AND
tblp_educativa.IdGrado =  '$IdGrado' AND ((tblc_usuario.IdEstatus =  '61') || (tblc_usuario.IdEstatus =  '62') || (tblc_usuario.IdEstatus =  '55'))
ORDER BY
tblc_usuario.IdOferta ASC
");
        while($x = $db->recorrer($sql)){
          $get_lista_alumnos_graduados[] = $x;
        }
        return $get_lista_alumnos_graduados;
	}

  public function get_alumnos_por_rvoe_reprob($IdCampus, $IdCiclo) {
    $db = new Conexion();
    $get_alumnos_por_rvoe_reprob = [];    
    

    $sql = $db->query("SELECT
    tblc_alumnos.IdActivo,
    tblc_usuario.IdEstatus,
    tblc_rvoe.Educativa,
    tblc_rvoe.Rvoe,
    tblc_campus.Campus,
    tblc_rvoe.IdRvoe,
    Count(tblc_usuario._idRvoe) AS Total,
    tblp_calificacion.Promedio
    FROM
    tblc_alumnos
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
    Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
    Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus
    Left Join tblp_calificacion ON tblp_calificacion.IdUsua = tblc_alumnos.IdUsua AND tblp_calificacion.IdCiclo = tblc_alumnos.IdCiclo
    WHERE
    tblc_alumnos.IdCiclo =  '$IdCiclo' AND
    tblc_usuario.IdCampus =  '$IdCampus' AND
    tblp_calificacion.IdEstatus =  '10' AND
    tblp_calificacion.Promedio <=  '5'
    GROUP BY
    tblc_usuario._idRvoe
    ORDER BY Total DESC
     ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_por_rvoe_reprob[] = $x;
    }
    return $get_alumnos_por_rvoe_reprob;
	}

  public function get_alumnos_por_rvoe_estatus($IdCampus, $IdCiclo,$IdRvoe,$IdEstatus) {
    $db = new Conexion();
    $get_alumnos_por_rvoe_estatus = [];
    $sql = $db->query("SELECT tblc_alumnos.IdActivo, Count(tblc_usuario._idRvoe) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario._idRvoe =  '$IdRvoe' AND tblc_usuario.IdEstatus =  '$IdEstatus' GROUP BY tblc_usuario._idRvoe  ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_por_rvoe_estatus[] = $x;
    }
    return $get_alumnos_por_rvoe_estatus;
	}

  public function get_alumnos_por_estatus_id($IdCampus, $IdOferta, $IdEstatus) {
    $db = new Conexion();
    $get_alumnos_por_estatus_id = [];
    $sql = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total
FROM
tblc_usuario
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdEstatus =  '$IdEstatus' AND
tblc_usuario.IdCampus =  '$IdCampus' AND
tblc_usuario.IdOferta =  '$IdOferta'
GROUP BY
tblc_usuario.IdUsua
 ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_por_estatus_id[] = $x;
    }
    return $get_alumnos_por_estatus_id;
	}

  public function get_alumnos_inscritos_rvoe_total($IdCampus, $IdCiclo,$IdRvoe) {
    $db = new Conexion();
    $get_alumnos_inscritos_rvoe_total = [];
    $sql = $db->query("SELECT tblc_alumnos.IdActivo, Count(tblc_usuario._idRvoe) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario._idRvoe =  '$IdRvoe' GROUP BY tblc_usuario._idRvoe  ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_inscritos_rvoe_total[] = $x;
    }
    return $get_alumnos_inscritos_rvoe_total;
	}

  public function get_alumnos_reprobados_rvoe_total($IdCampus, $IdCiclo,$IdRvoe) {
    $db = new Conexion();
    $get_alumnos_inscritos_rvoe_total = [];
    
    $sql = $db->query("SELECT
    Count(tblc_alumnos.IdUsua) AS Total,
    tblc_usuario.Usuario,
    tblc_usuario._idRvoe
    FROM
    tblc_alumnos
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
    Left Join tblp_calificacion ON tblp_calificacion.IdUsua = tblc_alumnos.IdUsua AND tblp_calificacion.IdCiclo = tblc_alumnos.IdCiclo
    WHERE tblc_alumnos.IdCiclo = '$IdCiclo' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario._idRvoe = '$IdRvoe' AND tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.Promedio <= '5'
    GROUP BY
    tblp_calificacion.IdUsua
    ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_inscritos_rvoe_total[] = $x;
    }
    return $get_alumnos_inscritos_rvoe_total;
	}

  public function get_sum_alumnos_nivel() {
    $db = new Conexion();
    $get_sum_alumnos_nivel = [];
    $sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Grado, tblp_educativa.Nombre FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdEstatus = '8' GROUP BY tblc_usuario.IdOferta ORDER BY tblc_usuario.Grado ASC ");
    while($x = $db->recorrer($sql)){
      $get_sum_alumnos_nivel[] = $x;
    }
    return $get_sum_alumnos_nivel;
	}

  public function get_alumnos_materia($IdAsignacion) {
    $db = new Conexion();
    $get_alumnos_materia = [];
    $sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_estatus.Estatus FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC ");
    while($x = $db->recorrer($sql)){
      $get_alumnos_materia[] = $x;
    }
    return $get_alumnos_materia;
	}

  public function get_sum_alumnos_sexo($sexo) {
    $db = new Conexion();
    $get_sum_alumnos_sexo = [];

    $sql = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total,
tblc_usuario.Grado
FROM
tblc_usuario
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdEstatus =  '8' AND
tblc_usuario.Sexo =  '$sexo'
GROUP BY
tblc_usuario.Grado
ORDER BY tblc_usuario.Grado ASC
");
    while($x = $db->recorrer($sql)){
      $get_sum_alumnos_sexo[] = $x;
    }
    return $get_sum_alumnos_sexo;
	}

  public function get_facturas_solicitadas() {
    $db = new Conexion();
    $get_facturas = [];
    $anio_mes = date("Y-m");
    $fec_ini = $anio_mes.'-01';
    $fec_fin = $anio_mes.'-31';
  
    
    
    $sql = $db->query("SELECT
    tblp_foliospago.IdFolio,
    tblp_foliospago.NoFolio,
    tblp_foliospago.Monto,
    tblp_foliospago.FecPago,
    tblc_conceptosplanes.NomPlan,
    tblp_pagos.Fecha,
    tblp_foliospago.Estatus,
    tblp_pagos.Monto AS TotalPagar,
    tblc_usuario.IdUsua,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_foliospago._importe,
    tblp_foliospago._descuento,
    tblp_foliospago._total,
    tblp_foliospago._fac,
    tblc_datosfactura.RFC
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
Left Join tblc_datosfactura ON tblc_datosfactura.IdUsua = tblp_pagos.IdUsua
    WHERE
    tblp_foliospago.Factura = '1' AND
    tblp_foliospago.FecPago BETWEEN '$fec_ini' AND '$fec_fin' ORDER BY tblp_foliospago.FecPago  ");
    while($x = $db->recorrer($sql)){
      $get_facturas[] = $x;
    }
    return $get_facturas;

  }

  public function get_facturas_solicitadas_pendi() {
    $db = new Conexion();
    $get_facturas = [];
    $anio_mes = date("Y-m");
    $fec_ini = $anio_mes.'-01';
    $fec_fin = $anio_mes.'-31';
   
    $sql = $db->query("SELECT
    tblp_foliospago.IdFolio,
    tblp_foliospago.NoFolio,
    tblp_foliospago.Monto,
    tblp_foliospago.FecPago,
    tblc_conceptosplanes.NomPlan,
    tblp_pagos.Fecha,
    tblp_foliospago.Estatus,
    tblp_pagos.Monto AS TotalPagar,
    tblc_usuario.IdUsua,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_foliospago._importe,
    tblp_foliospago._descuento,
    tblp_foliospago._total,
    tblp_foliospago._fac,
    tblc_datosfactura.RFC
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
Left Join tblc_datosfactura ON tblc_datosfactura.IdUsua = tblp_pagos.IdUsua
    WHERE
    tblp_foliospago.Factura = '1' AND
    tblp_pagos.Facturar = 'SI' AND
    tblp_foliospago.FecPago BETWEEN '$fec_ini' AND '$fec_fin' ORDER BY tblp_foliospago.FecPago ");
    while($x = $db->recorrer($sql)){
      $get_facturas[] = $x;
    }
    return $get_facturas;

  }


  public function get_facturas_mes($fec_ini, $fec_fin) {
    $db = new Conexion();
    $get_facturas_mes = [];
    $anio_mes = date("Y-m");


    $sql = $db->query("SELECT
    tblp_foliospago.IdFolio,
    tblp_foliospago.NoFolio,
    tblp_foliospago.Monto,
    tblp_foliospago.IdForma,
    tblp_foliospago.FecPago,
    tblc_conceptosplanes.NomPlan,
    tblp_pagos.Fecha,
    tblp_foliospago.Estatus,
    tblp_pagos.Monto AS TotalPagar,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_foliospago._importe,
    tblp_foliospago._descuento,
    tblp_foliospago._total,
    tblp_foliospago._fac,
    tblc_formapago._Descripcion
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
    WHERE
    tblp_foliospago.Factura = '1' AND
    tblp_foliospago.FecPago BETWEEN '$fec_ini' AND '$fec_fin' ORDER BY tblp_foliospago.IdForma ASC, tblp_foliospago.FecPago ASC");
    while($x = $db->recorrer($sql)){
      $get_facturas_mes[] = $x;
    }
    return $get_facturas_mes;

  }

  public function get_calificacion_user_id($IdUsua) {
    $db = new Conexion();
    $get_calificacion_user_id = [];
    $sql = $db->query("SELECT
    tblh_promedio.IdProm,
    tblh_promedio.IdUsua,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_modulo.CodeModulo,
    tblp_modulo.Grado,
    tblp_modulo.NombreMod,
    tblc_ciclo.Ciclo,
    tblh_promedio.IdPeriodo,
    tblh_promedio.Promedio
    FROM
    tblh_promedio
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_promedio.IdUsua
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblh_promedio.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_promedio.IdPeriodo
    WHERE tblh_promedio.IdUsua = '$IdUsua' ORDER BY tblc_ciclo.FInicio ASC, tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
      $get_calificacion_user_id[] = $x;
    }
    return $get_calificacion_user_id;
	}

  public function get_facturas_generadas($Ini, $Fin) {
    $db = new Conexion();
    $get_facturas_generadas = [];
    $anio_mes = date("Y-m");

    $sql = $db->query("SELECT
    tblg_datos_factura.IdGenerar,
    tblg_datos_factura.FolioPago,
    tblg_datos_factura.Folio,
    tblg_datos_factura.Fecha,
    tblg_datos_factura.IdEstatus,
    tblg_datos_factura.SubTotal,
    tblg_datos_factura.Descuento,
    tblg_datos_factura.Total,
    tblg_datos_factura.R_Nombre,
    tblg_datos_factura._codigoFactura,
    tblg_datos_factura._folio,
    tblg_datos_factura.Serie,
    tblg_datos_factura.Mes,
    tblg_datos_factura.Anio,
    tblg_datos_factura._tipo,
    tblg_factura.IdUsua
    FROM
    tblg_datos_factura
    Left Join tblg_factura ON tblg_factura.IdFactura = tblg_datos_factura.IdFactura
    WHERE
tblg_factura.Fecha BETWEEN '$Ini' AND '$Fin' ");
    while($x = $db->recorrer($sql)){
      $get_facturas_generadas[] = $x;
    }
    return $get_facturas_generadas;

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

  public function get_contratos_docente($Ini, $Fin, $IdCiclo) {
    $db = new Conexion();
    $get_contratos_docente = [];

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.Grupo,
tblp_asignacion.IdUsua,
tblp_asignacion.contrato,
tblp_asignacion.aceptado,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblp_asignacion.IdCiclo,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblc_dias_clases.Dia,
tblc_dias_clases.Dias_clase,
tblc_dias_clases._Dias,
tblc_dias_clases.Tipo,
tblc_dias_clases.Modalidad,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.FecIni BETWEEN '$Ini' AND '$Fin'
 ");
    while($x = $db->recorrer($sql)){
      $get_contratos_docente[] = $x;
    }
    return $get_contratos_docente;

  }

  public function get_ingresos_lst($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){
      $condx = "";
    } else {
      $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'";
    }
    $db = new Conexion();
    $get_ingresos_lst = [];

    $sql = $db->query("SELECT tblp_foliospago.IdFolio, tblp_foliospago.NoFolio, tblp_foliospago.IdPago, tblp_foliospago.Estatus, tblp_foliospago.FecCap, tblp_foliospago.FecPago, tblp_foliospago.Monto, tblp_foliospago.Folio, tblp_foliospago.IdUsua, tblp_foliospago.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblp_pagos.Fecha, tblp_pagos.IdOferta, tblc_conceptosplanes.NomPlan, tblc_formapago.Descripcion, tblc_bancos.Banco, tblp_educativa.Nombre AS Educativa, tblp_grupo.CveGrupo, tblc_campus.Campus, tblc_bancos.Nombre AS NomBanco FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma  Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_foliospago.IdCampus WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx ORDER BY tblp_pagos.IdOferta ASC, tblp_foliospago.FecCap ");
    while($x = $db->recorrer($sql)){
      $get_ingresos_lst[] = $x;
    }
    return $get_ingresos_lst;
	}

  public function get_ingresos_folios($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){
      $condx = "";
    } else {
      $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'";
    }
    $db = new Conexion();
    $get_ingresos_folios = [];

    $sql = $db->query("SELECT
Count(tblp_foliospago.IdFolio) AS Total,
tblp_foliospago.NoFolio,
tblp_foliospago.IdPago,
tblp_foliospago.Estatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
Sum(tblp_foliospago.Monto) AS Monto
FROM
tblp_foliospago
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdAdmin
WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx 
GROUP BY
tblp_foliospago.IdAdmin
ORDER BY Total ASC");
    while($x = $db->recorrer($sql)){
      $get_ingresos_folios[] = $x;
    }
    return $get_ingresos_folios;
	}


  public function get_pagos_pendientes_all($fecha1,$fecha2) {
  
    $db = new Conexion();
    $get_pagos_pendientes_all = [];

    $sql = $db->query("SELECT
Sum(tblp_pagos.Monto + tblp_pagos.Recargos - tblp_pagos.Descuento - tblp_pagos.TotalPagado) AS Total,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.IdEstatus,
tblp_pagos.Descuento,
tblp_pagos.IdCampus,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblc_campus.Campus,
tblp_educativa.Nombre
FROM
tblp_pagos
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_pagos.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
WHERE
tblp_pagos.IdConcepto <= '3' AND
tblp_pagos.IdEstatus =  '1'
AND tblp_pagos.Fecha BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59'
GROUP BY
tblp_pagos.IdCampus,
tblp_pagos.IdOferta
ORDER BY
tblp_pagos.IdCampus ASC,
tblp_educativa.IdGrado ASC");
    while($x = $db->recorrer($sql)){
      $get_pagos_pendientes_all[] = $x;
    }
    return $get_pagos_pendientes_all;
	}


  public function get_ing_banco($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){
      $condx = "";
    } else {
      $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'";
    }
    $db = new Conexion();
    $get_ing_banco = [];



    $sql = $db->query("SELECT tblp_foliospago.IdFolio, Sum(tblp_foliospago.Monto) AS Suma, tblc_bancos.Banco, tblc_bancos.Nombre FROM tblp_foliospago Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx GROUP BY tblp_foliospago.IdBanco ORDER BY tblp_foliospago.IdBanco ASC");
    while($x = $db->recorrer($sql)){
      $get_ing_banco[] = $x;
    }
    return $get_ing_banco;
	}

  public function get_ing_banco_campus($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){
      $condx = "";
    } else {
      $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'";
    }
    $db = new Conexion();
    $get_ing_banco_campus = [];

    $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
Sum(tblp_foliospago.Monto) AS Suma,
tblc_bancos.Banco,
tblc_bancos.Nombre,
tblp_foliospago.IdCampus,
tblc_campus.Campus
FROM
tblp_foliospago
Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_foliospago.IdCampus
WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx
GROUP BY
tblp_foliospago.IdCampus,
tblp_foliospago.IdBanco
ORDER BY
tblp_foliospago.IdCampus ASC,
tblp_foliospago.IdBanco ASC");
    while($x = $db->recorrer($sql)){
      $get_ing_banco_campus[] = $x;
    }
    return $get_ing_banco_campus;
	}


  public function get_ing_concep($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){ $condx = ""; } else { $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'"; }
    $db = new Conexion();
    $get_ing_concep = [];

    $sql = $db->query("SELECT tblp_foliospago.IdFolio, Sum(tblp_foliospago.Monto) AS Suma, tblc_conceptosplanes.NomPlan FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx GROUP BY tblc_conceptosplanes.IdConceptoPlanes ORDER BY tblc_conceptosplanes.IdConceptoPlanes");
    while($x = $db->recorrer($sql)){
      $get_ing_concep[] = $x;
    }
    return $get_ing_concep;
	}

  public function get_ing_concep_campus($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){ $condx = ""; } else { $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'"; }
    $db = new Conexion();
    $get_ing_concep_campus = [];

    $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
Sum(tblp_foliospago.Monto) AS Suma,
tblc_conceptosplanes.NomPlan,
tblc_campus.IdCampus,
tblc_campus.Campus
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_foliospago.IdCampus
WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx
GROUP BY tblp_foliospago.IdCampus, tblc_conceptosplanes.IdConceptoPlanes
ORDER BY  tblp_foliospago.IdCampus ASC, tblc_conceptosplanes.IdConceptoPlanes ASC");
    while($x = $db->recorrer($sql)){
      $get_ing_concep_campus[] = $x;
    }
    return $get_ing_concep_campus;
	}


  public function get_ing_oferta($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){ $condx = ""; } else { $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'"; }
    $db = new Conexion();
    $get_ing_oferta = [];

    $sql = $db->query("SELECT tblp_foliospago.IdFolio, Sum(tblp_foliospago.Monto) AS Suma, tblp_pagos.IdOferta, tblp_educativa.Nombre AS Educativa FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx GROUP BY tblp_pagos.IdOferta ORDER BY tblp_pagos.IdOferta ASC");
    while($x = $db->recorrer($sql)){
      $get_ing_oferta[] = $x;
    }
    return $get_ing_oferta;
	}

  public function get_oferta_id($IdOferta) {
    $db = new Conexion();
    $get_oferta_id = [];

    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'");
    while($x = $db->recorrer($sql)){
      $get_oferta_id[] = $x;
    }
    return $get_oferta_id;
	}

  public function get_vigencia_id($IdUsua) {
    $db = new Conexion();
    $get_vigencia_id = [];

    $sql = $db->query("SELECT tblc_alumnos.IdCiclo, tblc_ciclo.Ciclo FROM tblc_alumnos Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_alumnos.IdCiclo WHERE tblc_alumnos.IdUsua =  '$IdUsua' ORDER BY tblc_ciclo.FInicio DESC LIMIT 1");
    while($x = $db->recorrer($sql)){
      $get_vigencia_id[] = $x;
    }
    return $get_vigencia_id;
	}


  public function get_ing_oferta_campus($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){ $condx = ""; } else { $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'"; }
    $db = new Conexion();
    $get_ing_oferta_campus = [];

    $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
Sum(tblp_foliospago.Monto) AS Suma,
tblp_pagos.IdOferta,
tblp_educativa.Nombre AS Educativa,
tblp_foliospago.IdCampus,
tblc_campus.Campus
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_foliospago.IdCampus
WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx
GROUP BY tblp_foliospago.IdCampus, tblp_pagos.IdOferta
ORDER BY tblp_foliospago.IdCampus ASC, tblp_pagos.IdOferta ASC");
    while($x = $db->recorrer($sql)){
      $get_ing_oferta_campus[] = $x;
    }
    return $get_ing_oferta_campus;
	}

  public function get_ing_grado($fecha1,$fecha2,$IdPlan) {
    $condx = "";
    if($IdPlan == 9999){ $condx = ""; } else { $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'"; }
    $db = new Conexion();
    $get_ing_grado = [];

    $sql = $db->query("SELECT tblp_foliospago.IdFolio, Sum(tblp_foliospago.Monto) AS Suma, tblp_pagos.IdOferta, tblc_grado._Grado FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx GROUP BY tblp_educativa.IdGrado ORDER BY tblp_educativa.IdGrado ASC");
    while($x = $db->recorrer($sql)){
      $get_ing_grado[] = $x;
    }
    return $get_ing_grado;
	}

  public function get_alumno_code_id($code) {
    $db = new Conexion();
    $get_alumno_code_id = [];

    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario._qrcode = '$code'");
    while($x = $db->recorrer($sql)){
      $get_alumno_code_id[] = $x;
    }
    return $get_alumno_code_id;
}

  public function get_alumno_id($IdUsua) {
    $db = new Conexion();
    $get_alumno_id = [];

    $sql_user = $db->query("SELECT tblc_usuario.IdCampus, tblc_usuario._qrcode FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql_user);
    $_camp = $db->recorrer($sql_user);
    
    
    if(!isset($_camp["_qrcode"])){
      $IdCamp = $_camp["IdCampus"];

      $anio = date('Y');
      $mes = date('m');

      require '../../assets/qrcode/qrlib.php';
      $dir = '../../assets/images/qr/'.$anio.'/'.$mes.'/';

      if(!file_exists($dir))
      mkdir($dir);
      $ubicacion = $anio.'/'.$mes.'/';
      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 19;
      $cad =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

      $filename = $dir.$cad.'.png';
      $tamanio = 10;
      $level = 'M';
      $frameSize = 3;

      $guarado = 'assets/images/qr/'.$anio.'/'.$mes.'/'.$cad.'.png';;

      $contenido = "https://sciudy.com/mi_credencial.php?idToks=".$cad;

      QRCode::png($contenido, $filename, $level, $tamanio, $frameSize);

      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._qrcode = '$cad', tblc_usuario._ubicacion = '$guarado' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      
      $sql_cre = $db->query("SELECT tblp_credencial.Folio FROM tblp_credencial WHERE tblp_credencial.IdCampus = '$IdCamp' ORDER BY tblp_credencial.Folio DESC LIMIT 1");
      $db->rows($sql_cre);
      $credenx = $db->recorrer($sql_cre);
      if(isset($credenx['Folio'])){
        $folio = $credenx['Folio'] + 1;
      } else {
        $folio = 1;
      }

      if($IdCamp == 1){ $cox = "VH"; }
      if($IdCamp == 2){ $cox = "CO"; }
      if($IdCamp == 3){ $cox = "TE"; }
      if($IdCamp == 4){ $cox = "EZ"; }

      $_fol = str_pad($folio,4, "0", STR_PAD_LEFT);
      $cadena = 'IUDY-'.$cox.$_fol;

      $insertar = $db->query("INSERT INTO tblp_credencial (IdUsua, IdCampus, Folio, Cadena, FecCap) VALUES ('$IdUsua','$IdCamp','$folio','$cadena',NOW()) ");
      $insertar = $db->query("UPDATE tblc_usuario SET  tblc_usuario._folio = '$cadena', tblc_usuario._qrcode = '$cad', tblc_usuario._ubicacion = '$guarado' WHERE tblc_usuario.IdUsua = '$IdUsua'");


    }

    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $get_alumno_id[] = $x;
    }
    return $get_alumno_id;
  }

}

function obtener_fexc($fecha){
		$dia= conocer_sem($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $num.' de '.$mes.' de '.$anno;
	}

function conocer_sem($fecha) {
	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
}



?>
