<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	$IdUsua = substr($_GET["id"], 10, 10);
	
	$IdCiclo = substr($_GET["idToks"], 10, 10);
	$rvoe=$t->get_datos_campus_rvoe($IdUsua);
	$docs=$t->get_mis_docs_id($IdUsua);
	
	
	$lstUs=$t->get_sat_us($IdUsua);
	$lstCi=$t->get_ciclo_ac($IdCiclo,$lstUs[0]['IdGrupo']);
	$infox=$t->get_infor_cel($IdUsua);
	$esta=$t->get_estado_p($infox[0]['E_estado_procedencia']);
	$esta_pos=$t->get_estado_p($infox[0]['Pos_estado']);

	$cx = $infox[0]['P_civil'];
	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipC = 'CUATRIMESTRE'; } elseif($lstUs[0]['TipoCiclo'] == 'T'){ $tipC = 'TRIMESTRE'; } else { $tipC = 'SEMESTRE'; }
	
	
	$_txF = '';
	if($IdCiclo == $lstUs[0]['id_ciclo_ini']){ $_txF = 'INSCRIPCIÓN'; } else { $_txF = 'REINSCRIPCIÓN'; }

	$_SESSION['_imprF'] = "FICHA_".$lstCi[0]['Ciclo'].'-'.$lstUs[0]['AMaterno'].'_'.$lstUs[0]['APaterno'].'_'.$lstUs[0]['Nombre'];
	
	$pag=$t->get_costos_pag($lstUs[0]['IdOferta'],$IdCiclo);
	

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;

}

td, th {
    border: 0.5px solid black;
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="30mm" backbottom="3mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
			<tr>
				<td style="width: 150px;"><img src="../../assets/images/campus/<?php echo $rvoe[0]['_logoPdf']; ?>" style="width: 100%;" ></td>
				<td style="width: 500px; font-size: 14px;">
				    <?php echo $rvoe[0]['_titulo']; ?><br>
				    <b style="font-size: 12px;"><?php echo $rvoe[0]['Educativa']; ?><br>
				    FORMATO DE <?php echo $_txF; ?></b>
				</td>
			</tr>
		</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	

	</page_footer>
	<div style='border: 0.5px solid #adadad; width: 99px; height: 100px; position: absolute; margin-left: 590px; text-align: center;'>
	    <?php if($lstUs[0]['Foto'] <> 'nuevo.png'){ ?>
	    <img src="../../assets/perfil/<?php echo $lstUs[0]['Foto']; ?>" style="width: 90px; height: 95px" >
	    <?php }  else { echo "<p style='font-size: 10px; '><br><br>FOTO</p>"; }?>
	</div>
	<table style='margin-left: 4px;'>
		<tr style='background: #dadada;'>
			<td style='width: 384px; color: blue; border: none;'><b>FICHA DE <?php echo $_txF; ?></b></td>
			<td style='width: 160px; color: black; border: none; text-align: right;'><b><?php echo obtFechMay(date("Y-m-d")); ?></b></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 10px; '>
		<tr>
			<td style='width: 100px;  border: none;'><?php echo $lstUs[0]['_Grado']; ?>:</td>
			<td style='width: 442px; border-top: none; border-right: none;'><?php echo $lstUs[0]['Educativa']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 150px; border: none;'><?php echo $tipC; ?>: <?php echo obtenerGradox($lstCi[0]['Grado']); ?></td>
			<td style='width: 80px; border: none; text-align: center;'>GRUPO: <?php echo $lstUs[0]['Grupo']; ?></td>
			<td style='width: 150px; border: none;'>HORARIO: <?php echo $lstUs[0]['_Dias']; ?></td>
			<td style='width: 200px; border: none;'>MODALIDAD: <?php echo $lstUs[0]['_Modalidad']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 110px; border:none; '>PERIODO ESCOLAR:</td>
		<td style='width: 430px; text-align: left; border-top: none; border-right: none;'><?php echo $lstCi[0]['Ciclo']; ?></td>
	</tr>
	</table>
	<br><br>
	<table style='margin-left: 4px;'>
		<tr style='background: #dadada;'>
			<td style='width: 454px; color: blue; border: none;'><b>DATOS DEL ALUMNO</b></td>
			<td style='width: 200px; color: blue; border: none; text-align: right;'><b>MATRICULA: <?php echo $lstUs[0]['Usuario']; ?></b></td>
		</tr>
	</table>
	<table style='margin-left: 4px; '>
		<tr>
			<td style='width: 191px; text-align: center; border-top: none; border-left: none; border-right: none; '><?php echo $lstUs[0]['APaterno']; ?></td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-top: none; border-right: none; '><?php echo $lstUs[0]['AMaterno']; ?></td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-top: none; border-right: none; '><?php echo $lstUs[0]['Nombre']; ?></td>
		</tr>
		<tr>
			<td style='width: 191px; text-align: center; border-left: none; border-right: none; border-bottom:none;'>APELLIDO PATERNO</td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-right: none; border-bottom:none;'>APELLIDO MATERNO</td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-right: none; border-bottom:none;'>NOMBRE</td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 70px; border:none; '>DIRECCIÓN:</td>
		<td style='width: 582px;  border-top: none; border-right: none;'><?php echo $infox[0]['D_direccion']; ?></td>
	</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 70px; border:none; '>CELULAR</td>
		<td style='width: 104px; text-align: left; border-top: none; border-right: none;'><?php echo $lstUs[0]['Celular']; ?></td>
		<td style='width: 105px; border:none; text-align: right;'>CORREO:</td>
		<td style='width: 338px; text-align: center; border-top: none; border-right: none;'><?php echo $lstUs[0]['Correo']; ?></td>
	</tr>
	</table>

	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 120px; border:none; '>FECHA DE NACIMIENTO:</td>
		<td style='width: 50px; text-align: center; border-top: none; border-right: none;'><?php echo $lstUs[0]['FecNac']; ?></td>
		<td style='width: 120px; text-align: right; border:none; '>LUGAR DE NACIMIENTO:</td>
		<td style='width: 329px; text-align: center; border-top: none; border-right: none;'><?php echo $infox[0]['Nom_municipio'].', '.$infox[0]['Estado']; ?></td>
	</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 50px; border:none; '>CURP:</td>
		<td style='width: 179px; text-align: left; border-top: none; border-right: none;'><?php echo $infox[0]['P_curp']; ?></td>
		<td style='width: 120px; text-align: right; border:none; '>TIPO DE SANGRE:</td>
		<td style='width: 270px; text-align: center; border-top: none; border-right: none;'><?php echo $infox[0]['Sangre']; ?></td>
	</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 150px; border:none; '>¿ALGÚN PADECIMIENTO?:</td>
		<td style='width: 500px; text-align: left; border-top: none; border-right: none;'><?php echo $infox[0]['_Cual']; ?></td>
	</tr>
	</table>

	<table style='margin-left: 4px; margin-top: 30px;'>
		<tr style='background: #dadada;'>
			<td style='width: 670px; color: blue; border: none;'><b>ESTUDIOS ANTERIORES DEL SOLICITANTE</b></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 155px; border: none;'><?php if($lstUs[0]['IdGrado'] == 4){ echo "ESTUDIO ANTERIOR:"; } else { echo "CARRERA QUE CURSÓ:"; } ?></td>
			<td style='width: 273px; border-top: none; border-right: none;'><?php echo $infox[0]['E_estudio']; ?></td>
			<?php if(($lstUs[0]['IdGrado'] == 1) || ($lstUs[0]['IdGrado'] == 2) || ($lstUs[0]['IdGrado'] == 3)){ ?>
			<td style='width: 40px; text-align: right; border: none;'>TITULADO:</td>
			<td style='width: 40px; text-align: center; border-top: none; border-bottom: none;'>SI</td>
			<td style='width: 10px; text-align: center;'><?php if($infox[0]['E_titulo'] == 'SI'){ echo "X"; } ?></td>
			<td style='width: 40px; text-align: center; border-top: none; border-bottom: none;'>NO</td>
			<td style='width: 10px; text-align: center;'><?php if($infox[0]['E_titulo'] == 'NO'){ echo "X"; } ?></td><?php } ?>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 155px; border: none;'>INSTITUCIÓN DONDE ESTUDIO:</td>
			<td style='width: 345px; border-top: none; border-right: none;'><?php echo $infox[0]['E_escuela_procedencia']; ?></td>
			<td style='width: 80px; text-align: right; border: none;'>PROMEDIO:</td>
			<td style='width: 40px; text-align: center; border-top: none; border-right: none;'><?php echo $infox[0]['E_promedio']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 100px; border: none;'>LA INSTITUCIÓN ES:</td>
			<td style='width: 80px; text-align: center; border-top: none; border-bottom: none;'>PUBLICA</td>
			<td style='width: 10px; text-align: center;'><?php if($infox[0]['E_tipo'] == 'PUBLICA'){ echo "X"; } ?></td>
			<td style='width: 80px; text-align: center; border-top: none; border-bottom: none;'>PRIVADA</td>
			<td style='width: 10px; text-align: center;'><?php if($infox[0]['E_tipo'] == 'PRIVADA'){ echo "X"; } ?></td>
			<td style='width: 100px; border: none; text-align: right;'>ESTADO:</td>
			<td style='width: 187px; text-align: center; border-top: none; border-right: none;'><?php if(isset($esta[0]['_Estado'])){ echo $esta[0]['_Estado']; } ?></td>
		</tr>
	</table>

	<table style='margin-left: 4px; margin-top: 30px;'>
		<tr style='background: #dadada;'>
			<td style='width: 670px; color: blue; border: none;'><b><?php if($lstUs[0]['IdGrado'] == 4){ echo "DATOS DEL TUTOR:"; } else { echo "CONTACTO AUTORIZADO:"; } ?></b></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 60px; border: none;'>NOMBRE:</td>
			<td style='width: 320px; border-top: none; border-right: none;'><?php echo $infox[0]['ENombre']; ?></td>
			<td style='width: 80px; border: none; text-align: right;'>TELÉFONO:</td>
			<td style='width: 160px; border-top: none; border-right: none;'><?php echo $infox[0]['ECelular']; ?></td>
		</tr>
		<tr>
			<td style='width: 60px; border: none;'>CORREO:</td>
			<td style='width: 320px; border-top: none; border-right: none;'><?php echo $infox[0]['correo_tutor']; ?></td>
			<td style='width: 80px; border: none; text-align: right;'>PARENTESCO:</td>
			<td style='width: 160px; border-top: none; border-right: none;'><?php echo $infox[0]['EParentesco']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 30px;'>
		<tr style='background: #dadada;'>
			<td style='width: 348px; color: blue; border: none;'><b>DOCUMENTACIÓN ENTREGADA</b></td>
			<td style='width: 40px; color: blue; border: none; background: white;'></td>
			<td style='width: 250px; color: blue; border: none;'><b>COSTOS DE <?php echo $lstCi[0]['Ciclo']; ?></b></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 348px; border: none;'>
			    <table style='margin-left: -3px;'>
			        <tr>
			            <td style='width: 227px;'><b>NOMBRE DEL DOCUMENTO</b></td>
			            <td style='width: 100px; text-align: center;'><b>MARQUE CON UNA<br>(X)</b></td>
			        </tr>
			        <?php  for ($i=0;$i< sizeof($docs);$i++) { ?>
			        <tr>
			            <td style='width: 227px;'><?php echo $docs[$i]['Nombre']; ?></td>
			            <td style='width: 100px; text-align: center;'><?php if($docs[$i]['Si'] == 1){ echo "<b>X</b>";} ?></td>
			        </tr>
			        <?php } ?>
			    </table>
			</td>
			<td style='width: 40px; color: blue; border: none; background: white;'></td>
			<td style='width: 250px; border: none;'>
			    <table style='margin-left: -7px;'>
			        <tr>
			            <td style='width: 190px;'><b>NOMBRE DEL CONCEPTO</b></td>
			            <td style='width: 40px; text-align: center;'><b>MONTO<br>$</b></td>
			        </tr>
			        <?php  for ($i=0;$i< sizeof($pag);$i++) { ?>
			        <tr>
			            <td style='width: 190px;'><?php echo $pag[$i]['NomPlan']; ?> (<?php echo $pag[$i]['Numero']; ?>)</td>
			            <td style='width: 40px; text-align: center;'>$ <?php echo $pag[$i]['Monto']; ?> </td>
			        </tr>
			        <?php } ?>
			        <tr>
			            <td style='width: 190px;'>SEGURO ANUAL ACCIDENTES (1)</td>
			            <td style='width: 40px; text-align: center;'>$ 300.00 </td>
			        </tr>
			    </table><br>
			    <b style='text-align: center;'>Nota: recuerde realizar los pagos del 1 al 5 de cada mes para evitar recargos.</b>
			</td>
		</tr>
	</table>
	
	<table style='margin-left: 2px;'>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>ENTERADO Y ACEPTO<br><br></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>ENTERADO Y ACEPTO</td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>VTO. BNO.</td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'><?php if($lstUs[0]['IdGrado'] == 4){ echo "TUTOR:"; } else { echo "CONTACTO AUTORIZADO"; } ?><br><br><br><br></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>ALUMNO<br><br><br><br></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>GESTIÓN ESCOLAR<br><br><br><br></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>NOMBRE Y FIRMA</td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>NOMBRE Y FIRMA</td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>NOMBRE Y FIRMA</td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>
			    
			 <?php
            $imagen = $lstUs[0]['id_paquete'] ?? '';
            
            $rutaFisica = realpath($_SERVER['DOCUMENT_ROOT'] . "/assets/firma/" . $imagen);
            
            if (!empty($imagen) && $rutaFisica && file_exists($rutaFisica)) {
            ?>
                <img src="<?php echo $rutaFisica; ?>" style="width: 100%; margin-top: -80px;">
            <?php
            }
            ?>
			    
			    
			    </td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'></td>
		</tr>
		<tr>
			<td colspan="5" style='width: 670px; border: none; text-align: center; height: 50px;'><b>
			    Me compromento a entregar la documentación pendiente dentro de los próximos ______ días habiles, de lo contrario causaré baja.<br>
			    Conozco el reglamento que esta disponible en <?php if($lstUs[0]['IdGrado'] == 4){ echo "www.iupsureste.mx"; } else { echo "www.iudysureste.com"; } ?></b>
			    
			    </td>
		</tr>

	</table>
	
	
	<?php if(($lstUs[0]['Grado'] == 1) || ($lstUs[0]['Grado'] == 2) || ($lstUs[0]['Grado'] == 3)){ ?>
		
	<div style='width: 685px; margin-left: 4px; background: white; '>
	    <p style='text-align: justify; font-size: 8px;'>
	        CONTRATO   DE   PRESTACIÓN   DE    SERVICIOS    EDUCATIVOS    QUE    CELEBRAN    POR    UNA    PARTE    EL    “CENTRO    INTEGRAL    DE    ESTUDIOS    PROFESIONALES    SC”,    REPRESENTADO    POR    EL    MTRO.    AUDIEL    HIPÓLITO DURÁN,  EN  SU  CARÁCTER  DE   REPRESENTANTE   LEGAL,   EN   LO   SUCESIVO   DENOMINADO   “EL   PRESTADOR”.   Y   POR   LA   OTRA   PARTE   <b><?php echo $lstUs[0]['Nombre'].' '.$lstUs[0]['APaterno'].' '.$lstUs[0]['AMaterno']; ?></b>   DENOMINADA   EN   ADELANTE   PARA LOS EFECTOS DE ESTE CONTRATO COMO EL “PRESTATARIO” DE ACUERDO CON LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS.
	    </p>
	    <p style='text-align: justify; font-size: 8px;'>
	        <b>DECLARACIONES</b><br><br>

            I.- Declara EL PRESTADOR de servicios ser una Sociedad Civil constituida conforme a las leyes Mexicanas según consta en Escritura Pública.<br>
            II.-  El  PRESTADOR   declara   que   lleva   a   cabo   su   objeto   social   en   la   ciudad   de   Villahermosa,   en   su   sus   instalaciones   ubicadas   en   Carretera   Federal   Villahermosa-Teapa   Km   1,   Colonia   Plutarco   Elías   Calles,   impartiendo servicios educativos a nivel licenciatura y posgrado en educación profesional.<br>
            III.-Manifiesta   el   PRESTADOR   estar   inscrito   en   el   Registro   Federal   del   Contribuyente   bajo   la   clave   CIE090115D22 para   llevar   a   cabo   el   objeto   social   al   que   se   refiere    en    el    punto    anterior    y    cuyo    registro    e incorporaciones ante las autoridades educativas correspondientes están debidamente complementados con Claves de Incorporación y Reconocimiento de Validez Oficial de Estudios.<br>
            IV.-Declara     el     PRESTATARIO     tener     capacidad     y     estar     de     acuerdo     en     contratar     los     servicios     educativos     que     se     precisan     en     el     siguiente     contrato,     mismos     que     se     prestaran     al     alumno(a)     <b><?php echo $lstUs[0]['Nombre'].' '.$lstUs[0]['APaterno'].' '.$lstUs[0]['AMaterno']; ?></b>   de   <b><?php echo $lstUs[0]['Educativa']; ?></b>   Periodo   <b><?php echo $lstCi[0]['Ciclo']; ?></b>  con   el   personal   docente   que   distingue   y   señale   la    Universidad    en    sus    instalaciones    arriba indicadas en esta ciudad.<br>
            V.-  Asimismo  acepta  que  la  misma,   podrá   hacer   cambios   de   los   catedráticos   que   fueren   necesarios   en   su   caso,   sin   distinción   de   sexo,   igualmente   aceptan   ser   ubicados   o   reubicados   en   distintos   salones   de   clases   o edificios según las necesidades de la Universidad y que al grado de avance o nivel académico del alumno solamente compete definirlo o juzgarlo a la SECRETARÍA DE EDUCACIÓN PÚBLICA.<br>

	    </p>
	    <p style='text-align: justify; font-size: 8px;'>
	        <b>CLÁUSULAS</b><br><br>

PRIMERA.   EL   PRESTADOR   del   servicio   educativo   cobrará   en   “Moneda   Nacional”   los    siguientes    conceptos    que    se    detallan    a    continuación:    INSCRIPCIÓN,    REINSCRIPCIÓN,    REINSCRIPCIÓN    TARDÍA,    EXAMEN    DE UBICACIÓN,    CONSTANCIAS    DE    ESTUDIOS,    EXPEDICIÓN    DE    CERTIFICADOS    PARCIALES    O    TOTALES,    REPOSICIÓN    DE    BOLETAS,    CONSTANCIA    DE    ESTUDIOS    CON    CALIFICACIONES,    CONSTANCIAS     SIMPLES, EXÁMENES   ORDINARIOS   Y   EXTRAORDINARIOS,   TRÁMITES   POR   REVALIDACIÓN   DE   MATERIAS,    SEGUROS    ESTUDIANTILES,    TRAMITACIÓN    DE    TÍTULOS    Y    CÉDULAS    PROFESIONALES    ANTE    LAS    AUTORIDADES RESPECTIVAS,    GASTOS    NOTARIALES    NECESARIOS,    SANCIONES    ECONÓMICAS    CAUSADAS    POR    DAÑOS    AL    PATRIMONIO    UNIVERSITARIO,    YA    SEA    POR    PÉRDIDAS    O     DESTRUCCIÓN     POR     UTILIZACIÓN     DEL SERVICIO   DE   LABORATORIO   DE   CÓMPUTO,   PAGO   DE    SEGURO,    INCORPORACIÓN    ANUAL    A    LA    SECRETARÍA    DE    EDUCACIÓN    PÚBLICA,    CREDENCIALES,    REPOSICIÓN    DE    FICHAS    DE    PAGO    Y    OTRAS    QUE DISPONGA LA SECRETARÍA DE EDUCACIÓN PÚBLICA, Y LA INSTITUCIÓN EDUCATIVA PARA SU BUEN DESEMPEÑO.<br>
SEGUNDA.    Se    cobrarán    6 colegiaturas    mensuales    durante    cada    semestre    o   4 colegiaturas    mensuales    durante    el  cuatrimestre    dependiendo     del    plan    de    estudios    de    la    licenciatura    en  la    que    ingresa    o    se  encuentre cursando,  en  el  caso  de  maestrías  o  doctorados,  deberá  pagar  su  mensualidad  correspondiente  al  módulo  que  cursa,  que  deberá  cubrirse   dentro   de   los  5 primeros   días   naturales   de   cada   mes,   los   pagos   hechos   con posterioridad   a   este   plazo   causan   en   pago   de   recargas   del  20%   mensual   acumulables   mes   con   mes   y   en   caso   de   cheques   sean   devueltos   por   insuficiencia   de   fondos   o   por   alguna   otra   razón,   se   aplicará   lo   dispuesto en el  artículo  193 de  la  Ley  General  de  Títulos  y  Operaciones  de  Crédito,  así  como  las  comisiones  e  impuestos  que  cargue  el  banco  por  dicho  concepto,  en  el  caso  de  que  se  cubra  totalmente  el  concepto  de  colegiatura del    ciclo    escolar    en  una    sola    emisión,  esta    tendrá     un    descuento     del   10%,    siempre    y    cuando    se  realice    con    dos    semanas    de    anticipación  al  semestre    o    cuatrimestre    que    inicia.     La    inscripción  o    reinscripción  es semestral  o  cuatrimestral,  según  sea  el  caso,  dependiendo  del  plan  de  estudios  de   la   Licenciatura   en   la   que   ingresa   o   se   encuentre   cursando   y   cuando   los   pagos   sean   de   forma   anticipada.   EL   PRESTADOR   solamente devolverá    inscripciones,    reinscripciones    o    colegiaturas    cuando    se    le    indique    por    escrito    que    el    alumno    no    participará    en    el    ciclo    escolar    en    curso,    cuando    menos    un    mes    de    anticipación   al    inicio    de    éste;    todo    ello    de conformidad  en  lo  señalado  por  la  fracción  IV,  del  artículo   5 del   acuerdo   del   10 de   marzo   de   1992 sobre   comercialización   de   servicios   educativos.   Cuando   este   aviso   se   dé   con   anticipación   menor   de   la   señalada,   los usuarios   de   servicio   o   tutores,   por   Acuerdo   de   Voluntad   expresado   en   este   acto,   convienen   y   aceptan   que   EL   PRESTADOR,   no   les   devolverá   cantidad   alguna,   renunciando   a   ello   expresamente   por   tal   motivo. Cuando la inscripción del  alumno  se  haga  con  posteridad  y  no  sea  posible  cumplir  con  el  plazo  de  un  mes  de  anticipación  a  que  alude  la  fracción  I,  del  artículo  5 del  acuerdo  de  10 de  marzo  de  1992 ambas  partes  convienen  en este acto lo siguiente.<br>
A).	En   caso   de   cancelación   del   curso   deberá   presentar   por   escrito   en   las   Oficinas   del   Instituto   Universitario   de   Yucatán,   con   una   semana   de   anticipación   al   inicio   del   semestre   o   cuatrimestre   y   se   reintegrará   el  50% de la inscripción.<br>
B).	Si  el  aviso  escrito  se  da  después   de   iniciado   el   curso,   los   tutores   o   usuarios   del   servicio,   están   conformes   y   aceptan   a   la   firma   del   presente   contrato,   que   el   prestador   no   hará   reembolsable   ningún   pago,   y   los grupos    deben    contar,    con    al    menos    10 alumnos    para    su    existencia,    en    caso    contrario    podrá    cancelarse    en    cualquier    momento    del    curso    cuando    no    se    cumpla    con    este    requisito,    sin    responsabilidad    para    la    institucói n, estando conforme el prestatario, sus padres o tutores, deslindando de cualquier responsabilidad a la institución por medio de esta cláusula.<br>
C).	En el caso de  que  el  prestatario  decida  darse  de  baja  deberá  notificar  por  escrito  a  la  Dirección  de  Control  Escolar,  a  fin  de  que  sea  suspendido  el  cargo  de  la  colegiatura  la  cual  deberá  cubrirse  hasta  el  mes  que sea presentada dicha solicitud; en caso de no presentar dicha notificación seguirá vigente el cargo de la colegiatura y la obligación del pago, con los correspondientes recargos del 20%.<br>
TERCERA.   Que   el   PRESTATARIO   acepta   que   el   único   medio   para   poder   pagar   lo   mencionado   en   las   dos   cláusulas   anteriores   será   mediante   la   FICHA   RAP,   misma   que   deberá   imprimir   de   la   página   de   internet    del Instituto:  www.iudysureste.mx.  El    costo     de    los     conceptos     le    será    comunicado     al  inicio     del     semestre     o    cuatrimestre     en  curso,     tales     como     duplicados     de     certificados,     constancias     de     estudios,     credenciales     y    su reposición,    los    servicios    del    laboratorio     de    cómputo,  cursos    complementarios    fuera    de    la    carga    normal    de    materias,    actividades    extracurriculares    fuera    del    horario    normal    de    clases,    que    pudiera    tener    un    costo adicional  de  la  inscripción  y  a  las  colegiaturas  así  mismo   les   será   comunicado   al   inicio   del   semestre   o   cuatrimestre   en   curso   mediante   circulares   específicas   que   se   colocarán   en   lugares   visibles,   una   vez   que   se conozca el costo de tales servicios por Acuerdo de la Dirección General del Instituto, en caso de que se venza la fecha de la ficha RAP, se deberá pagar las reposición de la misma.<br>
CUARTA.  Que  el  PRESTATARIO  está  conforme  en  celebrar  el  presente  contrato  que  está  celebrando  según  el  ACUERDO   SOBRE   LAS   BASES   MÍNIMAS   DE   INFORMACIÓN   PARA   LA   COMERCIALIZACIÓN   DE   LOS SERVICIOS EDUCATIVOS DEL 10 DE MARZO DE 1992, MISMO QUE el prestador CONOCE, LO ACEPTA EN TODAS Y CADA UNA DE SUS PARTES Y SE DA PLENAMENTE ENTERADO DE SUS ALCANCES.<br>
QUINTA. Que EL PRESTATARIO conoce y acepta cumplir el Reglamento Interno del Instituto Universitario de Yucatán, del cual ha recibido un ejemplar obligándose a ello sin excusa.<br>
SEXTA. Que EL PRESTATARIO acepta de abstenerse de intervenir en forma colegiada  o  cualquier  otro  medio  en  los  aspectos  pedagógicos  y  laborales  del  PRESTADOR,  tal  y  como  se  indica  en  el  artículo  67,  fracción  V, párrafos 11 de la LEY GENERAL DE EDUCACIÓN.<br>
SÉPTIMA.  Que   EL   PRESTATARIO   acepta   que   no   exigirá   responsabilidad   alguna   a   EL   PRESTADOR,   por   artículos   propiedad   de   su(s)   hijo(s)   alumno,   extraviado   dentro   de   las   instalaciones   y   edificios   de   la   Universidad, de   conformidad   con   lo   señalado   en   el   REGLAMENTO   INTERNO   DEL   INSTITUTO   UNIVERSITARIO   DE   YUCATÁN,   quedando   estrictamente   prohibidos   la   introducción   y   uso   de   celulares,   iPod,   y   cualquier   aparato   eléctrico   y en caso de pérdida, robo o extravío se libera a EL INSTITUTO UNIVERSITARIO DE YUCATÁN de cualquier responsabilidad.<br>
OCTAVA.    Asimismo    el    Seguro    Estudiantil    es    Obligatorio    y    deberá    ser    cubierto    por    el    PRESTATARIO,    el    PRESTADOR    se    deslinda    de    responsabilidad    por    aquellos    accidentes    fuera    o    dentro    de    la    Institucói n,    en    el    caso que los estudiantes no cuenten con dicho seguro.<br>
NOVENA.  La  Institución  queda  excenta  de  toda  responsabilidad  por  pérdida  o  extravío  de   objetos   pertenecientes   al   PRESTATARIO,   quien   deberá   cuidar   de   ellos,   señalando   que   queda   prohibido   la   introducción   de aparatos electrónicos señalados de manera enunciativa mas no limitativa teléfonos celulares o móviles, iPod o juegos de videos.<br>
DÉCIMA.    Que    EL    PRESTATARIO     acepta    que    el  presente    contrato    de    servicios    educativos,    por    estar    formulado    conforme    a    las    bases    mínimas  del    ACUERDO    DEL    10 DE   MARZO    DEL    1992,    NO    REQUIERE    DE    SU INSCRIPCIÓN ANTE LA PROCURADURÍA FEDERAL DEL CONSUMIDOR.<br>
DÉCIMA  PRIMERA.  El  incumplimiento  de  la  obligación  en  el  pago  de  dos  o  más  colegiaturas  por  parte   de   EL   PRESTATARIO,   libera   al   prestador   del   servicio   a   continuar   el   mismo,   se   le   suspenderá   de   manera automática  de   todos   los   derechos   escolares,   sin   ser   obligación   dar   aviso   por   escrito,   se   enviará   un   oficio   a   quienes   se   les   interrumpa   la   prestación   de   dicho   servicio   a   fin   de   que   sean   cubiertos   los   adeudos íntegramente.  Asimismo  no  tendrá  derecho  a  presentar  exámenes  ordinarios,  ni   extraordinarios,   sino   hasta   que   esté   saldado   el   adeudo,   aquellos   alumnos   que   no   estén   al   corriente   de   sus   obligaciones   financieras, adeudo  en  la   documentación   o   adeudo   de   los   libros   o   material   didácticos,   del   mismo   modo   EL   PRESTATARIO   renuncia   a   la   solicitud   por   cualquier   vía   de   su   documentación   si   tiene   adeudos,   por   lo   cual   no   se   le expedirá certificado total o parcia, si la bajan fuera por esta razón.<br>
DÉCIMA   SEGUNDA.   En   el   caso   de   Reinscripciones,   esta   no   tendrá   validez   si   existieran   adeudos   de   una   o   más   colegiaturas   del   semestre   o   cuatrimestre   anterior,   quedando   la   Institución   liberada   de   sus   obligaciones,   y el alumno a la firma del presente da por enterado, que será dado de baja por esta situación sin responsabilidad para la Institución.<br>
DÉCIMA  TERCERA.  La  firma  y  aceptación  del   presente   contrato   obliga   al   usuario   a   designar   a:   (Nombre   del   Padre   o   Tutor o contacto autorizado):  <?php echo $infox[0]['ENombre']; ?>   para   que   reciba   la   documentación   del   estudiante,   la Universidad no estará obligada a entregar dicha documentación a otras personas distintas que no fueran las autorizadas en el presente contrato.<br>
DÉCIMA  CUARTA.  Que  EL  PRESTATARIO  está  enterado  que  al  solicitar  la  devolución  de  documentos  al  darse  de  baja   la   Institución   no   adquirirá   ninguna   obligatoriedad,   ni   responsabilidad   para   la   tramitación   de Certificados     Totales     o     Parciales,     ya     que     la     inexistencia     en     los     archivos     del     Departamento     Escolar     imposibilita     a     su     tramitacói n     ante     la     Secretaría     de     Educación     Pública.     Las     partes     firman     de     conformidad     el     presente, contrato en la ciudad de CENTRO, TABASCO a los <b><?php echo fecha_impre(date("Y-m-d")); ?>.</b><br>

	    </p>
	    <p style='text-align: justify; font-size: 8px;'>
	        

<b>Aviso de Protección de Datos Personales</b><br><br>

Únicamente  se  hará  uso  de  los  datos  personales  del  alumnado  para  fines  internos  y  de  gestión  ante  las  autoridades,  para  poder  tramitar  toda  documentación  oficial,  no  se proporcionará de ninguna manera a empresas de publicidad, bancos o cualquier otra persona física  o  moral  que  los  requiera;  así  mismo  podrán  proporcionarse  a  las  autoridades administrativas  y  judiciales  facultadas  para  solicitarlos  previo  oficio  o  acuerdo  judicial,  firmándose  para  ello  un  aviso  de  privacidad  adjunto  al  presente  documento  apegado  a  lo dispuesto en los artículos 8, 15, 16 y 26 de la ley de protección de datos personales.
<br>
<br><br>
<table style='font-size: 8px; text-align: center;'>
    <tr>
        <td style='width: 210px; border: none;'>EL PRESTADOR DEL SERVICIO EDUCATIVO<br><br>CENTRO INTEGRAL DE ESTUDIOS PROFESIONALES S.C.</td>
        <td style='width: 210px; border: none;'><?php if($lstUs[0]['IdGrado'] == 4){ echo "EL PRESTATARIO<br><br>NOMBRE Y FIRMA DEL TUTOR"; } ?></td>
        <td style='width: 210px; border: none;' >EL PRESTATARIO<br><br>NOMBRE Y FIRMA DEL TUTOR</td>
    </tr>
</table>
<br>
<b>Aviso de Protección de Datos Personales</b><br><br>

En calidad de alumno me doy por enterado de haber leído, entendido y comprendido el valor y fuerzas legales del contenido del aviso de privacidad, por lo que firmo y ratifico mi dicho.
<br><br>
<table style='font-size: 8px; text-align: center;'>
    <tr>
        <td style='width: 210px; border: none;'>EL PRESTADOR DEL SERVICIO EDUCATIVO<br><br>CENTRO INTEGRAL DE ESTUDIOS PROFESIONALES S.C.</td>
        <td style='width: 210px; border: none;'><?php if($lstUs[0]['IdGrado'] == 4){ echo "EL PRESTATARIO<br><br>NOMBRE Y FIRMA DEL TUTOR"; } ?></td>
        <td style='width: 210px; border: none;' >EL PRESTATARIO<br><br>NOMBRE Y FIRMA DEL TUTOR</td>
    </tr>
</table>
	    </p>
	    
	</div>
	<div style='width: 685px; margin-left: 4px; background: white; '>
	    <p style='text-align: center; font-size: 10px;'>
	        <b>AVISO PRIVACIDAD</b>
	    </p>
	    <p style='text-align: justify; font-size: 10px;'>
	        De   acuerdo   a   lo   dispuesto   por   la   Ley   Federal   de   Protección   de   Datos   Personales,   se   extiende   el   presente    aviso    de    protección    de    datos    personales, mismos que se solicitan para cubrir   con   la   normatividad   educativa,   e   interna   de   la   institución,   se   usará   solo   para   la   base   de   datos   de   la   institución,   para hacer listas de asistencias,   listas   de   calificaciones,   informar   a   los   padres   de   familia   o   tutores   de   las   situaciones   que   se   susciten   dentro   de   la   institución, así como el rendimiento escolar de sus hijos, también esos datos se usarán para el   seguimiento   de   egresados,   y   el   mismo   será   de   uso   interno,   el   o   la responsable del uso   de   los   datos   personales   es   el   o   la   encargada   de   Administración   Escolar   de   la   institución   así   como   las   personas   que   trabajan   dentro de dicho departamento.<br><br>

María Anaid Natalia López Martínez<br>
Carretera  Federal     Villahermosa-Teapa     Km.1.    Colonia  Plutarco Elías Calles 1 39 90 42<br>
anaid_lopez@iudysureste.com<br><br>

De  los   datos    personales    del    alumnado  únicamente    se    hará    uso    de    él    para    fines    internos    y    de    gestión    ante  autoridades,  para    poder    tramitar    toda    la documentación oficial, no se proporcionará de ninguna manera a empresas de publicidad, bancos o cualquier otra persona física o moral que los requiera.<br>

Los datos personales podrán proporcionarse a las autoridades facultadas para solicitarlos previo oficio, o acuerdo judicial.<br>

El titular de los datos   personales   tiene   en   todo   tiempo   el   derecho   de   acceder   a   los   datos   personales   que   se   poseen   y   preguntar   por   el   tratamiento   que   se les da, también podrá ratificarlos en caso de ser inexactos o   instruirnos   para   cancelarlos,   todo   ello   restringido   por   la   normatividad   educativa,   y   a   la gestión   para   emitir   documentación   oficial,   y   en   caso   de   querer   retirar   documentación   se   llenará   un    formato    previa    entrega    de    los    documentos    o información, y se estará en el entendido que no se podrá realizar ningún trámite en tanto en cuanto la institución no tenga los documentos.<br>

Cuando  el    titular    desee    saber  si    sus  datos    ya    fueron    proporcionados    a    la    Secretaría    de    Educación    Pública    podrá    informarse    en    el    departamento    de administración escolar.<br>

El titular de los datos a la firma de conocimiento del presente aviso está totalmente de acuerdo en que se proporcionen sus datos a las instancias gubernamentales, para toda la gestión educativa.<br>

En    caso  de    no    consentir  que    sus  datos    sean  proporcionados     lo    señalará,    pero    queda     en    el    entendido  que     no    se    le    podrá     realizar  la    gestión correspondiente ante las dependencias gubernamentales en materia de educación.<br>

La institución se reserva el derecho de efectuar en cualquier momento modificaciones o actualizaciones al presente aviso de privacidad,   en   atención   a   las modificaciones a la   ley   o   a   la   jurisprudencia,   políticas   internas,   nuevos   requisitos   para   la   prestación   u   ofrecimiento   de   nuestros   servicios   o   productos, de   acuerdo   a   las   prácticas   del   mercado;   como   ejemplo   sería   a   los   3°   de   preescolar   ofrecerles   los   servicios   de   primaria,   a   los   de   6°   de   primaria   los servicios   de   secundaria,   a   los   3°   de   secundaria   ofrecerles   los   servicios   de    bachillerato    o    preparatoria,    a    los    de    6°    de    bachillerato    o    preparatoria ofrecerles los servicios de licenciatura, a   los   egresados   de   licenciatura   ofrecerles   los   servicios   de   maestrías   y   a   los   egresados   de   maestría   ofrecerles   los servicios de doctorado, estando totalmente de acuerdo el titular de la información en ello.<br><br>

Lo anterior apegado a lo dispuesto por la Ley de Protección de Datos Personales en sus:<br><br>

Artículo 8.- Todo tratamiento de datos personales estará sujeto al   consentimiento   de   su   titular,   salvo   las   excepciones   previstas   por   la   presente   Ley.   El consentimiento   será   expreso   cuando   la   voluntad   se   manifieste   verbalmente,   por   escrito,   por   medios   electrónicos,   ópticos   o   por   cualquier   otra   tecnología, o por signos inequívocos.<br>
Se entenderá que   el   titular   consiente   tácitamente   el   tratamiento   de   sus   datos,   cuando   habiéndose   puesto   a   su   disposición   el   aviso   de   privacidad, no manifieste   oposición.   Los   datos   financieros   o   patrimoniales   requerirán   el   consentimiento   expreso   de   su   titular,   salvo   las   excepciones   a   que   se refieren los artículos 10 y 37 de la presente Ley.<br><br>

El    consentimiento    podrá    ser    revocado    en    cualquier    momento    sin    que    se    le    atribuya  efectos  retroactivos.  Para    renovar  el    consentimiento,  el    responsable deberá, en el aviso de privacidad, establecer los mecanismos y procedimientos para ello.<br>
Artículo 15.- El responsable tendrá la obligación de informar a los titulares de los datos, la información que se recaba de ellos y con qué fines, a través del aviso de privacidad. Artículo 16.- El aviso de privacidad deberá contener, al menos, la siguiente información:<br>
I.	La identidad y domicilio del responsable que los recaba;<br>
II.	Las finalidades del tratamiento de datos;<br>
III.	Las opciones y medios que el responsable ofrezca a los titulares para limitar el uso o divulgación de los datos;<br>
IV.	Los medios para ejercer los derechos de acceso, rectificación, cancelación u oposición, de conformidad con lo dispuesto en esta Ley;<br>
V.	En caso, las transferencias de datos que se efectúen, y<br>
VI.	El procedimiento y medio por el   cual   el   responsable   comunicará   a   los   titulares   de   cambios   al   aviso   de   privacidad,   de   conformidad   con   lo   previsto   en   esta Ley.<br>
En el caso de datos personales   sensibles,   el   aviso   de   privacidad   deberá   señalar   expresamente   que   se   trata   de este tipo de datos. Artículo 26.- El responsable no estará obligado a cancelar los datos personales cuando:<br>
I.	Se refiera a las partes de un contrato privado, social o administrativo y sean necesarios para su desarrollo y cumplimiento;<br>
II.	Deban ser tratados por disposición legal;<br>
III.	Obstaculice    actuaciones  judiciales    o    administrativas  vinculadas  a    obligaciones    fiscales,    la    investigación    y    persecución    de    delitos    o    la    actualización  de sanciones administrativas;<br>
IV.	Sean necesarios para proteger los intereses jurídicamente tutelados del titular;<br>
V.	Sean necesarios para realizar una acción en función del interés público;<br>
VI.	Sean necesarios para cumplir con una obligación legalmente adquirida por el titular, y<br>
VII.	Sean objetos de tratamiento para la prevención o para el diagnóstico   médico   o   la   gestión   de   servicios   de   salud,   siempre   que   dicho   tratamiento   se realice por un profesional de la salud sujeto a un deber de secreto.<br><br>

En   el   caso   de   los   menores   de   edad   el   titular   de   loso   datos   no   los   proporcionará,   si   no   el   padre   de   familia,   pero   con   ello   se   entiende    que    son proporcionados en su nombre y representación por no tener capacidad de ejercicio para poderlos proveer por sí mismo.<br><br>

El presente aviso se hará del conocimiento del titular al momento de la primera inscripción que es al mismo tiempo en que se toman sus datos.<br><br>

EN MI CALIDAD DE TITULAR DE LOS DATOS PERSONALES BAJO PROTESTA DE DECIR LA VERDAD SEÑALO QUE LEÍ EL PRESENTE DOCUMENTO Y SE ME FUE EXPLICADO EL VALOR Y FUERZA LEGAL DEL MISMO, POR LO CUAL AL   FIRMAR   RATIFICO   EL   CONTENIDO   DEL   MISMO   Y   AUTORIZO   EL   USO   DE   MIS DATOS PERSONALES PARA LA GESTIÓN EDUCATIVA Y USO INTERNOS DE LA INSTITUCIÓN.<br><br><br>

	    </p>
	    <br><br><br>
<p style='text-align: center'>___________________________________________________<br><b>NOMBRE Y FIRMA DEL ALUMNO</b></p>
<p style='text-align: center'>
    <?php if($lstUs[0]['id_paquete']){ ?><img src="../../assets/firma/<?php echo $lstUs[0]['id_paquete']; ?>" style="width: 200px; margin-top: -100px;"> <?php } ?>
    
</p>


	 </div>
	 <?php } ?>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
