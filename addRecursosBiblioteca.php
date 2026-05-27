<?php
include("head.php");

if($_SESSION['IdUsua'])
	{
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Ingresa para subir recurso a la biblioteca digital');
	}

?>

<script type="text/javascript">

$(document).ready(function(){

	$("#form1").validate({
		rules:{
			txtDescripcion:"required",
			archivo_1:"required"
		},
		messages:{
			txtDescripcion:{
				required:"Obligatorio"
			},
			archivo_1:{
				required:"Obligatorio"
			},
		}
	});

	$("#Enviar").click(function(){
		//window.parent.jQuery.popupbox.onResizePopupbox();
		if($("#form1").valid()==true)
			$("#form1").submit();
	});
});

	function check_file(){

		str=document.getElementById('archivo_1').value.toUpperCase();

        extension="PDF";

        if(str.indexOf(extension, str.length - 3) == -1)
        {
        alert('Solo puede subir archivos PDF');
            document.getElementById('archivo_1').value='';
        }
    }

</script>
</head>

<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">

  <?php
  	include("menuV.php");
  	?>
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
	<!-- Inicia sección de código -->

			<?php $valort = 0;
					if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
					{

								if($_FILES['archivo_1']['error'] == UPLOAD_ERR_OK)
								{
									$directorio = "assets/biblioteca/";
									// Copiamos el archivo
									move_uploaded_file($_FILES['archivo_1']['tmp_name'],$directorio.$_FILES['archivo_1']['name']);

									//$directorio = $directorio. $_FILES['archivo_1']['name'];
									$directorio = $_FILES['archivo_1']['name'];
									// Guardamos el datos en la Bdd

									$query = "SELECT MAX(IdBiblioteca) FROM tblp_biblioteca";

									$result = mysql_query($query ,Conectar::con());
									$row 	= mysql_fetch_array($result);

									(is_null($row[0]))?$idDocumento=1:$idDocumento= $row[0] + 1;

									$idTema = $_REQUEST['tema'];
									$Descripcion = $_POST['txtDescripcion'];
									$autor = $_POST['txtAutor'];
									$txtObra = $_POST['txtObra'];
									$Idusua = $_POST['IdUsua'];

									// $strSQL = "INSERT INTO tblp_documentos  VALUES ($idDocumento, $idTema, '$txtObra', '$directorio',  '$Descripcion ', '$autor ',1)";
									// $insrtDocumento = mysql_query($strSQL,Conectar::con());
									$strSQL = "INSERT INTO tblp_biblioteca  VALUES ($idDocumento,'0','$txtObra','$Descripcion', '$directorio','0','$autor',$idTema,'$Idusua',NOW())";
									$insrtDocumento = mysql_query($strSQL,Conectar::con());

									// Guardamos el dato en el LOG del Sistema
									$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Sube un documento a la biblioteca Digital <b>$txtObra</b>');
									$valort = 1;
									// echo "
									// 		<br>
									// 		<center> <font color=RED> <h3>Se ha insertado correctamen el Documento a la Biblioteca Digital</font></h3> </center>
									// 		<br><br>
									//
									// 		";
								} // Fin de Checa upload


				} // fin de if(POST)
			?>
			<?php if($valort == 1){ ?>
			<div class="alert alert-danger alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <h4><i class="icon fa fa-info"></i> Bibkioteca Digital</h4>
			                Se ha insertado correctamen el Documento a la Biblioteca Digital.
			              </div>
									<?php } ?>
			<div class="box box-default">
        <div class="box-body">
          <div class="row">

        <form action="addRecursosBiblioteca.php" name="form1" id="form1" method="post" enctype="multipart/form-data">
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
					<div class="col-md-4">
						<div class="box-primary">
							<div class="box-body">
							<div class="form-group">
								<label>Clasificaci&oacute;n:</label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-book"></i></div>
									<select class="form-control select2 select2-hidden-accessible" name="tema" id="tema" style="width: 100%;" tabindex="-1" aria-hidden="true">
										<option value=""> - SELECCIONE - </option>
										<?php
												$sqlTmp = "SELECT * FROM tblp_temas WHERE tblp_temas.Tipo = '1' ORDER BY IdTema";
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
					<div class="col-md-8">
    			  <div class="box-primary">
    				  <div class="box-body">
    					<div class="form-group">
    						<label>Autor</label>
    						<div class="input-group">
    						  <div class="input-group-addon"><i class="fa fa-street-view"></i></div>
    						  <input class="form-control" name="txtAutor" id="txtAutor" maxlength="150" size="80" type="text">
    						</div>
    					</div>
    				  </div>
    			  </div>
    			</div>
					<div class="col-md-6">
    			  <div class="box-primary">
    				  <div class="box-body">
    					<div class="form-group">
    						<label>Nombre de la Obra y/o Libro:</label>
    						<div class="input-group">
    						  <div class="input-group-addon"><i class="fa fa-qrcode"></i></div>
    						  <input class="form-control" name="txtObra" id="txtObra" maxlength="150"  size="90" type="text">
    						</div>
    					</div>
    				  </div>
    			  </div>
    			</div>
					<div class="col-md-6">
    			  <div class="box-primary">
    				  <div class="box-body">
    					<div class="form-group">
    						<label>Descripci&oacute;n:</label>
    						<div class="input-group">
    						  <div class="input-group-addon"><i class="fa fa-qrcode"></i></div>
    						  <input class="form-control" name="txtDescripcion" id="txtDescripcion" maxlength="250" size="110" type="text">
    						</div>
    					</div>
    				  </div>
    			  </div>
    			</div>
					<div class="col-md-12">
    			  <div class="box-primary">
    				  <div class="box-body">
    					<div class="form-group">
    						<label>Archivo:</label>
    						<div class="input-group">
    						  <div class="input-group-addon"><i class="fa fa-file"></i></div>
    						  <input type="file" name="archivo_1" id="archivo_1" onchange="check_file()">
    						</div>
    					</div>
    				  </div>
    			  </div>
    			</div>
					<div class="col-md-12">
            <div class="box-primary">
              <div class="box-body">
              <div class="box-footer" style=" text-align: center;">
                <button type="button" class="btn btn-info" onClick="window.open('bibliotecaDigital.php','_self')" href="javascript:void(0);"> <i class="fa fa-fw fa-rotate-left"></i> REGRESAR</button>
                <button class="btn btn-primary" type="submit" name="Enviar" id="Enviar" value="Agregar Documento" > <i class="fa fa-save"></i> GUARDAR DOCUMENTO</button>
              </div>
              </div>
            </div>
        	</div>
        </form>
			</div>
		</div>
			</div>
				</section>
    </div>

<?php include("footer.php"); ?>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
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
    $('.select2').select2()
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

//Money Euro
    $('[data-mask]').inputmask()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

</body>
</html>
