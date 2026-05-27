<?php
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Methods: POST');
  // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  header("Content-Type: application/json");
  require('../clases/class.System.php');
  $db = new Conexion();


  sleep(5);
  $_POST = json_decode(file_get_contents('php://input'),true);
  $_catalogo = $_POST['catalogo'];
  if($_catalogo == 'cat_campus'){
    $sql_campus = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdEstatus='8' ");
    $procesar = array();
    $procesar["campus"] = array();
    while($x = $db->recorrer($sql_campus)){
        $campus = array(
          'IdCampus' => $x['IdCampus'],
          'Campus' => $x['Campus']
        );
    array_push($procesar['campus'],$campus);
    }
    $procesar['valor']['IdEstatus'] = 8;
    echo json_encode($procesar);
    exit();
  } elseif($_catalogo == 'cat_plan'){
      $sql_campus_lst = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdEstatus='8' ");
      $procesar = array();
      $procesar["plan"] = array();
      while($_cam = $db->recorrer($sql_campus_lst)){
        $IdC = $_cam['IdCampus'];
        $sql_plan = $db->query("SELECT tblp_modulo.IdEducativa, tblp_modulo.IdCampus, tblp_educativa.IdGrado, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdC' GROUP BY tblp_modulo.IdEducativa ");

        while($_plan = $db->recorrer($sql_plan)){
          $campus = array(
            'IdOferta' => $_plan['IdEducativa'],
            'Oferta' => $_plan['Nombre'],
            'IdCampus' => $_plan['IdCampus'],
            'IdGrado' => $_plan['IdGrado']
          );
      array_push($procesar['plan'],$campus);
      }
      }
      $procesar['valor']['IdEstatus'] = 8;
      echo json_encode($procesar);
      exit();
  } elseif($_catalogo == 'cat_ciclo'){
    $sql_ciclo = $db->query("SELECT * FROM tblc_ciclo ");
    $procesar = array();
    $procesar["ciclo"] = array();
    while($x = $db->recorrer($sql_ciclo)){
        $campus = array(
          'IdCiclo' => $x['IdCiclo'],
          'Tipo' => $x['Tipo'],
          'Anio' => $x['Anio'],
          'Ciclo' => $x['Ciclo'],
          'FInicio' => $x['FInicio'],
          'FFinal' => $x['FFinal'],
          'IdEstatus' => $x['IdEstatus']
        );
    array_push($procesar['ciclo'],$campus);
    }
    $procesar['valor']['IdEstatus'] = 8;
    echo json_encode($procesar);
    exit();
  }elseif($_catalogo == 'cat_planpago'){
    $sql_plan = $db->query("SELECT tblc_conceptosplanes.IdConceptoPlanes, tblc_conceptosplanes.Code, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo, tblc_conceptosplanes.IdGrado, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Recargo, tblc_conceptosplanes.IdCampus, tblc_conceptos.NomConcepto FROM tblc_conceptosplanes Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosplanes.IdConcepto WHERE tblc_conceptos.Grado1 =  '1' ORDER BY tblc_conceptosplanes.IdConceptoPlanes ASC ");
    $procesar = array();
    $procesar["plan"] = array();
    while($x = $db->recorrer($sql_plan)){
        $campus = array(
          'IdConceptoPlanes' => $x['IdConceptoPlanes'],
          'Code' => $x['Code'],
          'NomPlan' => $x['NomPlan'],
          'Costo' => $x['Costo'],
          'IdGrado' => $x['IdGrado'],
          'IdConcepto' => $x['IdConcepto'],
          'IdCampus' => $x['IdCampus'],
          'NomConcepto' => $x['NomConcepto']
        );
    array_push($procesar['plan'],$campus);
    }
    $procesar['valor']['IdEstatus'] = 8;
    echo json_encode($procesar);
    exit();
  } else {
    echo json_encode(array('id_Estatus' => '10'));
  }

?>
