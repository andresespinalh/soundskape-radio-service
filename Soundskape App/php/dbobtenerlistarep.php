<?php
include('dbconexion.php');
header("Content-Type: text/html; charset=ISO-8859-1");
$conexion = conectar();
$data = json_decode(file_get_contents("php://input"));



$id_usuario = $data->id_usuario;


$result = $conexion->query("SELECT id_lista_reproduccion , nombre ,b.tipo_lista_reproduccion as 'tipo' FROM lista_reproduccion a, tipo_lista_reproduccion b WHERE (a.id_usuario='$id_usuario') AND (a.id_tipo_lista_reproduccion=b.id_tipo_lista_reproduccion)"); 


$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {//Recibe con los resultados de la consulta todos los nombres de las listas
	if ($outp != "") {$outp .= ",";}
   	$id_lista_reproduccion=$rs['id_lista_reproduccion'];
	$nombre=$rs['nombre']; 	
	$tipo=$rs['tipo'];
	$outp .= '{"id_lista_reproduccion":"'  . $id_lista_reproduccion        . '",';
	$outp .= '"nombre":"'   . $nombre        . '",';
	$outp .= '"tipo":"'   . $tipo        . '"}';
}


$outp ='{"records":['.$outp.']}'; //Guarda en formato json para el envio al formulario

$conexion->close();

echo $outp;
?>