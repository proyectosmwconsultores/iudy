<?php
require('system.php');
class Imprimir
{
	public function get_chkDeuda($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblp_saldo.Monto) AS Saldo FROM tblp_saldo WHERE tblp_saldo.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gdatoSald[] = $x;
    }
    return $gdatoSald;
  }

	public function get_gasto_id($IdGasto) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_gastos.IdGasto, tblp_gastos.Fecha, tblp_gastos.Importe, tblp_gastos.Nota, tblc_concepto_gasto.Nombre_gasto, tblc_permiso._Permiso FROM tblp_gastos Left Join tblc_concepto_gasto ON tblc_concepto_gasto.IdConcepto = tblp_gastos.IdConcepto Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblp_gastos.IdPermiso WHERE tblp_gastos.IdGasto =  '$IdGasto'");
    while($x = $db->recorrer($sql)){
      $get_gasto_id[] = $x;
    }
    return $get_gasto_id;
  }

  public function get_all_users($IdEstatus) {
    $db = new Conexion();
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS NomEducativa,
tblc_permiso.Permiso
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblc_usuario.Permisos
WHERE
tblc_usuario.IdEstatus =  '$IdEstatus' AND
tblc_usuario.Permisos <> '1'
ORDER BY
tblc_usuario.Permisos ASC,
tblc_usuario.IdOferta ASC
");
    while($x = $db->recorrer($sql)){
      $get_all_users[] = $x;
    }
    return $get_all_users;
  }



	public function get_datos_const($IdDocs) {
    $db = new Conexion();
		  $get_datos_const = [];
    $sql = $db->query("SELECT tblp_docs_solicitados.IdDocumento, tblp_docs_solicitados.Anio, tblp_docs_solicitados.Mes, tblp_docs_solicitados.Fecha, tblp_docs_solicitados.IdGrupo, tblp_rvoe.Modalidad, tblp_rvoe.Escuela, tblp_rvoe.Clave, tblc_usuario.IdOferta, tblc_usuario.Nombre, tblc_usuario.Sexo, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_ciclo.Ciclo, tblc_usuario.SemCua, tblp_educativa.Nombre AS Educativa, tblc_usuario.Usuario FROM tblp_docs_solicitados Left Join tblp_rvoe ON tblp_rvoe.IdEducativa = tblp_docs_solicitados.IdOferta AND tblp_rvoe.IdCampus = tblp_docs_solicitados.IdCampus Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_docs_solicitados.IdUsua Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_docs_solicitados.IdCiclo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_docs_solicitados.IdOferta WHERE tblp_docs_solicitados.IdDocumento =  '$IdDocs'");
    while($x = $db->recorrer($sql)){
      $get_datos_const[] = $x;
    }
    return $get_datos_const;
  }

  public function get_campus_id($IdCampus) {
		$db = new Conexion();
		$get_campus_id = [];
		$sql = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
		while($x = $db->recorrer($sql)){
			$get_campus_id[] = $x;
		}
		return $get_campus_id;
	}



  public function get_direccion() {
	$db = new Conexion();

	$sql = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '13'");
	while($x = $db->recorrer($sql)){
		$get_direccion[] = $x;
	}
	return $get_direccion;
}

public function get_grad_px($IdGrupo,$IdCiclo) {
$db = new Conexion();
$get_grad_px = [];
$sql = $db->query("SELECT tblc_ciclogrupo.Grado, tblc_ciclo.Ciclo FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo'");
while($x = $db->recorrer($sql)){
	$get_grad_px[] = $x;
}
return $get_grad_px;
}

	public function get_grpt($IdGrupo) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_grupo.CveGrupo, tblp_grupo.IdCampus, tblp_grupo.TipoCiclo FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    while($x = $db->recorrer($sql)){
      $get_grpt[] = $x;
    }
    return $get_grpt;
  }

	public function get_lstListaFinal($IdCampus,$IdCiclo) {
    $db = new Conexion();

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_evaluaciondocente.Promedio FROM tblc_usuario Left Join tblp_evaluaciondocente ON tblp_evaluaciondocente.IdUsua = tblc_usuario.IdUsua WHERE tblc_usuario.Permisos = '2' AND tblp_evaluaciondocente.IdCampus = '$IdCampus' AND tblp_evaluaciondocente.IdCiclo = '$IdCiclo'  ORDER BY tblc_usuario.APaterno ASC");
    while($x = $db->recorrer($sql)){
      $gEvaLst[] = $x;
    }
    return $gEvaLst;
  }

	public function get_lstCam($IdCampus) {
    $db = new Conexion();
		$sql = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
    while($x = $db->recorrer($sql)){
      $gCamaLst[] = $x;
    }
    return $gCamaLst;
  }

	public function get_lstCic($IdCiclo) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    while($x = $db->recorrer($sql)){
      $gCicLst[] = $x;
    }
    return $gCicLst;
  }

	public function get_pagosPenGrupo($IdGrupo,$IdEstatus) {
    $db = new Conexion();
		$hoy = date("Y-m-d");

		if($IdEstatus == 8){
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
AND tblp_pagos.IdEstatus <>  '4' AND tblp_pagos.FecDesc < '$hoy' $condsx ORDER BY tblc_usuario.APaterno ASC, tblp_pagos.FecDesc ASC");
    while($x = $db->recorrer($sql)){
      $getPagPend[] = $x;
    }
    return $getPagPend;

  }

	public function getId_usuarioId($IdUsua) {
    $db = new Conexion();

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblc_usuario.Sexo, tblc_usuario.FecNac, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblp_grupo.CveGrupo, tblp_educativa.IdGrado, tblp_educativa.Nombre AS Educativa, tblc_grado.Descripcion FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
    while($x = $db->recorrer($sql)){
      $gUsuaId[] = $x;
    }
    return $gUsuaId;
	}

	public function getId_usuarioInfo($IdUsua) {
    $db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_informacion WHERE tblp_informacion.IdUsua =  '$IdUsua' ");
    while($x = $db->recorrer($sql)){
      $gInfoId[] = $x;
    }
    return $gInfoId;
	}

	public function getId_doscInfo($IdUsua) {
    $db = new Conexion();

    $sql = $db->query("SELECT tblp_documentos.IdDocumento, tblp_documentos.IdUsua, tblp_documentos.Si, tblp_documentos.No, tblp_documentos.Co, tblh_tipodocumento.Nombre FROM tblp_documentos Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblp_documentos.IdTipoDocumento WHERE tblp_documentos.IdUsua =  '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gInfoId[] = $x;
    }
    return $gInfoId;
	}


	public function get_userSaldo($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT
tblp_saldo.IdSaldo,
tblp_saldo.Descripcion,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdOferta
FROM
tblp_saldo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_saldo.IdUsua
 WHERE tblp_saldo.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gdatSaldo[] = $x;
    }
    return $gdatSaldo;

  }

	public function get_boucherId($IdPago){
		$db = new Conexion();
		$get_boucherId = [];

    $sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.IdOferta,
tblc_usuario.IdCampus,
tblc_usuario._alfanumerica,
tblc_usuario._numerica,
tblc_conceptosplanes.NomPlan,
tblp_pagos.IdOferta,
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Descuento,
tblp_pagos.Fecha,
tblp_pagos.Recargos,
tblp_pagos.Descuento2,
tblp_pagos.Referencia,
tblp_pagos.TotalPagado,
tblp_pagos.Monto,
tblp_pagos.IdEstatus,
tblc_estatus.Estatus,
tblp_pagos.FecLimPago,
tblp_educativa.IdGrado
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
WHERE
tblp_pagos.IdPago =  '$IdPago'");
    while($x = $db->recorrer($sql)){
      $get_boucherId[] = $x;
    }
    return $get_boucherId;
  }

	public function get_beca($IdUsua,$IdPago){
		$db = new Conexion();
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

	public function get_bancos($IdOferta, $IdCampus){
		$db = new Conexion();
		$gBancos = [];
		
		$sql = $db->query("SELECT tblc_bancos_setting.IdSetting, tblc_bancos.Nombre, tblc_bancos.Banco, tblc_bancos.Convenio, tblc_bancos.NoCuenta, tblc_bancos.Clabe FROM tblc_bancos_setting Left Join tblc_bancos ON tblc_bancos.IdBanco = tblc_bancos_setting.IdBanco WHERE tblc_bancos_setting.IdCampus =  '$IdCampus' AND tblc_bancos_setting.IdOferta =  '$IdOferta' AND tblc_bancos.IdEstatus =  '8' ");
		while($x = $db->recorrer($sql)){
			$gBancos[] = $x;
		}
		return $gBancos;
	}
	
	public function get_bancos_id(){
		$db = new Conexion();
		$get_bancos_id = [];
		$sql = $db->query("SELECT * FROM tblc_bancos WHERE tblc_bancos.IdBanco =  '3' ");
		while($x = $db->recorrer($sql)){
			$get_bancos_id[] = $x;
		}
		return $get_bancos_id;
	}

	public function get_nobancos($IdOferta){
		$db = new Conexion();

		$sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
		$db->rows($sql9);
		$datos91 = $db->recorrer($sql9);
		$IdGrado = $datos91['IdGrado'];
		$get_nobancos = [];

		$sql = $db->query("SELECT Count(tblc_bancos.IdBanco) AS sumBanco FROM tblc_bancos WHERE tblc_bancos.Grado$IdGrado =  '1' AND tblc_bancos.IdEstatus = '8'");
		while($x = $db->recorrer($sql)){
			$get_nobancos[] = $x;
		}
		return $get_nobancos;
	}

	public function get_ofertaId($IdOferta){
		$db = new Conexion();
		$sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'");
		while($x = $db->recorrer($sql)){
			$geDTSum[] = $x;
		}
		return $geDTSum;
	}

	// public function get_usuariosT($IdEstatus) {
  //   if($IdEstatus == 99){ $cond = ""; } else { $cond = " WHERE tblc_usuario.IdEstatus = '$IdEstatus' "; }
  //   $db = new Conexion();
	//
	//
  //   //$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.FecCap, tblc_usuario.Matricula, tblp_educativa.Nombre AS NomEducativa, tblc_usuario.IdEstatus, tblc_estatus.Estatus FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus $cond ORDER BY tblc_usuario.Tipo ASC, tblc_usuario.APaterno ASC, tblc_usuario.Nombre ASC");
  //   while($x = $db->recorrer($sql)){
  //     $gAlumosTx[] = $x;
  //   }
  //   return $gAlumosTx;
  // }


	public function get_usuariosTx($IdEstatus) {
		$db = new Conexion();

    if($IdEstatus == 8){
        $cond = " AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '61')) ";
    } else {
        $cond = " AND tblc_usuario.IdEstatus = '$IdEstatus' ";
    }
    
		$sql = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Cargo FROM tblc_usuario WHERE tblc_usuario.Permisos <> '1' $cond GROUP BY tblc_usuario.Permisos ORDER BY tblc_usuario.Cargo ASC");
		while($x = $db->recorrer($sql)){
			$gusuariosT[] = $x;
		}
		return $gusuariosT;
	}

	public function get_factura_id($codeFactura) {
		$db = new Conexion();


		$sql = $db->query("SELECT * FROM tblg_factura WHERE tblg_factura._codigoFactura = '$codeFactura'");
		while($x = $db->recorrer($sql)){
			$get_factura_id[] = $x;
		}
		return $get_factura_id;
	}
	public function get_datos_factura_id($codeFactura) {
		$db = new Conexion();

		$sql = $db->query("SELECT * FROM tblg_datos_factura WHERE tblg_datos_factura._codigoFactura = '$codeFactura'");
		while($x = $db->recorrer($sql)){
			$get_datos_factura_id[] = $x;
		}
		return $get_datos_factura_id;
	}

	public function get_pagos_factura($codeFactura) {
		$db = new Conexion();

		$sql = $db->query("SELECT
tblg_conceptos_factura.IdConcepto,
tblg_conceptos_factura.FolioPago,
tblg_conceptos_factura.ClaveProdServ,
tblg_conceptos_factura.Cantidad,
tblg_conceptos_factura.ClaveUnidad,
tblg_conceptos_factura.Descripcion,
tblg_conceptos_factura.Unidad,
tblg_conceptos_factura.ValorUnitario,
tblg_conceptos_factura.Precio,
tblg_conceptos_factura.Importe,
tblg_conceptos_factura.Descuento,
tblg_conceptos_factura.ObjetoImp,
tblg_conceptos_factura.FecCap,
tblg_conceptos_factura.IdFactura,
tblg_conceptos_factura._folio,
tblg_conceptos_factura._codigoFactura,
tblg_conceptos_factura._unidad,
tblg_conceptos_factura.complemento,
tblg_conceptos_factura.rvoe,
tblg_conceptos_factura.curp,
tblg_conceptos_factura.alumno,
tblg_conceptos_factura.nivel,
tbc_producto.Descripcion AS DesProd
FROM
tblg_conceptos_factura
Left Join tbc_producto ON tbc_producto.Clave = tblg_conceptos_factura.ClaveProdServ WHERE tblg_conceptos_factura._codigoFactura = '$codeFactura'");
		while($x = $db->recorrer($sql)){
			$get_pagos_factura[] = $x;
		}
		return $get_pagos_factura;
	}

	public function get_direccion_id($IdFactura) {
		$db = new Conexion();
		$get_direccion_id = [];
	
		$sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblc_datosfactura.IdUsua,
tblc_datosfactura.Domicilio,
tblc_datosfactura.NoExterior,
tblc_datosfactura.Colonia,
tblc_datosfactura.Municipio,
tblc_datosfactura.Ciudad,
tblc_datosfactura.Estado,
tblc_datosfactura.tipoPersona
FROM
tblp_foliospago
Left Join tblc_datosfactura ON tblc_datosfactura.IdUsua = tblp_foliospago.IdUsua
WHERE
tblp_foliospago.NoFolio =  '$IdFactura' LIMIT 1
");
		while($x = $db->recorrer($sql)){
			$get_direccion_id[] = $x;
		}
		return $get_direccion_id;
	}

	public function get_detalle_id($IdFactura, $code) {
		$db = new Conexion();
		
		$sql = $db->query("SELECT tblg_datos_factura.FormaPago, tblc_formapago.c_Descripcion AS _formaPago, tblc_usocfdi.Descripcion AS _usoCFDI, tblc_regimen_fiscal.Descripcion AS _regimenFiscal FROM tblg_datos_factura Left Join tblc_formapago ON tblc_formapago.c_FormaPago = tblg_datos_factura.FormaPago Left Join tblc_usocfdi ON tblc_usocfdi.Clave = tblg_datos_factura.R_UsoCFDI Left Join tblc_regimen_fiscal ON tblc_regimen_fiscal.Clave = tblg_datos_factura.R_RegimenFiscalReceptor WHERE tblg_datos_factura.FolioPago =  '$IdFactura'");
		while($x = $db->recorrer($sql)){
			$get_detalle_id[] = $x;
		}
		return $get_detalle_id;
	}
	
	public function get_detalle_global_id($IdFactura) {
		$db = new Conexion();
		
		$sql = $db->query("SELECT tblg_datos_factura.FormaPago, tblc_formapago.c_Descripcion AS _formaPago, tblc_usocfdi.Descripcion AS _usoCFDI, tblc_regimen_fiscal.Descripcion AS _regimenFiscal FROM tblg_datos_factura Left Join tblc_formapago ON tblc_formapago.c_FormaPago = tblg_datos_factura.FormaPago Left Join tblc_usocfdi ON tblc_usocfdi.Clave = tblg_datos_factura.R_UsoCFDI Left Join tblc_regimen_fiscal ON tblc_regimen_fiscal.Clave = tblg_datos_factura.R_RegimenFiscalReceptor WHERE tblg_datos_factura.FolioPago =  '$IdFactura'");
		while($x = $db->recorrer($sql)){
			$get_detalle_id[] = $x;
		}
		return $get_detalle_id;
	}
	
	public function get_oferta_id($IdOferta) {
		$db = new Conexion();
		
		$sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta' ");
		while($x = $db->recorrer($sql)){
			$get_oferta_id[] = $x;
		}
		return $get_oferta_id;
	}

	public function get_user_fact($IdUsua) {
		$db = new Conexion();
		$sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS Educativa
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.IdUsua =  '$IdUsua'
");
		while($x = $db->recorrer($sql)){
			$get_detalle_id[] = $x;
		}
		return $get_detalle_id;
	}

	public function get_user_cic($IdCiclo) {
		$db = new Conexion();
		$sql = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo' ");
		while($x = $db->recorrer($sql)){
			$get_user_cic[] = $x;
		}
		return $get_user_cic;
	}

public function get_datoFolio($IdFactura) {
	$db = new Conexion();

	$sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.IdPago,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblp_foliospago.Folio,
tblp_foliospago.IdEstatus,
tblp_foliospago.FecCancelado,
tblp_foliospago.Motivo_cancelado,
tblp_foliospago.IdEstatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.IdGrupo,
tblc_usuario.IdCampus,
tblc_estatus.Estatus,
tblc_formapago.Descripcion,
admin.id_paquete AS Firma,
admin.Nombre AS Nom,
admin.APaterno AS Pat,
admin.AMaterno AS Mat,
tblc_bancos.NoCuenta
FROM
tblp_foliospago
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_foliospago.IdEstatus Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma Left Join tblc_usuario AS admin ON admin.IdUsua = tblp_foliospago.IdAdmin Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco WHERE tblp_foliospago.IdFactura =  '$IdFactura' LIMIT 1 ");
	while($x = $db->recorrer($sql)){
		$gAlumosFol[] = $x;
	}
	return $gAlumosFol;
}


public function get_dato_folio($Folio) {
	$db = new Conexion();

	$sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.IdPago,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblp_foliospago.Folio,
tblp_foliospago.IdEstatus,
tblp_foliospago.FecCancelado,
tblp_foliospago.Motivo_cancelado,
tblp_foliospago.IdEstatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.IdGrupo,
tblc_usuario.IdCampus,
tblc_estatus.Estatus,
tblc_formapago.Descripcion,
admin.id_paquete AS Firma,
admin.Nombre AS Nom,
admin.APaterno AS Pat,
admin.AMaterno AS Mat,
tblc_bancos.NoCuenta
FROM
tblp_foliospago
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_foliospago.IdEstatus Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma Left Join tblc_usuario AS admin ON admin.IdUsua = tblp_foliospago.IdAdmin Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco WHERE tblp_foliospago.NoFolio =  '$Folio' LIMIT 1 ");
	while($x = $db->recorrer($sql)){
		$gAlumosFol[] = $x;
	}
	return $gAlumosFol;
}


public function get_datoGrp($IdGrupo) {
	$db = new Conexion();
	$get_datoGrp = [];
	$sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Turno,
tblp_grupo.Grupo,
tblp_grupo.Modalidad,
tblp_educativa.Nombre,
tblp_educativa.IdGrado,
tblc_dias_clases._Dias,
tblc_grado._Grado
FROM
tblp_grupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado
WHERE
tblp_grupo.IdGrupo =  '$IdGrupo'
");
	while($x = $db->recorrer($sql)){
		$get_datoGrp[] = $x;
	}
	return $get_datoGrp;
}

public function get_datoPag($IdPago) {
	$db = new Conexion();

	$sql = $db->query("SELECT
		tblp_pagos.IdPago,
tblp_pagos.IdCiclo,
tblp_pagos.Fecha,
tblp_pagos.IdOferta,
tblc_conceptosplanes.NomPlan
FROM
tblp_pagos
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE
tblp_pagos.IdPago =  '$IdPago'

");
	while($x = $db->recorrer($sql)){
		$gAlumosPag[] = $x;
	}
	return $gAlumosPag;
}

public function get_datoCam($IdCampus) {
	$db = new Conexion();
	$sql = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
	while($x = $db->recorrer($sql)){
		$gAlumosCam[] = $x;
	}
	return $gAlumosCam;
}

public function get_plataforma() {
	$db = new Conexion();

	$sql = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '2'");
	while($x = $db->recorrer($sql)){
		$get_plataforma[] = $x;
	}
	return $get_plataforma;
}

public function get_lst_temporal($IdTempotal) {
	$db = new Conexion();
    $get_lst_temporal = [];
    
	$sql = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdTemporal = '$IdTempotal'");
	while($x = $db->recorrer($sql)){
		$get_lst_temporal[] = $x;
	}
	return $get_lst_temporal;
}


public function get_lstdatoFolio($IdFactura) {
	$db = new Conexion();

	$sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.IdPago,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblp_foliospago.Folio,
tblp_foliospago.Tipo,
tblp_foliospago.Nota,
tblc_formapago.Descripcion,
tblc_conceptosplanes.NomPlan,
tblp_foliospago.Estatus,
tblp_modulo.NombreMod,
tblp_foliospago.FecCap
FROM
tblp_foliospago
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_pagos.IdModulo WHERE tblp_foliospago.IdFactura =  '$IdFactura' ");
	while($x = $db->recorrer($sql)){
		$get_lstdatoFolio[] = $x;
	}
	return $get_lstdatoFolio;
}

public function get_lstdato_folio($Folio) {
	$db = new Conexion();


	$sql = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.IdPago,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblp_foliospago.Folio,
tblp_foliospago.NoFolio,
tblp_foliospago.Tipo,
tblp_foliospago.Nota,
tblp_foliospago._idtemporal,
tblc_formapago.Descripcion,
tblc_conceptosplanes.NomPlan,
tblp_foliospago.Estatus,
tblp_modulo.NombreMod,
tblp_foliospago.FecCap
FROM
tblp_foliospago
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_pagos.IdModulo WHERE tblp_foliospago.NoFolio =  '$Folio' ");
	while($x = $db->recorrer($sql)){
		$get_lstdatoFolio[] = $x;
	}
	return $get_lstdatoFolio;
}


	public function get_datosConsulta($IdDoc){
		$db = new Conexion();
		$sql1 = $db->query("SELECT * FROM tblc_docsolicitado WHERE tblc_docsolicitado.IdDocSolicitado = '$IdDoc'");
		$db->rows($sql1);
		$datos2 = $db->recorrer($sql1);
		$Fecha = $datos2["Fecha"];
		if(!$Fecha){
			$insertar = $db->query("UPDATE tblc_docsolicitado SET tblc_docsolicitado.Fecha = NOW() WHERE tblc_docsolicitado.IdDocSolicitado= '$IdDoc' ");
		}

		$sql = $db->query("SELECT * FROM tblc_docsolicitado WHERE tblc_docsolicitado.IdDocSolicitado = '$IdDoc'");
		while($x = $db->recorrer($sql)){
			$gDocSolicitado[] = $x;
		}
		return $gDocSolicitado;
	}

	public function get_datosUsuario($IdUsua){
		$db = new Conexion();
		$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Matricula, tblc_usuario.SemCua, tblc_usuario.Foto, tblp_educativa.Nombre AS NomEducativa, tblp_educativa.Tipo, tblc_usuario.Usuario, tblc_usuario.IdGrupo FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$gDatosUsua[] = $x;
		}
		return $gDatosUsua;
	}

	public function get_bajaUsua($IdUsua){
		$db = new Conexion();
		$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Matricula, tblc_estatus.Estatus, tblc_usuario.SemCua, tblp_educativa.Ciclo, tblc_abreviatura.Abreviatura, tblp_educativa.Nombre AS NomEducativa, tblh_baja.FecCap FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblc_usuario.SemCua Left Join tblh_baja ON tblh_baja.IdUsua = tblc_usuario.IdUsua WHERE tblc_usuario.IdUsua =  '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$gBajaUsua[] = $x;
		}
		return $gBajaUsua;
	}

	public function get_calFinal($IdUsua,$grado){
		$db = new Conexion();
		$sql = $db->query("SELECT tblp_calificacionfinal.IdCalificacionF, tblp_calificacionfinal.IdAsignacion, tblp_calificacionfinal.IdEducativa, tblp_calificacionfinal.IdModulo, tblp_calificacionfinal.IdAlumno, tblp_calificacionfinal.Calificacion, tblp_modulo.NoModulo, tblp_modulo.NombreMod FROM tblp_calificacionfinal Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacionfinal.IdModulo WHERE tblp_calificacionfinal.IdAlumno	= '$IdUsua' AND tblp_modulo.Grado = '$grado' ORDER BY tblp_calificacionfinal.IdModulo ASC");
		while($x = $db->recorrer($sql)){
			$gCalFinal[] = $x;
		}
		return $gCalFinal;
	}

	public function get_CicloEsss($IdAsignacion){
		$db = new Conexion();
		$sql = $db->query("SELECT tblc_ciclo.FInicio, tblc_ciclo.FFinal FROM tblp_asignacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
		while($x = $db->recorrer($sql)){
			$gAshhs[] = $x;
		}
		return $gAshhs;
	}

	public function get_datosCiclo($IdPago){
		$db = new Conexion();
		$sql = $db->query("SELECT tblp_pagos.IdPago, tblc_ciclo.IdCiclo, tblc_ciclo.Tipo, tblc_ciclo.FInicio, tblc_ciclo.FFinal FROM tblp_pagos Inner Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo WHERE tblp_pagos.IdPago =  '$IdPago'");
		while($x = $db->recorrer($sql)){
			$gCicloP[] = $x;
		}
		return $gCicloP;
	}

	public function get_calificaciones($IdAlumno,$cuatrimestre){
		$db = new Conexion();

		$sql = $db->query("SELECT tblp_calificacionfinal.IdCalificacionF, tblp_calificacionfinal.IdAsignacion, tblp_calificacionfinal.IdEducativa, tblp_calificacionfinal.IdAlumno, tblp_calificacionfinal.Calificacion, tblp_modulo.Grado, tblp_modulo.NombreMod, tblc_ciclo.Ciclo FROM tblp_calificacionfinal Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacionfinal.IdModulo Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_calificacionfinal.IdAsignacion AND tblp_asignacion.IdEducativa = tblp_calificacionfinal.IdEducativa AND tblp_asignacion.IdModulo = tblp_calificacionfinal.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo WHERE tblp_calificacionfinal.IdAlumno =  '$IdAlumno' AND tblp_calificacionfinal.Calificacion IS NOT NULL GROUP BY tblp_calificacionfinal.IdCalificacionF ORDER BY tblp_modulo.NoModulo ASC");
		while($x = $db->recorrer($sql)){
			$gCicloP[] = $x;
		}
		return $gCicloP;
	}

  public function get_descuento($IdDescuento){
		if($IdDescuento){
			$db = new Conexion();
			$sql = $db->query("SELECT tblp_descuento.IdDescuento, tblp_descuento.IdPago, tblp_descuento.IdTipoDescuento, tblp_descuento.Porcentaje, tblp_descuento.TotalPagar, tblp_descuento.Descuento, tblp_descuento.FecDescuento, tblp_descuento.FecCap, tblp_descuento.Estatus, tblc_tipodescuento.NomDescuento FROM tblp_descuento Inner Join tblc_tipodescuento ON tblc_tipodescuento.IdTipoDescuento = tblp_descuento.IdTipoDescuento WHERE tblp_descuento.IdDescuento = '$IdDescuento' AND tblp_descuento.Estatus = '8'");
			while($x = $db->recorrer($sql)){
				$gDescuentoId[] = $x;
			}
			return $gDescuentoId;
		}
  }

	public function get_recargo($IdUsua, $IdPago){
		$db = new Conexion();
		$sql = $db->query("SELECT Sum(tblp_recargos.Monto) AS Recargo FROM tblp_recargos WHERE tblp_recargos.IdUsua = '$IdUsua' AND tblp_recargos.IdPago = '$IdPago' AND tblp_recargos.IdEstatus = '8'");
		while($x = $db->recorrer($sql)){
			$gRecarId[] = $x;
		}
		return $gRecarId;

  }

	public function get_totalMaterias($IdUsua,$Grado){
		$db = new Conexion();
		$sql = $db->query("SELECT Count(tblp_calificacionfinal.IdCalificacionF) AS TotalMateria FROM tblp_calificacionfinal Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacionfinal.IdModulo WHERE tblp_calificacionfinal.IdAlumno =  '$IdUsua' AND tblp_modulo.Grado = '$Grado'");
		while($x = $db->recorrer($sql)){
			$gMatrasId[] = $x;
		}
		return $gMatrasId;
	}

	public function get_comprobanteId($IdPago){
		$db = new Conexion();
		$sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.FecLimPago, tblp_pagos.FecPago, tblp_pagos.TotalPagado, tblp_educativa.Tipo, tblp_educativa.Nombre, tblc_conceptos.NomConcepto, tblc_estatus.Estatus, tblh_detallepagos.FecCap AS FecSubioArchivo, tblc_usuario.Nombre AS NomUsuario, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_foliospago.NoFolio, tblc_formapago.Descripcion, tblp_pagos.Pagar, tblp_pagos.Recargos, tblp_pagos.EstatusDescuento FROM tblp_pagos Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblh_detallepagos ON tblh_detallepagos.IdPago = tblp_pagos.IdPago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblp_foliospago ON tblp_foliospago.IdPago = tblp_pagos.IdPago Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_pagos.IdFormaPago WHERE tblp_pagos.IdPago = '$IdPago'");
		while($x = $db->recorrer($sql)){
			$gBoucherIdx[] = $x;
		}
		return $gBoucherIdx;
	}

  public function get_datosToken($token){
		$db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Estatus, tblc_usuario.Correo, tblp_educativa.Nombre AS NomOferta FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Code = '$token'");
    while($x = $db->recorrer($sql)){
      $gTokenId[] = $x;
    }
    return $gTokenId;
  }

  public function get_imprimir($IdUsua){
		$db = new Conexion();

		$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_educativa.Nombre AS NomOferta FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gTiendagw[] = $x;
    }
    return $gTiendagw;
  }

	public function get_servicio($IdUsua){
		$db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gSevicio[] = $x;
    }
    return $gSevicio;
  }

	public function get_alumnos($IdGrupo,$IdCiclo){
		$db = new Conexion();

		$sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdEstatus,
tblc_usuario.Usuario,
tblc_usuario.Sexo
FROM
tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND ( tblc_usuario.IdCiclo IS NULL  OR tblc_usuario.IdCiclo =  '$IdCiclo' ) ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.Nombre ASC ");
// tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdCiclo IS NULL ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.Nombre ASC ");
//AND ( tblc_usuario.IdCiclo IS NULL  OR tblc_usuario.IdCiclo =  '16' )
    while($x = $db->recorrer($sql)){
      $gAlumns[] = $x;
    }
    return $gAlumns;
	}

	public function get_alumnosRep($IdGrupo,$IdCiclo){
		$db = new Conexion();

		$sql = $db->query("SELECT
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdUsua,
tblc_usuario.IdOferta,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_moduloalumno.IdModulo,
tblc_usuario.Usuario,
tblc_usuario.Sexo
FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion

WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_moduloalumno.IdGrupo = '$IdGrupo'
AND tblp_moduloalumno.Inicio =  'REC'
GROUP BY
tblp_moduloalumno.IdUsua

");
    while($x = $db->recorrer($sql)){
      $gAlumns[] = $x;
    }
    return $gAlumns;
	}

	public function get_alumnosReinCor($IdGrupo,$IdCiclo){
		$db = new Conexion();

		$sql = $db->query("SELECT
tblp_moduloalumno.IdEducativa,
tblp_moduloalumno.IdUsua,
tblc_usuario.IdOferta,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_moduloalumno.IdModulo,
tblc_usuario.Usuario,
tblc_usuario.Sexo
FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion

WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_moduloalumno.IdGrupo = '$IdGrupo'
AND tblp_moduloalumno.Inicio =  'REI'
GROUP BY
tblp_moduloalumno.IdUsua

");
    while($x = $db->recorrer($sql)){
      $get_alumnosReinCor[] = $x;
    }
    return $get_alumnosReinCor;
	}

	public function get_alumnosB($IdGrupo){
		$db = new Conexion();

		$sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.Sexo
FROM
tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus <> 8 ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.Nombre ASC ");
    while($x = $db->recorrer($sql)){
      $gAlumnsB[] = $x;
    }
    return $gAlumnsB;
	}

  public function get_encabezado($IdAsignacion){
		$db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.Grupo, tblp_modulo.NoModulo, tblp_modulo.Grado, tblp_modulo.NombreMod, tblp_educativa.Clave, tblp_educativa.Ciclo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_educativa.Nombre AS NomEducativa, tblp_educativa.Tipo, tblc_ciclo.Ciclo AS cicloEscolar, tblc_ciclo.Anio, mesInicio.Mes AS mesIni, mesFin.Mes AS mesFin FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblh_meses AS mesInicio ON mesInicio.IdMes = tblc_ciclo.MesIni Left Join tblh_meses AS mesFin ON mesFin.IdMes = tblc_ciclo.MesFin WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while($x = $db->recorrer($sql)){
      $get_encabezado[] = $x;
    }
    return $get_encabezado;
  }

  public function get_acta($IdAsignacion){
		$db = new Conexion();
    $sql = $db->query("SELECT tblp_calificacionfinal.IdCalificacionF, tblp_calificacionfinal.Calificacion, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_calificacionfinal Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacionfinal.IdAlumno WHERE tblp_calificacionfinal.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.Nombre ASC");
    while($x = $db->recorrer($sql)){
      $get_acta[] = $x;
    }
    return $get_acta;
  }


	public function get_alumnosSexo($IdAsignacion,$sexo){
		$db = new Conexion();
		$sql = $db->query("SELECT Count(tblp_calificacionfinal.IdCalificacionF) AS Total, tblc_usuario.Sexo FROM tblp_calificacionfinal Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacionfinal.IdAlumno WHERE tblp_calificacionfinal.IdAsignacion =  '$IdAsignacion' AND tblc_usuario.Sexo =  '$sexo' GROUP BY tblc_usuario.Sexo ORDER BY tblc_usuario.Nombre ASC");
		while($x = $db->recorrer($sql)){
			$get_alumnosSexo[] = $x;
		}
		return $get_alumnosSexo;
	}

	public function get_alumSx($IdGrupo,$Sexo,$IdCiclo){
		$db = new Conexion();
		$sql = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total
FROM
tblc_usuario
WHERE
tblc_usuario.IdGrupo =  '$IdGrupo' AND
tblc_usuario.Sexo =  '$Sexo'  AND ( tblc_usuario.IdCiclo IS NULL  OR tblc_usuario.IdCiclo =  '$IdCiclo' ) ");
		while($x = $db->recorrer($sql)){
			$get_alumSx[] = $x;
		}
		return $get_alumSx;
	}



	public function get_alumSxF($IdGrupo,$Sexo,$IdCiclo){
		$db = new Conexion();
		$sql = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total
FROM
tblc_usuario
WHERE
tblc_usuario.IdGrupo =  '$IdGrupo' AND
tblc_usuario.Sexo =  '$Sexo' AND tblc_usuario.IdEstatus = '8'
");
		while($x = $db->recorrer($sql)){
			$get_alumSxF[] = $x;
		}
		return $get_alumSxF;
	}

	public function get_datosMenu($IdAsignacion){
		$db = new Conexion();
		$sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre, tblp_educativa.Modalidad, tblp_educativa.Tipo AS tipoCarrera, tblp_educativa.Ciclo, tblp_educativa.Rvoe, tblp_modulo.Grado AS numCuatrimestre, tblp_asignacion.IdEducativa FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Inner Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
		while($x = $db->recorrer($sql)){
			$get_datosMenu[] = $x;
		}
		return $get_datosMenu;
	}

	public function get_lstProm($IdUsua, $IdOferta, $IdModulo){
		$db = new Conexion();
// echo "SELECT tblp_moduloalumno.Promedio FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdEducativa = '$IdOferta' AND tblp_moduloalumno.IdModulo = '$IdModulo' AND tblp_moduloalumno.IdUsua = '$IdUsua'";
// echo "<br><br> ";
		$sql = $db->query("SELECT tblp_moduloalumno.Promedio FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdEducativa = '$IdOferta' AND tblp_moduloalumno.IdModulo = '$IdModulo' AND tblp_moduloalumno.IdUsua = '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_lstProm[] = $x;
		}
		return $get_lstProm;
	}

	public function get_acta_pro($IdUsua) {
        $db = new Conexion();
        $get_acta_pro = [];
        $sql = $db->query("SELECT * FROM tblp_acta WHERE tblp_acta.IdUsua = '$IdUsua'");
        while($x = $db->recorrer($sql)){
          $get_acta_pro[] = $x;
        }
        return $get_acta_pro;

      }

		public function get_caL_user($usuario) {
			$db = new Conexion();
			$get_caL_user = [];
			$sql = $db->query("SELECT
tblp_calificacion.Usuario,
tblp_calificacion.Promedio,
tblp_modulo.CodeModulo,
tblp_modulo.Grado,
tblp_modulo.Creditos,
tblp_modulo.NombreMod
FROM
tblp_calificacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
WHERE
tblp_calificacion.Usuario =  '$usuario'
ORDER BY
tblp_modulo.CodeModulo ASC
");
			while($x = $db->recorrer($sql)){
				$get_caL_user[] = $x;
			}
			return $get_caL_user;

		}

	public function get_menDatos($IdGrupo){
		$db = new Conexion();

		$sql6 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
	  $db->rows($sql6);
	  $datos61 = $db->recorrer($sql6);
	  $IdCampus = $datos61["IdCampus"];
	  $IdOferta = $datos61["IdOferta"];
		$get_menDatos = [];
		$sql = $db->query("SELECT
tblp_rvoe.IdRvoe,
tblp_rvoe.IdEducativa,
tblp_rvoe.IdCampus,
tblp_rvoe.Rvoe,
tblp_rvoe.Vigencia,
tblp_rvoe.Turno,
tblp_rvoe.Clave,
tblp_rvoe.Modalidad,
tblp_rvoe.Escuela,
tblp_rvoe.Localidad,
tblp_educativa.Nombre,
tblp_educativa.IdGrado,
tblc_campus.Campus
FROM
tblp_rvoe
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_rvoe.IdEducativa
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_rvoe.IdCampus
WHERE
tblp_rvoe.IdCampus =  '$IdCampus' AND tblp_rvoe.IdEducativa = '$IdOferta'
");
		while($x = $db->recorrer($sql)){
			$get_menDatos[] = $x;
		}
		return $get_menDatos;
	}

	public function get_datCiclo($IdCiclo){
		$db = new Conexion();
		$sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
		while($x = $db->recorrer($sql)){
			$gCicl8U[] = $x;
		}
		return $gCicl8U;
	}

	public function get_dat_grp_mod($IdGrupo){
		$db = new Conexion();

		$sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblp_grupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
 WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
		while($x = $db->recorrer($sql)){
			$gCicl8U[] = $x;
		}
		return $gCicl8U;
	}

	public function get_lstFir($IdCampus){
		$db = new Conexion();

		$sql = $db->query("SELECT * FROM tblc_firmas WHERE tblc_firmas.IdCampus = '$IdCampus'");
		while($x = $db->recorrer($sql)){
			$gCixcl8U[] = $x;
		}
		return $gCixcl8U;
	}

	public function get_fecha_imp($IdUsua){
		$db = new Conexion();
		$sql = $db->query("SELECT * FROM tblp_acta WHERE tblp_acta.IdUsua = '$IdUsua'");
		while($x = $db->recorrer($sql)){
			$get_fecha_imp[] = $x;
		}
		return $get_fecha_imp;
	}

	public function get_lstMateria($IdCiclo,$IdGrupo){
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
WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2' ORDER BY tblp_modulo.CodeModulo ASC");
		while($x = $db->recorrer($sql)){
			$gmATRS[] = $x;
		}
		return $gmATRS;
	}

	public function get_dAsignaturas($IdOferta, $grado){
		$db = new Conexion();
		$sql = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.Grado = '$grado'");
		while($x = $db->recorrer($sql)){
			$gAlumndyh[] = $x;
		}
		return $gAlumndyh;
	}

  public function get_datosacta($IdAsignacion){
		$db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdUsua,
tblp_modulo.NombreMod,
tblp_grupo.CveGrupo,
tblp_grupo.Grupo,
tblp_modulo.CodeModulo,
tblc_ciclo.Tipo,
tblp_modulo.Grado,
tblc_abreviatura.Abreviatura
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
    while($x = $db->recorrer($sql)){
      $gAlumnds6[] = $x;
    }
    return $gAlumnds6;
  }

  public function get_configuracion() {
		$db = new Conexion();
		$get_configuracion = [];
    $sql = $db->query("SELECT * FROM tblp_configuracion");
    while($x = $db->recorrer($sql)){
      $get_configuracion[] = $x;
    }
    return $get_configuracion;
  }

	public function get_carta($IdModulo) {
		$db = new Conexion();
    $sql = $db->query("SELECT
tblp_modulodatos.IdDatosM,
tblp_modulodatos.IdEducativa,
tblp_modulodatos.IdModulo,
tblp_modulodatos.Objetivo,
tblp_modulodatos.Tema,
tblp_modulodatos.Metodologia,
tblp_modulodatos.Evaluacion,
tblp_modulodatos.Bibliografia,
tblp_modulodatos.FecCap,
tblp_educativa.Nombre,
tblp_modulo.NombreMod
FROM
tblp_modulodatos
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulodatos.IdEducativa
Inner Join tblp_modulo ON tblp_modulo.IdModulo = tblp_modulodatos.IdModulo AND tblp_modulo.IdEducativa = tblp_modulodatos.IdEducativa
WHERE
tblp_modulodatos.IdDatosM =  '$IdModulo'
");
    while($x = $db->recorrer($sql)){
      $gCarta[] = $x;
    }
    return $gCarta;
  }

  public function get_certificado($id){
		$db = new Conexion();
    $sql = $db->query("SELECT tblp_calificacionfinal.IdCalificacionF, tblp_calificacionfinal.IdAsignacion, tblp_calificacionfinal.IdEducativa, tblp_calificacionfinal.IdModulo, tblp_calificacionfinal.IdAlumno, tblp_calificacionfinal.Calificacion, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_modulo.NombreMod, tblp_educativa.Nombre AS NomDiplomado, tblp_educativa.Tipo, tblp_asignacion.FecFin, tblp_educativa.Creditos FROM tblp_calificacionfinal Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacionfinal.IdAlumno Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacionfinal.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_calificacionfinal.IdEducativa Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_calificacionfinal.IdAsignacion WHERE tblp_calificacionfinal.IdCalificacionF = '$id' AND tblp_asignacion.Tipo =  '2'");
    while($x = $db->recorrer($sql)){
      $gCertifiv[] = $x;
    }
    return $gCertifiv;
  }

	public function get_datPlaneacion($IdAsignacion){
		$db = new Conexion();

    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdUsua,
tblp_asignacion.Plantel,
tblp_asignacion.Salon,
tblp_asignacion.HraDia,
tblp_asignacion.IdCampus,
tblp_asignacion.HraSemana,
tblp_asignacion.HraDoc,
tblp_asignacion.HraInd,
tblp_modulo.NombreMod,
tblp_modulo.Grado,
tblp_modulo.Oferta,
tblc_ciclo.MesIni,
tblc_ciclo.MesFin,
tblc_ciclo.FFinal,
tblp_modulodatos.Objetivo,
tblp_modulodatos.Introduccion,
tblp_asignacion.IdUsua,
tblp_modulo.CodeModulo,
tblp_grupo.CveGrupo,
tblp_grupo.IdGrupo,
tblp_grupo.Modalidad,
tblc_ciclo.Tipo
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_modulodatos ON tblp_modulodatos.IdModulo = tblp_asignacion.IdModulo AND tblp_modulodatos.IdEducativa = tblp_asignacion.IdEducativa
Inner Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
WHERE
tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdAsignacion = '$IdAsignacion'
");
    while($x = $db->recorrer($sql)){
      $gPlaneD[] = $x;
    }
    return $gPlaneD;
  }

	public function get_datGrados($IdUsua){
		$db = new Conexion();

    $sql = $db->query("SELECT * FROM tblp_gradodoc WHERE tblp_gradodoc.IdUsua = '$IdUsua' ORDER BY tblp_gradodoc.Grado DESC ");
    while($x = $db->recorrer($sql)){
      $gGradosLis[] = $x;
    }
    return $gGradosLis;
  }

	public function get_datGradoD($IdUsua){
		$db = new Conexion();
		$get_datGradoD = [];

    $sql = $db->query("SELECT
tblp_modulo.Grado
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
WHERE
tblp_moduloalumno.IdUsua =  '$IdUsua' ORDER BY tblp_moduloalumno.FecCap DESC LIMIT 1 ");
    while($x = $db->recorrer($sql)){
      $get_datGradoD[] = $x;
    }
    return $get_datGradoD;
  }


	public function get_updCiclo($Usuario){
		$db = new Conexion();
		$graIni = 0;
		$sql = $db->query("SELECT tblp_modulo.Grado, tblp_calificacion.IdCalificacion, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.Usuario =  '$Usuario' ORDER BY tblp_modulo.Grado DESC");
		while($x = $db->recorrer($sql)){
			$graIni = $x["Grado"];


			$graFin = $x["Grado"];
		}

	}

	public function get_datUsuario($Usuario){
		$db = new Conexion();
		$get_datUsuario = [];
    $sql = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.Sexo,
tblc_usuario.IdGrupo,
tblc_usuario.Folio,
tblp_grupo.CveGrupo,
tblp_grupo.TipoCiclo,
tblp_grupo.Periodo,
tblp_educativa.Nombre AS Educativa,
tblp_educativa.Rvoe,
tblp_educativa.Vigencia,
tblc_usuario.IdCampus,
tblc_usuario.IdOferta
FROM
tblc_usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.Usuario =  '$Usuario'");
    while($x = $db->recorrer($sql)){
      $get_datUsuario[] = $x;
    }
    return $get_datUsuario;
  }

	public function get_calificacion($Usuario, $IdOferta, $Grado){
		$db = new Conexion();
		$get_calificacion = [];

    $sql = $db->query("SELECT
tblp_calificacion.IdCalificacion,
tblp_calificacion.Promedio,
tblp_calificacion.E1,
tblp_calificacion.E2,
tblp_modulo.NombreMod,
tblp_modulo.Grado,
tblp_modulo.CodeModulo,
tblc_ciclo.Ciclo
FROM
tblp_calificacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
WHERE tblp_calificacion.Usuario =  '$Usuario' AND
tblp_calificacion.IdOferta =  '$IdOferta' AND
tblp_modulo.Grado =  '$Grado'
ORDER BY tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
      $get_calificacion[] = $x;
    }
    return $get_calificacion;
  }

	public function get_chkRep($Usuario, $IdOferta){
		$db = new Conexion();
    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion FROM tblp_calificacion WHERE tblp_calificacion.Usuario =  '$Usuario' AND tblp_calificacion.IdOferta <>  '$IdOferta' ");
    while($x = $db->recorrer($sql)){
			$IdCal = $x["IdCalificacion"];

			$insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
    }

		$IdModIni = 0;
		$IdModFin = 0;

		$sql2 = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdModulo FROM tblp_calificacion WHERE tblp_calificacion.Usuario =  '$Usuario' AND tblp_calificacion.IdOferta =  '$IdOferta' ORDER BY tblp_calificacion.IdModulo ASC");
    while($y = $db->recorrer($sql2)){
			$IdCal2 = $y["IdCalificacion"];
			$IdModIni = $y["IdModulo"];
			if($IdModIni == $IdModFin){
					$insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal2'");
			}
			$IdModFin = $y["IdModulo"];
    }


  }

  public function get_chkDup($Usuario, $IdOferta,$IdCampus){
		$db = new Conexion();

		$IdModIni = "";
		$IdModFin = "";

		$sql2 = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.IdCampus, tblp_modulo.NombreMod FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.Usuario = '$Usuario' AND tblp_calificacion.IdOferta = '$IdOferta' ORDER BY tblp_modulo.CodeModulo ASC");
    while($y = $db->recorrer($sql2)){
			 $IdCal2 = $y["IdCalificacion"];
			$IdModIni = substr($y["CodeModulo"], 0, 6);
			if($IdModIni == $IdModFin){

					$insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal2'");
			}
			$IdModFin = substr($y["CodeModulo"], 0, 6);
    }


  }


	public function get_datPlanCorp($IdAsignacion,$IdUsua){
		$db = new Conexion();


    $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.Plantel,
tblp_asignacion.Salon,
tblp_asignacion.IdCampus,
tblp_asignacion.HraDia,
tblp_asignacion.HraSemana,
tblp_asignacion.HraDoc,
tblp_asignacion.HraInd,
tblp_modulo.NombreMod,
tblp_modulo.Grado,
tblp_modulo.Oferta,
tblc_ciclo.Tipo,
tblc_ciclo.MesIni,
tblc_ciclo.MesFin,
tblc_ciclo.Ciclo,
tblc_ciclo.FFinal,
tblp_modulodatos.Objetivo,
tblp_modulodatos.Introduccion,
tblp_modulo.CodeModulo,
tblp_grupo.CveGrupo,
tblp_grupo.IdGrupo,
tblp_grupo.Modalidad,
tblp_grupo.Turno,
tblp_grupo.IdDia,
tblp_educativa.Nombre,
tblp_planeacion.Planeacion
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_planeacion ON tblp_planeacion.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblp_modulodatos ON tblp_modulodatos.IdModulo = tblp_asignacion.IdModulo
WHERE tblp_asignacion.Tipo = '2' AND tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_planeacion.IdUsua = '$IdUsua'
");
    while($x = $db->recorrer($sql)){
      $gPlaneD[] = $x;
    }
    return $gPlaneD;
  }


	public function get_datCosto($IdPlaneacion){
		$db = new Conexion();
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
tblp_planeacion.FecCambio,
tblp_planeacion.IdCampus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_planeacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_planeacion.IdUsua WHERE
tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");
    while($x = $db->recorrer($sql)){
      $gPlaneCsoto[] = $x;
    }
    return $gPlaneCsoto;
  }

	public function get_datAprob($IdUsua){
		$db = new Conexion();

    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gaPROVc[] = $x;
    }
    return $gaPROVc;
  }

	public function get_usuarioIdG($IdGrupo){
		$db = new Conexion();
    $sql = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.Educacion FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' ORDER BY tblc_usuario.APaterno ASC  ");
    while($x = $db->recorrer($sql)){
      $gaPROVFc[] = $x;
    }
    return $gaPROVFc;
  }

  public function get_no_par($IdAsignacion){
		$db = new Conexion();
    $sql = $db->query("SELECT tblp_asignacion.NoParcial, tblp_asignacion._texto FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'  ");
    while($x = $db->recorrer($sql)){
      $get_no_par[] = $x;
    }
    return $get_no_par;
  }


	public function get_datParcial($IdAsignacion){
		$db = new Conexion();
    $sql = $db->query("SELECT
tblp_parcialdocente.IdParcialDocente,
tblp_parcialdocente.Tema,
tblp_parcialdocente.Objetivo,
tblp_parcialdocente.IdUsua,
tblp_parcialdocente.FecIni,
tblp_parcialdocente.FecFin,
tblc_ciclo.MesIni,
tblp_parcialdocente.NoParcial
FROM
tblp_parcialdocente
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_parcialdocente.IdCiclo
WHERE
tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.Tipo='P'
");
    while($x = $db->recorrer($sql)){
      $gParcial[] = $x;
    }
    return $gParcial;
  }

	public function get_datBiblio($IdAsignacion){
		$db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_fuentedocente WHERE tblp_fuentedocente.IdAsignacion = '$IdAsignacion' LIMIT 11");
    while($x = $db->recorrer($sql)){
      $gBiblio[] = $x;
    }
    return $gBiblio;
  }

	public function get_datActividadesTS($IdAsignacion){
		$db = new Conexion();
    $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.IdSemanaDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.Porcentaje,
tblp_parcialdocente.NoParcial,
tblc_tipoactividad.TipoActividad
FROM
tblp_actividadesdocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad

WHERE
tblp_actividadesdocente.IdAsignacion = '$IdAsignacion'
");
    while($x = $db->recorrer($sql)){
      $gParcialDat[] = $x;
    }
    return $gParcialDat;
  }

	public function get_datSemana($IdParcialDoc){
		$db = new Conexion();
		$sql = $db->query("SELECT
tblp_semanadocente.IdSemanaDocente,
tblp_semanadocente.NoSemana,
tblp_semanadocente.Temas
FROM
tblp_semanadocente
WHERE
tblp_semanadocente.IdParcialDocente =  '$IdParcialDoc'
");
		while($x = $db->recorrer($sql)){
			$gSemana[] = $x;
		}
		return $gSemana;
	}

	public function get_datActividades($IdSemanaDoc){
		$db = new Conexion();

		$sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.IdTipoActividad,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.Porcentaje,
tblp_actividadesdocente.DesActividad,
tblc_tipoactividad.TipoActividad
FROM
tblp_actividadesdocente
Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
 WHERE tblp_actividadesdocente.IdSemanaDocente = '$IdSemanaDoc'");
		while($x = $db->recorrer($sql)){
			$gActividS[] = $x;
		}
		return $gActividS;
	}
	public function get_fuentedocente($IdParcial,$IdSemanaDoc) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_fuentedocente WHERE tblp_fuentedocente.IdParcialDocente = '$IdParcial' AND tblp_fuentedocente.IdSemanaDocente = '$IdSemanaDoc'");
    while($x = $db->recorrer($sql)){
      $getFuenteDoc[] = $x;
    }
    return $getFuenteDoc;
  }

	public function get_datNoSemana($IdParcialDoc) {
		$db = new Conexion();
		$sql = $db->query("SELECT Count(tblp_semanadocente.IdSemanaDocente) AS noSemana FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcialDoc'");
		while($x = $db->recorrer($sql)){
			$getNoSem[] = $x;
		}
		return $getNoSem;
	}

	public function get_datGrupo($IdGrupo) {
		$db = new Conexion();
		$sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
		while($x = $db->recorrer($sql)){
			$getFgts[] = $x;
		}
		return $getFgts;
	}

	public function get_datGrupoId($IdGrupo) {
		$db = new Conexion();
		$sql = $db->query("SELECT
tblc_campus.Campus,
tblp_educativa.Nombre,
tblp_grupo.CveGrupo,
tblp_grupo.Turno,
tblp_grupo.Modalidad
FROM
tblp_grupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
 WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
		while($x = $db->recorrer($sql)){
			$getFgts[] = $x;
		}
		return $getFgts;
	}

	public function get_lstPagPe($IdUsua) {
		$db = new Conexion();

		$sql = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Monto,
tblp_pagos.Fecha,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblp_pagos.IdCiclo,
tblp_pagos.IdConceptoPlan,
tblp_pagos.Descuento,
tblp_pagos.Recargos,
tblp_pagos.IdFolio,
tblp_pagos.Descuento2,
tblc_ciclo.Ciclo,
tblc_conceptosplanes.NomPlan,
tblc_estatus.Estatus,
tblp_pagos.IdEstatus
FROM
tblp_pagos
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
WHERE
tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus <> '4'  ORDER BY
tblc_ciclo.FInicio ASC, tblp_pagos.Fecha ASC
");
		while($x = $db->recorrer($sql)){
			$getFgtssd[] = $x;
		}
		return $getFgtssd;
	}

	public function get_lstCarDesc($IdUsua) { 
		$db = new Conexion();
    $Hoy = date("Y-m-d");
    $anioMes = date("Y-m");
    $mto = 0;

    $sql_beca = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Fecha, tblp_pagos.Monto, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus <> '4' ");
    while ($_bec = $db->recorrer($sql_beca)) {
      $IdPago = $_bec["IdPago"];
      $IdPlan = $_bec["IdConcepto"];
      $Monto = $_bec["Monto"];
      $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$IdPlan' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' ");
      $db->rows($sqlx9);
      $datosx91 = $db->recorrer($sqlx9);
      
      if (isset($datosx91['Porcentaje'])) {
		$IdBeca = $datosx91['IdBeca'];
      	$Porcentaje = $datosx91['Porcentaje'];

        $deta = ($Monto / 100);
        $descP = ($deta * $Porcentaje);
        $descP = $descP - $mto;
        //$insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '$descP', tblp_pagos.IdBeca = '$IdBeca' WHERE tblp_pagos.IdPago= '$IdPago' ");
      } else {
        //$insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '0' WHERE tblp_pagos.IdPago= '$IdPago' ");
      }
    }
	}


	public function get_lstGrupo($IdAsignacion) {
		$db = new Conexion();

		$sql = $db->query("SELECT
			tblp_moduloalumno.IdUsua,
			tblp_moduloalumno.ParcialF1,
			tblp_moduloalumno.ParcialF2,
			tblp_moduloalumno.ParcialF3,
			tblp_moduloalumno.ParcialF4,
			tblp_moduloalumno.E1,
tblp_moduloalumno.Promedio,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.Educacion
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50'))
ORDER BY
tblc_usuario.APaterno ASC,
tblc_usuario.AMaterno ASC,
tblc_usuario.Nombre ASC
");
		while($x = $db->recorrer($sql)){
			$getFgtsS[] = $x;
		}
		return $getFgtsS;
	}


	public function get_campA(){
		$db = new Conexion();
    $sql = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdZona = '1'");
    while($x = $db->recorrer($sql)){
      $gCampT[] = $x;
    }
    return $gCampT;
  }


	public function get_datMateria($IdAsignacion) {
		$db = new Conexion();


		$sql = $db->query("SELECT
			tblp_asignacion.IdAsignacion,
tblp_asignacion.IdGrupo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_ciclo.Ciclo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_educativa.Nombre AS Educativa,
tblp_grupo.CveGrupo,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
tblp_asignacion.Tipo =  '2'
");
		while($x = $db->recorrer($sql)){
			$getMatem[] = $x;
		}
		return $getMatem;
	}



}
?>
