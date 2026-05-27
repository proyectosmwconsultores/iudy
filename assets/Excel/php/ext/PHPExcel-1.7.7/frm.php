<?php
require_once("css.php");
$t=new Trabajot();
if(isset($_GET["Mov"]) && $_GET["Mov"]=="Guardar"){
    $t->add_($_GET["id"],$_GET["txtFecIni"],$_GET["TxtJusti"]);
    exit; 
}
?>
<html>
    <body>
    <form name="frm" id="frm" action="frm.php" method="GET" enctype="multipart/form-data">
    <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
	<div class="row-fluid">
    	<div class="span12">
            
            <div class="row-fluid">
                <div class="span4"><input name="id" id="id" type="text"></div>                        
                <div class="span4"><input name="txtFecIni" id="txtFecIni" type="text" class="datepicker" style="cursor:pointer;"></div>
                <div class="span4">
                	<select name="TxtJusti" id="TxtJusti">
                        <option selected value="">- Seleccione -</option> 
                        <option value="1"<?php if($_GET[TxtJusti]=="1"){?>selected<?php }?>>DIA COMPLETO</option>
                        <option value="2"<?php if($_GET[TxtJusti]=="2"){?>selected<?php }?>>ENTRADA FALTA</option>
                        <option value="3"<?php if($_GET[TxtJusti]=="3"){?>selected<?php }?>>SALIDA FALTA</option>                         
                        <option value="4"<?php if($_GET[TxtJusti]=="4"){?>selected<?php }?>>ENTRADA RETARDO</option>
                        <option value="5"<?php if($_GET[TxtJusti]=="5"){?>selected<?php }?>>SALIDA RETARDO</option>                         
                    </select>  
                </div>
                <input name="Guardar" id="Guardar" type="button" value="Guardar"  onClick="document.frm.Mov.value='Guardar';document.frm.submit();" onsubmit="Val_Permisos()" style="cursor:pointer;" class="btn btn-danger"/>
            </div>
            
            
            </br>     
        </div>
       
    </div>
</form>
</body>
</html>