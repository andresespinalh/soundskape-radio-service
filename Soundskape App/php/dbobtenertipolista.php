<?php
include('dbconexion.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=ISO-8859-1");

$conexion = conectar();
$data = json_decode(file_get_contents("php://input"));






$result = $conexion->query("SELECT * FROM tipo_lista_reproduccion"); 


$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {//Recibe con los resultados de la consulta todos los nombres de ciudades 
	if ($outp != "") {$outp .= ",";}
   	$tipo_lista_reproduccion=$rs['tipo_lista_reproduccion'];
   	 $outp .= '{"tipo_lista_reproduccion":"'   . $tipo_lista_reproduccion        . '"}';

	
}
$outp ='{"records":['.$outp.']}'; //Guarda en formato json para el envio al formulario 	
 


$conexion->close();

echo $outp;
?>