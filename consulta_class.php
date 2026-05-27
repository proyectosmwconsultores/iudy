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

  public function get_sum_area($Inicio,$Final) {
    $db = new Conexion();
    $get_sum_area = [];
    $sql = $db->query("SELECT Sum(tblp_gastos.Importe) AS Suma, tblc_permiso._Permiso FROM tblp_gastos Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblp_gastos.IdPermiso WHERE tblp_gastos.Fecha BETWEEN '$Inicio' AND '$Final' GROUP BY tblp_gastos.IdPermiso ORDER BY Suma ASC ");
    while($x = $db->recorrer($sql)){
      $get_sum_area[] = $x;
    }
    return $get_sum_area;
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
    // $fec_ini = $anio_mes.'-01';
    // $fec_fin = $anio_mes.'-31';
    $fec_ini = '2022-07-01';
    $fec_fin = '2022-12-31';

    $sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.IdPago,
tblp_foliospago.IdUsua,
tblp_foliospago.FecPago,
Sum(tblp_foliospago.Monto) AS Total,
tblp_foliospago.IdForma,
tblp_foliospago.IdCampus,
tblp_educativa.Nombre AS NomEducativa,
tblc_formapago._Descripcion,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_datosfactura.IdEstatus
FROM
tblp_foliospago
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_foliospago.IdOferta
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
Left Join tblc_datosfactura ON tblc_datosfactura.IdUsua = tblc_usuario.IdUsua
WHERE
tblp_pagos.Facturar = 'SI' AND
tblp_foliospago.Factura = '1' AND
tblp_foliospago.FecPago BETWEEN '$fec_ini' AND '$fec_fin'
GROUP BY
tblp_foliospago.NoFolio
");
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
tblp_foliospago.FecPago,
tblc_conceptosplanes.NomPlan,
tblp_pagos.FecDesc,
tblp_foliospago.Estatus,
tblp_pagos.Monto AS TotalPagar,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
    WHERE
    tblp_foliospago.Factura = '1' AND
    tblp_foliospago.FecPago BETWEEN '$fec_ini' AND '$fec_fin'");
    while($x = $db->recorrer($sql)){
      $get_facturas_mes[] = $x;
    }
    return $get_facturas_mes;

  }

  public function get_facturas_generadas($Ini, $Fin) {
    $db = new Conexion();
    $get_facturas_generadas = [];
    $anio_mes = date("Y-m");

    $sql = $db->query("SELECT
tblg_datos_factura.Folio,
tblg_factura.IdFactura,
tblg_factura.IdUsua,
tblg_factura.FolioPago,
tblg_factura.fechaTimbrado,
tblg_factura._folio,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblg_datos_factura.SubTotal,
tblg_datos_factura.Descuento,
tblg_datos_factura.Total,
tblg_datos_factura.Serie,
tblg_datos_factura.Mes,
tblg_datos_factura.Anio
FROM
tblg_factura
Left Join tblg_datos_factura ON tblg_datos_factura.FolioPago = tblg_factura.FolioPago
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblg_factura.IdUsua
WHERE
tblg_factura.Fecha BETWEEN '$Ini' AND '$Fin' ");
    while($x = $db->recorrer($sql)){
      $get_facturas_generadas[] = $x;
    }
    return $get_facturas_generadas;

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

    $sql = $db->query("SELECT tblp_foliospago.IdFolio, tblp_foliospago.NoFolio, tblp_foliospago.IdPago, tblp_foliospago.Estatus, tblp_foliospago.FecCap, tblp_foliospago.FecPago, tblp_foliospago.Monto, tblp_foliospago.Folio, tblp_foliospago.IdUsua, tblp_foliospago.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblp_pagos.FecDesc, tblp_pagos.IdOferta, tblc_conceptosplanes.NomPlan, tblc_formapago.Descripcion, tblc_bancos.Banco, tblp_educativa.Nombre AS Educativa, tblp_grupo.CveGrupo, tblc_campus.Campus, tblc_bancos.Nombre AS NomBanco FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma  Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_foliospago.IdCampus WHERE tblp_foliospago.IdEstatus = '4' AND tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx ORDER BY tblp_pagos.IdOferta ASC, tblp_foliospago.FecCap ");
    while($x = $db->recorrer($sql)){
      $get_ingresos_lst[] = $x;
    }
    return $get_ingresos_lst;
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
