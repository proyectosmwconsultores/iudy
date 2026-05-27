<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];

  $sql_rec1 = $db->query("SELECT tblp_biblioteca.IdBiblioteca, tblp_biblioteca.IdAsignacion, tblp_biblioteca.Nombre, tblp_biblioteca.Descripcion, tblp_biblioteca.Link, tblp_biblioteca.Code, tblp_biblioteca.Anio, tblp_biblioteca.Mes, tblp_biblioteca.IdTema, tblp_temas.Descripcion AS Tema FROM tblp_biblioteca Left Join tblp_temas ON tblp_temas.IdTema = tblp_biblioteca.IdTema WHERE tblp_biblioteca.IdAsignacion = '$idAsignacion'");

  $sql9_r = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdGrupo, tblp_grupo.CveGrupo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$idAsignacion' AND tblp_asignacion.Tipo =  '2'");
  $db->rows($sql9_r);
  $datos91 = $db->recorrer($sql9_r);
  $Nombre = $datos91["NombreMod"];
  $IdOferta = $datos91["IdEducativa"];
  $Cve = substr($datos91["CveGrupo"], 5,1);
  if($Cve == "E"){
    $kst = "Escolar";
  } else {
    $kst = "No escolar";
  }

  $sql_rec2 = $db->query("SELECT tblp_archivo.IdArchivo, tblp_archivo.IdOferta, tblp_archivo.IdModulo, tblp_archivo.Nombre, tblp_archivo.Link, tblp_archivo.IdUsua, tblp_archivo.FecCap, tblp_archivo.Tipo, tblp_modulo.NombreMod FROM tblp_archivo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_archivo.IdModulo WHERE tblp_archivo.IdOferta = '$IdOferta' AND tblp_modulo.NombreMod = '$Nombre' AND tblp_archivo.Tipo = '$kst'");

  ?>
  <div class="box-body">
    <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-primary">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/recurso.png" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">MIS MATERIALES DIDÁCTICOS</h3>
              <h5 class="widget-user-desc">Lista de materiales didácticos disponibles</h5>
            </div>
            <div class="box-footer no-padding">
              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Tipo material</th>
                  <th>Nombre</th>
                  <th>Descargar</th>
                </tr>
                <?php $n_r = 0;  while($rec1 = $db->recorrer($sql_rec1)){ ?>
                <tr>
                  <td><?php echo $n_r = $n_r + 1; ?></td>
                  <td><?php echo $rec1['Descripcion']; ?></td>
                  <td><?php echo $rec1['Nombre']; ?></td>
                  <td>
                    <?php if($rec1["IdTema"]=="7") { ?>
      								<button type="button" class="btn btn-danger view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="<?php echo $rec1["IdBiblioteca"]; ?>"><i class="fa fa-youtube-play"></i></button>
      							<?php } else { ?>
      							<a onClick="window.open('assets/biblioteca/<?php echo $rec1["Anio"].'/'.$rec1["Mes"]; ?>/<?php echo $rec1["Link"] ?>','_blank')" href="javascript:void(0);"><button type="button" class="btn btn-default"><i class="fa fa-cloud-download"></i></button></a>
      							<?php } ?>
                  </td>
                </tr>
                <?php } ?>

              </tbody></table>
            </div>
          </div>


  </div>
  <div id="dataModal_Rec" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
             <div class="modal-content">
                  <div class="modal-body" id="employee_detail_Rec">
                  </div>
             </div>
        </div>
   </div>

<script>
$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewVideo.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail_Rec').html(data);
												 $('#dataModal_Rec').modal('show');
										}
							 });
					}
		 });
});
</script>
