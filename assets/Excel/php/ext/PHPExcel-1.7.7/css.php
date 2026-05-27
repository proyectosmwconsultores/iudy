<?php
include("../../../../../class/class.php");
class Trabajot 
{
    public function add_($id,$fec,$TxtJusti){
        $MesAnio= substr($fec, 0, 7);
        $dia= substr($fec, 8, 10);
        ECHO $sql1="SELECT Fecha$dia, Retardo1, Retardo2, Retardo3, EstEnt$dia, EstSal$dia, Falta1, Falta2 FROM tblp_asistencia WHERE Fecha$dia ='$fec' AND NoEmp='$id' AND MesAnio='$MesAnio'"; 

        $res1=mysql_query($sql1, Conectar::con());
        $reg1=mysql_fetch_array($res1);
        if($dia<=15){
            $retarrT="Retardo1";
            $faltaaT="Falta1";
        }else{
            $retarrT="Retardo2";
            $faltaaT="Falta2";
        }
               if($TxtJusti=="1"){
                   $faltaa1=$reg1["$faltaaT"]-1; 
                    if($faltaa1 < 0){ $faltaa1=0;}
                    $Esta="EstEnt$dia='A', HraEnt$dia='09:13',HraSal$dia='17:08', EstSal$dia='A', $faltaaT='$faltaa1' "; 
                }elseif($TxtJusti=="2"){
                    $faltaa1=$reg1["$faltaaT"]-1; if($faltaa1 < 0){ $faltaa1=0;}
                    $Esta="EstEnt$dia='A',HraEnt$dia='09:13', $faltaaT='$faltaa1' "; 
                }elseif($TxtJusti=="3"){
                    $faltaa1=$reg1["$faltaaT"]-1; if($faltaa1 < 0){ $faltaa1=0;}
                    $Esta="EstSal$dia='A',HraSal$dia='17:09',$faltaaT='$faltaa1' "; 
                }elseif($TxtJusti=="4"){
                    $faltaa1=$reg1["$retarrT"]-1; if($faltaa1 < 0){ $faltaa1=0;}
                    $Esta="EstEnt$dia='A',HraEnt$dia='09:13', $retarrT='$faltaa1' "; 
                }elseif($TxtJusti=="5"){
                    $faltaa1=$reg1["$retarrT"]-1; if($faltaa1 < 0){ $faltaa1=0;}
                    $Esta="EstSal$dia='A',HraSal$dia='17:09', $retarrT='$faltaa1' "; 
                }
        $sql2="UPDATE tblp_asistencia SET $Esta WHERE Fecha$dia ='$fec' AND NoEmp='$id' AND MesAnio='$MesAnio'";
            $res2=mysql_query($sql2, Conectar::con());
             echo "
        <script type='text/javascript'>
        alert('CORRECTAMENTE');
        window.location='frmPermisos.php';</script>";
    }
}
?>