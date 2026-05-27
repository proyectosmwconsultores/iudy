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
    $sql_pag = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_usuario.id_ciclo_ini, tblc_estatus.Estatus, tblc_usuario.fecha_baja, tblc_usuario.IdEstatus, tblp_grupo.Dia, tblp_grupo.CveGrupo FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.id_paquete = 'CRM' AND tblc_usuario.id_ciclo_ini = '$_catalogo' ORDER BY tblc_usuario.IdUsua DESC  ");
    $procesar = array();
    $procesar["pagos"] = array();
    while($x = $db->recorrer($sql_pag)){
        $pagos = array(
          'IdUsua' => $x['IdUsua'],
          'IdOferta' => $x['IdOferta'],
          'IdCiclo' => $x['id_ciclo_ini'],
          'Estatus' => $x['Estatus'],
          'IdEstatus' => $x['IdEstatus'],
          'Dia' => $x['Dia'],
          'CveGrupo' => $x['CveGrupo'],
          'IdCampus' => $x['IdCampus'],
          'Fecha' => $x['fecha_baja']
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
