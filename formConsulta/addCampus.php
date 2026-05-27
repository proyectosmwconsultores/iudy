<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

$sql_asig = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.Anio =  '2024' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Fecha_impresion IS NOT NULL  ");
while ($x = $db->recorrer($sql_asig)) {
  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '10' WHERE tblp_calificacion.IdAsignacion = '".$x['IdAsignacion']."' ");
}



$sql = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.Anio = '2023' AND tblp_biblioteca.Mes = '06' LIMIT 100 ");
    while ($x = $db->recorrer($sql)) {
         $nombre = $x["Nombre"];
          $directorio_raiz = $_SERVER['DOCUMENT_ROOT'] . "/assets/biblioteca/"; // Ruta física en el servidor
         
         //$directorio_raiz = "https://sciudy.com/assets/biblioteca/"; // Reemplaza con tu ruta real en el servidor
         $archivo = $directorio_raiz . $x["Anio"] . '/' . $x["Mes"] . '/' . $x["Link"];
         
         if (file_exists($archivo)) {
            // Intentamos eliminar el archivo
            if (unlink($archivo)) {
                //echo "1 El archivo $archivo ha sido eliminado con éxito.";
                // Ejecutar la consulta de eliminación en la base de datos
                $insertar = $db->query("DELETE FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '".$x['IdBiblioteca']."' ");
            } else {
                echo "2 Hubo un error al intentar eliminar el archivo $archivo.";
            }
        } else {
            echo "El archivo $archivo no existe.";
        }


    }
    





  ?>
  
  
  <form name="frm2sFr" id="frm2sFr" action="updFuente.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="TipoGuardar" id="TipoGuardar" value="addCampusNew">
    <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del nuevo campus / escuela:</label>
                <input name="txtCampus" id="txtCampus" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre público del campus:</label>
                <input name="txtDireccion" id="txtDireccion" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-success pull-right" onClick="addCampus()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
