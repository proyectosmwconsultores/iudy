<?php
session_start();
require('php/clases/class.php');
$t=new Trabajo();

if($_GET['Tipo'] == 'alumno'){
  if($_GET['Buscar']){
    // $IdCampus = $_GET['IdCampus'];
    $buscar = $_GET['Buscar'];
    $IdUsua = $_GET['IdUsua'];
    $Estatus = $_GET['Estatus'];
    $buscarFolioIdx=$t->get_buscarAlumno($buscar,$IdUsua,$Estatus);
  }
}elseif($_GET['Tipo'] == 'alumnoBuscar'){
  if($_GET['Buscar']){
    $IdCampus = $_GET['IdCampus'];
    $buscar = $_GET['Buscar'];
    $buscarFolioIdx=$t->get_buscar_alumno($buscar);
  }
} elseif($_GET['Tipo'] == 'bus_mod'){
  if($_GET['Buscar']){
    $buscar = $_GET['Buscar'];
    $IdUsua = $_SESSION['IdUsua'];
    $buscarFolioIdx=$t->get_bus_mod_user($buscar,$IdUsua);
  }
} elseif($_GET['Tipo'] == 'asesor'){
  if($_GET['Buscar']){
    $IdCampus = $_GET['IdCampus'];
    $buscar = $_GET['Buscar'];
    $buscarAsesor=$t->get_buscarAsesor($buscar,$IdCampus);
  }
}elseif($_GET['Tipo'] == 'planeacion'){
  if($_GET['Buscar']){
    $IdCampus = $_GET['IdCampus'];
    $buscar = $_GET['Buscar'];
    $buscarAsesor=$t->get_buscarPlaneacion($buscar,$IdCampus);
  }
}
elseif($_GET['Tipo'] == 'Asignatura'){
  if($_GET['Buscar']){

    $IdTema = $_GET['Buscar'];
    $buscarAsig=$t->get_buscarAsignatura($IdTema);
  }
}elseif($_GET['Tipo'] == 'buscUsers'){
  if($_GET['Buscar']){
    $IdCampus = $_GET['IdCampus'];
    $IdPermiso = $_GET['IdPermiso'];
    $IdUsua = $_GET['IdUsua'];
    $buscar = $_GET['Buscar'];
    $buscarAsesor=$t->get_buscarUsers($buscar,$IdCampus,$IdUsua,$IdPermiso);
  }
}elseif($_GET['Tipo'] == 'usuario_plataform'){
  if($_GET['Buscar']){
    $buscar = $_GET['Buscar'];
    $buscarFolioIdx=$t->get_buscar_users($buscar);
  }
}elseif($_GET['Tipo'] == 'buscar_datos_alumno'){
  if($_GET['Buscar']){
    $buscar = $_GET['Buscar'];
    $IdTemporal = $_GET['IdTemporal'];
    
    $buscarFolioIdx=$t->get_buscar_alumno_conciliar($buscar,$IdTemporal);
  }
}



?>
