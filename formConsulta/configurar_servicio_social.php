<?php
include('../hace.php');
if(isset($_POST["IdServicio"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdServicio = $_POST["IdServicio"];

  $sql_s = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdServicio = '$IdServicio' ");
  $db->rows($sql_s);
  $_serv = $db->recorrer($sql_s);
  ?>
  <form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

              <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre de la Dependencia / Institución / Organismo:</label>
                  <div class="col-sm-8">
                    <input type="text" name="txtDep" id="txtDep" class="form-control"  value="<?php echo $_serv["NomDependencia"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Progama del Servicio Social:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtPro" id="txtPro"  value="<?php echo $_serv["NomPrograma"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Periodo:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtPer" id="txtPer"  value="<?php echo $_serv["Periodo"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Fecha de impresión:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtFec" id="txtFec" value="<?php echo $_serv["FecImpresion"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Registro No:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="txtRegx" id="txtRegx" value="<?php echo $_serv["Registro"]; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Constancia de servicio social legalizada:</label>
                  <div class="col-sm-8">
                    <input type="file" onchange="validarPDF(this,'txt_constancia');" class="form-control" name="txt_constancia" id="txt_constancia">

                    <span class="input-group-btn">
                      <?php if($_serv["FecImpresion"]){ ?>
                      <button onclick="subir_constan(<?php echo $IdServicio; ?>)" type="button" class="btn btn-info btn-flat"><i class="fa fa-upload"></i> Subir constancia</button>
                      <?php } ?>
                      <?php if($_serv["Documento"]){ ?>
                        <button style="margin-left: 5px;" onclick="window.open('assets/docs/ServicioSocial/<?php echo $_serv['Documento']; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-warning btn-flat"><i class="fa fa-cloud-download"></i> Descargar constancia legalizada</button>

                      <?php } ?>
                    </span>

                  </div>
                </div>


                <div class="box-footer">


                  <?php if($_serv["FecImpresion"]){ ?>
                    <button type="button" onclick="add_doc_servicio(<?php echo $IdServicio; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-refresh"></i> Actualizar constancia</button>
                  <button style="margin-right: 10px;" type="button" onclick="window.open('repositorio/portafolio/constancia_servicio_social.php?tokenId=<?php echo time().$IdServicio; ?>','_blank')" href="javascript:void(0);" title="Imprimir constancia de servicio social" class="btn btn-danger pull-right"> <i class="fa fa-print"></i> Imprimir constancia</button>
                <?php } else { ?>
                  <button type="button" onclick="add_doc_servicio(<?php echo $IdServicio; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Generar constancia</button>
                <?php }?>
                </div>
              </div>
        </form>
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script>
        $(function () {
          //Date picker
          $('#txtFec').datepicker({
            autoclose: true
          })

        })

        function subir_constan(IdServicio){
            var Archivo = document.getElementById("txt_constancia").value;
            var Imagen = '#txt_constancia';

            if (Archivo ==""){
                swal("Error al guardar", "Debe seleccionar el archivo de la constancia de servicio social legalizado.", "error");
                return 0;
            }

            swal({
              title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: '#DD6B55',
              confirmButtonText: 'Aceptar',
              cancelButtonText: "Cancelar",
            },
            function (isConfirm) {
              if(isConfirm) {
        			$(".confirm").attr('disabled', 'disabled');

              var formData = new FormData();
              var files = $(Imagen)[0].files[0];
              formData.append('IdServicio',IdServicio);
              formData.append('file',files);

              $.ajax({
                  url: 'upload_constancia_ss.php',
                  type: 'post',
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {

        // alert(response);
                  }
              })
              .done(function(response) {
                if(response==1){
                  swal("Guardado correctamente", "El documento del servici social se ha guardado correctamente.", "success");
                  $.ajax({
              				 url:"formConsulta/configurar_servicio_social.php",
              				 method:"POST",
              				 data:{IdServicio:IdServicio},
              				 success:function(data){
              							$('#employee_detail3').html(data);
              							$('#dataModal3').modal('show');
              				 }
              		});
                }else{
                  swal("Error al guardar", "No se puede guardar los datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
              });


        		}
            });

        }
        </script>
  <?php
}
?>
