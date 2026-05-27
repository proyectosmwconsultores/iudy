//https://www.youtube.com/watch?v=oxZj82kh4FA
//markcell.github.io/jquery-tabledit/

function val_login()
{
  var txtUser = document.getElementById("txtUser").value;
  var txtPass = document.getElementById("txtPass").value;
  var TipoGuardar = "Login";
  var Tipo = "";""
  if (txtUser==""){
		swal("Error al guardar", "Debe escribir su CORREO", "error");
        document.getElementById("txtUser").focus();
        return 0;
    }
    if (txtPass==""){
  		swal("Error al guardar", "Debe escribir su SU CONTRASEÑA", "error");
          document.getElementById("txtUser").focus();
          return 0;
      }

      document.frm.Mov.value='Guardar';document.frm.submit();

  var datos = 'TipoGuardar=' + TipoGuardar + '&txtUser=' + txtUser + '&txtPass=' + txtPass;
  $.ajax({
    type:"POST",
    url:"insertar.php",
    data:datos,
    success:function(data){
    //  alert(data);
      //parent.location.href='inicio.php'; //direcciona la pagina madre
    }
  })
  .done(function(data) {
    if(data==1){
      swal("ACCESANDO", "INGRESANDO", "success");
      parent.location.href='inicio.php'; //direcciona la pagina madre
    }else{
      swal("Error al guardar", "NO SE PUEDE INGRESAR", "error");
    }
  })
  document.getElementById("frm").reset();
  //parent.location.href='viewForo.php?Id='+IdAsignacion; //direcciona la pagina madre
}

function uploadImg(obj){





        var uploadFile = obj.files[0];
        if (!window.FileReader) {
          swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
            return;
        }

        if (!(/\.(png|jpg|jpeg|gif)$/i).test(uploadFile.name)) {
          swal("Error", "Porfavor, cargue solamente archivos  .png / .jpg / .jpeg / .gif", "error");
            document.getElementById("archivo").value='';
            document.getElementById("archivo").focus();
        }
        else {
            var img = new Image();
            if (uploadFile.size > 10000000)
            {
              swal("Error al subir", "El peso del archivo debe ser menor a 10 MB", "error");
                document.getElementById("archivo").value='';
                document.getElementById("archivo").focus();
            }
            else {
              var Img = document.getElementById("archivo").value;
              var Ext = "";
              var porciones = Img.split('.');
              Ext = porciones[1];

              if((Ext == "png") || (Ext == "jpg") || (Ext == "jpeg") || (Ext == "gif")){
              } else {
                swal("Error al subir", "Verifique que en el nombre del archivo no contenga punto.", "error");
                  document.getElementById("archivo").value='';
                  document.getElementById("archivo").focus();
              }
                // alert('Imagen correcta :)')
            }
            // };
            img.src = URL.createObjectURL(uploadFile);
        }


}

function ValArchivoPDF(obj){
    var uploadFile = obj.files[0];
    if (!window.FileReader) {
    	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
        return;
    }

    if (!(/\.(jpg|png|pdf|docx|doc|xlsx|xls|zip|rar|ppt|pptx)$/i).test(uploadFile.name)) {
    	swal("Error", "Porfavor, cargue solamente archivos  pdf|docx|doc|xlsx|xls|zip|rar|ppt|pptx", "error");
        document.getElementById("archivo").value='';
        document.getElementById("archivo").focus();
    }
    else {

        var img = new Image();
        if (uploadFile.size > 10000000)
        {
        	swal("Error al subir", "El peso del archivo debe ser menor a 10 MB", "error");
            document.getElementById("archivo").value='';
            document.getElementById("archivo").focus();
        }
        else {
          var Img = document.getElementById("archivo").value;
          var Ext = "";
          var porciones = Img.split('.');
          Ext = porciones[1];

          if((Ext == "png") || (Ext == "jpg") || (Ext == "pptx") || (Ext == "ppt") || (Ext == "pdf") || (Ext == "docx") || (Ext == "doc") || (Ext == "xlsx")|| (Ext == "xls") || (Ext == "zip") || (Ext == "rar")){

          } else {
            swal("Error al subir", "Verifique que en el nombre del archivo no contenga punto.", "error");
              document.getElementById("archivo").value='';
              document.getElementById("archivo").focus();
          }

        }
        // };
        img.src = URL.createObjectURL(uploadFile);
    }
}

function validar_pdf(obj){
    var uploadFile = obj.files[0];
    if (!window.FileReader) {
    	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
        return;
    }

    if (!(/\.(pdf)$/i).test(uploadFile.name)) {
    	swal("Error", "Porfavor, cargue solamente archivo  .pdf", "error");
        document.getElementById("txtPdf").value='';
        document.getElementById("txtPdf").focus();
    }
    else {

        var img = new Image();
        if (uploadFile.size > 5000000)
        {
        	swal("Error al subir", "El peso del archivo debe ser menor a 5 MB", "error");
            document.getElementById("txtPdf").value='';
            document.getElementById("txtPdf").focus();
        }
        else {
          var Img = document.getElementById("archivo").value;
          var Ext = "";
          var porciones = Img.split('.');
          Ext = porciones[1];

          if(Ext == "pdf"){
          } else {
            swal("Error al subir", "Verifique que en el nombre del archivo no contenga punto.", "error");
              document.getElementById("txtPdf").value='';
              document.getElementById("txtPdf").focus();
          }
        }
    }
}

function ValRecursoPDF(obj){
    var uploadFile = obj.files[0];
    if (!window.FileReader) {
    	swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
        return;
    }

    if (!(/\.(pdf|docx|doc|xlsx|xls|zip|rar)$/i).test(uploadFile.name)) {
    	swal("Error", "Porfavor, cargue solamente archivos  .pdf / .doc / .docx / .xlsx / .xls", "error");
        document.getElementById("archivo").value='';
        document.getElementById("archivo").focus();
    }
    else {
        var img = new Image();
        if (uploadFile.size > 50000000)
        {
        	swal("Error al subir", "El peso del archivo debe ser menor a 50 MB", "error");
            document.getElementById("archivo").value='';
            document.getElementById("archivo").focus();
        }
        else {
            // alert('Imagen correcta :)')
        }
        // };
        img.src = URL.createObjectURL(uploadFile);
    }
}
//
// function ValidarImagen(obj){
//     var uploadFile = obj.files[0];
//     var fileInput = document.getElementById('foto');
//     if (!window.FileReader) {
//         alert('El navegador no soporta la lectura de archivos');
//         return;
//     }
//
//     if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
//         alert('El archivo a adjuntar no es una imagen');
//             document.getElementById("foto").value='';
//     }
//     else {
//         var img = new Image();
//         img.onload = function () {
//
//                 // alert('Imagen correcta :)')
//                 if (fileInput.files && fileInput.files[0]) {
//                     var reader = new FileReader();
//                     reader.onload = function(e) {
//                         document.getElementById('imagePreview').innerHTML = '<img class="profile-user-img img-responsive img-circle" src="'+e.target.result+'"/>';
//                     };
//                 reader.readAsDataURL(fileInput.files[0]);
//                 }
//
//         };
//         img.src = URL.createObjectURL(uploadFile);
//     }
// }
//
//


function val_loadPubliX(){
	if (document.frm.txtPublicidad.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la imagen de publicidad.", "error");
     document.getElementById("txtPublicidad").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta imagen de publicidad?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      document.frm.Mov.value='uploadPub';document.frm.submit();
		}
	});
}

function val_loadLogo(){
	if (document.frm.txtLogo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la imagen de logo.", "error");
     document.getElementById("txtLogo").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta imagen para logo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      document.frm.Mov.value='uploadLogo';document.frm.submit();
		}
	});
}

function val_loadIcono(){
	if (document.frm.txtIcono.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la imagen de icono.", "error");
     document.getElementById("txtIcono").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta imagen para icono?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      document.frm.Mov.value='uploadIcono';document.frm.submit();
		}
	});
}

function val_loadMateria(){
	if (document.frm.txtMateria.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la imagen de icono.", "error");
     document.getElementById("txtMateria").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir esta imagen para icono de materias?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      document.frm.Mov.value='uploadMateria';document.frm.submit();
		}
	});
}


function ValidarImagen(obj){
    var uploadFile = obj.files[0];
    var fileInput = document.getElementById('foto');
    if (!window.FileReader) {
      swal("Error", "EL NAVEGADOR NO SOPORTA LA LECTURA DE ARCHIVOS", "error");
        return;
    }

    if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
      swal("Error", "El archivo a adjuntar no es una imagen", "error");
            document.getElementById("foto").value='';
    }
    else {
        var img = new Image();
        img.onload = function () {
            // if (this.width.toFixed(0) != 128 && this.height.toFixed(0) != 128) {
            //     document.getElementById("foto").value='';
            //     document.getElementById("foto").focus();
            //     swal("ERROR", "LAS MEDIDAS DEBEN SER: 128 x 128", "error");
            // }
            // else
            if (uploadFile.size > 1000000)
            {
              swal("Error al subir", "El peso de la imagen debe ser menor a 1MB", "error");
            }
            else {
                // alert('Imagen correcta :)')
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                      document.getElementById("viewForo").style.display = "block";
                        document.getElementById('imagePreview').innerHTML = '<img class="profile-user-img img-responsive img-circle" src="'+e.target.result+'"/>';
                    };
                reader.readAsDataURL(fileInput.files[0]);
                }
            }
        };
        img.src = URL.createObjectURL(uploadFile);
    }
}

function val_adAddOferta(){
  // var TipoSer = document.frm.txtServicio.value;
	// if (document.frm.txtServicio.value.length==''){
  //       swal("Error al guardar", "Debe seleccionar el tipo de oferta educativa.", "error");
  //       document.getElementById("txtServicio").focus();
  //       return 0;
  //   }
    // if (document.frm.txtModalidad.value.length==''){
  	// 	swal("Error al guardar", "Escriba la modalidad de la oferta educativa.", "error");
    //       document.getElementById("txtModalidad").focus();
    //       return 0;
    //   }

  // if (document.frm.txtZona.value.length==''){
  //   swal("Error al guardar", "Debe seleccionar la zona de la oferta educativa.", "error");
  //       document.getElementById("txtZona").focus();
  //       return 0;
  //   }
  // if(TipoSer == 2){
  //   if (document.frm.txtCampus.value.length==''){
  //     swal("Error al guardar", "Debe seleccionar el campus de la oferta educativa.", "error");
  //         document.getElementById("txtCampus").focus();
  //         return 0;
  //     }
  // }

  if (document.frm.txtClave.value.length==''){
        swal("Error al guardar", "Debe agregar la clave del plan de estudio.", "error");
        document.getElementById("txtClave").focus();
        return 0;
    }
    if (document.frm.txtNombre.value.length==''){
  		swal("Error al guardar", "Escriba el nombre del plan de estudio.", "error");
          return 0;
      }
	if (document.frm.txtTipo.value.length==''){
		swal("Error al guardar", "Seleccione tipo de plan de estudio.", "error");
        document.getElementById("txtTipo").focus();
        return 0;
    }


	// if (document.frm.txtCiclo.value.length==''){
	// 	swal("Error al guardar", "Seleccione tipo de ciclo escolar.", "error");
  //       document.getElementById("txtCiclo").focus();
  //       return 0;
  //   }
	// if (document.frm.txtTotal.value.length==''){
	// 	swal("Error al guardar", "Escriba el total de semestres y/o cuatrimestres.", "error");
  //       document.getElementById("txtTotal").focus();
  //       return 0;
  //   }
  //
	// if (document.frm.txtCreditos.value.length==''){
	// 	swal("Error al guardar", "Escriba el total de cr\u00E9ditos.", "error");
  //       document.getElementById("txtCreditos").focus();
  //       return 0;
  //   }
  //   if (document.frm.txtRvoe.value.length==''){
  // 		swal("Error al guardar", "Debe escribir el rvoe.", "error");
  //         document.getElementById("txtRvoe").focus();
  //         return 0;
  //     }
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo plan de estudio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Plan de estudio guardado correctamente.", "success");
          parent.location.href='adAddOferta.php';
					document.getElementById("frm").reset();
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function saveCedula(){
	swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar los datos de este alumno?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Datos del alumno guardado correctamente.", "success");
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function save_cedula_id(){
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar sus datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Actualizado correctamente", "Sus datos personales se ha guardado correctamente.", "success");
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_adAddPlan()
{
  if (document.frm.txtOferta.value.length==''){
        swal("Error al guardar", "Debe seleccionar la licenciatura.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
    if (document.frm.txtModalidad.value.length==''){
  		swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
      document.getElementById("txtModalidad").focus();
          return 0;
      }
	if (document.frm.txtDias.value.length==''){
		swal("Error al guardar", "Debe seleccionar los dias.", "error");
        document.getElementById("txtDias").focus();
        return 0;
    }
  if (document.frm.txtGeneracion.value.length==''){
		swal("Error al guardar", "Debe escribir la generaci\u00F3n.", "error");
        document.getElementById("txtGeneracion").focus();
        return 0;
    }
  if (document.frm.txtCiclo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
    }
  if (document.frm.txtObjetivo.value.length==''){
		swal("Error al guardar", "Debe escribir el objetivo del plan de proyecto.", "error");
        document.getElementById("txtObjetivo").focus();
        return 0;
    }


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo plan de proyecto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Informaci\u00F3n del plan de proyecto guardado correctamente.", "success");
					 document.getElementById("frm").reset();
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_adAddCveGrupo()
{
  var Campus = document.frm.txtCampus.value;
  var Oferta = document.frm.txtOferta.value;
    if (document.frm.txtCampus.value.length==''){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        document.getElementById("txtCampus").focus();
        return 0;
    }
    if (document.frm.txtOferta.value.length==''){
        swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
    if (document.frm.txtClave.value.length==''){
        swal("Error al guardar", "Debe escribir la clave del grupo.", "error");
        document.getElementById("txtClave").focus();
        return 0;
    }
    if (document.frm.txtPeriodo.value.length==''){
        swal("Error al guardar", "Debe escribir el periodo del grupo.", "error");
        document.getElementById("txtPeriodo").focus();
        return 0;
    }


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta clave de grupo?",
		text: "Al agregar esta clave de grupo ya esta disponible para agregar a los alumnos",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Clave de grupo guardada correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adAddCveGrupo.php?C='+Campus+'&O='+Oferta; //direcciona la pagina madre
				}
        if(data==2){
					swal("Error al guardar", "La clave ya existe, favor de ingresar otra.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==3){
					swal("Error al guardar", "La clave de grupo no esta bien escrita.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==0){
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function val_addCveGrp()
{
  var Campus = document.frm.txtCampus.value;
  var Oferta = document.frm.txtOferta.value;
    if (document.frm.txtCampus.value.length==''){
        swal("Error al guardar", "Debe seleccionar el campus.", "error");
        document.getElementById("txtCampus").focus();
        return 0;
    }
    if (document.frm.txtOferta.value.length==''){
        swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
    if (document.frm.txtClave.value.length==''){
        swal("Error al guardar", "Debe escribir la clave del grupo.", "error");
        document.getElementById("txtClave").focus();
        return 0;
    }


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta clave de grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Clave de grupo guardada correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='addGrupo.php?C='+Campus+'&O='+Oferta; //direcciona la pagina madre
				}
        if(data==2){
					swal("Error al guardar", "La clave ya existe, favor de ingresar otra.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==3){
					swal("Error al guardar", "La clave de grupo no esta bien escrita.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==0){
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function val_addMatr()
{
  var Oferta = document.getElementById("txtOferta").value;
  var Grupo = document.getElementById("txtGrupo").value;
  var Tipo = document.getElementById("txtTipo").value;
  var TipoGuardar = "addMatricula";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea generar estas matr\u00EDculas?",
		text: "Al generar estas matr\u00EDculas se organizar\u00E1 a partir del Apellido Paterno",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
//alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Matr\u00EDculas generadas correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adMatricula.php?O='+Oferta+'&G='+Grupo; //direcciona la pagina madre
				}
        if(data==2){
					swal("Error al guardar", "Las matr\u00EDculas ya exiten, favor de verificar.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==0){
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function adAddCicloEscV(){
  var Tipo = document.getElementById("txtTipo").value;

	if (document.frm.txtTipo.value.length==''){
        swal("Error al guardar", "Debe seleccionar el tipo.", "error");
        document.getElementById("txtTipo").focus();
        return 0;
    }
    if (document.frm.datepicker1.value.length==''){
        swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("datepicker1").focus();
        return 0;
    }
    if (document.frm.datepicker2.value.length==''){
        swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
        document.getElementById("datepicker2").focus();
        return 0;
    }
    if (document.frm.txtCiclo.value.length==''){
        swal("Error al guardar", "Debe escribir el ciclo escolar.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
    }
    if (document.frm.txtPeriodo.value.length==''){
        swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
        document.getElementById("txtPeriodo").focus();
        return 0;
    }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este periodo de ciclo escolar?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
          //alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Periodo de ciclo escolar creado correctamente.", "success");
					document.getElementById("frm").reset();
          //parent.location.href='adAddCicloEsc.php'; //direcciona la pagina madre
          parent.location.href='adAddCicloEsc.php?Tipo='+Tipo; //direcciona la pagina madre
				}
        if(data==2){
					swal("Error al guardar", "El ciclo escolar ya existe, favor de ingresar otra.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==0){
					swal("ERROR", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}


function updCicloEscV()
{
  var Tipo = document.getElementById("Tipo").value;
  var Anio = document.getElementById("Anio").value;
  var IdCiclo = document.getElementById("IdCiclo").value;
  var FecIni = document.getElementById("txtFecIni").value;
  var FecFin = document.getElementById("txtFecFin").value;
  var Codigo = document.getElementById("txtCodigo").value;
  var TipoGuardar = "updCicloEscV";

	if (FecIni==''){
        swal("Error al guardar", "Debe escribir la fecha inicial.", "error");
        document.getElementById("txtFecIni").focus();
        return 0;
    }
    if (FecFin==''){
        swal("Error al guardar", "Debe escribir la fecha final.", "error");
        document.getElementById("txtFecFin").focus();
        return 0;
    }
    if (Codigo==''){
        swal("Error al guardar", "Debe escribir el ciclo.", "error");
        document.getElementById("txtCodigo").focus();
        return 0;
    }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar este ciclo escolar?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Codigo=' + Codigo;
			//var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Actualizado correctamente", "Ciclo escolar actualizado correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adAddCicloEsc.php?Tipo='+Tipo; //direcciona la pagina madre
				}

        if(data==0){
					swal("ERROR", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function addSubPeriodo()
{
  var Sub = document.getElementById("txtSub").value;
  var IdCiclo = document.getElementById("IdCiclo").value;
  var FecIni = document.getElementById("datepicker3").value;
  var FecFin = document.getElementById("datepicker4").value;
  var Codigo = document.getElementById("txtCodigo").value;
  var TipoGuardar = "addSubPeriodo";
  var employee_id = IdCiclo;

	if (Sub==''){
        swal("Error al guardar", "Debe seleccionar el SubPeriodo.", "error");
        document.getElementById("txtSub").focus();
        return 0;
    }
  if (Codigo==''){
      swal("Error al guardar", "Debe escribir el SubPeriodo.", "error");
      document.getElementById("txtCodigo").focus();
      return 0;
  }
  if (FecIni==''){
        swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("datepicker3").focus();
        return 0;
    }
    if (FecFin==''){
        swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
        document.getElementById("datepicker3").focus();
        return 0;
    }


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este SubPeriodo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&FecIni=' + FecIni + '&FecFin=' + FecFin + '&Codigo=' + Codigo + '&Sub=' + Sub;
			//var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Agregado correctamente", "El SubPeriodo ha sido agregado correctamente.", "success");
					document.getElementById("frm").reset();
          $.ajax({
               url:"formConsulta/addSubPeriodo.php",
               method:"POST",
               data:{employee_id:employee_id},
               success:function(data){
                    $('#employee_detail4').html(data);
                    $('#dataModal4').modal('show');
               }
          });

				}
        if(data==2){
					swal("Error al agregar", "No se puede agregar ya que existe un SubPeriodo.", "error");
					document.getElementById("frm").reset();
				}

        if(data==0){
					swal("ERROR", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function addApertura()
{
  var Parcial = document.getElementById("txtParcial").value;
  var FecFin = document.getElementById("datepicker4").value;
  var IdCiclo = document.getElementById("IdCiclo").value;
  var Tipo = document.getElementById("Tipo").value;
  var TipoGuardar = "addApertura";
  var employee_id = IdCiclo;

	if(Parcial==''){
        swal("Error al guardar", "Debe seleccionar el parcial.", "error");
        document.getElementById("txtParcial").focus();
        return 0;
    }
  if(FecFin==''){
      swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
      document.getElementById("datepicker4").focus();
      return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta apertura de calificaciones?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&Parcial=' + Parcial + '&FecFin=' + FecFin + '&Tipo=' + Tipo;
			//var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Agregado correctamente", "La apertura de califiacion ha sido agregado correctamente.", "success");
					document.getElementById("frm").reset();
          $.ajax({
               url:"formConsulta/addApertura.php",
               method:"POST",
               data:{employee_id:employee_id, Tipo:Tipo},
               success:function(data){
                 if(Tipo == "N"){
                    $('#employee_detail4').html(data);
                    $('#dataModal4').modal('show');
                  } else {
                    $('#employee_detail3').html(data);
                    $('#dataModal3').modal('show');
                  }
               }
          });

				}
        if(data==2){
					swal("Error al agregar", "No se puede agregar ya que existe un parcial.", "error");
					document.getElementById("frm").reset();
				}

        if(data==0){
					swal("ERROR", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function addTemas()
{
  var Temas = document.getElementById("txtTemas").value;
  var Cuatri = document.getElementById("txtCuatri").value;
  var Complejidad = document.getElementById("txtComplejidad").value;
  var IdPlan = document.getElementById("IdPlan").value;

  var employee_id = IdPlan;

	if (Temas==''){
        swal("Error al guardar", "Debe escribir la tendencia y/o temas actuales.", "error");
        document.getElementById("txtTemas").focus();
        return 0;
    }
  if (Cuatri==''){
      swal("Error al guardar", "Debe seleccionar el cuatrimestre.", "error");
      document.getElementById("txtCuatri").focus();
      return 0;
  }
  if (Complejidad==''){
      swal("Error al guardar", "Debe escribir la complejidad.", "error");
      document.getElementById("txtComplejidad").focus();
      return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9sta informaci\u00F3n?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      //var datos = 'TipoGuardar=' + TipoGuardar + '&IdPlan=' + IdPlan + '&Temas=' + Temas + '&FecFin=' + FecFin + '&Codigo=' + Codigo + '&Sub=' + Sub;
			var datos=$('#frmT5').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Agregado correctamente", "La tendencias y/o temas actuales ha sido agregado correctamente.", "success");
					document.getElementById("frm").reset();
          $.ajax({
               url:"formConsulta/addTemas.php",
               method:"POST",
               data:{employee_id:employee_id},
               success:function(data){
                    $('#employee_detail').html(data);
                    $('#dataModal').modal('show');
               }
          });

				}

        if(data==0){
					swal("Error al guardar", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function delSubPeriodo(IdCiclo, SubPeriodo)
{
  var TipoGuardar = "delSubPeriodo";
  var employee_id = IdCiclo;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este SubPeriodo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&SubPeriodo=' + SubPeriodo;
			//var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Eliminado correctamente", "El SubPeriodo ha sido eliminado correctamente.", "success");
					document.getElementById("frm").reset();
          $.ajax({
               url:"formConsulta/addSubPeriodo.php",
               method:"POST",
               data:{employee_id:employee_id},
               success:function(data){
                    $('#employee_detail4').html(data);
                    $('#dataModal4').modal('show');
               }
          });

				}


        if(data==0){
					swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function delApertura(IdApertura, IdCiclo){
  var Tipo = document.getElementById("Tipo").value;
  var TipoGuardar = "delApertura";
  var employee_id = IdCiclo;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este apertura?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + TipoGuardar + '&IdApertura=' + IdApertura;
			//var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Eliminado correctamente", "La apertura de este parcial ha sido eliminado correctamente.", "success");
					document.getElementById("frm").reset();
          $.ajax({
               url:"formConsulta/addApertura.php",
               method:"POST",
               data:{employee_id:employee_id, Tipo: Tipo},
               success:function(data){
                 if(Tipo == "N"){
                    $('#employee_detail4').html(data);
                    $('#dataModal4').modal('show');
                  } else {
                    $('#employee_detail3').html(data);
                    $('#dataModal3').modal('show');
                  }
               }
          });

				}


        if(data==0){
					swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function delTemas(IdTema, IdPlan)
{
  var TipoGuardar = "delTema";
  var employee_id = IdPlan;

	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este tema?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + TipoGuardar + '&IdTema=' + IdTema;
			//var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Eliminado correctamente", "El tema ha sido eliminado correctamente.", "success");
					document.getElementById("frm").reset();
          $.ajax({
               url:"formConsulta/addTemas.php",
               method:"POST",
               data:{employee_id:employee_id},
               success:function(data){
                    $('#employee_detail').html(data);
                    $('#dataModal').modal('show');
               }
          });

				}


        if(data==0){
					swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("ERROR", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}


function addEnlazar()
{
	if (document.frm.txtCiclo.value.length==''){
        swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
    }
    if (document.frm.txtGrupo.value.length==''){
        swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtGrupo").focus();
        return 0;
    }
    var Ciclo = document.frm.txtCiclo.value;
	swal({
		title: "\u00BFEst\u00E1 seguro que desea enlazar este ciclo escolar con este grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Ciclo escolar y grupo configurado correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adAddConfigCiclo.php?C='+Ciclo; //direcciona la pagina madre
				}
        if(data==2){
					swal("Error al guardar", "Este grupo ya se encuentra asociado a este ciclo escolar.", "error");
			//		document.getElementById("frm").reset();

				}
        if(data==0){
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar X01", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

function val_adUpdOferta()
{

	if (document.frm.txtTipo.value.length==''){
		swal("Error al guardar", "Seleccione tipo el tipo.", "error");
        document.getElementById("txtTipo").focus();
        return 0;
    }

	if (document.frm.txtNombre.value.length==''){
		swal("Error al guardar", "Escribe el nombre de la oferta educativa.", "error");
        return 0;
    }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		// text: "Al actualizar esta oferta educativa ya estar\u00E1 visible.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
  function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='updOferta';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
	// function (isConfirm) {
	// 	if (isConfirm) {
	// 		var datos=$('#frm').serialize();
	// 		$.ajax({
	// 			type:"POST",
	// 			url:"insertar.php",
	// 			data:datos,
	// 			success:function(data){
	// 			}
	// 		})
	// 		.done(function(data) {
	// 			if(data==1){
	// 				swal("Actualizado correctamente", "Actualizado correctamente", "success");
	// 				document.getElementById("frm").reset();
  //         parent.location.href='adSelOferta.php'; //direcciona la pagina madre
	// 			}else{
	// 				swal("Error al actualizar", "No se puede actualizar, verifique sus datos..", "error");
	// 			}
	// 		})
	// 		.error(function(data) {
	// 			swal("Error al actualizar 0x01", "No se puede actualizar, comuniquese con el desarrollador.", "error");
	// 		});
	// 	}
	// });
}



function add_reastdsa()
{

var tipo = document.getElementById("editor").innerHTML;

// var str = document.getElementById("demo").innerHTML;
  var res = tipo.replace("'", "´");
  // document.getElementById("demo").innerHTML = res;

document.getElementById("Texto").value=res;
    swal({
		title: "¿Est\u00E1 seguro que desea guardar estos datos de este editor?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
  function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='updEditor';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});

}

function add_observ()
{

var tipo = document.getElementById("editor").innerHTML;
var TipoG = document.getElementById("Tipo").value;

// var str = document.getElementById("demo").innerHTML;
  var res = tipo.replace("'", "´");
  // document.getElementById("demo").innerHTML = res;

document.getElementById("Texto").value=res;
    swal({
		title: "¿Est\u00E1 seguro que desea actualizar este trabajo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
  function (isConfirm) {
		if (isConfirm) {
			document.frm.Tipo.value=TipoG;document.frm.Mov.value='updEditorObs';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});

}

function val_adAddModulo()
{
  var Tipo = document.frm.IdPermiso.value;
  var Code = document.frm.txtCode.value;
  var Total = Code.length;

  if (Total != 9){
    swal("Error al guardar", "Favor de verificar la clave de la asignatura.", "error");
        return 0;
    }

  if (document.frm.txtCode.value.length==''){
		swal("Error al guardar", "Escribe el c\u00F3digo de la asignatura.", "error");
        document.getElementById("txtCode").focus();
        return 0;
    }
	if (document.frm.txtModulo.value.length==''){
		swal("Error al guardar", "Escribe el nombre de la asignatura.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }



	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva asignatura?",
		text: "Al agregar este asignatura estar\u00E1 disponible para agregar datos.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
        if(data==2){
					swal("Error al guardar", "Ha ocurrido un error, la asignatura ya existe.", "error");
				}
				if(data==1){
					swal("Guardado correctamente", "Asignatura guardado correctamente.", "success");
					document.getElementById("frm").reset();
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_adUpdModulo()
{
  // var Tipo = document.frm.IdPermiso.value;
  // if(Tipo != 9){
  //   if (document.frm.txtOferta.value.length==''){
  //     swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
  //     document.getElementById("txtOferta").focus();
  //     return 0;
  //   }
  // }

	// if (document.frm.txtNo.value.length==''){
	// 	swal("Error al guardar", "Seleccione el n\u00FAmero de semestres y/o cuatrimestres.", "error");
  //       document.getElementById("txtNo").focus();
  //       return 0;
  //   }
  // if (document.frm.txtCode.value.length==''){
	// 	swal("Error al guardar", "Escribe la clave de la asignatura.", "error");
  //       document.getElementById("txtCode").focus();
  //       return 0;
  //   }
	if (document.frm.txtModulo.value.length==''){
		swal("Error al guardar", "Escribe el nombre de la asignatura.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }
	// if (document.frm.txtEstatus.value.length==''){
	// 	swal("Error al guardar", "Seleccione el estatus.", "error");
  //       document.getElementById("txtEstatus").focus();
  //       return 0;
  //   }
	// if (document.frm.txtCreditos.value.length==''){
	// 	swal("Error al guardar", "Escriba el total de cr\u00E9ditos.", "error");
  //       document.getElementById("txtCreditos").focus();
  //       return 0;
  //   }
	swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta asignatura?",
		// text: "Al actualizar est\u00E1 asignatura estar\u00E1 visible autom\u00E1ticamente.",
		type: "info",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Actualizado", "Asignatura actualizado correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adSelModulos.php'; //direcciona la pagina madre
				}else{
					swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al actualizar 0x02", "No se puede actualizar, comuniquese con el desarrollador", "error");
			});
		}
	});
}

function val_subAstura()
{

	if (document.frm.txtNombre.value.length==''){
		swal("Error al guardar", "Escribe el nombre del archivo.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }

  if (document.frm.txtArchivo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el archivo a subir.", "error");
        document.getElementById("txtArchivo").focus();
        return 0;
    }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		// text: "Al actualizar est\u00E1 asignatura estar\u00E1 visible autom\u00E1ticamente.",
		type: "info",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadDoAlum").style.display = 'block';
      document.frm.Mov.value='Guardar';document.frm.submit();
		}
	});
}

function val_subFileDocs(){
  if (document.frm.txtGrado.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
     document.getElementById("txtGrado").focus();
     return 0;
  }

  if (document.frm.txtNombre.value.length==''){
	   swal("Error al guardar", "Debe escribir el nombre del documento.", "error");
     document.getElementById("txtNombre").focus();
     return 0;
  }
  if (document.frm.txtCiclo.value.length==''){
     swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
     document.getElementById("txtCiclo").focus();
     return 0;
  }
  if (document.frm.txtArchivo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el documento a subir.", "error");
     document.getElementById("txtArchivo").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		// text: "Al actualizar est\u00E1 asignatura estar\u00E1 visible autom\u00E1ticamente.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadDoAlum").style.display = 'block';
      document.frm.Mov.value='uploadDocs';document.frm.submit();
		}
	});
}

function val_subDoscMx(){
	if (document.frm.txtOferta.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
     document.getElementById("txtOferta").focus();
     return 0;
  }
  if (document.frm.txtModulo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la asignatura.", "error");
     document.getElementById("txtModulo").focus();
     return 0;
  }
  if (document.frm.txtModalidad.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
     document.getElementById("txtModalidad").focus();
     return 0;
  }
  if (document.frm.txtTema.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
     document.getElementById("txtTema").focus();
     return 0;
  }
  if (document.frm.txtNombre.value.length==''){
	   swal("Error al guardar", "Debe escribir el nombre del documento.", "error");
     document.getElementById("txtNombre").focus();
     return 0;
  }

  if (document.frm.txtArchivo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el documento a subir.", "error");
     document.getElementById("txtArchivo").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadDoAlum").style.display = 'block';
      document.frm.Mov.value='uploadDocsMx';document.frm.submit();
		}
	});
}

function val_uplImgMod(){
	if (document.frm.txtOferta.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
     document.getElementById("txtOferta").focus();
     return 0;
  }
  if (document.frm.txtTema.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
     document.getElementById("txtTema").focus();
     return 0;
  }
  if (document.frm.txtArchivo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar la imagen.", "error");
     document.getElementById("txtArchivo").focus();
     return 0;
  }


	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadDoAlum").style.display = 'block';
      document.frm.Mov.value='uplDocsMx';document.frm.submit();
		}
	});
}

function val_sbisDocs()
{

	if (document.frm.txtTipo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
     document.getElementById("txtTipo").focus();
     return 0;
  }
  if (document.frm.txtArchivo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el archivo.", "error");
     document.getElementById("txtArchivo").focus();
     return 0;
  }

  document.getElementById("imgLoadDoAlum").style.display = 'block';
  document.frm.Mov.value='upl_docsAlumno';
  document.frm.submit();

}

function val_subAvisosDocs()
{

	if (document.frm.txtUsuario.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de usuario.", "error");
     document.getElementById("txtUsuario").focus();
     return 0;
  }
  if (document.frm.txtTipo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de archivo.", "error");
     document.getElementById("txtTipo").focus();
     return 0;
  }

  if (document.frm.txtTitulo.value.length==''){
	   swal("Error al guardar", "Debe escribir el titulo del aviso.", "error");
     document.getElementById("txtTitulo").focus();
     return 0;
  }
  if (document.frm.txtNombre.value.length==''){
	   swal("Error al guardar", "Debe escribir el nombre del aviso.", "error");
     document.getElementById("txtNombre").focus();
     return 0;
  }

  if (document.frm.txtArchivo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el documento a subir.", "error");
     document.getElementById("txtArchivo").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		// text: "Al actualizar est\u00E1 asignatura estar\u00E1 visible autom\u00E1ticamente.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadDoAlum").style.display = 'block';
      document.frm.Mov.value='GuardarDocs';document.frm.submit();
		}
	});
}

function val_loadAvs(){
  if (document.frm.txtTipo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de archivo.", "error");
     document.getElementById("txtTipo").focus();
     return 0;
  }

  if (document.frm.txtTitulo.value.length==''){
	   swal("Error al guardar", "Debe escribir el titulo del aviso.", "error");
     document.getElementById("txtTitulo").focus();
     return 0;
  }
  if (document.frm.txtArchivo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el documento a subir.", "error");
     document.getElementById("txtArchivo").focus();
     return 0;
  }

	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		// text: "Al actualizar est\u00E1 asignatura estar\u00E1 visible autom\u00E1ticamente.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadDoAlum").style.display = 'block';
      document.frm.Mov.value='GuardarDocs';document.frm.submit();
		}
	});
}


function val_adAddModDatos()
{
	if (document.frm.txtOferta.value.length==''){
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
	if (document.frm.txtModulo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el m\u00F3dulo.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }
	if (document.frm.txtObjetivo.value.length==''){
		swal("Error al guardar", "Debe escribir los objetivos del m\u00F3dulo.", "error");
        document.getElementById("txtObjetivo").focus();
        return 0;
    }
	if (document.frm.txtTema.value.length==''){
		swal("Error al guardar", "Debe escribir los temas.", "error");
        document.getElementById("txtTema").focus();
        return 0;
    }
	if (document.frm.txtMetodologia.value.length==''){
		swal("Error al guardar", "Debe escribir la metodologia.", "error");
        document.getElementById("txtMetodolog\u00EDa").focus();
        return 0;
    }
	if (document.frm.txtEvaluacion.value.length==''){
		swal("Error al guardar", "Debe escribirla evaluaci\u00F3n.", "error");
        document.getElementById("txtEvaluacion").focus();
        return 0;
    }
	if (document.frm.txtBibliografia.value.length==''){
		swal("Error al guardar", "Debe escribir la bibliograf\u00EDa.", "error");
        document.getElementById("txtBibliografia").focus();
        return 0;
    }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar estos datos del m\u00F3dulo?",
		text: "Al agregar esta informaci\u00F3n estara visible para todos los que lleven este m\u00F3dulo.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}


function addNewGrupo()
{
	if (document.frm.txtGrupo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtGrupo").focus();
        return 0;
    }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea asignarlo a este grupo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='AddGropoAl';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function addNewAsignatura(valor)
{

document.frm.IdAsig.value=valor;


    swal({
		title: "\u00BFEst\u00E1 seguro que desea asignar a este alumno a esta materia?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='AddModuloCFST';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_addAvisos()
{
	if (document.frm.txtDocente.value.length==''){
		swal("Error al guardar", "Debe seleccionar el docente.", "error");
        document.getElementById("txtDocente").focus();
        return 0;
    }
  if (document.frm.txtEducativa.value.length==''){
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        document.getElementById("txtEducativa").focus();
        return 0;
    }
	if (document.frm.txtModulo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el m\u00F3dulo.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }
	if (document.frm.txtTitulo.value.length==''){
		swal("Error al guardar", "Debe escribir el t\u00EDtulo del aviso.", "error");
        document.getElementById("txtTitulo").focus();
        return 0;
    }
	if (document.frm.txtMensaje.value.length==''){
		swal("Error al guardar", "Debe escribir el mensaje.", "error");
        document.getElementById("txtMensaje").focus();
        return 0;
    }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este aviso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_adActModDatos()
{
	if (document.frm.txtOferta.value.length==''){
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
	if (document.frm.txtModulo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el m\u00F3dulo.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }
	if (document.frm.txtObjetivo.value.length==''){
		swal("Error al guardar", "Debe escribir los objetivos del m\u00F3dulo.", "error");
        document.getElementById("txtObjetivo").focus();
        return 0;
    }
	if (document.frm.txtIntro.value.length==''){
		swal("Error al guardar", "Debe escribir la introducci\u00F3n de la asignatura.", "error");
        document.getElementById("txtIntro").focus();
        return 0;
    }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos?",
		text: "Al actualizar esta informaci\u00F3n estara visible para todos los que lleven esta asignatura.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Actualizar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_doActModDatos()
{	var id = document.getElementById("Id").value;
	if (document.frm.txtObjetivo.value.length==''){
		swal("Error al guardar", "Debe escribir los objetivos del m\u00F3dulo.", "error");
        document.getElementById("txtObjetivo").focus();
        return 0;
    }
	if (document.frm.txtTema.value.length==''){
		swal("Error al guardar", "Debe escribir los temas.", "error");
        document.getElementById("txtTema").focus();
        return 0;
    }
	if (document.frm.txtMetodologia.value.length==''){
		swal("Error al guardar", "Debe escribir la metodolog\u00EDa.", "error");
        document.getElementById("txtMetodologia").focus();
        return 0;
    }
	if (document.frm.txtEvaluacion.value.length==''){
		swal("Error al guardar", "Debe escribir la evaluaci\u00F3n.", "error");
        document.getElementById("txtEvaluacion").focus();
        return 0;
    }
	if (document.frm.txtBibliografia.value.length==''){
		swal("Error al guardar", "Debe escribir la bibliograf\u00EDa.", "error");
        document.getElementById("txtBibliografia").focus();
        return 0;
    }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar estos datos del m\u00F3dulo?",
		text: "Al actualizar esta informaci\u00F3n estar\u00E1 visible para todos los que lleven este m\u00F3dulo.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.IdE.value=id;document.frm.Mov.value='Actualizar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_adAddModConfig()
{
	if (document.frm.txtModulo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el m\u00F3dulo.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }
  if (document.frm.txtCicloEscolar.value.length==''){
		swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
        document.getElementById("txtCicloEscolar").focus();
        return 0;
    }

	if (document.frm.txtClaveGrp.value.length==''){
		swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtClaveGrp").focus();
        return 0;
    }
    // if (document.frm.txt_parcial.value.length==''){
    //   swal("Error al guardar", "Debe seleccionar el número de parcial / módulo.", "error");
    //       document.getElementById("txt_parcial").focus();
    //       return 0;
    //   }
	if (document.frm.txtDocente.value.length==''){
		swal("Error al guardar", "Debe seleccionar el docente.", "error");
        document.getElementById("txtDocente").focus();
        return 0;
    }
    if (document.frm.txtTutor.value.length==''){
  		swal("Error al guardar", "Debe seleccionar el tutor.", "error");
          document.getElementById("txtTutor").focus();
          return 0;
      }


	if (document.frm.datepicker.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("datepicker").focus();
        return 0;
    }

	if (document.frm.datepicker2.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
        document.getElementById("datepicker2").focus();
        return 0;
    }


    swal({
		title: "\u00BFEsta seguro de la configuraci\u00F3n de esta asignatura?",
		text: "Al asignar esta asignatura el docente podra acceder a la informaci\u00F3n",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
        if(data==2){
					swal("Error al guardar", "Esta asignatura ya ha sido otorgado anteriormente, verifique sus datos.", "error");
					document.getElementById("frm").reset();
				}
				if(data==1){
					swal("Guardado correctamente", "Asignatura del docente agregado correctamente.", "success");
					parent.location.href='adAddModConfig.php'; //direcciona la pagina madre
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x03", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_adUpdModConfig()
{
  var IdDocActual = document.frm.IdDocente.value;
  var IdDocNuevo = document.frm.txtDocente.value;

  var Texto = "";
  if(IdDocActual != IdDocNuevo){
    Texto = "¡¡¡Atención!!! \n \u00BFEst\u00E1 seguro de cambiar de docente?\n\n ";
  }

	if (document.frm.txtDocente.value.length==''){
		swal("Error al guardar", "Debe seleccionar el docente.", "error");
        document.getElementById("txtDocente").focus();
        return 0;
    }
    if (document.frm.txtTutor.value.length==''){
  		swal("Error al guardar", "Debe seleccionar el tutor.", "error");
          document.getElementById("txtTutor").focus();
          return 0;
      }
	if (document.frm.txt_parcial.value.length==''){
		swal("Error al guardar", "Debe seleccionar el número de parcial / módulo.", "error");
        document.getElementById("txt_parcial").focus();
        return 0;
    }
  if (document.frm.datepicker.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("datepicker").focus();
        return 0;
  }
  if (document.frm.datepicker2.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
        document.getElementById("datepicker2").focus();
        return 0;
  }




    swal({
      title: Texto + '\u00BFEst\u00E1 seguro que desea actualizar los datos de esta asignaci\u00F3n?',
		text: "Al actualizar los cambios se veran reflejados autom\u00E1ticamente, favor de verificar",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Actualizado correctamente", "Datos actualizados correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adSelAsigMod.php'; //direcciona la pagina madre
				}else{
					swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al actualizar 0x04", "No se puede actualizar, comuniquese con el desarrollador", "error");
			});
		}
	});
}

function add_envioEditor()
{
  var IdParcialDoc = document.getElementById("IdParcialDoc").value;
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;

    swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar este trabajo al asesor acad\u00E9mico?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Enviado correctamente", "Actividad enviada correctamente al asesor.", "success");
					document.getElementById("frm").reset();
          parent.location.href='miEditor.php?toks=1572450355'+IdActividadDoc+'&tok=1572450355'+IdParcialDoc; //direcciona la pagina madre
				}else{
					swal("Error al enviar", "No se puede enviar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al actualizar 0x04", "No se puede enviar, comuniquese con el desarrollador", "error");
			});
		}
	});
}

function upd_envioEditor()
{
  var IdEditor = document.getElementById("IdEditor").value;
  var TipoG = document.getElementById("Tipo").value;

    swal({
		title: "\u00BFEst\u00E1 seguro que desea regresar este trabajo al alumno para que revise las observaciones?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Enviado correctamente", "Trabajo regresado al alumno correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='doEditor.php?toks=1572459870'+IdEditor+'&T='+TipoG; //direcciona la pagina madre
				}else{
					swal("Error al enviar", "No se puede enviar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al actualizar 0x04", "No se puede enviar, comuniquese con el desarrollador", "error");
			});
		}
	});
}



function saveCurso()
{
  var IdCurso = document.frm.txtOferta.value;
  var IdCampus = document.frm.IdCampus.value;
 var Curso = document.frm.txtCurso.value;


	if (document.frm.txtCurso.value.length==''){
	   swal("Error al guardar", "Debe escribir el nombre del curso.", "error");
      document.getElementById("txtCurso").focus();
      return 0;
  }
  var TipoGuardar = "savCurso";
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo curso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos = 'TipoGuardar=' + TipoGuardar + '&IdCurso=' + IdCurso + '&Curso=' + Curso + '&IdCampus=' + IdCampus;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
//alert(data);
				}
			})
			.done(function(data) {

				if(data==1){
					swal("Guardado correctamente", "Nombre del curso agregado correctamente.", "success");
					parent.location.href='addmiscursos.php'; //direcciona la pagina madre
				}else{
					swal("Error al guardar", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x05", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_adAddUsuario()
{
	var tipo = document.getElementById("txtTipo").value;

	if (document.frm.txtTipo.value.length==''){
	   swal("Error al guardar", "Debe seleccionar el tipo de usuario.", "error");
      document.getElementById("txtTipo").focus();
      return 0;
  }
  if (document.frm.txtCampus.value.length==''){
    swal("Error al guardar", "Debe seleccionar el campus.", "error");
    document.getElementById("txtCampus").focus();
    return 0;
  }
  if(tipo == 3){
		if (document.frm.txtOferta.value.length==''){
			swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
			document.getElementById("txtOferta").focus();
			return 0;
		}
  }

	if (document.frm.txtNombre.value.length==''){
		swal("Error al guardar", "Debe escribir el nombre del usuario.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
	if (document.frm.txtAPaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido paterno.", "error");
        document.getElementById("txtAPaterno").focus();
        return 0;
    }
	if (document.frm.txtAMaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido materno.", "error");
        document.getElementById("txtAMaterno").focus();
        return 0;
    }
    if (document.frm.txtSexo.value.length==''){
  		swal("Error al guardar", "Debe seleccionar el sexo.", "error");
          document.getElementById("txtSexo").focus();
          return 0;
      }
	if (document.frm.txtTelefono.value.length==''){
		swal("Error al guardar", "Debe escribir su n\u00FAmero de tel\u00E9fono.", "error");
        document.getElementById("txtTelefono").focus();
        return 0;
    }
	if (document.frm.txtCorreo.value.length==''){
		swal("Error al guardar", "Debe escribir su correo.", "error");
        document.getElementById("txtCorreo").focus();
        return 0;
    }
    if (document.frm.txtUser.value.length==''){
  		swal("Error al guardar", "Debe escribir el usuario.", "error");
          document.getElementById("txtUser").focus();
          return 0;
      }
      if (document.frm.txtPass.value.length==''){
    		swal("Error al guardar", "Debe escribir el password.", "error");
            document.getElementById("txtPass").focus();
            return 0;
        }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {

				if(data==1){
					swal("Guardado correctamente", "Usuario agregado correctamente.", "success");
					document.getElementById("frm").reset();
				}
        if(data==2){
					swal("Error al guardar", "El correo agregardo ya se encuentra activo.", "error");

				}
        if(data==0){
					swal("Error al guardar", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x05", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_addUsuar(){
  if (document.frm.txtCampus.value.length==''){
    swal("Error al guardar", "Debe seleccionar el campus.", "error");
    document.getElementById("txtCampus").focus();
    return 0;
  }
  if (document.frm.txtOferta.value.length==''){
    swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
    document.getElementById("txtOferta").focus();
    return 0;
  }
	if (document.frm.txtNombre.value.length==''){
		swal("Error al guardar", "Debe escribir el nombre del usuario.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
	if (document.frm.txtAPaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido paterno.", "error");
        document.getElementById("txtAPaterno").focus();
        return 0;
    }
	if (document.frm.txtAMaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido materno.", "error");
        document.getElementById("txtAMaterno").focus();
        return 0;
    }
	if (document.frm.txtCorreo.value.length==''){
		swal("Error al guardar", "Debe escribir su correo.", "error");
        document.getElementById("txtCorreo").focus();
        return 0;
    }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {

				if(data==1){
					swal("Guardado correctamente", "Usuario agregado correctamente.", "success");
					document.getElementById("frm").reset();
				}
        if(data==2){
					swal("Error al guardar", "El usuario ya esta registrado con este correo que escribio.", "error");
				}
        if(data==4){
					swal("Error al guardar", "Usted ya no tiene espacio para dar de alta más usuarios.", "error");
					document.getElementById("frm").reset();
				}
        // else{
				// 	swal("Error al guardar", "No se puede agregar, verifique sus datos.", "error");
				// }
			})
			.error(function(data) {
				swal("Error al guardar 0x05", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function add_alumno()
{
  Campus = document.frm.txtCampus.value;
  Oferta = document.frm.txtOferta.value;
  if (document.frm.txtCampus.value.length==''){
    swal("Error al guardar", "Debe seleccionar el campus.", "error");
    document.getElementById("txtCampus").focus();
    return 0;
  }

	if (document.frm.txtGrupo.value.length==''){
		swal("Error al guardar", "Debe seleccionar  el grupo.", "error");
		document.getElementById("txtGrupo").focus();
		return 0;
	}

  if (document.frm.txtOferta.value.length==''){
		swal("Error al guardar", "Debe seleccionar la oferta educativa.", "error");
		document.getElementById("txtOferta").focus();
		return 0;
	}

	if (document.frm.txtNombre.value.length==''){
		swal("Error al guardar", "Debe escribir el nombre del usuario.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
	if (document.frm.txtAPaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido paterno.", "error");
        document.getElementById("txtAPaterno").focus();
        return 0;
    }
	if (document.frm.txtAMaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido materno.", "error");
        document.getElementById("txtAMaterno").focus();
        return 0;
    }


    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este alumno?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
          //alert(data);
				}
			})
			.done(function(data) {

				if(data==1){
					swal("Guardado correctamente", "Alumno agregado correctamente.", "success");
					parent.location.href='adAddAlumno.php?C='+Campus+'&O='+Oferta; //direcciona la pagina madre
				}else{
					swal("Error al guardar", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x05", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function add_alumno_ex(){
  var IdGrupo = document.getElementById("txtGrupo").value;
  var IdPlan = document.getElementById("txtPlan").value;
	if (document.frm.txtGrupo.value.length==''){
		swal("Error al guardar", "Debe seleccionar  el grupo.", "error");
		document.getElementById("txtGrupo").focus();
		return 0;
	}
  if (document.frm.txtPlan.value.length==''){
		swal("Error al guardar", "Debe seleccionar el plan de pago.", "error");
		document.getElementById("txtPlan").focus();
		return 0;
	}

  if (document.frm.txtTelefono.value.length==''){
  swal("Error al guardar", "Debe escribir el numero de celular.", "error");
      document.getElementById("txtTelefono").focus();
      return 0;
  }
  if (document.frm.txtTipo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el tipo de usuario.", "error");
		document.getElementById("txtTipo").focus();
		return 0;
	}

	if (document.frm.txtNombre.value.length==''){
		swal("Error al guardar", "Debe escribir el nombre del usuario.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
	if (document.frm.txtAPaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido paterno.", "error");
        document.getElementById("txtAPaterno").focus();
        return 0;
    }
	if (document.frm.txtAMaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido materno.", "error");
        document.getElementById("txtAMaterno").focus();
        return 0;
    }



    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este usuario externo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
          //alert(data);
				}
			})
			.done(function(data) {

				if(data==1){
					swal("Guardado correctamente", "Usuario externo agregado correctamente.", "success");
					parent.location.href='captura_externo.php?Grp='+IdGrupo+'&Cal='+IdPlan; //direcciona la pagina madre
				}else{
					swal("Error al guardar", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x05", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_adUpdUsuario()
{
  var IdCampus = document.getElementById("IdCampus").value;
	var tipo = document.getElementById("txtTipo").value;

	if (document.frm.txtTipo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el tipo de usuario.", "error");
        document.getElementById("txtTipo").focus();
        return 0;
    }
    if (document.frm.txtNombre.value.length==''){
  		swal("Error al guardar", "Debe escribir el nombre del usuario.", "error");
          document.getElementById("txtNombre").focus();
          return 0;
      }
	if (document.frm.txtAPaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido paterno.", "error");
        document.getElementById("txtAPaterno").focus();
        return 0;
    }
	if (document.frm.txtAMaterno.value.length==''){
		swal("Error al guardar", "Debe escribir el apellido materno.", "error");
        document.getElementById("txtAMaterno").focus();
        return 0;
    }
    if (document.frm.txtSexo.value.length==''){
  		swal("Error al guardar", "Debe seleccionar el sexo.", "error");
          document.getElementById("txtSexo").focus();
          return 0;
      }

	if (document.frm.txtCorreo.value.length==''){
		swal("Error al guardar", "Debe escribir su correo.", "error");
        document.getElementById("txtCorreo").focus();
        return 0;
    }

	if (document.frm.txtUsuario.value.length==''){
		swal("Error al guardar", "Debe escribir el nombre de usuario.", "error");
        document.getElementById("txtUsuario").focus();
        return 0;
    }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar este usuario?",
		text: "Al actualizar este usuario los datos cambiar\u00E1n autom\u00E1ticamente",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			var datos=$('#frm').serialize();
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Actualizado correctamente", "Usuario actualizado correctamente.", "success");
					document.getElementById("frm").reset();
          parent.location.href='adSelAllUsuarios.php?IdC=45102'+IdCampus; //direcciona la pagina madre
				}else{
					swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al actualizar 0x06", "No se puede actualizar, comuniquese con el desarrollador", "error");
			});
		}
	});
}


function val_reePassword()
{
    swal({
		title: "\u00BFEst\u00E1 seguro que desea re-enviar datos a este usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
  function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='ReEnviar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function adAddAlumnoConfigM()
{
	if (document.frm.txtMatricula.value.length==''){
		swal("Error al guardar", "Debe poner el n\u00FAmero de matr\u00EDcula.", "error");
        document.getElementById("txtMatricula").focus();
        return 0;
    }
	if (document.frm.txtAnio.value.length==''){
		swal("Error al guardar", "Debe seleccionar el año.", "error");
        document.getElementById("txtAnio").focus();
        return 0;
    }
	if (document.frm.txtGrado.value.length==''){
		swal("Error al guardar", "Debe seleccionar el grado.", "error");
        document.getElementById("txtGrado").focus();
        return 0;
    }
	if (document.frm.txtGrupo.value.length==''){
		swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtGrupo").focus();
        return 0;
    }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar estos datos?",
		text: "Al agregar estos datos ya estar\u00E1 dado de alta en el grupo",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}


function val_doAddActividades()
{
	var tipo = document.getElementById("txtTipoActividad").value;
	var id = document.getElementById("Id").value;
	if (document.frm.txtTipoActividad.value.length==''){
		swal("Error al guardar", "Debe seleccionar el tipo de actividad.", "error");
        document.getElementById("txtTipoActividad").focus();
        return 0;
    }
	if (document.frm.datepicker1.value.length==''){
		swal("Error al guardar", "Debe ingresar la fecha inicial.", "error");
        document.getElementById("datepicker1").focus();
        return 0;
    }
	if(tipo=="Lectura" || tipo=="Tarea" || tipo=="Examen") {
		if (document.frm.datepicker2.value.length==''){
			swal("Error al guardar", "Debe ingresar la fecha final.", "error");
			document.getElementById("datepicker2").focus();
			return 0;
		}
		if (document.frm.txtModalidad.value.length==''){
			swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
			document.getElementById("txtModalidad").focus();
			return 0;
		}
	}
  if(tipo=="Examen") {
    if (document.frm.txtDuracion.value.length==''){
			swal("Error al guardar", "Debe seleccionar la duraci\u00F3n del ex\u00E1men.", "error");
			document.getElementById("txtDuracion").focus();
			return 0;
		}
  }
	if (document.frm.txtTitulo.value.length==''){
		swal("Error al guardar", "Debe escribir el t\u00EDtulo.", "error");
        document.getElementById("txtTitulo").focus();
        return 0;
    }
	if (document.frm.txtDescripcion.value.length==''){
		swal("Error al guardar", "Debe escribir la descripci\u00F3n.", "error");
        document.getElementById("txtDescripcion").focus();
        return 0;
    }

	if(tipo=="Lectura" || tipo=="Tarea" || tipo=="Examen") {
    var total = document.getElementById("Total").value;
    var porcen = document.getElementById("txtPorcentaje").value;
    var maximo = parseInt(total) + parseInt(porcen);
    var resul = 100 - parseInt(total);
		if (document.frm.txtPorcentaje.value.length==''){
			swal("Error al guardar", "Debe escribir el porcentaje.", "error");
			document.getElementById("txtPorcentaje").focus();
			return 0;
		}

    if (maximo > 100){
			swal("Error al guardar", "Ya paso el total de porcentaje de 100%, el porcentaje deseado debe ser " + resul, "error");
			document.getElementById("txtPorcentaje").value = resul;
			return 0;
		}
  }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta actividad?",
		text: "Al agregar esta actividad ser\u00E1 visible para los alumnos.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.IdE.value=id;document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}


function val_updAddActividades()
{
	var tipo = document.getElementById("txtTipoActividad").value;
	var id = document.getElementById("Id").value;
	if (document.frm.txtTipoActividad.value.length==''){
		swal("Error al guardar", "Debe seleccionar el tipo de actividad.", "error");
        document.getElementById("txtTipoActividad").focus();
        return 0;
    }
	if (document.frm.datepicker1.value.length==''){
		swal("Error al guardar", "Debe ingresar la fecha inicial.", "error");
        document.getElementById("datepicker1").focus();
        return 0;
    }
	if(tipo=="Lectura" || tipo=="Tarea" || tipo=="Examen") {
		if (document.frm.datepicker2.value.length==''){
			swal("Error al guardar", "Debe ingresar la fecha final.", "error");
			document.getElementById("datepicker2").focus();
			return 0;
		}
		if (document.frm.txtModalidad.value.length==''){
			swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
			document.getElementById("txtModalidad").focus();
			return 0;
		}
	}
	if (document.frm.txtTitulo.value.length==''){
		swal("Error al guardar", "Debe escribir el t\u00EDtulo.", "error");
        document.getElementById("txtTitulo").focus();
        return 0;
    }
	if (document.frm.txtDescripcion.value.length==''){
		swal("Error al guardar", "Debe escribir la descripci\u00F3n.", "error");
        document.getElementById("txtDescripcion").focus();
        return 0;
    }
	if(tipo=="Lectura" || tipo=="Tarea" || tipo=="Examen") {
    var total = document.getElementById("Total").value;
    var porcen = document.getElementById("txtPorcentaje").value;
    var maximo = parseInt(total) + parseInt(porcen);
    var resul = 100 - parseInt(total);
		if (document.frm.txtPorcentaje.value.length==''){
			swal("Error al guardar", "Debe escribir el porcentaje.", "error");
			document.getElementById("txtPorcentaje").focus();
			return 0;
		}
    if (maximo > 100){
			swal("Error al guardar", "Ya paso el total del porcentaje de 100%, el porcentaje deseado debe ser " + resul, "error");
			document.getElementById("txtPorcentaje").value = resul;
			return 0;
		}
  }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar esta actividad?",
		text: "Al actualizar esta actividad los cambios se ver\u00E1n reflejado en el sistema.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.IdE.value=id;document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_adAddAlumnoMod()
{
	var txtModulo = document.getElementById("txtModulo").value;

	if (txtModulo==""){
		swal("Error al guardar", "Debe seleccionar el m\u00F3dulo.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }


    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este m\u00F3dulo a este grupo?",
		text: "Al agregar este m\u00F3dulo a este grupo se genera autom\u00E1ticamente la nueva lista",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_doAddRecurso()
{
	var tipo = document.getElementById("Tipo").value;
  var txtNombre = document.getElementById("txtNombre").value;
  var txtTipoDoc = document.getElementById("txtTipoDoc").value;
  var archivo = document.getElementById("archivo").value;
	var video = document.getElementById("txtVideo").value;
	if (txtNombre==""){
		swal("Error al guardar", "Debe escribir el nombre.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
    if (txtTipoDoc==""){
		swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
        document.getElementById("txtTipoDoc").focus();
        return 0;
    }
  if(tipo==0){
	if (archivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  } else {
    if (video==""){
      swal("Error al guardar", "Debe pegar el iframe del video de YouTube.", "error");
          document.getElementById("txtVideo").focus();
          return 0;
      }
  }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este recurso a este m\u00F3dulo?",
		text: "Al agregar el recurso a este m\u00F3dulo autom\u00E1ticamente se podra visualizar",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadRecurso").style.display = 'block';
      document.getElementById("btnRecurso").disabled = true;
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_doAddBilbio()
{
	var tipo = document.getElementById("Tipo").value;
  var txtNombre = document.getElementById("txtNombre").value;
  var txtTipoDoc = document.getElementById("txtTipoDoc").value;
	var txtDescripcion = document.getElementById("txtDescripcion").value;
  var archivo = document.getElementById("archivo").value;
	if (txtNombre==""){
		swal("Error al guardar", "Debe escribir el nombre.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
    if (txtTipoDoc==""){
  		swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
          document.getElementById("txtTipoDoc").focus();
          return 0;
      }
	if (txtDescripcion==""){
		swal("Error al guardar", "Debe escribir la descripci\u00F3n.", "error");
        document.getElementById("txtDescripcion").focus();
        return 0;
    }
  if(tipo==0){
	if (archivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este documento?",
		text: "Al agregar el documento estar\u00E1 visible en la biblioteca digital",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      document.getElementById("imgLoadRecurso").style.display = 'block';
      document.getElementById("btnRecurso").disabled = true;
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_updateDocente()
{

	var txtNombre = document.getElementById("txtNombre").value;
  var txtAPaterno = document.getElementById("txtAPaterno").value;
  var txtAMaterno = document.getElementById("txtAMaterno").value;
	var txtCorreo = document.getElementById("txtCorreo").value;
  var txtTelefono = document.getElementById("txtTelefono").value;
  var txtSemblanza = document.getElementById("txtSemblanza").value;

	if (txtNombre==""){
		swal("Error al guardar", "Debe escribir el nombre.", "error");
        document.getElementById("txtNombre").focus();
        return 0;
    }
    if (txtAPaterno==""){
  		swal("Error al guardar", "Debe escribir su apellido paterno.", "error");
          document.getElementById("txtAPaterno").focus();
          return 0;
      }
	if (txtAMaterno==""){
		swal("Error al guardar", "Debe escribir la su apellido materno.", "error");
        document.getElementById("txtAMaterno").focus();
        return 0;
    }
	if (txtCorreo==""){
		swal("Error al guardar", "Debe escribir su correo.", "error");
        document.getElementById("txtCorreo").focus();
        return 0;
    }
    if (txtTelefono==""){
  		swal("Error al guardar", "Debe escribir su tel\u00E9fono.", "error");
          document.getElementById("txtTelefono").focus();
          return 0;
      }
      if (txtSemblanza==""){
    		swal("Error al guardar", "Debe escribir su semblanza.", "error");
            document.getElementById("txtSemblanza").focus();
            return 0;
        }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar sus datos?",
		text: "Al actualizar sus datos sera visible a todos sus alumnos.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_updateAlumno()
{

	var Correo = document.getElementById("txtCorreo").value;
  var Celular = document.getElementById("txtCelular").value;

	if (Correo==""){
	swal("Error al guardar", "Debe escribir su correo electrónico.", "error");
      document.getElementById("txtCorreo").focus();
      return 0;
  }
  if (Celular==""){
	swal("Error al guardar", "Debe escribir su número de celular.", "error");
      document.getElementById("txtCelular").focus();
      return 0;
  }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar sus datos?",
		text: "Al actualizar sus datos ser\u00E1 visible.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}

function val_update_datos(){

	var Correo = document.getElementById("txtCorreo").value;
  var Ingreso = document.getElementById("txtIngreso").value;
  var Celular = document.getElementById("txtCelular").value;
  var FecNac = document.getElementById("txtFecNac").value;

	if (Correo==""){
	swal("Error al guardar", "Debe escribir su correo.", "error");
      document.getElementById("txtCorreo").focus();
      return 0;
  }
  if (Celular==""){
	swal("Error al guardar", "Debe escribir su número de celular.", "error");
      document.getElementById("txtCelular").focus();
      return 0;
  }
  if (FecNac==""){
	swal("Error al guardar", "Debe seleccionar su fecha de nacimiento.", "error");
      document.getElementById("txtFecNac").focus();
      return 0;
  }
  if (Ingreso==""){
	swal("Error al guardar", "Debe seleccionar su fecha de ingreso en la institución.", "error");
      document.getElementById("txtIngreso").focus();
      return 0;
  }

    swal({
		title: "\u00BFEst\u00E1 seguro que desea actualizar sus datos?",
		text: "Al actualizar sus datos ser\u00E1 visible.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}


function val_alSelResponder()
{
	var archivo = document.getElementById("archivo").value;
  var NoArchivo = document.getElementById("NoArchivo").value;

	if (NoArchivo==""){
		swal("Error al guardar", "Debe seleccionar el n\u00FAmero de archivo.", "error");
        document.getElementById("NoArchivo").focus();
        return 0;
    }

	if (archivo==""){
		swal("ERROR", "Debe seleccionar el archivo a subir.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
    swal({
		title: "\u00BFEst\u00E1 seguro que desea subir este archivo?",
		text: "Al subir este archivo lo ver\u00E1 autom\u00E1ticamente el docente.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
      //$('#btnResponder').hide();uy
      document.getElementById("imgCargando").style.display = 'block';
      document.getElementById("btnResponder").disabled = true;
			document.frm.Mov.value='Guardar';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}



function val_upload(){
  var NoArchivo = document.getElementById("archivo").value;
	if (NoArchivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  subir_archivos();
}

function val_cargarTarea(){
  var suma = 0;
  chkLink1 = document.getElementById("chkLink1").checked;
  chkLink2 = document.getElementById("chkLink2").checked;
  chkLink3 = document.getElementById("chkLink3").checked;

  if(chkLink1 == true){ chkLink1 = 1; } else { chkLink1 = 0; }
  if(chkLink2 == true){ chkLink2 = 1; } else { chkLink2 = 0; }
  if(chkLink3 == true){ chkLink3 = 1; } else { chkLink3 = 0; }

  suma = (chkLink1 + chkLink2 + chkLink3);
  if(suma == 0){
    swal("Error al guardar", "Debe seleccionar una opcion donde se guardara el archivo", "error");
    return 0;
  }

  if(suma > 1){
    swal("Error al guardar", "Debe seleccionar una sola opcion donde se guardara el archivo.", "error");
    return 0;
  }



  var NoArchivo = document.getElementById("archivo").value;
	if (NoArchivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  subir_tarea();
}

function subir_tarea(){
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdParcial = document.getElementById("IdParcial").value;
  var IdTarea = document.getElementById("IdTarea").value;
  var IdSemana = document.getElementById("IdSemana").value;
  var NoSemana = document.getElementById("NoSemana").value;

  var NoLink = 0;
  chkLink1 = document.getElementById("chkLink1").checked;
  chkLink2 = document.getElementById("chkLink2").checked;
  chkLink3 = document.getElementById("chkLink3").checked;

  if(chkLink1 == true){ NoLink = 1; }
  if(chkLink2 == true){ NoLink = 2; }
  if(chkLink3 == true){ NoLink = 3; }


  let form = document.getElementById('form_subir');
  let barra_estado = form.children[5].children[0],
  span = barra_estado.children[0],
  boton_cancelar = form.children[3].children[1];
  barra_estado.classList.remove('barra_verde','barra_roja');
  var IdParcial = document.getElementById("IdParcial").value;

  //peticion
  let peticion = new XMLHttpRequest();

  //progreso

  document.getElementById("barra").style.display = 'block';
  // document.getElementById("btnSalir").style.display = 'none';
  document.getElementById("bntSubir").style.display = 'none';

  peticion.upload.addEventListener("progress", (event) =>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);
    console.log(porcentaje);
    barra_estado.style.width = porcentaje+'%';
    span.innerHTML = porcentaje+'%';
  });

  //finalizado
  peticion.addEventListener("load",()=>{
    barra_estado.classList.add('barra_verde');
    $('#dataTarea').modal('hide');
    // var IdTarea = 55;
    var TipoGuardar = "validar_tarea";
    $.ajax({
         url:"alumnos/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdTarea:IdTarea,IdAsignacion:IdAsignacion,NoLink:NoLink},
         success:function(data){

           if(data == 1){
             span.innerHTML = "Archivo subido correctamente.";
              swal({
               title: "El archivo se ha subido correctamente.",
               type: "success",
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 subirMiTarea(IdParcial,IdSemana, NoSemana, IdActividadDoc)
                 // miUnidad(IdParcial,IdSemana,NoSemana);
               }
             });
           } else {
             span.innerHTML = "Ha ocurrido un error.";
              swal({
               title: "Ha ocurrido un error, no se pudo subir el archivo.",
               type: "error",
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 subirMiTarea(IdParcial,IdSemana, NoSemana, IdActividadDoc)
               }
             });
           }

         }
    })
  });

  //Enviar datos
  peticion.open('post', 'subirTarea.php');
  peticion.send(new FormData(form));
  console.log();
}

function val_uploadTarea(){
  var suma = 0;
  chkLink1 = document.getElementById("chkLink1").checked;
  chkLink2 = document.getElementById("chkLink2").checked;
  chkLink3 = document.getElementById("chkLink3").checked;

  if(chkLink1 == true){ chkLink1 = 1; } else { chkLink1 = 0; }
  if(chkLink2 == true){ chkLink2 = 1; } else { chkLink2 = 0; }
  if(chkLink3 == true){ chkLink3 = 1; } else { chkLink3 = 0; }

  suma = (chkLink1 + chkLink2 + chkLink3);
  if(suma == 0){
    swal("Error al guardar", "Debe seleccionar una opcion donde se guardara el archivo", "error");
    return 0;
  }

  if(suma > 1){
    swal("Error al guardar", "Debe seleccionar una sola opcion donde se guardara el archivo.", "error");
    return 0;
  }



  var NoArchivo = document.getElementById("archivo").value;
	if (NoArchivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  subir_fileTarea();
}

function val_uploadTareaImg(){
  var suma = 0;
  imgDes = document.getElementById("txtImgDes").value;
  chkLink1 = document.getElementById("chkLink11").checked;
  chkLink2 = document.getElementById("chkLink22").checked;
  chkLink3 = document.getElementById("chkLink33").checked;

  if(chkLink1 == true){ chkLink1 = 1; } else { chkLink1 = 0; }
  if(chkLink2 == true){ chkLink2 = 1; } else { chkLink2 = 0; }
  if(chkLink3 == true){ chkLink3 = 1; } else { chkLink3 = 0; }

  suma = (chkLink1 + chkLink2 + chkLink3);
  if(suma == 0){
    swal("Error al guardar", "Debe seleccionar una opcion donde se guardara el archivo.", "error");
    return 0;
  }

  if(imgDes == ""){
    swal("Error al guardar", "Debe escribir el motivo por el cual va a subir esta imagen.", "error");
    return 0;
  }

  if(suma > 1){
    swal("Error al guardar", "Debe seleccionar una sola opcion donde se guardara el archivo.", "error");
    return 0;
  }



  var NoArchivo = document.getElementById("archivo").value;
	if (NoArchivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  subir_fileTareaImg();
}

function subir_fileTarea(){
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var NoLink = 0;
  chkLink1 = document.getElementById("chkLink1").checked;
  chkLink2 = document.getElementById("chkLink2").checked;
  chkLink3 = document.getElementById("chkLink3").checked;

  if(chkLink1 == true){ NoLink = 1; }
  if(chkLink2 == true){ NoLink = 2; }
  if(chkLink3 == true){ NoLink = 3; }


  let form = document.getElementById('form_subir');
  let barra_estado = form.children[5].children[0],
  span = barra_estado.children[0],
  boton_cancelar = form.children[3].children[1];
  barra_estado.classList.remove('barra_verde','barra_roja');
  var IdParcial = document.getElementById("IdParcial").value;

  //peticion
  let peticion = new XMLHttpRequest();

  //progreso

  document.getElementById("barra").style.display = 'block';
  // document.getElementById("btnSalir").style.display = 'none';
  document.getElementById("bntSubir").style.display = 'none';

  peticion.upload.addEventListener("progress", (event) =>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);
    console.log(porcentaje);
    barra_estado.style.width = porcentaje+'%';
    span.innerHTML = porcentaje+'%';
  });

  //finalizado
  peticion.addEventListener("load",()=>{
    barra_estado.classList.add('barra_verde');

    // var IdTarea = 55;
    var TipoGuardar = "search_file";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdActividadDoc:IdActividadDoc,IdAsignacion:IdAsignacion,IdUsua:IdUsua,NoLink:NoLink},
         success:function(data){

           if(data == 1){
             span.innerHTML = "Archivo subido correctamente.";
              swal({
               title: "Archivo subido correctamente.",
               type: "success",
               showCancelButton: true,
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               } else {
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               }
             });
           } else {
             span.innerHTML = "Ha ocurrido un error, no se pudo subir archivo.";
              swal({
               title: "Ha ocurrido un error, no se pudo subir el archivo.",
               type: "error",
               showCancelButton: true,
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               } else {
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               }
             });
           }

         }
    })
    // verificarFile();

  });

  //Enviar datos
  peticion.open('post', 'subir.php');
  peticion.send(new FormData(form));
  console.log();
}

function subir_fileTareaImg(){
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var NoLink = 0;
  chkLink1 = document.getElementById("chkLink11").checked;
  chkLink2 = document.getElementById("chkLink22").checked;
  chkLink3 = document.getElementById("chkLink33").checked;

  if(chkLink1 == true){ NoLink = 1; }
  if(chkLink2 == true){ NoLink = 2; }
  if(chkLink3 == true){ NoLink = 3; }


  let form = document.getElementById('form_subir');
  let barra_estado = form.children[5].children[0],
  span = barra_estado.children[0],
  boton_cancelar = form.children[3].children[1];
  barra_estado.classList.remove('barra_verde','barra_roja');
  var IdParcial = document.getElementById("IdParcial").value;

  //peticion
  let peticion = new XMLHttpRequest();

  //progreso

  document.getElementById("barra").style.display = 'block';
  // document.getElementById("btnSalir").style.display = 'none';
  document.getElementById("bntSubir").style.display = 'none';

  peticion.upload.addEventListener("progress", (event) =>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);
    console.log(porcentaje);
    barra_estado.style.width = porcentaje+'%';
    span.innerHTML = porcentaje+'%';
  });

  //finalizado
  peticion.addEventListener("load",()=>{
    barra_estado.classList.add('barra_verde');

    // var IdTarea = 55;
    var TipoGuardar = "search_file";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdActividadDoc:IdActividadDoc,IdAsignacion:IdAsignacion,IdUsua:IdUsua,NoLink:NoLink},
         success:function(data){

           if(data == 1){
             span.innerHTML = "Imagen subido correctamente.";
              swal({
               title: "Imagen subido correctamente.",
               type: "success",
               showCancelButton: true,
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               } else {
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               }
             });
           } else {
             span.innerHTML = "Ha ocurrido un error, no se pudo subir imagen.";
              swal({
               title: "Ha ocurrido un error, no se pudo subir el imagen.",
               type: "error",
               showCancelButton: true,
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               } else {
                 parent.location.href='alMiParcial.php?tok=1571774309'+IdParcial;
               }
             });
           }

         }
    })
    // verificarFile();

  });

  //Enviar datos
  peticion.open('post', 'subir.php');
  peticion.send(new FormData(form));
  console.log();
}

function subir_archivos(){
  let form = document.getElementById('form_subir');
  let barra_estado = form.children[4].children[0],
  span = barra_estado.children[0],
  boton_cancelar = form.children[3].children[1];
  barra_estado.classList.remove('barra_verde','barra_roja');

  //peticion
  let peticion = new XMLHttpRequest();

  //progreso
  document.getElementById("imgLoadDoDoc").style.display = 'block';
  document.getElementById("barra").style.display = 'block';
  // document.getElementById("btnSalir").style.display = 'none';
  document.getElementById("bntSubir").style.display = 'none';

  peticion.upload.addEventListener("progress", (event) =>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);
    console.log(porcentaje);
    barra_estado.style.width = porcentaje+'%';
    span.innerHTML = porcentaje+'%';
  });

  //finalizado
  peticion.addEventListener("load",()=>{
    barra_estado.classList.add('barra_verde');
    span.innerHTML = "Archivo subido correctamente";
    swal({
     title: "Video subido correctamente",
     type: "success",
     showCancelButton: true,
     confirmButtonColor: '#DD6B55',
     confirmButtonText: 'Aceptar',
   },
   function(isConfirm){
     if(isConfirm){
       parent.location.href='doSelDatosM.php';
     } else {
       parent.location.href='doSelDatosM.php';
     }
   });
  });

  //Enviar datos
  peticion.open('post', 'subir.php');
  peticion.send(new FormData(form));
}

function val_adAddGrupo(equipo, alumno)
{
  var id;
  var dat;
  var IdAsignacion = document.getElementById("Id").value;
  var Tipo = document.getElementById("TipoGuardar").value;

  var datos = 'IdAsignacion=' + IdAsignacion + '&Equipo=' + equipo + '&alumno=' + alumno + '&TipoGuardar=' + Tipo ;
  $.ajax({
    type:"POST",
    url:"insertar.php",
    data:datos,
    success:function(data){
    }
  })

}


function val_adAddCalificar(calificacion, tarea, alumno,usua,equipo)
{
  var calificacion = document.getElementById("txtCalificacion-"+tarea).value;
  var IdAsignacion = document.getElementById("Id").value;
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
  var Tipo = document.getElementById("TipoGuardar").value;
  var MaxCalificacion = document.getElementById("MaxCalificacion").value;
  var TipoCalificar = document.getElementById("TipoCalificar").value;

	swal({
		title: "\u00BFEst\u00E1 seguro de agregar esta calificaci\u00F3n?",
		//text: "Al agregar este alumno oferta educativa ya estará visible",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdAsignacion=' + IdAsignacion + '&IdAlumno=' + alumno + '&calificacion=' + calificacion + '&TipoGuardar=' + Tipo + '&IdTarea=' + tarea + '&IdUsua=' + usua + '&TipoCalificar=' + TipoCalificar + '&equipo=' + equipo + '&MaxCalificacion=' +MaxCalificacion + '&IdActividadDoc=' + IdActividadDoc;

			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
        //  alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Calificaci\u00F3n  agregada correctamente.", "success");
            //parent.location.href='doAddCalificarTarea.php?NoActividad='+NoActividad + '&M='+TipoCalificar; //direcciona la pagina madre
				}
        if(data==3){
          swal("Error al guardar", "La calificaci\u00F3n agregada esta fuera del rango.", "error");
              document.getElementById("frm").reset();
        } if(data==0){
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x08", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}


// function val_viewForo(IdActividad, IdUsua, Id)
// {
//   var mensaje = document.getElementById("txtMensaje-"+IdActividad).value;
//   var IdAsignacion = document.getElementById("Id").value;
//   var Tipo = document.getElementById("TipoGuardar").value;
//   if (mensaje==""){
// 	swal("Error al guardar", "Debe escribir su comentario.", "error");
//       document.getElementById("txtMensaje-"+IdActividad).focus();
//       return 0;
//   }
//
//   var datos = 'IdActividad=' + IdActividad + '&Mensaje=' + mensaje + '&TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion ;
//   $.ajax({
//     type:"POST",
//     url:"insertar.php",
//     data:datos,
//     success:function(data){
//       parent.location.href='viewForoId.php?Id='+Id; //direcciona la pagina madre
//     }
//   })
//   .done(function(data) {
//     if(data==1){
//       swal("Guardado correctamente", "Comentario agregado correctamente.", "success");
//     }else{
//       swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
//     }
//   })
//
// }



function val_like(IdActividad, IdUsua)
{

  document.getElementById("txtLike-"+IdActividad).style.color="blue";
  var IdAsignacion = document.getElementById("Id").value;
  var Tipo = document.getElementById("TipoGuardar").value;
  var Tipo = 'var_like';
  var das = document.getElementById("txtLike-"+IdActividad).value;
  var datos = 'IdActividad=' + IdActividad + '&TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion ;

  $.ajax({
    type:"POST",
    url:"insertar.php",
    data:datos,
    success:function(data){

    }
  })
}

function val_doAddConfigExamen()
{
  var IdAsignacion = document.getElementById("Id").value;
  var NoActividad = document.getElementById("NoActividad").value;
  var txtNoPregunta = document.getElementById("txtNoPregunta").value;
  var txtPregunta = document.getElementById("txtPregunta").value;
  var Tipo = document.getElementById("TipoGuardar").value;

	if (txtNoPregunta == ""){
        swal("Error al guardar", "Debe escribir el # de pregunta.", "error");
        document.getElementById("txtNoPregunta").value="";
        document.getElementById("txtNoPregunta").focus();
        return 0;
    }
	if (document.frm.txtPregunta.value.length==''){
		swal("Error al guardar", "Debe escribir la pregunta.", "error");
        document.getElementById("txtPregunta").focus();
        return 0;
    }
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta pregunta al examen?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
      var datos = 'IdAsignacion=' + IdAsignacion + '&TipoGuardar=' + Tipo + '&NoActividad=' + NoActividad  + '&txtNoPregunta=' + txtNoPregunta + '&txtPregunta=' + txtPregunta ;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Pregunta guardada correctamente.", "success");
					document.getElementById("frm").reset();
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
        parent.location.href='doAddConfigExamen.php?NoActividad='+NoActividad; //direcciona la pagina madre
			})
			.error(function(data) {
				swal("Error al guardar 0x09", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}

function val_mostrarExamen()
{
  var IdAsignacion = document.getElementById("Id").value;
  var NoActividad = document.getElementById("NoActividad").value;
  var Tipo = "mostrarExamen";

	swal({
		title: "\u00BFEst\u00E1 seguro que desea mostrar este examen a su grupo?",
		text: "Al mostrar este examen, los alumnos ya podr\u00E1n realizar el examen.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
      var datos = 'IdAsignacion=' + IdAsignacion + '&TipoGuardar=' + Tipo + '&NoActividad=' + NoActividad;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Examen mostrado a los alumnos correctamente.", "success");
					document.getElementById("frm").reset();
				}else{
					swal("Error al guardar", "No se puede guardar, verifique sus datos", "error");
				}
        parent.location.href='doAddConfigExamen.php?NoActividad='+NoActividad; //direcciona la pagina madre
			})
			.error(function(data) {
				swal("Error al guardar 0x10", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}


function val_AddRespuesta()
{
  var IdAsignacion = document.getElementById("Id").value;
  var NoActividad = document.getElementById("NoActividad").value;
  var IdExamen = document.getElementById("IdExamen").value;
  var txtRespuesta1 = document.getElementById("txtRespuesta1").value;
  var txtRespuesta2 = document.getElementById("txtRespuesta2").value;
  var txtRespuesta3 = document.getElementById("txtRespuesta3").value;
  var txtValor = document.getElementById("txtValor").value;
  var TipoGuardar ="AddPregunta";
	if (document.frm.txtRespuesta1.value.length==''){
        swal("Error al guardar", "Debe escribir la respuesta del inciso A.", "error");
        document.getElementById("txtRespuesta1").value="";
        document.getElementById("txtRespuesta1").focus();
        return 0;
    }
    if (document.frm.txtRespuesta2.value.length==''){
          swal("Error al guardar", "Debe escribir la respuesta del inciso B.", "error");
          document.getElementById("txtRespuesta2").value="";
          document.getElementById("txtRespuesta2").focus();
          return 0;
      }


	if (document.frm.txtValor.value.length==''){
		swal("Error al guardar", "Debe seleccionar la respuesta correcta.", "error");
        document.getElementById("txtValor").focus();
        return 0;
    }
    var datos = 'IdExamen=' + IdExamen + '&TipoGuardar=' + TipoGuardar + '&txtRespuesta1=' + txtRespuesta1 + '&txtRespuesta2=' + txtRespuesta2 + '&txtRespuesta3=' + txtRespuesta3  + '&txtValor=' + txtValor ;

    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
        parent.location.href='doAddConfigExamen.php?NoActividad='+NoActividad; //direcciona la pagina madre
      }
    })
}


function val_respuesta(IdRespuesta, noPreg, IdUsua)
{
  var IdAsignacion = document.getElementById("Id").value;
  var NoActividad = document.getElementById("NoActividad").value;
  var Tipo = 'var_respuesta';
swal({
  title: "\u00BFEst\u00E1 seguro que desea guardar esta respuesta seleccionada?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  cancelButtonText: "Cancelar",
},
function (isConfirm) {
  if (isConfirm) {
    $(".confirm").attr('disabled', 'disabled');
    var datos = 'IdRespuesta=' + IdRespuesta + '&NoPregunta=' + noPreg + '&TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua + '&IdAsignacion=' + IdAsignacion + '&NoActividad=' + NoActividad ;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
      }
    })
    .done(function(data) {
      if(data==1){
        swal("Guardado correctamente", "Respuesta guardada correctamente.", "success");
        document.getElementById("frm").reset();
      }else{
        swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
      }
      parent.location.href='viewExamen.php?NoActividad='+NoActividad; //direcciona la pagina madre
    })
    .error(function(data) {
      swal("Error al guardar 0x11", "No se puede guardar, comuniquese con el desarrollador.", "error");
    });
  } else {
    document.getElementById("frm").reset();
  }
});

}



function val_eliminarRes(IdRespuesta,valor) {
  var IdAsignacion = document.getElementById("Id").value;
  var NoActividad = document.getElementById("NoActividad").value;
  if(valor == 0){
    var Tipo = 'var_eliminarR';
    var datos = 'TipoGuardar=' + Tipo + '&IdRespuesta=' + IdRespuesta;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
        document.getElementById(IdRespuesta).style.display = 'none';
      }
    })
  } else {
    swal("Error al eliminar", "No se puede eliminar por que el examen ya esta activo.", "error");
    return 0;
  }

}

function val_eliminarPreg(IdExamen) {
  var Tipo = 'var_eliminarPreg';
  swal({
  title: "\u00BFEst\u00E1 seguro que desea eliminar esta pregunta?",
  text: "Al eliminar la pregunta, autom\u00E1ticamente se eliminaran sus respuestas.",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
  if (isConfirm) {
    $(".confirm").attr('disabled', 'disabled');
    var datos = 'TipoGuardar=' + Tipo + '&IdExamen=' + IdExamen;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
      }
    })
    .done(function(data) {
      if(data==1){
        swal("Eliminado correctamente", "La pregunta a sido eliminada correctamente.", "success");
        document.getElementById(IdExamen).style.display = 'none';
      }else{
        swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
      }
    })
    .error(function(data) {
      swal("Error al eliminar 0x12", "No se puede eliminar, comuniquese con el desarrollador.", "error");
    });
  }
  });




}

function val_recursoApoyo(IdRecurso) { //IdRecurso,Link,IdAsignacion
  var Tipo = 'val_recursoApoyo';
  swal({
  title: "\u00BFEst\u00E1 seguro que desea eliminar este recurso de apoyo?",
  text: "Al eliminar este recurso, autom\u00E1ticamente se eliminar\u00E1 para todos.",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
  if (isConfirm) {
    $(".confirm").attr('disabled', 'disabled');
    var datos = 'TipoGuardar=' + Tipo + '&IdRecurso=' + IdRecurso;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
      }
    })
    .done(function(data) {
      if(data==1){
        swal("Eliminado correctamente", "Recurso de apoyo eliminado correctamente.", "success");
        document.getElementById(IdRecurso).style.display = 'none';
      }else{
        swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
      }
    })
    .error(function(data) {
      swal("Error al eliminar 0x13", "No se puede eliminar, comuniquese con el desarrollador", "error");
    });
  }
  });




}

function val_addSer() {
  var Clave = document.getElementById("txtClave").value;
  if (document.frm.txtClave.value.length==''){
      swal("Error al guardar", "Debe escribir la clave.", "error");
      document.getElementById("txtClave").focus();
      return 0;
  }

  var Tipo = 'val_addserf';
  swal({
  title: "\u00BFEst\u00E1 seguro que desea crear esta clave?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
  if (isConfirm) {
    $(".confirm").attr('disabled', 'disabled');
    var datos = 'TipoGuardar=' + Tipo + '&Clave=' + Clave;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){

      }
    })
    .done(function(data) {
      if(data==1){
        swal("Guardado correctamente", "Serie guardado correctamente.", "success");
        parent.location.href='adConfigSer.php';
      }else{
        swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
      }
    })
    .error(function(data) {
      swal("Error al eliminar 0x13", "No se puede eliminar, comuniquese con el desarrollador", "error");
    });
  }
  });




}

function val_datosBusqueda()
{
	if (document.frm.txtAnio.value.length==''){
		swal("ERROR", "Debe seleccionar el año.", "error");
        document.getElementById("txtAnio").focus();
        return 0;
    }
	if (document.frm.txtMes.value.length==''){
		swal("ERROR", "Debe seleccionar el mes.", "error");
        document.getElementById("txtMes").focus();
        return 0;
    }
    document.frm.Mov.value='Buscar';document.frm.submit();
}

function val_datosBusquedaTipo()
{
	if (document.frm.datepicker.value.length==''){
		swal("Error al buscar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("datepicker").focus();
        return 0;
    }
    if (document.frm.datepicker2.value.length==''){
  		swal("Error al buscar", "Debe seleccionar la fecha final.", "error");
          document.getElementById("datepicker2").focus();
          return 0;
      }
    document.frm.Mov.value='Buscar';document.frm.submit();
}

function val_cargar_mitarea(){
  var suma = 0;
  chkLink1 = document.getElementById("chkLink1").checked;
  chkLink2 = document.getElementById("chkLink2").checked;
  chkLink3 = document.getElementById("chkLink3").checked;

  if(chkLink1 == true){ chkLink1 = 1; } else { chkLink1 = 0; }
  if(chkLink2 == true){ chkLink2 = 1; } else { chkLink2 = 0; }
  if(chkLink3 == true){ chkLink3 = 1; } else { chkLink3 = 0; }

  suma = (chkLink1 + chkLink2 + chkLink3);
  if(suma == 0){
    swal("Error al guardar", "Debe seleccionar una opcion donde se guardara el archivo", "error");
    return 0;
  }

  if(suma > 1){
    swal("Error al guardar", "Debe seleccionar una sola opcion donde se guardara el archivo.", "error");
    return 0;
  }



  var NoArchivo = document.getElementById("archivo").value;
	if (NoArchivo==""){
		swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        document.getElementById("archivo").focus();
        return 0;
    }
  subir_mi_tarea();
}

function subir_mi_tarea(){
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdParcial = document.getElementById("IdParcial").value;
  var IdTarea = document.getElementById("IdTarea").value;
  var IdSemana = document.getElementById("IdSemana").value;

  var NoLink = 0;
  chkLink1 = document.getElementById("chkLink1").checked;
  chkLink2 = document.getElementById("chkLink2").checked;
  chkLink3 = document.getElementById("chkLink3").checked;

  if(chkLink1 == true){ NoLink = 1; }
  if(chkLink2 == true){ NoLink = 2; }
  if(chkLink3 == true){ NoLink = 3; }


  let form = document.getElementById('form_subir');
  let barra_estado = form.children[5].children[0],
  span = barra_estado.children[0],
  boton_cancelar = form.children[3].children[1];
  barra_estado.classList.remove('barra_verde','barra_roja');
  var IdParcial = document.getElementById("IdParcial").value;

  //peticion
  let peticion = new XMLHttpRequest();

  //progreso

  document.getElementById("barra").style.display = 'block';
  // document.getElementById("btnSalir").style.display = 'none';
  document.getElementById("bntSubir").style.display = 'none';

  peticion.upload.addEventListener("progress", (event) =>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);
    console.log(porcentaje);
    barra_estado.style.width = porcentaje+'%';
    span.innerHTML = porcentaje+'%';
  });

  //finalizado
  peticion.addEventListener("load",()=>{
    barra_estado.classList.add('barra_verde');
    $('#dataTarea').modal('hide');
    // var IdTarea = 55;
    var TipoGuardar = "validar_tarea";
    $.ajax({
         url:"alumnos/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdTarea:IdTarea,IdAsignacion:IdAsignacion,NoLink:NoLink},
         success:function(data){

           if(data == 1){
             span.innerHTML = "Archivo subido correctamente.";
              swal({
               title: "El archivo se ha subido correctamente.",
               type: "success",
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 $('#dataTar').modal('hide');
                 //subirMiTarea(IdParcial,IdSemana, NoSemana, IdActividadDoc)
                 // miUnidad(IdParcial,IdSemana,NoSemana);
               }
             });
           } else {
             span.innerHTML = "Ha ocurrido un error.";
              swal({
               title: "Ha ocurrido un error, no se pudo subir el archivo.",
               type: "error",
               confirmButtonColor: '#DD6B55',
               confirmButtonText: 'Aceptar',
             },
             function(isConfirm){
               if(isConfirm){
                 $('#dataTar').modal('hide');
                 //subirMiTarea(IdParcial,IdSemana, NoSemana, IdActividadDoc)
               }
             });
           }

         }
    })
  });

  //Enviar datos
  peticion.open('post', 'subir_mi_tarea.php');
  peticion.send(new FormData(form));
  console.log();
}

function val_respuestaTarea()
{
var txtMensaje = document.getElementById("txtMensaje").value;
  var IdTarea = document.getElementById("IdTarea").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdUsua_recibe = document.getElementById("IdUsua_recibe").value;
  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
  var Tipo = document.getElementById("Tipo").value;
  var IdParcial = document.getElementById("IdParcial").value;
  var employee_id = document.getElementById("employee_id").value;

  var TipoGuardar ="AddTareaComentario";
	if (txtMensaje==""){
        swal("Error al guardar", "Debe escribir su comentario.", "error");
        document.getElementById("txtMensaje").focus();
        return 0;
    }
    document.getElementById("btn_envio").style.display = "none";
    document.getElementById("img_cargar").style.display = "block";

    var datos = 'IdTarea=' + IdTarea + '&TipoGuardar=' + TipoGuardar + '&txtMensaje=' + txtMensaje + '&IdUsua=' + IdUsua + '&Tipo=' + Tipo + '&IdUsua_recibe=' +IdUsua_recibe+'&IdActividadDoc='+IdActividadDoc;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
        $.ajax({
             url:"formConsulta/viewComentarios.php",
             method:"POST",
             data:{employee_id:employee_id},
             success:function(data){
                  $('#employee_detail').html(data);
                  $('#dataModal').modal('show');
             }
        });
      }
    })
    // .done(function(data) { alert(data);
    //   if(data==1){
    //
    //   } else {
    //     swal("Error al comentar", "No se puede guardar, el comentario no se pudo guardar.", "error");
    //   }
    // })

}
function chatPlaneacion(IdUsua)
{

  var Tipo = document.getElementById("Tipo").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdPlaneacion = document.getElementById("IdPlaneacion").value;
  var Chat = document.getElementById("txtChat").value;

  var TipoGuardar ="chatPlaneacion";
	if (Chat==""){
      swal("Error al guardar", "Debe escribir su comentario.", "error");
      document.getElementById("txtChat").focus();
      return 0;
  }
     var datos = 'IdUsua=' + IdUsua + '&TipoGuardar=' + TipoGuardar + '&Tipo=' + Tipo + '&IdAsignacion=' + IdAsignacion + '&Chat=' + Chat + '&IdPlaneacion=' + IdPlaneacion;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){

      }
    })
    .done(function(data) {
      if(data==1){
        swal("Guardado correctamente", "El comentario se ha guardado correctamente.", "success");
        // $('#dataModalenvioPlan').modal('hide');
        var IdAsignacion = document.getElementById("IdAsignacion").value;
    		var Tipo = "A";
    		$.ajax({
    				 url:"formConsulta/envioPlaneacion.php",
    				 method:"POST",
    				 data:{IdUsua:IdUsua,IdAsignacion:IdAsignacion,Tipo:Tipo},
    				 success:function(data){
    							$('#employee_detailenvioPlan').html(data);
    							$('#dataModalenvioPlan').modal('show');
    				 }
    		});
      } else {
        swal("Error al comentar", "No se puede guardar, el comentario no se pudo guardar.", "error");
      }
    })

}

function chatPlaneacionCorp(IdUsua)
{

  var Tipo = document.getElementById("Tipo").value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdPlaneacion = document.getElementById("IdPlaneacion").value;
  var Chat = document.getElementById("txtChat").value;

  var TipoGuardar ="chatPlaneacion";
	if (Chat==""){
      swal("Error al guardar", "Debe escribir su comentario.", "error");
      document.getElementById("txtChat").focus();
      return 0;
  }
     var datos = 'IdUsua=' + IdUsua + '&TipoGuardar=' + TipoGuardar + '&Tipo=' + Tipo + '&IdAsignacion=' + IdAsignacion + '&Chat=' + Chat + '&IdPlaneacion=' + IdPlaneacion;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){

      }
    })
    .done(function(data) {
      if(data==1){
        swal("Guardado correctamente", "El comentario se ha guardado correctamente.", "success");
      	$.ajax({
      			 url:"formConsulta/chatPlaneacion.php",
      			 method:"POST",
      			 data:{IdAsignacion:IdAsignacion, IdPlaneacion:IdPlaneacion},
      			 success:function(data){
      						$('#employee_detailChat').html(data);
      						$('#dataModalChat').modal('show');
      			 }
      	});
      } else {
        swal("Error al comentar", "No se puede guardar, el comentario no se pudo guardar.", "error");
      }
    })

}

function val_addNotificacion()
{
  var Mensaje = document.getElementById("txtMensaje").value;
  var IdEncargado = document.getElementById("IdEncargado").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdPermiso = "6";

  var TipoGuardar ="addNotificacion";
	if (Mensaje==""){
        swal("Error al guardar", "Debe escribir su comentario.", "error");
        document.getElementById("txtMensaje").focus();
        return 0;
    }
    var datos = 'IdEncargado=' + IdEncargado + '&TipoGuardar=' + TipoGuardar + '&Mensaje=' + Mensaje + '&IdUsua=' + IdUsua + '&IdPermiso=' + IdPermiso;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
      }
    })
    .done(function(data) {
      if(data==1){
        swal("Enviado correctamente", "Comentario enviado correctamente.", "success");
        $('#dataModalCx').modal('hide');
      } else {
        swal("Error al enviar", "No se puede enviar el correo, el comentario fue creado correctamente.", "error");
      }
    })

}

function val_datosBusquedaDocAct()
{
	if (document.frm.txtCicloEscolar.value.length==''){
		swal("Error al buscar", "Debe seleccionar el ciclo escolar.", "error");
        document.getElementById("txtCicloEscolar").focus();
        return 0;
    }
    if (document.frm.txtClaveGrp.value.length==''){
  		swal("Error al buscar", "Debe seleccionar el IdGrupo.", "error");
          document.getElementById("txtClaveGrp").focus();
          return 0;
      }
	if (document.frm.txtModulo.value.length==''){
		swal("Error al buscar", "Debe seleccionar la asignatura.", "error");
        document.getElementById("txtModulo").focus();
        return 0;
    }
    document.frm.Mov.value='Buscar';document.frm.submit();
}

function val_tipo(Id)
{
  document.getElementById("IdUsuaBus").value = Id;
  //parent.location.href='acSelIngTiemReal.php?Id=' + Id; //direcciona la pagina madre
}

function val_CalFinal()
{
  var IdAsignacion = document.getElementById("Id").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var Tipo = "AddCalificacionFinal";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea subir calificaci\u00F3n al servidor?",
		text: "Este movimiento solo lo puede hacer una \u00FAnica vez.",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdAsignacion=' + IdAsignacion + '&TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua ;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "Calificaci\u00F3n subida correctamente al servidor.", "success");
          document.getElementById("cali").style.display = "none";
          document.getElementById("msjCali").style.display = "block";
				}else{
					swal("Error al guardar", "No se puede subir, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x14", "No se puede subir, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function activarExtra(IdParcialDoc)
{
  var IdPlaneacion = document.getElementById("IdPlaneacion").value;
  var Tipo = "activarExtra";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea activar este m\u00F3dulo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdParcialDoc=' + IdParcialDoc + '&TipoGuardar=' + Tipo + '&IdPlaneacion=' + IdPlaneacion;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Activado correctamente", "El extraordinario ha sido activado correctamente.", "success");
          document.getElementById("btnActivar").style.display = "none";
				}else{
					swal("Error al activar", "No se puede activar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x14", "No se puede subir, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function actExtraAlumno(IdUsua)
{
var IdAsignacion = document.getElementById("IdAsignacion").value;

  var Tipo = "actExtraAlum";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea activar este extraordinario a este alumno?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdUsua=' + IdUsua + '&TipoGuardar=' + Tipo + '&IdAsignacion=' + IdAsignacion;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) { // alert(data);
				if(data==1){
					swal("Activado correctamente", "El extraordinario ha sido activado correctamente.", "success");
          cargar_calificacionx(IdAsignacion);
				}
        if(data==3){
					swal("Error al activar", "Favor de comunicarse con el administrador, ya que no existe el monto para el extraordinario.", "warning");
				}
        if(data == 0){
					swal("Error al activar", "No se puede activar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x14", "No se puede subir, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}


function asistenciaAct(IdLista, Dia, TipoAsis){
    var Tipo = "actLista";
    var btnA1 = "btnSIAC-"+IdLista;
    var btnA2 = "btnSIIN-"+IdLista;
    var btnA3 = "btnSIDE-"+IdLista;

    var btnR1 = "btnREAC-"+IdLista;
    var btnR2 = "btnREIN-"+IdLista;
    var btnR3 = "btnREDE-"+IdLista;

    var btnF1 = "btnFAAC-"+IdLista;
    var btnF2 = "btnFAIN-"+IdLista;
    var btnF3 = "btnFADE-"+IdLista;

    var datos = 'IdLista=' + IdLista + '&TipoGuardar=' + Tipo + '&Dia=' + Dia + '&TipoAsis=' + TipoAsis;
    $.ajax({
      type:"POST",
      url:"insertar.php",
      data:datos,
      success:function(data){
        if(TipoAsis == 'A'){

           document.getElementById(btnA1).style.display = "none";
           document.getElementById(btnA2).style.display = "block";
           document.getElementById(btnA3).style.display = "none";

           document.getElementById(btnR1).style.display = "none";
           document.getElementById(btnR2).style.display = "none";
           document.getElementById(btnR3).style.display = "block";

           document.getElementById(btnF1).style.display = "none";
           document.getElementById(btnF2).style.display = "none";
           document.getElementById(btnF3).style.display = "block";


        }
        if(TipoAsis == 'R'){

           document.getElementById(btnR1).style.display = "none";
           document.getElementById(btnR2).style.display = "block";
           document.getElementById(btnR3).style.display = "none";

           document.getElementById(btnA1).style.display = "none";
           document.getElementById(btnA2).style.display = "none";
           document.getElementById(btnA3).style.display = "block";

           document.getElementById(btnF1).style.display = "none";
           document.getElementById(btnF2).style.display = "none";
           document.getElementById(btnF3).style.display = "block";

        }
        if(TipoAsis == 'F'){

           document.getElementById(btnF1).style.display = "none";
           document.getElementById(btnF2).style.display = "block";
           document.getElementById(btnF3).style.display = "none";

           document.getElementById(btnA1).style.display = "none";
           document.getElementById(btnA2).style.display = "none";
           document.getElementById(btnA3).style.display = "block";

           document.getElementById(btnR1).style.display = "none";
           document.getElementById(btnR2).style.display = "none";
           document.getElementById(btnR3).style.display = "block";
        }

      }
    })
}




function actExtraAlumno2(IdUsua)
{
var IdAsignacion = document.getElementById("Id").value;
  var Tipo = "actExtraAlum2";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea activar este extraordinario a este alumno?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdUsua=' + IdUsua + '&TipoGuardar=' + Tipo + '&IdAsignacion=' + IdAsignacion;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
// alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Activado correctamente", "El extraordinario ha sido activado correctamente.", "success");
          document.getElementById("btnActivar-"+IdUsua).style.display = "none";
          // document.getElementById("btnActivadot-"+IdUsua).style.display = "block";
				}
        if(data==3){
					swal("Error al activar", "Favor de comunicarse con el administrador, ya que no existe el monto para el extraordinario.", "warning");
				}
        if(data == 0){
					swal("Error al activar", "No se puede activar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x14", "No se puede subir, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function actExtraAlumno3(IdUsua)
{
var IdAsignacion = document.getElementById("Id").value;
  var Tipo = "actExtraAlum3";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea activar este extraordinario a este alumno?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdUsua=' + IdUsua + '&TipoGuardar=' + Tipo + '&IdAsignacion=' + IdAsignacion;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Activado correctamente", "El extraordinario ha sido activado correctamente.", "success");
          document.getElementById("btnActivar-"+IdUsua).style.display = "none";
          // document.getElementById("btnActivadot-"+IdUsua).style.display = "block";
				}
        if(data==3){
					swal("Error al activar", "Favor de comunicarse con el administrador, ya que no existe el monto para el extraordinario.", "warning");
				}
        if(data == 0){
					swal("Error al activar", "No se puede activar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x14", "No se puede subir, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function actRecursarAlum(IdUsua)
{
var IdAsignacion = document.getElementById("Id").value;
  var Tipo = "actRecursarAlum";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea activar este extraordinario a este alumno?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdUsua=' + IdUsua + '&TipoGuardar=' + Tipo + '&IdAsignacion=' + IdAsignacion;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){
//alert(data);
				}
			})
			.done(function(data) {
				if(data==1){
					swal("Activado correctamente", "El alumno se ha mandado a recursar estar asignatura.", "success");
          document.getElementById("btnActivart-"+IdUsua).style.display = "none";
          document.getElementById("btnActivadot-"+IdUsua).style.display = "block";
				}else{
					swal("Error al activar", "No se puede activar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al guardar 0x14", "No se puede subir, comuniquese con el desarrollador.", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function val_verCerfificado(IdCalificacionF)
{

  var Tipo = "verCerfificado";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea mostrar este certificado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + Tipo + '&IdCalificacionF=' + IdCalificacionF ;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "El certificado ya se puede visualizar correctamente.", "success");
          parent.location.href='doSelActa.php'; //direcciona la pagina madre
				}else{
					swal("Error al mostrar", "No se puede mostrar certificado, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al mostrar 0x15", "No se puee mostrar, comuniquese con el desarrollador", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function addCurso(IdUsua)
{
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdEducativa = document.getElementById("IdEducativa").value;
  var Modulo = document.getElementById("Modulo").value;
  var Tipo = "addUserCurso";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este usuario a este curso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua +'&IdAsignacion=' + IdAsignacion + '&IdEducativa=' + IdEducativa + '&Modulo=' + Modulo;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Guardado correctamente", "El usuario ha sido agregado correctamente al curso.", "success");
          document.getElementById("btndel1-"+IdUsua).style.display = 'block';
          document.getElementById("btnadd1-"+IdUsua).style.display = 'none';
				}else{
					swal("Error al agregar", "No se puede agregar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}

function delCurso(IdUsua)
{
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var IdEducativa = document.getElementById("IdEducativa").value;
  var Modulo = document.getElementById("Modulo").value;
  var Tipo = "delUserCurso";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este usuario de este curso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'TipoGuardar=' + Tipo + '&IdUsua=' + IdUsua +'&IdAsignacion=' + IdAsignacion + '&IdEducativa=' + IdEducativa + '&Modulo=' + Modulo;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Eliminado correctamente", "El usuario ha sido eliminado correctamente del curso.", "success");
				}else{
					swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
			});
		} else{
      document.getElementById("frm").reset();
    }
	});
}


function val_addGenerarPag()
{
	if (document.frm.txtOferta.value.length==''){
		swal("Error al guardar", "Debe seleccionar tipo de oferta educativa.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
	if (document.frm.txtConcepto.value.length==''){
		swal("Error al guardar", "Debe seleccionar el concepto de pago.", "error");
        document.getElementById("txtConcepto").focus();
        return 0;
    }
	if (document.frm.datepicker.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha de pago con descuento.", "error");
        document.getElementById("datepicker").focus();
        return 0;
    }
  if (document.frm.datepicker2.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha de pago base.", "error");
        document.getElementById("datepicker2").focus();
        return 0;
    }
  if (document.frm.datepicker3.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha l\u00EDmite de pago.", "error");
        document.getElementById("datepicker3").focus();
        return 0;
    }
  if (document.frm.txtCicloEscolar.value.length==''){
    swal("Error al guardar", "Debe seleccionar ciclo escolar.", "error");
        document.getElementById("txtCicloEscolar").focus();
        return 0;
    }


    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9ste pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
  function (isConfirm) {
		if (isConfirm) {
			document.getElementById("imgLoadPag").style.display = 'block';
      document.getElementById("bntGenerarP").disabled = true;
			document.frm.Mov.value='genPago';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}


function val_addGenerarPagGrp()
{
	if (document.frm.txtOferta.value.length==''){
		swal("Error al guardar", "Debe seleccionar tipo de oferta educativa.", "error");
        document.getElementById("txtOferta").focus();
        return 0;
    }
	if (document.frm.txtConcepto.value.length==''){
		swal("Error al guardar", "Debe seleccionar el concepto de pago.", "error");
        document.getElementById("txtConcepto").focus();
        return 0;
    }
	if (document.frm.datepicker.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha de pago con descuento.", "error");
        document.getElementById("datepicker").focus();
        return 0;
    }
  if (document.frm.datepicker2.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha de pago base.", "error");
        document.getElementById("datepicker2").focus();
        return 0;
    }
  if (document.frm.datepicker3.value.length==''){
		swal("Error al guardar", "Debe seleccionar la fecha l\u00EDmite de pago.", "error");
        document.getElementById("datepicker3").focus();
        return 0;
    }
  if (document.frm.txtCicloEscolar.value.length==''){
    swal("Error al guardar", "Debe seleccionar ciclo escolar.", "error");
        document.getElementById("txtCicloEscolar").focus();
        return 0;
    }

    if (document.frm.txtGrupo.value.length==''){
      swal("Error al guardar", "Debe seleccionar el grupo.", "error");
          document.getElementById("txtGrupo").focus();
          return 0;
      }


    swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9ste pago?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
  function (isConfirm) {
		if (isConfirm) {
			document.getElementById("imgLoadPag").style.display = 'block';
      document.getElementById("bntGenerarP").disabled = true;
			document.frm.Mov.value='genPagoGrp';document.frm.submit();
			return true;
		} else {
			return false;
		}
	});
}


function val_uploadFile(){
  var NoArchivo = document.getElementById("archivo").value;
  var Nombre = document.getElementById("txtNombreF").value;

	if (NoArchivo==""){
	   swal("Error al guardar", "Debe seleccionar el archivo.", "error");
      document.getElementById("archivo").focus();
      return 0;
  }
  if (Nombre==""){
	   swal("Error al guardar", "Debe escribir el nombre del archivo.", "error");
      document.getElementById("txtNombreF").focus();
      return 0;
  }

  subir_fileArchivo();
}
function subir_fileArchivo(){
  var IdUsuaRecibe = document.getElementById("IdUsuaRecibe").value;
  var IdUsuaEnvia = document.getElementById("IdUsuaEnvia").value;


  let form = document.getElementById('form_subir');
  let barra_estado = form.children[5].children[0],
  span = barra_estado.children[0],
  boton_cancelar = form.children[3].children[1];
  barra_estado.classList.remove('barra_verde','barra_roja');
  // var IdParcial = document.getElementById("IdParcial").value;

  //peticion
  let peticion = new XMLHttpRequest();

  //progreso

  document.getElementById("img").style.display = 'block';
  document.getElementById("barra").style.display = 'block';
  // document.getElementById("btnSalir").style.display = 'none';
  document.getElementById("bntSubir").style.display = 'none';

  peticion.upload.addEventListener("progress", (event) =>{
    let porcentaje = Math.round((event.loaded / event.total) * 100);
    console.log(porcentaje);
    barra_estado.style.width = porcentaje+'%';
    span.innerHTML = porcentaje+'%';
  });

  //finalizado
  peticion.addEventListener("load",()=>{
    barra_estado.classList.add('barra_verde');


  });

  //Enviar datos
  peticion.open('post', 'subirFile.php');

  peticion.send(new FormData(form));
  console.log();

  swal({
		title: "El archivo adjunto se ha cargado correctamente",
		type: "success",
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
			cargarComen(IdUsuaEnvia,IdUsuaRecibe);
      $('#dataModalR').modal('hide');
		}

	});
}
