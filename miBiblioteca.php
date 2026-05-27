<?php $section = "Biblioteca Digital"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está ingresando a la biblioteca digital'); }
$temas=$t->get_temas();
$lstBiblio=$t->get_lst_biblioteca($_POST["txtTema"]);
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Mi biblioteca digital
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
					<li class="active">Mi biblioteca</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="miBiblioteca.php" method="POST" enctype="multipart/form-data">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="box-primary">
                <div class="box-body">
                  <!-- <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
                    <i class="fa fa-home"></i> Inicio
                  </a> -->
                  <?php if($_SESSION["Permisos"] == 4653) { ?>
                  <!-- <a class="btn btn-app" onclick="window.open('addBilbioteca.php','_self')" href="javascript:void(0);">
                    <span class="badge bg-red">Nuevo</span>
                    <i class="fa fa-book"></i> Agregar
                  </a> -->
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="box-primary">
                <div class="box-body">
                  <div class="form-group">
                    <label>Tipo de infomaci&oacute;n:</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-server"></i></div>
                      <select class="form-control select2" name="txtTema" id="txtTema" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="document.frm.submit();">
                        <option value=""> - Seleccione - </option>
                        <?php for ($i=0;$i< sizeof($temas);$i++) { ?>
                          <option value="<?php echo $temas[$i]["IdTema"]; ?>"<?php if($_POST["txtTema"]==$temas[$i]["IdTema"]){?>selected="selected"<?php }?>><?php echo $temas[$i]["Descripcion"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

              <div class="col-md-12">
                <div class="box">
                  <div class="box-body">
                    <div class="box-body no-padding">
                      <div id="txtHint"></div>
                    </div>
                    <div name="tabla1" id="tabla1" style=" display: block;">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th></th>
                        <th>Nombre</th>
						<?php if($_SESSION["Permisos"] == 185){ ?>
                        <th></th><?php } ?>
                      </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($lstBiblio);$i++) { $IdR = $lstBiblio[$i]["IdBiblioteca"];
                        $_tip = $lstBiblio[$i]['Tipo'];
                        $_tem = $lstBiblio[$i]['IdTema'];
                        $_icono = "<i class='fa fa-fw fa-file-text'></i>";
                        if($_tem == 7){
                          if($_tip == 'youtube'){ $_icono = "<i class='fa fa-fw fa-youtube'></i>"; } else { $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>"; }
                        } else {
                          if($_tip == 'pdf'){ $_icono = "<i class='fa fa-fw fa-file-pdf-o'></i>"; } elseif($_tip == 'docx'){ $_icono = "<i class='fa fa-fw fa-file-word-o'></i>"; } elseif($_tip == 'xlsx'){ $_icono = "<i class='fa fa-fw fa-file-excel-o'></i>"; }
                        }
                    
                          ?>
                        <tr id="<?php echo $IdR; ?>">
                          <td width="50px;" style="text-align: center;">
                              <button onclick="verBiblioteca(<?php echo $lstBiblio[$i]['IdBiblioteca']; ?>)" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat"> <?php echo $_icono; ?> </button>
						</td>
                          <td><?php echo $lstBiblio[$i]["Nombre"]; ?></td>
                          
						
						<?php if($_SESSION["Permisos"] == 185){ ?>
                          <td width="50px;" style="text-align: center;"><button onClick="val_recursoApoyo(<?php echo $IdR; ?>)" href="javascript:void(0);" name="add" id="add" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button></td>
                        </tr><?php } } ?>
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </form>
    <div id="dataBli"  class="modal fade"> <!--MODAL ME GUSTA-->
     <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_bib'></b></h4>
           </div>
           <div class="modal-body" id="employee_bli">
           </div>
        </div>
     </div>
  </div>
    </section>

		</div>
	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
function val_recursoApoyo(Id){
	$.ajax({
			 url:"formConsulta/delRecurso.php",
			 method:"POST",
			 data:{Id:Id},
			 success:function(data){
				// alert(data);
						var valor = 0;
						valor = data;
						if(valor == 1){
							document.getElementById(Id).style.display = 'none';
										swal("Eliminado", "RECURSO ELIMINADO CON ÉXITO", "success");
						} else{

							swal("Error", "NO SE PUDO ELIMINAR RECURSO", "error");

						}
			 }
	});
}

function verBiblioteca(IdBiblioteca){
  $.ajax({
       url:"formConsulta/verDocumento.php",
       method:"POST",
       data:{IdBiblioteca:IdBiblioteca},
       success:function(data){
            $('#employee_bli').html(data);
            $('#dataBli').modal('show');
       }
  });
}


  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>
