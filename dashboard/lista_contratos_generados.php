<?php
session_start();
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $Inicio = $_POST['Inicio'];
  $Final = $_POST['Final'];
  $IdCiclo = $_POST['IdCiclo'];
  
  // include('../hace.php');
  $datos = $t->get_contratos_docente($Inicio, $Final, $IdCiclo);
  $_mod88 = $t->get_mod_lista_id($_SESSION['IdUsua'], 88);
  $_mod89 = $t->get_mod_lista_id($_SESSION['IdUsua'], 89);

  ?>
  <div class="box-body">
  <div class="table-responsive">
    <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;">
      <thead>
        <tr>
          <th></th>
          <th>Contrato</th>
          <th>Docente</th>
          <th>Carrera </th>
          <th>Materia</th>
          <th>Grupo</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0;$i< sizeof($datos);$i++) { ?>
        <tr>
          <td width="90px">
          <?php if (isset($_mod88[0])) { ?>
          <button type="button" class="btn btn-info btn-flat" onclick="captura_informacion(<?php echo $datos[$i]['IdUsua']; ?>)"><i class="fa fa-fw fa-edit"></i></button>
          <?php } ?>
          <?php if (isset($_mod89[0])) { ?>
          <button type="button" title="Configurar contrato" class="btn btn-danger btn-flat"onclick="configurar_contrato('<?php echo $datos[$i]["IdAsignacion"]; ?>')"><i class="fa fa-fw fa-cog"></i></button>
          <?php } ?>
          </td>
          <td style="text-align: center;">
            <?php if($datos[$i]['contrato'] == 1){ echo "ACTIVO"; } ?>
            <?php if($datos[$i]['aceptado'] == 1){ echo "- ACEPTADO"; } ?>
           </td>
          <td><?php echo $datos[$i]['Nombre']; ?> <?php echo $datos[$i]['APaterno']; ?> <?php echo $datos[$i]['AMaterno']; ?>  </td>
          <td><?php echo $datos[$i]['Educativa']; ?></td>
          <td> <?php echo $datos[$i]['Grado']; ?>° <?php echo $datos[$i]['NombreMod']; ?></td>
          <td><?php echo $datos[$i]['CveGrupo']; ?></td>
          <td><?php echo $datos[$i]['FecIni']; ?> <?php echo $datos[$i]['FecFin']; ?> </td>
        </tr><?php } ?>
      </tfoot>
    </table>
  </div>
  </div>

  <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>

  <script>


function captura_informacion(IdUsua){
		$.ajax({
					url: "formConsulta/informacionDocente.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_info').html(data);
						$('#dataInfo').modal('show');
					}
				});
	}

  function configurar_contrato(IdAsignacion) {
		$.ajax({
			url: "formConsulta/generar_contrato.php",
			method: "POST",
			data: {
				IdAsignacion: IdAsignacion
			},
			success: function(data) {
				$('#employee_contrato').html(data);
				$('#data_contrato').modal('show');
			}
		});
	}

    
  </script>
