<?php session_start();
require('../../php/clases/class_practicas.php');
$practicas = new Class_practicas();
$IdUsua = $_POST['IdUsua'];
$IdAviso = $_POST['IdAviso'];
$IdDetalle = $_POST['IdDetalle'];
$Tipo = $_POST['Tipo'];

$lst = $practicas->inscripcion_practicas_id($IdUsua, $IdDetalle,$IdAviso);
$user = $practicas->usuario_id($IdUsua);
$gestion = $practicas->get_gestion_escolar();
$est=$practicas->get_estados();
?>

<div class="box box-primary">
<form method="POST" enctype="multipart/form-data" class="form-horizontal">  
<input type="hidden" name="_idUsua" id="_idUsua" value="<?php echo $_SESSION["IdUsua"]; ?>">
<input type="hidden" name="IdEsta_D" id="IdEsta_D" value="<?php echo $user[0]["D_estado"]; ?>">
<input type="hidden" name="IdMuni_D" id="IdMuni_D" value="<?php echo $user[0]["D_municipio"]; ?>">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-user"></i> Mis datos personales como alumno</h3>
  </div>
  <div class="box-body">
    
    <div class="form-group">
      <label class="col-sm-2 control-label">Domicilio:</label>
      <div class="col-sm-10">
        <input class="form-control" onchange="verificar_texto(this,'txt_direccion')" type="text" name="txt_direccion" id="txt_direccion" value="<?php echo $user[0]['D_direccion']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Estado:</label>
      <div class="col-sm-4">
        <select class="form-control" name="txt_estado" id="txt_estado" onchange="cargar_municipio()">
          <option value=""> - Seleccione - </option>
          <?php for ($i=0;$i< sizeof($est);$i++) { ?>
          <option value="<?php echo $est[$i]["IdEstado"]; ?>" <?php if(isset($info[0]["Estado"])){ if($info[0]["Estado"]==$est[$i]["IdEstado"]){?>selected="selected"<?php } } ?> > <?php echo $est[$i]["Estado"] ?> </option>
          <?php } ?>
        </select>
      </div>
      <label class="col-sm-2 control-label">Localidad:</label>
      <div class="col-sm-4">
        <select class="form-control" name="txt_municipio" id="txt_municipio">
          <option value="">Seleccione</option>
          <option></option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">CP:</label>
      <div class="col-sm-4">
      <input class="form-control" type="text" maxlength="5" onchange="verificar_numero(this,'txt_cp_alumno')" name="txt_cp_alumno" id="txt_cp_alumno" value="<?php echo $user[0]['D_cp']; ?>">
      </div>
      <label class="col-sm-2 control-label">Mi celular:</label>
      <div class="col-sm-4">
      <input class="form-control" type="text" maxlength="10" onchange="verificar_numero(this,'txt_celular')" name="txt_celular" id="txt_celular" value="<?php echo $user[0]['Celular']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Mi CURP:</label>
      <div class="col-sm-4">
      <input class="form-control" maxlength="18" onchange="verificar_texto(this,'txt_curp')" type="text" name="txt_curp" id="txt_curp" value="<?php echo $user[0]['Curp']; ?>">
      </div>
      <label class="col-sm-3 control-label">Cuatrimestre actual:</label>
      <div class="col-sm-3">
      <select class="form-control" name="txt_cuatrimestre" id="txt_cuatrimestre">
        <option value="">Seleccione</option>
        <option value="5" <?php if(isset($lst[0]["Grado"])){ if($lst[0]["Grado"]==5){?>selected="selected"<?php } } ?>> 5 CUATRIMESTRE</option>
        <option value="6" <?php if(isset($lst[0]["Grado"])){ if($lst[0]["Grado"]==6){?>selected="selected"<?php } } ?>> 6 CUATRIMESTRE</option>
        <option value="7" <?php if(isset($lst[0]["Grado"])){ if($lst[0]["Grado"]==7){?>selected="selected"<?php } } ?>> 7 CUATRIMESTRE</option>
        <option value="8" <?php if(isset($lst[0]["Grado"])){ if($lst[0]["Grado"]==8){?>selected="selected"<?php } } ?>> 8 CUATRIMESTRE</option>
        <option value="9" <?php if(isset($lst[0]["Grado"])){ if($lst[0]["Grado"]==9){?>selected="selected"<?php } } ?>> 9 CUATRIMESTRE</option>
      </select>
      </div>
    </div>
    
  </div>
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-bank"></i> Información para la Práctica Profesional</h3>
  </div>
  
  <div class="box-body">
    <?php if ($lst[0]['IdEstatus'] == 4) { ?>
      <div class="bg-black-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-check-circle"></i> La inscripción a la Práctica Profesional ha sido aprobada. </span></div>
    <?php } ?><br>
    
    <div class="form-group">
      <label class="col-sm-4 control-label">Nombre completo de la Empresa o Institución receptora:</label>
      <div class="col-sm-8">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_empresa')" name="txt_empresa" id="txt_empresa" value="<?php echo $lst[0]['Empresa']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-9 control-label">Grado académico del responsable:</label>
      <div class="col-sm-3">
        <select class="form-control" name="txt_grado" id="txt_grado">
        <option value="">Seleccione</option>
        <option value="DR" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='DR'){?>selected="selected"<?php } } ?>> DR</option>
        <option value="DRA" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='DRA'){?>selected="selected"<?php } } ?>> DRA</option>
        <option value="MTRO" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='MTRO'){?>selected="selected"<?php } } ?>> MTRO</option>
        <option value="MTRA" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='MTRA'){?>selected="selected"<?php } } ?>> MTRA</option>
        <option value="LIC" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='LIC'){?>selected="selected"<?php } } ?>> LIC</option>
        <option value="ING" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='ING'){?>selected="selected"<?php } } ?>> ING</option>
        <option value="ARQ" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='ARQ'){?>selected="selected"<?php } } ?>> ARQ</option>
        <option value="CP" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='CP'){?>selected="selected"<?php } } ?>> CP</option>
        <option value="C" <?php if(isset($lst[0]["Grado_responsable"])){ if($lst[0]["Grado_responsable"]=='C'){?>selected="selected"<?php } } ?>> C</option>
      </select>

      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Nombre completo del responsable de la Empresa/Institución Receptora:</label>
      <div class="col-sm-8">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_responsable')" name="txt_responsable" id="txt_responsable" value="<?php echo $lst[0]['Nombre_responsable']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Cargo que ocupa:</label>
      <div class="col-sm-8">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_cargo')" name="txt_cargo" id="txt_cargo" value="<?php echo $lst[0]['Cargo']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Domicilio actual de la Empresa/Institución receptora:</label>
      <div class="col-sm-8">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_domicilio')" name="txt_domicilio" id="txt_domicilio" value="<?php echo $lst[0]['Domicilio']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Código Postal de la Empresa/Institución receptora:</label>
      <div class="col-sm-4">
        <input class="form-control" type="text" maxlength="5" onchange="verificar_numero(this,'txt_cp')" name="txt_cp" id="txt_cp" value="<?php echo $lst[0]['CP']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Número telefónico de la Empresa/Institución receptora:</label>
      <div class="col-sm-4">
        <input class="form-control" type="text" maxlength="10" onchange="verificar_numero(this,'txt_telefono')" name="txt_telefono" id="txt_telefono" value="<?php echo $lst[0]['Telefono']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Fecha de inicio de prácticas profesionales:</label>
      <div class="col-sm-4">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_fecha')" name="txt_fecha" id="txt_fecha" value="<?php echo $lst[0]['Fecha_inicio']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Persona de enlace directo con la Empresa/Institución receptora:</label>
      <div class="col-sm-8">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_persona')" name="txt_persona" id="txt_persona" value="<?php echo $lst[0]['Persona_enlace']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Número de teléfono fijo actual de la persona de enlace directo:</label>
      <div class="col-sm-4">
        <input class="form-control" maxlength="10" type="text" onchange="verificar_numero(this,'txt_tel_enlace')" name="txt_tel_enlace" id="txt_tel_enlace" value="<?php echo $lst[0]['Telefono_enlace']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Área en la que estarás asignado para prestar tus Prácticas Profesionales:</label>
      <div class="col-sm-8">
        <input class="form-control" type="text" onchange="verificar_texto(this,'txt_area')" name="txt_area" id="txt_area" value="<?php echo $lst[0]['Area_asignado']; ?>">
      </div>
    </div>
    <?php if (($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 7) || ($_SESSION['Permisos'] == 1)) { ?>
      <div class="form-group">
        <label class="col-sm-8 control-label">Fecha de emisión:</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" name="txt_emision" id="txt_emision" value="<?php echo $lst[0]['Fecha_impresion']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Directora de Gestión Escolar y Titulación:</label>
        <div class="col-sm-8">
          <select class="form-control" name="txt_gestion" id="txt_gestion">
            <?php for ($i = 0; $i < sizeof($gestion); $i++) {  ?>
              <option value="<?php echo $gestion[$i]['IdUsua']; ?>" <?php if(isset($lst[0]["IdGestion"])){ if($lst[0]["IdGestion"]==$gestion[$i]['IdUsua']){?>selected="selected"<?php } } ?>><?php echo $gestion[$i]['Nombre'] . ' ' . $gestion[$i]['APaterno'] . ' ' . $gestion[$i]['AMaterno'];; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
    <?php } ?>
    <?php if(isset($lst[0]["Motivo"])){ ?>
    <div class="form-group">
        <label class="col-sm-4 control-label" style="color: blue;">Motivo por el cual el alumno no cumple:</label>
        <div class="col-sm-8">
          <input type="text"  class="form-control" value="<?php echo $lst[0]["Motivo"]; ?>">
        </div>
      </div>
      <?php } ?>

    <div class="form-group" style="float: right;">
      <div class="col-sm-12" id="_ocultar">
        <?php if ($_SESSION['Permisos'] == 3) { ?>
          <?php if ($lst[0]['IdEstatus'] == 5) { ?>
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 31, <?php echo $Tipo; ?>)" class="btn bg-orange btn-flat "><i class="fa fa-refresh"></i> Actualizar datos</button>
            <button type="button" onclick="cancelar_inscripcion(<?php echo $IdUsua; ?>,<?php echo $lst[0]['IdPractica']; ?>)" class="btn bg-primary btn-flat "><i class="fa fa-trash"></i> Cancelar mi solicitud</button>
            <br><br>
            <div class="bg-maroon-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-times-circle"></i> La inscripción para su Práctica Profesional no fue aprobada. </span></div>
          <?php } ?>

          <?php if ($lst[0]['IdEstatus'] == 1) { ?>
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 31, <?php echo $Tipo; ?>)" class="btn bg-purple btn-flat margin"><i class="fa fa-save"></i> Guardar datos</button>
          <?php } ?>
          <?php if ($lst[0]['IdEstatus'] == 31) { ?>
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 31, <?php echo $Tipo; ?>)" class="btn bg-maroon btn-flat margin"><i class="fa fa-refresh"></i> Actualizar datos</button>
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 2, <?php echo $Tipo; ?>)" class="btn bg-orange btn-flat margin"><i class="fa fa-send-o"></i> Enviar mi solicitud para inscripción</button>
          <?php } ?>
        <?php } ?>
        <?php if (($_SESSION['Permisos'] == 9) || ($_SESSION['Permisos'] == 1)) { ?>
          <?php if ($lst[0]['IdEstatus'] == 2) { ?>
            <button type="button" onclick="sav_no_cumple()" class="btn bg-maroon btn-flat margin"><i class="fa fa-times-circle"></i> El alumno no cumple</button>
            <!-- <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 5, <?php echo $Tipo; ?>)" class="btn bg-maroon btn-flat margin"><i class="fa fa-times-circle"></i> El alumno no cumple</button> -->
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 2, <?php echo $Tipo; ?>)" class="btn bg-orange btn-flat margin"><i class="fa fa-refresh"></i> Actualizar</button>
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 3, <?php echo $Tipo; ?>)" class="btn bg-purple btn-flat margin"><i class="fa fa-check-circle"></i> Aceptar alumno, enviar a Gestión Escolar</button>
          <?php } ?>
        <?php } ?>
        <?php if (($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 7) || ($_SESSION['Permisos'] == 1)) { ?>
          <?php if ($lst[0]['IdEstatus'] == 3) { ?>
            <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 31, <?php echo $Tipo; ?>)" class="btn bg-maroon btn-flat margin"><i class="fa fa-times-circle"></i> Regresar captura al alumno</button>
            <!-- <button type="button" onclick="sav_datos_practica(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 3, <?php echo $Tipo; ?>)" class="btn bg-orange btn-flat margin"><i class="fa fa-refresh"></i> Actualizar</button> -->
            <button type="button" onclick="sav_datos_practica_gestion(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 4, <?php echo $Tipo; ?>)" class="btn bg-purple btn-flat margin"><i class="fa fa-check-circle"></i> Aceptar alumno</button>
          <?php } ?>
        <?php } ?>
        <br>
      </div>
      <div class="col-sm-12">
      <?php if ($_SESSION['Permisos'] == 3) { ?>
        <?php if ($lst[0]['IdEstatus'] == 31) { ?>
          <div class="bg-navy-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-hourglass-start"></i> Su inscripción para su Práctica Profesional se encuentra en captura. </span></div>
        <?php } ?>
        <?php if ($lst[0]['IdEstatus'] == 2) { ?>
          <div class="bg-purple-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-bell-o"></i> La inscripción a la Práctica Profesional se encuentra en Revisión por el Coordinador Académico. </span></div>
        <?php } ?>
        <?php if ($lst[0]['IdEstatus'] == 3) { ?>
          <div class="bg-teal-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-caret-square-o-right"></i> La inscripción a la Práctica Profesional se encuentra en Revisión por Gestión Escolar. </span></div>
        <?php } ?>
        <?php } ?>
        <?php if ($lst[0]['IdEstatus'] == 4) { ?>
          <?php if (($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 7) || ($_SESSION['Permisos'] == 1)) { ?>
          <button type="button" onclick="sav_datos_practica_acept(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 2, <?php echo $Tipo; ?>)" class="btn bg-orange btn-flat margin"><i class="fa fa-refresh"></i> Actualizar</button>
          <?php } ?>
          <button type="button" onclick="javascript:window.open('repositorio/formatos/carta_asignacion.php?idToks=<?php echo time() . $lst[0]['IdPractica']; ?>');" href="javascript:void(0);" title="Imprimir carta de presentación." class="btn bg-teal btn-flat"><i class="fa fa-print"></i> Carta de Asignacion</button>
          <button type="button" onclick="javascript:window.open('repositorio/formatos/carta_presentacion.php?idToks=<?php echo time() . $lst[0]['IdPractica']; ?>');" href="javascript:void(0);" title="Imprimir carta de presentación." class="btn bg-maroon btn-flat"><i class="fa fa-print"></i> Carta de Presentación</button>
        <?php } ?>
      </div>
    </div>
    <div style="display: none;" id="_div">
    <div class="form-group">
        <label class="col-sm-4 control-label" style="color: red;">Motivo por el cual el alumno no cumple:</label>
        <div class="col-sm-8">
          <input type="text" name="_nocumple" id="_nocumple" class="form-control">
        </div>
      </div>
      <button type="button" onclick="sav_motivo_no_cumple(<?php echo $IdUsua; ?>,<?php echo $IdAviso; ?>,<?php echo $IdDetalle; ?>,<?php echo $lst[0]['IdPractica']; ?>, 5, <?php echo $Tipo; ?>)" class="btn bg-maroon btn-flat margin"><i class="fa fa-times-circle"></i> Guardar motivo</button>
    </div>

  </div>

</form>
</div>


<script>
  $(function() {
    $('#txt_fecha').datepicker({
      autoclose: true
    })
  })
  $(function() {
    $('#txt_emision').datepicker({
      autoclose: true
    })
  })


  function sav_datos_practica(IdUsua, IdAviso, IdDetalle, IdPractica, IdEstatus, Tipo) {
    
    var _idUsua = document.getElementById("_idUsua").value;
    var Direccion = document.getElementById("txt_direccion").value;
    var Estado = document.getElementById("txt_estado").value;
    var Municipio = document.getElementById("txt_municipio").value;
    var CPAlumno = document.getElementById("txt_cp_alumno").value;
    var Celular = document.getElementById("txt_celular").value;
    var Cuatrimestre = document.getElementById("txt_cuatrimestre").value;
    
    var Curp = document.getElementById("txt_curp").value;
    var Empresa = document.getElementById("txt_empresa").value;
    var Grado = document.getElementById("txt_grado").value;
    var Responsable = document.getElementById("txt_responsable").value;
    var Cargo = document.getElementById("txt_cargo").value;
    var Domicilio = document.getElementById("txt_domicilio").value;
    var Cp = document.getElementById("txt_cp").value;
    var Telefono = document.getElementById("txt_telefono").value;
    var Fecha = document.getElementById("txt_fecha").value;
    var Persona = document.getElementById("txt_persona").value;
    var TelEnlace = document.getElementById("txt_tel_enlace").value;
    var Area = document.getElementById("txt_area").value;

    var TipoGuardar = "sav_inscripcion_alumno";
    if (Direccion == '') {
      swal("Error al guardar", "Debe escribir su Domicilio.", "error");
      document.getElementById("txt_direccion").focus();
      return 0;
    }
    if (Estado == '') {
      swal("Error al guardar", "Debe seleccionar el estado.", "error");
      document.getElementById("txt_estado").focus();
      return 0;
    }
    if (Municipio == '') {
      swal("Error al guardar", "Debe seleccionar la localidad.", "error");
      document.getElementById("txt_municipio").focus();
      return 0;
    }
    if (CPAlumno == '') {
      swal("Error al guardar", "Debe escribir el Código Postal.", "error");
      document.getElementById("txt_cp_alumno").focus();
      return 0;
    }
    if (Celular == '') {
      swal("Error al guardar", "Debe escribir su numero de celular.", "error");
      document.getElementById("txt_celular").focus();
      return 0;
    }
    if (Curp == '') {
      swal("Error al guardar", "Debe escribir su CURP.", "error");
      document.getElementById("txt_curp").focus();
      return 0;
    }
    if (Cuatrimestre == '') {
      swal("Error al guardar", "Debe seleccionar el cuatrimestre actual.", "error");
      document.getElementById("txt_curp").focus();
      return 0;
    }
    if (Empresa == '') {
      swal("Error al guardar", "Debe escribir el Nombre completo de la Empresa o Institución receptora.", "error");
      document.getElementById("txt_empresa").focus();
      return 0;
    }
    if (Grado == '') {
      swal("Error al guardar", "Debe escribir el Grado académico del responsable.", "error");
      document.getElementById("txt_grado").focus();
      return 0;
    }
    if (Responsable == '') {
      swal("Error al guardar", "Debe escribir el Nombre completo del responsable de la Empresa/Institución Receptora.", "error");
      document.getElementById("txt_responsable").focus();
      return 0;
    }
    if (Cargo == '') {
      swal("Error al guardar", "Debe escribir el Cargo que ocupa.", "error");
      document.getElementById("txt_cargo").focus();
      return 0;
    }
    if (Domicilio == '') {
      swal("Error al guardar", "Debe escribir el Domicilio actual de la Empresa/Institución receptora.", "error");
      document.getElementById("txt_domicilio").focus();
      return 0;
    }
    if (Cp == '') {
      swal("Error al guardar", "Debe escribir el Código Postal de la Empresa/Institución receptora:.", "error");
      document.getElementById("txt_cp").focus();
      return 0;
    }
    if (Telefono == '') {
      swal("Error al guardar", "Debe escribir el Número telefónico de la Empresa/Institución receptora.", "error");
      document.getElementById("txt_telefono").focus();
      return 0;
    }
    if (Fecha == '') {
      swal("Error al guardar", "Debe escribir la Fecha de inicio de prácticas profesionales:.", "error");
      document.getElementById("txt_fecha").focus();
      return 0;
    }
    if (Persona == '') {
      swal("Error al guardar", "Debe escribir el Persona de enlace directo con la Empresa/Institución receptora.", "error");
      document.getElementById("txt_persona").focus();
      return 0;
    }
    if (TelEnlace == '') {
      swal("Error al guardar", "Debe escribir el Número de teléfono fijo actual de la persona de enlace directo.", "error");
      document.getElementById("txt_tel_enlace").focus();
      return 0;
    }
    if (Area == '') {
      swal("Error al guardar", "Debe escribir el Área en la que estaras asignado para prestar tus Practicas Profesionales.", "error");
      document.getElementById("txt_area").focus();
      return 0;
    }
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar estos para su práctica profesional?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              type: "POST",
              url: "vistas/practicas/sav_desarrollo.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdUsua: IdUsua,
                IdAviso: IdAviso,
                Curp: Curp,
                Empresa: Empresa,
                Grado: Grado,
                Responsable: Responsable,
                Cargo: Cargo,
                Domicilio: Domicilio,
                Cp: Cp,
                Telefono: Telefono,
                Fecha: Fecha,
                Persona: Persona,
                TelEnlace: TelEnlace,
                Area: Area,
                IdDetalle: IdDetalle,
                IdPractica: IdPractica,
                IdEstatus: IdEstatus,
                Direccion:Direccion,
                Estado:Estado,
                Municipio:Municipio,
                CPAlumno:CPAlumno,
                Celular:Celular,
                Cuatrimestre:Cuatrimestre,
                _idUsua:_idUsua
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "Los datos para la inscripción a la práctica profesional se han guardado correctamente.", "success");
                if (Tipo == 2) {
                  load_user_beca(IdEstatus);
                }
                $.ajax({
                  url: "vistas/practicas/inscripcion_alumno.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdAviso: IdAviso,
                    IdDetalle: IdDetalle,
                    Tipo: Tipo
                  },
                  success: function(data) {
                    $('#employee_practica').html(data);
                    $('#data_practica').modal('show');
                  }
                });
              } else {
                swal("Error al guardar", "Ha ocurrido un error, no se puede guardar los datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function sav_datos_practica_acept(IdUsua, IdAviso, IdDetalle, IdPractica, IdEstatus, Tipo) {
    
    var _idUsua = document.getElementById("_idUsua").value;
    var Direccion = document.getElementById("txt_direccion").value;
    var Estado = document.getElementById("txt_estado").value;
    var Municipio = document.getElementById("txt_municipio").value;
    var CPAlumno = document.getElementById("txt_cp_alumno").value;
    var Celular = document.getElementById("txt_celular").value;
    var Cuatrimestre = document.getElementById("txt_cuatrimestre").value;
    
    var Curp = document.getElementById("txt_curp").value;
    var Empresa = document.getElementById("txt_empresa").value;
    var Grado = document.getElementById("txt_grado").value;
    var Responsable = document.getElementById("txt_responsable").value;
    var Cargo = document.getElementById("txt_cargo").value;
    var Domicilio = document.getElementById("txt_domicilio").value;
    var Cp = document.getElementById("txt_cp").value;
    var Telefono = document.getElementById("txt_telefono").value;
    var Fecha = document.getElementById("txt_fecha").value;
    var Persona = document.getElementById("txt_persona").value;
    var TelEnlace = document.getElementById("txt_tel_enlace").value;
    var Area = document.getElementById("txt_area").value;
    var IdGestion = document.getElementById("txt_gestion").value;

    var TipoGuardar = "sav_inscripcion_alumno_activo";
    if (Direccion == '') {
      swal("Error al guardar", "Debe escribir su Domicilio.", "error");
      document.getElementById("txt_direccion").focus();
      return 0;
    }
    if (Estado == '') {
      swal("Error al guardar", "Debe seleccionar el estado.", "error");
      document.getElementById("txt_estado").focus();
      return 0;
    }
    if (Municipio == '') {
      swal("Error al guardar", "Debe seleccionar la localidad.", "error");
      document.getElementById("txt_municipio").focus();
      return 0;
    }
    if (CPAlumno == '') {
      swal("Error al guardar", "Debe escribir el Código Postal.", "error");
      document.getElementById("txt_cp_alumno").focus();
      return 0;
    }
    if (Celular == '') {
      swal("Error al guardar", "Debe escribir su numero de celular.", "error");
      document.getElementById("txt_celular").focus();
      return 0;
    }
    if (Curp == '') {
      swal("Error al guardar", "Debe escribir su CURP.", "error");
      document.getElementById("txt_curp").focus();
      return 0;
    }
    if (Cuatrimestre == '') {
      swal("Error al guardar", "Debe seleccionar el cuatrimestre actual.", "error");
      document.getElementById("txt_curp").focus();
      return 0;
    }
    if (Empresa == '') {
      swal("Error al guardar", "Debe escribir el Nombre completo de la Empresa o Institución receptora.", "error");
      document.getElementById("txt_empresa").focus();
      return 0;
    }
    if (Grado == '') {
      swal("Error al guardar", "Debe escribir el Grado académico del responsable.", "error");
      document.getElementById("txt_grado").focus();
      return 0;
    }
    if (Responsable == '') {
      swal("Error al guardar", "Debe escribir el Nombre completo del responsable de la Empresa/Institución Receptora.", "error");
      document.getElementById("txt_responsable").focus();
      return 0;
    }
    if (Cargo == '') {
      swal("Error al guardar", "Debe escribir el Cargo que ocupa.", "error");
      document.getElementById("txt_cargo").focus();
      return 0;
    }
    if (Domicilio == '') {
      swal("Error al guardar", "Debe escribir el Domicilio actual de la Empresa/Institución receptora.", "error");
      document.getElementById("txt_domicilio").focus();
      return 0;
    }
    if (Cp == '') {
      swal("Error al guardar", "Debe escribir el Código Postal de la Empresa/Institución receptora:.", "error");
      document.getElementById("txt_cp").focus();
      return 0;
    }
    if (Telefono == '') {
      swal("Error al guardar", "Debe escribir el Número telefónico de la Empresa/Institución receptora.", "error");
      document.getElementById("txt_telefono").focus();
      return 0;
    }
    if (Fecha == '') {
      swal("Error al guardar", "Debe escribir la Fecha de inicio de prácticas profesionales:.", "error");
      document.getElementById("txt_fecha").focus();
      return 0;
    }
    if (Persona == '') {
      swal("Error al guardar", "Debe escribir el Persona de enlace directo con la Empresa/Institución receptora.", "error");
      document.getElementById("txt_persona").focus();
      return 0;
    }
    if (TelEnlace == '') {
      swal("Error al guardar", "Debe escribir el Número de teléfono fijo actual de la persona de enlace directo.", "error");
      document.getElementById("txt_tel_enlace").focus();
      return 0;
    }
    if (Area == '') {
      swal("Error al guardar", "Debe escribir el Área en la que estaras asignado para prestar tus Practicas Profesionales.", "error");
      document.getElementById("txt_area").focus();
      return 0;
    }
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar estos para su práctica profesional?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              type: "POST",
              url: "vistas/practicas/sav_desarrollo.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdUsua: IdUsua,
                IdAviso: IdAviso,
                Curp: Curp,
                Empresa: Empresa,
                Grado: Grado,
                Responsable: Responsable,
                Cargo: Cargo,
                Domicilio: Domicilio,
                Cp: Cp,
                Telefono: Telefono,
                Fecha: Fecha,
                Persona: Persona,
                TelEnlace: TelEnlace,
                Area: Area,
                IdDetalle: IdDetalle,
                IdPractica: IdPractica,
                IdEstatus: IdEstatus,
                Direccion:Direccion,
                Estado:Estado,
                Municipio:Municipio,
                CPAlumno:CPAlumno,
                Celular:Celular,
                Cuatrimestre:Cuatrimestre,
                _idUsua:_idUsua,
                IdGestion:IdGestion
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Actualizado correctamente", "Los datos para la inscripción a la práctica profesional se han actualizado correctamente.", "success");
                load_user_beca(4);
                $.ajax({
                  url: "vistas/practicas/inscripcion_alumno.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdAviso: IdAviso,
                    IdDetalle: IdDetalle,
                    Tipo: Tipo
                  },
                  success: function(data) {
                    $('#employee_practica').html(data);
                    $('#data_practica').modal('show');
                  }
                });
              } else {
                swal("Error al guardar", "Ha ocurrido un error, no se puede guardar los datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function sav_datos_practica_gestion(IdUsua, IdAviso, IdDetalle, IdPractica, IdEstatus, Tipo) {
    var Direccion = document.getElementById("txt_direccion").value;
    var Estado = document.getElementById("txt_estado").value;
    var Municipio = document.getElementById("txt_municipio").value;
    var CPAlumno = document.getElementById("txt_cp_alumno").value;
    var Celular = document.getElementById("txt_celular").value;

    var Curp = document.getElementById("txt_curp").value;
    var Empresa = document.getElementById("txt_empresa").value;
    var Grado = document.getElementById("txt_grado").value;
    var Responsable = document.getElementById("txt_responsable").value;
    var Cargo = document.getElementById("txt_cargo").value;
    var Domicilio = document.getElementById("txt_domicilio").value;
    var Cp = document.getElementById("txt_cp").value;
    var Telefono = document.getElementById("txt_telefono").value;
    var Fecha = document.getElementById("txt_fecha").value;
    var Persona = document.getElementById("txt_persona").value;
    var TelEnlace = document.getElementById("txt_tel_enlace").value;
    var Area = document.getElementById("txt_area").value;
    var Emision = document.getElementById("txt_emision").value;
    var IdGestion = document.getElementById("txt_gestion").value;

    var TipoGuardar = "sav_inscripcion_alumno_gestion";
    if (Direccion == '') {
      swal("Error al guardar", "Debe escribir su Domicilio.", "error");
      document.getElementById("txt_direccion").focus();
      return 0;
    }
    if (Estado == '') {
      swal("Error al guardar", "Debe seleccionar el estado.", "error");
      document.getElementById("txt_estado").focus();
      return 0;
    }
    if (Municipio == '') {
      swal("Error al guardar", "Debe seleccionar la localidad.", "error");
      document.getElementById("txt_municipio").focus();
      return 0;
    }
    if (CPAlumno == '') {
      swal("Error al guardar", "Debe escribir el Código Postal.", "error");
      document.getElementById("txt_cp_alumno").focus();
      return 0;
    }
    if (Celular == '') {
      swal("Error al guardar", "Debe escribir su numero de celular.", "error");
      document.getElementById("txt_celular").focus();
      return 0;
    }

    if (Curp == '') {
      swal("Error al guardar", "Debe escribir su CURP.", "error");
      document.getElementById("txt_curp").focus();
      return 0;
    }
    if (Empresa == '') {
      swal("Error al guardar", "Debe escribir el Nombre completo de la Empresa o Institución receptora.", "error");
      document.getElementById("txt_empresa").focus();
      return 0;
    }
    if (Grado == '') {
      swal("Error al guardar", "Debe escribir el Grado académico del responsable.", "error");
      document.getElementById("txt_grado").focus();
      return 0;
    }
    if (Responsable == '') {
      swal("Error al guardar", "Debe escribir el Nombre completo del responsable de la Empresa/Institución Receptora.", "error");
      document.getElementById("txt_responsable").focus();
      return 0;
    }
    if (Cargo == '') {
      swal("Error al guardar", "Debe escribir el Cargo que ocupa.", "error");
      document.getElementById("txt_cargo").focus();
      return 0;
    }
    if (Domicilio == '') {
      swal("Error al guardar", "Debe escribir el Domicilio actual de la Empresa/Institución receptora.", "error");
      document.getElementById("txt_domicilio").focus();
      return 0;
    }
    if (Cp == '') {
      swal("Error al guardar", "Debe escribir el Código Postal de la Empresa/Institución receptora:.", "error");
      document.getElementById("txt_cp").focus();
      return 0;
    }
    if (Telefono == '') {
      swal("Error al guardar", "Debe escribir el Número telefónico de la Empresa/Institución receptora.", "error");
      document.getElementById("txt_telefono").focus();
      return 0;
    }
    if (Fecha == '') {
      swal("Error al guardar", "Debe escribir la Fecha de inicio de prácticas profesionales:.", "error");
      document.getElementById("txt_fecha").focus();
      return 0;
    }
    if (Persona == '') {
      swal("Error al guardar", "Debe escribir el Persona de enlace directo con la Empresa/Institución receptora.", "error");
      document.getElementById("txt_persona").focus();
      return 0;
    }
    if (TelEnlace == '') {
      swal("Error al guardar", "Debe escribir el Número de teléfono fijo actual de la persona de enlace directo.", "error");
      document.getElementById("txt_tel_enlace").focus();
      return 0;
    }
    if (Area == '') {
      swal("Error al guardar", "Debe escribir el Área en la que estaras asignado para prestar tus Practicas Profesionales.", "error");
      document.getElementById("txt_area").focus();
      return 0;
    }
    if (Emision == '') {
      swal("Error al guardar", "Debe seleccionar la fecha de emisión del documento de la práctica.", "error");
      document.getElementById("txt_emision").focus();
      return 0;
    }
    if (IdGestion == '') {
      swal("Error al guardar", "Debe seleccionar la responsable de la firma del documento.", "error");
      document.getElementById("txt_gestion").focus();
      return 0;
    }
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar estos para su práctica profesional?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              type: "POST",
              url: "vistas/practicas/sav_desarrollo.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdUsua: IdUsua,
                IdAviso: IdAviso,
                Curp: Curp,
                Empresa: Empresa,
                Grado: Grado,
                Responsable: Responsable,
                Cargo: Cargo,
                Domicilio: Domicilio,
                Cp: Cp,
                Telefono: Telefono,
                Fecha: Fecha,
                Persona: Persona,
                TelEnlace: TelEnlace,
                Area: Area,
                IdDetalle: IdDetalle,
                IdPractica: IdPractica,
                IdEstatus: IdEstatus,
                Emision: Emision,
                IdGestion: IdGestion,
                Direccion:Direccion,
                Estado:Estado,
                Municipio:Municipio,
                CPAlumno:CPAlumno,
                Celular:Celular
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Aceptado correctamente", "El alumno se ha aceptado correctamente para su proceso de práctica profesional.", "success");
                if (Tipo == 2) {
                  load_user_beca(IdEstatus);
                }
                $.ajax({
                  url: "vistas/practicas/inscripcion_alumno.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdAviso: IdAviso,
                    IdDetalle: IdDetalle,
                    Tipo: Tipo
                  },
                  success: function(data) {
                    $('#employee_practica').html(data);
                    $('#data_practica').modal('show');
                  }
                });
              } else {
                swal("Error al guardar", "Ha ocurrido un error, no se puede guardar los datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function verificar_texto(valor, variable) {
    var Texto = valor.value;
    Texto = Texto.toUpperCase();
    document.getElementById(variable).value = Texto;
  }

  function verificar_numero(valor, variable) {
    var Texto = valor.value;
    if (isNaN(Texto)) {
      document.getElementById(variable).value = '';
      swal("Dato err\u00F3neo", "El dato ingresado no es un n\u00FAmero.", "error");
      return 0;
    }
  }


  function cargar_municipio(){
    var IdEstado = document.getElementById("txt_estado").value;
    var Tipo = "get_estados_practica";
    $.post("php/clases/getConsulta.php", { Tipo:Tipo, IdEstado:IdEstado }, function(data){
      $("#txt_municipio").html(data);
    });
  }

  $(document).ready(function(){
    var IdEstado = document.getElementById("IdEsta_D").value;
    var Tipo = "get_estado_sel";
    $.post("php/clases/getConsulta.php", { Tipo:Tipo, IdEstado:IdEstado}, function(data){
      $("#txt_estado").html(data);
    });
  });

  $(document).ready(function(){
    var IdEstado = document.getElementById("IdEsta_D").value;
    var IdMunicipio = document.getElementById("IdMuni_D").value;
    var Tipo = "get_ciudad_sel_practica";
    $.post("php/clases/getConsulta.php", { Tipo:Tipo, IdEstado:IdEstado, IdMunicipio:IdMunicipio}, function(data){
      $("#txt_municipio").html(data);
    });
  });


function sav_no_cumple(){
  document.getElementById("_div").style.display = "block";
  document.getElementById("_ocultar").style.display = "none";
}

function sav_motivo_no_cumple(IdUsua, IdAviso, IdDetalle, IdPractica, IdEstatus, Tipo) {
    var Motivo = document.getElementById("_nocumple").value;
    
    var TipoGuardar = "sav_motivo_ins_alumno";
    if (Motivo == '') {
      swal("Error al guardar", "Debe escribir el motivo por el cual no cumple.", "error");
      document.getElementById("_nocumple").focus();
      return 0;
    }
    
    swal({
        title: "\u00BFEst\u00E1 seguro que desea no aceptar esta práctica profesional del alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              type: "POST",
              url: "vistas/practicas/sav_desarrollo.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdPractica: IdPractica,
                IdEstatus:IdEstatus,
                Motivo: Motivo
              },
              success: function(data) {
                
              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "La inscripción a la práctica profesional del alumno se ha cancelado correctamente.", "success");
                load_user_beca(IdEstatus);
                $.ajax({
                  url: "vistas/practicas/inscripcion_alumno.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdAviso: IdAviso,
                    IdDetalle: IdDetalle,
                    Tipo: Tipo
                  },
                  success: function(data) {
                    $('#employee_practica').html(data);
                    $('#data_practica').modal('show');
                  }
                });
              } else {
                swal("Error al guardar", "Ha ocurrido un error, no se puede guardar los datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function cancelar_inscripcion(IdUsua, IdPractica) {
    
    var TipoGuardar = "sav_cancelar_inscripcion_alumno";
    
    swal({
        title: "\u00BFEst\u00E1 seguro que desea cancelar su inscripción de su practica profesional?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              type: "POST",
              url: "vistas/practicas/sav_desarrollo.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdPractica: IdPractica
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                mostrar_seguimiento();
                $('#data_practica').modal('hide');

                swal("Eliminado correctamente", "Sus datos para la inscripción a la práctica profesional se han eliminado correctamente.", "success");
              } else {
                swal("Error al guardar", "Ha ocurrido un error, no se puede eliminar.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

</script>
