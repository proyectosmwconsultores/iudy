<?php $section = "Mi editor"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el editor de actividad'); }
if($_SESSION['Permisos']=="3") {

	$IdActividadDoc = substr($_GET["toks"], 10, 10);
	$IdParcialDoc = substr($_GET["tok"], 10, 10);

	$datosE=$t->get_datosEditor($_SESSION["IdUsua"],$_SESSION["IdAsignacion"],$IdParcialDoc,$IdActividadDoc);

	if(isset($_POST["Mov"]) && $_POST["Mov"]=="updEditor"){
		$t->get_addTreas();
		exit;
	}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link type="text/css" href="assets/editor/sample/css/sample.css" rel="stylesheet" media="screen" />
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo $AsignacionId[0]["NombreMod"];?>
		  </h1>

		</section>
		<section class="content">
			<form name="frm" id="frm" action="miEditor.php" method="POST" enctype="multipart/form-data">
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="Texto" name="Texto" value="" type="hidden"/>
				<input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActividadDoc; ?>" type="hidden"/>
				<input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $IdParcialDoc; ?>" type="hidden"/>
				<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
				<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
				<input id="IdEditor" name="IdEditor" value="<?php echo $datosE[0]["IdEditor"]; ?>" type="hidden"/>
				<input id="TipoGuardar" name="TipoGuardar" value="mi_Editor" type="hidden"/>

		  <div class="row">

				<div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editor de actividad</h3>
							<div class="btn-group" style="float: right;">
											<?php if($datosE[0]["IdEstatus"] == 12){ ?>
											<button type="button" onClick="add_reastdsa()" class="btn btn-success" ><i class="fa fa-fw fa-save"></i> Guardar</button>
                      <button type="button" onClick="add_envioEditor()" class="btn btn-info"> <i class="fa fa-fw fa-unlock"></i>Enviar trabajo</button>
											<?php } elseif($datosE[0]["IdEstatus"] == 2) { ?>
											<button type="button" class="btn btn-danger"> <i class="fa fa-fw fa-lock"></i>Trabajo enviado</button>
											<?php } elseif($datosE[0]["IdEstatus"] == 4) { ?>
											<button type="button" class="btn btn-info"> <i class="fa fa-fw fa-lock"></i>Trabajo Aprobado</button>
										<?php } elseif($datosE[0]["IdEstatus"] == 25) { ?>
											<button type="button" onClick="add_reastdsa()" class="btn btn-success" ><i class="fa fa-fw fa-save"></i> Actualizar</button>
                      <button type="button" onClick="add_envioEditor()" class="btn btn-info"> <i class="fa fa-fw fa-unlock"></i>Envia a revisi&oacute;n nuevamente</button>
											<?php } ?>
                    </div>
            </div>
            <div class="box-body">
							<main>

								<div class="centered">
									<div class="document-editor">
										<div class="toolbar-container"></div>
										<div class="content-container">
											<div id="editor" name="editor">

												<?php echo $datosE[0]["Texto"]; ?>
												</div>
										</div>
									</div>


								</div>
							</main>

            </div>

          	</div>

      		</div>

					<!-- <div class="col-md-3">
	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Comentariosde la actividad</h3>
	            </div>

	            <div class="box-body">



            <div class="box-body">

              <div class="direct-chat-messages">

                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                  </div>

                  <img class="direct-chat-img" src="assets/perfil/hombre.png" alt="Message User Image">
                  <div class="direct-chat-text" style="font-size: 12px;">
                    Is this template really for free? That's unbelievable!
                  </div>

                </div>

                <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                  </div>

                  <img class="direct-chat-img" src="assets/perfil/mujer.png" alt="Message User Image">
                  <div class="direct-chat-text" style="font-size: 12px;">
                    You better believe it!
                  </div>

                </div>

              </div>



              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Image">

                      <div class="contacts-list-info">
                            <span class="contacts-list-name">
                              Count Dracula
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                        <span class="contacts-list-msg">How have you been? I was...</span>
                      </div>

                    </a>
                  </li>

                </ul>

              </div>

            </div>

            <div class="box-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input name="message" placeholder="Type Message ..." class="form-control" type="text">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat">Send</button>
                      </span>
                </div>
              </form>
            </div>

	            </div>

	          	</div>

	      		</div> -->


              </div>
						</form>
            </div>
          </div>
        </div>
		  </div>
		</section>
	  </div>
	  <?php // include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="assets/editor/ckeditor.js"></script>

<script>
	DecoupledEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			const toolbarContainer = document.querySelector( 'main .toolbar-container' );

			toolbarContainer.prepend( editor.ui.view.toolbar.element );

			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>
</body>
</html>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);

 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
