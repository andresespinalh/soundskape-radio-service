<?php 
include('dbconexion.php'); 
$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario

$id_lista_reproduccion = $data->id_lista_reproduccion;



$conexion->query("DELETE FROM cancion_por_lista_reproduccion WHERE id_lista_reproduccion = '$id_lista_reproduccion'") or die(mysqli_error($conexion));

$conexion->query("DELETE FROM lista_reproduccion WHERE id_lista_reproduccion = '$id_lista_reproduccion'") or die(mysqli_error($conexion));





$conexion->Close();//Cierre de la conexion

?>