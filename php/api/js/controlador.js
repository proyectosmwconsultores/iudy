function validarEnlace(){
  // var url = 'http://localhost/mvc/crmglobal/assets/api/valifdar_enlace.php';
  var url = document.getElementById('txtCRM').value;
  var code = document.getElementById('txtCode').value;
  var miUrl = url + 'view/api/validar_enlace.php';

  let informacion = {
    link: document.getElementById('txtCRM').value,
    code: document.getElementById('txtCode').value,
    dominio: document.getElementById('dominio').value
  };
  // console.log('datos a enviar', informacion);

  axios({
    method:'POST',
    url: miUrl,
    reponseType:'json',
    data:informacion
  }).then(res=>{
    console.log(res);
    var id_status = res.status;
    var idEstatus = res.data;
    if(id_status == 200){
      if(idEstatus == 8){
        swal("Conexión con éxito", "La conexión con el CRM GLOBAL UNIVERSITY se ha realizado con éxito.", "success");
        $.post("php/api/api_conexion.php", { url: url, code:code}, function(data){ });
      }
      if(idEstatus == 5){
        swal("Error al conectarse", "Los datos ingresados no son correctos, favor de verificar.", "error");
      }
    } else {
        swal("Ha ocurrido un error", "No se puede enlazar al CRM GLOBAL UNIVERSITY.", "error");
    }


    // console.log(res);

  }).catch(error=>{
    swal("Error 404", "Ha ocurrido un "+error, "error");
    // console.error(error);
    // alert(error);
  });
}
