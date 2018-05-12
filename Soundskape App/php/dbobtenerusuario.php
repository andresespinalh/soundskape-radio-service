<?php 
include('dbconexion.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=ISO-8859-1");


$conexion = conectar();
$data = json_decode(file_get_contents("php://input"));


//Recibimos datos del inicio de sesion
$id_usuario = utf8_decode($data->id_usuario);

$result = $conexion->query( "call infoPerson('$id_usuario')");

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	$alias=$rs['alias']; 	//Obtencion de los datos del usuario
	$fecha_ingreso=$rs['fecha_ingreso'];
	$primer_nombre=$rs['primer_nombre']; 	
	$segundo_nombre=$rs['segundo_nombre'];
	$primer_apellido=$rs['primer_apellido']; 	
	$segundo_apellido=$rs['segundo_apellido'];
	$correo_electronico=$rs['correo_electronico']; 	
	$fecha_nacimiento=$rs['fecha_nacimiento'];
	$ciudad=$rs['ciudad']; 	
	$pais=$rs['pais'];
}


 $outp="";
 $outp .= '{"alias":"'  . $alias        . '",';
 $outp .= '"fecha_ingreso":"'   . $fecha_ingreso        . '",';
 $outp .= '"primer_nombre":"'   . $primer_nombre        . '",';
 $outp .= '"segundo_nombre":"'   . $segundo_nombre        . '",';
 $outp .= '"primer_apellido":"'   . $primer_apellido        . '",';
 $outp .= '"segundo_apellido":"'   . $segundo_apellido        . '",';
 $outp .= '"correo_electronico":"'   . $correo_electronico        . '",';
 $outp .= '"fecha_nacimiento":"'   . $fecha_nacimiento        . '",';
 $outp .= '"ciudad":"'   . $ciudad        . '",';
 $outp .= '"pais":"'   . $pais        . '"}';

 $outp ='{"records":['.$outp.']}';
 echo $outp;




?>
