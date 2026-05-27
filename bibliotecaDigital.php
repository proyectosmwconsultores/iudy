<?php


include("head.php");

if($_SESSION['IdUsua'])
	{
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está Ingresando a la biblioteca digital');
	}

?>

<script language="JavaScript">
	function functiongoTo(cadena)
	{
		window.open(cadena,'_blank','toolbar=yes,scrollbars=yes,resizable=no,top=500,left=500,width=900,height=600');
	}
</script>


<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Biblioteca Digital
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> INICIO</a></li>
        <li class="active">Biblioteca Digital</li>
      </ol>
    </section>

    <section class="content">
			<div class="box box-default">
        <div class="box-body">
          <div class="row">
							<form name="frm" id="frm" action="bibliotecaDigital.php" method="POST" enctype="multipart/form-data">
            <div class="col-md-8">
              <div class="box-primary">
                <div class="box-body">
                  <a class="btn btn-app" onclick="window.open('inicio.php','_self')" href="javascript:void(0);">
                    <i class="fa fa-rotate-left"></i> Regresar
                  </a>
									<?php if($_SESSION["Permisos"] != 3){ ?>
									<a class="btn btn-app" onclick="window.open('addRecursosBiblioteca.php','_self')" href="javascript:void(0);">
		                <span class="badge bg-blue">Nuevo</span>
		                <i class="fa fa-book"></i> Agregar
		              </a>
									<?php } ?>
                </div>
              </div>
            </div>
						<div class="col-md-4">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Clasificaci&oacute;n:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
                    <select class="form-control select2 select2-hidden-accessible" name="tema" id="tema" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="document.frm.submit();">
                      <option value=""> - SELECCIONE - </option>
											<?php
													$sqlTmp = "SELECT * FROM tblp_temas WHERE tblp_temas.Tipo='1' ORDER BY IdTema";
													$resultado = mysql_query($sqlTmp,Conectar::con());
													while ($row = mysql_fetch_array($resultado)) { ?>
														<option value="<?php echo $row['IdTema']; ?>"<?php if($_POST[tema]==$row['IdTema']){?>selected="selected"<?php }?>><?php echo utf8_encode($row['Descripcion']); ?></option>
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
                        <th>Descargar</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Autor</th>
                      </tr>
                      </thead>
											<?php
		                		if(isset($_POST['tema']) && ($_POST['tema'] != ""))
		                		{
									$idTema = $_POST['tema'];
									//echo	$query_srcListado = "Select NombreDocto, NombreCarpeta, D.Descripcion, T.Descripcion as Tema, D.autor, D.NombreCarpeta from tblp_documentos D inner join tblp_temas T on (D.IdTema=T.IdTema) WHERE Status=1 and D.IdTema=$idTema ORDER BY D.IdDocumento DESC";
									$query_srcListado = "SELECT
tblp_biblioteca.IdBiblioteca,
tblp_biblioteca.Nombre,
tblp_biblioteca.Descripcion,
tblp_biblioteca.Link,
tblp_biblioteca.Autor,
tblp_biblioteca.IdTema,
tblp_temas.Descripcion AS Tema
FROM
tblp_biblioteca
Left Join tblp_temas ON tblp_temas.IdTema = tblp_biblioteca.IdTema WHERE tblp_biblioteca.IdTema = '$idTema'";
		                		//}else{

								// echo 	$query_srcListado = "Select
								// 						NombreDocto,
								// 						NombreCarpeta,
								// 						D.Descripcion,
								// 						T.Descripcion as Tema,
								// 						D.autor,
								// 						D.NombreCarpeta
								// 					FROM
								// 						documentos D
								// 						inner join
								// 						tblp_temas T
								// 						on
								// 						(D.IdTema =  T.IdTema)
								// 					WHERE
								// 						Status=1
								// 					ORDER BY
								// 						D.IdTema,D.IdDocumento
								// 					";

		                //		}

								$srcListado	=	mysql_query($query_srcListado,Conectar::con());
							while($row_srcListado = mysql_fetch_array($srcListado))
							{
							?>
                      <tbody>
                        <tr>
                          <td><?php echo "<a href=\"#\" onclick=\"functiongoTo('assets/biblioteca/{$row_srcListado[3]}');\"><button type='button' class='btn bg-navy btn-sm' title='Descargar archivo'><i class='fa fa-fw fa-cloud-download'></i></button></a>"; //echo "<a href=\"#\" onclick=\"functiongoTo('{$row_srcListado[5]}');\"><img src= \"assets/download.png\" width=\"40\" height=\"40\" title=\" Descargar \"></a>"; ?>
													</td>
                          <td><b><?php echo $row_srcListado[1]; ?> </b></td>
                          <td><?php echo "<a href=\"#\" onclick=\"functiongoTo('assets/biblioteca/{$row_srcListado[3]}');\">". $row_srcListado[2]."</a>"; ?></td>
                          <td><?php echo utf8_encode($row_srcListado[4]); ?></td>
                        </tr>
                      </tbody>
										<?php } } // fin de while($row_srcListado = sqlsrv_fetch_array($srcListado)); ?>

                    </table>
                  </div>
                  </div>
                </div>
              </div>




</form>
          </div>
        </div>
      </div>



	<!-- Inicia sección de código -->





</div>

  <?php
  	include("footer.php");
  ?>


</div>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

$(function () {
  $('#example1').DataTable()
})

$(function () {
    $('.select2').select2()
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  })

</script>

</body>
</html>
