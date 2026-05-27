<?php
require('class.System.php');
class Class_openpay {

  public function validar_datos_pago($IdPago,$IdUsua) {
    $db = new Conexion();
    $validar_datos_pago = [];

    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos._link, tblp_pagos._fecha FROM tblp_pagos WHERE tblp_pagos.IdEstatus = '1' AND tblp_pagos.IdPago = '$IdPago' AND tblp_pagos.IdUsua =  '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $validar_datos_pago[] = $x;
    }
    return $validar_datos_pago;
	}

  public function obtener_pago_id($IdPago) {
    $db = new Conexion();
    $obtener_pago_id = [];
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Monto, tblp_pagos.Fecha, tblp_pagos.IdEstatus, tblp_pagos.Recargos, tblp_pagos.TotalPagado, tblc_conceptos.NomConcepto, tblp_pagos.Descuento, tblp_pagos.Descuento2 FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdPago =  '$IdPago'");
    while($x = $db->recorrer($sql)){
      $obtener_pago_id[] = $x;
    }
    return $obtener_pago_id;
	}

  public function obtener_usuario_id($IdUsua) {
    $db = new Conexion();
    $obtener_usuario_id = [];
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $obtener_usuario_id[] = $x;
    }
    return $obtener_usuario_id;
	}

  public function update_estatus_pago($IdPago, $total) {
    $db = new Conexion();
    $sql = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '4', tblp_pagos.TotalPagado = '$total' WHERE tblp_pagos.IdPago = '$IdPago'");
  }
  
  public function update_estatus_pago_link($IdPago, $link, $id) {
    $db = new Conexion();
    $hoy = date("Y-m-d");
    $sql = $db->query("UPDATE tblp_pagos SET tblp_pagos._fecha = '$hoy', tblp_pagos._id = '$id', tblp_pagos._link = '$link' WHERE tblp_pagos.IdPago = '$IdPago'");
  }


}
 
?>
