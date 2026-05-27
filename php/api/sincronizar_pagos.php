<?php
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Methods: POST');
  // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  header("Content-Type: application/json");
  require('../clases/class.System.php');
  $db = new Conexion();

  $_POST = json_decode(file_get_contents('php://input'),true);
  $_catalogo = $_POST['catalogo'];
  if($_catalogo){
    $sql_pag = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.TotalPagado, tblc_conceptosplanes.IdConcepto FROM tblp_pagos Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_pagos.IdActividad =  '$_catalogo' AND tblp_pagos.IdEstatus = '4' ");
    $procesar = array();
    $procesar["pagos"] = array();
    while($x = $db->recorrer($sql_pag)){
        $pagos = array(
          'IdUsua' => $x['IdUsua'],
          'TotalPagado' => $x['TotalPagado'],
          'IdConcepto' => $x['IdConcepto']
        );
    array_push($procesar['pagos'],$pagos);
    }
    $procesar['valor']['IdEstatus'] = 8;
    echo json_encode($procesar);
    exit();
  } else {
    echo json_encode(array('id_Estatus' => '10'));
  }

?>
