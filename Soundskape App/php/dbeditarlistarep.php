<?php 
include('dbconexion.php'); 
$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario

$id_lista_reproduccion = $data->id_lista_reproduccion;
$nombre = utf8_decode($data->nombre);
$tipo = utf8_decode($data->tipo);



$sql=$conexion->query("SELECT id_tipo_lista_reproduccion FROM tipo_lista_reproduccion WHERE tipo_lista_reproduccion='$tipo'");

$row = mysqli_fetch_array($sql)  or die(mysqli_error($conexion));
$idtipo=$row[0];


$conexion->query("UPDATE lista_reproduccion SET nombre='$nombre', id_tipo_lista_reproduccion='$idtipo' WHERE id_lista_reproduccion='$id_lista_reproduccion'");





$conexion->Close();//Cierre de la conexion

?>