<?php 
include('dbconexion.php'); 
$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario

$id_cancion = $data->id_cancion;



$conexion->query("DELETE FROM cancion_por_lista_reproduccion WHERE id_cancion = '$id_cancion'") or die(mysqli_error($conexion));





$conexion->Close();//Cierre de la conexion

?>